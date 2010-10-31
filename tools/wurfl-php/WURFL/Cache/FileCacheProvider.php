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
 * A Cache Provider that uses the File System as a storage
 *
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Cache_FileCacheProvider implements WURFL_Cache_CacheProvider {
	
	private $_cacheDir;
	
	const DIR = "dir";
	
	private $cacheIdentifier = "FILE_CACHE_PROVIDER";
	
	function __construct($params){
		if (is_array($params)) {
			if (!array_key_exists(self::DIR, $params)) {
				throw new WURFL_WURFLException("Specify a valid cache dir in the configuration file");
			}
			
			// Check if the directory exist and it is also write access
    		if (!is_writable($params[self::DIR])) {
				throw new WURFL_WURFLException("The diricetory specified <" . $params[self::DIR] . " > for the cache provider does not exist or it is not writable\n");	
    		}

    		$this->_cacheDir = $params[self::DIR] . DIRECTORY_SEPARATOR . $this->cacheIdentifier;
    		
    		WURFL_FileManager::createDir($this->_cacheDir);
		} 

	}
	
	public function get($key) {
		return WURFL_FileManager::fetch($key, $this->_cacheDir);
	}
	
	public function put($key, $value) {
		WURFL_FileManager::save($key, $value, $this->_cacheDir);
	}
	
	public function clear() {
		WURFL_FileManager::deleteContent($this->_cacheDir);
	}
	
	
	
}
?>