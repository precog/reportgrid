<?php

class chx_lang_IOException extends chx_lang_Exception {
	public function __construct($msg, $cause) { if(!php_Boot::$skip_constructor) {
		parent::__construct($msg,$cause);
	}}
	function __toString() { return 'chx.lang.IOException'; }
}
