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
 * @package    WURFL_Reloader
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 * @deprecated
 */
class WURFL_Reloader_DefaultWURFLReloader implements WURFL_Reloader_Interface {
	
	public function reload($wurflConfigurationPath) {
		$wurflConfig = $this->fromFile ( $wurflConfigurationPath );
		touch($wurflConfig->wurflFile);
		$wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);
		$wurflManager = $wurflManagerFactory->create();	
		
	}
	
	private function fromFile($wurflConfigurationPath) {
		if ($this->endswith ( $wurflConfigurationPath, ".xml" )) {
			return new WURFL_Configuration_XmlConfig ( $wurflConfigurationPath );
		}
		return new WURFL_Configuration_ArrayConfig($wurflConfigurationPath);
	}
	
	private function endswith($haystack, $needle) {
		$needle = preg_quote ( $needle );
		return preg_match ( '/(?:$needle)\$/i', $haystack );
	}
}
?>