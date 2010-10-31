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
class WURFL_Xml_VersionIterator extends WURFL_Xml_AbstractIterator {
	
	function __construct($inputFile) {
		parent::__construct ( $inputFile );
	}
	
	public function readNextElement() {
		$version = "";
		$lastUpdated = "";
		$officialURL = "";
		while ( $this->xmlReader->read () ) {
			
			$nodeName = $this->xmlReader->name;
			switch ($this->xmlReader->nodeType) {
				case XMLReader::TEXT :
					$currentText = $this->xmlReader->value;
					break;
				case XMLReader::END_ELEMENT :
					switch ($nodeName) {
						case 'version' :
							$this->currentElement = new WURFL_Xml_Info ( $version, $lastUpdated, $officialURL );
							break 2;
						
						case 'ver' :
							$version = $currentText;
						break;						
						
						case 'last_updated' :
							$lastUpdated = $currentText;
							break;
						
						case "official_url" :
							$officialURL = $currentText;
							break;
					}
			}
		} // end of while
	

	}

}
?>