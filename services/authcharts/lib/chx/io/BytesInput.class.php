<?php

class chx_io_BytesInput extends chx_io_Input {
	public function __construct($b, $pos, $len) {
		if(!php_Boot::$skip_constructor) {
		if($pos === null) {
			$pos = 0;
		}
		if($len === null) {
			$len = $b->length - $pos;
		}
		if($pos < 0 || $len < 0 || $pos + $len > $b->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		$this->b = $b->b;
		$this->pos = $pos;
		$this->len = $len;
		$this->__setEndian(false);
	}}
	public $position;
	public $b;
	public $pos;
	public $len;
	public function getBytesCopy() {
		$orig = $this->getPosition();
		$rv = null;
		$rv = Bytes::ofData(substr($this->b, 0, $this->len));
		$this->setPosition($orig);
		return $rv;
	}
	public function readByte() {
		if($this->len === 0) {
			throw new HException(new chx_lang_EofException(null, null));
		}
		$this->len--;
		return ord($this->b[$this->pos++]);
	}
	public function readBytes($buf, $pos, $len) {
		if($pos < 0 || $len < 0 || $pos + $len > $buf->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		if($this->len === 0 && $len > 0) {
			throw new HException(new chx_lang_EofException(null, null));
		}
		if($this->len < $len) {
			$len = $this->len;
		}
		$buf->b = substr($buf->b, 0, $pos) . substr($this->b, $this->pos, $len) . substr($buf->b, $pos+$len);
		$this->pos += $len;
		$this->len -= $len;
		return $len;
	}
	public function __getBytesAvailable() {
		return chx_io_BytesInput_0($this);
	}
	public function peek($pos) {
		if($pos === null) {
			$pos = $this->getPosition();
		}
		$orig = $this->getPosition();
		$this->setPosition($pos);
		$d = $this->readByte();
		$this->setPosition($orig);
		return $d;
	}
	public function setPosition($p) {
		$this->len = $this->len + ($this->getPosition() - $p);
		$this->pos = $p;
		return $p;
	}
	public function getPosition() {
		return $this->pos;
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
	function __toString() { return 'chx.io.BytesInput'; }
}
function chx_io_BytesInput_0(&$»this) {
	if($»this->len >= 0) {
		return $»this->len;
	} else {
		return 0;
	}
}
