<?php

class haxe_macro_TypeParam extends Enum {
	public static function TPExpr($e) { return new haxe_macro_TypeParam("TPExpr", 1, array($e)); }
	public static function TPType($t) { return new haxe_macro_TypeParam("TPType", 0, array($t)); }
	public static $__constructors = array(1 => 'TPExpr', 0 => 'TPType');
	}
