<?php

class Iterators {
	public function __construct(){}
	static function count($it) {
		$i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$_ = $»it->next();
			$i++;
		}
		return $i;
	}
	static function indexOf($it, $v, $f) {
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$f, &$it, &$v), "Iterators_0"), 'execute');
		}
		$c = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			if(call_user_func_array($f, array($i))) {
				return $c;
			} else {
				$c++;
			}
		}
		return -1;
	}
	static function contains($it, $v, $f) {
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$f, &$it, &$v), "Iterators_1"), 'execute');
		}
		$c = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			if(call_user_func_array($f, array($i))) {
				return true;
			}
		}
		return false;
	}
	static function harray($it) {
		$result = new _hx_array(array());
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			$result->push($v);
		}
		return $result;
	}
	static function join($it, $glue) {
		if($glue === null) {
			$glue = ", ";
		}
		return Iterators::harray($it)->join($glue);
	}
	static function map($it, $f) {
		$result = new _hx_array(array()); $i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			$result->push(call_user_func_array($f, array($v, $i++)));
		}
		return $result;
	}
	static function each($it, $f) {
		$i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$o = $»it->next();
			call_user_func_array($f, array($o, $i++));
		}
	}
	static function filter($it, $f) {
		$result = new _hx_array(array());
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			if(call_user_func_array($f, array($i))) {
				$result->push($i);
			}
		}
		return $result;
	}
	static function reduce($it, $f, $initialValue) {
		$accumulator = $initialValue; $i = 0;
		$»it = $it;
		while($»it->hasNext()) {
			$o = $»it->next();
			$accumulator = call_user_func_array($f, array($accumulator, $o, $i++));
		}
		return $accumulator;
	}
	static function random($it) {
		return Arrays::random(Iterators::harray($it));
	}
	static function any($it, $f) {
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			if(call_user_func_array($f, array($v))) {
				return true;
			}
		}
		return false;
	}
	static function all($it, $f) {
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			if(!call_user_func_array($f, array($v))) {
				return false;
			}
		}
		return true;
	}
	static function last($it) {
		$o = null;
		while($it->hasNext()) {
			$o = $it->next();
		}
		return $o;
	}
	static function lastf($it, $f) {
		$rev = Iterators::harray($it);
		$rev->reverse();
		return Arrays::lastf($rev, $f);
	}
	static function first($it) {
		return $it->next();
	}
	static function firstf($it, $f) {
		$»it = $it;
		while($»it->hasNext()) {
			$v = $»it->next();
			if(call_user_func_array($f, array($v))) {
				return $v;
			}
		}
		return null;
	}
	static function order($it, $f) {
		return Iterators_2($f, $it);
	}
	static function isIterator($v) {
		$fields = ((Reflect::isObject($v) && null === Type::getClass($v)) ? Reflect::fields($v) : Type::getInstanceFields(Type::getClass($v)));
		if(!Lambda::has($fields, "next", null) || !Lambda::has($fields, "hasNext", null)) {
			return false;
		}
		return Reflect::isFunction(Reflect::field($v, "next")) && Reflect::isFunction(Reflect::field($v, "hasNext"));
	}
	function __toString() { return 'Iterators'; }
}
function Iterators_0(&$f, &$it, &$v, $v2) {
	{
		return $v == $v2;
	}
}
function Iterators_1(&$f, &$it, &$v, $v2) {
	{
		return $v == $v2;
	}
}
function Iterators_2(&$f, &$it) {
	{
		$arr = Iterators::harray($it);
		$arr->sort(Iterators_3($arr, $f, $it));
		return $arr;
	}
}
function Iterators_3(&$arr, &$f, &$it) {
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
