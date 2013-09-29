<?php

class Floats {
	public function __construct(){}
	static function normalize($v) {
		if($v < 0.0) {
			return 0.0;
		} else {
			if($v > 1.0) {
				return 1.0;
			} else {
				return $v;
			}
		}
	}
	static function clamp($v, $min, $max) {
		if($v < $min) {
			return $min;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function clampSym($v, $max) {
		if($v < -$max) {
			return -$max;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function range($start, $stop, $step) {
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
		return $range;
	}
	static function sign($v) {
		return (($v < 0) ? -1 : 1);
	}
	static function abs($a) {
		return (($a < 0) ? -$a : $a);
	}
	static function min($a, $b) {
		return (($a < $b) ? $a : $b);
	}
	static function max($a, $b) {
		return (($a > $b) ? $a : $b);
	}
	static function wrap($v, $min, $max) {
		$range = $max - $min + 1;
		if($v < $min) {
			$v += $range * (($min - $v) / $range + 1);
		}
		return $min + ($v - $min) % $range;
	}
	static function circularWrap($v, $max) {
		$v = $v % $max;
		if($v < 0) {
			$v += $max;
		}
		return $v;
	}
	static function interpolate($f, $a, $b, $equation) {
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return $a + call_user_func_array($equation, array($f)) * ($b - $a);
	}
	static function interpolatef($a, $b, $equation) {
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
		return array(new _hx_lambda(array(&$a, &$b, &$d, &$equation), "Floats_0"), 'execute');
	}
	static function interpolateClampf($min, $max, $equation) {
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return array(new _hx_lambda(array(&$equation, &$max, &$min), "Floats_1"), 'execute');
	}
	static function format($v, $param, $params, $culture) {
		return call_user_func_array(Floats::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		$decimals = (($params->length > 0) ? Std::parseInt($params[0]) : null);
		switch($format) {
		case "D":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_2"), 'execute');
		}break;
		case "I":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_3"), 'execute');
		}break;
		case "C":{
			$s = Floats_4($culture, $decimals, $format, $param, $params);
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params, &$s), "Floats_5"), 'execute');
		}break;
		case "P":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_6"), 'execute');
		}break;
		case "M":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_7"), 'execute');
		}break;
		default:{
			Floats_8($culture, $decimals, $format, $param, $params);
		}break;
		}
	}
	static $_reparse;
	static function canParse($s) {
		return Floats::$_reparse->match($s);
	}
	static function parse($s) {
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		return Std::parseFloat($s);
	}
	static function compare($a, $b) {
		return (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
	}
	static function isNumeric($v) {
		return Std::is($v, _hx_qtype("Float")) || Std::is($v, _hx_qtype("Int"));
	}
	static function equals($a, $b, $approx) {
		if($approx === null) {
			$approx = 1e-5;
		}
		if(Math::isNaN($a)) {
			return Math::isNaN($b);
		} else {
			if(Math::isNaN($b)) {
				return false;
			} else {
				if(!Math::isFinite($a) && !Math::isFinite($b)) {
					return ($a > 0) == $b > 0;
				}
			}
		}
		return Math::abs($b - $a) < $approx;
	}
	static function uninterpolatef($a, $b) {
		$b = 1 / ($b - $a);
		return array(new _hx_lambda(array(&$a, &$b), "Floats_9"), 'execute');
	}
	static function uninterpolateClampf($a, $b) {
		$b = 1 / ($b - $a);
		return array(new _hx_lambda(array(&$a, &$b), "Floats_10"), 'execute');
	}
	static function round($number, $precision) {
		if($precision === null) {
			$precision = 2;
		}
		$number *= Math::pow(10, $precision);
		return Math::round($number) / Math::pow(10, $precision);
	}
	function __toString() { return 'Floats'; }
}
Floats::$_reparse = new EReg("^(\\+|-)?\\d+(\\.\\d+)?(e-?\\d+)?\$", "");
function Floats_0(&$a, &$b, &$d, &$equation, $f) {
	{
		return $a + call_user_func_array($equation, array($f)) * $d;
	}
}
function Floats_1(&$equation, &$max, &$min, $a, $b) {
	{
		$d = $b - $a;
		return array(new _hx_lambda(array(&$a, &$b, &$d, &$equation, &$max, &$min), "Floats_11"), 'execute');
	}
}
function Floats_2(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::decimal($v, $decimals, $culture);
	}
}
function Floats_3(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::int($v, $culture);
	}
}
function Floats_4(&$culture, &$decimals, &$format, &$param, &$params) {
	if($params->length > 1) {
		return $params[1];
	}
}
function Floats_5(&$culture, &$decimals, &$format, &$param, &$params, &$s, $v) {
	{
		return thx_culture_FormatNumber::currency($v, $s, $decimals, $culture);
	}
}
function Floats_6(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::percent($v, $decimals, $culture);
	}
}
function Floats_7(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::permille($v, $decimals, $culture);
	}
}
function Floats_8(&$culture, &$decimals, &$format, &$param, &$params) {
	throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 145, "className" => "Floats", "methodName" => "formatf"))));
}
function Floats_9(&$a, &$b, $x) {
	{
		return ($x - $a) * $b;
	}
}
function Floats_10(&$a, &$b, $x) {
	{
		return Floats::clamp(($x - $a) * $b, 0.0, 1.0);
	}
}
function Floats_11(&$a, &$b, &$d, &$equation, &$max, &$min, $f) {
	{
		return $a + call_user_func_array($equation, array(Floats::clamp($f, $min, $max))) * $d;
	}
}
