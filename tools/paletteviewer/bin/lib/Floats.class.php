<?php

class Floats {
	public function __construct(){}
	static function normalize($v) {
		$GLOBALS['%s']->push("Floats::normalize");
		$�spos = $GLOBALS['%s']->length;
		if($v < 0.0) {
			$GLOBALS['%s']->pop();
			return 0.0;
		} else {
			if($v > 1.0) {
				$GLOBALS['%s']->pop();
				return 1.0;
			} else {
				$GLOBALS['%s']->pop();
				return $v;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function clamp($v, $min, $max) {
		$GLOBALS['%s']->push("Floats::clamp");
		$�spos = $GLOBALS['%s']->length;
		if($v < $min) {
			$GLOBALS['%s']->pop();
			return $min;
		} else {
			if($v > $max) {
				$GLOBALS['%s']->pop();
				return $max;
			} else {
				$GLOBALS['%s']->pop();
				return $v;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function clampSym($v, $max) {
		$GLOBALS['%s']->push("Floats::clampSym");
		$�spos = $GLOBALS['%s']->length;
		if($v < -$max) {
			$�tmp = -$max;
			$GLOBALS['%s']->pop();
			return $�tmp;
		} else {
			if($v > $max) {
				$GLOBALS['%s']->pop();
				return $max;
			} else {
				$GLOBALS['%s']->pop();
				return $v;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function range($start, $stop, $step) {
		$GLOBALS['%s']->push("Floats::range");
		$�spos = $GLOBALS['%s']->length;
		if($step === null) {
			$step = 1.0;
		}
		if(null === $stop) {
			$stop = $start;
			$start = 0.0;
		}
		if(($stop - $start) / $step === Math::$POSITIVE_INFINITY) {
			throw new HException(new thx_error_Error("infinite range", null, null, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 50, "className" => "Floats", "methodName" => "range"))));
		}
		$range = new _hx_array(array()); $i = -1.0; $j = null;
		if($step < 0) {
			while(($j = $start + $step * ++$i) > $stop) {
				$range->push($j);
			}
		} else {
			while(($j = $start + $step * ++$i) < $stop) {
				$range->push($j);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $range;
		}
		$GLOBALS['%s']->pop();
	}
	static function sign($v) {
		$GLOBALS['%s']->push("Floats::sign");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = (($v < 0) ? -1 : 1);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function abs($a) {
		$GLOBALS['%s']->push("Floats::abs");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = (($a < 0) ? -$a : $a);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function min($a, $b) {
		$GLOBALS['%s']->push("Floats::min");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = (($a < $b) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function max($a, $b) {
		$GLOBALS['%s']->push("Floats::max");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = (($a > $b) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function wrap($v, $min, $max) {
		$GLOBALS['%s']->push("Floats::wrap");
		$�spos = $GLOBALS['%s']->length;
		$range = $max - $min + 1;
		if($v < $min) {
			$v += $range * (($min - $v) / $range + 1);
		}
		{
			$�tmp = $min + ($v - $min) % $range;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function circularWrap($v, $max) {
		$GLOBALS['%s']->push("Floats::circularWrap");
		$�spos = $GLOBALS['%s']->length;
		$v = $v % $max;
		if($v < 0) {
			$v += $max;
		}
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($f, $a, $b, $equation) {
		$GLOBALS['%s']->push("Floats::interpolate");
		$�spos = $GLOBALS['%s']->length;
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		{
			$�tmp = $a + call_user_func_array($equation, array($f)) * ($b - $a);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Floats::interpolatef");
		$�spos = $GLOBALS['%s']->length;
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		$d = $b - $a;
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$d, &$equation), "Floats_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateClampf($min, $max, $equation) {
		$GLOBALS['%s']->push("Floats::interpolateClampf");
		$�spos = $GLOBALS['%s']->length;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		{
			$�tmp = array(new _hx_lambda(array(&$equation, &$max, &$min), "Floats_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Floats::format");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Floats::formatf($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Floats::formatf");
		$�spos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		$decimals = (($params->length > 0) ? Std::parseInt($params[0]) : null);
		switch($format) {
		case "D":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_2"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "I":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_3"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "C":{
			$s = Floats_4($culture, $decimals, $format, $param, $params);
			{
				$�tmp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params, &$s), "Floats_5"), 'execute');
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case "P":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_6"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "M":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_7"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		default:{
			$�tmp = Floats_8($culture, $decimals, $format, $param, $params);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reparse;
	static function canParse($s) {
		$GLOBALS['%s']->push("Floats::canParse");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Floats::$_reparse->match($s);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parse($s) {
		$GLOBALS['%s']->push("Floats::parse");
		$�spos = $GLOBALS['%s']->length;
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		{
			$�tmp = Std::parseFloat($s);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Floats::compare");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isNumeric($v) {
		$GLOBALS['%s']->push("Floats::isNumeric");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Std::is($v, _hx_qtype("Float")) || Std::is($v, _hx_qtype("Int"));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function equals($a, $b, $approx) {
		$GLOBALS['%s']->push("Floats::equals");
		$�spos = $GLOBALS['%s']->length;
		if($approx === null) {
			$approx = 1e-5;
		}
		if(Math::isNaN($a)) {
			$�tmp = Math::isNaN($b);
			$GLOBALS['%s']->pop();
			return $�tmp;
		} else {
			if(Math::isNaN($b)) {
				$GLOBALS['%s']->pop();
				return false;
			} else {
				if(!Math::isFinite($a) && !Math::isFinite($b)) {
					$�tmp = ($a > 0) == $b > 0;
					$GLOBALS['%s']->pop();
					return $�tmp;
				}
			}
		}
		{
			$�tmp = Math::abs($b - $a) < $approx;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function uninterpolatef($a, $b) {
		$GLOBALS['%s']->push("Floats::uninterpolatef");
		$�spos = $GLOBALS['%s']->length;
		$b = 1 / ($b - $a);
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b), "Floats_9"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function uninterpolateClampf($a, $b) {
		$GLOBALS['%s']->push("Floats::uninterpolateClampf");
		$�spos = $GLOBALS['%s']->length;
		$b = 1 / ($b - $a);
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b), "Floats_10"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function round($number, $precision) {
		$GLOBALS['%s']->push("Floats::round");
		$�spos = $GLOBALS['%s']->length;
		if($precision === null) {
			$precision = 2;
		}
		$number *= Math::pow(10, $precision);
		{
			$�tmp = Math::round($number) / Math::pow(10, $precision);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Floats'; }
}
Floats::$_reparse = new EReg("^(\\+|-)?\\d+(\\.\\d+)?(e-?\\d+)?\$", "");
function Floats_0(&$a, &$b, &$d, &$equation, $f) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::interpolatef@106");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = $a + call_user_func_array($equation, array($f)) * $d;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_1(&$equation, &$max, &$min, $a, $b) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::interpolateClampf@114");
		$�spos2 = $GLOBALS['%s']->length;
		$d = $b - $a;
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$d, &$equation, &$max, &$min), "Floats_11"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_2(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@134");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_FormatNumber::decimal($v, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_3(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@136");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_FormatNumber::int($v, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_4(&$culture, &$decimals, &$format, &$param, &$params) {
	$�spos = $GLOBALS['%s']->length;
	if($params->length > 1) {
		return $params[1];
	}
}
function Floats_5(&$culture, &$decimals, &$format, &$param, &$params, &$s, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@139");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_FormatNumber::currency($v, $s, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_6(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@141");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_FormatNumber::percent($v, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_7(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@143");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_FormatNumber::permille($v, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_8(&$culture, &$decimals, &$format, &$param, &$params) {
	$�spos = $GLOBALS['%s']->length;
	throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 145, "className" => "Floats", "methodName" => "formatf"))));
}
function Floats_9(&$a, &$b, $x) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::uninterpolatef@186");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = ($x - $a) * $b;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_10(&$a, &$b, $x) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::uninterpolateClampf@192");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Floats::clamp(($x - $a) * $b, 0.0, 1.0);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_11(&$a, &$b, &$d, &$equation, &$max, &$min, $f) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::round@117");
		$�spos3 = $GLOBALS['%s']->length;
		{
			$�tmp = $a + call_user_func_array($equation, array(Floats::clamp($f, $min, $max))) * $d;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
