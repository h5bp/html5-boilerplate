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
final class WURFL_Xml_ParsingResult {
	
	private $devicesMap;
	private $groupIDCapabilitiesMap;
	
	public function __construct($devicesMap, $groupIDCapabilitiesMap=null) {
		$this->devicesMap = $devicesMap;
		$this->groupIDCapabilitiesMap = $groupIDCapabilitiesMap;	
	}
	
	public function __get($name) {
		return $this->$name;
	}
}

?>