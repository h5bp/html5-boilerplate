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


/**
 * EAcceleratorCacheProvider
 * 
 * An Implementation of the Cache using the eAccelerator cache
 * module.(http://eaccelerator.net/)
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Cache_EAcceleratorCacheProvider implements WURFL_Cache_CacheProvider {

	function get($key) {
		return eaccelerator_get($key);
	}

	function put($key, $value) {
		eaccelerator_put($key, $value);
	}
	
	function clear() {
	}
}

?>