<?php

class mongo_Mongo {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->m = new Mongo();
	}}
	public $m;
	public function selectDB($name) {
		return new mongo_MongoDB($this->m->selectDB($name));
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
	function __toString() { return 'mongo.Mongo'; }
}
