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

class WURFL_UserAgentHandlerChainFactory {
	
	private static $_userAgentHandlerChain = NULL;
	
	private function __construct() {
	}
	
	
	public static function createFrom(WURFL_Context $context) {
		self::init ( $context );
		return self::$_userAgentHandlerChain;
	}
	
	static private function init(WURFL_Context $context = null) {
		
		self::$_userAgentHandlerChain = new WURFL_UserAgentHandlerChain ();
		
		$chromeNormalizer = new WURFL_Request_UserAgentNormalizer_Chrome ();
		$operaNormalizer = new WURFL_Request_UserAgentNormalizer_Opera ();
		$konquerorNormalizer = new WURFL_Request_UserAgentNormalizer_Konqueror ();
		$safariNormalizer = new WURFL_Request_UserAgentNormalizer_Safari ();
		$firefoxNormalizer = new WURFL_Request_UserAgentNormalizer_Firefox ();
		$msieNormalizer = new WURFL_Request_UserAgentNormalizer_MSIE ();
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_NokiaHandler ( $context ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_AndroidHandler ( $context, new WURFL_Request_UserAgentNormalizer_Android() ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SonyEricssonHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_MotorolaHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_BlackBerryHandler ( $context ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SiemensHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SagemHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SamsungHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_PanasonicHandler ( $context ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_NecHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_QtekHandler ( $context ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_MitsubishiHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_PhilipsHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_LGHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_AppleHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_KyoceraHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_AlcatelHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SharpHandler ( $context ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SanyoHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_BenQHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_PantechHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_ToshibaHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_GrundigHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_HTCHandler ( $context ) );

		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_VodafoneHandler ( $context ) );
		
		
		// BOT
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_BotCrawlerTranscoderHandler ( $context ) );
		
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SPVHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_WindowsCEHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_PortalmmmHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_DoCoMoHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_KDDIHandler ( $context ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_OperaMiniHandler ( $context ) );
		
		// Web Browsers handlers
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_ChromeHandler ( $context, $chromeNormalizer ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_AOLHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_OperaHandler ( $context ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_KonquerorHandler ( $context, $konquerorNormalizer ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_SafariHandler ( $context, $safariNormalizer ) );
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_FirefoxHandler ( $context, $firefoxNormalizer ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_MSIEHandler ( $context, $msieNormalizer ) );
		
		self::$_userAgentHandlerChain->addUserAgentHandler ( new WURFL_Handlers_CatchAllHandler ( $context ) );
	
	}

}

?>