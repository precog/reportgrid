<?php

class StringTools {
	public function __construct(){}
	static function urlEncode($s) {
		return rawurlencode($s);
	}
	static function urlDecode($s) {
		return urldecode($s);
	}
	static function htmlEscape($s) {
		return _hx_explode(">", _hx_explode("<", _hx_explode("&", $s)->join("&amp;"))->join("&lt;"))->join("&gt;");
	}
	static function htmlUnescape($s) {
		return htmlspecialchars_decode($s);
	}
	static function startsWith($s, $start) {
		return strlen($s) >= strlen($start) && _hx_substr($s, 0, strlen($start)) === $start;
	}
	static function endsWith($s, $end) {
		$elen = strlen($end);
		$slen = strlen($s);
		return $slen >= $elen && _hx_substr($s, $slen - $elen, $elen) === $end;
	}
	static function isSpace($s, $pos) {
		$c = _hx_char_code_at($s, $pos);
		return $c >= 9 && $c <= 13 || $c === 32;
	}
	static function ltrim($s) {
		return ltrim($s);
	}
	static function rtrim($s) {
		return rtrim($s);
	}
	static function trim($s) {
		return trim($s);
	}
	static function rpad($s, $c, $l) {
		return str_pad($s, $l, $c, STR_PAD_RIGHT);
	}
	static function lpad($s, $c, $l) {
		return str_pad($s, $l, $c, STR_PAD_LEFT);
	}
	static function replace($s, $sub, $by) {
		return str_replace($sub, $by, $s);
	}
	static function hex($n, $digits) {
		$s = "";
		$hexChars = "0123456789ABCDEF";
		do {
			$s = _hx_char_at($hexChars, $n & 15) . $s;
			$n = _hx_shift_right($n, 4);
		} while($n > 0);
		if($digits !== null) {
			while(strlen($s) < $digits) {
				$s = "0" . $s;
			}
		}
		return $s;
	}
	static function fastCodeAt($s, $index) {
		return ord(substr($s,$index,1));
	}
	static function isEOF($c) {
		return false;
	}
	static function replaceRecurse($s, $sub, $by) {
		if(strlen($sub) === 0) {
			return str_replace($sub, $by, $s);
		}
		if(_hx_index_of($by, $sub, null) >= 0) {
			throw new HException("Infinite recursion");
		}
		$ns = $s;
		$olen = 0;
		$nlen = strlen($ns);
		while($olen !== $nlen) {
			$olen = strlen($ns);
			str_replace($sub, $by, $ns);
			$nlen = strlen($ns);
		}
		return $ns;
	}
	static function stripWhite($s) {
		$l = strlen($s);
		$i = 0;
		$sb = new StringBuf();
		while($i < $l) {
			if(!StringTools::isSpace($s, $i)) {
				$x = _hx_char_at($s, $i);
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
			$i++;
		}
		return $sb->b;
	}
	static function isNum($s, $pos) {
		$c = _hx_char_code_at($s, $pos);
		return $c >= 48 && $c <= 57;
	}
	static function isAlpha($s, $pos) {
		$c = _hx_char_code_at($s, $pos);
		return $c >= 65 && $c <= 90 || $c >= 97 && $c <= 122;
	}
	static function num($s, $pos) {
		$c = _hx_char_code_at($s, $pos);
		if($c > 0) {
			$c -= 48;
			if($c < 0 || $c > 9) {
				return null;
			}
			return $c;
		}
		return null;
	}
	static function splitLines($str) {
		$ret = _hx_explode("\x0A", $str);
		{
			$_g1 = 0; $_g = $ret->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$l = $ret[$i];
				if(_hx_substr($l, -1, 1) === "\x0D") {
					$ret[$i] = _hx_substr($l, 0, -1);
				}
				unset($l,$i);
			}
		}
		return $ret;
	}
	function __toString() { return 'StringTools'; }
}
