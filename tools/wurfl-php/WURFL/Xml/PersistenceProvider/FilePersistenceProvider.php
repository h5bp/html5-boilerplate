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
class WURFL_Xml_PersistenceProvider_FilePersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {

    private $_persistenceDir;
    
    protected $persistenceIdentifier = "FILE_PERSISTENCE_PROVIDER";
    
    
    const DIR = "dir";
    
    public function __construct($params) {
    	$this->initialize($params);
    }
    
    /**
     * Initializes the Persistence Dir
     *
     * @param array of parameters for configuring the Persistence Provider
     */
    function initialize($params) {
    	if (is_array($params)) {
			if (!array_key_exists(self::DIR, $params)) {
				throw new WURFL_WURFLException("Specify a valid Persistence dir in the configuration file");
			}
			
			// Check if the directory exist and it is also write access
    		if (!is_writable($params[self::DIR])) {
				throw new WURFL_WURFLException("The diricetory specified <" . $params[self::DIR]. "> for the persistence provider does not exist or it is not writable\n");	
    		}

    		$this->_persistenceDir = $params[self::DIR] . DIRECTORY_SEPARATOR . $this->persistenceIdentifier;
    		
    		WURFL_FileManager::createDir($this->_persistenceDir);
		} 
    }

    /**
     * Saves the object on the file system
     * 
     *
     * @param string $objectId
     * @param mixed $object
     */
    public function save($objectId, $object) {
    	WURFL_FileManager::save($this->encode($objectId), $object, $this->_persistenceDir);
    }

    public function load($objectId) {
    	return WURFL_FileManager::fetch($this->encode($objectId), $this->_persistenceDir);
    }

    public function remove($objectId) {
    	return WURFL_FileManager::remove($this->encode($objectId), $this->_persistenceDir);
    }

    
    /**
     * Clears the persistence provider by removing the directory 
     *
     */
    public function clear() {
    	WURFL_FileManager::removeDir($this->_persistenceDir);
    }
}