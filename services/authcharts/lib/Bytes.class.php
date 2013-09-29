<?php

class Bytes {
	public function __construct($length, $b) {
		if(!php_Boot::$skip_constructor) {
		$this->length = $length;
		$this->b = $b;
	}}
	public $length;
	public $b;
	public function get($pos) {
		return ord($this->b[$pos]);
	}
	public function set($pos, $v) {
		$this->b[$pos] = chr($v);
	}
	public function blit($pos, $src, $srcpos, $len) {
		if($len === null) {
			$len = $src->length - $srcpos;
		}
		if($srcpos + $len > $src->length) {
			$len = $src->length - $srcpos;
		}
		if($pos < 0 || $srcpos < 0 || $len < 0 || $pos + $len > $this->length || $srcpos + $len > $src->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		$this->b = substr($this->b, 0, $pos) . substr($src->b, $srcpos, $len) . substr($this->b, $pos+$len);
	}
	public function sub($pos, $len) {
		if($len === null) {
			$len = $this->length - $pos;
		}
		if($pos + $len > $this->length) {
			$len = $this->length - $pos;
		}
		if($pos < 0 || $len < 0) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		return new Bytes($len, substr($this->b, $pos, $len));
	}
	public function compare($other) {
		return $this->b < $other->b ? -1 : ($this->b == $other->b ? 0 : 1);
	}
	public function readString($pos, $len) {
		if($pos < 0 || $len < 0 || $pos + $len > $this->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		return substr($this->b, $pos, $len);
	}
	public function toString() {
		return $this->b;
	}
	public function getData() {
		return $this->b;
	}
	public function toHex($sep, $pos, $len) {
		if($pos === null) {
			$pos = 0;
		}
		if($sep === null) {
			$sep = "";
		}
		if($len === null) {
			$len = $this->length - $pos;
		}
		$data = $this->sub($pos, $len);
		$sb = new StringBuf();
		$l = $data->length;
		$first = true;
		{
			$_g = 0;
			while($_g < $l) {
				$i = $_g++;
				if($first) {
					$first = false;
				} else {
					$x = $sep;
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$sb->b .= $x;
					unset($x);
				}
				{
					$x = strtolower(StringTools::hex(ord($this->b[$i]), 2));
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$sb->b .= $x;
					unset($x);
				}
				unset($i);
			}
		}
		$s = rtrim($sb->b);
		if($sep === "" && strlen($s) % 2 !== 0) {
			$s = "0" . $s;
		}
		return $s;
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
	static function alloc($length) {
		return new Bytes($length, str_repeat(chr(0), $length));
	}
	static function ofString($s) {
		return new Bytes(strlen($s), $s);
	}
	static function ofStringData($s) {
		return new Bytes(strlen($s), $s);
	}
	static function ofData($b) {
		return new Bytes(strlen($b), $b);
	}
	static function ofHex($hs) {
		$s = StringTools::stripWhite($hs);
		$s = strtolower(StringTools::replaceRecurse($s, ":", ""));
		if(StringTools::startsWith($s, "0x")) {
			$s = _hx_substr($s, 2, null);
		}
		if((strlen($s) & 1) === 1) {
			$s = "0" . $s;
		}
		$b = new BytesBuffer();
		$l = intval(strlen($s) / 2);
		{
			$_g = 0;
			while($_g < $l) {
				$x = $_g++;
				$ch = _hx_substr($s, $x * 2, 2);
				$b->b .= chr(Std::parseInt("0x" . $ch));
				unset($x,$ch);
			}
		}
		return $b->getBytes();
	}
	function __toString() { return $this->toString(); }
}
