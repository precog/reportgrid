<?php

class php_Session {
	public function __construct(){}
	static function getCacheLimiter() {
		switch(session_cache_limiter()) {
		case "public":{
			return php_CacheLimiter::$Public;
		}break;
		case "private":{
			return php_CacheLimiter::$Private;
		}break;
		case "nocache":{
			return php_CacheLimiter::$NoCache;
		}break;
		case "private_no_expire":{
			return php_CacheLimiter::$PrivateNoExpire;
		}break;
		}
		return null;
	}
	static function setCacheLimiter($l) {
		if(php_Session::$started) {
			throw new HException("You can't set the cache limiter while the session is already in use");
		}
		$»t = ($l);
		switch($»t->index) {
		case 0:
		{
			session_cache_limiter("public");
		}break;
		case 1:
		{
			session_cache_limiter("private");
		}break;
		case 2:
		{
			session_cache_limiter("nocache");
		}break;
		case 3:
		{
			session_cache_limiter("private_no_expire");
		}break;
		}
	}
	static function getCacheExpire() {
		return session_cache_expire();
	}
	static function setCacheExpire($minutes) {
		if(php_Session::$started) {
			throw new HException("You can't set the cache expire time while the session is already in use");
		}
		session_cache_expire($minutes);
	}
	static function setName($name) {
		if(php_Session::$started) {
			throw new HException("You can't set the name while the session is already in use");
		}
		session_name($name);
	}
	static function getName() {
		return session_name();
	}
	static function getId() {
		return session_id();
	}
	static function setId($id) {
		if(php_Session::$started) {
			throw new HException("You can't set the session id while the session is already in use");
		}
		session_id($id);
	}
	static function getSavePath() {
		return session_save_path();
	}
	static function setSavePath($path) {
		if(php_Session::$started) {
			throw new HException("You can't set the save path while the session is already in use");
		}
		session_save_path($path);
	}
	static function getModule() {
		return session_module_name();
	}
	static function setModule($module) {
		if(php_Session::$started) {
			throw new HException("You can't set the module while the session is already in use");
		}
		session_module_name($module);
	}
	static function regenerateId($deleteold) {
		return session_regenerate_id($deleteold);
	}
	static function get($name) {
		php_Session::start();
		if(!isset($_SESSION[$name])) {
			return null;
		}
		return $_SESSION[$name];
	}
	static function set($name, $value) {
		php_Session::start();
		return $_SESSION[$name] = $value;
	}
	static function setCookieParams($lifetime, $path, $domain, $secure, $httponly) {
		if(php_Session::$started) {
			throw new HException("You can't set the cookie params while the session is already in use");
		}
		session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	}
	static function getCookieParams() {
		return _hx_anonymous(session_get_cookie_params());
	}
	static function setSaveHandler($open, $close, $read, $write, $destroy, $gc) {
		return session_set_save_handler($open, $close, $read, $write, $destroy, $gc);
	}
	static function exists($name) {
		php_Session::start();
		return array_key_exists($name, $_SESSION);
	}
	static function remove($name) {
		php_Session::start();
		unset($_SESSION[$name]);
	}
	static $started;
	static function start() {
		if(php_Session::$started) {
			return;
		}
		php_Session::$started = true;
		session_start();
	}
	static function clear() {
		session_unset();
	}
	static function close() {
		session_write_close();
		php_Session::$started = false;
	}
	function __toString() { return 'php.Session'; }
}
php_Session::$started = isset($_SESSION);
