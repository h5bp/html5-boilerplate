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
 * @package    WURFL_Logger
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Logger_NullLogger implements WURFL_Logger_Interface  {
	
	function log($message) {
		//echo $message . "\n";
	}
	
	function debug($message) {
		//echo $message . "\n";		
	}
	
	function info($message){}
}

?>