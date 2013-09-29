<?php

class Dates {
	public function __construct(){}
	static function format($d, $param, $params, $culture) {
		return call_user_func_array(Dates::formatf($param, $params, $culture), array($d));
	}
	static function formatf($param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		switch($format) {
		case "D":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_0"), 'execute');
		}break;
		case "DS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_1"), 'execute');
		}break;
		case "DST":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_2"), 'execute');
		}break;
		case "DSTS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_3"), 'execute');
		}break;
		case "DTS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_4"), 'execute');
		}break;
		case "Y":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_5"), 'execute');
		}break;
		case "YM":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_6"), 'execute');
		}break;
		case "M":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_7"), 'execute');
		}break;
		case "MN":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_8"), 'execute');
		}break;
		case "MS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_9"), 'execute');
		}break;
		case "MD":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_10"), 'execute');
		}break;
		case "WD":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_11"), 'execute');
		}break;
		case "WDN":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_12"), 'execute');
		}break;
		case "WDS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_13"), 'execute');
		}break;
		case "R":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_14"), 'execute');
		}break;
		case "DT":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_15"), 'execute');
		}break;
		case "U":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_16"), 'execute');
		}break;
		case "S":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_17"), 'execute');
		}break;
		case "T":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_18"), 'execute');
		}break;
		case "TS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_19"), 'execute');
		}break;
		case "C":{
			$f = $params[0];
			if(null === $f) {
				return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Dates_20"), 'execute');
			} else {
				return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Dates_21"), 'execute');
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("Unsupported date format: {0}", null, $format, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 71, "className" => "Dates", "methodName" => "formatf"))));
		}break;
		}
	}
	static function interpolate($f, $a, $b, $equation) {
		return call_user_func_array(Dates::interpolatef($a, $b, $equation), array($f));
	}
	static function interpolatef($a, $b, $equation) {
		$f = Floats::interpolatef($a->getTime(), $b->getTime(), $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Dates_22"), 'execute');
	}
	static function snap($time, $period, $mode) {
		if($mode === null) {
			$mode = 0;
		}
		if($mode < 0) {
			switch($period) {
			case "second":{
				return Math::floor($time / 1000.0) * 1000.0;
			}break;
			case "minute":{
				return Math::floor($time / 60000.0) * 60000.0;
			}break;
			case "hour":{
				return Math::floor($time / 3600000.0) * 3600000.0;
			}break;
			case "day":{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate(), 0, 0, 0))->getTime();
			}break;
			case "week":{
				return Math::floor($time / 604800000.) * 604800000.;
			}break;
			case "month":{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), 1, 0, 0, 0))->getTime();
			}break;
			case "year":{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), 0, 1, 0, 0, 0))->getTime();
			}break;
			default:{
				return 0;
			}break;
			}
		} else {
			if($mode > 0) {
				switch($period) {
				case "second":{
					return Math::ceil($time / 1000.0) * 1000.0;
				}break;
				case "minute":{
					return Math::ceil($time / 60000.0) * 60000.0;
				}break;
				case "hour":{
					return Math::ceil($time / 3600000.0) * 3600000.0;
				}break;
				case "day":{
					$d = Date::fromTime($time);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate() + 1, 0, 0, 0))->getTime();
				}break;
				case "week":{
					return Math::ceil($time / 604800000.) * 604800000.;
				}break;
				case "month":{
					$d = Date::fromTime($time);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth() + 1, 1, 0, 0, 0))->getTime();
				}break;
				case "year":{
					$d = Date::fromTime($time);
					return _hx_deref(new Date($d->getFullYear() + 1, 0, 1, 0, 0, 0))->getTime();
				}break;
				default:{
					return 0;
				}break;
				}
			} else {
				switch($period) {
				case "second":{
					return Math::round($time / 1000.0) * 1000.0;
				}break;
				case "minute":{
					return Math::round($time / 60000.0) * 60000.0;
				}break;
				case "hour":{
					return Math::round($time / 3600000.0) * 3600000.0;
				}break;
				case "day":{
					$d = Date::fromTime($time); $mod = (($d->getHours() >= 12) ? 1 : 0);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate() + $mod, 0, 0, 0))->getTime();
				}break;
				case "week":{
					return Math::round($time / 604800000.) * 604800000.;
				}break;
				case "month":{
					$d = Date::fromTime($time); $mod = (($d->getDate() > Math::round(DateTools::getMonthDays($d) / 2)) ? 1 : 0);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth() + $mod, 1, 0, 0, 0))->getTime();
				}break;
				case "year":{
					$d = Date::fromTime($time); $mod = (($time > _hx_deref(new Date($d->getFullYear(), 6, 2, 0, 0, 0))->getTime()) ? 1 : 0);
					return _hx_deref(new Date($d->getFullYear() + $mod, 0, 1, 0, 0, 0))->getTime();
				}break;
				default:{
					return 0;
				}break;
				}
			}
		}
	}
	static function snapToWeekDay($time, $day) {
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
			throw new HException(new thx_error_Error("unknown week day '{0}'", null, $day, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 186, "className" => "Dates", "methodName" => "snapToWeekDay"))));
		}break;
		}
		return $time - ($d - $s) % 7 * 24 * 60 * 60 * 1000;
	}
	static $_reparse;
	static function canParse($s) {
		return Dates::$_reparse->match($s);
	}
	static function parse($s) {
		$parts = _hx_explode(".", $s);
		$date = Date::fromString(str_replace("T", " ", $parts[0]));
		if($parts->length > 1) {
			$date = Date::fromTime($date->getTime() + Std::parseInt($parts[1]));
		}
		return $date;
	}
	static function compare($a, $b) {
		return Dates_23($a, $b);
	}
	function __toString() { return 'Dates'; }
}
Dates::$_reparse = new EReg("^\\d{4}-\\d\\d-\\d\\d(( |T)\\d\\d:\\d\\d(:\\d\\d(\\.\\d{1,3})?)?)?Z?\$", "");
function Dates_0(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::date($d, $culture);
	}
}
function Dates_1(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateShort($d, $culture);
	}
}
function Dates_2(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateShort($d, $culture) . " " . thx_culture_FormatDate::time($d, $culture);
	}
}
function Dates_3(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateShort($d, $culture) . " " . thx_culture_FormatDate::timeShort($d, $culture);
	}
}
function Dates_4(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::date($d, $culture) . " " . thx_culture_FormatDate::timeShort($d, $culture);
	}
}
function Dates_5(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::year($d, $culture);
	}
}
function Dates_6(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::yearMonth($d, $culture);
	}
}
function Dates_7(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::month($d, $culture);
	}
}
function Dates_8(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::monthName($d, $culture);
	}
}
function Dates_9(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::monthNameShort($d, $culture);
	}
}
function Dates_10(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::monthDay($d, $culture);
	}
}
function Dates_11(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::weekDay($d, $culture);
	}
}
function Dates_12(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::weekDayName($d, $culture);
	}
}
function Dates_13(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::weekDayNameShort($d, $culture);
	}
}
function Dates_14(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateRfc($d, $culture);
	}
}
function Dates_15(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateTime($d, $culture);
	}
}
function Dates_16(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::universal($d, $culture);
	}
}
function Dates_17(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::sortable($d, $culture);
	}
}
function Dates_18(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::time($d, $culture);
	}
}
function Dates_19(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::timeShort($d, $culture);
	}
}
function Dates_20(&$culture, &$f, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::date($d, $culture);
	}
}
function Dates_21(&$culture, &$f, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::format($f, $d, $culture, Dates_24($culture, $d, $f, $format, $param, $params));
	}
}
function Dates_22(&$a, &$b, &$equation, &$f, $v) {
	{
		return Date::fromTime(call_user_func_array($f, array($v)));
	}
}
function Dates_23(&$a, &$b) {
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
function Dates_24(&$culture, &$d, &$f, &$format, &$param, &$params) {
	if($params[1] !== null) {
		return $params[1] === "true";
	} else {
		return true;
	}
}
