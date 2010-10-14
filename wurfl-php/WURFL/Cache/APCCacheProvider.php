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
class WURFL_Cache_APCCacheProvider implements WURFL_Cache_CacheProvider {
	
	const EXTENSION_MODULE_NAME = "apc";
	
	/**
	 *
	 * @param array $params
	 */
	public function __construct($params=null) {
		$this->_ensureModuleExistance();
	}
	
	function get($key) {
		return apc_fetch($key);
	}

	function put($key, $value) {
		apc_store($key, $value);
	}
	
	function clear() {
	}
	
 	/* 
 	 * Ensures the existance of the the PHP Extension apc
	 *
	 */
	private function _ensureModuleExistance() {
		if(!extension_loaded(self::EXTENSION_MODULE_NAME)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("The PHP extension apc must be installed and loaded in order to use this cache provider");
		}
	}
}

?>