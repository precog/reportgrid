<?php

class php_CacheLimiter extends Enum {
	public static $NoCache;
	public static $Private;
	public static $PrivateNoExpire;
	public static $Public;
	public static $__constructors = array(2 => 'NoCache', 1 => 'Private', 3 => 'PrivateNoExpire', 0 => 'Public');
	}
php_CacheLimiter::$NoCache = new php_CacheLimiter("NoCache", 2);
php_CacheLimiter::$Private = new php_CacheLimiter("Private", 1);
php_CacheLimiter::$PrivateNoExpire = new php_CacheLimiter("PrivateNoExpire", 3);
php_CacheLimiter::$Public = new php_CacheLimiter("Public", 0);
