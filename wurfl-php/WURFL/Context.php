<?php

class WURFL_Context {
	
	private $persistenceProvider;
	private $cacheProvider;
	private $logger;
	
	public function __construct($persistenceProvider, $caheProvider = null, $logger = null) {
		$this->persistenceProvider = $persistenceProvider;
		$this->cacheProvider = is_null($caheProvider) ? new WURFL_Cache_NullCacheProvider() : $caheProvider;
		$this->logger = is_null($logger) ? new WURFL_Logger_NullLogger() : $logger;
	}
	
	public function cacheProvider($cacheProvider) {
		return new WURFL_Context ( $this->persistenceProvider, $cacheProvider, $this->logger );
	}
	
	public function logger($logger) {
		return new WURFL_Context ( $this->persistenceProvider, $this->cacheProvider, $logger );
	}
	
	public function __get($name) {
		return $this->$name;
	}

}