<?php

class math_reduction_Null implements math_reduction_ModularReduction{
	public function __construct() { 
	}
	public function convert($x) {
		return $x;
	}
	public function revert($x) {
		return $x;
	}
	public function mulTo($x, $y, $r) {
		$x->multiplyTo($y, $r);
	}
	public function sqrTo($x, $r) {
		$x->squareTo($r);
	}
	public function reduce($x) {
	}
	function __toString() { return 'math.reduction.Null'; }
}
