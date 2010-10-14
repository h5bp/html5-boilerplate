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
 * @package    WURFL_Xml_PersistenceProvider
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Xml_PersistenceProvider_MemcachePersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {

	const EXTENSION_MODULE_NAME = "memcache";
	const DEFAULT_HOST = "127.0.0.1";
	const DEFAULT_PORT = 11211;
	const DEFUALT_APPLICATION_KEY = "";
	
	protected $persistenceIdentifier = "MEMCACHE_PERSISTENCE_PROVIDER";
	
	private $_memcache;
	private $_host;
	private $_port;

	public function __construct($params) {
		if (is_array($params)) {
			$this->_host = isset($params["host"]) ? $params["host"] : self::DEFAULT_HOST;
			$this->_port = isset($params["port"]) ? $params["port"] : self::DEFAULT_PORT;
			$this->_applicationKey = isset($params["application_key"]) ? $params["application_key"] : self::DEFUALT_APPLICATION_KEY;						
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
	

	/**
	 * Saves the object.
	 *
	 * @param stting $objectId
	 * @param mixed $object
	 * @return
	 */
	public function save($objectId, $object) {
		return $this->_memcache->set($this->encode($objectId), $object);
	}

	public function load($objectId) {
		return $this->_memcache->get($this->encode($objectId));
	}

	
	public function clear() {
		$this->_memcache->flush();
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