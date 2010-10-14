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

/**
 * Abstract PersistenceProvider
 *
 * A Skeleton implementation of the PersistenceProvider Interface
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
abstract class WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider implements WURFL_Xml_PersistenceProvider {
	
	const APPLICATION_PREFIX = "WURFL_"; 
	protected $persistenceIdentifier;
	
	/**
     * Saves the object.
     *
     * @param string $objectId
     * @param mixed $object
     * @return 
     */
    public function save($objectId, $object) {}
	
    /**
     * Returns the object identified by $objectId
     *
     * @param string $objectId
     */
    public function load($objectId){}

    
    /**
     * Removes from the persistence provider the
     * object identified by $objectId
     *
     * @param string $objectId
     */
    public function remove($objectId){}


    /**
     * Removes all entry from the Persistence Provider
     *
     */
    public function clear(){}
    
    
    /**
     * Checks if WURFL is Loaded
     *
     * @return boolean
     */
 	public function isWURFLLoaded() {
        return $this->load(WURFL_Xml_XMLResourceManager::WURFL_LOADED);
    }
	
    /**
     * Sets a flag
     *
     * @return 
     */
    public function setWURFLLoaded($loaded=TRUE) {
        $this->save(WURFL_Xml_XMLResourceManager::WURFL_LOADED, $loaded);
    }
	
	/**
	 * Encode the Object Id using the Persistence Identifier
	 *
	 * @param string $input
	 */
	protected function encode($input) {
		return self::APPLICATION_PREFIX . $this->persistenceIdentifier . "_" . $input;  	
	}
	
	/**
	 * Decode the Object Id
	 *
	 * @param unknown_type $input
	 */
	protected function decode($input) {
		return substr($input, sizeof(self::APPLICATION_PREFIX . $this->persistenceIdentifier));
	}
	
	
	
	
}
?>