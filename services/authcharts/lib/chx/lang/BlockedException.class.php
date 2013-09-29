<?php

class chx_lang_BlockedException extends chx_lang_IOException {
	public function __construct($msg, $cause) { if(!php_Boot::$skip_constructor) {
		parent::__construct($msg,$cause);
	}}
	function __toString() { return 'chx.lang.BlockedException'; }
}
