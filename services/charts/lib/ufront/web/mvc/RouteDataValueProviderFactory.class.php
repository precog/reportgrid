<?php

class ufront_web_mvc_RouteDataValueProviderFactory extends ufront_web_mvc_ValueProviderFactory {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function getValueProvider($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "RouteDataValueProviderFactory.hx", "lineNumber" => 20, "className" => "ufront.web.mvc.RouteDataValueProviderFactory", "methodName" => "getValueProvider"))));
		}
		return new ufront_web_mvc_RouteDataValueProvider($controllerContext);
	}
	function __toString() { return 'ufront.web.mvc.RouteDataValueProviderFactory'; }
}
