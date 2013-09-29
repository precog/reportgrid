<?php

class thx_data_ValueHandler implements thx_data_IDataHandler{
	public function __construct() {
		;
	}
	public $value;
	public $_stack;
	public $_names;
	public function start() {
		$this->_stack = new _hx_array(array());
		$this->_names = new _hx_array(array());
	}
	public function end() {
		$this->value = $this->_stack->pop();
	}
	public function startObject() {
		$this->_stack->push(_hx_anonymous(array()));
	}
	public function endObject() {
	}
	public function startField($name) {
		$this->_names->push($name);
	}
	public function endField() {
		$value = $this->_stack->pop();
		$last = thx_data_ValueHandler_0($this, $value);
		$last->{$this->_names->pop()} = $value;
	}
	public function startArray() {
		$this->_stack->push(new _hx_array(array()));
	}
	public function endArray() {
	}
	public function startItem() {
	}
	public function endItem() {
		$value = $this->_stack->pop();
		$last = thx_data_ValueHandler_1($this, $value);
		$last->push($value);
	}
	public function date($d) {
		$this->_stack->push($d);
	}
	public function string($s) {
		$this->_stack->push($s);
	}
	public function int($i) {
		$this->_stack->push($i);
	}
	public function float($f) {
		$this->_stack->push($f);
	}
	public function null() {
		$this->_stack->push(null);
	}
	public function bool($b) {
		$this->_stack->push($b);
	}
	public function comment($s) {
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
	function __toString() { return 'thx.data.ValueHandler'; }
}
function thx_data_ValueHandler_0(&$»this, &$value) {
	{
		$arr = $»this->_stack;
		return $arr[$arr->length - 1];
	}
}
function thx_data_ValueHandler_1(&$»this, &$value) {
	{
		$arr = $»this->_stack;
		return $arr[$arr->length - 1];
	}
}
