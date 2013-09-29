<?php

class ufront_web_VirtualUrl extends ufront_web_PartialUrl {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->isPhysical = false;
	}}
	public $isPhysical;
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
	static function parse($url) {
		$u = new ufront_web_VirtualUrl();
		ufront_web_VirtualUrl::feed($u, $url);
		return $u;
	}
	static function feed($u, $url) {
		ufront_web_PartialUrl::feed($u, $url);
		if($u->segments[0] === "~") {
			$u->segments->shift();
			if($u->segments->length === 1 && $u->segments[0] === "") {
				$u->segments->pop();
			}
			$u->isPhysical = true;
		} else {
			$u->isPhysical = false;
		}
	}
	function __toString() { return 'ufront.web.VirtualUrl'; }
}
