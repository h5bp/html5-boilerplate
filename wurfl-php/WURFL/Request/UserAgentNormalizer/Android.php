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


class WURFL_Request_UserAgentNormalizer_Android implements WURFL_Request_UserAgentNormalizer_Interface  {
	
	const LANGUAGE_PATTERN = "/; [a-z]{2}(-[a-zA-Z]{2})?(?!=[;)])/";
	/**
	 * Return the UserAgent Without the language coed 
	 * 
	 * 
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {		
		return preg_replace(self::LANGUAGE_PATTERN, "", $userAgent, 1);
	}
	
	
	private function androidWithMajorAndMinorVersion($userAgent) {
		return substr($userAgent, strpos($userAgent, "Android"), 11);
	}
	
	

}


?>