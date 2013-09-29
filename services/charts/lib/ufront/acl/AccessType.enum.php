<?php

class ufront_acl_AccessType extends Enum {
	public static $Allow;
	public static $Deny;
	public static $__constructors = array(0 => 'Allow', 1 => 'Deny');
	}
ufront_acl_AccessType::$Allow = new ufront_acl_AccessType("Allow", 0);
ufront_acl_AccessType::$Deny = new ufront_acl_AccessType("Deny", 1);
