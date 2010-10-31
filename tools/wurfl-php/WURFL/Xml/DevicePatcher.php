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
 *
 */
class WURFL_Xml_DevicePatcher {
	
	public function patch($device, $patchingDevice) {
		
		if (strcmp ( $patchingDevice->userAgent, $device->userAgent ) !== 0) {
			$message = "Patch Device : " . $patchingDevice->id . " can't ovveride user agent " . $device->userAgent . " with " . $patchingDevice->userAgent;
			throw new WURFL_WURFLException ( $message );
		}
		
		$groupIdCapabilitiesMap = WURFL_WURFLUtils::array_merge_recursive_unique ( $device->getGroupIdCapabilitiesMap (), $patchingDevice->getGroupIdCapabilitiesMap () );
		
		return new WURFL_Xml_ModelDevice ( $device->id, $device->userAgent, $device->fallBack, $device->actualDeviceRoot, $groupIdCapabilitiesMap );
	
	}
}

?>