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
class WURFL_Constants {

	private function __construct(){}

	const GENERIC = "generic";
	const GENERIC_XHTML = "generic_xhtml";

	const ACCEPT_HEADER_VND_WAP_XHTML_XML = "application/vnd.wap.xhtml+xml";
	const ACCEPT_HEADER_XHTML_XML = "application/xhtml+xml";
	const ACCEPT_HEADER_TEXT_HTML = "application/text+html";

	const UA = "UA";
	
	const MEMCACHE = "memcache";
	const APC = "apc";
	const FILE = "file";
	const NULL_CACHE = "null";
	const EACCELERATOR = "eaccelerator";
	const SQLITE = "sqlite";
	const MYSQL = "mysql";
}

?>