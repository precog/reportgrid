<?php

class thx_culture_FormatParams {
	public function __construct(){}
	static function cleanQuotes($p) {
		if(strlen($p) <= 1) {
			return $p;
		}
		$f = _hx_substr($p, 0, 1);
		if(("\"" === $f || "'" === $f) && _hx_substr($p, -1, null) === $f) {
			return _hx_substr($p, 1, strlen($p) - 2);
		} else {
			return $p;
		}
	}
	static function params($p, $ps, $alt) {
		if(null !== $ps && null !== $p) {
			return _hx_deref(new _hx_array(array($p)))->concat($ps);
		}
		if((null === $ps || $ps->length === 0) && null === $p) {
			return new _hx_array(array($alt));
		}
		if(null === $ps || $ps->length === 0) {
			$parts = _hx_explode(":", $p);
			return _hx_deref(new _hx_array(array($parts[0])))->concat((($parts->length === 1) ? new _hx_array(array()) : Iterators::map(_hx_explode(",", $parts[1])->iterator(), array(new _hx_lambda(array(&$alt, &$p, &$parts, &$ps), "thx_culture_FormatParams_0"), 'execute'))));
		}
		return $ps;
	}
	function __toString() { return 'thx.culture.FormatParams'; }
}
function thx_culture_FormatParams_0(&$alt, &$p, &$parts, &$ps, $s, $i) {
	{
		if(0 === $i) {
			return $s;
		} else {
			return thx_culture_FormatParams::cleanQuotes($s);
		}
	}
}
