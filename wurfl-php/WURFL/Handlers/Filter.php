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
 * UserAgentFilter is the base interface that concrete classes
 * must implement to classify the devices by user agent and then persist
 * the resulting datastructures.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

interface WURFL_Handlers_Filter {

	/**
	 * The filter() method is used to classify devices based on patterns
	 * in their user agents.
	 *  
	 * @param string $userAgent User Agent of the device
	 * @param string $deviceID  id of the the device
	 * 
	 */
	public function filter($userAgent, $deviceID);

	/**
	 * The persistData() method is resposible to 
	 * saving the classification output(associative arrays that holds <userAgent, deviceID> pair))  
	 *
	 */
	public function persistData();


}

?>