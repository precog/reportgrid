<?php

class thx_data_ValueHandler implements thx_data_IDataHandler{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::new");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}}
	public $value;
	public $_stack;
	public $_names;
	public function start() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::start");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack = new _hx_array(array());
		$this->_names = new _hx_array(array());
		$GLOBALS['%s']->pop();
	}
	public function end() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::end");
		$»spos = $GLOBALS['%s']->length;
		$this->value = $this->_stack->pop();
		$GLOBALS['%s']->pop();
	}
	public function startObject() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::startObject");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push(_hx_anonymous(array()));
		$GLOBALS['%s']->pop();
	}
	public function endObject() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::endObject");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function startField($name) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::startField");
		$»spos = $GLOBALS['%s']->length;
		$this->_names->push($name);
		$GLOBALS['%s']->pop();
	}
	public function endField() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::endField");
		$»spos = $GLOBALS['%s']->length;
		$value = $this->_stack->pop();
		$last = thx_data_ValueHandler_0($this, $value);
		$last->{$this->_names->pop()} = $value;
		$GLOBALS['%s']->pop();
	}
	public function startArray() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::startArray");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push(new _hx_array(array()));
		$GLOBALS['%s']->pop();
	}
	public function endArray() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::endArray");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function startItem() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::startItem");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function endItem() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::endItem");
		$»spos = $GLOBALS['%s']->length;
		$value = $this->_stack->pop();
		$last = thx_data_ValueHandler_1($this, $value);
		$last->push($value);
		$GLOBALS['%s']->pop();
	}
	public function date($d) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::date");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push($d);
		$GLOBALS['%s']->pop();
	}
	public function string($s) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::string");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push($s);
		$GLOBALS['%s']->pop();
	}
	public function int($i) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::int");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push($i);
		$GLOBALS['%s']->pop();
	}
	public function float($f) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::float");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push($f);
		$GLOBALS['%s']->pop();
	}
	public function null() {
		$GLOBALS['%s']->push("thx.data.ValueHandler::null");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push(null);
		$GLOBALS['%s']->pop();
	}
	public function bool($b) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::bool");
		$»spos = $GLOBALS['%s']->length;
		$this->_stack->push($b);
		$GLOBALS['%s']->pop();
	}
	public function comment($s) {
		$GLOBALS['%s']->push("thx.data.ValueHandler::comment");
		$»spos = $GLOBALS['%s']->length;
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
	function __toString() { return 'thx.data.ValueHandler'; }
}
function thx_data_ValueHandler_0(&$»this, &$value) {
	$»spos = $GLOBALS['%s']->length;
	{
		$arr = $»this->_stack;
		return $arr[$arr->length - 1];
	}
}
function thx_data_ValueHandler_1(&$»this, &$value) {
	$»spos = $GLOBALS['%s']->length;
	{
		$arr = $»this->_stack;
		return $arr[$arr->length - 1];
	}
}
