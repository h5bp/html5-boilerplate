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
class WURFL_Device {
	
	private $_modelDevice;
	private $_capabilitiesHolder;
	
	public function __construct($modelDevice, $capabilitiesHolder) {
		$this->_modelDevice = $modelDevice;
		$this->_capabilitiesHolder = $capabilitiesHolder;	
	}
	
	/**
	 * Magic Method
	 *
	 * @param string $name
	 * @return string
	 */
	public function __get($name) {
		if (isset($name)) {
			switch ($name) {
				case "id":
				case "userAgent":
				case "fallBack":
				case "actualDeviceRoot":
					return $this->_modelDevice->$name;
				break;
				default:
					throw new WURFL_WURFLException("the field " . $name . " is not defined");
				break;
			}
			
		}

		throw new WURFL_WURFLException("the field " . $name . " is not defined");
	}
	
	/**
	 * Returns the value of a given capability name
	 * for the current device
	 * 
	 * @param string $capability must be a valid capability name
	 * @return string
	 * @throws WURFLException if the value of the $capability name is illegal
	 */
	public function getCapability($capabilityName) {
		if (!isset($capabilityName)) {
			throw new Exception("capability name must not be null");
		}

		return $this->_capabilitiesHolder->getCapability($capabilityName);
	}
	
	/**
	 * Returns all the value of the capabilities of the
	 * current device 
	 *
	 */
	public function getAllCapabilities() {
		return $this->_capabilitiesHolder->getAllCapabilities();
	}
}

?>