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
class WURFL_Cache_MysqlCacheProvider implements WURFL_Cache_CacheProvider {

	const EXTENSION_MODULE_NAME = "mysql";
	const DEFAULT_HOST = "localhost";
	const DEFAULT_USER = "";
	const DEFAULT_PASS = "";
	const DEFAULT_DB = "";
	const DEFAULT_TABLE = "wurfl_object_cache";
	const DEFAULT_PORT = 3306;
	const DEFAULT_KEYCOLUMN = "key";
	const DEFAULT_VALUECOLUMN = "value";
	
	
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
                      `key` varchar(255) collate latin1_general_ci NOT NULL,          
                      `value` mediumblob NOT NULL,                                    
                      `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,              
                      PRIMARY KEY  (`key`)                                            
                    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci";
			$success=mysql_query($sql,$this->_link);
			if (!$success) {
				throw new WURFL_Xml_PersistenceProvider_Exception("Table $this->_table missing in $this->_db (".mysql_error($this->_link).")");
			}
		} 
		
		if (is_resource($test)) mysql_free_result($test);
	}

	function get($key) {
		$key = mysql_escape_string($key);
		$sql="select `value` from `$this->_db`.`$this->_table` where `key`='$key'";
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

	function put($key, $value) {
		$value=mysql_escape_string(serialize($value));
		$key=mysql_escape_string($key);
		$sql = "delete from `$this->_db`.`$this->_table` where `key`='$key'";
		$success=mysql_query($sql,$this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)."deleting $key in $this->_db");
		}

		$sql="insert into `$this->_db`.`$this->_table` (`key`,`value`) VALUES ('$key','$value')";
		$success=mysql_query($sql,$this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)."setting $key in $this->_db");
		}
		return $success;
	}

	function clear() {
		
	}

	function close( ) {
		mysql_close($this->_link);
		$this->_link = null;
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