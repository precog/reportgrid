<?php

class haxe_rtti_CType extends Enum {
	public static function CAnonymous($fields) { return new haxe_rtti_CType("CAnonymous", 5, array($fields)); }
	public static function CClass($name, $params) { return new haxe_rtti_CType("CClass", 2, array($name, $params)); }
	public static function CDynamic($t = null) { return new haxe_rtti_CType("CDynamic", 6, array($t)); }
	public static function CEnum($name, $params) { return new haxe_rtti_CType("CEnum", 1, array($name, $params)); }
	public static function CFunction($args, $ret) { return new haxe_rtti_CType("CFunction", 4, array($args, $ret)); }
	public static function CTypedef($name, $params) { return new haxe_rtti_CType("CTypedef", 3, array($name, $params)); }
	public static $CUnknown;
	public static $__constructors = array(5 => 'CAnonymous', 2 => 'CClass', 6 => 'CDynamic', 1 => 'CEnum', 4 => 'CFunction', 3 => 'CTypedef', 0 => 'CUnknown');
	}
haxe_rtti_CType::$CUnknown = new haxe_rtti_CType("CUnknown", 0);
