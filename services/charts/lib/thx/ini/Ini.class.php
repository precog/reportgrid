<?php

class thx_ini_Ini {
	public function __construct(){}
	static function encode($value) {
		$handler = new thx_ini_IniEncoder(null, null);
		_hx_deref(new thx_data_ValueEncoder($handler))->encode($value);
		return $handler->encodedString;
	}
	static function decode($value) {
		$handler = new thx_data_ValueHandler();
		$r = _hx_deref(new thx_ini_IniDecoder($handler, null, null))->decode($value);
		return $handler->value;
	}
	function __toString() { return 'thx.ini.Ini'; }
}
