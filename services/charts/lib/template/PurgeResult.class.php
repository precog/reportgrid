<?php

class template_PurgeResult extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			{
				$x = "<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>PurgeResult</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = $__context__->baseurl;
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = $__context__->url->base("css/style.css");
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = "\">\x0A</head>\x0A<body>\x0A<h1>PurgeResult</h1>\x0A<dl>\x0A  <dt>elements purged:</dt>\x0A  <dd>";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = $__context__->type;
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = "</dd>\x0A  <dt>quantity:</dt>\x0A  <dd>";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = $__context__->erased;
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			{
				$x = "</dd>\x0A</dl>\x0A</body>\x0A</html>";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
		}
		return $__b__->b;
	}
	function __toString() { return 'template.PurgeResult'; }
}
