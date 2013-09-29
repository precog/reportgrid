<?php

class thx_util_TypeServiceLocator {
	public function __construct() {
		if(!isset($this->unbinded)) $this->unbinded = array(new _hx_lambda(array(&$this), "thx_util_TypeServiceLocator_0"), 'execute');
		if(!php_Boot::$skip_constructor) {
		$this->_binders = new Hash();
	}}
	public $_binders;
	public function instance($cls, $o) {
		return $this->bind($cls, array(new _hx_lambda(array(&$cls, &$o), "thx_util_TypeServiceLocator_1"), 'execute'));
	}
	public function bind($cls, $f) {
		$this->_binders->set(Type::getClassName($cls), $f);
		return $this;
	}
	public function memoize($cls, $f) {
		$r = null;
		return $this->bind($cls, array(new _hx_lambda(array(&$cls, &$f, &$r), "thx_util_TypeServiceLocator_2"), 'execute'));
	}
	public function unbinded($cls) { return call_user_func_array($this->unbinded, array($cls)); }
	public $unbinded = null;
	public function get($cls) {
		$f = $this->_binders->get(Type::getClassName($cls));
		if(null === $f) {
			return $this->unbinded($cls);
		} else {
			return call_user_func($f);
		}
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return 'thx.util.TypeServiceLocator'; }
}
function thx_util_TypeServiceLocator_0(&$»this, $cls) {
	{
		return null;
	}
}
function thx_util_TypeServiceLocator_1(&$cls, &$o) {
	{
		return $o;
	}
}
function thx_util_TypeServiceLocator_2(&$cls, &$f, &$r) {
	{
		if(null === $r) {
			$r = call_user_func($f);
		}
		return $r;
	}
}
