<?php

class Iterables {
	public function __construct(){}
	static function indexOf($it, $v, $f) {
		$GLOBALS['%s']->push("Iterables::indexOf");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::indexOf($it->iterator(), $v, $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function contains($it, $v, $f) {
		$GLOBALS['%s']->push("Iterables::contains");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::contains($it->iterator(), $v, $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function harray($it) {
		$GLOBALS['%s']->push("Iterables::array");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::harray($it->iterator());
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function map($it, $f) {
		$GLOBALS['%s']->push("Iterables::map");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::map($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function each($it, $f) {
		$GLOBALS['%s']->push("Iterables::each");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::each($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			$裨mp;
			return;
		}
		$GLOBALS['%s']->pop();
	}
	static function reduce($it, $f, $initialValue) {
		$GLOBALS['%s']->push("Iterables::reduce");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::reduce($it->iterator(), $f, $initialValue);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function random($it) {
		$GLOBALS['%s']->push("Iterables::random");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Arrays::random(Iterators::harray($it->iterator()));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function any($it, $f) {
		$GLOBALS['%s']->push("Iterables::any");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::any($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function all($it, $f) {
		$GLOBALS['%s']->push("Iterables::all");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::all($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function last($it) {
		$GLOBALS['%s']->push("Iterables::last");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterables_0($it);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function lastf($it, $f) {
		$GLOBALS['%s']->push("Iterables::lastf");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::lastf($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function first($it) {
		$GLOBALS['%s']->push("Iterables::first");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = $it->iterator()->next();
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function firstf($it, $f) {
		$GLOBALS['%s']->push("Iterables::firstf");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::firstf($it->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function order($it, $f) {
		$GLOBALS['%s']->push("Iterables::order");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Iterables_1($f, $it);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isIterable($v) {
		$GLOBALS['%s']->push("Iterables::isIterable");
		$製pos = $GLOBALS['%s']->length;
		$fields = ((Reflect::isObject($v) && null === Type::getClass($v)) ? Reflect::fields($v) : Type::getInstanceFields(Type::getClass($v)));
		if(!Lambda::has($fields, "iterator", null)) {
			$GLOBALS['%s']->pop();
			return false;
		}
		{
			$裨mp = Reflect::isFunction(Reflect::field($v, "iterator"));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Iterables'; }
}
function Iterables_0(&$it) {
	$製pos = $GLOBALS['%s']->length;
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
	$製pos = $GLOBALS['%s']->length;
	{
		$arr = Iterators::harray($it->iterator());
		$arr->sort(Iterables_2($arr, $f, $it));
		return $arr;
	}
}
function Iterables_2(&$arr, &$f, &$it) {
	$製pos = $GLOBALS['%s']->length;
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
