<?php

class chx_io_Input {
	public function __construct(){}
	public $bytesAvailable;
	public $bigEndian;
	public function readByte() {
		chx_io_Input_0($this);
	}
	public function readBytes($s, $pos, $len) {
		$k = $len;
		$b = $s->b;
		if($pos < 0 || $len < 0 || $pos + $len > $s->length) {
			throw new HException(new chx_lang_OutsideBoundsException(null, null));
		}
		while($k > 0) {
			$b[$pos] = chr($this->readByte());
			$pos++;
			$k--;
		}
		return $len;
	}
	public function isEof() {
		chx_io_Input_1($this);
	}
	public function close() {
	}
	public function readAll($bufsize) {
		if($bufsize === null) {
			$bufsize = 8192;
		}
		$buf = Bytes::alloc($bufsize);
		$total = new BytesBuffer();
		try {
			while(true) {
				$len = $this->readBytes($buf, 0, $bufsize);
				if($len === 0) {
					throw new HException(new chx_lang_BlockedException(null, null));
				}
				{
					if($len < 0 || $len > $buf->length) {
						throw new HException(new chx_lang_OutsideBoundsException(null, null));
					}
					$total->b .= substr($buf->b, 0, $len);
				}
				unset($len);
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e = $_ex_) instanceof chx_lang_EofException){
			} else throw $»e;;
		}
		return $total->getBytes();
	}
	public function readFullBytes($s, $pos, $len) {
		while($len > 0) {
			$k = $this->readBytes($s, $pos, $len);
			$pos += $k;
			$len -= $k;
			unset($k);
		}
	}
	public function read($nbytes) {
		$s = Bytes::alloc($nbytes);
		$p = 0;
		while($nbytes > 0) {
			$k = $this->readBytes($s, $p, $nbytes);
			if($k === 0) {
				throw new HException(new chx_lang_BlockedException(null, null));
			}
			$p += $k;
			$nbytes -= $k;
			unset($k);
		}
		return $s;
	}
	public function readUntil($end) {
		$buf = new StringBuf();
		$last = null;
		while(($last = $this->readByte()) !== $end) {
			$buf->b .= chr($last);
		}
		return $buf->b;
	}
	public function readLine() {
		$buf = new StringBuf();
		$last = null;
		$s = null;
		try {
			while(($last = $this->readByte()) !== 10) {
				$buf->b .= chr($last);
			}
			$s = $buf->b;
			if(_hx_char_code_at($s, strlen($s) - 1) === 13) {
				$s = _hx_substr($s, 0, -1);
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e = $_ex_) instanceof chx_lang_EofException){
				$s = $buf->b;
				if(strlen($s) === 0) {
					throw new HException($e);
				}
			} else throw $»e;;
		}
		return $s;
	}
	public function readFloat() {
		$a = unpack("f", $this->readString(4));
		return $a[1];
	}
	public function readDouble() {
		$a = unpack("d", $this->readString(8));
		return $a[1];
	}
	public function readInt8() {
		$n = $this->readByte();
		if($n >= 128) {
			return $n - 256;
		}
		return $n;
	}
	public function readUInt8() {
		return $this->readByte();
	}
	public function readInt16() {
		$ch1 = $this->readByte();
		$ch2 = $this->readByte();
		$n = chx_io_Input_2($this, $ch1, $ch2);
		if(($n & 32768) !== 0) {
			return $n - 65536;
		}
		return $n;
	}
	public function readUInt16() {
		$ch1 = $this->readByte();
		$ch2 = $this->readByte();
		return chx_io_Input_3($this, $ch1, $ch2);
	}
	public function readInt24() {
		$ch1 = $this->readByte();
		$ch2 = $this->readByte();
		$ch3 = $this->readByte();
		$n = chx_io_Input_4($this, $ch1, $ch2, $ch3);
		if(($n & 8388608) !== 0) {
			return $n - 16777216;
		}
		return $n;
	}
	public function readUInt24() {
		$ch1 = $this->readByte();
		$ch2 = $this->readByte();
		$ch3 = $this->readByte();
		return chx_io_Input_5($this, $ch1, $ch2, $ch3);
	}
	public function readInt31() {
		$ch1 = null; $ch2 = null; $ch3 = null; $ch4 = null;
		if($this->bigEndian) {
			$ch4 = $this->readByte();
			$ch3 = $this->readByte();
			$ch2 = $this->readByte();
			$ch1 = $this->readByte();
		} else {
			$ch1 = $this->readByte();
			$ch2 = $this->readByte();
			$ch3 = $this->readByte();
			$ch4 = $this->readByte();
		}
		if((($ch4 & 128) === 0) != (($ch4 & 64) === 0)) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		return $ch1 | $ch2 << 8 | $ch3 << 16 | $ch4 << 24;
	}
	public function readUInt30() {
		$ch1 = $this->readByte();
		$ch2 = $this->readByte();
		$ch3 = $this->readByte();
		$ch4 = $this->readByte();
		if(((($this->bigEndian) ? $ch1 : $ch4)) >= 64) {
			throw new HException(new chx_lang_OverflowException(null, null));
		}
		return chx_io_Input_6($this, $ch1, $ch2, $ch3, $ch4);
	}
	public function readInt32() {
		$ch1 = $this->readByte();
		$ch2 = $this->readByte();
		$ch3 = $this->readByte();
		$ch4 = $this->readByte();
		return (($this->bigEndian) ? ($ch1 << 8 | $ch2) << 16 | ($ch3 << 8 | $ch4) : ($ch4 << 8 | $ch3) << 16 | ($ch2 << 8 | $ch1));
	}
	public function readString($len) {
		$b = Bytes::alloc($len);
		$this->readFullBytes($b, 0, $len);
		return $b->toString();
	}
	public function readUTF() {
		$len = $this->readUInt16();
		return $this->readString($len);
	}
	public function readMultiByteString($len, $charset) {
		$cset = strtolower($charset);
		switch($cset) {
		case "latin1":{
		}break;
		case "us-ascii":{
		}break;
		default:{
			throw new HException(new chx_lang_UnsupportedException($cset . " not supported", null));
		}break;
		}
		return $this->readString($len);
	}
	public function __getBytesAvailable() {
		chx_io_Input_7($this);
	}
	public function __setEndian($b) {
		$this->bigEndian = $b;
		return $b;
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
	function __toString() { return 'chx.io.Input'; }
}
function chx_io_Input_0(&$»this) {
	throw new HException(new chx_lang_FatalException("Not implemented", null));
}
function chx_io_Input_1(&$»this) {
	throw new HException(new chx_lang_UnsupportedException("Not implemented for this input type", null));
}
function chx_io_Input_2(&$»this, &$ch1, &$ch2) {
	if($»this->bigEndian) {
		return $ch2 | $ch1 << 8;
	} else {
		return $ch1 | $ch2 << 8;
	}
}
function chx_io_Input_3(&$»this, &$ch1, &$ch2) {
	if($»this->bigEndian) {
		return $ch2 | $ch1 << 8;
	} else {
		return $ch1 | $ch2 << 8;
	}
}
function chx_io_Input_4(&$»this, &$ch1, &$ch2, &$ch3) {
	if($»this->bigEndian) {
		return $ch3 | $ch2 << 8 | $ch1 << 16;
	} else {
		return $ch1 | $ch2 << 8 | $ch3 << 16;
	}
}
function chx_io_Input_5(&$»this, &$ch1, &$ch2, &$ch3) {
	if($»this->bigEndian) {
		return $ch3 | $ch2 << 8 | $ch1 << 16;
	} else {
		return $ch1 | $ch2 << 8 | $ch3 << 16;
	}
}
function chx_io_Input_6(&$»this, &$ch1, &$ch2, &$ch3, &$ch4) {
	if($»this->bigEndian) {
		return $ch4 | $ch3 << 8 | $ch2 << 16 | $ch1 << 24;
	} else {
		return $ch1 | $ch2 << 8 | $ch3 << 16 | $ch4 << 24;
	}
}
function chx_io_Input_7(&$»this) {
	throw new HException(new chx_lang_FatalException("Not implemented", null));
}
