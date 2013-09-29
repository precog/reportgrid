<?php

class chx_crypt_RSA extends chx_crypt_RSAEncrypt implements chx_crypt_IBlockCipher{
	public function __construct($nHex, $eHex, $dHex) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct(null,null);
		$this->init();
		if($nHex !== null) {
			$this->setPrivate($nHex, $eHex, $dHex);
		}
	}}
	public $d;
	public $p;
	public $q;
	public $dmp1;
	public $dmq1;
	public $coeff;
	public function init() {
		parent::init();
		$this->d = null;
		$this->p = null;
		$this->q = null;
		$this->dmp1 = null;
		$this->dmq1 = null;
		$this->coeff = null;
	}
	public function decrypt($buf) {
		return $this->doBufferDecrypt($buf, (isset($this->doPrivate) ? $this->doPrivate: array($this, "doPrivate")), new chx_crypt_PadPkcs1Type2($this->__getBlockSize()));
	}
	public function decryptBlock($enc) {
		$c = math_BigInteger::ofBytes($enc, true, null, null);
		$m = $this->doPrivate($c);
		if($m === null) {
			throw new HException("doPrivate error");
		}
		$ba = $m->toBytesUnsigned();
		if($ba->length < $this->__getBlockSize()) {
			$b2 = Bytes::alloc($this->__getBlockSize());
			{
				$_g1 = 0; $_g = $this->__getBlockSize() - $ba->length + 1;
				while($_g1 < $_g) {
					$i = $_g1++;
					$b2->b[$i] = chr(0);
					unset($i);
				}
			}
			$b2->blit($this->__getBlockSize() - $ba->length, $ba, 0, $ba->length);
			$ba = $b2;
		} else {
			while($ba->length > $this->__getBlockSize()) {
				$cnt = $ba->length - $this->__getBlockSize();
				{
					$_g = 0;
					while($_g < $cnt) {
						$i = $_g++;
						if(ord($ba->b[$i]) !== 0) {
							throw new HException("decryptBlock length error");
						}
						unset($i);
					}
					unset($_g);
				}
				$ba = $ba->sub($cnt, $this->__getBlockSize());
				unset($cnt);
			}
		}
		return $ba;
	}
	public function decryptText($hexString) {
		return $this->decrypt(BytesUtil::ofHex(BytesUtil::cleanHexFormat($hexString)));
	}
	public function sign($content) {
		return $this->doBufferEncrypt($content, (isset($this->doPrivate) ? $this->doPrivate: array($this, "doPrivate")), new chx_crypt_PadPkcs1Type1($this->__getBlockSize()));
	}
	public function setPrivate($N, $E, $D) {
		$this->init();
		parent::setPublic($N,$E);
		if($D !== null && strlen($D) > 0) {
			$s = BytesUtil::cleanHexFormat($D);
			$this->d = math_BigInteger::ofString($s, 16);
		} else {
			throw new HException("Invalid RSA private key");
		}
	}
	public function setPrivateEx($N, $E, $D, $P, $Q, $DP, $DQ, $C) {
		$this->init();
		$this->setPrivate($N, $E, $D);
		if($P !== null && $Q !== null) {
			$this->p = math_BigInteger::ofString(BytesUtil::cleanHexFormat($P), 16);
			$this->q = math_BigInteger::ofString(BytesUtil::cleanHexFormat($Q), 16);
			$this->dmp1 = null;
			$this->dmq1 = null;
			$this->coeff = null;
			if($DP !== null) {
				$this->dmp1 = math_BigInteger::ofString(BytesUtil::cleanHexFormat($DP), 16);
			}
			if($DQ !== null) {
				$this->dmq1 = math_BigInteger::ofString(BytesUtil::cleanHexFormat($DQ), 16);
			}
			if($C !== null) {
				$this->coeff = math_BigInteger::ofString(BytesUtil::cleanHexFormat($C), 16);
			}
			$this->recalcCRT();
		} else {
			throw new HException("Invalid RSA private key ex");
		}
	}
	public function recalcCRT() {
		if($this->p !== null && $this->q !== null) {
			if($this->dmp1 === null) {
				$this->dmp1 = $this->d->mod($this->p->sub(math_BigInteger::getONE()));
			}
			if($this->dmq1 === null) {
				$this->dmq1 = $this->d->mod($this->q->sub(math_BigInteger::getONE()));
			}
			if($this->coeff === null) {
				$this->coeff = $this->q->modInverse($this->p);
			}
		}
	}
	public function doPrivate($x) {
		if($this->p === null || $this->q === null) {
			return $x->modPow($this->d, $this->n);
		}
		$xp = $x->mod($this->p)->modPow($this->dmp1, $this->p);
		$xq = $x->mod($this->q)->modPow($this->dmq1, $this->q);
		while($xp->compare($xq) < 0) {
			$xp = $xp->add($this->p);
		}
		return $xp->sub($xq)->mul($this->coeff)->mod($this->p)->mul($this->q)->add($xq);
	}
	public function toString() {
		$sb = new StringBuf();
		{
			$x = parent::toString();
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
			$x = "Private:\x0A";
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
			$x = "D:\x09" . $this->d->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		if($this->p !== null) {
			$x = "P:\x09" . $this->p->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		if($this->q !== null) {
			$x = "Q:\x09" . $this->q->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		if($this->dmp1 !== null) {
			$x = "DMP1:\x09" . $this->dmp1->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		if($this->dmq1 !== null) {
			$x = "DMQ1:\x09" . $this->dmq1->toHex() . "\x0A";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$sb->b .= $x;
		}
		if($this->coeff !== null) {
			$x = "COEFF:\x09" . $this->coeff->toHex() . "\x0A";
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
	static function generate($B, $E) {
		$rng = new math_prng_Random(null);
		$key = new chx_crypt_RSA(null, null, null);
		$qs = $B >> 1;
		$key->e = Std::parseInt(chx_crypt_RSA_0($B, $E, $key, $qs, $rng));
		$ee = math_BigInteger::ofInt($key->e);
		while(true) {
			$key->p = math_BigInteger::randomPrime($B - $qs, $ee, 10, true, $rng);
			$key->q = math_BigInteger::randomPrime($qs, $ee, 10, true, $rng);
			if($key->p->compare($key->q) <= 0) {
				$t = $key->p;
				$key->p = $key->q;
				$key->q = $t;
				unset($t);
			}
			$p1 = $key->p->sub(math_BigInteger::getONE());
			$q1 = $key->q->sub(math_BigInteger::getONE());
			$phi = $p1->mul($q1);
			if($phi->gcd($ee)->compare(math_BigInteger::getONE()) === 0) {
				$key->n = $key->p->mul($key->q);
				$key->d = $ee->modInverse($phi);
				$key->dmp1 = $key->d->mod($p1);
				$key->dmq1 = $key->d->mod($q1);
				$key->coeff = $key->q->modInverse($key->p);
				break;
			}
			unset($q1,$phi,$p1);
		}
		return $key;
	}
	function __toString() { return $this->toString(); }
}
function chx_crypt_RSA_0(&$B, &$E, &$key, &$qs, &$rng) {
	if(StringTools::startsWith($E, "0x")) {
		return $E;
	} else {
		return "0x" . $E;
	}
}
