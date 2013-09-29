<?php

class ufront_web_error_InternalServerError extends ufront_web_error_HttpError {
	public function __construct($pos) { if(!php_Boot::$skip_constructor) {
		parent::__construct(500,"Internal Server Error",null,$pos,_hx_anonymous(array("fileName" => "InternalServerError.hx", "lineNumber" => 8, "className" => "ufront.web.error.InternalServerError", "methodName" => "new")));
	}}
	function __toString() { return 'ufront.web.error.InternalServerError'; }
}
