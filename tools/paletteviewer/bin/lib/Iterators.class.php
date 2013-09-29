<?php

class Iterators {
	public function __construct(){}
	static function indexOf($it, $v, $f) {
		$GLOBALS['%s']->push("Iterators::indexOf");
		$»spos = $GLOBALS['%s']->length;
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$f, &$it, &$v), "Iterators_0"), 'execute');
		}
		$c = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			if(call_user_func_array($f, array($i))) {
				$GLOBALS['%s']->pop();
				return $c;
			} else {
				$c++;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return -1;
		}
		$GLOBALS['%s']->pop();
	}
	static function contains($it, $v, $f) {
		$GLOBALS['%s']->push("Iterators::contains");
		$»spos = $GLOBALS['%s']->length;
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$f, &$it, &$v), "Iterators_1"), 'execute');
		}
		$c = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			if(call_user_func_array($f, array($i))) {
				$GLOBALS['%s']->pop();
				return true;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function harray($it) {
		$GLOBALS['%s']->push("Iterators::array");
		$»spos = $GLOBALS['%s']->length;
		$result = new _hx_array(array());
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			$result->push($v);
		}
		{
			$GLOBALS['%s']->pop();
			return $result;
		}
		$GLOBALS['%s']->pop();
	}
	static function map($it, $f) {
		$GLOBALS['%s']->push("Iterators::map");
		$»spos = $GLOBALS['%s']->length;
		$result = new _hx_array(array()); $i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			$result->push(call_user_func_array($f, array($v, $i++)));
		}
		{
			$GLOBALS['%s']->pop();
			return $result;
		}
		$GLOBALS['%s']->pop();
	}
	static function each($it, $f) {
		$GLOBALS['%s']->push("Iterators::each");
		$»spos = $GLOBALS['%s']->length;
		$i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$o = $»it->next();
			call_user_func_array($f, array($o, $i++));
		}
		$GLOBALS['%s']->pop();
	}
	static function reduce($it, $f, $initialValue) {
		$GLOBALS['%s']->push("Iterators::reduce");
		$»spos = $GLOBALS['%s']->length;
		$accumulator = $initialValue; $i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$o = $»it->next();
			$accumulator = call_user_func_array($f, array($accumulator, $o, $i++));
		}
		{
			$GLOBALS['%s']->pop();
			return $accumulator;
		}
		$GLOBALS['%s']->pop();
	}
	static function random($it) {
		$GLOBALS['%s']->push("Iterators::random");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Arrays::random(Iterators::harray($it));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function any($it, $f) {
		$GLOBALS['%s']->push("Iterators::any");
		$»spos = $GLOBALS['%s']->length;
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			if(call_user_func_array($f, array($v))) {
				$GLOBALS['%s']->pop();
				return true;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function all($it, $f) {
		$GLOBALS['%s']->push("Iterators::all");
		$»spos = $GLOBALS['%s']->length;
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			if(!call_user_func_array($f, array($v))) {
				$GLOBALS['%s']->pop();
				return false;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	static function last($it) {
		$GLOBALS['%s']->push("Iterators::last");
		$»spos = $GLOBALS['%s']->length;
		$o = null;
		while($it->hasNext()) {
			$o = $it->next();
		}
		{
			$GLOBALS['%s']->pop();
			return $o;
		}
		$GLOBALS['%s']->pop();
	}
	static function lastf($it, $f) {
		$GLOBALS['%s']->push("Iterators::lastf");
		$»spos = $GLOBALS['%s']->length;
		$rev = Iterators::harray($it);
		$rev->reverse();
		{
			$»tmp = Arrays::lastf($rev, $f);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function first($it) {
		$GLOBALS['%s']->push("Iterators::first");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $it->next();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function firstf($it, $f) {
		$GLOBALS['%s']->push("Iterators::firstf");
		$»spos = $GLOBALS['%s']->length;
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			if(call_user_func_array($f, array($v))) {
				$GLOBALS['%s']->pop();
				return $v;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static function order($it, $f) {
		$GLOBALS['%s']->push("Iterators::order");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Iterators_2($f, $it);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isIterator($v) {
		$GLOBALS['%s']->push("Iterators::isIterator");
		$»spos = $GLOBALS['%s']->length;
		$fields = ((Reflect::isObject($v) && null === Type::getClass($v)) ? Reflect::fields($v) : Type::getInstanceFields(Type::getClass($v)));
		if(!Lambda::has($fields, "next", null) || !Lambda::has($fields, "hasNext", null)) {
			$GLOBALS['%s']->pop();
			return false;
		}
		{
			$»tmp = Reflect::isFunction(Reflect::field($v, "next")) && Reflect::isFunction(Reflect::field($v, "hasNext"));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Iterators'; }
}
function Iterators_0(&$f, &$it, &$v, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Iterators::indexOf@11");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v === $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Iterators_1(&$f, &$it, &$v, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Iterators::contains@24");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v === $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Iterators_2(&$f, &$it) {
	$»spos = $GLOBALS['%s']->length;
	{
		$arr = Iterators::harray($it);
		$arr->sort(Iterators_3($arr, $f, $it));
		return $arr;
	}
}
function Iterators_3(&$arr, &$f, &$it) {
	$»spos = $GLOBALS['%s']->length;
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
