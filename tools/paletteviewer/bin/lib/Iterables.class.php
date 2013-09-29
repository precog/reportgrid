<?php

class Iterables {
	public function __construct(){}
	static function indexOf($it, $v, $f) {
		$GLOBALS['%s']->push("Iterables::indexOf");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::indexOf($it->iterator(), $v, $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function contains($it, $v, $f) {
		$GLOBALS['%s']->push("Iterables::contains");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::contains($it->iterator(), $v, $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function harray($it) {
		$GLOBALS['%s']->push("Iterables::array");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::harray($it->iterator());
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function map($it, $f) {
		$GLOBALS['%s']->push("Iterables::map");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::map($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function each($it, $f) {
		$GLOBALS['%s']->push("Iterables::each");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::each($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			$�tmp;
			return;
		}
		$GLOBALS['%s']->pop();
	}
	static function reduce($it, $f, $initialValue) {
		$GLOBALS['%s']->push("Iterables::reduce");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::reduce($it->iterator(), $f, $initialValue);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function random($it) {
		$GLOBALS['%s']->push("Iterables::random");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Arrays::random(Iterators::harray($it->iterator()));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function any($it, $f) {
		$GLOBALS['%s']->push("Iterables::any");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::any($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function all($it, $f) {
		$GLOBALS['%s']->push("Iterables::all");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::all($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function last($it) {
		$GLOBALS['%s']->push("Iterables::last");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterables_0($it);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function lastf($it, $f) {
		$GLOBALS['%s']->push("Iterables::lastf");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::lastf($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function first($it) {
		$GLOBALS['%s']->push("Iterables::first");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = $it->iterator()->next();
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function firstf($it, $f) {
		$GLOBALS['%s']->push("Iterables::firstf");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::firstf($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function order($it, $f) {
		$GLOBALS['%s']->push("Iterables::order");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterables_1($f, $it);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isIterable($v) {
		$GLOBALS['%s']->push("Iterables::isIterable");
		$�spos = $GLOBALS['%s']->length;
		$fields = ((Reflect::isObject($v) && null === Type::getClass($v)) ? Reflect::fields($v) : Type::getInstanceFields(Type::getClass($v)));
		if(!Lambda::has($fields, "iterator", null)) {
			$GLOBALS['%s']->pop();
			return false;
		}
		{
			$�tmp = Reflect::isFunction(Reflect::field($v, "iterator"));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Iterables'; }
}
function Iterables_0(&$it) {
	$�spos = $GLOBALS['%s']->length;
	{
		$it1 = $it->iterator();
		$o = null;
		while($it1->hasNext()) {
			$o = $it1->next();
		}
		return $o;
	}
}
function Iterables_1(&$f, &$it) {
	$�spos = $GLOBALS['%s']->length;
	{
		$arr = Iterators::harray($it->iterator());
		$arr->sort(Iterables_2($arr, $f, $it));
		return $arr;
	}
}
function Iterables_2(&$arr, &$f, &$it) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
