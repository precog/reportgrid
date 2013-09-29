<?php

class ufront_web_UrlDirection extends Enum {
	public static $IncomingUrlRequest;
	public static $UrlGeneration;
	public static $__constructors = array(0 => 'IncomingUrlRequest', 1 => 'UrlGeneration');
	}
ufront_web_UrlDirection::$IncomingUrlRequest = new ufront_web_UrlDirection("IncomingUrlRequest", 0);
ufront_web_UrlDirection::$UrlGeneration = new ufront_web_UrlDirection("UrlGeneration", 1);
