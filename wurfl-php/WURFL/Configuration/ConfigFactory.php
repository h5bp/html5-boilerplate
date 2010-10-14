<?php

class WURFL_Configuration_ConfigFactory {
	
	public static function create($configFilePath) {
		
		if (!isset ( $configFilePath )) {
			throw new InvalidArgumentException ( " The configuration file path $configFilePath is not set" );
		}
		if (self::isXmlConfiguration ( $configFilePath )) {
			return new WURFL_Configuration_XmlConfig ( $configFilePath );
		}
		
		return new WURFL_Configuration_ArrayConfig ( $configFilePath );
	
	}
	
	private static function isXmlConfiguration($fileName) {
		return strcmp ( "xml", substr ( $fileName, - 3 ) ) === 0 ? TRUE : FALSE;
	}
}
?>