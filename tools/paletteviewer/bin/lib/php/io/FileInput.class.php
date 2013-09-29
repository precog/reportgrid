<?php

class php_io_FileInput extends haxe_io_Input {
	public function __construct($f) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("php.io.FileInput::new");
		$»spos = $GLOBALS['%s']->length;
		$this->__f = $f;
		$GLOBALS['%s']->pop();
	}}
	public $__f;
	public function readByte() {
		$GLOBALS['%s']->push("php.io.FileInput::readByte");
		$»spos = $GLOBALS['%s']->length;
		if(feof($this->__f)) {
			$»tmp = php_io_FileInput_0($this);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$r = fread($this->__f, 1);
		if(($r === false)) {
			$»tmp = php_io_FileInput_1($this, $r);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$»tmp = ord($r);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function readBytes($s, $p, $l) {
		$GLOBALS['%s']->push("php.io.FileInput::readBytes");
		$»spos = $GLOBALS['%s']->length;
		if(feof($this->__f)) {
			$»tmp = php_io_FileInput_2($this, $l, $p, $s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$r = fread($this->__f, $l);
		if(($r === false)) {
			$»tmp = php_io_FileInput_3($this, $l, $p, $r, $s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$b = haxe_io_Bytes::ofString($r);
		$s->blit($p, $b, 0, strlen($r));
		{
			$»tmp = strlen($r);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function close() {
		$GLOBALS['%s']->push("php.io.FileInput::close");
		$»spos = $GLOBALS['%s']->length;
		parent::close();
		if($this->__f !== null) {
			fclose($this->__f);
		}
		$GLOBALS['%s']->pop();
	}
	public function seek($p, $pos) {
		$GLOBALS['%s']->push("php.io.FileInput::seek");
		$»spos = $GLOBALS['%s']->length;
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
		$GLOBALS['%s']->pop();
	}
	public function tell() {
		$GLOBALS['%s']->push("php.io.FileInput::tell");
		$»spos = $GLOBALS['%s']->length;
		$r = ftell($this->__f);
		if(($r === false)) {
			$»tmp = php_io_FileInput_4($this, $r);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$»tmp = $r;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function readLine() {
		$GLOBALS['%s']->push("php.io.FileInput::readLine");
		$»spos = $GLOBALS['%s']->length;
		$r = fgets($this->__f);
		if((false === $r)) {
			throw new HException(new haxe_io_Eof());
		}
		{
			$»tmp = rtrim($r, "\x0D\x0A");
			$GLOBALS['%s']->pop();
			return $»tmp;
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
	function __toString() { return 'php.io.FileInput'; }
}
function php_io_FileInput_0(&$»this) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(new haxe_io_Eof());
}
function php_io_FileInput_1(&$»this, &$r) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
function php_io_FileInput_2(&$»this, &$l, &$p, &$s) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(new haxe_io_Eof());
}
function php_io_FileInput_3(&$»this, &$l, &$p, &$r, &$s) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
function php_io_FileInput_4(&$»this, &$r) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
