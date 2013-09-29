<?php

class ufront_web_mvc_ControllerContext {
	public function __construct($controller, $requestContext) {
		if(!php_Boot::$skip_constructor) {
		$this->controller = $controller;
		$this->requestContext = $requestContext;
		$this->httpContext = $requestContext->httpContext;
		$this->routeData = $requestContext->routeData;
		$this->request = $this->httpContext->getRequest();
		$this->response = $this->httpContext->getResponse();
		$this->session = $this->httpContext->getSession();
	}}
	public $controller;
	public $requestContext;
	public $httpContext;
	public $routeData;
	public $request;
	public $response;
	public $session;
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
	function __toString() { return 'ufront.web.mvc.ControllerContext'; }
}
