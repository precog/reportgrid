<?php

class ufront_web_routing_UriPart extends Enum {
	public static function UPConst($value) { return new ufront_web_routing_UriPart("UPConst", 0, array($value)); }
	public static function UPOptBParam($name, $left, $right) { return new ufront_web_routing_UriPart("UPOptBParam", 5, array($name, $left, $right)); }
	public static function UPOptBRest($name, $left, $right) { return new ufront_web_routing_UriPart("UPOptBRest", 10, array($name, $left, $right)); }
	public static function UPOptLParam($name, $left) { return new ufront_web_routing_UriPart("UPOptLParam", 3, array($name, $left)); }
	public static function UPOptLRest($name, $left) { return new ufront_web_routing_UriPart("UPOptLRest", 8, array($name, $left)); }
	public static function UPOptParam($name) { return new ufront_web_routing_UriPart("UPOptParam", 2, array($name)); }
	public static function UPOptRParam($name, $right) { return new ufront_web_routing_UriPart("UPOptRParam", 4, array($name, $right)); }
	public static function UPOptRRest($name, $right) { return new ufront_web_routing_UriPart("UPOptRRest", 9, array($name, $right)); }
	public static function UPOptRest($name) { return new ufront_web_routing_UriPart("UPOptRest", 7, array($name)); }
	public static function UPParam($name) { return new ufront_web_routing_UriPart("UPParam", 1, array($name)); }
	public static function UPRest($name) { return new ufront_web_routing_UriPart("UPRest", 6, array($name)); }
	public static $__constructors = array(0 => 'UPConst', 5 => 'UPOptBParam', 10 => 'UPOptBRest', 3 => 'UPOptLParam', 8 => 'UPOptLRest', 2 => 'UPOptParam', 4 => 'UPOptRParam', 9 => 'UPOptRRest', 7 => 'UPOptRest', 1 => 'UPParam', 6 => 'UPRest');
	}
