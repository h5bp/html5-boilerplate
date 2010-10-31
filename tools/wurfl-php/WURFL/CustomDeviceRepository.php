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
class WURFL_CustomDeviceRepository extends WURFL_DeviceRepository {
	
	const WURFL_USER_AGENTS_CLASSIFIED = "WURFL_USER_AGENTS_CLASSIFIED";
	
	private $persistenceProvider;
	private $deviceClassificationNames;
	
	private $_groupIDCapabilitiesMap;
	private $_userAgentsWithDeviceIDMap;
	private $_devicesId;
	private $_capabilitiesName;
	
	private $_deviceCache = array ();
	
	public function __construct($persistenceProvider, $deviceClassificationNames) {
		if (is_null ( $persistenceProvider )) {
			throw new InvalidArgumentException ( "$persistenceProvider cannt be null" );
		}
		$this->persistenceProvider = $persistenceProvider;
		$this->deviceClassificationNames = $deviceClassificationNames;
		$this->init ();
	}
	
	private function init() {
		$genericDevice = $this->getDevice ( "generic" );
		$this->_capabilitiesName = array_keys ( $genericDevice->capabilities );
		$this->_groupIDCapabilitiesMap = $genericDevice->groupIdCapabilitiesNameMap;
	}
	
	public function getWURFLInfo() {
		return $this->persistenceProvider->load ( WURFL_Xml_Info::PERSISTENCE_KEY );
	}
	
	/**
	 * Returns a device for the given device ID
	 *
	 * @param string $deviceId
	 * @return WURFL_Device
	 * @throws WURFL_Exception if $deviceID is not defined in wurfl
	 * devices repository
	 */
	public function getDevice($deviceId) {
		if (! isset ( $this->_deviceCache [$deviceId] )) {
			$this->_deviceCache [$deviceId] = $this->persistenceProvider->load ( $deviceId );
		}
		
		return $this->_deviceCache [$deviceId];
	}
	
	/**
	 * Returns an array of all the devices id
	 *
	 * @return array
	 */
	public function getAllDevicesID() {
		$devicesId = array();
		foreach ($this->deviceClassificationNames as $className) {
			$currentMap = $this->persistenceProvider->load($className);
			if(!is_array($currentMap)) {
				$currentMap = array();	
			}
			$devicesId = array_merge($devicesId, array_values($currentMap));
		}
		return $devicesId;
	}
	
	/**
	 * Returns the Capability value for the given device id
	 * and capablility name
	 *
	 * @param string $deviceID
	 * @param string $capabilityName
	 * @return string
	 */
	public function getCapabilityForDevice($deviceId, $capabilityName) {
		if (! $this->isCapabilityDefined ( $capabilityName )) {
			throw new WURFL_WURFLException ( "capability name: " . $capabilityName . " not found" );
		}
		
		while ( strcmp ( $deviceId, "root" ) ) {
			$device = $this->persistenceProvider->load ( $deviceId );
			if (! $device) {
				throw new WURFL_WURFLException ( "the device with $deviceId is not found." );
			}
			if (isset ( $device->capabilities [$capabilityName] )) {
				$capabilityValue = $device->capabilities [$capabilityName];
				break;
			}
			$deviceId = $device->fallBack;
		}
		
		return $capabilityValue;
	
	}
	
	/**
	 * Checks if the capability name specified by $capability
	 * is defined in the repository
	 *
	 * @param string $capability
	 * @return boolean
	 */
	private function isCapabilityDefined($capability) {
		return in_array ( $capability, $this->_capabilitiesName );
	}
	
	/**
	 * Returns an associative array of capabilityName => capabilityValue 
	 * for the given device 
	 * 
	 *
	 * @param string $deviceID
	 * @return array associative array of capabilityName, capabilityValue
	 */
	function getAllCapabilitiesForDevice($deviceID) {
		$devices = array_reverse ( $this->getDeviceHierarchy ( $deviceID ) );
		$capabilities = array ();
		
		foreach ( $devices as $device ) {
			if (is_array ( $device->capabilities )) {
				$capabilities = array_merge ( $capabilities, $device->capabilities );
			}
		}
		
		return $capabilities;
	
	}
	
	/**
	 * Returns an array containing all devices from the root
	 * device to the device of the given id
	 *
	 * @param string $deviceID
	 * @return array
	 */
	public function getDeviceHierarchy($deviceID) {
		$devices = array ();
		while ( strcmp ( $deviceID, "root" ) ) {
			$device = $this->getDevice ( $deviceID );
			
			if (is_null ( $device )) {
				break;
			}
			$devices [] = $device;
			$deviceID = $device->fallBack;
		}
		return $devices;
	}
	
	/**
	 * Returns an array Of group IDs defined in wurfl
	 *
	 * @return array
	 */
	public function getListOfGroups() {
		return array_keys ( $this->_groupIDCapabilitiesMap );
	}
	
	/**
	 * Returns an array of all capability names defined in
	 * the given group ID
	 *
	 * @param string $groupID
	 * @return array of capability names
	 */
	public function getCapabilitiesNameForGroup($groupID) {
		if (! array_key_exists ( $groupID, $this->_groupIDCapabilitiesMap )) {
			throw new WURFL_WURFLException ( "The Group ID " . $groupID . " supplied does not exist" );
		}
		return $this->_groupIDCapabilitiesMap [$groupID];
	}
	
	/**
	 * Returns the group id in which the given capabiliy name
	 * belongs to
	 *
	 * @param string $capabilitity
	 * @return string
	 */
	public function getGroupIDForCapability($capability) {
		if (! isset ( $capability )) {
			throw new WURFL_WURFLException ( "capability value is not set." );
		}
		
		return $this->_capabilityByGroupMap [$capability];
	}
}