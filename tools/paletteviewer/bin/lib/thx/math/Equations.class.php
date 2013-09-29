<?php

class thx_math_Equations {
	public function __construct(){}
	static function linear($v) {
		$GLOBALS['%s']->push("thx.math.Equations::linear");
		$製pos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	static function polynomial($t, $e) {
		$GLOBALS['%s']->push("thx.math.Equations::polynomial");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Math::pow($t, $e);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function quadratic($t) {
		$GLOBALS['%s']->push("thx.math.Equations::quadratic");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = thx_math_Equations::polynomial($t, 2);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function cubic($t) {
		$GLOBALS['%s']->push("thx.math.Equations::cubic");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = thx_math_Equations::polynomial($t, 3);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function sin($t) {
		$GLOBALS['%s']->push("thx.math.Equations::sin");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = 1 - Math::cos($t * Math::$PI / 2);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function exponential($t) {
		$GLOBALS['%s']->push("thx.math.Equations::exponential");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = thx_math_Equations_0($t);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function circle($t) {
		$GLOBALS['%s']->push("thx.math.Equations::circle");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = 1 - Math::sqrt(1 - $t * $t);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function elastic($t, $a, $p) {
		$GLOBALS['%s']->push("thx.math.Equations::elastic");
		$製pos = $GLOBALS['%s']->length;
		$s = null;
		if(null === $p) {
			$p = 0.45;
		}
		if(null === $a) {
			$a = 1;
			$s = $p / 4;
		} else {
			$s = $p / (2 * Math::$PI) / Math::asin(1 / $a);
		}
		{
			$裨mp = 1 + $a * Math::pow(2, 10 * -$t) * Math::sin(($t - $s) * 2 * Math::$PI / $p);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function elasticf($a, $p) {
		$GLOBALS['%s']->push("thx.math.Equations::elasticf");
		$製pos = $GLOBALS['%s']->length;
		$s = null;
		if(null === $p) {
			$p = 0.45;
		}
		if(null === $a) {
			$a = 1;
			$s = $p / 4;
		} else {
			$s = $p / (2 * Math::$PI) / Math::asin(1 / $a);
		}
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$p, &$s), "thx_math_Equations_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function back($t, $s) {
		$GLOBALS['%s']->push("thx.math.Equations::back");
		$製pos = $GLOBALS['%s']->length;
		if(null === $s) {
			$s = 1.70158;
		}
		{
			$裨mp = $t * $t * (($s + 1) * $t - $s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function backf($s) {
		$GLOBALS['%s']->push("thx.math.Equations::backf");
		$製pos = $GLOBALS['%s']->length;
		if(null === $s) {
			$s = 1.70158;
		}
		{
			$裨mp = array(new _hx_lambda(array(&$s), "thx_math_Equations_2"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function bounce($t) {
		$GLOBALS['%s']->push("thx.math.Equations::bounce");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = thx_math_Equations_3($t);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function polynomialf($e) {
		$GLOBALS['%s']->push("thx.math.Equations::polynomialf");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = array(new _hx_lambda(array(&$e), "thx_math_Equations_4"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.math.Equations'; }
}
function thx_math_Equations_0(&$t) {
	$製pos = $GLOBALS['%s']->length;
	if(!_hx_equal($t, 0)) {
		return Math::pow(2, 10 * ($t - 1)) - 1e-3;
	} else {
		return 0;
	}
}
function thx_math_Equations_1(&$a, &$p, &$s, $t) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.math.Equations::elasticf@70");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = 1 + $a * Math::pow(2, 10 * -$t) * Math::sin(($t - $s) * 2 * Math::$PI / $p);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function thx_math_Equations_2(&$s, $t) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.math.Equations::backf@83");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = $t * $t * (($s + 1) * $t - $s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function thx_math_Equations_3(&$t) {
	$製pos = $GLOBALS['%s']->length;
	if($t < 1 / 2.75) {
		return 7.5625 * $t * $t;
	} else {
		if($t < 2 / 2.75) {
			return 7.5625 * ($t -= 1.5 / 2.75) * $t + .75;
		} else {
			if($t < 2.5 / 2.75) {
				return 7.5625 * ($t -= 2.25 / 2.75) * $t + .9375;
			} else {
				return 7.5625 * ($t -= 2.625 / 2.75) * $t + .984375;
			}
		}
	}
}
function thx_math_Equations_4(&$e, $t) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.math.Equations::polynomialf@96");
		$製pos2 = $GLOBALS['%s']->length;
		thx_math_Equations::polynomial($t, $e);
		$GLOBALS['%s']->pop();
	}
}
