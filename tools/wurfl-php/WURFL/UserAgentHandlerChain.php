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

class WURFL_UserAgentHandlerChain {
	 

	private $_userAgentHandlers = array();
	
	
	public function __construct() {	
	}
	
	
	/**
	 * Adds a UserAgentHandler to the chain
	 *
	 * @param WURFL_UserAgentHandler_Interface $handler
	 * @return 
	 */
	public function addUserAgentHandler(WURFL_Handlers_Handler $handler) {
		$size = sizeof($this->_userAgentHandlers); 
		if ($size > 0) {
			$this->_userAgentHandlers[$size-1]->setNextHandler($handler);
		}
		$this->_userAgentHandlers[] = $handler;
		return $this;
	}
	
	public function getHandlers() {
		return $this->_userAgentHandlers;
	}
	
	/**
	 * Adds the pair $userAgent, $deviceID to the clusters they belong to.
	 *
	 * @param String $userAgent
	 * @param String $deviceID
	 */
	public function filter($userAgent, $deviceID) {
		$this->_userAgentHandlers[0]->filter($userAgent, $deviceID);
	}
	
	
	public function findHandler($userAgent) {
		foreach ($this->_userAgentHandlers as $handler) {
			if($handler->canHandle($userAgent)) {
				return $handler;
			}
		}
	}
	
	
	/**
	 * Return the the device id for the request 
	 *
	 * @param WURFL_Request_GenericRequest $request
	 * @return String deviceID
	 */
	public function match(WURFL_Request_GenericRequest $request) {
		return $this->_userAgentHandlers[0]->match($request);
	}
	
	public function persistData() {
		foreach ($this->_userAgentHandlers as $userAgentHandler) {
			$userAgentHandler->persistData();
		}
		
	}
	
	
	public function collectData() {
		$userAgentsWithDeviceId = array();		
		foreach ($this->_userAgentHandlers as $userAgentHandler) {
			$current = $userAgentHandler->getUserAgentsWithDeviceId();
			if(!empty($current)) {
				$userAgentsWithDeviceId = array_merge($userAgentsWithDeviceId, $current);
			} 
		}
				
		return $userAgentsWithDeviceId;
	}
	
	
	
	
}

?>