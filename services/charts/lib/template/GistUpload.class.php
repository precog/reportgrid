<?php

class template_GistUpload extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Upload GIST</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Upload Form</h1>\x0A");
			$action = $__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "gist")));
			$__b__->add("\x0A<form method=\"post\" action=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($action);
			$__b__->add("\" class=\"formupload\">\x0A  <ul>\x0A    <li>\x0A      <label for=\"gistid\">GIST ID or URL</label>\x0A      <br>\x0A      <input type=\"text\" name=\"gistid\" value=\"");
			$__b__->add(template_GistUpload_0($this, $__b__, $__context__, $action));
			$__b__->add("\"/>\x0A      ");
			if(null !== $__context__->error) {
				$__b__->add("\x0A\x09    <div class=\"error\">The GIST ID or URL is wrong: ");
				$__b__->add($__context__->error);
				$__b__->add("</div>\x0A      ");
				null;
			}
			$__b__->add("\x0A    </li>\x0A  </ul>\x0A  <input type=\"submit\" value=\"submit\">\x0A<form>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.GistUpload'; }
}
function template_GistUpload_0(&$»this, &$__b__, &$__context__, &$action) {
	if(null === $__context__->gistid) {
		return "";
	} else {
		return $__context__->gistid;
	}
}
