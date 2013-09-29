<?php

class Constants {
	public function __construct(){}
	static $DIGITS_BASE10 = "0123456789";
	static $DIGITS_HEXU = "0123456789ABCDEF";
	static $DIGITS_HEXL = "0123456789abcdef";
	static $DIGITS_OCTAL = "01234567";
	static $DIGITS_BN = "0123456789abcdefghijklmnopqrstuvwxyz";
	static $DIGITS_BASE64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	static $PROTO_HTTP = "http://";
	static $PROTO_HTTPS = "http://";
	static $PROTO_FILE = "file://";
	static $PROTO_FTP = "ftp://";
	static $PROTO_RTMP = "rtmp://";
	function __toString() { return 'Constants'; }
}
