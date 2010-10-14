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
 * MemcacheCacheProvider
 *
 * An Implementation of the Cache using memcache module.(http://uk3.php.net/memcache.)
 *
 * @category   WURFL
 * @package    WURFL_Cache
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Cache_MemcacheCacheProvider implements WURFL_Cache_CacheProvider {

	const EXTENSION_MODULE_NAME = "memcache";
	const DEFAULT_HOST = "127.0.0.1";
	const DEFAULT_PORT = 11211;
	
	
	private $_memcache;
	private $_host;
	private $_port;

	public function __construct($params) {
		if (is_array($params)) {
			$this->_host = isset($params["host"]) ? $params["host"] : self::DEFAULT_HOST;
			$this->_port = isset($params["port"]) ? $params["port"] : self::DEFAULT_PORT;			
		}
		$this->initialize();
	}

	/**
	 * Initializes the Memcache Module
	 *
	 */
	public final function initialize() {
		$this->_ensureModuleExistance();
		$this->_memcache = new Memcache();
		$this->_memcache->connect($this->_host, $this->_port);
	}


	function get($key) {
		return $this->_memcache->get($key);
	}

	function put($key, $value) {
		$this->_memcache->set($key, $value);
	}

	function clear() {
	}

	function close( ) {
		$this->_memcache->close();
		$this->_memcache = null;
	}

	/**
	 * Ensures the existance of the the PHP Extension memcache
	 *
	 */
	private function _ensureModuleExistance() {
		if(!extension_loaded(self::EXTENSION_MODULE_NAME)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("The PHP extension memcache must be installed and loaded in order to use the Memcached.");
		}
	}
}
?>