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
class WURFL_CapabilitiesHolder {
	
	private $_device;
	private $_deviceRepository;
	private $_cacheProvider;
	
	public function __construct($device, $deviceRepository, $cacheProvider) {
		$this->_device = $device;
		$this->_deviceRepository = $deviceRepository;
		$this->_cacheProvider = $cacheProvider;
	}
	
	/**
	 * Returns the value of a given capability name
	 * 
	 * @param string $capabilityName
	 * @return string
	 * @throws WURFLException if the value of the $capability name is illegal
	 */
	public function getCapability($capabilityName) {
		
		if(isset($this->_device->capabilities[$capabilityName])) {
 			return $this->_device->capabilities[$capabilityName];
 		}
 				
 		$key = $this->_device->id . "_" . $capabilityName;
 		$capabilityValue = $this->_cacheProvider->get($key);
 		if (empty($capabilityValue)) {

			$capabilityValue = $this->_deviceRepository->getCapabilityForDevice($this->_device->fallBack, $capabilityName);
 			// save it in cache
 			$this->_cacheProvider->put($key, $capabilityValue);
 		}

		// prevent useless gets when retrieving the same capability from this device again
		//$this->_device->capabilities[$capabilityName] = $capabilityValue;

 		return $capabilityValue;
 	}
	
	/**
	 * Returns all the capabilities value of the
	 * current device as <capabilityName, capabilityValue>
	 * Map
	 *
	 */
	public function getAllCapabilities() {
		return  $this->_deviceRepository->getAllCapabilitiesForDevice($this->_device->id);		
	}
	
}

?>