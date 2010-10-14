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
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * This Class is reponsable for creating a WURFLManager instance
 * by instantiating and wiring together all the neccessary
 * objects. e.g. WURFL_Xml_XMLResourceManager, WURFL_DeviceRepository, etc.
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_WURFLManagerFactory {
	
	const DEBUG = FALSE;
	const WURFL_LAST_MODIFICATION_TIME = "WURFL_LAST_MODIFICATION_TIME";
	
	private $wurflConfig;
	private $wurflManager;
	
	public function __construct($wurflConfig) {
		$this->wurflConfig = $wurflConfig;
	}
	
	/**
	 * Creates a new WURFLManager Object
	 */
	public function create() {
		if ($this->hasToBeReloaded () || $this->wurflManager === NULL) {
			$this->init ();
		}
		return $this->wurflManager;
	}
	
	public function hasToBeReloaded() {
		if(!$this->wurflConfig->autoReload) {
			return false;
		}
		$persistenceProvider = self::persistenceProvider ( $this->wurflConfig->persistence );		
		$lastModificationTime = $persistenceProvider->load(self::WURFL_LAST_MODIFICATION_TIME);
		$currentModificationTime = filemtime($this->wurflConfig->wurflFile);
		if($currentModificationTime > $lastModificationTime) {
			$persistenceProvider->setWURFLLoaded(FALSE);
			$this->invalidateCache();
			return true;			
		}
		return false;
	}
	
	
	private function invalidateCache() {
		$cacheProvider = self::cacheProvider($this->wurflConfig->cache);
		$cacheProvider->clear();
	}
	
	public function remove() {
		$persistenceProvider = self::persistenceProvider ( $this->wurflConfig->persistence );
		$persistenceProvider->clear ();
		$this->wurflManager = NULL;
	}
		
	private function init() {
		$persistenceProvider = self::persistenceProvider ( $this->wurflConfig->persistence );
		$cacheProvider = self::cacheProvider ( $this->wurflConfig->cache );
		$logger = null; //$this->logger($wurflConfig->logger);
		

		$context = new WURFL_Context ( $persistenceProvider );
		$context = $context->cacheProvider ( $cacheProvider )->logger ( $logger );
		
		$userAgentHandlerChain = WURFL_UserAgentHandlerChainFactory::createFrom ( $context );
		$deviceRepository = $this->deviceRepository ( $persistenceProvider, $userAgentHandlerChain );
		$wurflService = new WURFL_WURFLService ( $deviceRepository, $userAgentHandlerChain, $cacheProvider );
		
		$userAgentNormalizer = new WURFL_Request_UserAgentNormalizer ();
		$requestFactory = new WURFL_Request_GenericRequestFactory ( $userAgentNormalizer );
		
		$this->wurflManager = new WURFL_WURFLManager ( $wurflService, $requestFactory );
		$persistenceProvider->save(self::WURFL_LAST_MODIFICATION_TIME, filemtime($this->wurflConfig->wurflFile));
	
	}
	
	private static function persistenceProvider($persistenceConfig) {
		return WURFL_Xml_PersistenceProvider_PersistenceProviderManager::getPersistenceProvider ( $persistenceConfig );
	}
	
	private static function cacheProvider($cacheConfig) {
		return WURFL_Cache_CacheProviderFactory::getCacheProvider ( $cacheConfig );
	}
	
	/**
	 * @param userAgentHandlerChain
	 */
	private function deviceRepository($persistenceProvider, $userAgentHandlerChain) {
		$devicePatcher = new WURFL_Xml_DevicePatcher ();
		$deviceRepositoryBuilder = new WURFL_DeviceRepositoryBuilder ( $persistenceProvider, $userAgentHandlerChain, $devicePatcher );
		$infoIterator = new WURFL_Xml_VersionIterator ( $this->wurflConfig->wurflFile );
		$deviceIterator = new WURFL_Xml_DeviceIterator ( $this->wurflConfig->wurflFile );
		$patchIterators = self::patchIterators ( $this->wurflConfig->wurflPatches );
		$deviceRepository = $deviceRepositoryBuilder->build ( $infoIterator, $deviceIterator, $patchIterators );
		return $deviceRepository;
	}
	
	private static function patchIterators($wurflPatches) {
		$patchIterators = array ();
		
		if (is_array ( $wurflPatches )) {
			foreach ( $wurflPatches as $wurflPatch ) {
				$patchIterators [] = new WURFL_Xml_DeviceIterator ( $wurflPatch );
			}
		}
		return $patchIterators;
	}

}

?>