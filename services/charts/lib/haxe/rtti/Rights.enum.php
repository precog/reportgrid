<?php

class haxe_rtti_Rights extends Enum {
	public static function RCall($m) { return new haxe_rtti_Rights("RCall", 2, array($m)); }
	public static $RDynamic;
	public static $RInline;
	public static $RMethod;
	public static $RNo;
	public static $RNormal;
	public static $__constructors = array(2 => 'RCall', 4 => 'RDynamic', 5 => 'RInline', 3 => 'RMethod', 1 => 'RNo', 0 => 'RNormal');
	}
haxe_rtti_Rights::$RDynamic = new haxe_rtti_Rights("RDynamic", 4);
haxe_rtti_Rights::$RInline = new haxe_rtti_Rights("RInline", 5);
haxe_rtti_Rights::$RMethod = new haxe_rtti_Rights("RMethod", 3);
haxe_rtti_Rights::$RNo = new haxe_rtti_Rights("RNo", 1);
haxe_rtti_Rights::$RNormal = new haxe_rtti_Rights("RNormal", 0);
