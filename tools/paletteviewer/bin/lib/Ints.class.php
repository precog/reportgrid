<?php

class Ints {
	public function __construct(){}
	static function range($start, $stop, $step) {
		$GLOBALS['%s']->push("Ints::range");
		$製pos = $GLOBALS['%s']->length;
		if($step === null) {
			$step = 1;
		}
		if(null === $stop) {
			$stop = $start;
			$start = 0;
		}
		if(($stop - $start) / $step === Math::$POSITIVE_INFINITY) {
			throw new HException(new thx_error_Error("infinite range", null, null, _hx_anonymous(array("fileName" => "Ints.hx", "lineNumber" => 19, "className" => "Ints", "methodName" => "range"))));
		}
		$range = new _hx_array(array()); $i = -1; $j = null;
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
		$GLOBALS['%s']->push("Ints::sign");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($v < 0) ? -1 : 1);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function abs($a) {
		$GLOBALS['%s']->push("Ints::abs");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a < 0) ? -$a : $a);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function min($a, $b) {
		$GLOBALS['%s']->push("Ints::min");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a < $b) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function max($a, $b) {
		$GLOBALS['%s']->push("Ints::max");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a > $b) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function wrap($v, $min, $max) {
		$GLOBALS['%s']->push("Ints::wrap");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Math::round(Floats::wrap($v, $min, $max));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function clamp($v, $min, $max) {
		$GLOBALS['%s']->push("Ints::clamp");
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
		$GLOBALS['%s']->push("Ints::clampSym");
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
	static function interpolate($f, $min, $max, $equation) {
		$GLOBALS['%s']->push("Ints::interpolate");
		$製pos = $GLOBALS['%s']->length;
		if($max === null) {
			$max = 100.0;
		}
		if($min === null) {
			$min = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		{
			$裨mp = Math::round($min + call_user_func_array($equation, array($f)) * ($max - $min));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($min, $max, $equation) {
		$GLOBALS['%s']->push("Ints::interpolatef");
		$製pos = $GLOBALS['%s']->length;
		if($max === null) {
			$max = 1.0;
		}
		if($min === null) {
			$min = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		$d = $max - $min;
		{
			$裨mp = array(new _hx_lambda(array(&$d, &$equation, &$max, &$min), "Ints_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Ints::format");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Ints::formatf($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Ints::formatf");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Floats::formatf(null, thx_culture_FormatParams::params($param, $params, "I"), $culture);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reparse;
	static function canParse($s) {
		$GLOBALS['%s']->push("Ints::canParse");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Ints::$_reparse->match($s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parse($s) {
		$GLOBALS['%s']->push("Ints::parse");
		$製pos = $GLOBALS['%s']->length;
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		{
			$裨mp = Std::parseInt($s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Ints::compare");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = $a - $b;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Ints'; }
}
Ints::$_reparse = new EReg("^([+-])?\\d+\$", "");
function Ints_0(&$d, &$equation, &$max, &$min, $f) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Ints::interpolatef@85");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = Math::round($min + call_user_func_array($equation, array($f)) * $d);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
