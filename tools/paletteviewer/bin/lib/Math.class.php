<?php

class Math {
	public function __construct(){}
	static $PI;
	static $NaN;
	static $POSITIVE_INFINITY;
	static $NEGATIVE_INFINITY;
	static function abs($v) {
		$GLOBALS['%s']->push("Math::abs");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = abs($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function min($a, $b) {
		$GLOBALS['%s']->push("Math::min");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = min($a, $b);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function max($a, $b) {
		$GLOBALS['%s']->push("Math::max");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = max($a, $b);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function sin($v) {
		$GLOBALS['%s']->push("Math::sin");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = sin($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function cos($v) {
		$GLOBALS['%s']->push("Math::cos");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = cos($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function atan2($y, $x) {
		$GLOBALS['%s']->push("Math::atan2");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = atan2($y, $x);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function tan($v) {
		$GLOBALS['%s']->push("Math::tan");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = tan($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function exp($v) {
		$GLOBALS['%s']->push("Math::exp");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = exp($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function log($v) {
		$GLOBALS['%s']->push("Math::log");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = log($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function sqrt($v) {
		$GLOBALS['%s']->push("Math::sqrt");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = sqrt($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function round($v) {
		$GLOBALS['%s']->push("Math::round");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (int) floor($v + 0.5);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function floor($v) {
		$GLOBALS['%s']->push("Math::floor");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (int) floor($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ceil($v) {
		$GLOBALS['%s']->push("Math::ceil");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (int) ceil($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function atan($v) {
		$GLOBALS['%s']->push("Math::atan");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = atan($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function asin($v) {
		$GLOBALS['%s']->push("Math::asin");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = asin($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function acos($v) {
		$GLOBALS['%s']->push("Math::acos");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = acos($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function pow($v, $exp) {
		$GLOBALS['%s']->push("Math::pow");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = pow($v, $exp);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function random() {
		$GLOBALS['%s']->push("Math::random");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = mt_rand() / mt_getrandmax();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isNaN($f) {
		$GLOBALS['%s']->push("Math::isNaN");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = is_nan($f);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isFinite($f) {
		$GLOBALS['%s']->push("Math::isFinite");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = is_finite($f);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Math'; }
}
{
	Math::$PI = M_PI;
	Math::$NaN = acos(1.01);
	Math::$NEGATIVE_INFINITY = log(0);
	Math::$POSITIVE_INFINITY = -Math::$NEGATIVE_INFINITY;
}
