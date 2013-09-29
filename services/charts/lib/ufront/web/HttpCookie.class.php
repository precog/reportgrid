<?php

class ufront_web_HttpCookie {
	public function __construct($name, $value, $expires, $domain, $path, $secure) {
		if(!php_Boot::$skip_constructor) {
		if($secure === null) {
			$secure = false;
		}
		$this->name = $name;
		$this->setValue($value);
		$this->expires = $expires;
		$this->domain = $domain;
		$this->path = $path;
		$this->secure = $secure;
	}}
	public $domain;
	public $expires;
	public $name;
	public $path;
	public $secure;
	public $value;
	public function setName($v) {
		if(null === $v) {
			throw new HException("invalid null argument name");
		}
		return $this->name = $v;
	}
	public function setValue($v) {
		if(null === $v) {
			throw new HException("invalid null argument value");
		}
		return $this->value = $v;
	}
	public function toString() {
		return $this->name . ": " . (isset($this->description) ? $this->description: array($this, "description"));
	}
	public function description() {
		$buf = new StringBuf();
		$buf->add($this->value);
		if($this->expires !== null) {
			ufront_web_HttpCookie::addPair($buf, "expires", DateTools::format($this->expires, "%a, %d-%b-%Y %H:%M:%S GMT"), null);
		}
		ufront_web_HttpCookie::addPair($buf, "domain", $this->domain, null);
		ufront_web_HttpCookie::addPair($buf, "path", $this->path, null);
		if($this->secure) {
			ufront_web_HttpCookie::addPair($buf, "secure", null, true);
		}
		return $buf->b;
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
	static function addPair($buf, $name, $value, $allowNullValue) {
		if($allowNullValue === null) {
			$allowNullValue = false;
		}
		if(!$allowNullValue && null === $value) {
			return;
		}
		$buf->add("; ");
		$buf->add($name);
		if(null === $value) {
			return;
		}
		$buf->add("=");
		$buf->add($value);
	}
	static $__properties__ = array("set_value" => "setValue");
	function __toString() { return $this->toString(); }
}
