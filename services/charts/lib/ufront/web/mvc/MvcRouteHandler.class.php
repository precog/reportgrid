<?php

class ufront_web_mvc_MvcRouteHandler implements ufront_web_routing_IRouteHandler{
	public function __construct() { 
	}
	public function getHttpHandler($requestContext) {
		return new ufront_web_mvc_MvcHandler($requestContext);
	}
	function __toString() { return 'ufront.web.mvc.MvcRouteHandler'; }
}
