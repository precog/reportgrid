<?php

class thx_color_Colors {
	public function __construct(){}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("thx.color.Colors::interpolatef");
		$»spos = $GLOBALS['%s']->length;
		$ca = thx_color_Colors::parse($a);
		$cb = thx_color_Colors::parse($b);
		$f = thx_color_Rgb::interpolatef($ca, $cb, $equation);
		{
			$»tmp = array(new _hx_lambda(array(&$a, &$b, &$ca, &$cb, &$equation, &$f), "thx_color_Colors_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("thx.color.Colors::interpolate");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = call_user_func_array(thx_color_Colors::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reParse;
	static function parse($s) {
		$GLOBALS['%s']->push("thx.color.Colors::parse");
		$»spos = $GLOBALS['%s']->length;
		if(!thx_color_Colors::$_reParse->match($s = strtolower($s))) {
			$v = thx_color_NamedColors::$byName->get($s);
			if(null === $v) {
				if("transparent" === $s) {
					$»tmp = thx_color_Rgb::fromInt(16777215);
					$GLOBALS['%s']->pop();
					return $»tmp;
				} else {
					$GLOBALS['%s']->pop();
					return null;
				}
			} else {
				$GLOBALS['%s']->pop();
				return $v;
			}
		}
		$type = thx_color_Colors::$_reParse->matched(1);
		if(!Strings::hempty($type)) {
			$values = _hx_explode(",", thx_color_Colors::$_reParse->matched(2));
			switch($type) {
			case "rgb":case "rgba":{
				$»tmp = new thx_color_Rgb(thx_color_Colors::_c($values[0]), thx_color_Colors::_c($values[1]), thx_color_Colors::_c($values[2]));
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			case "hsl":{
				$»tmp = new thx_color_Hsl(thx_color_Colors::_d($values[0]), thx_color_Colors::_p($values[1]), thx_color_Colors::_p($values[2]));
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			case "cmyk":{
				$»tmp = new thx_color_Cmyk(thx_color_Colors::_p($values[0]), thx_color_Colors::_p($values[1]), thx_color_Colors::_p($values[2]), thx_color_Colors::_p($values[3]));
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			}
		}
		$color = thx_color_Colors::$_reParse->matched(3);
		if(strlen($color) === 3) {
			$color = Iterators::map(_hx_explode("", $color)->iterator(), array(new _hx_lambda(array(&$color, &$s, &$type), "thx_color_Colors_1"), 'execute'))->join("");
		} else {
			if(strlen($color) !== 6) {
				$GLOBALS['%s']->pop();
				return null;
			}
		}
		{
			$»tmp = thx_color_Rgb::fromInt(Std::parseInt("0x" . $color));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function _c($s) {
		$GLOBALS['%s']->push("thx.color.Colors::_c");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Std::parseInt(trim($s));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function _d($s) {
		$GLOBALS['%s']->push("thx.color.Colors::_d");
		$»spos = $GLOBALS['%s']->length;
		$s1 = trim($s);
		if(_hx_substr($s1, -3, null) === "deg") {
			$s1 = _hx_substr($s1, 0, -3);
		} else {
			if(_hx_substr($s1, -1, null) === "Âº") {
				$s1 = _hx_substr($s1, 0, -1);
			}
		}
		{
			$»tmp = Std::parseFloat($s1);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function _p($s) {
		$GLOBALS['%s']->push("thx.color.Colors::_p");
		$»spos = $GLOBALS['%s']->length;
		$s1 = trim($s);
		if(_hx_substr($s1, -1, null) === "%") {
			$»tmp = Std::parseFloat(_hx_substr($s1, 0, -1)) / 100;
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = Std::parseFloat($s1);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.color.Colors'; }
}
thx_color_Colors::$_reParse = new EReg("^\\s*(?:(hsl|rgb|rgba|cmyk)\\(([^)]+)\\))|(?:(?:0x|#)([a-f0-9]{3,6}))\\s*\$", "i");
function thx_color_Colors_0(&$a, &$b, &$ca, &$cb, &$equation, &$f, $v) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.color.Colors::interpolatef@19");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = call_user_func_array($f, array($v))->toString();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function thx_color_Colors_1(&$color, &$s, &$type, $d, $_) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.color.Colors::parse@64");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $d . $d;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
