<?php

class php_io__Process_Stdout extends haxe_io_Input {
	public function __construct($p) {
		if(!php_Boot::$skip_constructor) {
		$this->p = $p;
		$this->buf = haxe_io_Bytes::alloc(1);
	}}
	public $p;
	public $buf;
	public function readByte() {
		if($this->readBytes($this->buf, 0, 1) === 0) {
			throw new HException(haxe_io_Error::$Blocked);
		}
		return ord($this->buf->b[0]);
	}
	public function readBytes($str, $pos, $l) {
		if(feof($this->p)) {
			php_io__Process_Stdout_0($this, $l, $pos, $str);
		}
		$r = fread($this->p, $l);
		if(($r === "")) {
			php_io__Process_Stdout_1($this, $l, $pos, $r, $str);
		}
		if(($r === false)) {
			php_io__Process_Stdout_2($this, $l, $pos, $r, $str);
		}
		$b = haxe_io_Bytes::ofString($r);
		$str->blit($pos, $b, 0, strlen($r));
		return strlen($r);
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
	function __toString() { return 'php.io._Process.Stdout'; }
}
function php_io__Process_Stdout_0(&$»this, &$l, &$pos, &$str) {
	throw new HException(new haxe_io_Eof());
}
function php_io__Process_Stdout_1(&$»this, &$l, &$pos, &$r, &$str) {
	throw new HException(new haxe_io_Eof());
}
function php_io__Process_Stdout_2(&$»this, &$l, &$pos, &$r, &$str) {
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
