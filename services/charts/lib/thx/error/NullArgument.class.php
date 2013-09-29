<?php

class thx_error_NullArgument extends thx_error_Error {
	public function __construct($argumentName, $message, $posInfo) { if(!php_Boot::$skip_constructor) {
		if(null === $message) {
			$message = "invalid null or empty argument '{0}' for method {1}.{2}()";
		}
		parent::__construct($message,new _hx_array(array($argumentName, $posInfo->className, $posInfo->methodName)),$posInfo,_hx_anonymous(array("fileName" => "NullArgument.hx", "lineNumber" => 16, "className" => "thx.error.NullArgument", "methodName" => "new")));
	}}
	function __toString() { return 'thx.error.NullArgument'; }
}
