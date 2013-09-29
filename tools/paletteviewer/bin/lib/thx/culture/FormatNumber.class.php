<?php

class thx_culture_FormatNumber {
	public function __construct(){}
	static function decimal($v, $decimals, $culture) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::decimal");
		$»spos = $GLOBALS['%s']->length;
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		{
			$»tmp = thx_culture_FormatNumber::crunch($v, $decimals, $culture->percent, $culture->number->patternNegative, $culture->number->patternPositive, $culture, null, null);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function percent($v, $decimals, $culture) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::percent");
		$»spos = $GLOBALS['%s']->length;
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		{
			$»tmp = thx_culture_FormatNumber::crunch($v, $decimals, $culture->percent, $culture->percent->patternNegative, $culture->percent->patternPositive, $culture, "%", $culture->symbolPercent);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function permille($v, $decimals, $culture) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::permille");
		$»spos = $GLOBALS['%s']->length;
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		{
			$»tmp = thx_culture_FormatNumber::crunch($v, $decimals, $culture->percent, $culture->percent->patternNegative, $culture->percent->patternPositive, $culture, "%", $culture->symbolPermille);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function currency($v, $symbol, $decimals, $culture) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::currency");
		$»spos = $GLOBALS['%s']->length;
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		{
			$»tmp = thx_culture_FormatNumber::crunch($v, $decimals, $culture->currency, $culture->currency->patternNegative, $culture->currency->patternPositive, $culture, "\$", thx_culture_FormatNumber_0($culture, $decimals, $symbol, $v));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function int($v, $culture) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::int");
		$»spos = $GLOBALS['%s']->length;
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		{
			$»tmp = thx_culture_FormatNumber::decimal($v, 0, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function digits($v, $culture) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::digits");
		$»spos = $GLOBALS['%s']->length;
		if(null === $culture) {
			$culture = thx_culture_Culture::getDefaultCulture();
		}
		{
			$»tmp = thx_culture_FormatNumber::processDigits($v, $culture->digits);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function crunch($v, $decimals, $info, $negative, $positive, $culture, $symbol, $replace) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::crunch");
		$»spos = $GLOBALS['%s']->length;
		if(Math::isNaN($v)) {
			$»tmp = $culture->symbolNaN;
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			if(!Math::isFinite($v)) {
				$»tmp = thx_culture_FormatNumber_1($culture, $decimals, $info, $negative, $positive, $replace, $symbol, $v);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}
		$fv = thx_culture_FormatNumber::value($v, $info, thx_culture_FormatNumber_2($culture, $decimals, $info, $negative, $positive, $replace, $symbol, $v), $culture->digits);
		if($symbol !== null) {
			$»tmp = str_replace($symbol, $replace, str_replace("n", $fv, (($v < 0) ? $negative : $positive)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = str_replace("n", $fv, (($v < 0) ? $negative : $positive));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function processDigits($s, $digits) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::processDigits");
		$»spos = $GLOBALS['%s']->length;
		if($digits === null) {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$o = new _hx_array(array());
		{
			$_g1 = 0; $_g = strlen($s);
			while($_g1 < $_g) {
				$i = $_g1++;
				$o->push($digits[Std::parseInt(_hx_substr($s, $i, 1))]);
				unset($i);
			}
		}
		{
			$»tmp = $o->join("");
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function value($v, $info, $decimals, $digits) {
		$GLOBALS['%s']->push("thx.culture.FormatNumber::value");
		$»spos = $GLOBALS['%s']->length;
		$fv = "" . Math::abs($v);
		$pos = _hx_index_of($fv, "E", null);
		if($pos > 0) {
			$e = Std::parseInt(_hx_substr($fv, $pos + 1, null));
			$ispos = true;
			if($e < 0) {
				$ispos = false;
				$e = -$e;
			}
			$s = str_replace(".", "", _hx_substr($fv, 0, $pos));
			if($ispos) {
				$fv = str_pad($s, $e + 1, "0", STR_PAD_RIGHT);
			} else {
				$fv = "0" . str_pad(".", $e, "0", STR_PAD_RIGHT) . $s;
			}
		}
		$parts = _hx_explode(".", $fv);
		$temp = $parts[0];
		$intparts = new _hx_array(array());
		$group = 0;
		while(true) {
			if(strlen($temp) === 0) {
				break;
			}
			$len = $info->groups[$group];
			if(strlen($temp) <= $len) {
				$intparts->unshift(thx_culture_FormatNumber::processDigits($temp, $digits));
				break;
			}
			$intparts->unshift(thx_culture_FormatNumber::processDigits(_hx_substr($temp, -$len, null), $digits));
			$temp = _hx_substr($temp, 0, -$len);
			if($group < $info->groups->length - 1) {
				$group++;
			}
			unset($len);
		}
		$intpart = $intparts->join($info->groupsSeparator);
		if($decimals > 0) {
			$decpart = (($parts->length === 1) ? str_pad("", $decimals, "0", STR_PAD_LEFT) : ((strlen($parts[1]) > $decimals) ? _hx_substr($parts[1], 0, $decimals) : str_pad($parts[1], $decimals, "0", STR_PAD_RIGHT)));
			{
				$»tmp = $intpart . $info->decimalsSeparator . thx_culture_FormatNumber::processDigits($decpart, $digits);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		} else {
			$GLOBALS['%s']->pop();
			return $intpart;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.culture.FormatNumber'; }
}
function thx_culture_FormatNumber_0(&$culture, &$decimals, &$symbol, &$v) {
	$»spos = $GLOBALS['%s']->length;
	if($symbol === null) {
		return $culture->currencySymbol;
	} else {
		return $symbol;
	}
}
function thx_culture_FormatNumber_1(&$culture, &$decimals, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	$»spos = $GLOBALS['%s']->length;
	if($v === Math::$NEGATIVE_INFINITY) {
		return $culture->symbolNegInf;
	} else {
		return $culture->symbolPosInf;
	}
}
function thx_culture_FormatNumber_2(&$culture, &$decimals, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	$»spos = $GLOBALS['%s']->length;
	if($decimals === null) {
		return $info->decimals;
	} else {
		if($decimals < 0) {
			return 0;
		} else {
			return $decimals;
		}
	}
}
