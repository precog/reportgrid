<?php

class thx_error_AbstractMethod extends thx_error_Error {
	public function __construct($posInfo) { if(!php_Boot::$skip_constructor) {
		parent::__construct("method {0}.{1}() is abstract",new _hx_array(array($posInfo->className, $posInfo->methodName)),$posInfo,_hx_anonymous(array("fileName" => "AbstractMethod.hx", "lineNumber" => 14, "className" => "thx.error.AbstractMethod", "methodName" => "new")));
	}}
	function __toString() { return 'thx.error.AbstractMethod'; }
}
