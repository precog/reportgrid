<?php

class ufront_web_routing_EmptyRoute extends ufront_web_routing_RouteBase {
	public function __construct() { 
	}
	static $instance;
	function __toString() { return 'ufront.web.routing.EmptyRoute'; }
}
ufront_web_routing_EmptyRoute::$instance = new ufront_web_routing_EmptyRoute();
