<?php

class ufront_web_mvc_ViewContext {
	public function __construct($controllerContext, $view, $viewEngine, $viewData, $viewHelpers) {
		if(!php_Boot::$skip_constructor) {
		$this->controllerContext = $controllerContext;
		$this->controller = $controllerContext->controller;
		$this->requestContext = $controllerContext->requestContext;
		$this->httpContext = $this->requestContext->httpContext;
		$this->routeData = $this->requestContext->routeData;
		$this->view = $view;
		$this->viewData = $viewData;
		$this->viewEngine = $viewEngine;
		$this->request = $this->httpContext->getRequest();
		$this->response = $this->httpContext->getResponse();
		$this->session = $this->httpContext->getSession();
		$this->viewHelpers = $viewHelpers;
	}}
	public $controller;
	public $controllerContext;
	public $httpContext;
	public $requestContext;
	public $routeData;
	public $view;
	public $viewData;
	public $request;
	public $response;
	public $session;
	public $viewEngine;
	public $viewHelpers;
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
	function __toString() { return 'ufront.web.mvc.ViewContext'; }
}
