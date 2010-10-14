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
 * UserAgentMatcher is the base interface that concrete classes 
 * must implement to retrieve a device with the given request    
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
interface WURFL_Handlers_Matcher {
	
	/**
	 * Returns a matching device id for the given request
	 * 
	 * If no matching device is found will return "generic"
	 * 
	 * @param WURFL_Request_GenericRequest $request
	 */
	public function match(WURFL_Request_GenericRequest $request);
	
}

?>