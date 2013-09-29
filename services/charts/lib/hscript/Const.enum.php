<?php

class hscript_Const extends Enum {
	public static function CFloat($f) { return new hscript_Const("CFloat", 1, array($f)); }
	public static function CInt($v) { return new hscript_Const("CInt", 0, array($v)); }
	public static function CInt32($v) { return new hscript_Const("CInt32", 3, array($v)); }
	public static function CString($s) { return new hscript_Const("CString", 2, array($s)); }
	public static $__constructors = array(1 => 'CFloat', 0 => 'CInt', 3 => 'CInt32', 2 => 'CString');
	}
