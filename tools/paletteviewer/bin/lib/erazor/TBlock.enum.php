<?php

class erazor_TBlock extends Enum {
	public static function codeBlock($s) { return new erazor_TBlock("codeBlock", 1, array($s)); }
	public static function literal($s) { return new erazor_TBlock("literal", 0, array($s)); }
	public static function printBlock($s) { return new erazor_TBlock("printBlock", 2, array($s)); }
	public static $__constructors = array(1 => 'codeBlock', 0 => 'literal', 2 => 'printBlock');
	}
