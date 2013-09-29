<?php

class hscript_Expr extends Enum {
	public static function EArray($e, $index) { return new hscript_Expr("EArray", 16, array($e, $index)); }
	public static function EArrayDecl($e) { return new hscript_Expr("EArrayDecl", 17, array($e)); }
	public static function EBinop($op, $e1, $e2) { return new hscript_Expr("EBinop", 6, array($op, $e1, $e2)); }
	public static function EBlock($e) { return new hscript_Expr("EBlock", 4, array($e)); }
	public static $EBreak;
	public static function ECall($e, $params) { return new hscript_Expr("ECall", 8, array($e, $params)); }
	public static function EConst($c) { return new hscript_Expr("EConst", 0, array($c)); }
	public static $EContinue;
	public static function EField($e, $f) { return new hscript_Expr("EField", 5, array($e, $f)); }
	public static function EFor($v, $it, $e) { return new hscript_Expr("EFor", 11, array($v, $it, $e)); }
	public static function EFunction($args, $e, $name = null, $ret = null) { return new hscript_Expr("EFunction", 14, array($args, $e, $name, $ret)); }
	public static function EIdent($v) { return new hscript_Expr("EIdent", 1, array($v)); }
	public static function EIf($cond, $e1, $e2 = null) { return new hscript_Expr("EIf", 9, array($cond, $e1, $e2)); }
	public static function ENew($cl, $params) { return new hscript_Expr("ENew", 18, array($cl, $params)); }
	public static function EObject($fl) { return new hscript_Expr("EObject", 21, array($fl)); }
	public static function EParent($e) { return new hscript_Expr("EParent", 3, array($e)); }
	public static function EReturn($e = null) { return new hscript_Expr("EReturn", 15, array($e)); }
	public static function ETernary($cond, $e1, $e2) { return new hscript_Expr("ETernary", 22, array($cond, $e1, $e2)); }
	public static function EThrow($e) { return new hscript_Expr("EThrow", 19, array($e)); }
	public static function ETry($e, $v, $t, $ecatch) { return new hscript_Expr("ETry", 20, array($e, $v, $t, $ecatch)); }
	public static function EUnop($op, $prefix, $e) { return new hscript_Expr("EUnop", 7, array($op, $prefix, $e)); }
	public static function EVar($n, $t = null, $e = null) { return new hscript_Expr("EVar", 2, array($n, $t, $e)); }
	public static function EWhile($cond, $e) { return new hscript_Expr("EWhile", 10, array($cond, $e)); }
	public static $__constructors = array(16 => 'EArray', 17 => 'EArrayDecl', 6 => 'EBinop', 4 => 'EBlock', 12 => 'EBreak', 8 => 'ECall', 0 => 'EConst', 13 => 'EContinue', 5 => 'EField', 11 => 'EFor', 14 => 'EFunction', 1 => 'EIdent', 9 => 'EIf', 18 => 'ENew', 21 => 'EObject', 3 => 'EParent', 15 => 'EReturn', 22 => 'ETernary', 19 => 'EThrow', 20 => 'ETry', 7 => 'EUnop', 2 => 'EVar', 10 => 'EWhile');
	}
hscript_Expr::$EBreak = new hscript_Expr("EBreak", 12);
hscript_Expr::$EContinue = new hscript_Expr("EContinue", 13);
