<?php

class chx_crypt_RSAEncrypt implements chx_crypt_IBlockCipher{
	public function __construct($nHex, $eHex) {
		if(!php_Boot::$skip_constructor) {
		$this->init();
		if($nHex !== null) {
			$this->setPublic($nHex, $eHex);
		}
	}}
	public $n;
	public $e;
	public $blockSize;
	public function init() {
		$this->n = null;
		$this->e = 0;
	}
	public function decryptBlock($enc) {
		throw new HException("Not a private key");
		return null;
	}
	public function encrypt($buf) {
		return $this->doBufferEncrypt($buf, (isset($this->doPublic) ? $this->doPublic: array($this, "doPublic")), new chx_crypt_PadPkcs1Type2($this->__getBlockSize()));
	}
	public function encryptBlock($block) {
		$bsize = $this->__getBlockSize();
		if($block->length !== $bsize) {
			throw new HException("bad block size");
		}
		$biv = math_BigInteger::ofBytes($block, true, null, null);
		$biRes = $this->doPublic($biv)->toBytesUnsigned();
		$l = $biRes->length;
		$i = 0;
		while($l > $bsize) {
			if(ord($biRes->b[$i]) !== 0) {
				throw new HException(new chx_lang_FatalException("encoded length was " . $biRes->length, null));
			}
			$i++;
			$l--;
		}
		if($i !== 0) {
			$biRes = $biRes->sub($i, $l);
		}
		if($biRes->length < $bsize) {
			$bb = new BytesBuffer();
			$l = $bsize - $biRes->length;
			{
				$_g = 0;
				while($_g < $l) {
					$i1 = $_g++;
					$bb->b .= chr(0);
					unset($i1);
				}
			}
			{
				$len = $biRes->length;
				if($len < 0 || $len > $biRes->length) {
					throw new HException(new chx_lang_OutsideBoundsException(null, null));
				}
				$bb->b .= substr($biRes->b, 0, $len);
			}
			$biRes = $bb->getBytes();
		}
		return $biRes;
	}
	public function encyptText($text, $separator) {
		if($separator === null) {
			$separator = ":";
		}
		return BytesUtil::toHex($this->encrypt(Bytes::ofString($text)), ":");
	}
	public function setPublic($nHex, $eHex) {
		$this->init();
		if($nHex === null || strlen($nHex) === 0) {
			throw new HException(new chx_lang_NullPointerException("nHex not set: " . $nHex, null));
		}
		if($eHex === null || strlen($eHex) === 0) {
			throw new HException(new chx_lang_NullPointerException("eHex not set: " . $eHex, null));
		}
		$s = BytesUtil::cleanHexFormat($nHex);
		$this->n = math_BigInteger::ofString($s, 16);
		if($this->n === null) {
			throw new HException(2);
		}
		$ie = Std::parseInt("0x" . BytesUtil::cleanHexFormat($eHex));
		if($ie === null || $ie === 0) {
			throw new HException(3);
		}
		$this->e = $ie;
	}
	public function verify($data) {
		return $this->doBufferDecrypt($data, (isset($this->doPublic) ? $this->doPublic: array($this, "doPublic")), new chx_crypt_PadPkcs1Type1($this->__getBlockSize()));
	}
	public function doBufferEncrypt($src, $f, $pf) {
		$bs = $this->__getBlockSize();
		$ts = $bs - 11;
		$idx = 0;
		$msg = new BytesBuffer();
		while($idx < $src->length) {
			if($idx + $ts > $src->length) {
				$ts = $src->length - $idx;
			}
			$m = math_BigInteger::ofBytes($pf->pad($src->sub($idx, $ts)), true, null, null);
			$c = call_user_func_array($f, array($m));
			$h = $c->toBytesUnsigned();
			if(($h->length & 1) !== 0) {
				$msg->b .= chr(0);
			}
			$msg->b .= $h->b;
			$idx += $ts;
			unset($m,$h,$c);
		}
		return $msg->getBytes();
	}
	public function doBufferDecrypt($src, $f, $pf) {
		$bs = $this->__getBlockSize();
		$ts = $bs - 11;
		$idx = 0;
		$msg = new BytesBuffer();
		while($idx < $src->length) {
			if($idx + $bs > $src->length) {
				$bs = $src->length - $idx;
			}
			$c = math_BigInteger::ofBytes($src->sub($idx, $bs), true, null, null);
			$m = call_user_func_array($f, array($c));
			if($m === null) {
				return null;
			}
			$up = $pf->unpad($m->toBytesUnsigned());
			if($up->length > $ts) {
				throw new HException("block text length error");
			}
			$msg->b .= $up->b;
			$idx += $bs;
			unset($up,$m,$c);
		}
		return $msg->getBytes();
	}
	public function doPublic($x) {
		return $x->modPowInt($this->e, $this->n);
	}
	public function __getBlockSize() {
		if($this->n === null) {
			return 0;
		}
		return $this->n->bitLength() + 7 >> 3;
	}
	public function toString() {
		$sb = new StringBuf();
		{
			$x = "Public:\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		{
			$x = "N:\x09" . $this->n->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		{
			$x = "E:\x09" . math_BigInteger::ofInt($this->e)->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		return $sb->b;
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
