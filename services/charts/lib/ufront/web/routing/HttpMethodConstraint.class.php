<?php

class ufront_web_routing_HttpMethodConstraint implements ufront_web_routing_IRouteConstraint{
	public function __construct($method, $methods) {
		if(!php_Boot::$skip_constructor) {
		if(null === $methods) {
			$methods = new _hx_array(array());
		}
		if(null !== $method) {
			$methods->push($method);
		}
		if(0 === $methods->length) {
			throw new HException("invalid argument, you have to pass at least one method");
		}
		$this->methods = Iterators::map($methods->iterator(), array(new _hx_lambda(array(&$method, &$methods), "ufront_web_routing_HttpMethodConstraint_0"), 'execute'));
	}}
	public $methods;
	public function match($context, $route, $params, $direction) {
		$»t = ($direction);
		switch($»t->index) {
		case 0:
		{
			return Arrays::exists($this->methods, $context->getRequest()->getHttpMethod(), null);
		}break;
		case 1:
		{
			return true;
		}break;
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
	function __toString() { return 'ufront.web.routing.HttpMethodConstraint'; }
}
function ufront_web_routing_HttpMethodConstraint_0(&$method, &$methods, $d, $_) {
	{
		return strtoupper($d);
	}
}
