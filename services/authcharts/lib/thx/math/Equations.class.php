<?php

class thx_math_Equations {
	public function __construct(){}
	static function linear($v) {
		return $v;
	}
	static function polynomial($t, $e) {
		return Math::pow($t, $e);
	}
	static function quadratic($t) {
		return thx_math_Equations::polynomial($t, 2);
	}
	static function cubic($t) {
		return thx_math_Equations::polynomial($t, 3);
	}
	static function sin($t) {
		return 1 - Math::cos($t * Math::$PI / 2);
	}
	static function exponential($t) {
		return thx_math_Equations_0($t);
	}
	static function circle($t) {
		return 1 - Math::sqrt(1 - $t * $t);
	}
	static function elastic($t, $a, $p) {
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
		return 1 + $a * Math::pow(2, 10 * -$t) * Math::sin(($t - $s) * 2 * Math::$PI / $p);
	}
	static function elasticf($a, $p) {
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
		return array(new _hx_lambda(array(&$a, &$p, &$s), "thx_math_Equations_1"), 'execute');
	}
	static function back($t, $s) {
		if(null === $s) {
			$s = 1.70158;
		}
		return $t * $t * (($s + 1) * $t - $s);
	}
	static function backf($s) {
		if(null === $s) {
			$s = 1.70158;
		}
		return array(new _hx_lambda(array(&$s), "thx_math_Equations_2"), 'execute');
	}
	static function bounce($t) {
		return thx_math_Equations_3($t);
	}
	static function polynomialf($e) {
		return array(new _hx_lambda(array(&$e), "thx_math_Equations_4"), 'execute');
	}
	function __toString() { return 'thx.math.Equations'; }
}
function thx_math_Equations_0(&$t) {
	if(!_hx_equal($t, 0)) {
		return Math::pow(2, 10 * ($t - 1)) - 1e-3;
	} else {
		return 0;
	}
}
function thx_math_Equations_1(&$a, &$p, &$s, $t) {
	{
		return 1 + $a * Math::pow(2, 10 * -$t) * Math::sin(($t - $s) * 2 * Math::$PI / $p);
	}
}
function thx_math_Equations_2(&$s, $t) {
	{
		return $t * $t * (($s + 1) * $t - $s);
	}
}
function thx_math_Equations_3(&$t) {
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
	{
		thx_math_Equations::polynomial($t, $e);
	}
}
