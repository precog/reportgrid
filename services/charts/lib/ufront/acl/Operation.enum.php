<?php

class ufront_acl_Operation extends Enum {
	public static $Add;
	public static $Remove;
	public static $__constructors = array(0 => 'Add', 1 => 'Remove');
	}
ufront_acl_Operation::$Add = new ufront_acl_Operation("Add", 0);
ufront_acl_Operation::$Remove = new ufront_acl_Operation("Remove", 1);
