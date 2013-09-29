<?php

class chx_formats_Base64 {
	public function __construct(){}
	static $enc;
	static function encode($bytes) {
		$ext = chx_formats_Base64_0($bytes);
		if(chx_formats_Base64::$enc === null) {
			chx_formats_Base64::$enc = new haxe_BaseCode(Bytes::ofString("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"));
		}
		return chx_formats_Base64::$enc->encodeBytes($bytes)->toString() . $ext;
	}
	static function decode($s) {
		$s = StringTools::stripWhite($s);
		$s = str_replace("=", "", $s);
		if(chx_formats_Base64::$enc === null) {
			chx_formats_Base64::$enc = new haxe_BaseCode(Bytes::ofString("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"));
		}
		return chx_formats_Base64_1($s);
	}
	function __toString() { return 'chx.formats.Base64'; }
}
function chx_formats_Base64_0(&$bytes) {
	switch($bytes->length % 3) {
	case 1:{
		return "==";
	}break;
	case 2:{
		return "=";
	}break;
	case 0:{
		return "";
	}break;
	}
}
function chx_formats_Base64_1(&$s) {
	try {
		return chx_formats_Base64::$enc->decodeBytes(Bytes::ofString($s));
	}catch(Exception $»e) {
		$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
		$e = $_ex_;
		{
			return null;
		}
	}
}
