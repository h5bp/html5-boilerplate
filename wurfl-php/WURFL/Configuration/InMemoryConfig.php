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
 * @package    WURFL_Configuration
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Configuration_InMemoryConfig extends  WURFL_Configuration_Config {

	public function __construct() {		
	}
	
	
	public function wurflFile($wurflFile) {
		$this->wurflFile = $wurflFile;
		return $this;
	}
	
	public function wurflPatch($wurflPatch) {
		$this->wurflPatches[] = $wurflPatch;
		return $this;
	}
	
	public function persistence($provider, $params = array()) {
		$this->persistence["provider"] = $provider;
		$this->persistence["params"] = $params;
		return $this;				
	}
	
	public function cache($provider, $params = array()) {
		$this->cache["provider"] = $provider;
		$this->cache["params"] = $params;
		return $this;
	}
	
	/**
	 * 
	 */
	final protected function initialize() {	
		// DO NOTHING :
	}

	
}

?>