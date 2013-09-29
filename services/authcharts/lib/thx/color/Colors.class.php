<?php

class thx_color_Colors {
	public function __construct(){}
	static function interpolatef($a, $b, $equation) {
		$ca = thx_color_Colors::parse($a);
		$cb = thx_color_Colors::parse($b);
		$f = thx_color_Rgb::interpolatef($ca, $cb, $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$ca, &$cb, &$equation, &$f), "thx_color_Colors_0"), 'execute');
	}
	static function interpolate($v, $a, $b, $equation) {
		return thx_color_Colors::interpolatef($a, $b, $equation)($v);
	}
	static $_reParse;
	static function parse($s) {
		if(!thx_color_Colors::$_reParse->match($s = trim(strtolower($s)))) {
			$v = thx_color_NamedColors::$byName->get($s);
			if(null === $v) {
				if("transparent" === $s) {
					return thx_color_Rgb::fromInt(16777215);
				} else {
					return null;
				}
			} else {
				return $v;
			}
		}
		$type = thx_color_Colors::$_reParse->matched(1);
		if(!Strings::hempty($type)) {
			$values = _hx_explode(",", thx_color_Colors::$_reParse->matched(2));
			switch($type) {
			case "rgb":case "rgba":{
				return new thx_color_Rgb(thx_color_Colors::_c($values[0]), thx_color_Colors::_c($values[1]), thx_color_Colors::_c($values[2]));
			}break;
			case "hsl":{
				return new thx_color_Hsl(thx_color_Colors::_d($values[0]), thx_color_Colors::_p($values[1]), thx_color_Colors::_p($values[2]));
			}break;
			case "cmyk":{
				return new thx_color_Cmyk(thx_color_Colors::_p($values[0]), thx_color_Colors::_p($values[1]), thx_color_Colors::_p($values[2]), thx_color_Colors::_p($values[3]));
			}break;
			}
		}
		$color = thx_color_Colors::$_reParse->matched(3);
		if(strlen($color) === 3) {
			$color = Iterators::map(_hx_explode("", $color)->iterator(), array(new _hx_lambda(array(&$color, &$s, &$type), "thx_color_Colors_1"), 'execute'))->join("");
		} else {
			if(strlen($color) !== 6) {
				return null;
			}
		}
		return thx_color_Rgb::fromInt(Std::parseInt("0x" . $color));
	}
	static function _c($s) {
		return Std::parseInt(trim($s));
	}
	static function _d($s) {
		$s1 = trim($s);
		if(_hx_substr($s1, -3, null) === "deg") {
			$s1 = _hx_substr($s1, 0, -3);
		} else {
			if(_hx_substr($s1, -1, null) === "º") {
				$s1 = _hx_substr($s1, 0, -1);
			}
		}
		return Std::parseFloat($s1);
	}
	static function _p($s) {
		$s1 = trim($s);
		if(_hx_substr($s1, -1, null) === "%") {
			return Std::parseFloat(_hx_substr($s1, 0, -1)) / 100;
		} else {
			return Std::parseFloat($s1);
		}
	}
	function __toString() { return 'thx.color.Colors'; }
}
thx_color_Colors::$_reParse = new EReg("^(?:(hsl|rgb|rgba|cmyk)\\(([^)]+)\\))|(?:(?:0x|#)([a-f0-9]{3,6}))\$", "i");
function thx_color_Colors_0(&$a, &$b, &$ca, &$cb, &$equation, &$f, $v) {
	{
		return call_user_func_array($f, array($v))->toString();
	}
}
function thx_color_Colors_1(&$color, &$s, &$type, $d, $_) {
	{
		return $d . $d;
	}
}
