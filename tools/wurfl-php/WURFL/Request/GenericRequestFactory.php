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
 * @package    WURFL_Request
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Request_GenericRequestFactory {

	private $_userAgentNormalizer;
	
	function __construct(WURFL_Request_UserAgentNormalizer $userAgentNormalizer ) {
		$this->_userAgentNormalizer = $userAgentNormalizer;
		$this->_init();
	}

	/**
	 * Creates GenericRequest Object from
	 * a $_SERVER object
	 *
	 * @param $_SERVER $request
	 * @return GenericRequest
	 */
	public function createRequest($request) {
		$userAgent = WURFL_WURFLUtils::getUserAgent($request);
		$this->checkUserAgent($userAgent);
		
		$userAgent = $this->_userAgentNormalizer->normalize($userAgent);
		$userAgentProfile = WURFL_WURFLUtils::getUserAgentProfile($request);
		$isXhtmlDevice = WURFL_WURFLUtils::isXhtmlRequester($request);

		return new WURFL_Request_GenericRequest($userAgent, $userAgentProfile, $isXhtmlDevice);

	}

	public function createRequestForUserAgent($userAgent) {
		$this->checkUserAgent($userAgent);
		$userAgent = $this->_userAgentNormalizer->normalize($userAgent);
		return new WURFL_Request_GenericRequest($userAgent, null, false);
	}


	private function checkUserAgent($userAgent) {
		if (!isset($userAgent) || is_null($userAgent) || empty($userAgent)) {
			throw new WURFL_WURFLException("can't find user agent string in the request");
		}
	}

	private function _init() {
		$this->_userAgentNormalizer->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Vodafone());
		$this->_userAgentNormalizer->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_UPLink());
		$this->_userAgentNormalizer->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_BlackBerry());
		$this->_userAgentNormalizer->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_YesWAP());
		$this->_userAgentNormalizer->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_BabelFish());
		
	}

	
}


?>