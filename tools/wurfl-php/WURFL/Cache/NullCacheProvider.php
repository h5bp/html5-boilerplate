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
 * @package    WURFL_Cache
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Cache_NullCacheProvider implements WURFL_Cache_CacheProvider  {
	
	
	public function get($key) {
		return NULL;
	}
	
	public function put($key, $value) {
	}
	
	public function clear() {
	}
	
	
}

?>