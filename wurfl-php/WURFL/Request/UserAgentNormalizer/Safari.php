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

class WURFL_Request_UserAgentNormalizer_Safari implements WURFL_Request_UserAgentNormalizer_Interface {
	
	const PATTERN = "/(Mozilla\/5\.0.*U;)(?:.*)(Safari\/\d{0,3})(?:.*)/";
	/**
	 * Return the safari user agent stripping out 
	 * 	- all the chararcters between U; and Safari/xxx
	 *	
	 *  e.g Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_4_11; fr) AppleWebKit/525.18 (KHTML, like Gecko) Version/3.1.1 Safari/525.18
	 * 		becomes
	 * 		Mozilla/5.0 (Macintosh Safari/525
	 * 
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return preg_replace ( self::PATTERN, "$1 $2", $userAgent );
	}

}

?>