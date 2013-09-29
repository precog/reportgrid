<?php

class ufront_web_mvc_view_FormatHelper implements ufront_web_mvc_IViewHelper{
	public function __construct() { 
	}
	public function register($data) {
		$data->set("format", (isset(Dynamics::$format) ? Dynamics::$format: array("Dynamics", "format")));
		$data->set("pattern", (isset(Strings::$format) ? Strings::$format: array("Strings", "format")));
		$data->set("formatDate", (isset(Dates::$format) ? Dates::$format: array("Dates", "format")));
		$data->set("formatInt", (isset(Ints::$format) ? Ints::$format: array("Ints", "format")));
		$data->set("formatFloat", (isset(Floats::$format) ? Floats::$format: array("Floats", "format")));
	}
	function __toString() { return 'ufront.web.mvc.view.FormatHelper'; }
}
