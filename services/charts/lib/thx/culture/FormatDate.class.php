<?php

class thx_culture_FormatDate {
	public function __construct(){}
	static function format($pattern, $date, $culture, $leadingspace) {
		if($leadingspace === null) {
			$leadingspace = true;
		}
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		$pos = 0;
		$len = strlen($pattern);
		$buf = new StringBuf();
		$info = $culture->date;
		while($pos < $len) {
			$c = _hx_char_at($pattern, $pos);
			if($c !== "%") {
				$buf->add($c);
				$pos++;
				continue;
			}
			$pos++;
			$c = _hx_char_at($pattern, $pos);
			switch($c) {
			case "a":{
				$buf->add($info->abbrDays[$date->getDay()]);
			}break;
			case "A":{
				$buf->add($info->days[$date->getDay()]);
			}break;
			case "b":case "h":{
				$buf->add($info->abbrMonths[$date->getMonth()]);
			}break;
			case "B":{
				$buf->add($info->months[$date->getMonth()]);
			}break;
			case "c":{
				$buf->add(thx_culture_FormatDate::dateTime($date, $culture));
			}break;
			case "C":{
				$buf->add(thx_culture_FormatNumber::digits("" . Math::floor($date->getFullYear() / 100), $culture));
			}break;
			case "d":{
				$buf->add(thx_culture_FormatNumber::digits(str_pad("" . $date->getDate(), 2, "0", STR_PAD_LEFT), $culture));
			}break;
			case "D":{
				$buf->add(thx_culture_FormatDate::format("%m/%d/%y", $date, $culture, null));
			}break;
			case "e":{
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_0($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "f":{
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_1($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "G":{
				throw new HException("Not Implemented Yet");
			}break;
			case "g":{
				throw new HException("Not Implemented Yet");
			}break;
			case "H":{
				$buf->add(thx_culture_FormatNumber::digits(str_pad("" . $date->getHours(), 2, "0", STR_PAD_LEFT), $culture));
			}break;
			case "i":{
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_2($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "I":{
				$buf->add(thx_culture_FormatNumber::digits(str_pad("" . thx_culture_FormatDate::getMHours($date), 2, "0", STR_PAD_LEFT), $culture));
			}break;
			case "j":{
				throw new HException("Not Implemented Yet");
			}break;
			case "k":{
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_3($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "l":{
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_4($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "m":{
				$buf->add(thx_culture_FormatNumber::digits(str_pad("" . ($date->getMonth() + 1), 2, "0", STR_PAD_LEFT), $culture));
			}break;
			case "M":{
				$buf->add(thx_culture_FormatNumber::digits(str_pad("" . $date->getMinutes(), 2, "0", STR_PAD_LEFT), $culture));
			}break;
			case "n":{
				$buf->add("\x0A");
			}break;
			case "p":{
				$buf->add(thx_culture_FormatDate_5($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos));
			}break;
			case "P":{
				$buf->add(strtolower((thx_culture_FormatDate_6($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos))));
			}break;
			case "q":{
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_7($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "r":{
				$buf->add(thx_culture_FormatDate::format("%I:%M:%S %p", $date, $culture, null));
			}break;
			case "R":{
				$buf->add(thx_culture_FormatDate::format("%H:%M", $date, $culture, null));
			}break;
			case "s":{
				$buf->add("" . intval($date->getTime() / 1000));
			}break;
			case "S":{
				$buf->add(thx_culture_FormatNumber::digits(str_pad("" . $date->getSeconds(), 2, "0", STR_PAD_LEFT), $culture));
			}break;
			case "t":{
				$buf->add("\x09");
			}break;
			case "T":{
				$buf->add(thx_culture_FormatDate::format("%H:%M:%S", $date, $culture, null));
			}break;
			case "u":{
				$d = $date->getDay();
				$buf->add(thx_culture_FormatNumber::digits(thx_culture_FormatDate_8($buf, $c, $culture, $d, $date, $info, $leadingspace, $len, $pattern, $pos), $culture));
			}break;
			case "U":{
				throw new HException("Not Implemented Yet");
			}break;
			case "V":{
				throw new HException("Not Implemented Yet");
			}break;
			case "w":{
				$buf->add(thx_culture_FormatNumber::digits("" . $date->getDay(), $culture));
			}break;
			case "W":{
				throw new HException("Not Implemented Yet");
			}break;
			case "x":{
				$buf->add(thx_culture_FormatDate::date($date, $culture));
			}break;
			case "X":{
				$buf->add(thx_culture_FormatDate::time($date, $culture));
			}break;
			case "y":{
				$buf->add(thx_culture_FormatNumber::digits(_hx_substr(("" . $date->getFullYear()), -2, null), $culture));
			}break;
			case "Y":{
				$buf->add(thx_culture_FormatNumber::digits("" . $date->getFullYear(), $culture));
			}break;
			case "z":{
				$buf->add("+0000");
			}break;
			case "Z":{
				$buf->add("GMT");
			}break;
			case "%":{
				$buf->add("%");
			}break;
			default:{
				$buf->add("%" . $c);
			}break;
			}
			$pos++;
			unset($c);
		}
		return $buf->b;
	}
	static function getMHours($date) {
		$v = $date->getHours();
		return thx_culture_FormatDate_9($date, $v);
	}
	static function yearMonth($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternYearMonth, $date, $culture, false);
	}
	static function monthDay($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternMonthDay, $date, $culture, false);
	}
	static function date($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternDate, $date, $culture, false);
	}
	static function dateShort($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternDateShort, $date, $culture, false);
	}
	static function dateRfc($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternDateRfc, $date, $culture, false);
	}
	static function dateTime($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternDateTime, $date, $culture, false);
	}
	static function universal($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternUniversal, $date, $culture, false);
	}
	static function sortable($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternSortable, $date, $culture, false);
	}
	static function time($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternTime, $date, $culture, false);
	}
	static function timeShort($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatDate::format($culture->date->patternTimeShort, $date, $culture, false);
	}
	static function hourShort($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		if(null === $culture->date->am) {
			return thx_culture_FormatDate::format("%H", $date, $culture, false);
		} else {
			return thx_culture_FormatDate::format("%l %p", $date, $culture, false);
		}
	}
	static function year($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatNumber::digits("" . $date->getFullYear(), $culture);
	}
	static function month($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatNumber::digits("" . ($date->getMonth() + 1), $culture);
	}
	static function monthName($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return $culture->date->abbrMonths[$date->getMonth()];
	}
	static function monthNameShort($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return $culture->date->months[$date->getMonth()];
	}
	static function weekDay($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return thx_culture_FormatNumber::digits("" . ($date->getDay() + $culture->date->firstWeekDay), $culture);
	}
	static function weekDayName($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return $culture->date->abbrDays[$date->getDay()];
	}
	static function weekDayNameShort($date, $culture) {
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		return $culture->date->days[$date->getDay()];
	}
	function __toString() { return 'thx.culture.FormatDate'; }
}
function thx_culture_FormatDate_0(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($leadingspace) {
		return str_pad("" . $date->getDate(), 2, " ", STR_PAD_LEFT);
	} else {
		return "" . $date->getDate();
	}
}
function thx_culture_FormatDate_1(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($leadingspace) {
		return str_pad("" . ($date->getMonth() + 1), 2, " ", STR_PAD_LEFT);
	} else {
		return "" . ($date->getMonth() + 1);
	}
}
function thx_culture_FormatDate_2(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($leadingspace) {
		return str_pad("" . $date->getMinutes(), 2, " ", STR_PAD_LEFT);
	} else {
		return "" . $date->getMinutes();
	}
}
function thx_culture_FormatDate_3(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($leadingspace) {
		return str_pad("" . $date->getHours(), 2, " ", STR_PAD_LEFT);
	} else {
		return "" . $date->getHours();
	}
}
function thx_culture_FormatDate_4(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($leadingspace) {
		return str_pad("" . thx_culture_FormatDate::getMHours($date), 2, " ", STR_PAD_LEFT);
	} else {
		return "" . thx_culture_FormatDate::getMHours($date);
	}
}
function thx_culture_FormatDate_5(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($date->getHours() > 11) {
		return $info->pm;
	} else {
		return $info->am;
	}
}
function thx_culture_FormatDate_6(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($date->getHours() > 11) {
		return $info->pm;
	} else {
		return $info->am;
	}
}
function thx_culture_FormatDate_7(&$buf, &$c, &$culture, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($leadingspace) {
		return str_pad("" . $date->getSeconds(), 2, " ", STR_PAD_LEFT);
	} else {
		return "" . $date->getSeconds();
	}
}
function thx_culture_FormatDate_8(&$buf, &$c, &$culture, &$d, &$date, &$info, &$leadingspace, &$len, &$pattern, &$pos) {
	if($d === 0) {
		return "7";
	} else {
		return "" . $d;
	}
}
function thx_culture_FormatDate_9(&$date, &$v) {
	if($v > 12) {
		return $v - 12;
	} else {
		return $v;
	}
}
