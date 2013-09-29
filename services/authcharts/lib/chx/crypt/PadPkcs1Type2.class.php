<?php

class chx_crypt_PadPkcs1Type2 extends chx_crypt_PadPkcs1Type1 implements chx_crypt_IPad{
	public function __construct($size) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct($size);
		$this->typeByte = 2;
		$this->rng = new math_prng_Random(null);
	}}
	public $rng;
	public function getPadByte() {
		$x = 0;
		while($x === 0) {
			$x = $this->rng->next();
		}
		return $x;
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
	function __toString() { return 'chx.crypt.PadPkcs1Type2'; }
}
