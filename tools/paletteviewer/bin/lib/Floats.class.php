<?php

class Floats {
	public function __construct(){}
	static function normalize($v) {
		$GLOBALS['%s']->push("Floats::normalize");
		$製pos = $GLOBALS['%s']->length;
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
		$製pos = $GLOBALS['%s']->length;
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
		$製pos = $GLOBALS['%s']->length;
		if($v < -$max) {
			$裨mp = -$max;
			$GLOBALS['%s']->pop();
			return $裨mp;
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
		$製pos = $GLOBALS['%s']->length;
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
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($v < 0) ? -1 : 1);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function abs($a) {
		$GLOBALS['%s']->push("Floats::abs");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a < 0) ? -$a : $a);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function min($a, $b) {
		$GLOBALS['%s']->push("Floats::min");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a < $b) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function max($a, $b) {
		$GLOBALS['%s']->push("Floats::max");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a > $b) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function wrap($v, $min, $max) {
		$GLOBALS['%s']->push("Floats::wrap");
		$製pos = $GLOBALS['%s']->length;
		$range = $max - $min + 1;
		if($v < $min) {
			$v += $range * (($min - $v) / $range + 1);
		}
		{
			$裨mp = $min + ($v - $min) % $range;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function circularWrap($v, $max) {
		$GLOBALS['%s']->push("Floats::circularWrap");
		$製pos = $GLOBALS['%s']->length;
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
		$製pos = $GLOBALS['%s']->length;
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
			$裨mp = $a + call_user_func_array($equation, array($f)) * ($b - $a);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Floats::interpolatef");
		$製pos = $GLOBALS['%s']->length;
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
			$裨mp = array(new _hx_lambda(array(&$a, &$b, &$d, &$equation), "Floats_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateClampf($min, $max, $equation) {
		$GLOBALS['%s']->push("Floats::interpolateClampf");
		$製pos = $GLOBALS['%s']->length;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		{
			$裨mp = array(new _hx_lambda(array(&$equation, &$max, &$min), "Floats_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Floats::format");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Floats::formatf($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Floats::formatf");
		$製pos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		$decimals = (($params->length > 0) ? Std::parseInt($params[0]) : null);
		switch($format) {
		case "D":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_2"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		case "I":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_3"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		case "C":{
			$s = Floats_4($culture, $decimals, $format, $param, $params);
			{
				$裨mp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params, &$s), "Floats_5"), 'execute');
				$GLOBALS['%s']->pop();
				return $裨mp;
			}
		}break;
		case "P":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_6"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		case "M":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_7"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		default:{
			$裨mp = Floats_8($culture, $decimals, $format, $param, $params);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reparse;
	static function canParse($s) {
		$GLOBALS['%s']->push("Floats::canParse");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Floats::$_reparse->match($s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parse($s) {
		$GLOBALS['%s']->push("Floats::parse");
		$製pos = $GLOBALS['%s']->length;
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		{
			$裨mp = Std::parseFloat($s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Floats::compare");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isNumeric($v) {
		$GLOBALS['%s']->push("Floats::isNumeric");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Std::is($v, _hx_qtype("Float")) || Std::is($v, _hx_qtype("Int"));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function equals($a, $b, $approx) {
		$GLOBALS['%s']->push("Floats::equals");
		$製pos = $GLOBALS['%s']->length;
		if($approx === null) {
			$approx = 1e-5;
		}
		if(Math::isNaN($a)) {
			$裨mp = Math::isNaN($b);
			$GLOBALS['%s']->pop();
			return $裨mp;
		} else {
			if(Math::isNaN($b)) {
				$GLOBALS['%s']->pop();
				return false;
			} else {
				if(!Math::isFinite($a) && !Math::isFinite($b)) {
					$裨mp = ($a > 0) == $b > 0;
					$GLOBALS['%s']->pop();
					return $裨mp;
				}
			}
		}
		{
			$裨mp = Math::abs($b - $a) < $approx;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function uninterpolatef($a, $b) {
		$GLOBALS['%s']->push("Floats::uninterpolatef");
		$製pos = $GLOBALS['%s']->length;
		$b = 1 / ($b - $a);
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$b), "Floats_9"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function uninterpolateClampf($a, $b) {
		$GLOBALS['%s']->push("Floats::uninterpolateClampf");
		$製pos = $GLOBALS['%s']->length;
		$b = 1 / ($b - $a);
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$b), "Floats_10"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function round($number, $precision) {
		$GLOBALS['%s']->push("Floats::round");
		$製pos = $GLOBALS['%s']->length;
		if($precision === null) {
			$precision = 2;
		}
		$number *= Math::pow(10, $precision);
		{
			$裨mp = Math::round($number) / Math::pow(10, $precision);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Floats'; }
}
Floats::$_reparse = new EReg("^(\\+|-)?\\d+(\\.\\d+)?(e-?\\d+)?\$", "");
function Floats_0(&$a, &$b, &$d, &$equation, $f) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::interpolatef@106");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = $a + call_user_func_array($equation, array($f)) * $d;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_1(&$equation, &$max, &$min, $a, $b) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::interpolateClampf@114");
		$製pos2 = $GLOBALS['%s']->length;
		$d = $b - $a;
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$b, &$d, &$equation, &$max, &$min), "Floats_11"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_2(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@134");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_FormatNumber::decimal($v, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_3(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@136");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_FormatNumber::int($v, $culture);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_4(&$culture, &$decimals, &$format, &$param, &$params) {
	$製pos = $GLOBALS['%s']->length;
	if($params->length > 1) {
		return $params[1];
	}
}
function Floats_5(&$culture, &$decimals, &$format, &$param, &$params, &$s, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@139");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_FormatNumber::currency($v, $s, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_6(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@141");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_FormatNumber::percent($v, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_7(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::formatf@143");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_FormatNumber::permille($v, $decimals, $culture);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_8(&$culture, &$decimals, &$format, &$param, &$params) {
	$製pos = $GLOBALS['%s']->length;
	throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 145, "className" => "Floats", "methodName" => "formatf"))));
}
function Floats_9(&$a, &$b, $x) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::uninterpolatef@186");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = ($x - $a) * $b;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_10(&$a, &$b, $x) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::uninterpolateClampf@192");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = Floats::clamp(($x - $a) * $b, 0.0, 1.0);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Floats_11(&$a, &$b, &$d, &$equation, &$max, &$min, $f) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Floats::round@117");
		$製pos3 = $GLOBALS['%s']->length;
		{
			$裨mp = $a + call_user_func_array($equation, array(Floats::clamp($f, $min, $max))) * $d;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
