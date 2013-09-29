<?php

class math_reduction_Barrett implements math_reduction_ModularReduction{
	public function __construct($m) {
		if(!php_Boot::$skip_constructor) {
		$this->r2 = math_BigInteger::nbi();
		$this->q3 = math_BigInteger::nbi();
		math_BigInteger::getONE()->dlShiftTo(2 * $m->t, $this->r2);
		$this->mu = $this->r2->div($m);
		$this->m = $m;
	}}
	public $m;
	public $mu;
	public $r2;
	public $q3;
	public function convert($x) {
		if($x->sign < 0 || $x->t > 2 * $this->m->t) {
			return $x->mod($this->m);
		} else {
			if($x->compare($this->m) < 0) {
				return $x;
			} else {
				$r = math_BigInteger::nbi();
				$x->copyTo($r);
				$this->reduce($r);
				return $r;
			}
		}
	}
	public function revert($x) {
		return $x;
	}
	public function reduce($x) {
		$x->drShiftTo($this->m->t - 1, $this->r2);
		if($x->t > $this->m->t + 1) {
			$x->t = $this->m->t + 1;
			$x->clamp();
		}
		$this->mu->multiplyUpperTo($this->r2, $this->m->t + 1, $this->q3);
		$this->m->multiplyLowerTo($this->q3, $this->m->t + 1, $this->r2);
		while($x->compare($this->r2) < 0) {
			$x->dAddOffset(1, $this->m->t + 1);
		}
		$x->subTo($this->r2, $x);
		while($x->compare($this->m) >= 0) {
			$x->subTo($this->m, $x);
		}
	}
	public function sqrTo($x, $r) {
		$x->squareTo($r);
		$this->reduce($r);
	}
	public function mulTo($x, $y, $r) {
		$x->multiplyTo($y, $r);
		$this->reduce($r);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return 'math.reduction.Barrett'; }
}
