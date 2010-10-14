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

interface WURFL_Xml_Interface {
	
	/**
	 * Parses the given file and returns a WURFL_Xml_ParsingResult 
	 * object
	 *
	 * @param string $fileName
	 * @return WURFL_Xml_ParsingResult
	 */	
	public function parse($fileName);
	
	const ID = "id";
	const USER_AGENT = "user_agent";
	const FALL_BACK = "fall_back";
	const ACTUAL_DEVICE_ROOT = "actual_device_root";
	
	const DEVICE = "device";
	
	const GROUP = "group";
	const GROUP_ID = "id";
	
	const CAPABILITY = "capability";
	const CAPABILITY_NAME = "name";
	const CAPABILITY_VALUE = "value";
	
	
}

?>