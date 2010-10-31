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
 * @deprecated
 */
class WURFL_Xml_WURFLPatchFileParser implements WURFL_Xml_Interface {

	const WURFL_PATCHING_SCHEMA = "wurfl-patch.rng";
	
	/**
	 * returns a map of devices by deviceId of the patching wurfl file
	 *
	 * @param string $fileName
	 */
	public function parse($fileName) {
		return WURFL_Xml_ParserUtil::parse($fileName, self::WURFL_PATCHING_SCHEMA);
	}

}
?>