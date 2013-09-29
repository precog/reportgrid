<?php

class ufront_web_HttpResponse {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->clear();
		$this->setContentType(null);
		$this->charset = "utf-8";
		$this->status = 200;
	}}
	public $contentType;
	public $redirectLocation;
	public $charset;
	public $status;
	public $_buff;
	public $_headers;
	public $_cookies;
	public function flush() {
	}
	public function clear() {
		$this->clearCookies();
		$this->clearHeaders();
		$this->clearContent();
	}
	public function clearCookies() {
		$this->_cookies = new Hash();
	}
	public function clearContent() {
		$this->_buff = new StringBuf();
	}
	public function clearHeaders() {
		$this->_headers = new thx_collection_HashList();
	}
	public function write($s) {
		if(null !== $s) {
			$this->_buff->add($s);
		}
	}
	public function writeChar($c) {
		$this->_buff->b .= chr($c);
	}
	public function writeBytes($b, $pos, $len) {
		$this->_buff->add($b->readString($pos, $len));
	}
	public function setHeader($name, $value) {
		if(null === $name) {
			throw new HException(new thx_error_NullArgument("name", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 103, "className" => "ufront.web.HttpResponse", "methodName" => "setHeader"))));
		}
		if(null === $value) {
			throw new HException(new thx_error_NullArgument("value", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 104, "className" => "ufront.web.HttpResponse", "methodName" => "setHeader"))));
		}
		$this->_headers->set($name, $value);
	}
	public function setCookie($cookie) {
		$this->_cookies->set($cookie->name, $cookie);
	}
	public function getBuffer() {
		return $this->_buff->b;
	}
	public function getCookies() {
		return $this->_cookies;
	}
	public function getHeaders() {
		return $this->_headers;
	}
	public function redirect($url) {
		$this->status = 302;
		$this->setRedirectLocation($url);
	}
	public function setOk() {
		$this->status = 200;
	}
	public function setUnauthorized() {
		$this->status = 401;
	}
	public function setNotFound() {
		$this->status = 404;
	}
	public function setInternalError() {
		$this->status = 500;
	}
	public function permanentRedirect($url) {
		$this->status = 301;
		$this->setRedirectLocation($url);
	}
	public function isRedirect() {
		return Math::floor($this->status / 100) === 3;
	}
	public function isPermanentRedirect() {
		return $this->status === 301;
	}
	public function getContentType() {
		return $this->_headers->get("Content-type");
	}
	public function setContentType($v) {
		if(null === $v) {
			$this->_headers->set("Content-type", "text/html");
		} else {
			$this->_headers->set("Content-type", $v);
		}
		return $v;
	}
	public function getRedirectLocation() {
		return $this->_headers->get("Location");
	}
	public function setRedirectLocation($v) {
		if(null === $v) {
			$this->_headers->remove("Location");
		} else {
			$this->_headers->set("Location", $v);
		}
		return $v;
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
		if(null === ufront_web_HttpResponse::$instance) {
			ufront_web_HttpResponse::$instance = new php_ufront_web_HttpResponse();
		}
		return ufront_web_HttpResponse::$instance;
	}
	static $CONTENT_TYPE = "Content-type";
	static $LOCATION = "Location";
	static $DEFAULT_CONTENT_TYPE = "text/html";
	static $DEFAULT_CHARSET = "utf-8";
	static $DEFAULT_STATUS = 200;
	static $MOVED_PERMANENTLY = 301;
	static $FOUND = 302;
	static $UNAUTHORIZED = 401;
	static $NOT_FOUND = 404;
	static $INTERNAL_SERVER_ERROR = 500;
	static $__properties__ = array("set_redirectLocation" => "setRedirectLocation","get_redirectLocation" => "getRedirectLocation","set_contentType" => "setContentType","get_contentType" => "getContentType","get_instance" => "getInstance");
	function __toString() { return 'ufront.web.HttpResponse'; }
}
