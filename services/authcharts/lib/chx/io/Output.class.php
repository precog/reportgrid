<?php

class chx_io_Output {
	public function __construct(){}
	public $bigEndian;
	public $lock;
	public function writeByte($c) {
		chx_io_Output_0($this, $c);
	}
	public function writeBytes($s, $pos, $len) {
		$k = $len;
		$b = $s->b;
		if($pos < 0 || $len < 0 || $pos + $len > $s->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		while($k > 0) {
			$this->writeByte(ord($b[$pos]));
			$pos++;
			$k--;
		}
		return $len;
	}
	public function flush() {
		return $this;
	}
	public function close() {
	}
	public function setBigEndian($b) {
		$this->bigEndian = $b;
		return $b;
	}
	public function write($b) {
		$l = $b->length;
		$p = 0;
		while($l > 0) {
			$k = $this->writeBytes($b, $p, $l);
			if($k === 0) {
				throw new HException(new chx_lang_BlockedException(null, null));
			}
			$p += $k;
			$l -= $k;
			unset($k);
		}
		return $this;
	}
	public function writeFullBytes($s, $pos, $len) {
		while($len > 0) {
			$k = $this->writeBytes($s, $pos, $len);
			$pos += $k;
			$len -= $k;
			unset($k);
		}
		return $this;
	}
	public function writeFloat($x) {
		$this->write(Bytes::ofString(pack("f", $x)));
		return $this;
	}
	public function writeDouble($x) {
		$this->write(Bytes::ofString(pack("d", $x)));
		return $this;
	}
	public function writeInt8($x) {
		if($x < -128 || $x >= 128) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		$this->writeByte($x & 255);
		return $this;
	}
	public function writeUInt8($x) {
		return $this->writeByte($x);
	}
	public function writeInt16($x) {
		if($x < -32768 || $x >= 32768) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		$this->writeUInt16($x & 65535);
		return $this;
	}
	public function writeUInt16($x) {
		if($x < 0 || $x >= 65536) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		if($this->bigEndian) {
			$this->writeByte($x >> 8);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte($x >> 8);
		}
		return $this;
	}
	public function writeInt24($x) {
		if($x < -8388608 || $x >= 8388608) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		$this->writeUInt24($x & 16777215);
		return $this;
	}
	public function writeUInt24($x) {
		if($x < 0 || $x >= 16777216) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		if($this->bigEndian) {
			$this->writeByte($x >> 16);
			$this->writeByte($x >> 8 & 255);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte($x >> 8 & 255);
			$this->writeByte($x >> 16);
		}
		return $this;
	}
	public function writeInt31($x) {
		if($x < -1073741824 || $x >= 1073741824) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		if($this->bigEndian) {
			$this->writeByte(_hx_shift_right($x, 24));
			$this->writeByte($x >> 16 & 255);
			$this->writeByte($x >> 8 & 255);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte($x >> 8 & 255);
			$this->writeByte($x >> 16 & 255);
			$this->writeByte(_hx_shift_right($x, 24));
		}
		return $this;
	}
	public function writeUInt30($x) {
		if($x < 0 || $x >= 1073741824) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		if($this->bigEndian) {
			$this->writeByte(_hx_shift_right($x, 24));
			$this->writeByte($x >> 16 & 255);
			$this->writeByte($x >> 8 & 255);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte($x >> 8 & 255);
			$this->writeByte($x >> 16 & 255);
			$this->writeByte(_hx_shift_right($x, 24));
		}
		return $this;
	}
	public function writeInt32($x) {
		if($this->bigEndian) {
			$this->writeByte(chx_io_Output_1($this, $x));
			$this->writeByte(chx_io_Output_2($this, $x) & 255);
			$this->writeByte(chx_io_Output_3($this, $x) & 255);
			$this->writeByte(chx_io_Output_4($this, $x));
		} else {
			$this->writeByte(chx_io_Output_5($this, $x));
			$this->writeByte(chx_io_Output_6($this, $x) & 255);
			$this->writeByte(chx_io_Output_7($this, $x) & 255);
			$this->writeByte(chx_io_Output_8($this, $x));
		}
		return $this;
	}
	public function prepare($nbytes) {
		return $this;
	}
	public function writeInput($i, $bufsize) {
		if($bufsize === null) {
			$bufsize = 4096;
		}
		$buf = Bytes::alloc($bufsize);
		try {
			while(true) {
				$len = $i->readBytes($buf, 0, $bufsize);
				if($len === 0) {
					throw new HException(new chx_lang_BlockedException(null, null));
				}
				$p = 0;
				while($len > 0) {
					$k = $this->writeBytes($buf, $p, $len);
					if($k === 0) {
						throw new HException(new chx_lang_BlockedException(null, null));
					}
					$p += $k;
					$len -= $k;
					unset($k);
				}
				unset($p,$len);
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e = $_ex_) instanceof chx_lang_EofException){
			} else throw $»e;;
		}
		return $this;
	}
	public function writeString($s) {
		$b = Bytes::ofString($s);
		$this->writeFullBytes($b, 0, $b->length);
		return $this;
	}
	public function writeUTF($s) {
		if(strlen($s) > 65535) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		$this->writeUInt16(strlen($s));
		$this->writeString($s);
		return $this;
	}
	public function printf($format, $args, $prependLength) {
		if($prependLength === null) {
			$prependLength = false;
		}
		$s = chx_text_Sprintf::format($format, $args);
		if($prependLength) {
			$this->writeUTF($s);
		} else {
			$this->writeString($s);
		}
		return $this;
	}
	public function toString() {
		return Type::getClassName(Type::getClass($this));
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
	function __toString() { return $this->toString(); }
}
function chx_io_Output_0(&$»this, &$c) {
	throw new HException(new chx_lang_FatalException("Not implemented", null));
}
function chx_io_Output_1(&$»this, &$x) {
	{
		$x1 = _hx_shift_right($x, 24);
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_2(&$»this, &$x) {
	{
		$x1 = _hx_shift_right($x, 16);
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_3(&$»this, &$x) {
	{
		$x1 = _hx_shift_right($x, 8);
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_4(&$»this, &$x) {
	{
		$x1 = $x & 255;
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_5(&$»this, &$x) {
	{
		$x1 = $x & 255;
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_6(&$»this, &$x) {
	{
		$x1 = _hx_shift_right($x, 8);
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_7(&$»this, &$x) {
	{
		$x1 = _hx_shift_right($x, 16);
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
function chx_io_Output_8(&$»this, &$x) {
	{
		$x1 = _hx_shift_right($x, 24);
		if(($x1 >> 30 & 1) !== _hx_shift_right($x1, 31)) {
			throw new HException("Overflow " . $x1);
		}
		return $x1 & -1;
	}
}
