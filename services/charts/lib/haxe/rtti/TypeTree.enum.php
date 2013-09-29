<?php

class haxe_rtti_TypeTree extends Enum {
	public static function TClassdecl($c) { return new haxe_rtti_TypeTree("TClassdecl", 1, array($c)); }
	public static function TEnumdecl($e) { return new haxe_rtti_TypeTree("TEnumdecl", 2, array($e)); }
	public static function TPackage($name, $full, $subs) { return new haxe_rtti_TypeTree("TPackage", 0, array($name, $full, $subs)); }
	public static function TTypedecl($t) { return new haxe_rtti_TypeTree("TTypedecl", 3, array($t)); }
	public static $__constructors = array(1 => 'TClassdecl', 2 => 'TEnumdecl', 0 => 'TPackage', 3 => 'TTypedecl');
	}
