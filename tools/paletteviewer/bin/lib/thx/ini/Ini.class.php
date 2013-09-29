<?php

class thx_ini_Ini {
	public function __construct(){}
	static function encode($value) {
		$GLOBALS['%s']->push("thx.ini.Ini::encode");
		$»spos = $GLOBALS['%s']->length;
		$handler = new thx_ini_IniEncoder(null, null);
		_hx_deref(new thx_data_ValueEncoder($handler))->encode($value);
		{
			$»tmp = $handler->encodedString;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function decode($value) {
		$GLOBALS['%s']->push("thx.ini.Ini::decode");
		$»spos = $GLOBALS['%s']->length;
		$handler = new thx_data_ValueHandler();
		$r = _hx_deref(new thx_ini_IniDecoder($handler, null, null))->decode($value);
		{
			$»tmp = $handler->value;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.ini.Ini'; }
}
