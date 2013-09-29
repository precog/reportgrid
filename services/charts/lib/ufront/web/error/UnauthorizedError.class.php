<?php

class ufront_web_error_UnauthorizedError extends ufront_web_error_HttpError {
	public function __construct($pos) { if(!php_Boot::$skip_constructor) {
		parent::__construct(401,"Unauthorized Access",null,$pos,_hx_anonymous(array("fileName" => "UnauthorizedError.hx", "lineNumber" => 8, "className" => "ufront.web.error.UnauthorizedError", "methodName" => "new")));
	}}
	function __toString() { return 'ufront.web.error.UnauthorizedError'; }
}
