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
 */

class WURFL_Xml_WURFLConsistencyVerifier {
	
	private function __construct() {
	}
	
	private function __clone() {
	}
	
	/**
	 * Verifies the correctness of the wurfl devices
	 *
	 * @param array $devicesMap
	 */
	public static function verify(array $devicesMap) {
				
		$devicesMapByUserAgent = array ();
		$hierarchyVerifiedDeviceIds = array ();
		
		// Verifiy the existance of the Generic Device
		self::verifyGenericDeviceExistance ( $devicesMap );
		
		$genericDevice = $devicesMap [WURFL_Constants::GENERIC];
		
		foreach ($devicesMap as $deviceId => $device) {		
			if(!WURFL_WURFLUtils::isGeneric($deviceId)) {						
				self::verifyUserAgentUniqueness ( $devicesMapByUserAgent, $device->userAgent );
				$devicesMapByUserAgent [$device->userAgent] = $device;
				
				//self::verifyHierarchy($devicesMap, $hierarchyVerifiedDeviceIds, $device);
				//$hierarchyVerifiedDeviceIds[] = $device->id;
				

				self::verifyGroups ( $genericDevice, $device );
				
				self::verifyCapabilities ( $genericDevice, $device );
			
			}
		
		}
	
	}
	
	/**
	 * Verifies if a device defines a new capability not defined by generic
	 *
	 * @param ModelDevice $genericDevice
	 * @param ModelDevice $device
	 */
	private static function verifyCapabilities($genericDevice, $device) {
		$genericDeviceGroupIdCapabilitiesNameMap = $genericDevice->groupIdCapabilitiesNameMap;
		$deviceGroupIdCapabilitiesNameMap = $device->groupIdCapabilitiesNameMap;
		foreach ( $deviceGroupIdCapabilitiesNameMap as $groupId => $capabilitiesName ) {
			$diff = array_diff ( $capabilitiesName, $genericDeviceGroupIdCapabilitiesNameMap [$groupId] );
			if (count ( $diff ) > 0) {
				$values = implode ( " ", $diff );
				throw new WURFL_WURFLException ( "The device $device->id defines new capabilities [$values] in group $groupId not defined in the Generic Device" );
			}
		}
	
	}
	
	/**
	 * Verifies that a device does not define a new group that is not defined in the generic
	 *
	 * @param array $devicesMap
	 * @param WURFL_Device $device
	 */
	private static function verifyGroups($genericDevice, $device) {
		$genericDeviceGroupIdCapabilitiesNameMap = $genericDevice->groupIdCapabilitiesNameMap;
		$deviceGroupIdCapabilitiesNameMap = $device->groupIdCapabilitiesNameMap;
		
		$diff = array_diff_key ( $deviceGroupIdCapabilitiesNameMap, $genericDeviceGroupIdCapabilitiesNameMap );
		
		if (count ( $diff ) > 0) {
			$values = implode ( " ", array_keys ( $diff ) );
			throw new WURFL_WURFLException ( "The device $device->id defines new Groups [$values] not defined in the Generic Device" );
		}
	}
	
	/**
	 * Verifies the existance of the generic device
	 *
	 * @param array $devicesMap
	 */
	private static function verifyGenericDeviceExistance($devicesMap) {
		if (! array_key_exists ( WURFL_Constants::GENERIC, $devicesMap )) {
			throw new WURFL_WURFLException ( "Generic Device is not defined." );
		}
	}
	
	/**
	 * Verifies the uniqueness of the user agent
	 *
	 * @param array $devicesMapByUserAgent
	 * @param string $userAgent
	 */
	private static function verifyUserAgentUniqueness($devicesMapByUserAgent, $userAgent) {
		if (array_key_exists ( $userAgent, array_keys ( $devicesMapByUserAgent ) )) {
			$device = $devicesMapByUserAgent [$userAgent];			
			if ($device != null) {
				throw new WURFL_WURFLException ( "user agent " . $userAgent . " is already defined by device " . $device->id );
			}
		}
	
	}
	
	/**
	 * Verifies if every device has a valid fall back and that there is no
	 * cicular fall backs references
	 *
	 * @param array $devicesMap
	 * @param array $hierarchyVerifiedDeviceIds
	 * @param mixed $device
	 */
	private static function verifyHierarchy($devicesMap, $hierarchyVerifiedDeviceIds, $deviceToCheck) {
		
		$hierarchy = array ();
		
		$id = $deviceToCheck->id;
		
		while ( strcmp ( WURFL_Constants::GENERIC, $id ) !== 0 ) {
			$device = $devicesMap [$id];
			$fallBack = $device->fallBack;
			
			if (array_search ( $fallBack, $hierarchyVerifiedDeviceIds )) {
				return;
			}
			
			if (! array_key_exists ( $fallBack, $devicesMap )) {
				throw new WURFL_WURFLException ( "Fall Back not found for device : " . $id );
			}
			
			// Check for circular hierarchy
			

			$id = $fallBack;
		
		}
	
	}
	
	private static function getGenericDevice($devicesMap) {
		return $devicesMap [WURFL_Constants::GENERIC];
	}
	
	private static function isGeneric($device) {
		return strcmp ( $device->id, WURFL_Constants::GENERIC ) === 0;
	}

}

?>