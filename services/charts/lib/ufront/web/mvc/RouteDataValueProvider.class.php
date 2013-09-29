<?php

class ufront_web_mvc_RouteDataValueProvider extends ufront_web_mvc_HashValueProvider {
	public function __construct($controllerContext) { if(!php_Boot::$skip_constructor) {
		parent::__construct($controllerContext->routeData->data);
	}}
	function __toString() { return 'ufront.web.mvc.RouteDataValueProvider'; }
}
