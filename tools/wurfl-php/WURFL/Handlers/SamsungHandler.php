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
 * SamsungUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_SamsungHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing "Samsung/SGH" or
	 * starting with one of the following
	 * "SEC-", "Samsung", "SAMSUNG", "SPH", "SGH", "SCH"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Samsung/SGH" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SEC-" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Samsung" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SAMSUNG" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SPH" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SGH" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SCH" );
	}
	
	/**
	 * If UA starts with one of the following ("SEC-", "SAMSUNG-", "SCH"), apply RIS with FS.
	 * If UA starts with one of the following ("Samsung-","SPH", "SGH" ), apply RIS with First Space (not FS).
	 * If UA starts with "SAMSUNG/", apply RIS with threshold SS (Second Slash)
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SEC-" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SAMSUNG-" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SCH" )) {
			$tollerance = WURFL_Handlers_Utils::firstSlash ( $userAgent );
		} else if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Samsung" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SPH" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "SGH" )) {
			$tollerance = WURFL_Handlers_Utils::firstSpace ( $userAgent );
		} else {
			$tollerance = WURFL_Handlers_Utils::secondSlash ( $userAgent );
		}
		$this->logger->log ( "$this->prefix :Applying Conclusive Match for ua: $userAgent with tollerance $tollerance" );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tollerance );
	}
	
	protected $prefix = "SAMSUNG";
}

?>