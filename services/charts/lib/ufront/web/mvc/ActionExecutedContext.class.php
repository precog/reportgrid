<?php

class ufront_web_mvc_ActionExecutedContext {
	public function __construct($controllerContext, $actionName, $result) {
		if(!php_Boot::$skip_constructor) {
		$this->controllerContext = $controllerContext;
		$this->actionName = $actionName;
		$this->result = $result;
	}}
	public $actionName;
	public $controllerContext;
	public $result;
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
	function __toString() { return 'ufront.web.mvc.ActionExecutedContext'; }
}
