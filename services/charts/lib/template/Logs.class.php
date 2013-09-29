<?php

class template_Logs extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Logs</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Logs</h1>\x0A<ol class=\"logs\">\x0A");
			if($__context__->data->length === 0) {
				$__b__->add("\x0A\x09<div class=\"message\">no logs are available</div>\x0A");
				null;
			} else {
				$__b__->add("\x0A\x09");
				{
					$_g = 0; $_g1 = $__context__->data;
					while($_g < $_g1->length) {
						$log = $_g1[$_g];
						++$_g;
						$__b__->add("\x0A\x09  <li>\x0A\x09    <div class=\"loc\">");
						$__b__->add(Date::fromTime($log->time)->toString());
						$__b__->add(" on ");
						$__b__->add($log->server);
						$__b__->add("</div>\x0A\x09    <div class=\"info\">");
						$__b__->add(template_Logs_0($this, $__b__, $__context__, $_g, $_g1, $log));
						$__b__->add($log->pos->className);
						$__b__->add(".");
						$__b__->add($log->pos->methodName);
						$__b__->add("(");
						$__b__->add($log->pos->lineNumber);
						$__b__->add(")</div>\x0A\x09    <div class=\"msg\">");
						$__b__->add(StringTools::htmlEscape($log->msg));
						$__b__->add("</div>\x0A\x09  </li>\x0A\x09");
						null;
						unset($log);
					}
				}
				$__b__->add("\x0A");
				null;
			}
			$__b__->add("\x0A</ol>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.Logs'; }
}
function template_Logs_0(&$»this, &$__b__, &$__context__, &$_g, &$_g1, &$log) {
	if(_hx_explode(".", $log->pos->fileName)->shift() === _hx_explode(".", $log->pos->className)->pop()) {
		return "";
	} else {
		return $log->pos->fileName . ": ";
	}
}
