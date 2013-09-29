<?php

class php_io_FileInput extends haxe_io_Input {
	public function __construct($f) {
		if(!php_Boot::$skip_constructor) {
		$this->__f = $f;
	}}
	public $__f;
	public function readByte() {
		if(feof($this->__f)) {
			php_io_FileInput_0($this);
		}
		$r = fread($this->__f, 1);
		if(($r === false)) {
			php_io_FileInput_1($this, $r);
		}
		return ord($r);
	}
	public function readBytes($s, $p, $l) {
		if(feof($this->__f)) {
			php_io_FileInput_2($this, $l, $p, $s);
		}
		$r = fread($this->__f, $l);
		if(($r === false)) {
			php_io_FileInput_3($this, $l, $p, $r, $s);
		}
		$b = haxe_io_Bytes::ofString($r);
		$s->blit($p, $b, 0, strlen($r));
		return strlen($r);
	}
	public function close() {
		parent::close();
		if($this->__f !== null) {
			fclose($this->__f);
		}
	}
	public function seek($p, $pos) {
		$w = null;
		$»t = ($pos);
		switch($»t->index) {
		case 0:
		{
			$w = SEEK_SET;
		}break;
		case 1:
		{
			$w = SEEK_CUR;
		}break;
		case 2:
		{
			$w = SEEK_END;
		}break;
		}
		$r = fseek($this->__f, $p, $w);
		if(($r === false)) {
			throw new HException(haxe_io_Error::Custom("An error occurred"));
		}
	}
	public function tell() {
		$r = ftell($this->__f);
		if(($r === false)) {
			php_io_FileInput_4($this, $r);
		}
		return $r;
	}
	public function readLine() {
		$r = fgets($this->__f);
		if((false === $r)) {
			throw new HException(new haxe_io_Eof());
		}
		return rtrim($r, "\x0D\x0A");
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
	function __toString() { return 'php.io.FileInput'; }
}
function php_io_FileInput_0(&$»this) {
	throw new HException(new haxe_io_Eof());
}
function php_io_FileInput_1(&$»this, &$r) {
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
function php_io_FileInput_2(&$»this, &$l, &$p, &$s) {
	throw new HException(new haxe_io_Eof());
}
function php_io_FileInput_3(&$»this, &$l, &$p, &$r, &$s) {
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
function php_io_FileInput_4(&$»this, &$r) {
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
