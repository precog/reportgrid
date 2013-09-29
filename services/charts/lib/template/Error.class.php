<?php

class template_Error extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Download Error</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A  <style>\x0Abody {\x0A  padding: 0;\x0A  font-size: 80%;\x0A}\x0A  </style>\x0A</head>\x0A<body>\x0A<div class=\"error\">");
			$__b__->add($__context__->data->error);
			$__b__->add("</div>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.Error'; }
}
