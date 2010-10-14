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

class WURFL_Request_UserAgentNormalizer_Chrome implements WURFL_Request_UserAgentNormalizer_Interface {
		
	/**
	 * Return the Chrome string with the major version  
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return $this->chromeWithMajorVersion ( $userAgent );		
	}
	
	private function chromeWithMajorVersion($userAgent) {
		return substr ( $userAgent, strpos ( $userAgent, "Chrome" ), 8);
	}

}

?>