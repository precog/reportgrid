<?php

class BytesUtil {
	public function __construct(){}
	static $hEMPTY;
	static function byteArrayToBytes($a, $padToBytes) {
		$sb = new BytesBuffer();
		{
			$_g = 0;
			while($_g < $a->length) {
				$i = $a[$_g];
				++$_g;
				if($i > 255 || $i < 0) {
					throw new HException("Value out of range");
				}
				$sb->b .= chr($i);
				unset($i);
			}
		}
		if($padToBytes !== null && $padToBytes > 0) {
			return BytesUtil::nullPad($sb->getBytes(), $padToBytes);
		}
		return $sb->getBytes();
	}
	static function byteToHex($b) {
		$b = $b & 255;
		return strtolower(StringTools::hex($b, 2));
	}
	static function byte32ToHex($b) {
		$bs = $b & 255 & -1;
		return strtolower(StringTools::hex($bs, 2));
	}
	static function bytesToInt32LE($s) {
		return I32::unpackLE(BytesUtil::nullPad($s, 4));
	}
	static function cleanHexFormat($hex) {
		$e = str_replace(":", "", $hex);
		$e = _hx_explode("|", $e)->join("");
		$e = _hx_explode("\x0D", $e)->join("");
		$e = _hx_explode("\x0A", $e)->join("");
		$e = _hx_explode("\x09", $e)->join("");
		$e = str_replace(" ", "", $e);
		$e = str_replace(" ", "", $e);
		if(StringTools::startsWith($e, "0x")) {
			$e = _hx_substr($e, 2, null);
		}
		if((strlen($e) & 1) === 1) {
			$e = "0" . $e;
		}
		return strtolower($e);
	}
	static function encodeToBase($buf, $base) {
		$bc = new haxe_BaseCode(Bytes::ofString($base));
		return $bc->encodeBytes($buf);
	}
	static function eq($a, $b) {
		if($a->length !== $b->length) {
			return false;
		}
		$l = $a->length;
		{
			$_g = 0;
			while($_g < $l) {
				$i = $_g++;
				if(ord($a->b[$i]) !== ord($b->b[$i])) {
					return false;
				}
				unset($i);
			}
		}
		return true;
	}
	static function hexDump($b, $separator) {
		return BytesUtil::toHex($b, $separator);
	}
	static function int32ToBytesLE($l) {
		return I32::packLE($l);
	}
	static function int32ArrayToBytes($a, $padToBytes) {
		$sb = new BytesBuffer();
		{
			$_g = 0;
			while($_g < $a->length) {
				$v = $a[$_g];
				++$_g;
				$i = $v & -1;
				if($i > 255 || $i < 0) {
					throw new HException("Value out of range");
				}
				$sb->b .= chr($i);
				unset($v,$i);
			}
		}
		if($padToBytes !== null && $padToBytes > 0) {
			return BytesUtil::nullPad($sb->getBytes(), $padToBytes);
		}
		return $sb->getBytes();
	}
	static function intArrayToBytes($a, $padToBytes) {
		$sb = new BytesBuffer();
		{
			$_g = 0;
			while($_g < $a->length) {
				$i = $a[$_g];
				++$_g;
				if($i > 255 || $i < 0) {
					throw new HException("Value out of range");
				}
				$sb->b .= chr($i);
				unset($i);
			}
		}
		if($padToBytes !== null && $padToBytes > 0) {
			return BytesUtil::nullPad($sb->getBytes(), $padToBytes);
		}
		return $sb->getBytes();
	}
	static function nullBytes($len) {
		$sb = Bytes::alloc($len);
		{
			$_g = 0;
			while($_g < $len) {
				$i = $_g++;
				$sb->b[$i] = chr(0);
				unset($i);
			}
		}
		return $sb;
	}
	static function nullPad($s, $chunkLen) {
		$r = $chunkLen - $s->length % $chunkLen;
		if($r === $chunkLen) {
			return $s;
		}
		$sb = new BytesBuffer();
		$sb->b .= $s->b;
		{
			$_g = 0;
			while($_g < $r) {
				$x = $_g++;
				$sb->b .= chr(0);
				unset($x);
			}
		}
		return $sb->getBytes();
	}
	static function ofIntArray($a) {
		$b = new BytesBuffer();
		{
			$_g1 = 0; $_g = $a->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$b->b .= chr(BytesUtil::cleanValue($a[$i]));
				unset($i);
			}
		}
		return $b->getBytes();
	}
	static function ofHex($hs) {
		$s = BytesUtil::cleanHexFormat($hs);
		$b = new BytesBuffer();
		$l = intval(strlen($s) / 2);
		{
			$_g = 0;
			while($_g < $l) {
				$x = $_g++;
				$ch = _hx_substr($s, $x * 2, 2);
				$v = Std::parseInt("0x" . $ch);
				if($v > 255) {
					throw new HException("error");
				}
				$b->b .= chr($v);
				unset($x,$v,$ch);
			}
		}
		return $b->getBytes();
	}
	static function toHex($b, $separator) {
		if($separator === null) {
			$separator = " ";
		}
		$sb = new StringBuf();
		$l = $b->length;
		$first = true;
		{
			$_g = 0;
			while($_g < $l) {
				$i = $_g++;
				if($first) {
					$first = false;
				} else {
					$x = $separator;
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
					$x = strtolower(StringTools::hex(ord($b->b[$i]), 2));
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
		return rtrim($sb->b);
	}
	static function unNullPad($s) {
		$p = $s->length - 1;
		while($p-- > 0) {
			if(ord($s->b[$p]) !== 0) {
				break;
			}
		}
		if($p === 0 && ord($s->b[0]) === 0) {
			$bb = new BytesBuffer();
			return $bb->getBytes();
		}
		$p++;
		$b = Bytes::alloc($p);
		$b->blit(0, $s, 0, $p);
		return $b;
	}
	static function cleanValue($v) {
		$neg = false;
		if($v < 0) {
			if($v < -128) {
				throw new HException("not a byte");
			}
			$neg = true;
			$v = $v & 255 | 128;
		}
		if($v > 255) {
			throw new HException("not a byte");
		}
		return $v;
	}
	function __toString() { return 'BytesUtil'; }
}
{
	$bb = new BytesBuffer();
	BytesUtil::$hEMPTY = $bb->getBytes();
}
