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
class WURFL_WURFLService {
	
	private $_deviceRepository;
	private $_userAgentHandlerChain;
	private $_cacheProvider;
	
	public function __construct(WURFL_DeviceRepository $deviceRepository, WURFL_UserAgentHandlerChain $userAgentHandlerChain, WURFL_Cache_CacheProvider $cacheProvider) {
		$this->_deviceRepository = $deviceRepository;
		$this->_userAgentHandlerChain = $userAgentHandlerChain;
		$this->_cacheProvider = $cacheProvider;
	}
	
	/**
	 * Returns the WURFL XML Info
	 */
	public function getWURFLInfo() {
		return $this->_deviceRepository->getWURFLInfo ();
	}
	
	/**
	 * Returns the Device for the given WURFL_Request_GenericRequest
	 *
	 * @param WURFL_Request_GenericRequest $request
	 * @return WURFL_Device
	 */
	public function getDeviceForRequest(WURFL_Request_GenericRequest $request) {
		$deviceId = $this->deviceIdForRequest ( $request );
		return $this->getWrappedDevice ( $deviceId );
	
	}
	
	/**
	 * Retun a WURFL_Xml_ModelDevice for the given device id
	 *
	 * @param string $deviceID
	 * @return WURFL_Xml_ModelDevice
	 */
	public function getDevice($deviceID) {
		return $this->getWrappedDevice ( $deviceID );
	}
	
	/**
	 * Returns all devices ID present in WURFL
	 *
	 * @return array of strings
	 */
	public function getAllDevicesID() {
		return $this->_deviceRepository->getAllDevicesID ();
	}
	
	/**
	 * Returns an array of all the fall back devices starting from
	 * the given device
	 *
	 * @param string $deviceID
	 * @return array
	 */
	public function getDeviceHierarchy($deviceID) {
		return $this->_deviceRepository->getDeviceHierarchy ( $deviceID );
	}
	
	public function getListOfGroups() {
		return $this->_deviceRepository->getListOfGroups ();
	}
	
	
	public function getCapabilitiesNameForGroup($groupId) {
		return $this->_deviceRepository->getCapabilitiesNameForGroup ($groupId);
	}
	
	// ******************** private functions *****************************
	

	/**
	 * 
	 */
	private function deviceIdForRequest($request) {
		$deviceId = $this->_cacheProvider->get ( $request->id );
		if (empty ( $deviceId )) {
			$deviceId = $this->_userAgentHandlerChain->match ( $request );
			// save it in cache
			$this->_cacheProvider->put ( $request->id, $deviceId );
		}
		return $deviceId;
	}
	
	/**
	 * Wraps the model device with WURFL_Xml_ModelDevice
	 *
	 * @param string $deviceID
	 * @return WURFL_Xml_ModelDevice
	 */
	private function getWrappedDevice($deviceID) {
		$modelDevice = $this->_deviceRepository->getDevice ( $deviceID );
		return new WURFL_Device ( $modelDevice, new WURFL_CapabilitiesHolder ( $modelDevice, $this->_deviceRepository, $this->_cacheProvider ) );
	}
}

?>