<?php

class ufront_web_mvc_HttpUnauthorizedResult extends ufront_web_mvc_ActionResult {
	public function __construct() { 
	}
	public function executeResult($context) {
		$context->httpContext->getResponse()->status = 401;
	}
	function __toString() { return 'ufront.web.mvc.HttpUnauthorizedResult'; }
}
