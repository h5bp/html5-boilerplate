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
 * LGUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_LGHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "LG";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs starting with "LG"
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "LG" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "lg" );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
		if ($this->isVodafone ( $userAgent )) {
			$tolerance = WURFL_Handlers_Utils::ordinalIndexOf($userAgent, "LG", 1);
		}
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "LG/" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "LGE/" )) {
			$tolerance = WURFL_Handlers_Utils::secondSlash ( $userAgent );
		} else {
			$tolerance = WURFL_Handlers_Utils::firstSlash ( $userAgent );
		}
		
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tolerance );
	}
	
	
	private function isVodafone($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith($userAgent, "Vodafone");
	}
	
	

}
?>