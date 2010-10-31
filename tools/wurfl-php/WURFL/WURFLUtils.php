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
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_WURFLUtils {

	/**
	 * returns the User Agent From $_SERVER
	 *
	 * @param $_SERVER $request
	 * @return string
	 */
	public static function getUserAgent($request) {			
		if (isset($request[WURFL_Constants::UA])) {
			return $request[WURFL_Constants::UA];
		}		

		if(isset($request['HTTP_X_DEVICE_USER_AGENT'])) {
			return $request['HTTP_X_DEVICE_USER_AGENT'];
		}		
		if(isset($request['HTTP_USER_AGENT'])) {
			return $request['HTTP_USER_AGENT'];
		}
		
		throw new WURFL_WURFLException("No user-agent found in the request");
	}

	/**
	 * returns the UA Profile from the $_SERVER object
	 *
	 *
	 * @param $_SERVER $request
	 * @return  string
	 */
	public static function getUserAgentProfile($request) {
		if (isset($request["HTTP_X_WAP_PROFILE"])) {
			return $request["HTTP_X_WAP_PROFILE"];
		}
		if (isset($request["HTTP_PROFILE"])) {
			return $request["HTTP_PROFILE"];
		}
		if (isset($request["Opt"])) {
			$opt = $request["Opt"];
			$regex = "/ns=\\d+/";
			$matches = array();
			if (preg_match($regex, $opt, $matches)) {
				$namespaceProfile = substr($matches[0], 2) . "-Profile";
			}
			if (isset($request[$namespaceProfile])) {
				return $request[$namespaceProfile];
			}
		}

		return NULL;
	}

	/**
	 * Checks if the requester device is xhtml enaabled
	 *
	 * @param $_SERVER $request
	 * @return boolean
	 */
	public static function isXhtmlRequester($request) {
		if (!isset($request["accept"])) {
			return FALSE;
		}
		
		$accept = $request["accept"];
		if (isset($accept)) {
			if ((strpos($accept, WURFL_Constants.ACCEPT_HEADER_VND_WAP_XHTML_XML) !== 0)
			|| (strpos($accept, WURFL_Constants.ACCEPT_HEADER_XHTML_XML) !== 0)
			|| (strpos($accept, WURFL_Constants.ACCEPT_HEADER_TEXT_HTML) !== 0)) {
				return true;;
			}
		}

		return false;

	}


	public static function isGeneric($deviceID) {
		if (strcmp($deviceID, WURFL_Constants::GENERIC) === 0) {
			return true;
		}
		return false;
	}
	
	public static function array_merge_recursive_unique($array1, $array2) {
		// LOOP THROUGH $array2
		foreach($array2 AS $k => $v) {

			// CHECK IF VALUE EXISTS IN $array1
			if(!empty($array1[$k])) {
				// IF VALUE EXISTS CHECK IF IT'S AN ARRAY OR A STRING
				if(!is_array($array2[$k])) {
					// OVERWRITE IF IT'S A STRING
					$array1[$k]=$array2[$k];
				} else {
					// RECURSE IF IT'S AN ARRAY
					$array1[$k] = self::array_merge_recursive_unique($array1[$k], $array2[$k]);
				}
			} else {
				// IF VALUE DOESN'T EXIST IN $array1 USE $array2 VALUE
				$array1[$k]=$v;
			}
		}
		unset($k, $v);

		return $array1;
	}
	
	public static function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}
}

?>