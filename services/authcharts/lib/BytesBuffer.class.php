<?php

class BytesBuffer {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->b = "";
	}}
	public $b;
	public function addByte($byte) {
		$this->b .= chr($byte);
	}
	public function add($src) {
		$this->b .= $src->b;
	}
	public function addBytes($src, $pos, $len) {
		if($pos < 0 || $len < 0 || $pos + $len > $src->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		$this->b .= substr($src->b, $pos, $len);
	}
	public function getBytes() {
		$bytes = new Bytes(strlen($this->b), $this->b);
		$this->b = null;
		return $bytes;
	}
	public function writeByte($b) {
		$this->b .= chr($b);
	}
	public function writeBytes($src, $pos, $len) {
		{
			if($pos < 0 || $len < 0 || $pos + $len > $src->length) {
				throw new HException(new chx_lang_OutsideBoundsException(null, null));
			}
			$this->b .= substr($src->b, $pos, $len);
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
	function __toString() { return 'BytesBuffer'; }
}
