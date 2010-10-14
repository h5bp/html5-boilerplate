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
 * OperaHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_OperaHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "OPERA";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		if (WURFL_Handlers_Utils::isMobileBrowser ( $userAgent )) {
			return false;
		}
		
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera" );
	}
	
	private $operas = array ("7" => "opera_7", "8" => "opera_8", "9" => "opera_9", "10" => "opera_10" );
	
	const OPERA_TOLERANCE = 3;
	function lookForMatchingUserAgent($userAgent) {
		return WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::OPERA_TOLERANCE );
	}
	
	function applyRecoveryMatch($userAgent) {
		$operaVersion = $this->operaVersion ( $userAgent );
		if (isset ( $this->operas [$operaVersion] )) {
			return $this->operas [$operaVersion];
		}
		
		return "opera";
		
	}
	
	const OPERA_VERSION_PATTERN = "/.*Opera\/(\d+).*$/";
	private function operaVersion($userAgent) {
		if (preg_match ( self::OPERA_VERSION_PATTERN, $userAgent, $match )) {
			return $match [1];
		}
		return NULL;
	}

}