<?php

class haxe_Int32 {
	public function __construct(){}
	static function make($a, $b) {
		return $a << 16 | $b;
	}
	static function ofInt($x) {
		return $x;
	}
	static function clamp($x) {
		return $x;
	}
	static function toInt($x) {
		if(($x >> 30 & 1) !== _hx_shift_right($x, 31)) {
			throw new HException("Overflow " . $x);
		}
		return $x & -1;
	}
	static function toNativeInt($x) {
		return $x;
	}
	static function add($a, $b) {
		return $a + $b;
	}
	static function sub($a, $b) {
		return $a - $b;
	}
	static function mul($a, $b) {
		return $a * $b;
	}
	static function div($a, $b) {
		return intval($a / $b);
	}
	static function mod($a, $b) {
		return $a % $b;
	}
	static function shl($a, $b) {
		return $a << $b;
	}
	static function shr($a, $b) {
		return $a >> $b;
	}
	static function ushr($a, $b) {
		return _hx_shift_right($a, $b);
	}
	static function hand($a, $b) {
		return $a & $b;
	}
	static function hor($a, $b) {
		return $a | $b;
	}
	static function hxor($a, $b) {
		return $a ^ $b;
	}
	static function neg($a) {
		return -$a;
	}
	static function isNeg($a) {
		return $a < 0;
	}
	static function isZero($a) {
		return $a === 0;
	}
	static function complement($a) {
		return ~$a;
	}
	static function compare($a, $b) {
		return $a - $b;
	}
	static function ucompare($a, $b) {
		if($a < 0) {
			return (($b < 0) ? ~$b - ~$a : 1);
		}
		return (($b < 0) ? -1 : $a - $b);
	}
	function __toString() { return 'haxe.Int32'; }
}
