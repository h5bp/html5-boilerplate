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
 * @package    WURFL_Xml
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
interface WURFL_Xml_PersistenceProvider {
	/**
	 * Saves the object 
	 *
	 * @param string $objectId
	 * @param mixed $object
	 */
    public function save($objectId, $object);

    
    /**
     * Loads the object identified by the objectId from the persistence
     * provider
     *
     * @param string $objectId
     */
    public function load($objectId);
	
    
    /**
     * Removes the element form the Persistence identified by the object Id
     *
     * @param string $objectId
     */
    public function remove($objectId);
    
    /**
     * Removes all of entries from the persistace provider.
     *
     */
    public function clear();
    
    
    public function isWURFLLoaded();

    public function setWURFLLoaded();

}