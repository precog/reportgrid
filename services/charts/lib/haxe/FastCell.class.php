<?php

class haxe_FastCell {
	public function __construct($elt, $next) {
		if(!php_Boot::$skip_constructor) {
		$this->elt = $elt;
		$this->next = $next;
	}}
	public $elt;
	public $next;
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
	function __toString() { return 'haxe.FastCell'; }
}
