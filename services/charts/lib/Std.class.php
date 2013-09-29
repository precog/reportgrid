<?php

class Std {
	public function __construct(){}
	static function is($v, $t) {
		return _hx_instanceof($v, $t);
	}
	static function string($s) {
		return _hx_string_rec($s, "");
	}
	static function int($x) {
		return intval($x);
	}
	static function parseInt($x) {
		if(!is_numeric($x)) {
			$matches = null;
			preg_match("/^-?\\d+/", $x, $matches);
			return ((count($matches) === 0) ? null : intval($matches[0]));
		} else {
			return ((strtolower(_hx_substr($x, 0, 2)) === "0x") ? (int) hexdec(substr($x, 2)) : intval($x));
		}
	}
	static function parseFloat($x) {
		return is_numeric($x) ? floatval($x) : acos(1.01);
	}
	static function random($x) {
		return mt_rand(0, $x - 1);
	}
	function __toString() { return 'Std'; }
}
