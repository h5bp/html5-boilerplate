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


class WURFL_Request_UserAgentNormalizer_BlackBerry implements WURFL_Request_UserAgentNormalizer_Interface  {

	/**
	 * This method returns the substring starting from "BlackBerry"
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {

		$index = strpos($userAgent, "BlackBerry");
		if ($index > 0) {
			$userAgent = substr($userAgent, $index);
		}
		
		return $userAgent;
	}

}


?>