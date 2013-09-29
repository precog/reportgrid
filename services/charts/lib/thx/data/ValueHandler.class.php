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
	public function objectStart() {
		$this->_stack->push(_hx_anonymous(array()));
	}
	public function objectEnd() {
	}
	public function objectFieldStart($name) {
		$this->_names->push($name);
	}
	public function objectFieldEnd() {
		$value = $this->_stack->pop();
		$last = thx_data_ValueHandler_0($this, $value);
		$last->{$this->_names->pop()} = $value;
	}
	public function arrayStart() {
		$this->_stack->push(new _hx_array(array()));
	}
	public function arrayEnd() {
	}
	public function arrayItemStart() {
	}
	public function arrayItemEnd() {
		$value = $this->_stack->pop();
		$last = thx_data_ValueHandler_1($this, $value);
		$last->push($value);
	}
	public function valueDate($d) {
		$this->_stack->push($d);
	}
	public function valueString($s) {
		$this->_stack->push($s);
	}
	public function valueInt($i) {
		$this->_stack->push($i);
	}
	public function valueFloat($f) {
		$this->_stack->push($f);
	}
	public function valueNull() {
		$this->_stack->push(null);
	}
	public function valueBool($b) {
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
