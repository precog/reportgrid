<?php

class ufront_web_mvc_DefaultControllerFactory implements ufront_web_mvc_IControllerFactory{
	public function __construct($controllerBuilder, $dependencyResolver) {
		if(!php_Boot::$skip_constructor) {
		if(null === $controllerBuilder) {
			throw new HException(new thx_error_NullArgument("controllerBuilder", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "DefaultControllerFactory.hx", "lineNumber" => 14, "className" => "ufront.web.mvc.DefaultControllerFactory", "methodName" => "new"))));
		}
		$this->_controllerBuilder = $controllerBuilder;
		$this->_dependencyResolver = $dependencyResolver;
	}}
	public $_controllerBuilder;
	public $_dependencyResolver;
	public function createController($requestContext, $controllerName) {
		$cls = ufront_web_mvc_DefaultControllerFactory_0($this, $controllerName, $requestContext);
		$names = new _hx_array(array($cls, $cls . "Controller"));
		if(null == $this->_controllerBuilder->packages) throw new HException('null iterable');
		$»it = $this->_controllerBuilder->packages->iterator();
		while($»it->hasNext()) {
			$pack = $»it->next();
			$type = null;
			{
				$_g = 0;
				while($_g < $names->length) {
					$name = $names[$_g];
					++$_g;
					$fullpath = $pack . "." . $name;
					$type = Type::resolveClass($fullpath);
					if(null !== $type) {
						break;
					}
					unset($name,$fullpath);
				}
				unset($_g);
			}
			if($type !== null) {
				$controller = $this->_dependencyResolver->getService($type);
				if(Std::is($controller, _hx_qtype("ufront.web.mvc.IController"))) {
					return $controller;
				}
				unset($controller);
			}
			unset($type);
		}
		ufront_web_mvc_DefaultControllerFactory_1($this, $cls, $controllerName, $names, $requestContext);
	}
	public function releaseController($controller) {
		$f = Reflect::field($controller, "dispose");
		if(null !== $f) {
			Reflect::callMethod($controller, $f, new _hx_array(array()));
		}
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
	function __toString() { return 'ufront.web.mvc.DefaultControllerFactory'; }
}
function ufront_web_mvc_DefaultControllerFactory_0(&$»this, &$controllerName, &$requestContext) {
	if($controllerName === null) {
		return null;
	} else {
		return strtoupper(_hx_char_at($controllerName, 0)) . _hx_substr($controllerName, 1, null);
	}
}
function ufront_web_mvc_DefaultControllerFactory_1(&$»this, &$cls, &$controllerName, &$names, &$requestContext) {
	throw new HException(new thx_error_Error("unable to find a class for the controller '{0}'", null, $controllerName, _hx_anonymous(array("fileName" => "DefaultControllerFactory.hx", "lineNumber" => 41, "className" => "ufront.web.mvc.DefaultControllerFactory", "methodName" => "createController"))));
}
