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
 * AppleUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_AppleHandler extends WURFL_Handlers_Handler {
	
	const APLLE_TOLLERANCE = 5;
	protected $prefix = "APPLE";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing either "iPhone" or "iPod" or "iPad"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPhone" ) 
			|| WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPod" )
			|| WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPad" );
	}
	
	/**
	 * Apply LD with threshold 5
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
		return WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::APLLE_TOLLERANCE );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPad" )) {
			return "apple_ipad_touch_ver1";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPod" )) {
			return "apple_ipod_touch_ver1";
		}
		
		return "apple_iphone_ver1";
	}

}
?>