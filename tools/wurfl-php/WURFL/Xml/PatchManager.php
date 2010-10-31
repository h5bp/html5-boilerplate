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
 * @package    WURFL_Xml
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 * @deprecated
 */
class WURFL_Xml_PatchManager {

	
	private $genericDevice;
	
	/**
	 * Apply Patch
	 *
	 * @param WURFL_Xml_ParsingResult $wurflParsingResult
	 * @param WURFL_Xml_ParsingResult $patchParsingResult
	 * @return WURFL_Xml_ParsingResult
	 */
	public function applyPatch($devices, $patchingDevices) {
				
		$this->genericDevice = $devices["generic"]; 
		
		foreach ($patchingDevices as $patchingDevice) {
			$deviceAlreadyDefined = array_key_exists($patchingDevice->id, $devices);
			if ($deviceAlreadyDefined) {
				// device already exist update device;
				$device = $this->patchSingleDevice($devices[$patchingDevice->id], $patchingDevice);
				$devices[$device->id] = $device;
			} else {
				// New device
				$devices[$patchingDevice->id] = $patchingDevice;
			}
		}

		return $devices;
	}


	/**
	 * Pathces a single device with a device from the patch file
	 *
	 * @param WURFL_Xml_ModelDevice $device
	 * @param WURFL_Xml_ModelDevice $patchingDevice
	 * @return WURFL_Xml_ModelDevice
	 */
	private function patchSingleDevice($device, $patchingDevice) {
		if (strcmp($patchingDevice->userAgent, $device->userAgent) !== 0) {
			$message = "Patch Device : " .$patchingDevice->id . " can't ovveride user agent " . $device->userAgent . " with " . $patchingDevice->userAgent;
			throw new WURFL_WURFLException($message);
		}
		
		$groupIdCapabilitiesMap = WURFL_WURFLUtils::array_merge_recursive_unique($device->getGroupIdCapabilitiesMap(), $patchingDevice->getGroupIdCapabilitiesMap());
		
		return new WURFL_Xml_ModelDevice($device->id, $device->userAgent, $device->fallBack, $device->actualDeviceRoot, $groupIdCapabilitiesMap);

	}

}
		/*
		if (strcmp($device->fallBack, $patchDevice->fallBack) !== 0) {
			$message = "you are not allowed to ovveride fall back for device : " . $device->id;
			throw new WURFL_WURFLException($message);
		}
		*/


?>