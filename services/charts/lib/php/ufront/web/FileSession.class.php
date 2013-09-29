<?php

class php_ufront_web_FileSession implements ufront_web_IHttpSessionState{
	public function __construct($savePath) { if(!php_Boot::$skip_constructor) {
		php_Session::setCacheExpire(14400);
		php_Session::setSavePath($savePath);
	}}
	public function dispose() {
		if(!php_Session::$started) {
			return;
		}
		session_write_close();
	}
	public function clear() {
		session_unset();
	}
	public function get($name) {
		$value = php_Session::get($name);
		if($value === null) {
			return null;
		} else {
			return php_Lib::unserialize($value);
		}
	}
	public function set($name, $value) {
		php_Session::set($name, php_Lib::serialize($value));
	}
	public function exists($name) {
		return php_Session::exists($name);
	}
	public function remove($name) {
		php_Session::remove($name);
	}
	public function id() {
		return php_Session::getId();
	}
	function __toString() { return 'php.ufront.web.FileSession'; }
}
