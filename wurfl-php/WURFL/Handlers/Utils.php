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

class WURFL_Handlers_Utils {
	
	private static $mobileBrowsers = array ("cldc", "symbian", "midp", "j2me", "mobile", "wireless", "palm", "phone", "pocket pc", "pocketpc", "netfront", "bolt", "iris", "brew", "openwave", "windows ce", "wap2", "android", "opera mini", "opera mobi", "maemo", "fennec", "blazer", "160x160", "tablet", "webos", "sony" );
	
	public static function risMatch($collection, $needle, $tollerance) {
		return WURFL_Handlers_Matcher_RISMatcher::INSTANCE ()->match ( $collection, $needle, $tollerance );
	}
	
	public static function ldMatch($collection, $needle, $tollerance = 7) {
		return WURFL_Handlers_Matcher_LDMatcher::INSTANCE ()->match ( $collection, $needle, $tollerance );
	}
	
	public static function indexOfOrLength($string, $target, $startingIndex=0) {
		$lengh = strlen ( $string );		
		$pos = strpos ( $string, $target, $startingIndex );
		return $pos === false ? $lengh : $pos;
	}
	
	private static $mobileBrowserUserAgents = array ();
	public static function isMobileBrowser($userAgent) {
		if (isset ( self::$mobileBrowserUserAgents [$userAgent] )) {
			return self::$mobileBrowserUserAgents [$userAgent];
		}
		$mobileBrowser = false;
		foreach ( self::$mobileBrowsers as $key ) {
			if (stripos ( $userAgent, $key ) !== FALSE) {
				$mobileBrowser = true;
				break;
			}
		}
		self::$mobileBrowserUserAgents [$userAgent] = $mobileBrowser;
		return $mobileBrowser;
	
	}
	
	public static function isSpamOrCrawler($userAgent) {
		//$spamOrCrawlers = array("FunWebProducts", "Spam");		
		return self::checkIfContains ( $userAgent, "Spam" ) || self::checkIfContains ( $userAgent, "FunWebProducts" );
	}
	
	/**
	 * 
	 * Returns the position of third occurrence of a ;(semi-column) if it exists
	 * the string length otherwise
	 *
	 * @param string $haystack
	 */
	public static function thirdSemiColumn($haystack) {
		$thirdSemiColumnIndex = self::ordinalIndexOf ( $haystack, ";", 3 );
		if ($thirdSemiColumnIndex < 0) {
			return strlen ( $haystack );
		}
		
		return $thirdSemiColumnIndex;
	}
	
	public static function ordinalIndexOf($haystack, $needle, $ordinal) {
		if (is_null ( $haystack ) || empty ( $haystack )) {
			throw new InvalidArgumentException ( "haystack must not be null or empty" );
		}
		
		if (! is_integer ( $ordinal )) {
			throw new InvalidArgumentException ( "ordinal must be a positive ineger" );
		}
		
		$found = 0;
		$index = - 1;
		do {
			$index = strpos ( $haystack, $needle, $index + 1 );
			$index = is_int ( $index ) ? $index : - 1;
			if ($index < 0) {
				return $index;
			}
			$found ++;
		} while ( $found < $ordinal );
		
		return $index;
	
	}
	
	public static function firstSlash($string) {
		$firstSlash = strpos ( $string, "/" );
		return $firstSlash != 0 ? $firstSlash : strlen ( $string );
	}
	
	public static function secondSlash($string) {
		$firstSlash = strpos ( $string, "/" );
		if ($firstSlash === false)
			return strlen ( $string );
		return strpos ( substr ( $string, $firstSlash + 1 ), "/" ) + $firstSlash;
	}
	
	public static function firstSpace($string) {
		$firstSpace = strpos ( $string, " " );
		return ($firstSpace == 0) ? strlen ( $string ) : $firstSpace;
	}
	
	public static function checkIfContains($haystack, $needle) {
		return strpos ( $haystack, $needle ) !== FALSE;
	}
	
	public static function checkIfContainsCaseInsensitive($haystack, $needle) {
		return stripos ( $haystack, $needle ) !== FALSE;
	}
	
	public static function checkIfStartsWith($haystack, $needle) {
		return strpos ( $haystack, $needle ) === 0;
	}
	
	public static function checkIfStartsWithOneOf($haystack, $needles) {
		if (is_array ( $needles )) {
			foreach ( $needles as $needle ) {
				if (strpos ( $haystack, $needle ) === 0) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	const WORST_MATCH = 7;

}

?>