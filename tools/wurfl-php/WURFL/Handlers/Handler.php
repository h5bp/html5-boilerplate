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
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * UserAgentHandler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
abstract class WURFL_Handlers_Handler implements WURFL_Handlers_Filter, WURFL_Handlers_Matcher {
	
	private $nextHandler;
	
	private $userAgentNormalizer;
	
	protected $prefix;
	
	protected $userAgentsWithDeviceID;
	
	protected $persistenceProvider;
	
	// Log
	protected $logger;
	protected $undetectedDeviceLogger;
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		
		if (is_null ( $userAgentNormalizer )) {
			$this->userAgentNormalizer = new WURFL_Request_UserAgentNormalizer_Null ();
		} else {
			$this->userAgentNormalizer = $userAgentNormalizer;
		}
		$this->logger = $wurflContext->logger;
		//$this->undtectedDeviceLogger = $wurflContext->undetectedDeviceLogger;
		

		$this->persistenceProvider = $wurflContext->persistenceProvider;
	}
	
	/**
	 * Sets the next Handler
	 *
	 * @param WURFL_Handlers_UserAgentHandler $handler
	 */
	public function setNextHandler($handler) {
		$this->nextHandler = $handler;
	}
	
	public function getName() {
		return $this->getPrefix ();
	}
	
	abstract function canHandle($userAgent);
	
	//********************************************************
	//
	//     Classification of the User Agents
	//
	//********************************************************
	/**
	 *
	 * @param string $userAgent
	 * @param string $deviceID
	 */
	function filter($userAgent, $deviceID) {
		if ($this->canHandle ( $userAgent )) {
			$this->updateUserAgentsWithDeviceIDMap ( $userAgent, $deviceID );
			return;
		}
		if (isset ( $this->nextHandler )) {
			return $this->nextHandler->filter ( $userAgent, $deviceID );
		}
	}
	
	/**
	 * Updates the map containing the classified user agents
	 * Before adding the user agent to the map it normalizes by using the normalizeUserAgent
	 * function.
	 *
	 * If you need to normalize the user agent you need to override the funcion in
	 * the speficific user agent handler
	 *
	 *
	 * @param string $userAgent
	 * @param string $deviceID
	 */
	final function updateUserAgentsWithDeviceIDMap($userAgent, $deviceID) {
		$this->userAgentsWithDeviceID [$this->normalizeUserAgent ( $userAgent )] = $deviceID;
	}
	
	public function normalizeUserAgent($userAgent) {
		return $this->userAgentNormalizer->normalize ( $userAgent );
	}
	
	//********************************************************
	//	Persisting The classified user agents
	//
	//********************************************************
	/**
	 * Persists the classified user agents on the filesystem
	 *
	 */
	function persistData() {
		// we sort the array first, useful for doing ris match
		if (! empty ( $this->userAgentsWithDeviceID )) {
			ksort ( $this->userAgentsWithDeviceID );
			$this->persistenceProvider->save ( $this->getPrefix (), $this->userAgentsWithDeviceID );
		}
	}
	
	function getUserAgentsWithDeviceId() {
		if (! isset ( $this->userAgentsWithDeviceID )) {
			$this->userAgentsWithDeviceID = $this->persistenceProvider->load ( $this->getPrefix () );
		}
		return $this->userAgentsWithDeviceID;
	}
	
	//********************************************************
	//	Matching
	//
	//********************************************************
	/**
	 * Finds the device id for the given request.
	 * if it is not found it delegates to the next available handler
	 *
	 *
	 * @param WURFL_GenericRequest $request
	 * @return string
	 */
	public function match(WURFL_Request_GenericRequest $request) {
		$userAgent = $request->userAgent;
		if ($this->canHandle ( $userAgent )) {
			return $this->applyMatch ( $request );
		}
		
		if (isset ( $this->nextHandler )) {
			return $this->nextHandler->match ( $request );
		}
		
		return WURFL_Constants::GENERIC;
	}
	
	/**
	 * Template method
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyMatch(WURFL_Request_GenericRequest $request) {
		$userAgent = $request->userAgent;
		$this->logger->debug ( "START: Matching For  " . $userAgent );
		
		// Get The data associated with this current handler
		$this->userAgentsWithDeviceID = $this->persistenceProvider->load ( $this->getPrefix () );
		if (! is_array ( $this->userAgentsWithDeviceID )) {
			$this->userAgentsWithDeviceID = array ();
		}
		$deviceID = NULL;
		// we start with direct match
		if (array_key_exists ( $userAgent, $this->userAgentsWithDeviceID )) {
			return $this->userAgentsWithDeviceID [$userAgent];
		}
		
		// Try with the conclusive Match
		$this->logger->debug ( "$this->prefix :Applying Conclusive Match for ua: $userAgent" );
		$deviceID = $this->applyConclusiveMatch ( $userAgent );
		
		if ($this->isBlankOrGeneric($deviceID)) {
			// Log the ua and the ua profile
			//$this->logger->debug ( $request );
			$this->logger->debug ( "$this->prefix :Applying Recovery Match for ua: $userAgent" );
			$deviceID = $this->applyRecoveryMatch ( $userAgent );
		}
		// Try with catch all recovery Match
		if ($this->isBlankOrGeneric($deviceID)) {
			$this->logger->debug ( "$this->prefix :Applying Catch All Recovery Match for ua: $userAgent" );
			$deviceID = $this->applyRecoveryCatchAllMatch ( $userAgent );
		}
		
		if ($this->isBlankOrGeneric($deviceID)) {
			$deviceID = WURFL_Constants::GENERIC;
		}
		
		$this->logger->debug ( "END: Matching For  " . $userAgent );
		
		return $deviceID;
	}
	/**
	 * @param deviceID
	 */
	private function isBlankOrGeneric($deviceID) {
		return $deviceID == NULL || strcmp ( $deviceID, "generic" ) === 0 || strlen ( trim ( $deviceID ) ) == 0;
	}

	
	/**
	 
	 * @param string $userAgent
	 * @return string
	 */
	function applyConclusiveMatch($userAgent) {
		$userAgent = $this->normalizeUserAgent ($userAgent );		
		$match = $this->lookForMatchingUserAgent ( $userAgent );
		
		if (! empty ( $match )) {
			return $this->userAgentsWithDeviceID [$match];
		}
		
		return NULL;
	
	}
	
	/**
	 * Override this method to give an alternative way to do the matching
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
		$tollerance = WURFL_Handlers_Utils::firstSlash ( $userAgent );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tollerance );
	}
	
	protected function applyRisWithTollerance($userAgetsList, $target, $tollerance) {
		return WURFL_Handlers_Utils::risMatch ( $userAgetsList, $target, $tollerance );
	}
	
	/**
	 * Applies Recovery Match
	 *
	 * @param string $userAgent
	 */
	function applyRecoveryMatch($userAgent) {
	}
	
	function applyRecoveryCatchAllMatch($userAgent) {
		
		//Openwave
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/7.2" )) {
			return "opwv_v72_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/7" )) {
			return "opwv_v7_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/6.2" )) {
			return "opwv_v62_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/6.1" )) {
			return "opwv_v6_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/6" )) {
			return "opwv_v6_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/5" )) {
			return "upgui_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/4" )) {
			return "uptext_generic";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "UP.Browser/3" )) {
			return "uptext_generic";
		}
		
		//Series 60
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Series60" )) {
			return "nokia_generic_series60";
		}
		
		// Access/Net Front
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "NetFront/3.0" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "ACS-NF/3.0" )) {
			return "netfront_ver3";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "NetFront/3.1" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "ACS-NF/3.1" )) {
			return "netfront_ver3_1";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "NetFront/3.2" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "ACS-NF/3.2" )) {
			return "netfront_ver3_2";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "NetFront/3.3" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "ACS-NF/3.3" )) {
			return "netfront_ver3_3";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "NetFront/3.4" )) {
			return "netfront_ver3_4";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "NetFront/3.5" )) {
			return "netfront_ver3_5";
		}
		
		//Windows CE
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Windows CE" )) {
			return "ms_mobile_browser_ver1";
		}
		
		/**
		 * Teleca-Obigo Browser
		 */
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "ObigoInternetBrowser/Q03C" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "AU-MIC/2" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "AU-MIC-" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "AU-OBIGO/" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Obigo/Q03" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Obigo/Q04" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "ObigoInternetBrowser/2" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Teleca Q03B1" )) {
			return WURFL_Constants::GENERIC_XHTML;
		}
		
		//web browsers?
		$mozzilas = array ("Mozilla/4", "Mozilla/5", "Mozilla/6" );
		if (WURFL_Handlers_Utils::checkIfStartsWithOneOf ( $userAgent, $mozzilas )) {
			return "generic_web_browser";
		}
		
		/**
		 * Mozilla of some kind
		 */
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Mozilla" )) {
			return WURFL_Constants::GENERIC_XHTML;
		}
		
		// DoCoMo
		if ((strpos ( $userAgent, "DoCoMo" ) === 0) || (strpos ( $userAgent, "KDDI" ) === 0)) {
			return "docomo_generic_jap_ver1";
		}
		
		return WURFL_Constants::GENERIC;
	}
	
	public function getPrefix() {
		return $this->prefix . "_DEVICEIDS";
	}

}

?>