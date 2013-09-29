<?php

class hxevents_Async {
	public function __construct($after, $error) {
		if(!php_Boot::$skip_constructor) {
		$this->_after = $after;
		$this->_error = $error;
	}}
	public $_after;
	public $_error;
	public function completed() {
		$this->_after();
	}
	public function error($e) {
		if(null !== $this->_error) {
			$this->_error($e);
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
	function __toString() { return 'hxevents.Async'; }
}
