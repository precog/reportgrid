<?php

class hscript_Token extends Enum {
	public static $TBkClose;
	public static $TBkOpen;
	public static $TBrClose;
	public static $TBrOpen;
	public static $TComma;
	public static function TConst($c) { return new hscript_Token("TConst", 1, array($c)); }
	public static $TDot;
	public static $TDoubleDot;
	public static $TEof;
	public static function TId($s) { return new hscript_Token("TId", 2, array($s)); }
	public static function TOp($s) { return new hscript_Token("TOp", 3, array($s)); }
	public static $TPClose;
	public static $TPOpen;
	public static $TQuestion;
	public static $TSemicolon;
	public static $__constructors = array(12 => 'TBkClose', 11 => 'TBkOpen', 7 => 'TBrClose', 6 => 'TBrOpen', 9 => 'TComma', 1 => 'TConst', 8 => 'TDot', 14 => 'TDoubleDot', 0 => 'TEof', 2 => 'TId', 3 => 'TOp', 5 => 'TPClose', 4 => 'TPOpen', 13 => 'TQuestion', 10 => 'TSemicolon');
	}
hscript_Token::$TBkClose = new hscript_Token("TBkClose", 12);
hscript_Token::$TBkOpen = new hscript_Token("TBkOpen", 11);
hscript_Token::$TBrClose = new hscript_Token("TBrClose", 7);
hscript_Token::$TBrOpen = new hscript_Token("TBrOpen", 6);
hscript_Token::$TComma = new hscript_Token("TComma", 9);
hscript_Token::$TDot = new hscript_Token("TDot", 8);
hscript_Token::$TDoubleDot = new hscript_Token("TDoubleDot", 14);
hscript_Token::$TEof = new hscript_Token("TEof", 0);
hscript_Token::$TPClose = new hscript_Token("TPClose", 5);
hscript_Token::$TPOpen = new hscript_Token("TPOpen", 4);
hscript_Token::$TQuestion = new hscript_Token("TQuestion", 13);
hscript_Token::$TSemicolon = new hscript_Token("TSemicolon", 10);
