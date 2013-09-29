<?php

class chx_vm_Lock {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->lock = 1;
	}}
	public $lock;
	public function wait($waitMs) {
		$checktime = true;
		$limit = 0.0;
		if($waitMs === null) {
			$checktime = false;
		}
		if($checktime) {
			$limit = Date::now()->getTime() + $waitMs;
		}
		while($this->lock > 0) {
			if($checktime && Date::now()->getTime() >= $limit) {
				return false;
			}
		}
		$this->lock++;
		return true;
	}
	public function release() {
		$this->lock--;
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
	function __toString() { return 'chx.vm.Lock'; }
}
