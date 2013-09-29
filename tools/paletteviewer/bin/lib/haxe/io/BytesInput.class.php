<?php

class haxe_io_BytesInput extends haxe_io_Input {
	public function __construct($b, $pos, $len) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("haxe.io.BytesInput::new");
		$»spos = $GLOBALS['%s']->length;
		if($pos === null) {
			$pos = 0;
		}
		if($len === null) {
			$len = $b->length - $pos;
		}
		if($pos < 0 || $len < 0 || $pos + $len > $b->length) {
			throw new HException(haxe_io_Error::$OutsideBounds);
		}
		$this->b = $b->b;
		$this->pos = $pos;
		$this->len = $len;
		$GLOBALS['%s']->pop();
	}}
	public $b;
	public $pos;
	public $len;
	public function readByte() {
		$GLOBALS['%s']->push("haxe.io.BytesInput::readByte");
		$»spos = $GLOBALS['%s']->length;
		if($this->len === 0) {
			throw new HException(new haxe_io_Eof());
		}
		$this->len--;
		{
			$»tmp = ord($this->b[$this->pos++]);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function readBytes($buf, $pos, $len) {
		$GLOBALS['%s']->push("haxe.io.BytesInput::readBytes");
		$»spos = $GLOBALS['%s']->length;
		if($pos < 0 || $len < 0 || $pos + $len > $buf->length) {
			throw new HException(haxe_io_Error::$OutsideBounds);
		}
		if($this->len === 0 && $len > 0) {
			throw new HException(new haxe_io_Eof());
		}
		if($this->len < $len) {
			$len = $this->len;
		}
		$buf->b = substr($buf->b, 0, $pos) . substr($this->b, $this->pos, $len) . substr($buf->b, $pos+$len);
		$this->pos += $len;
		$this->len -= $len;
		{
			$GLOBALS['%s']->pop();
			return $len;
		}
		$GLOBALS['%s']->pop();
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
	function __toString() { return 'haxe.io.BytesInput'; }
}
