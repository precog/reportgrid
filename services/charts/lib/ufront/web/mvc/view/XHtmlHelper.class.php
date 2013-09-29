<?php

class ufront_web_mvc_view_XHtmlHelper extends ufront_web_mvc_view_HtmlHelper {
	public function __construct($name, $urlHelper) { if(!php_Boot::$skip_constructor) {
		parent::__construct($name,$urlHelper);
	}}
	public function register($data) {
		$data->set($this->name, new ufront_web_mvc_view_XHtmlHelperInst($this->urlHelper));
	}
	function __toString() { return 'ufront.web.mvc.view.XHtmlHelper'; }
}
