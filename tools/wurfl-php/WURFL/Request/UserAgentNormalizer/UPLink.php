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
class WURFL_Request_UserAgentNormalizer_UPLink implements WURFL_Request_UserAgentNormalizer_Interface  {

	/**
	 * This method remove the "UP.Link" substring from user agent string.
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		$index = strpos($userAgent, "UP.Link");
		if ($index > 0) {
			return substr($userAgent, 0, $index);
		}
		return $userAgent;
	}

}

?>