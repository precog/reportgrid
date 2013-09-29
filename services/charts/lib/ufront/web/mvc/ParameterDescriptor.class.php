<?php

class ufront_web_mvc_ParameterDescriptor {
	public function __construct($name, $type, $ctype) {
		if(!php_Boot::$skip_constructor) {
		$this->name = $name;
		$this->type = $type;
		$this->ctype = $ctype;
	}}
	public $name;
	public $type;
	public $ctype;
	public $defaultValue;
	public function toString() {
		return "ParameterDescriptor { name : " . $this->name . ", type : " . $this->type . ", ctype : " . $this->ctype . "}";
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
	function __toString() { return $this->toString(); }
}
