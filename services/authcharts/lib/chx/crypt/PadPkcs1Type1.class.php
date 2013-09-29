<?php

class chx_crypt_PadPkcs1Type1 implements chx_crypt_IPad{
	public function __construct($size) {
		if(!php_Boot::$skip_constructor) {
		$this->{"blockSize"} = $size;
		$this->setPadCount(8);
		$this->typeByte = 1;
		$this->setPadByte(255);
	}}
	public $blockSize;
	public $textSize;
	public $padByte;
	public $padCount;
	public $typeByte;
	public function getBytesReadPerBlock() {
		return $this->textSize;
	}
	public function pad($s) {
		if($s->length > $this->textSize) {
			throw new HException("Unable to pad block: provided buffer is " . $s->length . " max is " . $this->textSize);
		}
		$sb = new BytesBuffer();
		$sb->b .= chr(0);
		$sb->b .= chr($this->typeByte);
		$n = $this->blockSize - $s->length - 3;
		while($n-- > 0) {
			$sb->b .= chr($this->getPadByte());
		}
		$sb->b .= chr(0);
		$sb->b .= $s->b;
		$rv = $sb->getBytes();
		return $rv;
	}
	public function unpad($s) {
		$i = 0;
		$sb = new BytesBuffer();
		while($i < $s->length) {
			while($i < $s->length && ord($s->b[$i]) === 0) {
				++$i;
			}
			if($s->length - $i - 3 - $this->padCount < 0) {
				throw new HException("Unexpected short message");
			}
			if(ord($s->b[$i]) !== $this->typeByte) {
				throw new HException("Expected marker " . $this->typeByte . " at position " . $i . " [" . BytesUtil::hexDump($s, null) . "]");
			}
			if(++$i >= $s->length) {
				return $sb->getBytes();
			}
			while($i < $s->length && ord($s->b[$i]) !== 0) {
				++$i;
			}
			$i++;
			$n = 0;
			while($i < $s->length && $n++ < $this->textSize) {
				$sb->b .= chr(ord($s->b[$i++]));
			}
			unset($n);
		}
		return $sb->getBytes();
	}
	public function calcNumBlocks($len) {
		return Math::ceil($len / $this->textSize);
	}
	public function isBlockPad() {
		return true;
	}
	public function blockOverhead() {
		return 3 + $this->padCount;
	}
	public function setPadCount($x) {
		if($x + 3 >= $this->blockSize) {
			throw new HException("Internal padding size exceeds crypt block size");
		}
		$this->padCount = $x;
		$this->textSize = $this->blockSize - 3 - $this->padCount;
		return $x;
	}
	public function setBlockSize($x) {
		$this->blockSize = $x;
		$this->textSize = $x - 3 - $this->padCount;
		if($this->textSize <= 0) {
			throw new HException("Block size " . $x . " to small for Pkcs1 with padCount " . $this->padCount);
		}
		return $x;
	}
	public function getPadByte() {
		return $this->padByte;
	}
	public function setPadByte($x) {
		$this->padByte = $x & 255;
		return $x;
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
	function __toString() { return 'chx.crypt.PadPkcs1Type1'; }
}
