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
				{
					$x = $c;
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$buf->b .= $x;
					unset($x);
				}
				$pos++;
				continue;
			}
			$pos++;
			$c = _hx_char_at($pattern, $pos);
			switch($c) {
			case "a":{
				$x = $info->abbrDays[$date->getDay()];
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "A":{
				$x = $info->days[$date->getDay()];
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "b":case "h":{
				$x = $info->abbrMonths[$date->getMonth()];
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "B":{
				$x = $info->months[$date->getMonth()];
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "c":{
				$x = thx_culture_FormatDate::dateTime($date, $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "C":{
				$x = thx_culture_FormatNumber::digits("" . Math::floor($date->getFullYear() / 100), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "d":{
				$x = thx_culture_FormatNumber::digits(str_pad("" . $date->getDate(), 2, "0", STR_PAD_LEFT), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "D":{
				$x = thx_culture_FormatDate::format("%m/%d/%y", $date, $culture, null);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "e":{
				$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_0($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "f":{
				$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_1($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "G":{
				throw new HException("Not Implemented Yet");
			}break;
			case "g":{
				throw new HException("Not Implemented Yet");
			}break;
			case "H":{
				$x = thx_culture_FormatNumber::digits(str_pad("" . $date->getHours(), 2, "0", STR_PAD_LEFT), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "i":{
				$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_2($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "I":{
				$x = thx_culture_FormatNumber::digits(str_pad("" . thx_culture_FormatDate::getMHours($date), 2, "0", STR_PAD_LEFT), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "j":{
				throw new HException("Not Implemented Yet");
			}break;
			case "k":{
				$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_3($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "l":{
				$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_4($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "m":{
				$x = thx_culture_FormatNumber::digits(str_pad("" . ($date->getMonth() + 1), 2, "0", STR_PAD_LEFT), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "M":{
				$x = thx_culture_FormatNumber::digits(str_pad("" . $date->getMinutes(), 2, "0", STR_PAD_LEFT), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "n":{
				$x = "\x0A";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "p":{
				$x = thx_culture_FormatDate_5($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "P":{
				$x = strtolower((thx_culture_FormatDate_6($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos)));
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "q":{
				$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_7($buf, $c, $culture, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "r":{
				$x = thx_culture_FormatDate::format("%I:%M:%S %p", $date, $culture, null);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "R":{
				$x = thx_culture_FormatDate::format("%H:%M", $date, $culture, null);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "s":{
				$x = "" . intval($date->getTime() / 1000);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "S":{
				$x = thx_culture_FormatNumber::digits(str_pad("" . $date->getSeconds(), 2, "0", STR_PAD_LEFT), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "t":{
				$x = "\x09";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "T":{
				$x = thx_culture_FormatDate::format("%H:%M:%S", $date, $culture, null);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "u":{
				$d = $date->getDay();
				{
					$x = thx_culture_FormatNumber::digits(thx_culture_FormatDate_8($buf, $c, $culture, $d, $date, $info, $leadingspace, $len, $pattern, $pos), $culture);
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$buf->b .= $x;
				}
			}break;
			case "U":{
				throw new HException("Not Implemented Yet");
			}break;
			case "V":{
				throw new HException("Not Implemented Yet");
			}break;
			case "w":{
				$x = thx_culture_FormatNumber::digits("" . $date->getDay(), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "W":{
				throw new HException("Not Implemented Yet");
			}break;
			case "x":{
				$x = thx_culture_FormatDate::date($date, $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "X":{
				$x = thx_culture_FormatDate::time($date, $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "y":{
				$x = thx_culture_FormatNumber::digits(_hx_substr(("" . $date->getFullYear()), -2, null), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "Y":{
				$x = thx_culture_FormatNumber::digits("" . $date->getFullYear(), $culture);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "z":{
				$x = "+0000";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "Z":{
				$x = "GMT";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			case "%":{
				$x = "%";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
			}break;
			default:{
				$x = "%" . $c;
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
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
