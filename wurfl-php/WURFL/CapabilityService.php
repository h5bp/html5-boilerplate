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
 */
class WURFL_CapabilityService {

	/**
	 * Initialize the CapabilityService
	 *
	 * @param WURFL_DeviceRepository $deviceRepository
	 * @param WURFL_Cache_CacheProvider $cacheProvider
	 */
	function __construct($deviceRepository, $cacheProvider) {
		$this->_deviceRepository = $deviceRepository;
		$this->_cacheProvider = $cacheProvider;
	}

	/**
	 * Return a Cabability Value
	 *
	 * @param string $deviceID
	 * @param string $capabilityName
	 * @return string
	 */
	function getCapabilityForDevice($deviceID, $capabilityName) {
		$key = $deviceID . $capabilityName;
		$capabilityValue = $this->_cacheProvider->get($key);
		if (empty($capabilityValue)) {
			$capabilityValue = $this->_deviceRepository->getCapabilityForDevice($deviceID, $capabilityName);
			// save it in cache
			$this->_cacheProvider->put($key, $capabilityValue);
		}
		return $capabilityValue;
	}

	/**
	 * Returns all the capabilities of the device
	 *
	 * @param string $deviceID
	 * @return array
	 */
	function getAllCapabilitiesForDevice($deviceID) {
		return $this->_deviceRepository->getAllCapabilitiesForDevice($deviceID);
	}

	/**
	 * Returns an array of all groups id
	 *
	 * @return array
	 */
	public function getListOfGroups() {
		return $this->_deviceRepository->getListOfGroups();
	}


	/**
	 * Returns an array of capabilities name for the given gorup id
	 *
	 * @param string $groupID
	 * @return array
	 */
	public function getCapabilitiesNameForGroup($groupID) {
		return $this->_deviceRepository->getCapabilitiesNameForGroup($groupID);
	}
	
	/**
	 * Return a list of fallback devices starting from 
	 * the given 
	 *
	 * @param string $deviceID
	 * @return array of devices
	 */
	public function getDeviceHierarchy($deviceID) {
		return $this->_deviceRepository->getDeviceHierarchy($deviceID);
	}

	/**
	 *  
	 *
	 * @param string $deviceID
	 * @return array
	 */
	public function getFallBackListForDevice($deviceID) {
		$devices = $this->_deviceRepository->getDeviceHierarchy($deviceID);
		$fallBacks = array();
		foreach ($devices as $device) {
			$fallBacks[] = $device->id;
		}
		return $fallBacks;
	}

	private $_deviceRepository;
	private $_cacheProvider;
}

?>