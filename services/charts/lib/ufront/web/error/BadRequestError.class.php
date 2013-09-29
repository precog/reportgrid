<?php

class ufront_web_error_BadRequestError extends ufront_web_error_HttpError {
	public function __construct($pos) { if(!php_Boot::$skip_constructor) {
		parent::__construct(400,"Bad Request",null,$pos,_hx_anonymous(array("fileName" => "BadRequestError.hx", "lineNumber" => 8, "className" => "ufront.web.error.BadRequestError", "methodName" => "new")));
	}}
	function __toString() { return 'ufront.web.error.BadRequestError'; }
}
