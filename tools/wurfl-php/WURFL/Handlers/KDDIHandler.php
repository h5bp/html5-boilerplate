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
 * KDDIUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_KDDIHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "KDDI";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing "KDDI"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "KDDI" );
	}
	
	/**
	 */
	function lookForMatchingUserAgent($userAgent) {
		$tolerance = $this->tolerance ( $userAgent );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tolerance );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera" )) {
			return "opera";
		}
		return "opwv_v62_generic";
	}
	
	private function tolerance($userAgent) {
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "KDDI/" )) {
			return WURFL_Handlers_Utils::secondSlash ( $userAgent );
		}
		
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "KDDI" )) {
			return WURFL_Handlers_Utils::firstSlash ( $userAgent );
		}
		
		return WURFL_Handlers_Utils::indexOfOrLength ( $userAgent, ")" );
	
	}

}
?>