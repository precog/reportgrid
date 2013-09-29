<?php

class thx_culture_FormatParams {
	public function __construct(){}
	static function cleanQuotes($p) {
		$GLOBALS['%s']->push("thx.culture.FormatParams::cleanQuotes");
		$»spos = $GLOBALS['%s']->length;
		if(strlen($p) <= 1) {
			$GLOBALS['%s']->pop();
			return $p;
		}
		$f = _hx_substr($p, 0, 1);
		if(("\"" === $f || "'" === $f) && _hx_substr($p, -1, null) === $f) {
			$»tmp = _hx_substr($p, 1, strlen($p) - 2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$GLOBALS['%s']->pop();
			return $p;
		}
		$GLOBALS['%s']->pop();
	}
	static function params($p, $ps, $alt) {
		$GLOBALS['%s']->push("thx.culture.FormatParams::params");
		$»spos = $GLOBALS['%s']->length;
		if(null !== $ps && null !== $p) {
			$»tmp = _hx_deref(new _hx_array(array($p)))->concat($ps);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		if((null === $ps || $ps->length === 0) && null === $p) {
			$»tmp = new _hx_array(array($alt));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		if(null === $ps || $ps->length === 0) {
			$parts = _hx_explode(":", $p);
			{
				$»tmp = _hx_deref(new _hx_array(array($parts[0])))->concat((($parts->length === 1) ? new _hx_array(array()) : Iterators::map(_hx_explode(",", $parts[1])->iterator(), array(new _hx_lambda(array(&$alt, &$p, &$parts, &$ps), "thx_culture_FormatParams_0"), 'execute'))));
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $ps;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.culture.FormatParams'; }
}
function thx_culture_FormatParams_0(&$alt, &$p, &$parts, &$ps, $s, $i) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.culture.FormatParams::params@33");
		$»spos2 = $GLOBALS['%s']->length;
		if(0 === $i) {
			$GLOBALS['%s']->pop();
			return $s;
		} else {
			$»tmp = thx_culture_FormatParams::cleanQuotes($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
