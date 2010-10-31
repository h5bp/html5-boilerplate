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
 * @package    WURFL_Configuration
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Configuration_ConfigHolder {
	
	private static $_wurflConfig = null;
	
	private function __construct() {
	}
	
	private function __clone() {
	}
	
	/**
	 * Returns a Configuration object
	 *
	 */
	public static function getWURFLConfig() {
		if (null === self::$_wurflConfig) {
			throw new WURFL_WURFLException ( "The Configuration Holder is not initialized with a valid WURFLConfig object" );
		}
		
		return self::$_wurflConfig;
	}
	
	/**
	 * Sets the Configuration object
	 *
	 * @param WURFL_Configuration_Config $wurflConfig
	 */
	public static function setWURFLConfig(WURFL_Configuration_Config $wurflConfig) {
		self::$_wurflConfig = $wurflConfig;
	}
	

}

?>