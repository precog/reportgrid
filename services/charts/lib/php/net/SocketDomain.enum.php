<?php

class php_net_SocketDomain extends Enum {
	public static $AfInet;
	public static $AfInet6;
	public static $AfUnix;
	public static $__constructors = array(0 => 'AfInet', 1 => 'AfInet6', 2 => 'AfUnix');
	}
php_net_SocketDomain::$AfInet = new php_net_SocketDomain("AfInet", 0);
php_net_SocketDomain::$AfInet6 = new php_net_SocketDomain("AfInet6", 1);
php_net_SocketDomain::$AfUnix = new php_net_SocketDomain("AfUnix", 2);
