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
class WURFL_Request_UserAgentNormalizer_Vodafone implements WURFL_Request_UserAgentNormalizer_Interface  {

	/**
	 * Clean the UA from the serial number by replacing
	 * "SN"+digits with the "SN"+ "X"x the number of digits available in the original UA.
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		$regex = "/SN\\d+/";
		$matches = array();
		if(preg_match($regex, $userAgent, $matches)) {
			 $string = "SN";	
			for($i=2; $i< strlen($matches[0]); $i=$i+1) {
				$string .= "X";
			}
			return str_replace($matches, $string, $userAgent);
		}
		return $userAgent;
	}

}

?>