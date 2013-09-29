<?php

class math_reduction_Montgomery implements math_reduction_ModularReduction{
	public function __construct($x) {
		if(!php_Boot::$skip_constructor) {
		$this->m = $x;
		$this->mp = $this->m->invDigit();
		$this->mpl = $this->mp & 32767;
		$this->mph = $this->mp >> 15;
		$this->um = (1 << math_BigInteger::$DB - 15) - 1;
		$this->mt2 = 2 * $this->m->t;
	}}
	public $m;
	public $mt2;
	public $mp;
	public $mpl;
	public $mph;
	public $um;
	public function convert($x) {
		$r = math_BigInteger::nbi();
		$x->abs()->dlShiftTo($this->m->t, $r);
		$r->divRemTo($this->m, null, $r);
		if($x->sign < 0 && $r->compare(math_BigInteger::getZERO()) > 0) {
			$this->m->subTo($r, $r);
		}
		return $r;
	}
	public function revert($x) {
		$r = math_BigInteger::nbi();
		$x->copyTo($r);
		$this->reduce($r);
		return $r;
	}
	public function reduce($x) {
		$x->padTo($this->mt2);
		$i = 0;
		while($i < $this->m->t) {
			$j = $x->chunks->»a[$i] & 32767;
			$u0 = $j * $this->mpl + (($j * $this->mph + ($x->chunks->»a[$i] >> 15) * $this->mpl & $this->um) << 15) & math_BigInteger::$DM;
			$j = $i + $this->m->t;
			$x->chunks->»a[$j] += $this->m->am(0, $u0, $x, $i, 0, $this->m->t);
			while($x->chunks->»a[$j] >= math_BigInteger::$DV) {
				$x->chunks->»a[$j] -= math_BigInteger::$DV;
				if($x->chunks->length < $j + 2) {
					$x->chunks[$j + 1] = 0;
				}
				$x->chunks->»a[++$j]++;
			}
			$i++;
			unset($u0,$j);
		}
		$x->clamp();
		$x->drShiftTo($this->m->t, $x);
		if($x->compare($this->m) >= 0) {
			$x->subTo($this->m, $x);
		}
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
	function __toString() { return 'math.reduction.Montgomery'; }
}
