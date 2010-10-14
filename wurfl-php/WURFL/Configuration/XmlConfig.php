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
class WURFL_Configuration_XmlConfig extends WURFL_Configuration_Config {

	
	
	private $logDir = ".";
	

	private $stack = array();
	private $persistenceOrCache = array();
	
	
	
	/**
	 * Constructor
	 *
	 * @param string $confLocation
	 */
	function __construct($configFilePath) {
		parent::__construct($configFilePath);
	}
	
	
	
	/**
	 * Reads the configuration file and creates the class attributes
	 *
	 */
	protected  function initialize(){
		
		$reader = new XMLReader();
		$reader->open(parent::getConfigFilePath());

		$reader->setRelaxNGSchemaSource(self::WURFL_CONF_SCHEMA);
		
	
		libxml_use_internal_errors(TRUE);

		
		while ($reader->read()) {
			if(!$reader->isValid()) {
				throw new Exception(libxml_get_last_error()->message);
			}
			$name = $reader->name;
			switch ($reader->nodeType) {
				case XMLReader::ELEMENT:
					$this->_handleStartElement($name);
					break;
				case XMLReader::TEXT:
					$this->_handleTextElement($reader->value);
					break;
				case XMLReader::END_ELEMENT:
					$this->_handleEndElement($name);
					break;
			}
		}
		
		$reader->close();
		
		if (isset($this->cache["dir"])) {
			$this->logDir = $this->cache["dir"];
		}
		
		
		
		
	}

	/**
	 * Handles the start of an element
	 *
	 * @param string $name
	 */
	private function _handleStartElement($name) {
		array_push($this->stack, $name);
	}

	/**
	 * Handles Text Element
	 *
	 * @param array $stack
	 * @param string $name
	 * @param string $value
	 */
	private function _handleTextElement($value) {
		$currentElement = $this->array_peek($this->stack);
		switch ($currentElement) {
			case WURFL_Configuration_Config::MAIN_FILE:				
				$this->wurflFile = parent::getFullPath($value);
				break;
			case WURFL_Configuration_Config::PATCH:
				$this->wurflPatches[] = parent::getFullPath($value);
				break;
			case WURFL_Configuration_Config::PROVIDER:
				$this->persistenceOrCache["provider"] = $value;
				break;
			case WURFL_Configuration_Config::PARAMS:
				$this->persistenceOrCache = array_merge($this->persistenceOrCache, $this->_toArray($value));
				break;
		}

	}

	/**
	 * Handles the end of the element
	 *
	 * @param string $name
	 */
	private function _handleEndElement($name) {
		switch ($name) {
			case WURFL_Configuration_Config::PERSISTENCE:
				$this->persistence = $this->persistenceOrCache;
			case WURFL_Configuration_Config::CACHE:
				$this->cache = $this->persistenceOrCache;
				break;
		}
		
		array_pop($this->stack);
		
	}


	//************************* Utility Functions ********************************//
	
	private function _toArray($params) {
		$paramsArray = array();
		
		foreach (explode(",", $params) as $param) {
			$paramNameValue = explode("=", $param);
			
			if(strcmp(WURFL_Configuration_Config::DIR, $paramNameValue[0]) == 0) {
				$paramNameValue[1] = parent::getFullPath($paramNameValue[1]);
			}
			
			$paramsArray[$paramNameValue[0]] = $paramNameValue[1];
		}

		
		return $paramsArray;
	}

	private function array_peek(array &$array) {
		$var = array_pop($array);
		array_push($array, $var);
		return $var;
	}
	
	
	


	const  WURFL_CONF_SCHEMA = '<?xml version="1.0" encoding="utf-8" ?>
	<element name="wurfl-config" xmlns="http://relaxng.org/ns/structure/1.0">
    	<element name="wurfl">
    		<element name="main-file"><text/></element>
    		<element name="patches">
    			<zeroOrMore>
      				<element name="patch"><text/></element>
    			</zeroOrMore>
  			</element>
  		</element>
  		<element name="persistence">
      		<element name="provider"><text/></element>
      		<optional>
      			<element name="params"><text/></element>
      		</optional>
  		</element>
  		<element name="cache">
      		<element name="provider"><text/></element>
      		<optional>
      			<element name="params"><text/></element>
      		</optional>
  		</element>
	</element>';
}
?>