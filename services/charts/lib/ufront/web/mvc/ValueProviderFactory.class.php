<?php

class ufront_web_mvc_ValueProviderFactory {
	public function __construct() { 
	}
	public function getValueProvider($controllerContext) {
		ufront_web_mvc_ValueProviderFactory_0($this, $controllerContext);
	}
	function __toString() { return 'ufront.web.mvc.ValueProviderFactory'; }
}
function ufront_web_mvc_ValueProviderFactory_0(&$»this, &$controllerContext) {
	throw new HException("Abstract method, must be overridden in subclass.");
}
