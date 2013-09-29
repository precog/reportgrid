<?php

class ufront_web_mvc_ControllerBuilder {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->packages = new HList();
		$this->attributes = new HList();
	}}
	public $packages;
	public $attributes;
	public $controllerFactory;
	public $_controllerFactory;
	public function getControllerFactory() {
		if($this->_controllerFactory === null) {
			$this->_controllerFactory = new ufront_web_mvc_DefaultControllerFactory($this, ufront_web_mvc_DependencyResolver::$current);
		}
		return $this->_controllerFactory;
	}
	public function setControllerFactory($controllerFactory) {
		if(null === $controllerFactory) {
			throw new HException(new thx_error_NullArgument("controllerFactory", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ControllerBuilder.hx", "lineNumber" => 31, "className" => "ufront.web.mvc.ControllerBuilder", "methodName" => "setControllerFactory"))));
		}
		$this->_controllerFactory = $controllerFactory;
		return $controllerFactory;
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
	static $current;
	static $__properties__ = array("set_controllerFactory" => "setControllerFactory","get_controllerFactory" => "getControllerFactory");
	function __toString() { return 'ufront.web.mvc.ControllerBuilder'; }
}
ufront_web_mvc_ControllerBuilder::$current = new ufront_web_mvc_ControllerBuilder();
