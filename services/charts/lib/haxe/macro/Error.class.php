<?php

class haxe_macro_Error {
	public function __construct($m, $p) {
		if(!php_Boot::$skip_constructor) {
		$this->message = $m;
		$this->pos = $p;
	}}
	public $message;
	public $pos;
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
	function __toString() { return 'haxe.macro.Error'; }
}
