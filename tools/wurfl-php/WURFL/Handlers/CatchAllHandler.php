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
 * CatchAllUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Handlers_CatchAllHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "CATCH_ALL";
	const MOZILLA_TOLLERACE = 4;
	
	const MOZILLA5 = "CATCH_ALL_MOZILLA5";
	const MOZILLA4 = "CATCH_ALL_MOZILLA4";
	
	private $mozilla4UserAgentsWithDeviceID = array ();
	private $mozilla5UserAgentsWithDeviceID = array ();
	
	public function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Final Interceptor: Intercept
	 * Everything that has not been trapped by a previous handler
	 *
	 * @param string $userAgent
	 * @return boolean always true
	 */
	function canHandle($userAgent) {
		return true;
	}
	
	/**
	 * If UA starts with Mozilla, apply LD with tollerance 5.
	 * If UA does not start with Mozilla, apply RIS on FS
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyConclusiveMatch($userAgent) {
		
		$deviceId = WURFL_Constants::GENERIC;
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Mozilla" )) {
			$deviceId = $this->applyMozillaConclusiveMatch ( $userAgent );
		} else {
			$tollerance = WURFL_Handlers_Utils::firstSlash ( $userAgent );
			$match = WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tollerance );
			$deviceId = $this->userAgentsWithDeviceID [$match];
		}
		
		return $deviceId;
	}
	
	private function applyMozillaConclusiveMatch($userAgent) {
		if ($this->isMozilla5 ( $userAgent )) {
			return $this->applyMozilla5ConclusiveMatch ( $userAgent );
		}
		
		if ($this->isMozilla4 ( $userAgent )) {
			return $this->applyMozilla4ConclusiveMatch ( $userAgent );
		}
		
		$this->logger->log ( "Applying Catch All Conclusive Match for ua: $userAgent" );
		$match = WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::MOZILLA_TOLLERACE );
		return $this->userAgentsWithDeviceID [$match];
	
	}
	
	private function applyMozilla5ConclusiveMatch($userAgent) {
		$this->logger->log ( "Applying Catch All Conclusive Match Mozilla 5 (LD with treshold of )for ua: $userAgent" );
		$this->mozilla5UserAgentsWithDeviceID = $this->persistenceProvider->load ( self::MOZILLA5 );
		
		if (! array_key_exists ( $userAgent, $this->mozilla5UserAgentsWithDeviceID )) {
			$match = WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->mozilla5UserAgentsWithDeviceID ), $userAgent, self::MOZILLA_TOLLERACE );
		}
		
		if (! empty ( $match )) {
			return $this->mozilla5UserAgentsWithDeviceID [$match];
		}
		
		return NULL;
	}
	
	private function applyMozilla4ConclusiveMatch($userAgent) {
		$this->logger->log ( "Applying Catch All Conclusive Match Mozilla 4 for ua: $userAgent" );
		$this->mozilla4UserAgentsWithDeviceID = $this->persistenceProvider->load ( self::MOZILLA4 );
		if (! array_key_exists ( $userAgent, $this->mozilla4UserAgentsWithDeviceID )) {
			$match = WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->mozilla4UserAgentsWithDeviceID ), $userAgent, self::MOZILLA_TOLLERACE );
		}
		
		if (! empty ( $match )) {
			return $this->mozilla4UserAgentsWithDeviceID [$match];
		}
		
		return NULL;
	}
	
	function filter($userAgent, $deviceID) {
		if ($this->isMozilla4 ( $userAgent )) {
			$this->mozilla4UserAgentsWithDeviceID [$userAgent] = $deviceID;
		}
		if ($this->isMozilla5 ( $userAgent )) {
			$this->mozilla5UserAgentsWithDeviceID [$userAgent] = $deviceID;
		}
		parent::filter ( $userAgent, $deviceID );
	}
	
	function persistData() {
		ksort ( $this->mozilla4UserAgentsWithDeviceID );
		ksort ( $this->mozilla5UserAgentsWithDeviceID );
		$this->persistenceProvider->save ( self::MOZILLA4, $this->mozilla4UserAgentsWithDeviceID );
		$this->persistenceProvider->save ( self::MOZILLA5, $this->mozilla5UserAgentsWithDeviceID );
		parent::persistData ();
	}
	
	private function loadMozillaData() {
		$this->mozilla4UserAgentsWithDeviceID = $this->persistenceProvider->find ( WURFL_Handlers_CatchAllHandler::MOZILLA4 );
		$this->mozilla5UserAgentsWithDeviceID = $this->persistenceProvider->find ( WURFL_Handlers_CatchAllHandler::MOZILLA5 );
	}
	
	private function isMozilla5($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Mozilla/5" );
	}
	
	private function isMozilla4($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Mozilla/4" );
	}
	
	private function isMozilla($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Mozilla" );
	}

}

?>
