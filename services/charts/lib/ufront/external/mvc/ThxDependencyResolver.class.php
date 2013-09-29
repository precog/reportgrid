<?php

class ufront_external_mvc_ThxDependencyResolver implements ufront_web_mvc_IDependencyResolver{
	public function __construct($locator) {
		if(!php_Boot::$skip_constructor) {
		if(null === $locator) {
			throw new HException(new thx_error_NullArgument("locator", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ThxDependencyResolver.hx", "lineNumber" => 19, "className" => "ufront.external.mvc.ThxDependencyResolver", "methodName" => "new"))));
		}
		$this->locator = $locator;
		$this->defaultResolver = new ufront_web_mvc_DefaultDependencyResolver($this);
	}}
	public $locator;
	public $defaultResolver;
	public function getService($serviceType) {
		$o = $this->locator->get($serviceType);
		if(null === $o) {
			return $this->defaultResolver->getService($serviceType);
		} else {
			return $o;
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
	function __toString() { return 'ufront.external.mvc.ThxDependencyResolver'; }
}
