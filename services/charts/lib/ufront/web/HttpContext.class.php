<?php

class ufront_web_HttpContext {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_urlFilters = new _hx_array(array());
	}}
	public $_urlFilters;
	public $request;
	public $response;
	public $session;
	public $_requestUri;
	public function getRequestUri() {
		if(null === $this->_requestUri) {
			$url = ufront_web_PartialUrl::parse($this->getRequest()->getUri());
			{
				$_g = 0; $_g1 = $this->_urlFilters;
				while($_g < $_g1->length) {
					$filter = $_g1[$_g];
					++$_g;
					$filter->filterIn($url, $this->getRequest());
					unset($filter);
				}
			}
			$this->_requestUri = $url->toString();
		}
		return $this->_requestUri;
	}
	public function generateUri($uri) {
		$uriOut = ufront_web_VirtualUrl::parse($uri);
		$i = $this->_urlFilters->length - 1;
		while($i >= 0) {
			_hx_array_get($this->_urlFilters, $i--)->filterOut($uriOut, $this->getRequest());
		}
		return $uriOut->toString();
	}
	public function addUrlFilter($filter) {
		if(null === $filter) {
			throw new HException(new thx_error_NullArgument("filter", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 57, "className" => "ufront.web.HttpContext", "methodName" => "addUrlFilter"))));
		}
		$this->_requestUri = null;
		$this->_urlFilters->push($filter);
		return $this;
	}
	public function clearUrlFilters() {
		$this->_requestUri = null;
		$this->_urlFilters = new _hx_array(array());
	}
	public function dispose() {
	}
	public function getRequest() {
		ufront_web_HttpContext_0($this);
	}
	public function getResponse() {
		ufront_web_HttpContext_1($this);
	}
	public function getSession() {
		ufront_web_HttpContext_2($this);
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
	static function createWebContext($sessionpath, $request, $response) {
		if(null === $request) {
			$request = ufront_web_HttpRequest::getInstance();
		}
		if(null === $response) {
			$response = ufront_web_HttpResponse::getInstance();
		}
		if(null === $sessionpath) {
			$sessionpath = $request->getScriptDirectory() . "../_sessions";
		}
		return new ufront_web_HttpContextImpl($request, $response, ufront_web_session_FileSession::create($sessionpath));
	}
	static $__properties__ = array("get_session" => "getSession","get_response" => "getResponse","get_request" => "getRequest");
	function __toString() { return 'ufront.web.HttpContext'; }
}
function ufront_web_HttpContext_0(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 71, "className" => "ufront.web.HttpContext", "methodName" => "getRequest"))));
}
function ufront_web_HttpContext_1(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 72, "className" => "ufront.web.HttpContext", "methodName" => "getResponse"))));
}
function ufront_web_HttpContext_2(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 73, "className" => "ufront.web.HttpContext", "methodName" => "getSession"))));
}
