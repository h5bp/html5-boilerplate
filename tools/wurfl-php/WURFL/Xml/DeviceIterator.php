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
class WURFL_Xml_DeviceIterator extends  WURFL_Xml_AbstractIterator {
	
	
	function __construct($inputFile) {
		parent::__construct($inputFile);
	}
	
	public function readNextElement() {
		
		$deviceId = null;
		$groupId = null;
		
		while ( $this->xmlReader->read () ) {			
			
			$nodeName = $this->xmlReader->name;
			switch ($this->xmlReader->nodeType) {
				case XMLReader::ELEMENT :
					switch ($nodeName) {
						case WURFL_Xml_Interface::DEVICE :
							$groupIDCapabilitiesMap = array ();
							
							$deviceId = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::ID );
							$userAgent = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::USER_AGENT );
							$fallBack = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::FALL_BACK );
							$actualDeviceRoot = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::ACTUAL_DEVICE_ROOT );
							
							$currentCapabilityNameValue = array ();
							if ($this->xmlReader->isEmptyElement) {
								$this->currentElement = new WURFL_Xml_ModelDevice ( $deviceId, $userAgent, $fallBack, $actualDeviceRoot );
								break 3;
							}
							break;
						
						case WURFL_Xml_Interface::GROUP :
							$groupId = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::GROUP_ID );
							$groupIDCapabilitiesMap [$groupId] = array ();
							break;
						
						case WURFL_Xml_Interface::CAPABILITY :
							
							$capabilityName = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_NAME );
							$capabilityValue = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_VALUE );
							$currentCapabilityNameValue [$capabilityName] = $capabilityValue;
							$groupIDCapabilitiesMap [$groupId] [$capabilityName] = $capabilityValue;
					
							break;
					}
					
					break;
				case XMLReader::END_ELEMENT :
					if ($nodeName == WURFL_Xml_Interface::DEVICE) {						
						$this->currentElement = new WURFL_Xml_ModelDevice ( $deviceId, $userAgent, $fallBack, $actualDeviceRoot, $groupIDCapabilitiesMap );
						break 2;
					}
			}
		} // end of while
		
	}

}
?>