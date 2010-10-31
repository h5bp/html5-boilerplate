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
class WURFL_Xml_ParserUtil {
	
	/**
	 * Creates a Map of devices from the xml file
	 *
	 * @param string $fileName path to the xml file to parse
	 * @return Map of <deviceId ModelDevice>
	 */
	public static function parse($fileName, $validationSchema) {
		
		$devicesMap = array ();
		
		$deviceID = null;
		$groupID = null;
		
		$reader = new XMLReader ( );
		$reader->open ( $fileName );
		
		$fullFileName = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . $validationSchema;
		$reader->setRelaxNGSchema ( $fullFileName );
		libxml_use_internal_errors ( TRUE );
		
		while ( $reader->read () ) {			
			if (! $reader->isValid ()) {
				throw new Exception ( libxml_get_last_error()->message );
			}
			
			$nodeName = $reader->name;
			switch ($reader->nodeType) {
				case XMLReader::ELEMENT :
					switch ($nodeName) {
						case WURFL_Xml_Interface::DEVICE :
							$groupIDCapabilitiesMap = array ();
							
							$deviceID = $reader->getAttribute ( WURFL_Xml_Interface::ID );
							$userAgent = $reader->getAttribute ( WURFL_Xml_Interface::USER_AGENT );
							$fallBack = $reader->getAttribute ( WURFL_Xml_Interface::FALL_BACK );
							$actualDeviceRoot = $reader->getAttribute ( WURFL_Xml_Interface::ACTUAL_DEVICE_ROOT );
							
							$currentCapabilityNameValue = array ();
							if ($reader->isEmptyElement) {
								$device = new WURFL_Xml_ModelDevice ( $deviceID, $userAgent, $fallBack, $actualDeviceRoot );
								$devicesMap [$deviceID] = $device;
							}
							break;
						
						case WURFL_Xml_Interface::GROUP :
							$groupID = $reader->getAttribute ( WURFL_Xml_Interface::GROUP_ID );
							$groupIDCapabilitiesMap [$groupID] = array ();
							break;
						
						case WURFL_Xml_Interface::CAPABILITY :
							
							$capabilityName = $reader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_NAME );
							$capabilityValue = $reader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_VALUE );
							$currentCapabilityNameValue [$capabilityName] = $capabilityValue;
							$groupIDCapabilitiesMap [$groupID] [$capabilityName] = $capabilityValue;
							
							break;
					}
					
					break;
				case XMLReader::END_ELEMENT :
					if ($nodeName == WURFL_Xml_Interface::DEVICE) {						
						$device = new WURFL_Xml_ModelDevice ( $deviceID, $userAgent, $fallBack, $actualDeviceRoot, $groupIDCapabilitiesMap );
						$devicesMap [$device->id] = $device;
					}
					break;
			}
		} // end of while
		

		$reader->close ();
		
		return $devicesMap;
	
	}

}

?>