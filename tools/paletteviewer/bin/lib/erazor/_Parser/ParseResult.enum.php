<?php

class erazor__Parser_ParseResult extends Enum {
	public static $doneIncludeCurrent;
	public static $doneSkipCurrent;
	public static $keepGoing;
	public static $__constructors = array(1 => 'doneIncludeCurrent', 2 => 'doneSkipCurrent', 0 => 'keepGoing');
	}
erazor__Parser_ParseResult::$doneIncludeCurrent = new erazor__Parser_ParseResult("doneIncludeCurrent", 1);
erazor__Parser_ParseResult::$doneSkipCurrent = new erazor__Parser_ParseResult("doneSkipCurrent", 2);
erazor__Parser_ParseResult::$keepGoing = new erazor__Parser_ParseResult("keepGoing", 0);
