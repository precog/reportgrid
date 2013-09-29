<?php

class Bools {
	public function __construct(){}
	static function format($v, $param, $params, $culture) {
		return Bools::formatf($param, $params, $culture)($v);
	}
	static function formatf($param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "B");
		$format = $params->shift();
		switch($format) {
		case "B":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_0"), 'execute');
		}break;
		case "N":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_1"), 'execute');
		}break;
		case "R":{
			if($params->length !== 2) {
				throw new HException("bool format R requires 2 parameters");
			}
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_2"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported bool format: " . $format);
		}break;
		}
	}
	static function interpolate($v, $a, $b, $equation) {
		return Bools::interpolatef($a, $b, $equation)($v);
	}
	static function interpolatef($a, $b, $equation) {
		if($a === $b) {
			return array(new _hx_lambda(array(&$a, &$b, &$equation), "Bools_3"), 'execute');
		} else {
			$f = Floats::interpolatef(0, 1, $equation);
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Bools_4"), 'execute');
		}
	}
	static function canParse($s) {
		$s = strtolower($s);
		return $s === "true" || $s === "false";
	}
	static function parse($s) {
		return strtolower($s) === "true";
	}
	static function compare($a, $b) {
		return (($a === $b) ? 0 : (($a) ? -1 : 1));
	}
	function __toString() { return 'Bools'; }
}
function Bools_0(&$culture, &$format, &$param, &$params, $v) {
	{
		return (($v) ? "true" : "false");
	}
}
function Bools_1(&$culture, &$format, &$param, &$params, $v) {
	{
		return (($v) ? "1" : "0");
	}
}
function Bools_2(&$culture, &$format, &$param, &$params, $v) {
	{
		return Bools_5($culture, $format, $param, $params, $v);
	}
}
function Bools_3(&$a, &$b, &$equation, $_) {
	{
		return $a;
	}
}
function Bools_4(&$a, &$b, &$equation, &$f, $v) {
	{
		return ((call_user_func_array($f, array($v)) < 0.5) ? $a : $b);
	}
}
function Bools_5(&$culture, &$format, &$param, &$params, &$v) {
	if($v) {
		return $params[0];
	} else {
		return $params[1];
	}
}
