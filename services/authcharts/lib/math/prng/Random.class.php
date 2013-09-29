<?php

class math_prng_Random {
	public function __construct($backend) {
		if(!php_Boot::$skip_constructor) {
		$this->createState($backend);
		$this->initialized = false;
	}}
	public $state;
	public $pool;
	public $pptr;
	public $initialized;
	public function next() {
		if($this->initialized === false) {
			$this->createState(null);
			$this->state->init($this->pool);
			{
				$_g1 = 0; $_g = $this->pool->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					$this->pool[$i] = 0;
					unset($i);
				}
			}
			$this->pptr = 0;
			$this->pool = new _hx_array(array());
			$this->initialized = true;
		}
		return $this->state->next();
	}
	public function nextBytes($bytes, $pos, $len) {
		$_g = 0;
		while($_g < $len) {
			$i = $_g++;
			$bytes->b[$pos + $i] = chr($this->next());
			unset($i);
		}
	}
	public function nextBytesStream($out, $count) {
		$_g = 0;
		while($_g < $count) {
			$i = $_g++;
			$out->writeUInt8($this->next());
			unset($i);
		}
	}
	public function seedInt($x) {
		$this->pool->»a[$this->pptr++] ^= $x & 255;
		$this->pool->»a[$this->pptr++] ^= $x >> 8 & 255;
		$this->pool->»a[$this->pptr++] ^= $x >> 16 & 255;
		$this->pool->»a[$this->pptr++] ^= $x >> 24 & 255;
		if($this->pptr >= $this->state->size) {
			$this->pptr -= $this->state->size;
		}
	}
	public function seedTime() {
		$dt = Date::now()->getTime();
		$m = intval($dt * 1000);
		$this->seedInt($m);
	}
	public function createState($backend) {
		if($backend === null) {
			$this->state = new math_prng_ArcFour();
		} else {
			$this->state = $backend;
		}
		if($this->pool === null) {
			$this->pool = new _hx_array(array());
			$this->pptr = 0;
			$t = null;
			while($this->pptr < $this->state->size) {
				$t = Math::floor(65536 * Math::random());
				$this->pool[$this->pptr++] = _hx_shift_right($t, 8);
				$this->pool[$this->pptr++] = $t & 255;
			}
			$this->pptr = 0;
			$this->seedTime();
		}
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
	function __toString() { return 'math.prng.Random'; }
}
