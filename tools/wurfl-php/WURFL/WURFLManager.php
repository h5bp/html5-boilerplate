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
class WURFL_WURFLManager {
	
	private $_wurflService;
	private $_requestFactory;
	
	public function __construct(WURFL_WURFLService $wurflService, WURFL_Request_GenericRequestFactory $requestFactory) {
		$this->_wurflService = $wurflService;
		$this->_requestFactory = $requestFactory;
	}
	
	/**
	 * Return the version of the underlying wurfl xml file
	 * @return WURFL_Xml_Info 
	 */
	public function getWURFLInfo() {
		return $this->_wurflService->getWURFLInfo ();
	}
	
	/**
	 * Return a device the given WURFL_Request_GenericRequest request(user-agent..)
	 *
	 * @param WURFL_Request_GenericRequest $request
	 * @return WURFL_Xml_ModelDevice
	 * @throws Exception if the $request parameter is not set
	 */
	function getDeviceForRequest(WURFL_Request_GenericRequest $request) {
		if (! isset ( $request )) {
			throw new Exception ( "The request parameter must be set." );
		}
		return $this->_wurflService->getDeviceForRequest ( $request );
	}
	
	/**
	 * Return a device for the given http request(user-agent..)
	 *
	 * @param _SERVER $request
	 * @return WURFL_Xml_ModelDevice device
	 * @throws Exception if $httpRequest is not set
	 */
	function getDeviceForHttpRequest($httpRequest) {
		if (! isset ( $httpRequest )) {
			throw new Exception ( "The $httpRequest parameter must be set." );
		}
		$request = $this->_requestFactory->createRequest ( $httpRequest );
		return $this->getDeviceForRequest ( $request );
	}
	
	/**
	 * Returns a device for the given user-agent
	 *
	 * @param string $userAgent
	 * @return WURFL_Device device
	 * @throws Exception if $userAgent is not set
	 */
	function getDeviceForUserAgent($userAgent) {
		if (! isset ( $userAgent )) {
			throw new Exception ( "The $userAgent parameter must be set" );
		}
		
		$request = $this->_requestFactory->createRequestForUserAgent ( $userAgent );
		return $this->getDeviceForRequest ( $request );
	}
	
	/**
	 * Return a device for the given device id
	 *
	 * @param string $deviceID
	 * @return WURFL_Device
	 */
	public function getDevice($deviceID) {
		return $this->_wurflService->getDevice ( $deviceID );
	}
	
	/**
	 * Returns an array of all wurfl group ids
	 *
	 * @return array
	 */
	public function getListOfGroups() {
		return $this->_wurflService->getListOfGroups ();
	}
	
	/**
	 * return all capability names for the given group id
	 *
	 * @param string $groupID
	 * @return array
	 */
	public function getCapabilitiesNameForGroup($groupID) {
		return $this->_wurflService->getCapabilitiesNameForGroup ( $groupID );
	}
	
	/**
	 * Returns an array of all the fall back devices starting from
	 * the given device
	 *
	 * @param string $deviceID
	 * @return array
	 */
	public function getFallBackDevices($deviceID) {
		return $this->_wurflService->getDeviceHierarchy ( $deviceID );
	}
	
	/**
	 * Returns all the devices id in wurfl
	 *
	 * @return array
	 */
	public function getAllDevicesID() {
		return $this->_wurflService->getAllDevicesID ();
	}

}

?>