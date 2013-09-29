<?php

class haxe_macro_FieldType extends Enum {
	public static function FFun($f) { return new haxe_macro_FieldType("FFun", 1, array($f)); }
	public static function FProp($get, $set, $t, $e = null) { return new haxe_macro_FieldType("FProp", 2, array($get, $set, $t, $e)); }
	public static function FVar($t, $e = null) { return new haxe_macro_FieldType("FVar", 0, array($t, $e)); }
	public static $__constructors = array(1 => 'FFun', 2 => 'FProp', 0 => 'FVar');
	}
