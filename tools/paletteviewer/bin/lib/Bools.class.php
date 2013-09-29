<?php

class Bools {
	public function __construct(){}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Bools::format");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Bools::formatf($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Bools::formatf");
		$�spos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "B");
		$format = $params->shift();
		switch($format) {
		case "B":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "N":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "R":{
			if($params->length !== 2) {
				throw new HException("bool format R requires 2 parameters");
			}
			{
				$�tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_2"), 'execute');
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		default:{
			throw new HException("Unsupported bool format: " . $format);
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Bools::interpolate");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Bools::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Bools::interpolatef");
		$�spos = $GLOBALS['%s']->length;
		if($a === $b) {
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$equation), "Bools_3"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		} else {
			$f = Floats::interpolatef(0, 1, $equation);
			{
				$�tmp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Bools_4"), 'execute');
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function canParse($s) {
		$GLOBALS['%s']->push("Bools::canParse");
		$�spos = $GLOBALS['%s']->length;
		$s = strtolower($s);
		{
			$�tmp = $s === "true" || $s === "false";
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parse($s) {
		$GLOBALS['%s']->push("Bools::parse");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = strtolower($s) === "true";
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Bools::compare");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = (($a === $b) ? 0 : (($a) ? -1 : 1));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Bools'; }
}
function Bools_0(&$culture, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::formatf@23");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = (($v) ? "true" : "false");
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_1(&$culture, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::formatf@25");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = (($v) ? "1" : "0");
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_2(&$culture, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::formatf@29");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Bools_5($culture, $format, $param, $params, $v);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_3(&$a, &$b, &$equation, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::interpolatef@43");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $a;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_4(&$a, &$b, &$equation, &$f, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::interpolatef@47");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = ((call_user_func_array($f, array($v)) < 0.5) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_5(&$culture, &$format, &$param, &$params, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if($v) {
		return $params[0];
	} else {
		return $params[1];
	}
}
