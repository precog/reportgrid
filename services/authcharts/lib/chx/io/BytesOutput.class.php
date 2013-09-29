<?php

class chx_io_BytesOutput extends chx_io_Output {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->b = new BytesBuffer();
	}}
	public $b;
	public function writeByte($c) {
		$this->b->b .= chr($c);
		return $this;
	}
	public function writeBytes($buf, $pos, $len) {
		{
			if($pos < 0 || $len < 0 || $pos + $len > $buf->length) {
				throw new HException(new chx_lang_OutsideBoundsException(null, null));
			}
			$this->b->b .= substr($buf->b, $pos, $len);
		}
		return $len;
	}
	public function getBytes() {
		return $this->b->getBytes();
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
	function __toString() { return 'chx.io.BytesOutput'; }
}
