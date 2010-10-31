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

class WURFL_Request_UserAgentNormalizer_Opera implements WURFL_Request_UserAgentNormalizer_Interface {
	
	const OPERA = "Opera";

	const PATTERN = "/Opera[\/\s]{1}[\d]{1,}(?!=[\.])/";
	
	/**
	 * Return the Opera user agent with the major version		
	 * 
	 * e.g 
	 * Opera/9.00 (Windows NT 5.1; U; de) -> Opera/9
	 * Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0) Opera 7.52 [en] -> Opera 7
	 * 
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		if(preg_match(self::PATTERN, $userAgent, $matches)) {
			return $matches[0];
		}
		return $userAgent;
	}
	
	private function operaWithMajorVersion($userAgent) {
		return substr ( $userAgent, strpos ( $userAgent, self::OPERA ), 7 );
	}

}

?>