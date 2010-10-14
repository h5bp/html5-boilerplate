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
 * SPVUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_SPVHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "SPV";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs starting containing SPV"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "SPV" );
	}
	
	function lookForMatchingUserAgent($userAgent) {
		$tollerance = WURFL_Handlers_Utils::indexOfOrLength ( $userAgent, ";", strpos ( $userAgent, "SPV" ) );
		return parent::applyRisWithTollerance ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tollerance );
	}
	
	/**
	 * If "OpVer x.x.x.x is present, then apply TokensMatcher wit thresold 7,
	 * otherwise apply LD with thresold 5.
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgentx($userAgent) {
		$userAgents = array_keys ( $this->userAgentsWithDeviceID );
		$spvTokensProvider = new WURFL_Handlers_Matcher_SPVProvider ();
		
		if ($spvTokensProvider->canApply ( $userAgent )) {
			$tokenMatcher = new WURFL_Handlers_Matcher_TokenMatcher ( $spvTokensProvider );
			return $tokenMatcher->match ( $userAgents, $userAgent, 7 );
		}
		return WURFL_Handlers_Utils::ldMatch ( $userAgents, $userAgent, 5 );
	
	}

}
?>