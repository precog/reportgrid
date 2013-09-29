<?php

class Types {
	public function __construct(){}
	static function className($o) {
		$GLOBALS['%s']->push("Types::className");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_explode(".", Type::getClassName(Type::getClass($o)))->pop();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fullName($o) {
		$GLOBALS['%s']->push("Types::fullName");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Type::getClassName(Type::getClass($o));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function typeName($o) {
		$GLOBALS['%s']->push("Types::typeName");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Types_0($o);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function hasSuperClass($type, $sup) {
		$GLOBALS['%s']->push("Types::hasSuperClass");
		$»spos = $GLOBALS['%s']->length;
		while(null !== $type) {
			if($type === $sup) {
				$GLOBALS['%s']->pop();
				return true;
			}
			$type = Type::getSuperClass($type);
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function isAnonymous($v) {
		$GLOBALS['%s']->push("Types::isAnonymous");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Reflect::isObject($v) && null === Type::getClass($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function has($value, $type) {
		$GLOBALS['%s']->push("Types::as");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ((Std::is($value, $type)) ? $value : null);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ifIs($value, $type, $handler) {
		$GLOBALS['%s']->push("Types::ifIs");
		$»spos = $GLOBALS['%s']->length;
		if(Std::is($value, $type)) {
			call_user_func_array($handler, array($value));
		}
		{
			$GLOBALS['%s']->pop();
			return $value;
		}
		$GLOBALS['%s']->pop();
	}
	static function of($type, $value) {
		$GLOBALS['%s']->push("Types::of");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ((Std::is($value, $type)) ? $value : null);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function sameType($a, $b) {
		$GLOBALS['%s']->push("Types::sameType");
		$»spos = $GLOBALS['%s']->length;
		if(null === $a && $b === null) {
			$GLOBALS['%s']->pop();
			return true;
		}
		if(null === $a || $b === null) {
			$GLOBALS['%s']->pop();
			return false;
		}
		$tb = Type::typeof($b);
		$»t = ($tb);
		switch($»t->index) {
		case 6:
		$c = $»t->params[0];
		{
			$»tmp = Std::is($a, $c);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 7:
		$e = $»t->params[0];
		{
			$»tmp = Std::is($a, $e);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		default:{
			$»tmp = Type::typeof($a) === $tb;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function isPrimitive($v) {
		$GLOBALS['%s']->push("Types::isPrimitive");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Types_1($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Types'; }
}
function Types_0(&$o) {
	$»spos = $GLOBALS['%s']->length;
	$»t = (Type::typeof($o));
	switch($»t->index) {
	case 0:
	{
		return "null";
	}break;
	case 1:
	{
		return "Int";
	}break;
	case 2:
	{
		return "Float";
	}break;
	case 3:
	{
		return "Bool";
	}break;
	case 5:
	{
		return "function";
	}break;
	case 6:
	$c = $»t->params[0];
	{
		return Type::getClassName($c);
	}break;
	case 7:
	$e = $»t->params[0];
	{
		return Type::getEnumName($e);
	}break;
	case 4:
	{
		return "Object";
	}break;
	case 8:
	{
		return "Unknown";
	}break;
	}
}
function Types_1(&$v) {
	$»spos = $GLOBALS['%s']->length;
	$»t = (Type::typeof($v));
	switch($»t->index) {
	case 0:
	case 1:
	case 2:
	case 3:
	{
		return true;
	}break;
	case 5:
	case 7:
	case 4:
	case 8:
	{
		return false;
	}break;
	case 6:
	$c = $»t->params[0];
	{
		return Type::getClassName($c) === "String";
	}break;
	}
}
