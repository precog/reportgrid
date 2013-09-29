<?php

class thx_math_Equations {
	public function __construct(){}
	static function linear($v) {
		$GLOBALS['%s']->push("thx.math.Equations::linear");
		$�spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	static function polynomial($t, $e) {
		$GLOBALS['%s']->push("thx.math.Equations::polynomial");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Math::pow($t, $e);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function quadratic($t) {
		$GLOBALS['%s']->push("thx.math.Equations::quadratic");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = thx_math_Equations::polynomial($t, 2);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function cubic($t) {
		$GLOBALS['%s']->push("thx.math.Equations::cubic");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = thx_math_Equations::polynomial($t, 3);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function sin($t) {
		$GLOBALS['%s']->push("thx.math.Equations::sin");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = 1 - Math::cos($t * Math::$PI / 2);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function exponential($t) {
		$GLOBALS['%s']->push("thx.math.Equations::exponential");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = thx_math_Equations_0($t);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function circle($t) {
		$GLOBALS['%s']->push("thx.math.Equations::circle");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = 1 - Math::sqrt(1 - $t * $t);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function elastic($t, $a, $p) {
		$GLOBALS['%s']->push("thx.math.Equations::elastic");
		$�spos = $GLOBALS['%s']->length;
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
			$�tmp = 1 + $a * Math::pow(2, 10 * -$t) * Math::sin(($t - $s) * 2 * Math::$PI / $p);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function elasticf($a, $p) {
		$GLOBALS['%s']->push("thx.math.Equations::elasticf");
		$�spos = $GLOBALS['%s']->length;
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
			$�tmp = array(new _hx_lambda(array(&$a, &$p, &$s), "thx_math_Equations_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function back($t, $s) {
		$GLOBALS['%s']->push("thx.math.Equations::back");
		$�spos = $GLOBALS['%s']->length;
		if(null === $s) {
			$s = 1.70158;
		}
		{
			$�tmp = $t * $t * (($s + 1) * $t - $s);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function backf($s) {
		$GLOBALS['%s']->push("thx.math.Equations::backf");
		$�spos = $GLOBALS['%s']->length;
		if(null === $s) {
			$s = 1.70158;
		}
		{
			$�tmp = array(new _hx_lambda(array(&$s), "thx_math_Equations_2"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function bounce($t) {
		$GLOBALS['%s']->push("thx.math.Equations::bounce");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = thx_math_Equations_3($t);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function polynomialf($e) {
		$GLOBALS['%s']->push("thx.math.Equations::polynomialf");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = array(new _hx_lambda(array(&$e), "thx_math_Equations_4"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.math.Equations'; }
}
function thx_math_Equations_0(&$t) {
	$�spos = $GLOBALS['%s']->length;
	if(!_hx_equal($t, 0)) {
		return Math::pow(2, 10 * ($t - 1)) - 1e-3;
	} else {
		return 0;
	}
}
function thx_math_Equations_1(&$a, &$p, &$s, $t) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.math.Equations::elasticf@70");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = 1 + $a * Math::pow(2, 10 * -$t) * Math::sin(($t - $s) * 2 * Math::$PI / $p);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function thx_math_Equations_2(&$s, $t) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.math.Equations::backf@83");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = $t * $t * (($s + 1) * $t - $s);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function thx_math_Equations_3(&$t) {
	$�spos = $GLOBALS['%s']->length;
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
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.math.Equations::polynomialf@96");
		$�spos2 = $GLOBALS['%s']->length;
		thx_math_Equations::polynomial($t, $e);
		$GLOBALS['%s']->pop();
	}
}
