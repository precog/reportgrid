<?php

class ufront_web_HttpContextImpl extends ufront_web_HttpContext {
	public function __construct($request, $response, $session) { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->request = $request;
		$this->response = $response;
		$this->session = $session;
	}}
	public function setRequest($request) {
		if(null === $request) {
			throw new HException(new thx_error_NullArgument("request", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContextImpl.hx", "lineNumber" => 22, "className" => "ufront.web.HttpContextImpl", "methodName" => "setRequest"))));
		}
		$this->request = $request;
	}
	public function setResponse($response) {
		if(null === $response) {
			throw new HException(new thx_error_NullArgument("response", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContextImpl.hx", "lineNumber" => 28, "className" => "ufront.web.HttpContextImpl", "methodName" => "setResponse"))));
		}
		$this->response = $response;
	}
	public function setSession($session) {
		if(null === $session) {
			throw new HException(new thx_error_NullArgument("session", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContextImpl.hx", "lineNumber" => 34, "className" => "ufront.web.HttpContextImpl", "methodName" => "setSession"))));
		}
		$this->session = $session;
	}
	public function getRequest() {
		return $this->request;
	}
	public function getResponse() {
		return $this->response;
	}
	public function getSession() {
		return $this->session;
	}
	public function dispose() {
		$this->getSession()->dispose();
	}
	static $__properties__ = array("get_session" => "getSession","get_response" => "getResponse","get_request" => "getRequest");
	function __toString() { return 'ufront.web.HttpContextImpl'; }
}
