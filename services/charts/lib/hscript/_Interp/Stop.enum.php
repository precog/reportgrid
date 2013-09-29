<?php

class hscript__Interp_Stop extends Enum {
	public static $SBreak;
	public static $SContinue;
	public static function SReturn($v) { return new hscript__Interp_Stop("SReturn", 2, array($v)); }
	public static $__constructors = array(0 => 'SBreak', 1 => 'SContinue', 2 => 'SReturn');
	}
hscript__Interp_Stop::$SBreak = new hscript__Interp_Stop("SBreak", 0);
hscript__Interp_Stop::$SContinue = new hscript__Interp_Stop("SContinue", 1);
