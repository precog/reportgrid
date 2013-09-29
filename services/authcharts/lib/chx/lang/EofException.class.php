<?php

class chx_lang_EofException extends chx_lang_IOException {
	public function __construct($msg, $cause) { if(!php_Boot::$skip_constructor) {
		parent::__construct($msg,$cause);
	}}
	public function toString() {
		return "EOF";
	}
	function __toString() { return $this->toString(); }
}
