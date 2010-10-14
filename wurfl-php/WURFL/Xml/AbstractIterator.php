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
abstract class WURFL_Xml_AbstractIterator implements Iterator {
	
	private $inputFile;
	
	protected $xmlReader;
	
	protected $currentElement;
	
	protected $currentElementId;
	
	function __construct($inputFile) {
		if(!file_exists($inputFile)) {
			throw new InvalidArgumentException("cannot locate [$inputFile] file!");
		}
		$this->inputFile = WURFL_Xml_Utils::getXMLFile($inputFile);
	}
	
	/**
	 * 
	 */
	public function current() {
		return $this->currentElement;
	}
	
	/**
	 * 
	 */
	public function next() {
		$this->currentElement = null;
	}
	
	/**
	 * 
	 */
	public function key() {
		return $this->currentElementId;
	}
	
	/**
	 * 
	 */
	public function valid() {
		if($this->currentElement === null) {
			$this->readNextElement();
		}
		return $this->currentElement != null;
	}
	
	/**
	 * 
	 */
	public function rewind() {
		$this->xmlReader = new XMLReader();
		$this->xmlReader->open($this->inputFile);
		$this->currentElement = null;
		$this->currentElementId = null;
	}
	
	abstract public function readNextElement();
	
	
}
?>