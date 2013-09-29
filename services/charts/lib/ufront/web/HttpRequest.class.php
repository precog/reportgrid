<?php

class ufront_web_HttpRequest {
	public function __construct(){}
	public $params;
	public function getParams() {
		if(null === $this->params) {
			$this->params = new thx_collection_CascadeHash(new _hx_array(array(new Hash(), $this->getQuery(), $this->getPost(), $this->getCookies())));
		}
		return $this->params;
	}
	public $queryString;
	public function getQueryString() {
		ufront_web_HttpRequest_0($this);
	}
	public $postString;
	public function getPostString() {
		ufront_web_HttpRequest_1($this);
	}
	public $query;
	public function getQuery() {
		ufront_web_HttpRequest_2($this);
	}
	public $post;
	public function getPost() {
		ufront_web_HttpRequest_3($this);
	}
	public $cookies;
	public function getCookies() {
		ufront_web_HttpRequest_4($this);
	}
	public $hostName;
	public function getHostName() {
		ufront_web_HttpRequest_5($this);
	}
	public $clientIP;
	public function getClientIP() {
		ufront_web_HttpRequest_6($this);
	}
	public $uri;
	public function getUri() {
		ufront_web_HttpRequest_7($this);
	}
	public $clientHeaders;
	public function getClientHeaders() {
		ufront_web_HttpRequest_8($this);
	}
	public $userAgent;
	public function getUserAgent() {
		ufront_web_HttpRequest_9($this);
	}
	public $httpMethod;
	public function getHttpMethod() {
		ufront_web_HttpRequest_10($this);
	}
	public $scriptDirectory;
	public function getScriptDirectory() {
		ufront_web_HttpRequest_11($this);
	}
	public $authorization;
	public function getAuthorization() {
		ufront_web_HttpRequest_12($this);
	}
	public function setUploadHandler($handler) {
		throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 83, "className" => "ufront.web.HttpRequest", "methodName" => "setUploadHandler"))));
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
	static $instance;
	static function getInstance() {
		if(null === ufront_web_HttpRequest::$instance) {
			ufront_web_HttpRequest::$instance = new php_ufront_web_HttpRequest();
		}
		return ufront_web_HttpRequest::$instance;
	}
	static $__properties__ = array("get_authorization" => "getAuthorization","get_scriptDirectory" => "getScriptDirectory","get_httpMethod" => "getHttpMethod","get_userAgent" => "getUserAgent","get_clientHeaders" => "getClientHeaders","get_uri" => "getUri","get_clientIP" => "getClientIP","get_hostName" => "getHostName","get_cookies" => "getCookies","get_post" => "getPost","get_query" => "getQuery","get_postString" => "getPostString","get_queryString" => "getQueryString","get_params" => "getParams","get_instance" => "getInstance");
	function __toString() { return 'ufront.web.HttpRequest'; }
}
function ufront_web_HttpRequest_0(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 45, "className" => "ufront.web.HttpRequest", "methodName" => "getQueryString"))));
}
function ufront_web_HttpRequest_1(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 48, "className" => "ufront.web.HttpRequest", "methodName" => "getPostString"))));
}
function ufront_web_HttpRequest_2(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 51, "className" => "ufront.web.HttpRequest", "methodName" => "getQuery"))));
}
function ufront_web_HttpRequest_3(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 54, "className" => "ufront.web.HttpRequest", "methodName" => "getPost"))));
}
function ufront_web_HttpRequest_4(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 57, "className" => "ufront.web.HttpRequest", "methodName" => "getCookies"))));
}
function ufront_web_HttpRequest_5(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 60, "className" => "ufront.web.HttpRequest", "methodName" => "getHostName"))));
}
function ufront_web_HttpRequest_6(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 63, "className" => "ufront.web.HttpRequest", "methodName" => "getClientIP"))));
}
function ufront_web_HttpRequest_7(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 66, "className" => "ufront.web.HttpRequest", "methodName" => "getUri"))));
}
function ufront_web_HttpRequest_8(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 69, "className" => "ufront.web.HttpRequest", "methodName" => "getClientHeaders"))));
}
function ufront_web_HttpRequest_9(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 72, "className" => "ufront.web.HttpRequest", "methodName" => "getUserAgent"))));
}
function ufront_web_HttpRequest_10(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 75, "className" => "ufront.web.HttpRequest", "methodName" => "getHttpMethod"))));
}
function ufront_web_HttpRequest_11(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 78, "className" => "ufront.web.HttpRequest", "methodName" => "getScriptDirectory"))));
}
function ufront_web_HttpRequest_12(&$»this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 81, "className" => "ufront.web.HttpRequest", "methodName" => "getAuthorization"))));
}
