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
 * @package    WURFL_Xml
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 *
 */
class WURFL_Xml_Info {

	const PERSISTENCE_KEY = "WURFL_XML_INFO";
	private $version;
	private $lastUpdated;
	private $officialURL;
	
	public function __construct($version, $lastUpdated, $officialURL) {
		$this->version = $version;
		$this->lastUpdated = $lastUpdated;
		$this->officialURL = $officialURL;		
	}
	
	public function __get($name) {
		return $this->$name;
	} 
	
}