<?php

class template_FormAPI extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			{
				$x = "<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Upload API Response</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"";
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
				$x = "\">\x0A</head>\x0A<body>\x0A<h1>Upload API Response</h1>\x0A";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$__b__->b .= $x;
			}
			if(null !== $__context__->error) {
				{
					$x = "\x0A  <div class=\"error\">";
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
					$x = $__context__->error;
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
					$x = "</div>\x0A";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$__b__->b .= $x;
				}
				null;
			} else {
				{
					$x = "\x0A  <h2>New Template Rendering Generated</h2>\x0A  <dl>\x0A    <dt>key</dt>\x0A    <dd>";
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
					$x = $__context__->info->key;
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
					$x = "</dd>\x0A  </dl>\x0A";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$__b__->b .= $x;
				}
				null;
			}
			{
				$x = "\x0A</body>\x0A</html>";
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
	function __toString() { return 'template.FormAPI'; }
}
