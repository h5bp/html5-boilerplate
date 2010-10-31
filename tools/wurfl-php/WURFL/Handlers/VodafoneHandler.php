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
 * VodafoneUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_VodafoneHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "VODAFONE";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercepting All User Agents Starting with "Vodafone"
	 *
	 * @param $string $userAgent
	 * @return boolean
	 */
	function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Vodafone" );
	}
	
	/** 
	 * 
	 * @param string $userAgent
	 */
	function lookForMatchingUserAgent($userAgent) {	
		$userAgents = array_keys ( $this->userAgentsWithDeviceID );				
		$tolerance = WURFL_Handlers_Utils::ordinalIndexOf($userAgent, "/", 3);		
		return WURFL_Handlers_Utils::risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tolerance);
	}

}

?>