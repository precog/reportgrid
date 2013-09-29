<?php

class thx_collection_Set {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_v = new _hx_array(array());
		$this->length = 0;
	}}
	public $length;
	public $_v;
	public function add($v) {
		$this->_v->remove($v);
		$this->_v->push($v);
		$this->length = $this->_v->length;
	}
	public function remove($v) {
		$t = $this->_v->remove($v);
		$this->length = $this->_v->length;
		return $t;
	}
	public function exists($v) {
		{
			$_g = 0; $_g1 = $this->_v;
			while($_g < $_g1->length) {
				$t = $_g1[$_g];
				++$_g;
				if($t == $v) {
					return true;
				}
				unset($t);
			}
		}
		return false;
	}
	public function iterator() {
		return $this->_v->iterator();
	}
	public function harray() {
		return $this->_v->copy();
	}
	public function toString() {
		return "{" . $this->_v->join(", ") . "}";
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
		return $set;
	}
	function __toString() { return $this->toString(); }
}
