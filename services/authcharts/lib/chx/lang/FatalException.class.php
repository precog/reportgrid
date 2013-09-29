<?php

class chx_lang_FatalException {
	public function __construct($msg, $cause) {
		if(!php_Boot::$skip_constructor) {
		$this->message = $msg;
		$this->cause = $cause;
	}}
	public $message;
	public $cause;
	public function toString() {
		return Type::getClassName(Type::getClass($this)) . "(" . (chx_lang_FatalException_0($this));
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
function chx_lang_FatalException_0(&$»this) {
	if($»this->message === null) {
		return "";
	} else {
		return $»this->message . ")";
	}
}
