<?php

class ufront_web_routing_RequestContext {
	public function __construct($httpContext, $routeData, $routes) {
		if(!php_Boot::$skip_constructor) {
		$this->httpContext = $httpContext;
		$this->routeData = $routeData;
		$this->request = $httpContext->getRequest();
		$this->response = $httpContext->getResponse();
		$this->session = $httpContext->getSession();
		$this->routes = $routes;
	}}
	public $httpContext;
	public $routeData;
	public $request;
	public $response;
	public $session;
	public $routes;
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
	function __toString() { return 'ufront.web.routing.RequestContext'; }
}
