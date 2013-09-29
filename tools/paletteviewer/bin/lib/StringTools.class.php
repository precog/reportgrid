<?php

class StringTools {
	public function __construct(){}
	static function urlEncode($s) {
		$GLOBALS['%s']->push("StringTools::urlEncode");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = rawurlencode($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function urlDecode($s) {
		$GLOBALS['%s']->push("StringTools::urlDecode");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = urldecode($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function htmlEscape($s) {
		$GLOBALS['%s']->push("StringTools::htmlEscape");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_explode(">", _hx_explode("<", _hx_explode("&", $s)->join("&amp;"))->join("&lt;"))->join("&gt;");
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function htmlUnescape($s) {
		$GLOBALS['%s']->push("StringTools::htmlUnescape");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = htmlspecialchars_decode($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function startsWith($s, $start) {
		$GLOBALS['%s']->push("StringTools::startsWith");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = strlen($s) >= strlen($start) && _hx_substr($s, 0, strlen($start)) === $start;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function endsWith($s, $end) {
		$GLOBALS['%s']->push("StringTools::endsWith");
		$»spos = $GLOBALS['%s']->length;
		$elen = strlen($end);
		$slen = strlen($s);
		{
			$»tmp = $slen >= $elen && _hx_substr($s, $slen - $elen, $elen) === $end;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isSpace($s, $pos) {
		$GLOBALS['%s']->push("StringTools::isSpace");
		$»spos = $GLOBALS['%s']->length;
		$c = _hx_char_code_at($s, $pos);
		{
			$»tmp = $c >= 9 && $c <= 13 || $c === 32;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ltrim($s) {
		$GLOBALS['%s']->push("StringTools::ltrim");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ltrim($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function rtrim($s) {
		$GLOBALS['%s']->push("StringTools::rtrim");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = rtrim($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function trim($s) {
		$GLOBALS['%s']->push("StringTools::trim");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = trim($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function rpad($s, $c, $l) {
		$GLOBALS['%s']->push("StringTools::rpad");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = str_pad($s, $l, $c, STR_PAD_RIGHT);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function lpad($s, $c, $l) {
		$GLOBALS['%s']->push("StringTools::lpad");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = str_pad($s, $l, $c, STR_PAD_LEFT);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function replace($s, $sub, $by) {
		$GLOBALS['%s']->push("StringTools::replace");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = str_replace($sub, $by, $s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function hex($n, $digits) {
		$GLOBALS['%s']->push("StringTools::hex");
		$»spos = $GLOBALS['%s']->length;
		$s = dechex($n);
		if($digits !== null) {
			$s = str_pad($s, $digits, "0", STR_PAD_LEFT);
		}
		{
			$»tmp = strtoupper($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fastCodeAt($s, $index) {
		$GLOBALS['%s']->push("StringTools::fastCodeAt");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ord(substr($s,$index,1));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isEOF($c) {
		$GLOBALS['%s']->push("StringTools::isEOF");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ($c === 0);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'StringTools'; }
}
