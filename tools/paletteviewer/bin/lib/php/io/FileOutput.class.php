<?php

class php_io_FileOutput extends haxe_io_Output {
	public function __construct($f) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("php.io.FileOutput::new");
		$»spos = $GLOBALS['%s']->length;
		$this->__f = $f;
		$GLOBALS['%s']->pop();
	}}
	public $__f;
	public function writeByte($c) {
		$GLOBALS['%s']->push("php.io.FileOutput::writeByte");
		$»spos = $GLOBALS['%s']->length;
		$r = fwrite($this->__f, chr($c));
		if(($r === false)) {
			$»tmp = php_io_FileOutput_0($this, $c, $r);
			$GLOBALS['%s']->pop();
			$»tmp;
			return;
		}
		{
			$GLOBALS['%s']->pop();
			$r;
			return;
		}
		$GLOBALS['%s']->pop();
	}
	public function writeBytes($b, $p, $l) {
		$GLOBALS['%s']->push("php.io.FileOutput::writeBytes");
		$»spos = $GLOBALS['%s']->length;
		$s = $b->readString($p, $l);
		if(feof($this->__f)) {
			$»tmp = php_io_FileOutput_1($this, $b, $l, $p, $s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$r = fwrite($this->__f, $s, $l);
		if(($r === false)) {
			$»tmp = php_io_FileOutput_2($this, $b, $l, $p, $r, $s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$GLOBALS['%s']->pop();
			return $r;
		}
		$GLOBALS['%s']->pop();
	}
	public function flush() {
		$GLOBALS['%s']->push("php.io.FileOutput::flush");
		$»spos = $GLOBALS['%s']->length;
		$r = fflush($this->__f);
		if(($r === false)) {
			throw new HException(haxe_io_Error::Custom("An error occurred"));
		}
		$GLOBALS['%s']->pop();
	}
	public function close() {
		$GLOBALS['%s']->push("php.io.FileOutput::close");
		$»spos = $GLOBALS['%s']->length;
		parent::close();
		if($this->__f !== null) {
			fclose($this->__f);
		}
		$GLOBALS['%s']->pop();
	}
	public function seek($p, $pos) {
		$GLOBALS['%s']->push("php.io.FileOutput::seek");
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
		$GLOBALS['%s']->push("php.io.FileOutput::tell");
		$»spos = $GLOBALS['%s']->length;
		$r = ftell($this->__f);
		if(($r === false)) {
			$»tmp = php_io_FileOutput_3($this, $r);
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
	public function eof() {
		$GLOBALS['%s']->push("php.io.FileOutput::eof");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = feof($this->__f);
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
	function __toString() { return 'php.io.FileOutput'; }
}
function php_io_FileOutput_0(&$»this, &$c, &$r) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
function php_io_FileOutput_1(&$»this, &$b, &$l, &$p, &$s) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(new haxe_io_Eof());
}
function php_io_FileOutput_2(&$»this, &$b, &$l, &$p, &$r, &$s) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
function php_io_FileOutput_3(&$»this, &$r) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
