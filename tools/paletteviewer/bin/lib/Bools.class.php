<?php

class Bools {
	public function __construct(){}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Bools::format");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Bools::formatf($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Bools::formatf");
		$製pos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "B");
		$format = $params->shift();
		switch($format) {
		case "B":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		case "N":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		case "R":{
			if($params->length !== 2) {
				throw new HException("bool format R requires 2 parameters");
			}
			{
				$裨mp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_2"), 'execute');
				$GLOBALS['%s']->pop();
				return $裨mp;
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
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Bools::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Bools::interpolatef");
		$製pos = $GLOBALS['%s']->length;
		if($a === $b) {
			$裨mp = array(new _hx_lambda(array(&$a, &$b, &$equation), "Bools_3"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		} else {
			$f = Floats::interpolatef(0, 1, $equation);
			{
				$裨mp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Bools_4"), 'execute');
				$GLOBALS['%s']->pop();
				return $裨mp;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function canParse($s) {
		$GLOBALS['%s']->push("Bools::canParse");
		$製pos = $GLOBALS['%s']->length;
		$s = strtolower($s);
		{
			$裨mp = $s === "true" || $s === "false";
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parse($s) {
		$GLOBALS['%s']->push("Bools::parse");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = strtolower($s) === "true";
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Bools::compare");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a === $b) ? 0 : (($a) ? -1 : 1));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Bools'; }
}
function Bools_0(&$culture, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::formatf@23");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = (($v) ? "true" : "false");
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_1(&$culture, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::formatf@25");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = (($v) ? "1" : "0");
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_2(&$culture, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::formatf@29");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = Bools_5($culture, $format, $param, $params, $v);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_3(&$a, &$b, &$equation, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::interpolatef@43");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $a;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_4(&$a, &$b, &$equation, &$f, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Bools::interpolatef@47");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = ((call_user_func_array($f, array($v)) < 0.5) ? $a : $b);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Bools_5(&$culture, &$format, &$param, &$params, &$v) {
	$製pos = $GLOBALS['%s']->length;
	if($v) {
		return $params[0];
	} else {
		return $params[1];
	}
}
