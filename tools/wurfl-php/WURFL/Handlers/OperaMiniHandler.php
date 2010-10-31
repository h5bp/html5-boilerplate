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
class WURFL_Handlers_OperaMiniHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "OPERA_MINI";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs Containing Opera Mini
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera Mini" );
	}
	
	function applyRecoveryMatch($userAgent) {
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera Mini/1" )) {
			return "opera_mini_ver1";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera Mini/2" )) {
			return "opera_mini_ver2";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera Mini/3" )) {
			return "opera_mini_ver3";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera Mini/4" )) {
			return "opera_mini_ver4";
		}
	}

}