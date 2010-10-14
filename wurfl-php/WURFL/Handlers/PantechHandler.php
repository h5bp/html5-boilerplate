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
 * PantechUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_PantechHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs starting with "Pantech","PANTECH","PT-" or "PG-"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Pantech" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "PANTECH" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "PT-" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "PG-" );
	}
	
	/**
	 * If starts with "PT-", "PG-" or "PANTECH", use RIS with FS
	 * Otherwise LD with threshold 4
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Pantech" )) {
			return WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::PANTECH_TOLLERANCE );
		}
		$tollerance = WURFL_Handlers_Utils::firstSlash ( $userAgent );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tollerance );
	
	}
	
	const PANTECH_TOLLERANCE = 4;
	protected $prefix = "PANTECH";
}
?>