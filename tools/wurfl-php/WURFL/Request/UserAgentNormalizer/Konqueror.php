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


class WURFL_Request_UserAgentNormalizer_Konqueror implements WURFL_Request_UserAgentNormalizer_Interface  {

	const KONQUEROR = "Konqueror";
	
	/**
	 * Return the Konqueror user agent with the major version		
	 *  
	 * e.g 
	 * 	Mozilla/5.0 (compatible; Konqueror/4.1; Linux) KHTML/4.1.2 (like Gecko) -> Konqueror/4
	 * 		
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return $this->konquerorWithMajorVersion($userAgent);
	}
	
	private function konquerorWithMajorVersion($userAgent) {
		return substr($userAgent, strpos($userAgent, self::KONQUEROR), 10);
	}

}


?>