<?php

class ufront_web_mvc_ExceptionContext extends ufront_web_mvc_ControllerContext {
	public function __construct($controllerContext, $exception) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct($controllerContext->controller,$controllerContext->requestContext);
		$this->hexception = $exception;
	}}
	public $hexception;
	public $exceptionHandled;
	public $result;
	public $_result;
	public function getResult() {
		return ufront_web_mvc_ExceptionContext_0($this);
	}
	public function setResult($result) {
		$this->_result = $result;
		return $result;
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
	static $__properties__ = array("set_result" => "setResult","get_result" => "getResult");
	function __toString() { return 'ufront.web.mvc.ExceptionContext'; }
}
function ufront_web_mvc_ExceptionContext_0(&$»this) {
	if($»this->_result !== null) {
		return $»this->_result;
	} else {
		return new ufront_web_mvc_EmptyResult();
	}
}
