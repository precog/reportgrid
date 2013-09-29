<?php

class template_HomeTemplate extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$x = "<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Instructions</title>\x0A</head>\x0A<body>\x0A<h1>Server Side Rendering Instructions</h1>\x0A</body>\x0A</html>";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$__b__->b .= $x;
		}
		return $__b__->b;
	}
	function __toString() { return 'template.HomeTemplate'; }
}
