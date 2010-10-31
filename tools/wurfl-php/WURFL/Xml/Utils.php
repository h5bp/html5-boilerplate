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
 */
class WURFL_Xml_Utils {
	
	// 
	private function __construct() {}
	private function __clone() {}
	
	
	/**
	 * Returns the file path of the $xmlResource
	 * In the case of $xmlResource is zipped it
	 * uncomporesses it first
	 *
	 * @param string $xmlResource
	 */
	public static function getXMLFile($xmlResource) {
		if (self::isZipFile($xmlResource)) {
			return self::getZippedFile($xmlResource);
		}
		
		return $xmlResource;
	}

	private static function getZippedFile($filename) {
		
		if(!self::zipModuleLoaded()) {
			throw new WURFL_WURFLException("The Zip extension is not loaded. Load the extension or use the flat wurfl.xml file");
		}
		
		
		$tmpDir = sys_get_temp_dir();
		
		$zip = new ZipArchive();

		if ($zip->open($filename)!==TRUE) {
			exit("cannot open <$filename>\n");
		}
		$zippedFile = $zip->statIndex(0);
		$wurflFile = $zippedFile['name'];
		
		//$wurflFile = md5(uniqid(rand(), true)); 
		
		//$zip->extractTo($tmpDir, $wurflFile);
		$zip->extractTo($tmpDir);

		$zip->close();
		
		return $tmpDir . '/' .$wurflFile;
	}

	private static function isZipFile($fileName) {
		return strcmp("zip", substr($fileName, -3)) === 0 ? TRUE : FALSE;
	}
	
	
	private static function zipModuleLoaded() {
		return class_exists('ZipArchive');
	}
	
}


?>