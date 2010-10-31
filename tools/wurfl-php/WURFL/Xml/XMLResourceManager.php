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
 * @deprecated
 */
class WURFL_Xml_XMLResourceManager {
	
	private $_fileManager = null;
	private $_config = null;
	private $_patchManager = null;
	
	// Parsers
	private $_wurflParser = null;
	private $_wurflPatchParser = null;
	
	private $devices;
	private $_userAgentsWithDeviceIDMap;
	private $_groupIDCapabilitiesMap = array ();
	
	private $_persistenceProvider;
	
	const WURFL_TIMEOUT = '600';
	const WURFL_MEMORY_LIMIT = '256M';
	const WURFL_LOADED = "WURFL_LOADED";
	const USER_AGENTS_WITH_DEVICE_ID_MAP = "USER_AGENTS_WITH_DEVICE_ID_MAP";
	const CAPABILITY_GROUP_MAP = "CAPABILITY_GROUP_MAP";
	const GROUP_ID_CAPABILTIIES_MAP = "GROUP_ID_CAPABILTIIES_MAP";
	
	private $_logger;
	
	/**
	 * Initializes the XMLResourcesManager
	 *
	 * @param WURFL_Xml_PersistenceProvider $persistenceProvider
	 * @param WURFL_Xml_PatchManager $patchManager
	 * @param WURFL_Xml_WURFLFileParser $wurflParser
	 * @param WURFL_Xml_WURFLPatchFileParser $wurflPatchParser
	 */
	function __construct(WURFL_Xml_PersistenceProvider $persistenceProvider, WURFL_Xml_PatchManager $patchManager, WURFL_Xml_WURFLFileParser $wurflParser, WURFL_Xml_WURFLPatchFileParser $wurflPatchParser) {
		$this->_config = WURFL_Configuration_ConfigHolder::getWURFLConfig ();
		$this->_patchManager = $patchManager;
		
		$this->_wurflParser = $wurflParser;
		$this->_wurflPatchParser = $wurflPatchParser;
		
		$this->_persistenceProvider = $persistenceProvider;
		
		$this->init ();
	}
	
	/**
	 * Returns an associative array containing <userAgent, deviceID>
	 *
	 * @return array
	 */
	public function getUserAgentsWithDeviceID() {
		
		if (is_array ( $this->_userAgentsWithDeviceIDMap )) {
			return $this->_userAgentsWithDeviceIDMap;
		}
		
		return $this->_persistenceProvider->load ( WURFL_Xml_XMLResourceManager::USER_AGENTS_WITH_DEVICE_ID_MAP );
	}
	
	/**
	 * Returns an associative array containing <groupID, capabilities>
	 *
	 * @return array
	 */
	public function getGroupIDCapabilitiesMap() {
		return $this->_persistenceProvider->load ( WURFL_Xml_XMLResourceManager::GROUP_ID_CAPABILTIIES_MAP );
	}
	
	//*************************** PRIVATE **********************
	private function init() {
		
		$this->_logger = WURFL_Logger_LoggerFactory::create();
		
		$this->_logger->info ( "START: WURFL LOADING PROCESS: " );
		if (! $this->isWURFLLoaded ()) {
			set_time_limit ( WURFL_Xml_XMLResourceManager::WURFL_TIMEOUT );

			$memRequired = WURFL_WURFLUtils::return_bytes ( WURFL_Xml_XMLResourceManager::WURFL_MEMORY_LIMIT );
			$memAvailable = ini_get ( 'memory_limit' );
			if ( !$memAvailable || $memAvailable < $memRequired ) {
				ini_set ( 'memory_limit', WURFL_Xml_XMLResourceManager::WURFL_MEMORY_LIMIT );
			}
			
			$wurflFile = $this->_config->wurflFile;
			$wurflFile = WURFL_Xml_Utils::getXMLFile ( $wurflFile );
			
			$devicesMap = $this->_wurflParser->parse ( $wurflFile );
			
			WURFL_Xml_WURFLConsistencyVerifier::verify ( $devicesMap);
						
			$devicesMap = $this->applyPatches ( $devicesMap );
			
			$this->_logger->info ( "START: PERSISTING DEVICES" );
			$this->updateAndSaveDataStuctures ( $devicesMap );
			$this->setWURFLLoaded ();
			$this->_logger->info ( "END: PERSISTING DEVICES" );
		}
		$this->_logger->info ( "END: WURFL LOADING PROCESS" );
	}
	
	private function applyPatches($devicesMap) {
		if (is_array ( $this->_config->wurflPatches )) {
			foreach ( $this->_config->wurflPatches as $wurflPatchFile ) {
				if (isset ( $wurflPatchFile )) {
					$devicesMap = $this->applyPatch ( $devicesMap, $wurflPatchFile );
					WURFL_Xml_WURFLConsistencyVerifier::verify ( $devicesMap );
				}
			}
		}
		
		return $devicesMap;
	}
	
	private function applyPatch($devicesMap, $wurflPatchFile) {
		$wurflPatchFile = WURFL_Xml_Utils::getXMLFile ( $wurflPatchFile );
		$patchDevicesMap = $this->_wurflPatchParser->parse ( $wurflPatchFile );
		$devicesMap = $this->_patchManager->applyPatch ( $devicesMap, $patchDevicesMap );
		return $devicesMap;
	}
	

	
	private function isFallBackDefined(&$devicesMap, $device) {
		if (! $this->isGeneric ( $device->id )) {
			if (! array_key_exists ( $device->fallBack, $devicesMap )) {
				throw new WURFL_WURFLException ( "Fall Back : " . $device->fallBack . " is not defined for device : " . $device->id );
			}
		}
	
	}
	
	private function updateAndSaveDataStuctures($devicesMap) {
		
		$genericDevice = $devicesMap["generic"];
		
		foreach ( $devicesMap as $deviceID => $device ) {
			$this->_userAgentsWithDeviceIDMap [$device->userAgent] = $deviceID;
			$this->_persistenceProvider->save ( $deviceID, $device );
		}
		
		$this->_persistenceProvider->save ( WURFL_Xml_XMLResourceManager::USER_AGENTS_WITH_DEVICE_ID_MAP, $this->_userAgentsWithDeviceIDMap );
		$this->_persistenceProvider->save ( WURFL_Xml_XMLResourceManager::GROUP_ID_CAPABILTIIES_MAP, $genericDevice->groupIdCapabilitiesNameMap );
	
	}
	
	private function isWURFLLoaded() {
		return $this->_persistenceProvider->isWURFLLoaded ( self::WURFL_LOADED );
	}
	
	private function setWURFLLoaded() {
		$this->_persistenceProvider->setWURFLLoaded ( self::WURFL_LOADED );
	}
	
	private function isGeneric($deviceID) {
		if (strcmp ( $deviceID, WURFL_Constants::GENERIC ) === 0) {
			return true;
		}
		return false;
	}

} // end of class


?>