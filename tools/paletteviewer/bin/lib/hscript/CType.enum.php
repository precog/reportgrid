<?php

class hscript_CType extends Enum {
	public static function CTAnon($fields) { return new hscript_CType("CTAnon", 2, array($fields)); }
	public static function CTFun($args, $ret) { return new hscript_CType("CTFun", 1, array($args, $ret)); }
	public static function CTParent($t) { return new hscript_CType("CTParent", 3, array($t)); }
	public static function CTPath($path, $params = null) { return new hscript_CType("CTPath", 0, array($path, $params)); }
	public static $__constructors = array(2 => 'CTAnon', 1 => 'CTFun', 3 => 'CTParent', 0 => 'CTPath');
	}
