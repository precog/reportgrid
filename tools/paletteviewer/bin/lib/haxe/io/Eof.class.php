<?php

class haxe_io_Eof {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("haxe.io.Eof::new");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}}
	public function toString() {
		$GLOBALS['%s']->push("haxe.io.Eof::toString");
		$»spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return "Eof";
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return $this->toString(); }
}
