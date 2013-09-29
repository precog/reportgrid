<?php

class Dates {
	public function __construct(){}
	static function format($d, $param, $params, $culture) {
		$GLOBALS['%s']->push("Dates::format");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = call_user_func_array(Dates::formatf($param, $params, $culture), array($d));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Dates::formatf");
		$»spos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		switch($format) {
		case "D":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "DS":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "DST":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_2"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "DSTS":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_3"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "DTS":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_4"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "Y":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_5"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "YM":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_6"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "M":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_7"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "MN":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_8"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "MS":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_9"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "MD":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_10"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "WD":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_11"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "WDN":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_12"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "WDS":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_13"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "R":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_14"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "DT":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_15"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "U":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_16"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "S":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_17"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "T":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_18"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "TS":{
			$»tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_19"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "C":{
			$f = $params[0];
			if(null === $f) {
				$»tmp = array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Dates_20"), 'execute');
				$GLOBALS['%s']->pop();
				return $»tmp;
			} else {
				$»tmp = array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Dates_21"), 'execute');
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("Unsupported date format: {0}", null, $format, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 71, "className" => "Dates", "methodName" => "formatf"))));
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($f, $a, $b, $equation) {
		$GLOBALS['%s']->push("Dates::interpolate");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = call_user_func_array(Dates::interpolatef($a, $b, $equation), array($f));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Dates::interpolatef");
		$»spos = $GLOBALS['%s']->length;
		$f = Floats::interpolatef($a->getTime(), $b->getTime(), $equation);
		{
			$»tmp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Dates_22"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function snap($time, $period) {
		$GLOBALS['%s']->push("Dates::snap");
		$»spos = $GLOBALS['%s']->length;
		switch($period) {
		case "second":{
			$»tmp = Math::round($time / 1000.0) * 1000.0;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "minute":{
			$»tmp = Math::round($time / 60000.0) * 60000.0;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "hour":{
			$»tmp = Math::round($time / 3600000.0) * 3600000.0;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "day":{
			$»tmp = Math::round($time / 86400000.) * 86400000.;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "week":{
			$»tmp = Math::round($time / 604800000.) * 604800000.;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "month":{
			$d = Date::fromTime($time);
			{
				$»tmp = _hx_deref(new Date($d->getFullYear(), $d->getMonth(), 1, 0, 0, 0))->getTime();
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}break;
		case "year":{
			$d = Date::fromTime($time);
			{
				$»tmp = _hx_deref(new Date($d->getFullYear(), 0, 1, 0, 0, 0))->getTime();
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}break;
		case "eternity":{
			$GLOBALS['%s']->pop();
			return 0;
		}break;
		default:{
			$»tmp = Dates_23($period, $time);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function snapToWeekDay($time, $day) {
		$GLOBALS['%s']->push("Dates::snapToWeekDay");
		$»spos = $GLOBALS['%s']->length;
		$d = Date::fromTime($time)->getDay();
		$s = 0;
		switch(strtolower($day)) {
		case "sunday":{
			$s = 0;
		}break;
		case "monday":{
			$s = 1;
		}break;
		case "tuesday":{
			$s = 2;
		}break;
		case "wednesday":{
			$s = 3;
		}break;
		case "thursday":{
			$s = 4;
		}break;
		case "friday":{
			$s = 5;
		}break;
		case "saturday":{
			$s = 6;
		}break;
		default:{
			throw new HException(new thx_error_Error("unknown week day '{0}'", null, $day, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 134, "className" => "Dates", "methodName" => "snapToWeekDay"))));
		}break;
		}
		{
			$»tmp = $time - ($d - $s) % 7 * 24 * 60 * 60 * 1000;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reparse;
	static function canParse($s) {
		$GLOBALS['%s']->push("Dates::canParse");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Dates::$_reparse->match($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parse($s) {
		$GLOBALS['%s']->push("Dates::parse");
		$»spos = $GLOBALS['%s']->length;
		$parts = _hx_explode(".", $s);
		$date = Date::fromString(str_replace("T", " ", $parts[0]));
		if($parts->length > 1) {
			$date = Date::fromTime($date->getTime() + Std::parseInt($parts[1]));
		}
		{
			$GLOBALS['%s']->pop();
			return $date;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Dates::compare");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Dates_24($a, $b);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Dates'; }
}
Dates::$_reparse = new EReg("^\\d{4}-\\d\\d-\\d\\d(( |T)\\d\\d:\\d\\d(:\\d\\d(\\.\\d{1,3})?)?)?Z?\$", "");
function Dates_0(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@25");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::date($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_1(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@27");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::dateShort($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_2(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@29");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::dateShort($d, $culture) . " " . thx_culture_FormatDate::time($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_3(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@31");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::dateShort($d, $culture) . " " . thx_culture_FormatDate::timeShort($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_4(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@33");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::date($d, $culture) . " " . thx_culture_FormatDate::timeShort($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_5(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@35");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::year($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_6(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@37");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::yearMonth($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_7(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@39");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::month($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_8(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@41");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::monthName($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_9(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@43");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::monthNameShort($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_10(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@45");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::monthDay($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_11(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@47");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::weekDay($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_12(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@49");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::weekDayName($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_13(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@51");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::weekDayNameShort($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_14(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@53");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::dateRfc($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_15(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@55");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::dateTime($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_16(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@57");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::universal($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_17(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@59");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::sortable($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_18(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@61");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::time($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_19(&$culture, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@63");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::timeShort($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_20(&$culture, &$f, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@67");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::date($d, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_21(&$culture, &$f, &$format, &$param, &$params, $d) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::formatf@69");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_FormatDate::format($f, $d, $culture, Dates_25($culture, $d, $f, $format, $param, $params));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_22(&$a, &$b, &$equation, &$f, $v) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dates::interpolatef@83");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = Date::fromTime(call_user_func_array($f, array($v)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dates_23(&$period, &$time) {
	$»spos = $GLOBALS['%s']->length;
	throw new HException(new thx_error_Error("unknown period '{0}'", null, $period, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 109, "className" => "Dates", "methodName" => "snap"))));
}
function Dates_24(&$a, &$b) {
	$»spos = $GLOBALS['%s']->length;
	{
		$a1 = $a->getTime(); $b1 = $b->getTime();
		if($a1 < $b1) {
			return -1;
		} else {
			if($a1 > $b1) {
				return 1;
			} else {
				return 0;
			}
		}
		unset($b1,$a1);
	}
}
function Dates_25(&$culture, &$d, &$f, &$format, &$param, &$params) {
	$»spos = $GLOBALS['%s']->length;
	if($params[1] !== null) {
		return $params[1] === "true";
	} else {
		return true;
	}
}
