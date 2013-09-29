<?php

class Strings {
	public function __construct(){}
	static $_re;
	static $_reSplitWC;
	static $_reReduceWS;
	static $_reFormat;
	static function format($pattern, $values, $nullstring, $culture) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		if(null === $values || 0 === $values->length) {
			return $pattern;
		}
		return call_user_func_array(Strings::formatf($pattern, $nullstring, $culture), array($values));
	}
	static function formatf($pattern, $nullstring, $culture) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		$buf = new _hx_array(array());
		while(true) {
			if(!Strings::$_reFormat->match($pattern)) {
				$buf->push(array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "Strings_0"), 'execute'));
				break;
			}
			$pos = Std::parseInt(Strings::$_reFormat->matched(1));
			$format = Strings::$_reFormat->matched(2);
			if($format === "") {
				$format = null;
			}
			$p = null;
			$params = new _hx_array(array());
			{
				$_g = 3;
				while($_g < 20) {
					$i = $_g++;
					$p = Strings::$_reFormat->matched($i);
					if($p === null || $p === "") {
						break;
					}
					$params->push(thx_culture_FormatParams::cleanQuotes($p));
					unset($i);
				}
				unset($_g);
			}
			$left = Strings::$_reFormat->matchedLeft();
			$buf->push(array(new _hx_lambda(array(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_1"), 'execute'));
			$df = Dynamics::formatf($format, $params, $nullstring, $culture);
			$buf->push(call_user_func_array((array(new _hx_lambda(array(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_2"), 'execute')), array(array(new _hx_lambda(array(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_3"), 'execute'), $pos)));
			$pattern = Strings::$_reFormat->matchedRight();
			unset($pos,$params,$p,$left,$format,$df);
		}
		return array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "Strings_4"), 'execute');
	}
	static function formatOne($v, $param, $params, $culture) {
		return call_user_func_array(Strings::formatOnef($param, $params, $culture), array($v));
	}
	static function formatOnef($param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "S");
		$format = $params->shift();
		switch($format) {
		case "S":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Strings_5"), 'execute');
		}break;
		case "T":{
			$len = (($params->length < 1) ? 20 : Std::parseInt($params[0]));
			$ellipsis = Strings_6($culture, $format, $len, $param, $params);
			return Strings::ellipsisf($len, $ellipsis);
		}break;
		case "PR":{
			$len = (($params->length < 1) ? 10 : Std::parseInt($params[0]));
			$pad = Strings_7($culture, $format, $len, $param, $params);
			return array(new _hx_lambda(array(&$culture, &$format, &$len, &$pad, &$param, &$params), "Strings_8"), 'execute');
		}break;
		case "PL":{
			$len = (($params->length < 1) ? 10 : Std::parseInt($params[0]));
			$pad = Strings_9($culture, $format, $len, $param, $params);
			return array(new _hx_lambda(array(&$culture, &$format, &$len, &$pad, &$param, &$params), "Strings_10"), 'execute');
		}break;
		default:{
			Strings_11($culture, $format, $param, $params);
		}break;
		}
	}
	static function upTo($value, $searchFor) {
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			return $value;
		} else {
			return _hx_substr($value, 0, $pos);
		}
	}
	static function startFrom($value, $searchFor) {
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			return $value;
		} else {
			return _hx_substr($value, $pos + strlen($searchFor), null);
		}
	}
	static function rtrim($value, $charlist) {
		return rtrim($value, $charlist);
	}
	static function ltrim($value, $charlist) {
		return ltrim($value, $charlist);
	}
	static function trim($value, $charlist) {
		return trim($value, $charlist);
	}
	static $_reCollapse;
	static function collapse($value) {
		return Strings::$_reCollapse->replace(trim($value), " ");
	}
	static function ucfirst($value) {
		return Strings_12($value);
	}
	static function lcfirst($value) {
		return Strings_13($value);
	}
	static function hempty($value) {
		return $value === null || $value === "";
	}
	static function isAlphaNum($value) {
		return ctype_alnum($value);
	}
	static function digitsOnly($value) {
		return ctype_digit($value);
	}
	static function ucwords($value) {
		return Strings::$__ucwordsPattern->customReplace(Strings_14($value), (isset(Strings::$__upperMatch) ? Strings::$__upperMatch: array("Strings", "__upperMatch")));
	}
	static function ucwordsws($value) {
		return ucwords($value);
	}
	static function __upperMatch($re) {
		return strtoupper($re->matched(0));
	}
	static $__ucwordsPattern;
	static function humanize($s) {
		return str_replace("_", " ", Strings::underscore($s));
	}
	static function capitalize($s) {
		return strtoupper(_hx_substr($s, 0, 1)) . _hx_substr($s, 1, null);
	}
	static function succ($s) {
		return _hx_substr($s, 0, -1) . chr(_hx_char_code_at(_hx_substr($s, -1, null), 0) + 1);
	}
	static function underscore($s) {
		$s = _hx_deref(new EReg("::", "g"))->replace($s, "/");
		$s = _hx_deref(new EReg("([A-Z]+)([A-Z][a-z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("([a-z\\d])([A-Z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("-", "g"))->replace($s, "_");
		return strtolower($s);
	}
	static function dasherize($s) {
		return str_replace("_", "-", $s);
	}
	static function repeat($s, $times) {
		$b = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $times) {
				$i = $_g++;
				$b->push($s);
				unset($i);
			}
		}
		return $b->join("");
	}
	static function wrapColumns($s, $columns, $indent, $newline) {
		if($newline === null) {
			$newline = "\x0A";
		}
		if($indent === null) {
			$indent = "";
		}
		if($columns === null) {
			$columns = 78;
		}
		$parts = Strings::$_reSplitWC->split($s);
		$result = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $parts->length) {
				$part = $parts[$_g];
				++$_g;
				$result->push(Strings::_wrapColumns(trim(Strings::$_reReduceWS->replace($part, " ")), $columns, $indent, $newline));
				unset($part);
			}
		}
		return $result->join($newline);
	}
	static function _wrapColumns($s, $columns, $indent, $newline) {
		$parts = new _hx_array(array());
		$pos = 0;
		$len = strlen($s);
		$ilen = strlen($indent);
		$columns -= $ilen;
		while(true) {
			if($pos + $columns >= $len - $ilen) {
				$parts->push(_hx_substr($s, $pos, null));
				break;
			}
			$i = 0;
			while(!StringTools::isSpace($s, $pos + $columns - $i) && $i < $columns) {
				$i++;
			}
			if($i === $columns) {
				$i = 0;
				while(!StringTools::isSpace($s, $pos + $columns + $i) && $pos + $columns + $i < $len) {
					$i++;
				}
				$parts->push(_hx_substr($s, $pos, $columns + $i));
				$pos += $columns + $i + 1;
			} else {
				$parts->push(_hx_substr($s, $pos, $columns - $i));
				$pos += $columns - $i + 1;
			}
			unset($i);
		}
		return $indent . $parts->join($newline . $indent);
	}
	static function stripTags($s) {
		return strip_tags($s);
	}
	static $_reInterpolateNumber;
	static function interpolate($v, $a, $b, $equation) {
		return call_user_func_array(Strings::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation) {
		$extract = array(new _hx_lambda(array(&$a, &$b, &$equation), "Strings_15"), 'execute');
		$decimals = array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract), "Strings_16"), 'execute');
		$sa = new _hx_array(array()); $fa = new _hx_array(array()); $sb = new _hx_array(array()); $fb = new _hx_array(array());
		call_user_func_array($extract, array($a, $sa, $fa));
		call_user_func_array($extract, array($b, $sb, $fb));
		$functions = new _hx_array(array()); $i = 0;
		$min = Strings_17($a, $b, $decimals, $equation, $extract, $fa, $fb, $functions, $i, $sa, $sb);
		while($i < $min) {
			if($sa[$i] !== $sb[$i]) {
				break;
			}
			if(null === $sa[$i]) {
				if($fa[$i] === $fb[$i]) {
					$s = "" . $fa[$i];
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb), "Strings_18"), 'execute'));
					unset($s);
				} else {
					$f = Floats::interpolatef($fa[$i], $fb[$i], $equation);
					$dec = Math::pow(10, Strings_19($a, $b, $decimals, $equation, $extract, $f, $fa, $fb, $functions, $i, $min, $sa, $sb));
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$dec, &$decimals, &$equation, &$extract, &$f, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb), "Strings_20"), 'execute'));
					unset($f,$dec);
				}
			} else {
				$s = $sa[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb), "Strings_21"), 'execute'));
				unset($s);
			}
			$i++;
		}
		$rest = "";
		while($i < $sb->length) {
			if(null !== $sb[$i]) {
				$rest .= $sb[$i];
			} else {
				$rest .= $fb[$i];
			}
			$i++;
		}
		if("" !== $rest) {
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "Strings_22"), 'execute'));
		}
		return array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "Strings_23"), 'execute');
	}
	static function interpolateChars($v, $a, $b, $equation) {
		return call_user_func_array(Strings::interpolateCharsf($a, $b, $equation), array($v));
	}
	static function interpolateCharsf($a, $b, $equation) {
		$aa = _hx_explode("", $a); $ab = _hx_explode("", $b);
		while($aa->length > $ab->length) {
			$ab->insert(0, " ");
		}
		while($ab->length > $aa->length) {
			$aa->insert(0, " ");
		}
		$ai = new _hx_array(array());
		{
			$_g1 = 0; $_g = $aa->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$ai[$i] = Strings::interpolateCharf($aa[$i], $ab[$i], null);
				unset($i);
			}
		}
		return array(new _hx_lambda(array(&$a, &$aa, &$ab, &$ai, &$b, &$equation), "Strings_24"), 'execute');
	}
	static function interpolateChar($v, $a, $b, $equation) {
		return call_user_func_array(Strings::interpolateCharf($a, $b, $equation), array($v));
	}
	static function interpolateCharf($a, $b, $equation) {
		if(_hx_deref(new EReg("^\\d", ""))->match($b) && $a === " ") {
			$a = "0";
		}
		$r = new EReg("^[^a-zA-Z0-9]", "");
		if($r->match($b) && $a === " ") {
			$a = $r->matched(0);
		}
		$ca = _hx_char_code_at($a, 0); $cb = _hx_char_code_at($b, 0); $i = Ints::interpolatef($ca, $cb, $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$ca, &$cb, &$equation, &$i, &$r), "Strings_25"), 'execute');
	}
	static function ellipsis($s, $maxlen, $symbol) {
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		if(strlen($s) > $maxlen) {
			return _hx_substr($s, 0, Strings_26($maxlen, $s, $symbol)) . $symbol;
		} else {
			return $s;
		}
	}
	static function ellipsisf($maxlen, $symbol) {
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		return array(new _hx_lambda(array(&$maxlen, &$symbol), "Strings_27"), 'execute');
	}
	static function compare($a, $b) {
		return (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
	}
	function __toString() { return 'Strings'; }
}
Strings::$_re = new EReg("[{](\\d+)(?::[^}]*)?[}]", "m");
Strings::$_reSplitWC = new EReg("(\x0D\x0A|\x0A\x0D|\x0A|\x0D)", "g");
Strings::$_reReduceWS = new EReg("\\s+", "");
Strings::$_reFormat = new EReg("{(\\d+)(?::([a-zA-Z]+))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?}", "m");
Strings::$_reCollapse = new EReg("\\s+", "g");
Strings::$__ucwordsPattern = new EReg("[^a-zA-Z]([a-z])", "");
Strings::$_reInterpolateNumber = new EReg("[-+]?(?:\\d+\\.\\d+|\\d+\\.|\\.\\d+|\\d+)(?:[eE][-]?\\d+)?", "");
function Strings_0(&$buf, &$culture, &$nullstring, &$pattern, $_) {
	{
		return $pattern;
	}
}
function Strings_1(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $_) {
	{
		return $left;
	}
}
function Strings_2(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $f, $a1) {
	{
		return array(new _hx_lambda(array(&$a1, &$buf, &$culture, &$df, &$f, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_28"), 'execute');
	}
}
function Strings_3(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $i, $v) {
	{
		return call_user_func_array($df, array($v[$i]));
	}
}
function Strings_4(&$buf, &$culture, &$nullstring, &$pattern, $values) {
	{
		if(null === $values) {
			$values = new _hx_array(array());
		}
		return Iterators::map($buf->iterator(), array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern, &$values), "Strings_29"), 'execute'))->join("");
	}
}
function Strings_5(&$culture, &$format, &$param, &$params, $v) {
	{
		return $v;
	}
}
function Strings_6(&$culture, &$format, &$len, &$param, &$params) {
	if($params->length < 2) {
		return "...";
	} else {
		return $params[1];
	}
}
function Strings_7(&$culture, &$format, &$len, &$param, &$params) {
	if($params->length < 2) {
		return " ";
	} else {
		return $params[1];
	}
}
function Strings_8(&$culture, &$format, &$len, &$pad, &$param, &$params, $v) {
	{
		return str_pad($v, $len, $pad, STR_PAD_RIGHT);
	}
}
function Strings_9(&$culture, &$format, &$len, &$param, &$params) {
	if($params->length < 2) {
		return " ";
	} else {
		return $params[1];
	}
}
function Strings_10(&$culture, &$format, &$len, &$pad, &$param, &$params, $v) {
	{
		return str_pad($v, $len, $pad, STR_PAD_LEFT);
	}
}
function Strings_11(&$culture, &$format, &$param, &$params) {
	throw new HException("Unsupported string format: " . $format);
}
function Strings_12(&$value) {
	if($value === null) {
		return null;
	} else {
		return strtoupper(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
	}
}
function Strings_13(&$value) {
	if($value === null) {
		return null;
	} else {
		return strtolower(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
	}
}
function Strings_14(&$value) {
	if($value === null) {
		return null;
	} else {
		return strtoupper(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
	}
}
function Strings_15(&$a, &$b, &$equation, $value, $s, $f) {
	{
		while(Strings::$_reInterpolateNumber->match($value)) {
			$left = Strings::$_reInterpolateNumber->matchedLeft();
			if(!Strings::hempty($left)) {
				$s->push($left);
				$f->push(null);
			}
			$s->push(null);
			$f->push(Std::parseFloat(Strings::$_reInterpolateNumber->matched(0)));
			$value = Strings::$_reInterpolateNumber->matchedRight();
			unset($left);
		}
		if(!Strings::hempty($value)) {
			$s->push($value);
			$f->push(null);
		}
	}
}
function Strings_16(&$a, &$b, &$equation, &$extract, $v) {
	{
		$s = "" . $v; $p = _hx_index_of($s, ".", null);
		if($p < 0) {
			return 0;
		}
		return strlen($s) - $p - 1;
	}
}
function Strings_17(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$sa, &$sb) {
	{
		$a1 = $sa->length; $b1 = $sb->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Strings_18(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb, $_) {
	{
		return $s;
	}
}
function Strings_19(&$a, &$b, &$decimals, &$equation, &$extract, &$f, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb) {
	{
		$a1 = call_user_func_array($decimals, array($fa[$i])); $b1 = call_user_func_array($decimals, array($fb[$i]));
		if($a1 > $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Strings_20(&$a, &$b, &$dec, &$decimals, &$equation, &$extract, &$f, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb, $t) {
	{
		return "" . Math::round(call_user_func_array($f, array($t)) * $dec) / $dec;
	}
}
function Strings_21(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb, $_) {
	{
		return $s;
	}
}
function Strings_22(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $_) {
	{
		return $rest;
	}
}
function Strings_23(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t), "Strings_30"), 'execute'))->join("");
	}
}
function Strings_24(&$a, &$aa, &$ab, &$ai, &$b, &$equation, $v) {
	{
		$r = new _hx_array(array());
		{
			$_g1 = 0; $_g = $ai->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r[$i] = call_user_func_array($ai[$i], array($v));
				unset($i);
			}
		}
		return trim($r->join(""));
	}
}
function Strings_25(&$a, &$b, &$ca, &$cb, &$equation, &$i, &$r, $v) {
	{
		return chr(call_user_func_array($i, array($v)));
	}
}
function Strings_26(&$maxlen, &$s, &$symbol) {
	{
		$a = strlen($symbol); $b = $maxlen - strlen($symbol);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($b,$a);
	}
}
function Strings_27(&$maxlen, &$symbol, $s) {
	{
		if(strlen($s) > $maxlen) {
			return _hx_substr($s, 0, Strings_31($maxlen, $s, $symbol)) . $symbol;
		} else {
			return $s;
		}
	}
}
function Strings_28(&$a1, &$buf, &$culture, &$df, &$f, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $a2) {
	{
		return call_user_func_array($f, array($a1, $a2));
	}
}
function Strings_29(&$buf, &$culture, &$nullstring, &$pattern, &$values, $df, $_) {
	{
		return call_user_func_array($df, array($values));
	}
}
function Strings_30(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Strings_31(&$maxlen, &$s, &$symbol) {
	{
		$a = strlen($symbol); $b = $maxlen - strlen($symbol);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($b,$a);
	}
}
