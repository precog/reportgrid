<?php

class thx_error_NotImplemented extends thx_error_Error {
	public function __construct($posInfo) { if(!php_Boot::$skip_constructor) {
		parent::__construct("method {0}.{1}() needs to be implemented",new _hx_array(array($posInfo->className, $posInfo->methodName)),$posInfo,_hx_anonymous(array("fileName" => "NotImplemented.hx", "lineNumber" => 13, "className" => "thx.error.NotImplemented", "methodName" => "new")));
	}}
	function __toString() { return 'thx.error.NotImplemented'; }
}
