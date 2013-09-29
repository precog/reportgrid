<?php

class math_BigInteger {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		if(math_BigInteger::$BI_RC === null || math_BigInteger::$BI_RC->length === 0) {
			math_BigInteger::initBiRc();
		}
		if(strlen(math_BigInteger::$BI_RM) === 0) {
			throw new HException("BI_RM not initialized");
		}
		$this->chunks = new _hx_array(array());
		$this->am = (isset($this->am2) ? $this->am2: array($this, "am2"));
	}}
	public $t;
	public $sign;
	public $chunks;
	public $am;
	public function fromInt($x) {
		$this->t = 1;
		$this->chunks[0] = 0;
		$this->sign = (($x < 0) ? -1 : 0);
		if($x > 0) {
			$this->chunks[0] = $x;
		} else {
			if($x < -1) {
				$this->chunks[0] = $x + math_BigInteger::$DV;
			} else {
				$this->t = 0;
			}
		}
	}
	public function fromInt32($x) {
		$this->fromInt($x);
	}
	public function toInt() {
		if($this->sign < 0) {
			if($this->t === 1) {
				return $this->chunks->»a[0] - math_BigInteger::$DV;
			} else {
				if($this->t === 0) {
					return -1;
				}
			}
		} else {
			if($this->t === 1) {
				return $this->chunks[0];
			} else {
				if($this->t === 0) {
					return 0;
				}
			}
		}
		return ($this->chunks->»a[1] & (1 << 32 - math_BigInteger::$DB) - 1) << math_BigInteger::$DB | $this->chunks[0];
	}
	public function toInt32() {
		return $this->toInt();
	}
	public function toString() {
		return $this->toRadix(10);
	}
	public function toHex() {
		return $this->toRadix(16);
	}
	public function toBytes() {
		$i = $this->t;
		$r = new _hx_array(array());
		$r[0] = $this->sign;
		$p = math_BigInteger::$DB - $i * math_BigInteger::$DB % 8;
		$d = null;
		$k = 0;
		if($i-- > 0) {
			if($p < math_BigInteger::$DB && ($d = $this->chunks->»a[$i] >> $p) !== ($this->sign & math_BigInteger::$DM) >> $p) {
				$r[$k] = $d | $this->sign << math_BigInteger::$DB - $p;
				$k++;
			}
			while($i >= 0) {
				if($p < 8) {
					$d = ($this->chunks->»a[$i] & (1 << $p) - 1) << 8 - $p;
					--$i;
					$d |= $this->chunks->»a[$i] >> ($p += math_BigInteger::$DB - 8);
				} else {
					$d = $this->chunks->»a[$i] >> ($p -= 8) & 255;
					if($p <= 0) {
						$p += math_BigInteger::$DB;
						--$i;
					}
				}
				if(($d & 128) !== 0) {
					$d |= -256;
				}
				if($k === 0 && ($this->sign & 128) !== ($d & 128)) {
					++$k;
				}
				if($k > 0 || $d !== $this->sign) {
					$r[$k] = $d;
					$k++;
				}
			}
		}
		$bb = new BytesBuffer();
		{
			$_g1 = 0; $_g = $r->length;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				$bb->b .= chr($r[$i1]);
				unset($i1);
			}
		}
		return $bb->getBytes();
	}
	public function toBytesUnsigned() {
		$bb = new BytesBuffer();
		$k = 8;
		$km = 255;
		$d = 0;
		$i = $this->t;
		$p = math_BigInteger::$DB - $i * math_BigInteger::$DB % $k;
		$m = false;
		$c = 0;
		if($i-- > 0) {
			if($p < math_BigInteger::$DB && ($d = $this->chunks->»a[$i] >> $p) > 0) {
				$m = true;
				$bb->b .= chr($d);
				$c++;
			}
			while($i >= 0) {
				if($p < $k) {
					$d = ($this->chunks->»a[$i] & (1 << $p) - 1) << $k - $p;
					$d |= $this->chunks->»a[--$i] >> ($p += math_BigInteger::$DB - $k);
				} else {
					$d = $this->chunks->»a[$i] >> ($p -= $k) & $km;
					if($p <= 0) {
						$p += math_BigInteger::$DB;
						--$i;
					}
				}
				if($d > 0) {
					$m = true;
				}
				if($m) {
					$bb->b .= chr($d);
					$c++;
				}
			}
		}
		return $bb->getBytes();
	}
	public function toRadix($b) {
		if($b === null) {
			$b = 10;
		}
		if($b < 2 || $b > 36) {
			throw new HException(new chx_lang_UnsupportedException("invalid base for conversion", null));
		}
		if($this->sigNum() === 0) {
			return "0";
		}
		$cs = Math::floor(0.6931471805599453 * math_BigInteger::$DB / Math::log($b));
		$a = intval(Math::pow($b, $cs));
		$d = math_BigInteger::nbv($a);
		$y = math_BigInteger::nbi();
		$z = math_BigInteger::nbi();
		$r = "";
		$this->divRemTo($d, $y, $z);
		while($y->sigNum() > 0) {
			$r = _hx_substr(I32::baseEncode($a + $z->toInt32(), $b), 1, null) . $r;
			$y->divRemTo($d, $y, $z);
		}
		return I32::baseEncode($z->toInt32(), $b) . $r;
	}
	public function abs() {
		return (($this->sign < 0) ? $this->neg() : $this);
	}
	public function add($a) {
		$r = math_BigInteger::nbi();
		$this->addTo($a, $r);
		return $r;
	}
	public function compare($a) {
		$r = $this->sign - $a->sign;
		if($r !== 0) {
			return $r;
		}
		$i = $this->t;
		$r = $i - $a->t;
		if($r !== 0) {
			return $r;
		}
		while(--$i >= 0) {
			$r = $this->chunks->»a[$i] - $a->chunks[$i];
			if($r !== 0) {
				return $r;
			}
		}
		return 0;
	}
	public function div($a) {
		$r = math_BigInteger::nbi();
		$this->divRemTo($a, $r, null);
		return $r;
	}
	public function divideAndRemainder($a) {
		$q = math_BigInteger::nbi();
		$r = math_BigInteger::nbi();
		$this->divRemTo($a, $q, $r);
		return new _hx_array(array($q, $r));
	}
	public function eq($a) {
		return $this->compare($a) === 0;
	}
	public function isEven() {
		return (math_BigInteger_0($this)) === 0;
	}
	public function max($a) {
		return (($this->compare($a) > 0) ? $this : $a);
	}
	public function min($a) {
		return (($this->compare($a) < 0) ? $this : $a);
	}
	public function mod($a) {
		$r = math_BigInteger::nbi();
		$this->abs()->divRemTo($a, null, $r);
		if($this->sign < 0 && $r->compare(math_BigInteger::getZERO()) > 0) {
			$a->subTo($r, $r);
		}
		return $r;
	}
	public function modInt($n) {
		if($n <= 0) {
			return 0;
		}
		$d = math_BigInteger::$DV % $n;
		$r = math_BigInteger_1($this, $d, $n);
		if($this->t > 0) {
			if($d === 0) {
				$r = $this->chunks->»a[0] % $n;
			} else {
				$i = $this->t - 1;
				while($i >= 0) {
					$r = ($d * $r + $this->chunks[$i]) % $n;
					--$i;
				}
			}
		}
		return $r;
	}
	public function modInverse($m) {
		$ac = $m->isEven();
		if($this->isEven() && $ac || $m->sigNum() === 0) {
			return math_BigInteger::getZERO();
		}
		$u = $m->hclone();
		$v = $this->hclone();
		$a = math_BigInteger::nbv(1);
		$b = math_BigInteger::nbv(0);
		$c = math_BigInteger::nbv(0);
		$d = math_BigInteger::nbv(1);
		while($u->sigNum() !== 0) {
			while($u->isEven()) {
				$u->rShiftTo(1, $u);
				if($ac) {
					if(!$a->isEven() || !$b->isEven()) {
						$a->addTo($this, $a);
						$b->subTo($m, $b);
					}
					$a->rShiftTo(1, $a);
				} else {
					if(!$b->isEven()) {
						$b->subTo($m, $b);
					}
				}
				$b->rShiftTo(1, $b);
			}
			while($v->isEven()) {
				$v->rShiftTo(1, $v);
				if($ac) {
					if(!$c->isEven() || !$d->isEven()) {
						$c->addTo($this, $c);
						$d->subTo($m, $d);
					}
					$c->rShiftTo(1, $c);
				} else {
					if(!$d->isEven()) {
						$d->subTo($m, $d);
					}
				}
				$d->rShiftTo(1, $d);
			}
			if($u->compare($v) >= 0) {
				$u->subTo($v, $u);
				if($ac) {
					$a->subTo($c, $a);
				}
				$b->subTo($d, $b);
			} else {
				$v->subTo($u, $v);
				if($ac) {
					$c->subTo($a, $c);
				}
				$d->subTo($b, $d);
			}
		}
		if($v->compare(math_BigInteger::getONE()) !== 0) {
			return math_BigInteger::getZERO();
		}
		if($d->compare($m) >= 0) {
			return $d->sub($m);
		}
		if($d->sigNum() < 0) {
			$d->addTo($m, $d);
		} else {
			return $d;
		}
		return $d;
	}
	public function modPow($e, $m) {
		$i = $e->bitLength();
		$k = null;
		$r = math_BigInteger::nbv(1);
		$z = null;
		if($i <= 0) {
			return $r;
		} else {
			if($i < 18) {
				$k = 1;
			} else {
				if($i < 48) {
					$k = 3;
				} else {
					if($i < 144) {
						$k = 4;
					} else {
						if($i < 768) {
							$k = 5;
						} else {
							$k = 6;
						}
					}
				}
			}
		}
		if($i < 8) {
			$z = new math_reduction_Classic($m);
		} else {
			if($m->isEven()) {
				$z = new math_reduction_Barrett($m);
			} else {
				$z = new math_reduction_Montgomery($m);
			}
		}
		$g = new _hx_array(array());
		$n = 3;
		$k1 = $k - 1;
		$km = (1 << $k) - 1;
		$g[1] = $z->convert($this);
		if($k > 1) {
			$g2 = math_BigInteger::nbi();
			$z->sqrTo($g[1], $g2);
			while($n <= $km) {
				$g[$n] = math_BigInteger::nbi();
				$z->mulTo($g2, $g[$n - 2], $g[$n]);
				$n += 2;
			}
		}
		$j = $e->t - 1;
		$w = null;
		$is1 = true;
		$r2 = math_BigInteger::nbi();
		$t = null;
		$i = math_BigInteger::nbits($e->chunks[$j]) - 1;
		while($j >= 0) {
			if($i >= $k1) {
				$w = $e->chunks->»a[$j] >> $i - $k1 & $km;
			} else {
				$w = ($e->chunks->»a[$j] & (1 << $i + 1) - 1) << $k1 - $i;
				if($j > 0) {
					$w |= $e->chunks->»a[$j - 1] >> math_BigInteger::$DB + $i - $k1;
				}
			}
			$n = $k;
			while(($w & 1) === 0) {
				$w >>= 1;
				--$n;
			}
			if(($i -= $n) < 0) {
				$i += math_BigInteger::$DB;
				--$j;
			}
			if($is1) {
				_hx_array_get($g, $w)->copyTo($r);
				$is1 = false;
			} else {
				while($n > 1) {
					$z->sqrTo($r, $r2);
					$z->sqrTo($r2, $r);
					$n -= 2;
				}
				if($n > 0) {
					$z->sqrTo($r, $r2);
				} else {
					$t = $r;
					$r = $r2;
					$r2 = $t;
				}
				$z->mulTo($r2, $g[$w], $r);
			}
			$chnk = $e->chunks[$j];
			while($j >= 0 && ($chnk & 1 << $i) === 0) {
				$z->sqrTo($r, $r2);
				$t = $r;
				$r = $r2;
				$r2 = $t;
				if(--$i < 0) {
					$i = math_BigInteger::$DB - 1;
					--$j;
				}
				$chnk = $e->chunks[$j];
			}
			unset($chnk);
		}
		return $z->revert($r);
	}
	public function modPowInt($e, $m) {
		if($m === null) {
			throw new HException("m is null");
		}
		$z = null;
		if($e < 256 || $m->isEven()) {
			$z = new math_reduction_Classic($m);
		} else {
			$z = new math_reduction_Montgomery($m);
		}
		return $this->exp($e, $z);
	}
	public function mul($a) {
		$r = math_BigInteger::nbi();
		$this->multiplyTo($a, $r);
		return $r;
	}
	public function neg() {
		$r = math_BigInteger::nbi();
		math_BigInteger::getZERO()->subTo($this, $r);
		return $r;
	}
	public function pow($e) {
		return $this->exp($e, new math_reduction_Null());
	}
	public function remainder($a) {
		$r = math_BigInteger::nbi();
		$this->divRemTo($a, null, $r);
		return $r;
	}
	public function sub($a) {
		$r = math_BigInteger::nbi();
		$this->subTo($a, $r);
		return $r;
	}
	public function hand($a) {
		$r = math_BigInteger::nbi();
		$this->bitwiseTo($a, (isset(math_BigInteger::$op_and) ? math_BigInteger::$op_and: array("math_BigInteger", "op_and")), $r);
		return $r;
	}
	public function andNot($a) {
		$r = math_BigInteger::nbi();
		$this->bitwiseTo($a, (isset(math_BigInteger::$op_andnot) ? math_BigInteger::$op_andnot: array("math_BigInteger", "op_andnot")), $r);
		return $r;
	}
	public function bitCount() {
		$r = 0; $x = $this->sign & math_BigInteger::$DM;
		{
			$_g1 = 0; $_g = $this->t;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r += math_BigInteger::cbit($this->chunks->»a[$i] ^ $x);
				unset($i);
			}
		}
		return $r;
	}
	public function bitLength() {
		if($this->t <= 0) {
			return 0;
		}
		return math_BigInteger::$DB * ($this->t - 1) + math_BigInteger::nbits($this->chunks->»a[$this->t - 1] ^ $this->sign & math_BigInteger::$DM);
	}
	public function complement() {
		return $this->not();
	}
	public function clearBit($n) {
		return $this->changeBit($n, (isset(math_BigInteger::$op_andnot) ? math_BigInteger::$op_andnot: array("math_BigInteger", "op_andnot")));
	}
	public function flipBit($n) {
		return $this->changeBit($n, (isset(math_BigInteger::$op_xor) ? math_BigInteger::$op_xor: array("math_BigInteger", "op_xor")));
	}
	public function getLowestSetBit() {
		{
			$_g1 = 0; $_g = $this->t;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($this->chunks[$i] !== 0) {
					return $i * math_BigInteger::$DB + math_BigInteger::lbit($this->chunks[$i]);
				}
				unset($i);
			}
		}
		if($this->sign < 0) {
			return $this->t * math_BigInteger::$DB;
		}
		return -1;
	}
	public function not() {
		$r = math_BigInteger::nbi();
		{
			$_g1 = 0; $_g = $this->t;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r->chunks[$i] = math_BigInteger::$DM & ~$this->chunks[$i];
				unset($i);
			}
		}
		$r->t = $this->t;
		$r->sign = ~$this->sign;
		return $r;
	}
	public function hor($a) {
		$r = math_BigInteger::nbi();
		$this->bitwiseTo($a, (isset(math_BigInteger::$op_or) ? math_BigInteger::$op_or: array("math_BigInteger", "op_or")), $r);
		return $r;
	}
	public function setBit($n) {
		return $this->changeBit($n, (isset(math_BigInteger::$op_or) ? math_BigInteger::$op_or: array("math_BigInteger", "op_or")));
	}
	public function shl($n) {
		$r = math_BigInteger::nbi();
		if($n < 0) {
			$this->rShiftTo(-$n, $r);
		} else {
			$this->lShiftTo($n, $r);
		}
		return $r;
	}
	public function shr($n) {
		$r = math_BigInteger::nbi();
		if($n < 0) {
			$this->lShiftTo(-$n, $r);
		} else {
			$this->rShiftTo($n, $r);
		}
		return $r;
	}
	public function testBit($n) {
		$j = Math::floor($n / math_BigInteger::$DB);
		if($j >= $this->t) {
			return $this->sign !== 0;
		}
		return ($this->chunks->»a[$j] & 1 << $n % math_BigInteger::$DB) !== 0;
	}
	public function hxor($a) {
		$r = math_BigInteger::nbi();
		$this->bitwiseTo($a, (isset(math_BigInteger::$op_xor) ? math_BigInteger::$op_xor: array("math_BigInteger", "op_xor")), $r);
		return $r;
	}
	public function addTo($a, $r) {
		$i = 0;
		$c = 0;
		$m = intval(Math::min($a->t, $this->t));
		while($i < $m) {
			$c += $this->chunks->»a[$i] + $a->chunks[$i];
			$r->chunks[$i] = $c & math_BigInteger::$DM;
			$i++;
			$c >>= math_BigInteger::$DB;
		}
		if($a->t < $this->t) {
			$c += $a->sign;
			while($i < $this->t) {
				$c += $this->chunks[$i];
				$r->chunks[$i] = $c & math_BigInteger::$DM;
				$i++;
				$c >>= math_BigInteger::$DB;
			}
			$c += $this->sign;
		} else {
			$c += $this->sign;
			while($i < $a->t) {
				$c += $a->chunks[$i];
				$r->chunks[$i] = $c & math_BigInteger::$DM;
				$i++;
				$c >>= math_BigInteger::$DB;
			}
			$c += $a->sign;
		}
		$r->sign = (($c < 0) ? -1 : 0);
		if($c > 0) {
			$r->chunks[$i] = $c;
			$i++;
		} else {
			if($c < -1) {
				$r->chunks[$i] = math_BigInteger::$DV + $c;
				$i++;
			}
		}
		$r->t = $i;
		$r->clamp();
	}
	public function copyTo($r) {
		{
			$_g1 = 0; $_g = $this->chunks->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r->chunks[$i] = $this->chunks[$i];
				unset($i);
			}
		}
		$r->t = $this->t;
		$r->sign = $this->sign;
	}
	public function divRemTo($m, $q, $r) {
		$pm = $m->abs();
		if($pm->t <= 0) {
			return;
		}
		$pt = $this->abs();
		if($pt->t < $pm->t) {
			if($q !== null) {
				$q->fromInt(0);
			}
			if($r !== null) {
				$this->copyTo($r);
			}
			return;
		}
		if($r === null) {
			$r = math_BigInteger::nbi();
		}
		$y = math_BigInteger::nbi();
		$ts = $this->sign;
		$ms = $m->sign;
		$nsh = math_BigInteger::$DB - math_BigInteger::nbits($pm->chunks[$pm->t - 1]);
		if($nsh > 0) {
			$pt->lShiftTo($nsh, $r);
			$pm->lShiftTo($nsh, $y);
		} else {
			$pt->copyTo($r);
			$pm->copyTo($y);
		}
		$ys = $y->t;
		$y0 = $y->chunks[$ys - 1];
		if($y0 === 0) {
			return;
		}
		$yt = $y0 * 1.0 * ((1 << math_BigInteger::$F1) * 1.0) + (math_BigInteger_2($this, $m, $ms, $nsh, $pm, $pt, $q, $r, $ts, $y, $y0, $ys));
		$d1 = math_BigInteger::$FV / $yt;
		$d2 = (1 << math_BigInteger::$F1) * 1.0 / $yt;
		$e = (1 << math_BigInteger::$F2) * 1.0;
		$i = $r->t;
		$j = $i - $ys;
		$t = (($q === null) ? math_BigInteger::nbi() : $q);
		$y->dlShiftTo($j, $t);
		if($r->compare($t) >= 0) {
			$r->chunks[$r->t] = 1;
			$r->t++;
			$r->subTo($t, $r);
		}
		math_BigInteger::getONE()->dlShiftTo($ys, $t);
		$t->subTo($y, $y);
		while($y->t < $ys) {
			$y->chunks[$y->t] = 0;
			$y->t++;
		}
		while(--$j >= 0) {
			$qd = null;
			if($r->chunks[--$i] === $y0) {
				$qd = math_BigInteger::$DM;
			} else {
				$qd = Math::floor($r->chunks->»a[$i] * 1.0 * $d1 + ($r->chunks->»a[$i - 1] * 1.0 + $e) * $d2);
			}
			$r->chunks->»a[$i] += $y->am(0, $qd, $r, $j, 0, $ys);
			if($r->chunks->»a[$i] < $qd) {
				$y->dlShiftTo($j, $t);
				$r->subTo($t, $r);
				while($r->chunks->»a[$i] < --$qd) {
					$r->subTo($t, $r);
				}
			}
			unset($qd);
		}
		if($q !== null) {
			$r->drShiftTo($ys, $q);
			if($ts !== $ms) {
				math_BigInteger::getZERO()->subTo($q, $q);
			}
		}
		$r->t = $ys;
		$r->clamp();
		if($nsh > 0) {
			$r->rShiftTo($nsh, $r);
		}
		if($ts < 0) {
			math_BigInteger::getZERO()->subTo($r, $r);
		}
	}
	public function multiplyLowerTo($a, $n, $r) {
		$i = intval(Math::min($this->t + $a->t, $n));
		$r->sign = 0;
		$r->t = $i;
		while($i > 0) {
			--$i;
			$r->chunks[$i] = 0;
		}
		$j = $r->t - $this->t;
		while($i < $j) {
			$r->chunks[$i + $this->t] = $this->am(0, $a->chunks[$i], $r, $i, 0, $this->t);
			++$i;
		}
		$j = intval(Math::min($a->t, $n));
		while($i < $j) {
			$this->am(0, $a->chunks[$i], $r, $i, 0, $n - $i);
			++$i;
		}
		$r->clamp();
	}
	public function multiplyTo($a, $r) {
		$x = $this->abs(); $y = $a->abs();
		$i = $x->t;
		$r->t = $i + $y->t;
		while(--$i >= 0) {
			$r->chunks[$i] = 0;
		}
		{
			$_g1 = 0; $_g = $y->t;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				$r->chunks[$i1 + $x->t] = $x->am(0, $y->chunks[$i1], $r, $i1, 0, $x->t);
				unset($i1);
			}
		}
		$r->sign = 0;
		$r->clamp();
		if($this->sign !== $a->sign) {
			math_BigInteger::getZERO()->subTo($r, $r);
		}
	}
	public function multiplyUpperTo($a, $n, $r) {
		--$n;
		$i = $r->t = $this->t + $a->t - $n;
		$r->sign = 0;
		while(--$i >= 0) {
			$r->chunks[$i] = 0;
		}
		$i = intval(Math::max($n - $this->t, 0));
		{
			$_g1 = $i; $_g = $a->t;
			while($_g1 < $_g) {
				$x = $_g1++;
				$r->chunks[$this->t + $x - $n] = $this->am($n - $x, $a->chunks[$x], $r, 0, 0, $this->t + $x - $n);
				unset($x);
			}
		}
		$r->clamp();
		$r->drShiftTo(1, $r);
	}
	public function squareTo($r) {
		if($r === $this) {
			throw new HException("can not squareTo self");
		}
		$x = $this->abs();
		$i = $r->t = 2 * $x->t;
		while(--$i >= 0) {
			$r->chunks[$i] = 0;
		}
		$i = 0;
		while($i < $x->t - 1) {
			$c = $x->am($i, $x->chunks[$i], $r, 2 * $i, 0, 1);
			if(($r->chunks->»a[$i + $x->t] += $x->am($i + 1, 2 * $x->chunks[$i], $r, 2 * $i + 1, $c, $x->t - $i - 1)) >= math_BigInteger::$DV) {
				$r->chunks->»a[$i + $x->t] -= math_BigInteger::$DV;
				$r->chunks[$i + $x->t + 1] = 1;
			}
			$i++;
			unset($c);
		}
		if($r->t > 0) {
			$rv = $x->am($i, $x->chunks[$i], $r, 2 * $i, 0, 1);
			$r->chunks->»a[$r->t - 1] += $rv;
		}
		$r->sign = 0;
		$r->clamp();
	}
	public function subTo($a, $r) {
		$i = 0;
		$c = 0;
		$m = intval(Math::min($a->t, $this->t));
		while($i < $m) {
			$c += $this->chunks->»a[$i] - $a->chunks[$i];
			$r->chunks[$i] = $c & math_BigInteger::$DM;
			$i++;
			$c >>= math_BigInteger::$DB;
		}
		if($a->t < $this->t) {
			$c -= $a->sign;
			while($i < $this->t) {
				$c += $this->chunks[$i];
				$r->chunks[$i] = $c & math_BigInteger::$DM;
				$i++;
				$c >>= math_BigInteger::$DB;
			}
			$c += $this->sign;
		} else {
			$c += $this->sign;
			while($i < $a->t) {
				$c -= $a->chunks[$i];
				$r->chunks[$i] = $c & math_BigInteger::$DM;
				$i++;
				$c >>= math_BigInteger::$DB;
			}
			$c -= $a->sign;
		}
		$r->sign = (($c < 0) ? -1 : 0);
		if($c < -1) {
			$r->chunks[$i] = math_BigInteger::$DV + $c;
			$i++;
		} else {
			if($c > 0) {
				$r->chunks[$i] = $c;
				$i++;
			}
		}
		$r->t = $i;
		$r->clamp();
	}
	public function clamp() {
		$c = $this->sign & math_BigInteger::$DM;
		while($this->t > 0 && $this->chunks[$this->t - 1] === $c) {
			--$this->t;
		}
	}
	public function hclone() {
		$r = math_BigInteger::nbi();
		$this->copyTo($r);
		return $r;
	}
	public function gcd($a) {
		$x = (($this->sign < 0) ? $this->neg() : $this->hclone());
		$y = (($a->sign < 0) ? $a->neg() : $a->hclone());
		if($x->compare($y) < 0) {
			$t = $x;
			$x = $y;
			$y = $t;
		}
		$i = $x->getLowestSetBit(); $g = $y->getLowestSetBit();
		if($g < 0) {
			return $x;
		}
		if($i < $g) {
			$g = $i;
		}
		if($g > 0) {
			$x->rShiftTo($g, $x);
			$y->rShiftTo($g, $y);
		}
		while($x->sigNum() > 0) {
			if(($i = $x->getLowestSetBit()) > 0) {
				$x->rShiftTo($i, $x);
			}
			if(($i = $y->getLowestSetBit()) > 0) {
				$y->rShiftTo($i, $y);
			}
			if($x->compare($y) >= 0) {
				$x->subTo($y, $x);
				$x->rShiftTo(1, $x);
			} else {
				$y->subTo($x, $y);
				$y->rShiftTo(1, $y);
			}
		}
		if($g > 0) {
			$y->lShiftTo($g, $y);
		}
		return $y;
	}
	public function padTo($n) {
		while($this->t < $n) {
			$this->chunks[$this->t] = 0;
			$this->t++;
		}
	}
	public function shortValue() {
		return math_BigInteger_3($this);
	}
	public function byteValue() {
		return math_BigInteger_4($this);
	}
	public function sigNum() {
		if($this->sign < 0) {
			return -1;
		} else {
			if($this->t <= 0 || $this->t === 1 && $this->chunks->»a[0] <= 0) {
				return 0;
			} else {
				return 1;
			}
		}
	}
	public function dAddOffset($n, $w) {
		while($this->t <= $w) {
			$this->chunks[$this->t] = 0;
			$this->t++;
		}
		$this->chunks->»a[$w] += $n;
		while($this->chunks->»a[$w] >= math_BigInteger::$DV) {
			$this->chunks->»a[$w] -= math_BigInteger::$DV;
			if(++$w >= $this->t) {
				$this->chunks[$this->t] = 0;
				$this->t++;
			}
			_hx_array_increment($this->chunks,$w);
		}
	}
	public function dlShiftTo($n, $r) {
		if($r === null) {
			return;
		}
		$i = $this->t - 1;
		while($i >= 0) {
			$r->chunks[$i + $n] = $this->chunks[$i];
			$i--;
		}
		$i = $n - 1;
		while($i >= 0) {
			$r->chunks[$i] = 0;
			$i--;
		}
		$r->t = $this->t + $n;
		$r->sign = $this->sign;
	}
	public function drShiftTo($n, $r) {
		if($r === null) {
			return;
		}
		$i = $n;
		while($i < $this->t) {
			$r->chunks[$i - $n] = $this->chunks[$i];
			$i++;
		}
		$r->t = intval(Math::max($this->t - $n, 0));
		$r->sign = $this->sign;
	}
	public function invDigit() {
		if($this->t < 1) {
			return 0;
		}
		$x = $this->chunks[0];
		if(($x & 1) === 0) {
			return 0;
		}
		$y = $x & 3;
		$y = $y * (2 - ($x & 15) * $y) & 15;
		$y = $y * (2 - ($x & 255) * $y) & 255;
		$y = $y * (2 - (($x & 65535) * $y & 65535)) & 65535;
		$y = $y * (2 - $x * $y % math_BigInteger::$DV) % math_BigInteger::$DV;
		return math_BigInteger_5($this, $x, $y);
	}
	public function isProbablePrime($v) {
		$i = null;
		$x = $this->abs();
		if($x->t === 1 && $x->chunks->»a[0] <= math_BigInteger::$lowprimes[math_BigInteger::$lowprimes->length - 1]) {
			{
				$_g1 = 0; $_g = math_BigInteger::$lowprimes->length;
				while($_g1 < $_g) {
					$i1 = $_g1++;
					if($x->chunks[0] === math_BigInteger::$lowprimes[$i1]) {
						return true;
					}
					unset($i1);
				}
			}
			return false;
		}
		if($x->isEven()) {
			return false;
		}
		$i = 1;
		while($i < math_BigInteger::$lowprimes->length) {
			$m = math_BigInteger::$lowprimes[$i];
			$j = $i + 1;
			while($j < math_BigInteger::$lowprimes->length && $m < math_BigInteger::$lplim) {
				$m *= math_BigInteger::$lowprimes[$j];
				$j++;
			}
			$m = $x->modInt($m);
			while($i < $j) {
				if($m % math_BigInteger::$lowprimes[$i] === 0) {
					return false;
				}
				$i++;
			}
			unset($m,$j);
		}
		return $x->millerRabin($v);
	}
	public function primify($bits, $ta) {
		while($this->bitLength() > $bits) {
			$this->subTo(math_BigInteger::getONE()->shl($bits - 1), $this);
		}
		while(!$this->isProbablePrime($ta)) {
			$this->dAddOffset(2, 0);
			while($this->bitLength() > $bits) {
				$this->subTo(math_BigInteger::getONE()->shl($bits - 1), $this);
			}
		}
	}
	public function bitwiseTo($a, $op, $r) {
		$f = null;
		$m = intval(Math::min($a->t, $this->t));
		{
			$_g = 0;
			while($_g < $m) {
				$i = $_g++;
				$r->chunks[$i] = call_user_func_array($op, array($this->chunks[$i], $a->chunks[$i]));
				unset($i);
			}
		}
		if($a->t < $this->t) {
			$f = $a->sign & math_BigInteger::$DM;
			{
				$_g1 = $m; $_g = $this->t;
				while($_g1 < $_g) {
					$i = $_g1++;
					$r->chunks[$i] = call_user_func_array($op, array($this->chunks[$i], $f));
					unset($i);
				}
			}
			$r->t = $this->t;
		} else {
			$f = $this->sign & math_BigInteger::$DM;
			{
				$_g1 = $m; $_g = $a->t;
				while($_g1 < $_g) {
					$i = $_g1++;
					$r->chunks[$i] = call_user_func_array($op, array($f, $a->chunks[$i]));
					unset($i);
				}
			}
			$r->t = $a->t;
		}
		$r->sign = call_user_func_array($op, array($this->sign, $a->sign));
		$r->clamp();
	}
	public function changeBit($n, $op) {
		$r = math_BigInteger::getONE()->shl($n);
		$this->bitwiseTo($r, $op, $r);
		return $r;
	}
	public function chunkSize($r) {
		return Math::floor(0.6931471805599453 * math_BigInteger::$DB / Math::log($r));
	}
	public function dMultiply($n) {
		$this->chunks[$this->t] = $this->am(0, $n - 1, $this, 0, 0, $this->t);
		$this->t++;
		$this->clamp();
	}
	public function exp($e, $z) {
		if($e > 2147483647 || $e < 1) {
			return math_BigInteger::getONE();
		}
		$r = math_BigInteger::nbi();
		$r2 = math_BigInteger::nbi();
		$g = $z->convert($this);
		$i = math_BigInteger::nbits($e) - 1;
		$g->copyTo($r);
		while(--$i >= 0) {
			$z->sqrTo($r, $r2);
			if(($e & 1 << $i) > 0) {
				$z->mulTo($r2, $g, $r);
			} else {
				$t = $r;
				$r = $r2;
				$r2 = $t;
				unset($t);
			}
		}
		return $z->revert($r);
	}
	public function millerRabin($v) {
		$n1 = $this->sub(math_BigInteger::getONE());
		$k = $n1->getLowestSetBit();
		if($k <= 0) {
			return false;
		}
		$r = $n1->shr($k);
		$v = $v + 1 >> 1;
		if($v > math_BigInteger::$lowprimes->length) {
			$v = math_BigInteger::$lowprimes->length;
		}
		$a = math_BigInteger::nbi();
		{
			$_g = 0;
			while($_g < $v) {
				$i = $_g++;
				$a->fromInt(math_BigInteger::$lowprimes[$i]);
				$y = $a->modPow($r, $this);
				if($y->compare(math_BigInteger::getONE()) !== 0 && $y->compare($n1) !== 0) {
					$j = 1;
					while($j++ < $k && $y->compare($n1) !== 0) {
						$y = $y->modPowInt(2, $this);
						if($y->compare(math_BigInteger::getONE()) === 0) {
							return false;
						}
					}
					if($y->compare($n1) !== 0) {
						return false;
					}
					unset($j);
				}
				unset($y,$i);
			}
		}
		return true;
	}
	public function lShiftTo($n, $r) {
		$bs = $n % math_BigInteger::$DB;
		$cbs = math_BigInteger::$DB - $bs;
		$bm = (1 << $cbs) - 1;
		$ds = Math::floor($n / math_BigInteger::$DB); $c = $this->sign << $bs & math_BigInteger::$DM; $i = null;
		$i1 = $this->t - 1;
		while($i1 >= 0) {
			$r->chunks[$i1 + $ds + 1] = $this->chunks->»a[$i1] >> $cbs | $c;
			$c = ($this->chunks->»a[$i1] & $bm) << $bs;
			$i1--;
		}
		$i1 = $ds - 1;
		while($i1 >= 0) {
			$r->chunks[$i1] = 0;
			$i1--;
		}
		$r->chunks[$ds] = $c;
		$r->t = $this->t + $ds + 1;
		$r->sign = $this->sign;
		$r->clamp();
	}
	public function rShiftTo($n, $r) {
		$r->sign = $this->sign;
		$ds = Math::floor($n / math_BigInteger::$DB);
		if($ds >= $this->t) {
			$r->t = 0;
			return;
		}
		$bs = $n % math_BigInteger::$DB;
		$cbs = math_BigInteger::$DB - $bs;
		$bm = (1 << $bs) - 1;
		$r->chunks[0] = $this->chunks->»a[$ds] >> $bs;
		{
			$_g1 = $ds + 1; $_g = $this->t;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r->chunks->»a[$i - $ds - 1] |= ($this->chunks->»a[$i] & $bm) << $cbs;
				$r->chunks[$i - $ds] = $this->chunks->»a[$i] >> $bs;
				unset($i);
			}
		}
		if($bs > 0) {
			$r->chunks->»a[$this->t - $ds - 1] |= ($this->sign & $bm) << $cbs;
		}
		$r->t = $this->t - $ds;
		$r->clamp();
	}
	public function am2($i, $x, $w, $j, $c, $n) {
		$xl = $x & 32767;
		$xh = $x >> 15;
		while(--$n >= 0) {
			$l = $this->chunks->»a[$i] & 32767;
			$h = $this->chunks->»a[$i] >> 15;
			$i++;
			$m = $xh * $l + $h * $xl;
			$l = $xl * $l + (($m & 32767) << 15) + $w->chunks[$j] + ($c & 1073741823);
			$c = (_hx_shift_right($l, 30)) + (_hx_shift_right($m, 15)) + $xh * $h + (_hx_shift_right($c, 30));
			$w->chunks[$j] = $l & 1073741823;
			$j++;
			unset($m,$l,$h);
		}
		return $c;
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
	static $MAX_RADIX = 36;
	static $MIN_RADIX = 2;
	static $DB;
	static $DM;
	static $DV;
	static $BI_FP;
	static $FV;
	static $F1;
	static $F2;
	static $ZERO;
	static $ONE;
	static $BI_RM;
	static $BI_RC;
	static $lowprimes;
	static $lplim;
	static $defaultAm;
	static function initBiRc() {
		math_BigInteger::$BI_RC = new _hx_array(array());
		$rr = _hx_char_code_at("0", 0);
		{
			$_g = 0;
			while($_g < 10) {
				$vv = $_g++;
				math_BigInteger::$BI_RC[$rr] = $vv;
				$rr++;
				unset($vv);
			}
		}
		$rr = _hx_char_code_at("a", 0);
		{
			$_g = 10;
			while($_g < 37) {
				$vv = $_g++;
				math_BigInteger::$BI_RC[$rr] = $vv;
				$rr++;
				unset($vv);
			}
		}
		$rr = _hx_char_code_at("A", 0);
		{
			$_g = 10;
			while($_g < 37) {
				$vv = $_g++;
				math_BigInteger::$BI_RC[$rr] = $vv;
				$rr++;
				unset($vv);
			}
		}
	}
	static function getZERO() {
		return math_BigInteger::nbv(0);
	}
	static function getONE() {
		return math_BigInteger::nbv(1);
	}
	static function nbv($i) {
		$r = math_BigInteger::nbi();
		$r->fromInt($i);
		return $r;
	}
	static function nbi() {
		return new math_BigInteger();
	}
	static function ofString($s, $base) {
		$me = math_BigInteger::nbi();
		$fromStringExt = array(new _hx_lambda(array(&$base, &$me, &$s), "math_BigInteger_6"), 'execute');
		$k = null;
		if($base === 16) {
			$k = 4;
		} else {
			if($base === 10) {
				return call_user_func_array($fromStringExt, array($s, $base));
			} else {
				if($base === 256) {
					$k = 8;
				} else {
					if($base === 8) {
						$k = 3;
					} else {
						if($base === 2) {
							$k = 1;
						} else {
							if($base === 32) {
								$k = 5;
							} else {
								if($base === 4) {
									$k = 2;
								} else {
									return call_user_func_array($fromStringExt, array($s, $base));
								}
							}
						}
					}
				}
			}
		}
		$me->t = 0;
		$me->sign = 0;
		$i = strlen($s); $mi = false; $sh = 0;
		while(--$i >= 0) {
			$x = math_BigInteger_7($base, $fromStringExt, $i, $k, $me, $mi, $s, $sh);
			if($x < 0) {
				if(_hx_char_at($s, $i) === "-") {
					$mi = true;
				}
				continue;
			}
			$mi = false;
			if($sh === 0) {
				$me->chunks[$me->t] = $x;
				$me->t++;
			} else {
				if($sh + $k > math_BigInteger::$DB) {
					$me->chunks->»a[$me->t - 1] |= ($x & (1 << math_BigInteger::$DB - $sh) - 1) << $sh;
					$me->chunks[$me->t] = $x >> math_BigInteger::$DB - $sh;
					$me->t++;
				} else {
					$me->chunks->»a[$me->t - 1] |= $x << $sh;
				}
			}
			$sh += $k;
			if($sh >= math_BigInteger::$DB) {
				$sh -= math_BigInteger::$DB;
			}
			unset($x);
		}
		if($k === 8 && (_hx_char_code_at($s, 0) & 128) !== 0) {
			$me->sign = -1;
			if($sh > 0) {
				$me->chunks->»a[$me->t - 1] |= (1 << math_BigInteger::$DB - $sh) - 1 << $sh;
			}
		}
		$me->clamp();
		if($mi) {
			math_BigInteger::getZERO()->subTo($me, $me);
		}
		return $me;
	}
	static function ofInt($x) {
		$i = math_BigInteger::nbi();
		$i->fromInt($x);
		return $i;
	}
	static function ofInt32($x) {
		$i = math_BigInteger::nbi();
		$i->fromInt32($x);
		return $i;
	}
	static function ofBytes($r, $unsigned, $pos, $len) {
		if($pos === null) {
			$pos = 0;
		}
		if($len === null) {
			$len = $r->length - $pos;
		}
		if($len === 0) {
			return math_BigInteger::getZERO();
		}
		$bi = math_BigInteger::nbi();
		$bi->sign = 0;
		$bi->t = 0;
		$i = $pos + $len;
		$sh = 0;
		while(--$i >= $pos) {
			$x = math_BigInteger_8($bi, $i, $len, $pos, $r, $sh, $unsigned);
			if($sh === 0) {
				$bi->chunks[$bi->t] = $x;
				$bi->t++;
			} else {
				if($sh + 8 > math_BigInteger::$DB) {
					$bi->chunks->»a[$bi->t - 1] |= ($x & (1 << math_BigInteger::$DB - $sh) - 1) << $sh;
					$bi->chunks[$bi->t] = $x >> math_BigInteger::$DB - $sh;
					$bi->t++;
				} else {
					$bi->chunks->»a[$bi->t - 1] |= $x << $sh;
				}
			}
			$sh += 8;
			if($sh >= math_BigInteger::$DB) {
				$sh -= math_BigInteger::$DB;
			}
			unset($x);
		}
		if(!$unsigned && (ord($r->b[0]) & 128) !== 0) {
			$bi->sign = -1;
			if($sh > 0) {
				$bi->chunks->»a[$bi->t - 1] |= (1 << math_BigInteger::$DB - $sh) - 1 << $sh;
			}
		}
		$bi->clamp();
		return $bi;
	}
	static function random($bits, $rng) {
		if($rng === null) {
			$rng = new math_prng_Random(null);
		}
		if($bits < 2) {
			return math_BigInteger::ofInt(1);
		}
		$len = ($bits >> 3) + 1;
		$x = Bytes::alloc($len);
		$t = $bits & 7;
		$rng->nextBytes($x, 0, $len);
		if($t > 0) {
			$v = ord($x->b[0]);
			$v &= (1 << $t) - 1;
			$x->b[0] = chr($v);
		} else {
			$x->b[0] = chr(0);
		}
		return math_BigInteger::ofString(BytesUtil::hexDump($x, ""), 16);
	}
	static function randomPrime($bits, $gcdExp, $iterations, $forceLength, $rng) {
		if($rng === null) {
			$rng = new math_prng_Random(null);
		}
		if($iterations < 1) {
			$iterations = 1;
		}
		while(true) {
			$i = math_BigInteger::random($bits, $rng);
			if($forceLength) {
				if(!$i->testBit($bits - 1)) {
					$i->bitwiseTo(math_BigInteger::getONE()->shl($bits - 1), (isset(math_BigInteger::$op_or) ? math_BigInteger::$op_or: array("math_BigInteger", "op_or")), $i);
				}
			}
			if($i->isEven()) {
				$i->dAddOffset(1, 0);
			}
			$i->primify($bits, 1);
			if($i->sub(math_BigInteger::getONE())->gcd($gcdExp)->compare(math_BigInteger::getONE()) === 0 && $i->isProbablePrime($iterations)) {
				return $i;
			}
			unset($i);
		}
		return null;
	}
	static function op_and($x, $y) {
		return $x & $y;
	}
	static function op_or($x, $y) {
		return $x | $y;
	}
	static function op_xor($x, $y) {
		return $x ^ $y;
	}
	static function op_andnot($x, $y) {
		return $x & ~$y;
	}
	static function nbits($x) {
		$r = 1;
		$t = null;
		if(($t = _hx_shift_right($x, 16)) !== 0) {
			$x = $t;
			$r += 16;
		}
		if(($t = $x >> 8) !== 0) {
			$x = $t;
			$r += 8;
		}
		if(($t = $x >> 4) !== 0) {
			$x = $t;
			$r += 4;
		}
		if(($t = $x >> 2) !== 0) {
			$x = $t;
			$r += 2;
		}
		if(($t = $x >> 1) !== 0) {
			$x = $t;
			$r += 1;
		}
		return $r;
	}
	static function cbit($x) {
		$r = 0;
		while($x !== 0) {
			$x &= $x - 1;
			++$r;
		}
		return $r;
	}
	static function intAt($s, $i) {
		$c = math_BigInteger::$BI_RC[_hx_char_code_at($s, $i)];
		if($c === null) {
			return -1;
		}
		return $c;
	}
	static function int2charCode($n) {
		return _hx_char_code_at(math_BigInteger::$BI_RM, $n);
	}
	static function lbit($x) {
		if($x === 0) {
			return -1;
		}
		$r = 0;
		if(($x & 65535) === 0) {
			$x >>= 16;
			$r += 16;
		}
		if(($x & 255) === 0) {
			$x >>= 8;
			$r += 8;
		}
		if(($x & 15) === 0) {
			$x >>= 4;
			$r += 4;
		}
		if(($x & 3) === 0) {
			$x >>= 2;
			$r += 2;
		}
		if(($x & 1) === 0) {
			++$r;
		}
		return $r;
	}
	static function dumpBi($r) {
		$s = "sign: " . Std::string($r->sign);
		$s .= " t: " . $r->t;
		$s .= Std::string($r->chunks);
		return $s;
	}
	function __toString() { return $this->toString(); }
}
{
	$dbits = null;
	$dbits = 30;
	switch($dbits) {
	case 30:{
		math_BigInteger::$defaultAm = 2;
	}break;
	case 28:{
		math_BigInteger::$defaultAm = 3;
	}break;
	case 26:{
		math_BigInteger::$defaultAm = 1;
	}break;
	default:{
		throw new HException("bad dbits value");
	}break;
	}
	math_BigInteger::$DB = $dbits;
	math_BigInteger::$DM = (1 << math_BigInteger::$DB) - 1;
	math_BigInteger::$DV = 1 << math_BigInteger::$DB;
	math_BigInteger::$BI_FP = 52;
	math_BigInteger::$FV = Math::pow(2, math_BigInteger::$BI_FP);
	math_BigInteger::$F1 = math_BigInteger::$BI_FP - math_BigInteger::$DB;
	math_BigInteger::$F2 = 2 * math_BigInteger::$DB - math_BigInteger::$BI_FP;
	math_BigInteger::initBiRc();
	math_BigInteger::$BI_RM = "0123456789abcdefghijklmnopqrstuvwxyz";
	math_BigInteger::$lowprimes = new _hx_array(array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509));
	math_BigInteger::$lplim = intval(67108864 / math_BigInteger::$lowprimes[math_BigInteger::$lowprimes->length - 1]);
}
function math_BigInteger_0(&$»this) {
	if($»this->t > 0) {
		return $»this->chunks->»a[0] & 1;
	} else {
		return $»this->sign;
	}
}
function math_BigInteger_1(&$»this, &$d, &$n) {
	if($»this->sign < 0) {
		return $n - 1;
	} else {
		return 0;
	}
}
function math_BigInteger_2(&$»this, &$m, &$ms, &$nsh, &$pm, &$pt, &$q, &$r, &$ts, &$y, &$y0, &$ys) {
	if($ys > 1) {
		return ($y->chunks->»a[$ys - 2] >> math_BigInteger::$F2) * 1.0;
	} else {
		return 0.0;
	}
}
function math_BigInteger_3(&$»this) {
	if($»this->t === 0) {
		return $»this->sign;
	} else {
		return $»this->chunks[0] << 16 >> 16;
	}
}
function math_BigInteger_4(&$»this) {
	if($»this->t === 0) {
		return $»this->sign;
	} else {
		return $»this->chunks[0] << 24 >> 24;
	}
}
function math_BigInteger_5(&$»this, &$x, &$y) {
	if($y > 0) {
		return math_BigInteger::$DV - $y;
	} else {
		return -$y;
	}
}
function math_BigInteger_6(&$base, &$me, &$s, $s1, $b) {
	{
		$me->fromInt(0);
		$cs = Math::floor(0.6931471805599453 * math_BigInteger::$DB / Math::log($b));
		$d = intval(Math::pow($b, $cs));
		$mi = false;
		$j = 0;
		$w = 0;
		{
			$_g1 = 0; $_g = strlen($s1);
			while($_g1 < $_g) {
				$i = $_g1++;
				$x = math_BigInteger::intAt($s1, $i);
				if($x < 0) {
					if(_hx_char_at($s1, $i) === "-" && $me->sign === 0) {
						$mi = true;
					}
					continue;
				}
				$w = $b * $w + $x;
				if(++$j >= $cs) {
					$me->dMultiply($d);
					$me->dAddOffset($w, 0);
					$j = 0;
					$w = 0;
				}
				unset($x,$i);
			}
		}
		if($j > 0) {
			$me->dMultiply(intval(Math::pow($b, $j)));
			$me->dAddOffset($w, 0);
		}
		if($mi) {
			math_BigInteger::getZERO()->subTo($me, $me);
		}
		return $me;
	}
}
function math_BigInteger_7(&$base, &$fromStringExt, &$i, &$k, &$me, &$mi, &$s, &$sh) {
	if($k === 8) {
		return _hx_char_code_at($s, $i) & 255;
	} else {
		return math_BigInteger::intAt($s, $i);
	}
}
function math_BigInteger_8(&$bi, &$i, &$len, &$pos, &$r, &$sh, &$unsigned) {
	if($i < $len) {
		return ord($r->b[$i]) & 255;
	} else {
		return 0;
	}
}
