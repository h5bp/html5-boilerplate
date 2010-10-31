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


class WURFL_Cache_CacheProviderFactory  {

	const DEFAULT_CACHE_PROVIDER_NAME = "file";

	private static $_cacheProviders = array();

	// prevent instantiation
	private function __construct(){}
	private function __clone(){}

	
	/**
	 * Returns A CacheProvider
	 *
	 * @return CacheProvider
	 */
	public static function getCacheProvider($cacheConfig=null) {
		$cache = is_null($cacheConfig) ? WURFL_Configuration_ConfigHolder::getWURFLConfig()->cache : $cacheConfig;
		$provider = isset($cache["provider"]) ? $cache["provider"] : null;
		
		switch ($provider) {
			case WURFL_Constants::FILE:
				self::$_cacheProvider = new WURFL_Cache_FileCacheProvider($cache);
				break;
			case WURFL_Constants::MEMCACHE:
				self::$_cacheProvider = new WURFL_Cache_MemcacheCacheProvider($cache);
				break;
			case WURFL_Constants::APC:
				self::$_cacheProvider = new WURFL_Cache_APCCacheProvider($cache);
				break;
			case WURFL_Constants::EACCELERATOR:
				self::$_cacheProvider = new WURFL_Cache_EAcceleratorCacheProvider($cache);
				break;
			case WURFL_Constants::MYSQL:
				self::$_cacheProvider = new WURFL_Cache_MysqlCacheProvider($cache);
				break;
			default:
				self::$_cacheProvider = new WURFL_Cache_NullCacheProvider();
				break;
		}


		return self::$_cacheProvider;
	}

	const FILE_CACHE_PROVIDER_DIR = "devices";
	private static $_cacheProvider;
}

?>