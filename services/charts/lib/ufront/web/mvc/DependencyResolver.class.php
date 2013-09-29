<?php

class ufront_web_mvc_DependencyResolver {
	public function __construct(){}
	static $current;
	function __toString() { return 'ufront.web.mvc.DependencyResolver'; }
}
ufront_web_mvc_DependencyResolver::$current = new ufront_web_mvc_DefaultDependencyResolver(null);
