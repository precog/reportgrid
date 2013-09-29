<?php

class math_reduction_Classic implements math_reduction_ModularReduction{
	public function __construct($m) {
		if(!php_Boot::$skip_constructor) {
		$this->m = $m;
	}}
	public $m;
	public function convert($x) {
		if($x->sign < 0 || $x->compare($this->m) >= 0) {
			return $x->mod($this->m);
		}
		return $x;
	}
	public function revert($x) {
		return $x;
	}
	public function reduce($x) {
		$x->divRemTo($this->m, null, $x);
	}
	public function mulTo($x, $y, $r) {
		$x->multiplyTo($y, $r);
		$this->reduce($r);
	}
	public function sqrTo($x, $r) {
		$x->squareTo($r);
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
	function __toString() { return 'math.reduction.Classic'; }
}
