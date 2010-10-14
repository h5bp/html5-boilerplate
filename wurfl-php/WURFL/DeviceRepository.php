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
class WURFL_DeviceRepository {
	
	const WURFL_USER_AGENTS_CLASSIFIED = "WURFL_USER_AGENTS_CLASSIFIED";
	
	private $_persistenceProvider;
	
	private $_userAgentHandlerChain;
	private $_xmlResourceManager;
	
	private $_groupIDCapabilitiesMap;
	private $_userAgentsWithDeviceIDMap;
	private $_devicesId;
	private $_capabilitiesName;

	private $_deviceCache = array();
	
	function __construct(WURFL_Xml_XMLResourceManager $xmlResourceManager, WURFL_UserAgentHandlerChain $userAgentHandlerChain, WURFL_Xml_PersistenceProvider $persistenceProvider) {
		$this->_xmlResourceManager = $xmlResourceManager;
		$this->_persistenceProvider = $persistenceProvider;
		$this->_userAgentHandlerChain = $userAgentHandlerChain;
		$this->init ();
	}
	
	/**
	 * Returns a device for the given device ID
	 *
	 * @param string $deviceID
	 * @return WURFL_Device
	 * @throws WURFL_Exception if $deviceID is not defined in wurfl
	 * 		   devices repository
	 */
	public function getDevice($deviceID) {
		if (!isset($this->_deviceCache[$deviceID])) {
			if (! $this->isDeviceDefined ( $deviceID )) {
				throw new WURFL_WURFLException ( "Device with device id " . $deviceID . " is not defined." );
			}
		
			$this->_deviceCache[$deviceID] = $this->_persistenceProvider->load ( $deviceID );
		}

		return $this->_deviceCache[$deviceID];
	}
	
	/**
	 * Returns an array of all the devices id
	 *
	 * @return array
	 */
	public function getAllDevicesID() {
		return array_values ( $this->_xmlResourceManager->getUserAgentsWithDeviceID () );
	}
	
	/**
	 * Returns the Capability value for the given device id
	 * and capablility name
	 *
	 * @param string $deviceID
	 * @param string $capabilityName
	 * @return string
	 */
	public function getCapabilityForDevice($deviceID, $capabilityName) {
		if (! $this->isCapabilityDefined ( $capabilityName )) {
			throw new WURFL_WURFLException ( "capability name: " . $capabilityName . " not found" );
		}
		
		while ( strcmp ( $deviceID, "root" ) ) {
			$device = $this->_persistenceProvider->load ( $deviceID );
			if(!$device) {
				throw new WURFL_WURFLException("the device with $deviceID is not found.");
			}
			if (isset ( $device->capabilities [$capabilityName] )) {
				$capabilityValue = $device->capabilities [$capabilityName];
				break;
			}
			$deviceID = $device->fallBack;
		}
		
		return $capabilityValue;
	
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
	
	public function getUserAgentDeviceIdMap($handlerName) {
		
	}
	
	
	// ***************** private ****************************
	//
	private function init() {
		
		$this->_userAgentsWithDeviceIDMap = $this->_xmlResourceManager->getUserAgentsWithDeviceID ();
		
		$genericDevice = $this->getDevice(WURFL_Constants::GENERIC);
		$this->_capabilitiesName = array_keys($genericDevice->capabilities);
		$this->_groupIDCapabilitiesMap = $genericDevice->groupIdCapabilitiesNameMap;
		
		$this->classifyUserAgents ();
		
	
	}
	
	private function classifyUserAgents() {
		
		if (! $this->isFilterApplied ()) {			
			foreach ( $this->_userAgentsWithDeviceIDMap as $userAgent => $deviceID ) {
				if ( ! empty ( $deviceID )) {
					$this->_userAgentHandlerChain->filter ( $userAgent, $deviceID );
				}
			}
			$this->_userAgentHandlerChain->persistData ();			
			$this->setFilterApplied ();
		}
	}
	
	private function collectData() {
				
		if (! isset ( $this->_userAgentsWithDeviceIDMap )) {
			$this->_userAgentsWithDeviceIDMap = $this->_userAgentHandlerChain->collectData ();
		}
		
		$this->_devicesId = array_values ( $this->_userAgentsWithDeviceIDMap );
	}
	
	private function createCapabilitiesNameList() {
		$this->_groupIDCapabilitiesMap = $this->_xmlResourceManager->getGroupIDCapabilitiesMap ();
		$this->_capabilitiesName = array ();
		foreach ( array_values ( $this->_groupIDCapabilitiesMap ) as $capabilitiesName ) {
			$this->_capabilitiesName = array_merge ( $this->_capabilitiesName, $capabilitiesName );
		}
	}
	
	/**
	 * Checks if the device identified by $deviceID
	 * exists in the repository
	 *
	 * @param string $deviceID
	 * @return boolean
	 */
	private function isDeviceDefined($deviceID) {		
		return in_array ( $deviceID, array_values($this->_userAgentsWithDeviceIDMap ));
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
	
	private function setFilterApplied() {
		$this->_persistenceProvider->save ( WURFL_DeviceRepository::WURFL_USER_AGENTS_CLASSIFIED, TRUE );
	}
	
	private function isFilterApplied() {
		return $this->_persistenceProvider->load ( WURFL_DeviceRepository::WURFL_USER_AGENTS_CLASSIFIED );
	}

}

?>