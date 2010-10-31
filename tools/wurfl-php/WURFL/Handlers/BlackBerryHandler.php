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
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * BlackBerryUserAgentHanlder
 * 
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Handlers_BlackBerryHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing "BlackBerry"
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "BlackBerry" );
	}
	
	/**
	 * Apply Recovery Match
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		
		if (strpos ( $userAgent, "BlackBerry" ) === 0) {
			
			$position = WURFL_Handlers_Utils::firstSlash ( $userAgent );
			if ($position > 0 && $position + 4 <= strlen ( $userAgent )) {
				$version = substr ( $userAgent, $position + 1, $position + 4 );
				
				if (strpos ( $version, "2." ) === 0) {
					return "blackberry_generic_ver2";
				}
				if (strpos ( $version, "3.2" ) === 0) {
					return "blackberry_generic_ver3_sub2";
				}
				if (strpos ( $version, "3.3" ) === 0) {
					return "blackberry_generic_ver3_sub30";
				}
				if (strpos ( $version, "3.5" ) === 0) {
					return "blackberry_generic_ver3_sub50";
				}
				if (strpos ( $version, "3.6" ) === 0) {
					return "blackberry_generic_ver3_sub60";
				}
				if (strpos ( $version, "3.7" ) === 0) {
					return "blackberry_generic_ver3_sub70";
				}
				if (strpos ( $version, "4." ) === 0) {
					return "blackberry_generic_ver4";
				}
			}
		}
	}
	
	protected $prefix = "BLACKBERRY";
}

?>