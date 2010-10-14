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
class WURFL_Xml_PersistenceProvider_MysqlPersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {

	const EXTENSION_MODULE_NAME = "mysql";
	const DEFAULT_HOST = "localhost";
	const DEFAULT_USER = "";
	const DEFAULT_PASS = "";
	const DEFAULT_DB = "";
	const DEFAULT_TABLE = "wurfl_object_cache";
	const DEFAULT_PORT = 3306;
	const DEFAULT_KEYCOLUMN="key";
	const DEFAULT_VALUECOLUMN="value";
	
	protected $persistenceIdentifier = "MYSQL_PERSISTENCE_PROVIDER";
	
	private $_link;
	private $_host;
	private $_db;
	private $_user;
	private $_pass;
	private $_port;
	private $_table;
	private $_keycolumn;
	private $_valuecolumn;
	
	public function __construct($params) {
		if (is_array($params)) {
			$this->_host = isset($params["host"]) ? $params["host"] : self::DEFAULT_HOST;
			$this->_port = isset($params["port"]) ? $params["port"] : self::DEFAULT_PORT;
			$this->_user = isset($params["user"]) ? $params["user"] : self::DEFAULT_USER;
			$this->_pass = isset($params["pass"]) ? $params["pass"] : self::DEFAULT_PASS;
			$this->_db = isset($params["db"]) ? $params["db"] : self::DEFAULT_DB;			
			$this->_table = isset($params["table"]) ? $params["table"] : self::DEFAULT_TABLE;			
			$this->_keycolumn = isset($params["keycolumn"]) ? $params["keycolumn"] : self::DEFAULT_KEYCOLUMN;
			$this->_valuecolumn = isset($params["valuecolumn"]) ? $params["valuecolumn"] : self::DEFAULT_VALUECOLUMN;
		}
		$this->initialize();
	}

	/**
	 * Initializes the Memcache Module
	 *
	 */
	public final function initialize() {
		$this->_ensureModuleExistance();
		
		/* Initializes link to MySql */
		$this->_link = mysql_connect("$this->_host:$this->_port",$this->_user,$this->_pass);
		if (mysql_error($this->_link)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("Couldn't link to $this->_host (".mysql_error($this->_link).")");
		}
		
		/* Initializes link to database */
		$success=mysql_select_db($this->_db,$this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("Couldn't change to database $this->_db (".mysql_error($this->_link).")");
		}
		
		/* Is Table there? */
		$test = mysql_query("SHOW TABLES FROM $this->_db LIKE '$this->_table'",$this->_link);
		if (!is_resource($test)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("Couldn't show tables from database $this->_db (".mysql_error($this->_link).")");
		}
		
		// create table if it's not there.
		if (mysql_num_rows($test)==0) {
			$sql="CREATE TABLE `$this->_db`.`$this->_table` (                               
                      `$this->_keycolumn` varchar(255) collate latin1_general_ci NOT NULL,          
                      `$this->_valuecolumn` mediumblob NOT NULL,                                    
                      `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,              
                      PRIMARY KEY  (`$this->_keycolumn`)                                            
                    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci";
			$success=mysql_query($sql,$this->_link);
			if (!$success) {
				throw new WURFL_Xml_PersistenceProvider_Exception("Table $this->_table missing in $this->_db (".mysql_error($this->_link).")");
			}
		} 
		
		if (is_resource($test)) mysql_free_result($test);
	}	

	/**
	 * Saves the object.
	 *
	 * @param stting $objectId
	 * @param mixed $object
	 * @return
	 */
	public function save($objectId, $object) {
		$object=mysql_escape_string(serialize($object));
		$objectId=$this->encode($objectId);
		$objectId=mysql_escape_string($objectId);
		$sql = "delete from `$this->_db`.`$this->_table` where `$this->_keycolumn`='$objectId'";
		$success=mysql_query($sql,$this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)."deleting $objectId in $this->_db");
		}

		$sql="insert into `$this->_db`.`$this->_table` (`$this->_keycolumn`,`$this->_valuecolumn`) VALUES ('$objectId','$object')";
		$success=mysql_query($sql,$this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)."setting $objectId in $this->_db");
		}
		return $success;
	}

	public function load($objectId) {
		$objectId = $this->encode($objectId);
		$objectId = mysql_escape_string($objectId);
		
		$sql="select `$this->_valuecolumn` from `$this->_db`.`$this->_table` where `$this->_keycolumn`='$objectId'";
		$result=mysql_query($sql,$this->_link);
		if (!is_resource($result)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)."in $this->_db");
		}
		
		$row = mysql_fetch_assoc($result);
		if (is_array($row)) {
			$return = unserialize($row['value']);
		} else {
			$return=false;
		}
		if (is_resource($result)) mysql_free_result($result);
		return $return;
	}
	
	public function clear() {
		$sql = "truncate table `$this->db`.`$this->table`";
		$success=mysql_query($sql,$this->_link);
		if (mysql_error($this->_link)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)." clearing $this->_db.$this->_table");
		}
		return $success;
	}
	
	public function isWURFLLoaded() {
		return $this->load(WURFL_Xml_XMLResourceManager::WURFL_LOADED);
	}

	public function setWURFLLoaded() {
		return $this->save(WURFL_Xml_XMLResourceManager::WURFL_LOADED, TRUE);
	}


	/**
	 * Ensures the existance of the the PHP Extension memcache
	 *
	 */
	private function _ensureModuleExistance() {
		if(!extension_loaded(self::EXTENSION_MODULE_NAME)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("The PHP extension mysql must be installed and loaded in order to use the mysql.");
		}
	}

}