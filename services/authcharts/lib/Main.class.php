<?php

class Main {
	public function __construct(){}
	static $params;
	static function main() {
		$host = Main::$params->get("host");
		if(null === $host) {
			Main::out(null);
		}
		$result = _hx_anonymous(array("host" => $host, "key" => Main::encrypt($host)));
		Main::out($result);
	}
	static function encrypt($s) {
		$rsa = new chx_crypt_RSA(Key::$modulus, Key::$publicExponent, Key::$privateExponent);
		return chx_formats_Base64::encode($rsa->sign(Bytes::ofString($s)));
	}
	static function out($o) {
		$cback = Main::$params->get("callback"); $json = thx_json_Json::encode($o);
		if(null === $cback) {
			php_Lib::hprint($json);
		} else {
			php_Lib::hprint($cback . "(" . $json . ");");
		}
		php_Sys::hexit(((null === $o) ? 1 : 0));
	}
	function __toString() { return 'Main'; }
}
Main::$params = php_Web::getParams();
