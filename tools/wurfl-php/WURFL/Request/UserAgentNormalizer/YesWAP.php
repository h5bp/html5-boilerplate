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
 * @package    WURFL_Request_UserAgentNormalizer
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Request_UserAgentNormalizer_YesWAP implements WURFL_Request_UserAgentNormalizer_Interface  {

	const YES_WAP_REGEX = "/\\s*Mozilla\\/4\\.0 \\(YesWAP mobile phone proxy\\)/";
	
	/**
	 * 
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return preg_replace(self::YES_WAP_REGEX, "", $userAgent);
	}
	
	
	
}
?>