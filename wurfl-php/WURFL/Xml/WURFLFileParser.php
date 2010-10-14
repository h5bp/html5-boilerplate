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
class WURFL_Xml_WURFLFileParser implements WURFL_Xml_Interface {
	
	const WURFL_SCHEMA = "wurfl.rng";
	
	/**
	 * Parses the given xml, creates maps of devices and map group capabilities map
	 *
	 * @param string $fileName path to the xml file to parse
	 * @return array of <deviceId, modelDevice>  
	 */
	public function parse($fileName) {
		 return WURFL_Xml_ParserUtil::parse($fileName, self::WURFL_SCHEMA);	
	}
	

}

?>