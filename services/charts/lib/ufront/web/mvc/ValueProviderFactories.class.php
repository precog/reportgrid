<?php

class ufront_web_mvc_ValueProviderFactories {
	public function __construct(){}
	static $factories;
	function __toString() { return 'ufront.web.mvc.ValueProviderFactories'; }
}
ufront_web_mvc_ValueProviderFactories::$factories = new ufront_web_mvc_ValueProviderFactoryCollection(new _hx_array(array(new ufront_web_mvc_FormValueProviderFactory(), new ufront_web_mvc_RouteDataValueProviderFactory(), new ufront_web_mvc_QueryStringValueProviderFactory())));
