<?php

class ufront_web_error_PageNotFoundError extends ufront_web_error_HttpError {
	public function __construct($pos) { if(!php_Boot::$skip_constructor) {
		parent::__construct(404,"Page Not Found",null,$pos,_hx_anonymous(array("fileName" => "PageNotFoundError.hx", "lineNumber" => 8, "className" => "ufront.web.error.PageNotFoundError", "methodName" => "new")));
	}}
	function __toString() { return 'ufront.web.error.PageNotFoundError'; }
}
