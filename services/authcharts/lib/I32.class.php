<?php

class I32 {
	public function __construct(){}
	static $ZERO = 0;
	static $ONE = 1;
	static $BYTE_MASK = 255;
	static function B4($v) {
		return _hx_shift_right($v, 24) & -1;
	}
	static function B3($v) {
		return _hx_shift_right($v, 16) & 255 & -1;
	}
	static function B2($v) {
		return _hx_shift_right($v, 8) & 255 & -1;
	}
	static function B1($v) {
		return $v & 255 & -1;
	}
	static function abs($v) {
		return intval(Math::abs($v));
	}
	static function add($a, $b) {
		return $a + $b;
	}
	static function alphaFromArgb($v) {
		return _hx_shift_right($v, 24) & -1;
	}
	static function hand($a, $b) {
		return $a & $b;
	}
	static function baseEncode($v, $radix) {
		if($radix < 2 || $radix > 36) {
			throw new HException("radix out of range");
		}
		$sb = "";
		$av = intval(Math::abs($v));
		$radix32 = $radix;
		while(true) {
			$r32 = $av % $radix32;
			$sb = _hx_char_at("0123456789abcdefghijklmnopqrstuvwxyz", $r32 & -1) . $sb;
			$av = intval(($av - $r32) / $radix32);
			if($av === 0) {
				break;
			}
			unset($r32);
		}
		if($v < 0) {
			return "-" . $sb;
		}
		return $sb;
	}
	static function complement($v) {
		return ~$v;
	}
	static function compare($a, $b) {
		return $a - $b;
	}
	static function div($a, $b) {
		return intval($a / $b);
	}
	static function encodeBE($i) {
		$sb = new BytesBuffer();
		$sb->b .= chr(_hx_shift_right($i, 24) & -1);
		$sb->b .= chr(_hx_shift_right($i, 16) & 255 & -1);
		$sb->b .= chr(_hx_shift_right($i, 8) & 255 & -1);
		$sb->b .= chr($i & 255 & -1);
		return $sb->getBytes();
	}
	static function encodeLE($i) {
		$sb = new BytesBuffer();
		$sb->b .= chr($i & 255 & -1);
		$sb->b .= chr(_hx_shift_right($i, 8) & 255 & -1);
		$sb->b .= chr(_hx_shift_right($i, 16) & 255 & -1);
		$sb->b .= chr(_hx_shift_right($i, 24) & -1);
		return $sb->getBytes();
	}
	static function decodeBE($s, $pos) {
		if($pos === null) {
			$pos = 0;
		}
		$b0 = ord($s->b[$pos + 3]);
		$b1 = ord($s->b[$pos + 2]);
		$b2 = ord($s->b[$pos + 1]);
		$b3 = ord($s->b[$pos]);
		$b1 = $b1 << 8;
		$b2 = $b2 << 16;
		$b3 = $b3 << 24;
		$a = $b0 + $b1;
		$a = $a + $b2;
		$a = $a + $b3;
		return $a;
	}
	static function decodeLE($s, $pos) {
		if($pos === null) {
			$pos = 0;
		}
		$b0 = ord($s->b[$pos]);
		$b1 = ord($s->b[$pos + 1]);
		$b2 = ord($s->b[$pos + 2]);
		$b3 = ord($s->b[$pos + 3]);
		$b1 = $b1 << 8;
		$b2 = $b2 << 16;
		$b3 = $b3 << 24;
		$a = $b0 + $b1;
		$a = $a + $b2;
		$a = $a + $b3;
		return $a;
	}
	static function eq($a, $b) {
		return $a === $b;
	}
	static function gt($a, $b) {
		return $a > $b;
	}
	static function gteq($a, $b) {
		return $a >= $b;
	}
	static function lt($a, $b) {
		return $a < $b;
	}
	static function lteq($a, $b) {
		return $a <= $b;
	}
	static function make($high, $low) {
		return ($high << 16) + $low;
	}
	static function makeColor($alpha, $rgb) {
		return $alpha << 24 | $rgb & 16777215;
	}
	static function mod($a, $b) {
		return $a % $b;
	}
	static function mul($a, $b) {
		return $a * $b;
	}
	static function neg($v) {
		return -$v;
	}
	static function ofInt($v) {
		return $v;
	}
	static function hor($a, $b) {
		return $a | $b;
	}
	static function packBE($l) {
		$sb = new BytesBuffer();
		{
			$_g1 = 0; $_g = $l->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$sb->b .= chr(_hx_shift_right($l[$i], 24) & -1);
				$sb->b .= chr(_hx_shift_right($l[$i], 16) & 255 & -1);
				$sb->b .= chr(_hx_shift_right($l[$i], 8) & 255 & -1);
				$sb->b .= chr($l->»a[$i] & 255 & -1);
				unset($i);
			}
		}
		return $sb->getBytes();
	}
	static function packLE($l) {
		$sb = new BytesBuffer();
		{
			$_g1 = 0; $_g = $l->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$sb->b .= chr($l->»a[$i] & 255 & -1);
				$sb->b .= chr(_hx_shift_right($l[$i], 8) & 255 & -1);
				$sb->b .= chr(_hx_shift_right($l[$i], 16) & 255 & -1);
				$sb->b .= chr(_hx_shift_right($l[$i], 24) & -1);
				unset($i);
			}
		}
		return $sb->getBytes();
	}
	static function rgbFromArgb($v) {
		return $v & 16777215;
	}
	static function sub($a, $b) {
		return $a - $b;
	}
	static function shl($v, $bits) {
		return $v << $bits;
	}
	static function shr($v, $bits) {
		return $v >> $bits;
	}
	static function toColor($v) {
		return _hx_anonymous(array("alpha" => _hx_shift_right($v, 24) & -1, "color" => $v & 16777215));
	}
	static function toFloat($v) {
		return $v * 1.0;
	}
	static function toInt($v) {
		return $v & -1;
	}
	static function toNativeArray($v) {
		return $v;
	}
	static function unpackLE($s) {
		if($s === null || $s->length === 0) {
			return new _hx_array(array());
		}
		if($s->length % 4 !== 0) {
			throw new HException("Buffer not multiple of 4 bytes");
		}
		$a = new _hx_array(array());
		$pos = 0;
		$i = 0;
		$len = $s->length;
		while($pos < $len) {
			$a[$i] = I32::decodeLE($s, $pos);
			$pos += 4;
			$i++;
		}
		return $a;
	}
	static function unpackBE($s) {
		if($s === null || $s->length === 0) {
			return new _hx_array(array());
		}
		if($s->length % 4 !== 0) {
			throw new HException("Buffer not multiple of 4 bytes");
		}
		$a = new _hx_array(array());
		$pos = 0;
		$i = 0;
		while($pos < $s->length) {
			$a[$i] = I32::decodeBE($s, $pos);
			$pos += 4;
			$i++;
		}
		return $a;
	}
	static function ushr($v, $bits) {
		return _hx_shift_right($v, $bits);
	}
	static function hxor($a, $b) {
		return $a ^ $b;
	}
	function __toString() { return 'I32'; }
}
