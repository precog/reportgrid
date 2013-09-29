<?php

class Reflect {
	public function __construct(){}
	static function hasField($o, $field) {
		$GLOBALS['%s']->push("Reflect::hasField");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_has_field($o, $field);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function field($o, $field) {
		$GLOBALS['%s']->push("Reflect::field");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_field($o, $field);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function setField($o, $field, $value) {
		$GLOBALS['%s']->push("Reflect::setField");
		$»spos = $GLOBALS['%s']->length;
		$o->{$field} = $value;
		$GLOBALS['%s']->pop();
	}
	static function callMethod($o, $func, $args) {
		$GLOBALS['%s']->push("Reflect::callMethod");
		$»spos = $GLOBALS['%s']->length;
		if(is_string($o) && !is_array($func)) {
			$»tmp = call_user_func_array(Reflect::field($o, $func), $args->»a);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$»tmp = call_user_func_array(((is_callable($func)) ? $func : array($o, $func)), ((null === $args) ? array() : $args->»a));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fields($o) {
		$GLOBALS['%s']->push("Reflect::fields");
		$»spos = $GLOBALS['%s']->length;
		if($o === null) {
			$»tmp = new _hx_array(array());
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$»tmp = (($o instanceof _hx_array) ? new _hx_array(array('concat','copy','insert','iterator','length','join','pop','push','remove','reverse','shift','slice','sort','splice','toString','unshift')) : ((is_string($o)) ? new _hx_array(array('charAt','charCodeAt','indexOf','lastIndexOf','length','split','substr','toLowerCase','toString','toUpperCase')) : new _hx_array(_hx_get_object_vars($o))));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isFunction($f) {
		$GLOBALS['%s']->push("Reflect::isFunction");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (is_array($f) && is_callable($f)) || _hx_is_lambda($f) || is_array($f) && _hx_has_field($f[0], $f[1]) && $f[1] !== "length";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Reflect::compare");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (($a === $b) ? 0 : (($a > $b) ? 1 : -1));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compareMethods($f1, $f2) {
		$GLOBALS['%s']->push("Reflect::compareMethods");
		$»spos = $GLOBALS['%s']->length;
		if(is_array($f1) && is_array($f1)) {
			$»tmp = $f1[0] === $f2[0] && $f1[1] == $f2[1];
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		if(is_string($f1) && is_string($f2)) {
			$»tmp = _hx_equal($f1, $f2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function isObject($v) {
		$GLOBALS['%s']->push("Reflect::isObject");
		$»spos = $GLOBALS['%s']->length;
		if($v === null) {
			$GLOBALS['%s']->pop();
			return false;
		}
		if(is_object($v)) {
			$»tmp = $v instanceof _hx_anonymous || Type::getClass($v) !== null;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$»tmp = is_string($v) && !_hx_is_lambda($v);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function deleteField($o, $f) {
		$GLOBALS['%s']->push("Reflect::deleteField");
		$»spos = $GLOBALS['%s']->length;
		if(!_hx_has_field($o, $f)) {
			$GLOBALS['%s']->pop();
			return false;
		}
		if(isset($o->»dynamics[$f])) unset($o->»dynamics[$f]); else unset($o->$f);
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	static function copy($o) {
		$GLOBALS['%s']->push("Reflect::copy");
		$»spos = $GLOBALS['%s']->length;
		if(is_string($o)) {
			$GLOBALS['%s']->pop();
			return $o;
		}
		$o2 = _hx_anonymous(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$o2->{$f} = Reflect::field($o, $f);
				unset($f);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $o2;
		}
		$GLOBALS['%s']->pop();
	}
	static function makeVarArgs($f) {
		$GLOBALS['%s']->push("Reflect::makeVarArgs");
		$»spos = $GLOBALS['%s']->length;
		return array(new _hx_lambda(array(&$f), '_hx_make_var_args'), 'execute');
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Reflect'; }
}
