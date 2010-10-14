<?php
/**
 * WURFL API
 *
 * LICENSE
 *
 * This file is released under the GNU General Public License. Refer to the
 * COPYING file distributed with this package.
 *
 * Copyright (c) 2008-2009, WURFL-Pro S.r.l., Rome, Italy
 *
 *
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 * 
 */
class WURFL_DeviceRepositoryBuilder {
	
	private $persistenceProvider;
	private $userAgentHandlerChain;
	private $devicePatcher;
	
	private $handlersUserAgentsMap;
	
	public function __construct($persistenceProvider, $userAgentHandlerChain, $devicePatcher) {
		$this->persistenceProvider = $persistenceProvider;
		$this->userAgentHandlerChain = $userAgentHandlerChain;
		$this->devicePatcher = $devicePatcher;
	}
	
	/**
	 * 
	 * @param iterator $deviceIterator
	 * @param array $patchDeviceIterators
	 */
	public function build($wurflInfoIterator, $deviceIterator, $patchDeviceIterators = NULL) {
		if (! $this->isRepositoryBuilt ()) {
			$this->buildRepository ( $wurflInfoIterator, $deviceIterator, $patchDeviceIterators );
			$this->setRepositoryBuilt ();
		}
		
		$deviceClassificationNames = $this->deviceClassificationNames();
		return new WURFL_CustomDeviceRepository ( $this->persistenceProvider, $deviceClassificationNames );
	}
	
	private function isRepositoryBuilt() {
		return $this->persistenceProvider->isWURFLLoaded ();
	}
	
	private function setRepositoryBuilt() {
		$this->persistenceProvider->setWURFLLoaded ();
	}
	
	private function deviceClassificationNames() {
		$deviceClusers = array();
		foreach ($this->userAgentHandlerChain->getHandlers() as $userAgentHandler) {
			$deviceClusers[] = $userAgentHandler->getPrefix();
		}
		return $deviceClusers;
	}
	
	private function buildRepository($wurflInfoIterator, $deviceIterator, $patchDeviceIterators = NULL) {
		$this->persistWurflInfo ( $wurflInfoIterator );
		$patchingDevices = array ();
		if (! is_null ( $patchDeviceIterators )) {
			$patchingDevices = $this->toListOfPatchingDevices ( $patchDeviceIterators );
		}
		try {
			$this->process ( $deviceIterator, $patchingDevices );
		} catch ( Exception $exception ) {
			$this->clean ();
			throw new Exception ( "Problem Building WURFL Repository " . $exception );
		}
	}
	
	private function clean() {
		$this->persistenceProvider->clear ();
	}
	
	private function persistWurflInfo($wurflInfoIterator) {
		foreach ( $wurflInfoIterator as $info ) {
			$this->persistenceProvider->save ( WURFL_Xml_Info::PERSISTENCE_KEY, $info );
		}
	}
	
	private function process($deviceIterator, $patchingDevices) {
		$this->userAgentsMap = array ();
		$usedPatchingDeviceIds = array ();
		foreach ( $deviceIterator as $device ) {
			$toPatch = isset ( $patchingDevices [$device->id] );
			if ($toPatch) {
				$device = $this->patchDevice ( $device, $patchingDevices [$device->id] );
				$usedPatchingDevicesIds [] = $device->id;
			}
			$this->classifyAndPersistDevice ( $device );
		}
		$this->classifyAndPersistNewDevices ( array_diff_key ( $patchingDevices, $usedPatchingDeviceIds ) );
		$this->persistClassifiedDevicesUserAgentMap ();
	}
	
	private function classifyAndPersistNewDevices($newDevices) {
		foreach ( $newDevices as $newDevice ) {
			$this->classifyAndPersistDevice ( $newDevice );
		}
	}
	
	/**
	 * 
	 * @param WURFL_Xml_ModelDevice $device
	 * @param array $patchingDevices
	 */
	private function processDevice($device, $patchingDevices) {
		$this->classifyAndPersistDevice ( $device );
	}
	
	private function classifyAndPersistDevice($device) {
		$this->userAgentHandlerChain->filter ( $device->userAgent, $device->id );
		$this->persistenceProvider->save ( $device->id, $device );
	}
	
	private function persistClassifiedDevicesUserAgentMap() {
		$this->userAgentHandlerChain->persistData ();
	}
	
	private function patchDevice($device, $patchingDevice) {
		return $this->devicePatcher->patch ( $device, $patchingDevice );
	}
	
	private function saveDevice($device) {
		$this->persistenceProvider->save ( $device->id, $device );
	}
	
	private function toListOfPatchingDevices($patchingDeviceIterators) {
		$currentPatchingDevices = array ();
		foreach ( $patchingDeviceIterators as $deviceIterator ) {
			$newPatchingDevices = $this->toArray ( $deviceIterator );
			$this->patchDevices ( $currentPatchingDevices, $newPatchingDevices );
		}
		return $currentPatchingDevices;
	}
	
	private function patchDevices(&$currentPatchingDevices, $newPatchingDevices) {
		foreach ( $newPatchingDevices as $deviceId => $newPatchingDevice ) {
			if (isset ( $currentPatchingDevices [$deviceId] )) {
				$currentPatchingDevices [$deviceId] = $this->patchDevice ( $currentPatchingDevices [$deviceId], $newPatchingDevice );
			} else {
				$currentPatchingDevices [$deviceId] = $newPatchingDevice;
			}
		}
	}
	
	private function toArray($deviceIterator) {
		$patchingDevices = array ();
		foreach ( $deviceIterator as $device ) {
			$patchingDevices [$device->id] = $device;
		}
		return $patchingDevices;
	}
	
	private function toMap($patchingDeviceIterators) {
		$patchingDevices = array ();
		foreach ( $patchingDeviceIterators as $deviceIterator ) {
			foreach ( $deviceIterator as $deviceId => $device ) {
				$patchingDevices [$deviceId] = $device;
			}
		}
		return $patchingDevices;
	}

}
?>