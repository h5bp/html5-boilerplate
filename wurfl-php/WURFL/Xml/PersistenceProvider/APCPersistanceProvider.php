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
class WURFL_Xml_PersistenceProvider_APCPersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {
	
	const EXTENSION_MODULE_NAME = "apc";
	
	protected $persistenceIdentifier = "APC_PERSISTENCE_PROVIDER";
	
	public function __construct() {
	}
	
	public function initialize() {
		$this->_ensureModuleExistance ();
	}
	
	public function save($objectId, $object) {
		return apc_store ( $this->encode ( $objectId ), $object );
	}
	
	public function find($objectId) {
		return apc_fetch ( $this->encode ( $objectId ) );
	}
	
	public function getAllData() {
	}
	
	public function cleanAllData() {
	
	}
	
	/**
	 * Ensures the existance of the the PHP Extension apc
	 *
	 */
	private function _ensureModuleExistance() {
		if (! extension_loaded ( self::EXTENSION_MODULE_NAME )) {
			throw new WURFL_Xml_PersistenceProvider_Exception ( "The PHP extension apc must be installed and loaded in order to use the Memcached." );
		}
	}

}