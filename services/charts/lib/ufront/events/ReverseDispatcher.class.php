<?php

class ufront_events_ReverseDispatcher extends hxevents_Dispatcher {
	public function __construct() {
		if(!isset($this->add)) $this->add = array(new _hx_lambda(array(&$this), "ufront_events_ReverseDispatcher_0"), 'execute');
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function add($h) { return call_user_func_array($this->add, array($h)); }
	public $add = null;
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
	function __toString() { return 'ufront.events.ReverseDispatcher'; }
}
function ufront_events_ReverseDispatcher_0(&$»this, $h) {
	{
		$»this->handlers->unshift($h);
		return $h;
	}
}
