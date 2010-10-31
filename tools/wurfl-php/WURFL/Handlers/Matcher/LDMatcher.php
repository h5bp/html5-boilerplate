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
 * @package    WURFL_Handlers_Matcher
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Handlers_Matcher_LDMatcher implements WURFL_Handlers_Matcher_Interface {
	
	private static $instance;
	
	private function __construct() {
	}
	
	public static function INSTANCE() {
		if (self::$instance === null) {
			self::$instance = new self ( );
		}
		return self::$instance;
	}
	
	/**
	 * Search through the collection of strings
	 * to find one with distance smaller than the
	 * given one
	 *
	 * @param array $collection
	 * @param string $needle
	 * @param int $tollerance
	 * @return string
	 */
	public function match(&$collection, $needle, $tollerance) {
		
		$best = $tollerance;
		$match = '';
		foreach ( $collection as $userAgent ) {
			if (abs ( strlen ( $needle ) - strlen ( $userAgent ) ) <= $tollerance) {
				//$current = $this->levenshtein ( $needle, $userAgent, $tollerance );
				$current = levenshtein($needle, $userAgent);
				if ($current <= $best) {
					$best = $current - 1;
					$match = $userAgent;
				}
			}
		}
		
		return $match;
	
	}
	
	function levenshtein($s, $t, $tollerance) {
		$m = strlen ( $s );
		$n = strlen ( $t );
		
		for($i = 0; $i <= $m; $i ++)
			$d [$i] [0] = $i;
		for($j = 0; $j <= $n; $j ++)
			$d [0] [$j] = $j;
		
		for($i = 1; $i <= $m; $i ++) {
			for($j = 1; $j <= $n; $j ++) {
				$c = ($s [$i - 1] == $t [$j - 1]) ? 0 : 1;
				$d [$i] [$j] = min ( $d [$i - 1] [$j] + 1, $d [$i] [$j - 1] + 1, $d [$i - 1] [$j - 1] + $c );
				if ($i == $j && $d [$i] [$j] > ($tollerance + 3)) {
					return $d [$i] [$j];
				}
			}
		}
		
		return $d [$m] [$n];
	}
	
/*	private function levenshtein($s, $t, $tollerance) {
		$n = strlen($s);
		$m = strlen($t);
		
		
                if (n == 0) {
                        return m;
                } else if (m == 0) {
                        return n;
                }

                
                $p = array();
                $d = array();
                $_d = array();
                
                //int p[] = new int[n + 1]; // 'previous' cost array, horizontally
                //int d[] = new int[n + 1]; // cost array, horizontally
                //int _d[]; // placeholder to assist in swapping p and d

                // indexes into strings s and t
                $i; // iterates through s
                $j; // iterates through t

                $t_j; // jth character of t

                $cost; // cost

                for ($i = 0; $i <= $n; $i++) {
                        $p[$i] = $i;
                }

                for ($j = 1; $j <= $m; $j++) {
                        $t_j =  strpos($t,) $t.charAt(j - 1);
                        $d[0] = j;

                        for ($i = 1; $i <= $n; $i++) {
                                cost = s.charAt(i - 1) == t_j ? 0 : 1;
                                // minimum of cell to the left+1, to the top+1, diagonally left
                                // and up +cost
                                $d[$i] = Math.min(Math.min(d[i - 1] + 1, p[i] + 1), p[i - 1]
                                                + cost);

                                // Performance check
                                if ($i == $j && $d[i] > (tollerance + 3)) {
                                        return d[i];
                                }

                        }

                        // copy current distance counts to 'previous row' distance counts
                        $_d = $p;
                        $p = $d;
                        $d = $_d;
                }
		
	}*/

}

?>