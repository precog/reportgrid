<?php

class ufront_web_mvc_FormValueProvider extends ufront_web_mvc_HashValueProvider {
	public function __construct($controllerContext) { if(!php_Boot::$skip_constructor) {
		parent::__construct($controllerContext->request->getPost());
	}}
	function __toString() { return 'ufront.web.mvc.FormValueProvider'; }
}
