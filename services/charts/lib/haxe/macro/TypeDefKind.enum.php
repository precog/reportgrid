<?php

class haxe_macro_TypeDefKind extends Enum {
	public static function TDClass($extend = null, $implement = null, $isInterface = null) { return new haxe_macro_TypeDefKind("TDClass", 2, array($extend, $implement, $isInterface)); }
	public static $TDEnum;
	public static $TDStructure;
	public static $__constructors = array(2 => 'TDClass', 0 => 'TDEnum', 1 => 'TDStructure');
	}
haxe_macro_TypeDefKind::$TDEnum = new haxe_macro_TypeDefKind("TDEnum", 0);
haxe_macro_TypeDefKind::$TDStructure = new haxe_macro_TypeDefKind("TDStructure", 1);
