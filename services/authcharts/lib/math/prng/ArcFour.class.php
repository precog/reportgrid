<?php

class math_prng_ArcFour implements math_prng_IPrng{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->i = 0;
		$this->j = 0;
		$this->S = new _hx_array(array());
		$this->setSize(256);
	}}
	public $i;
	public $j;
	public $S;
	public $size;
	public function init($key) {
		$t = null;
		{
			$_g = 0;
			while($_g < 256) {
				$x = $_g++;
				$this->S[$x] = $x;
				unset($x);
			}
		}
		$this->j = 0;
		{
			$_g = 0;
			while($_g < 256) {
				$i = $_g++;
				$this->j = $this->j + $this->S[$i] + $key[$i % $key->length] & 255;
				$t = $this->S[$i];
				$this->S[$i] = $this->j;
				$this->S[$this->j] = $t;
				unset($i);
			}
		}
		$this->i = 0;
		$this->j = 0;
	}
	public function next() {
		if($this->S->length === 0) {
			throw new HException("not initialized");
		}
		$t = null;
		$this->i = $this->i + 1 & 255;
		$this->j = $this->j + $this->S[$this->i] & 255;
		$t = $this->S[$this->i];
		$this->S[$this->i] = $this->S[$this->j];
		$this->S[$this->j] = $t;
		return $this->S[$t + $this->S[$this->i] & 255];
	}
	public function setSize($v) {
		if($v % 4 !== 0 || $v < 32) {
			throw new HException("invalid size");
		}
		$this->size = $v;
		return $v;
	}
	public function toString() {
		return "ArcFour";
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
	function __toString() { return $this->toString(); }
}
