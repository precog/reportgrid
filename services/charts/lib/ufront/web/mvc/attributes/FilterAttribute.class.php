<?php

class ufront_web_mvc_attributes_FilterAttribute {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->order = -1;
	}}
	public $order;
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
	function __toString() { return 'ufront.web.mvc.attributes.FilterAttribute'; }
}
