<?php

class haxe_macro_ExprDef extends Enum {
	public static function EArray($e1, $e2) { return new haxe_macro_ExprDef("EArray", 1, array($e1, $e2)); }
	public static function EArrayDecl($values) { return new haxe_macro_ExprDef("EArrayDecl", 7, array($values)); }
	public static function EBinop($op, $e1, $e2) { return new haxe_macro_ExprDef("EBinop", 2, array($op, $e1, $e2)); }
	public static function EBlock($exprs) { return new haxe_macro_ExprDef("EBlock", 13, array($exprs)); }
	public static $EBreak;
	public static function ECall($e, $params) { return new haxe_macro_ExprDef("ECall", 8, array($e, $params)); }
	public static function ECast($e, $t) { return new haxe_macro_ExprDef("ECast", 25, array($e, $t)); }
	public static function ECheckType($e, $t) { return new haxe_macro_ExprDef("ECheckType", 29, array($e, $t)); }
	public static function EConst($c) { return new haxe_macro_ExprDef("EConst", 0, array($c)); }
	public static $EContinue;
	public static function EDisplay($e, $isCall) { return new haxe_macro_ExprDef("EDisplay", 26, array($e, $isCall)); }
	public static function EDisplayNew($t) { return new haxe_macro_ExprDef("EDisplayNew", 27, array($t)); }
	public static function EField($e, $field) { return new haxe_macro_ExprDef("EField", 3, array($e, $field)); }
	public static function EFor($it, $expr) { return new haxe_macro_ExprDef("EFor", 14, array($it, $expr)); }
	public static function EFunction($name, $f) { return new haxe_macro_ExprDef("EFunction", 12, array($name, $f)); }
	public static function EIf($econd, $eif, $eelse) { return new haxe_macro_ExprDef("EIf", 16, array($econd, $eif, $eelse)); }
	public static function EIn($e1, $e2) { return new haxe_macro_ExprDef("EIn", 15, array($e1, $e2)); }
	public static function ENew($t, $params) { return new haxe_macro_ExprDef("ENew", 9, array($t, $params)); }
	public static function EObjectDecl($fields) { return new haxe_macro_ExprDef("EObjectDecl", 6, array($fields)); }
	public static function EParenthesis($e) { return new haxe_macro_ExprDef("EParenthesis", 5, array($e)); }
	public static function EReturn($e = null) { return new haxe_macro_ExprDef("EReturn", 20, array($e)); }
	public static function ESwitch($e, $cases, $edef) { return new haxe_macro_ExprDef("ESwitch", 18, array($e, $cases, $edef)); }
	public static function ETernary($econd, $eif, $eelse) { return new haxe_macro_ExprDef("ETernary", 28, array($econd, $eif, $eelse)); }
	public static function EThrow($e) { return new haxe_macro_ExprDef("EThrow", 24, array($e)); }
	public static function ETry($e, $catches) { return new haxe_macro_ExprDef("ETry", 19, array($e, $catches)); }
	public static function EType($e, $field) { return new haxe_macro_ExprDef("EType", 4, array($e, $field)); }
	public static function EUnop($op, $postFix, $e) { return new haxe_macro_ExprDef("EUnop", 10, array($op, $postFix, $e)); }
	public static function EUntyped($e) { return new haxe_macro_ExprDef("EUntyped", 23, array($e)); }
	public static function EVars($vars) { return new haxe_macro_ExprDef("EVars", 11, array($vars)); }
	public static function EWhile($econd, $e, $normalWhile) { return new haxe_macro_ExprDef("EWhile", 17, array($econd, $e, $normalWhile)); }
	public static $__constructors = array(1 => 'EArray', 7 => 'EArrayDecl', 2 => 'EBinop', 13 => 'EBlock', 21 => 'EBreak', 8 => 'ECall', 25 => 'ECast', 29 => 'ECheckType', 0 => 'EConst', 22 => 'EContinue', 26 => 'EDisplay', 27 => 'EDisplayNew', 3 => 'EField', 14 => 'EFor', 12 => 'EFunction', 16 => 'EIf', 15 => 'EIn', 9 => 'ENew', 6 => 'EObjectDecl', 5 => 'EParenthesis', 20 => 'EReturn', 18 => 'ESwitch', 28 => 'ETernary', 24 => 'EThrow', 19 => 'ETry', 4 => 'EType', 10 => 'EUnop', 23 => 'EUntyped', 11 => 'EVars', 17 => 'EWhile');
	}
haxe_macro_ExprDef::$EBreak = new haxe_macro_ExprDef("EBreak", 21);
haxe_macro_ExprDef::$EContinue = new haxe_macro_ExprDef("EContinue", 22);
