<?php

class hscript_Error extends Enum {
	public static function EInvalidAccess($f) { return new hscript_Error("EInvalidAccess", 7, array($f)); }
	public static function EInvalidChar($c) { return new hscript_Error("EInvalidChar", 0, array($c)); }
	public static function EInvalidIterator($v) { return new hscript_Error("EInvalidIterator", 5, array($v)); }
	public static function EInvalidOp($op) { return new hscript_Error("EInvalidOp", 6, array($op)); }
	public static function EUnexpected($s) { return new hscript_Error("EUnexpected", 1, array($s)); }
	public static function EUnknownVariable($v) { return new hscript_Error("EUnknownVariable", 4, array($v)); }
	public static $EUnterminatedComment;
	public static $EUnterminatedString;
	public static $__constructors = array(7 => 'EInvalidAccess', 0 => 'EInvalidChar', 5 => 'EInvalidIterator', 6 => 'EInvalidOp', 1 => 'EUnexpected', 4 => 'EUnknownVariable', 3 => 'EUnterminatedComment', 2 => 'EUnterminatedString');
	}
hscript_Error::$EUnterminatedComment = new hscript_Error("EUnterminatedComment", 3);
hscript_Error::$EUnterminatedString = new hscript_Error("EUnterminatedString", 2);
