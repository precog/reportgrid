<?php

class Iterables {
	public function __construct(){}
	static function count($it) {
		return Iterators::count($it->iterator());
	}
	static function indexOf($it, $v, $f) {
		return Iterators::indexOf($it->iterator(), $v, $f);
	}
	static function contains($it, $v, $f) {
		return Iterators::contains($it->iterator(), $v, $f);
	}
	static function harray($it) {
		return Iterators::harray($it->iterator());
	}
	static function join($it, $glue) {
		if($glue === null) {
			$glue = ", ";
		}
		return Iterators::harray($it->iterator())->join($glue);
	}
	static function map($it, $f) {
		return Iterators::map($it->iterator(), $f);
	}
	static function each($it, $f) {
		Iterators::each($it->iterator(), $f);
		return;
	}
	static function filter($it, $f) {
		return Iterators::filter($it->iterator(), $f);
	}
	static function reduce($it, $f, $initialValue) {
		return Iterators::reduce($it->iterator(), $f, $initialValue);
	}
	static function random($it) {
		return Arrays::random(Iterators::harray($it->iterator()));
	}
	static function any($it, $f) {
		return Iterators::any($it->iterator(), $f);
	}
	static function all($it, $f) {
		return Iterators::all($it->iterator(), $f);
	}
	static function last($it) {
		return Iterables_0($it);
	}
	static function lastf($it, $f) {
		return Iterators::lastf($it->iterator(), $f);
	}
	static function first($it) {
		return $it->iterator()->next();
	}
	static function firstf($it, $f) {
		return Iterators::firstf($it->iterator(), $f);
	}
	static function order($it, $f) {
		return Iterables_1($f, $it);
	}
	static function isIterable($v) {
		$fields = ((Reflect::isObject($v) && null === Type::getClass($v)) ? Reflect::fields($v) : Type::getInstanceFields(Type::getClass($v)));
		if(!Lambda::has($fields, "iterator", null)) {
			return false;
		}
		return Reflect::isFunction(Reflect::field($v, "iterator"));
	}
	function __toString() { return 'Iterables'; }
}
function Iterables_0(&$it) {
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
	{
		$arr = Iterators::harray($it->iterator());
		$arr->sort(Iterables_2($arr, $f, $it));
		return $arr;
	}
}
function Iterables_2(&$arr, &$f, &$it) {
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
