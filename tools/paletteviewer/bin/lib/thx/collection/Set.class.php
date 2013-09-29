<?php

class thx_collection_Set {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.collection.Set::new");
		$»spos = $GLOBALS['%s']->length;
		$this->_v = new _hx_array(array());
		$this->length = 0;
		$GLOBALS['%s']->pop();
	}}
	public $length;
	public $_v;
	public function add($v) {
		$GLOBALS['%s']->push("thx.collection.Set::add");
		$»spos = $GLOBALS['%s']->length;
		$this->_v->remove($v);
		$this->_v->push($v);
		$this->length = $this->_v->length;
		$GLOBALS['%s']->pop();
	}
	public function remove($v) {
		$GLOBALS['%s']->push("thx.collection.Set::remove");
		$»spos = $GLOBALS['%s']->length;
		$t = $this->_v->remove($v);
		$this->length = $this->_v->length;
		{
			$GLOBALS['%s']->pop();
			return $t;
		}
		$GLOBALS['%s']->pop();
	}
	public function exists($v) {
		$GLOBALS['%s']->push("thx.collection.Set::exists");
		$»spos = $GLOBALS['%s']->length;
		{
			$_g = 0; $_g1 = $this->_v;
			while($_g < $_g1->length) {
				$t = $_g1[$_g];
				++$_g;
				if($t === $v) {
					$GLOBALS['%s']->pop();
					return true;
				}
				unset($t);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	public function iterator() {
		$GLOBALS['%s']->push("thx.collection.Set::iterator");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->_v->iterator();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function harray() {
		$GLOBALS['%s']->push("thx.collection.Set::array");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->_v->copy();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("thx.collection.Set::toString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = "{" . $this->_v->join(", ") . "}";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
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
	static function ofArray($arr) {
		$GLOBALS['%s']->push("thx.collection.Set::ofArray");
		$»spos = $GLOBALS['%s']->length;
		$set = new thx_collection_Set();
		{
			$_g = 0;
			while($_g < $arr->length) {
				$item = $arr[$_g];
				++$_g;
				$set->add($item);
				unset($item);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $set;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return $this->toString(); }
}
