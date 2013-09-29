<?php

class Strings {
	public function __construct(){}
	static $_re;
	static $_reSplitWC;
	static $_reReduceWS;
	static $_reFormat;
	static function format($pattern, $values, $nullstring, $culture) {
		$GLOBALS['%s']->push("Strings::format");
		$製pos = $GLOBALS['%s']->length;
		if($nullstring === null) {
			$nullstring = "null";
		}
		if(null === $values || 0 === $values->length) {
			$GLOBALS['%s']->pop();
			return $pattern;
		}
		{
			$裨mp = call_user_func_array(Strings::formatf($pattern, $nullstring, $culture), array($values));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($pattern, $nullstring, $culture) {
		$GLOBALS['%s']->push("Strings::formatf");
		$製pos = $GLOBALS['%s']->length;
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
		{
			$裨mp = array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "Strings_4"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatOne($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Strings::formatOne");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Strings::formatOnef($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatOnef($param, $params, $culture) {
		$GLOBALS['%s']->push("Strings::formatOnef");
		$製pos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "S");
		$format = $params->shift();
		switch($format) {
		case "S":{
			$裨mp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Strings_5"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		case "T":{
			$len = (($params->length < 1) ? 20 : Std::parseInt($params[0]));
			$ellipsis = Strings_6($culture, $format, $len, $param, $params);
			{
				$裨mp = Strings::ellipsisf($len, $ellipsis);
				$GLOBALS['%s']->pop();
				return $裨mp;
			}
		}break;
		case "PR":{
			$len = (($params->length < 1) ? 10 : Std::parseInt($params[0]));
			$pad = Strings_7($culture, $format, $len, $param, $params);
			{
				$裨mp = array(new _hx_lambda(array(&$culture, &$format, &$len, &$pad, &$param, &$params), "Strings_8"), 'execute');
				$GLOBALS['%s']->pop();
				return $裨mp;
			}
		}break;
		case "PL":{
			$len = (($params->length < 1) ? 10 : Std::parseInt($params[0]));
			$pad = Strings_9($culture, $format, $len, $param, $params);
			{
				$裨mp = array(new _hx_lambda(array(&$culture, &$format, &$len, &$pad, &$param, &$params), "Strings_10"), 'execute');
				$GLOBALS['%s']->pop();
				return $裨mp;
			}
		}break;
		default:{
			$裨mp = Strings_11($culture, $format, $param, $params);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function upTo($value, $searchFor) {
		$GLOBALS['%s']->push("Strings::upTo");
		$製pos = $GLOBALS['%s']->length;
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			$GLOBALS['%s']->pop();
			return $value;
		} else {
			$裨mp = _hx_substr($value, 0, $pos);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function startFrom($value, $searchFor) {
		$GLOBALS['%s']->push("Strings::startFrom");
		$製pos = $GLOBALS['%s']->length;
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			$GLOBALS['%s']->pop();
			return $value;
		} else {
			$裨mp = _hx_substr($value, $pos + strlen($searchFor), null);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function rtrim($value, $charlist) {
		$GLOBALS['%s']->push("Strings::rtrim");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = rtrim($value, $charlist);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ltrim($value, $charlist) {
		$GLOBALS['%s']->push("Strings::ltrim");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = ltrim($value, $charlist);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function trim($value, $charlist) {
		$GLOBALS['%s']->push("Strings::trim");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = trim($value, $charlist);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reCollapse;
	static function collapse($value) {
		$GLOBALS['%s']->push("Strings::collapse");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Strings::$_reCollapse->replace(trim($value), " ");
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ucfirst($value) {
		$GLOBALS['%s']->push("Strings::ucfirst");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Strings_12($value);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function lcfirst($value) {
		$GLOBALS['%s']->push("Strings::lcfirst");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Strings_13($value);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function hempty($value) {
		$GLOBALS['%s']->push("Strings::empty");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = $value === null || $value === "";
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function isAlphaNum($value) {
		$GLOBALS['%s']->push("Strings::isAlphaNum");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = ctype_alnum($value);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function digitsOnly($value) {
		$GLOBALS['%s']->push("Strings::digitsOnly");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = ctype_digit($value);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ucwords($value) {
		$GLOBALS['%s']->push("Strings::ucwords");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = Strings::$__ucwordsPattern->customReplace(Strings_14($value), (isset(Strings::$__upperMatch) ? Strings::$__upperMatch: array("Strings", "__upperMatch")));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ucwordsws($value) {
		$GLOBALS['%s']->push("Strings::ucwordsws");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = ucwords($value);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function __upperMatch($re) {
		$GLOBALS['%s']->push("Strings::__upperMatch");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = strtoupper($re->matched(0));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static $__ucwordsPattern;
	static function humanize($s) {
		$GLOBALS['%s']->push("Strings::humanize");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = str_replace("_", " ", Strings::underscore($s));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function capitalize($s) {
		$GLOBALS['%s']->push("Strings::capitalize");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = strtoupper(_hx_substr($s, 0, 1)) . _hx_substr($s, 1, null);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function succ($s) {
		$GLOBALS['%s']->push("Strings::succ");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = _hx_substr($s, 0, -1) . chr(_hx_char_code_at(_hx_substr($s, -1, null), 0) + 1);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function underscore($s) {
		$GLOBALS['%s']->push("Strings::underscore");
		$製pos = $GLOBALS['%s']->length;
		$s = _hx_deref(new EReg("::", "g"))->replace($s, "/");
		$s = _hx_deref(new EReg("([A-Z]+)([A-Z][a-z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("([a-z\\d])([A-Z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("-", "g"))->replace($s, "_");
		{
			$裨mp = strtolower($s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function dasherize($s) {
		$GLOBALS['%s']->push("Strings::dasherize");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = str_replace("_", "-", $s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function repeat($s, $times) {
		$GLOBALS['%s']->push("Strings::repeat");
		$製pos = $GLOBALS['%s']->length;
		$b = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $times) {
				$i = $_g++;
				$b->push($s);
				unset($i);
			}
		}
		{
			$裨mp = $b->join("");
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function wrapColumns($s, $columns, $indent, $newline) {
		$GLOBALS['%s']->push("Strings::wrapColumns");
		$製pos = $GLOBALS['%s']->length;
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
		{
			$裨mp = $result->join($newline);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function _wrapColumns($s, $columns, $indent, $newline) {
		$GLOBALS['%s']->push("Strings::_wrapColumns");
		$製pos = $GLOBALS['%s']->length;
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
		{
			$裨mp = $indent . $parts->join($newline . $indent);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function stripTags($s) {
		$GLOBALS['%s']->push("Strings::stripTags");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = strip_tags($s);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reInterpolateNumber;
	static function interpolate($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Strings::interpolate");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Strings::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Strings::interpolatef");
		$製pos = $GLOBALS['%s']->length;
		$extract = array(new _hx_lambda(array(&$a, &$b, &$equation), "Strings_15"), 'execute');
		$sa = new _hx_array(array()); $fa = new _hx_array(array()); $sb = new _hx_array(array()); $fb = new _hx_array(array());
		call_user_func_array($extract, array($a, $sa, $fa));
		call_user_func_array($extract, array($b, $sb, $fb));
		$functions = new _hx_array(array()); $i = 0;
		$min = Strings_16($a, $b, $equation, $extract, $fa, $fb, $functions, $i, $sa, $sb);
		while($i < $min) {
			if($sa[$i] !== $sb[$i]) {
				break;
			}
			if(null === $sa[$i]) {
				if($fa[$i] === $fb[$i]) {
					$s = "" . $fa[$i];
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb), "Strings_17"), 'execute'));
					unset($s);
				} else {
					$f = Floats::interpolatef($fa[$i], $fb[$i], $equation);
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract, &$f, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb), "Strings_18"), 'execute'));
					unset($f);
				}
			} else {
				$s = $sa[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb), "Strings_19"), 'execute'));
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
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "Strings_20"), 'execute'));
		}
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "Strings_21"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateChars($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Strings::interpolateChars");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Strings::interpolateCharsf($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateCharsf($a, $b, $equation) {
		$GLOBALS['%s']->push("Strings::interpolateCharsf");
		$製pos = $GLOBALS['%s']->length;
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
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$aa, &$ab, &$ai, &$b, &$equation), "Strings_22"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateChar($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Strings::interpolateChar");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array(Strings::interpolateCharf($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateCharf($a, $b, $equation) {
		$GLOBALS['%s']->push("Strings::interpolateCharf");
		$製pos = $GLOBALS['%s']->length;
		$ca = _hx_char_code_at($a, 0); $cb = _hx_char_code_at($b, 0); $i = Ints::interpolatef($ca, $cb, $equation);
		{
			$裨mp = array(new _hx_lambda(array(&$a, &$b, &$ca, &$cb, &$equation, &$i), "Strings_23"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function ellipsis($s, $maxlen, $symbol) {
		$GLOBALS['%s']->push("Strings::ellipsis");
		$製pos = $GLOBALS['%s']->length;
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		if(strlen($s) > $maxlen) {
			$裨mp = _hx_substr($s, 0, Strings_24($maxlen, $s, $symbol)) . $symbol;
			$GLOBALS['%s']->pop();
			return $裨mp;
		} else {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	static function ellipsisf($maxlen, $symbol) {
		$GLOBALS['%s']->push("Strings::ellipsisf");
		$製pos = $GLOBALS['%s']->length;
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		{
			$裨mp = array(new _hx_lambda(array(&$maxlen, &$symbol), "Strings_25"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Strings::compare");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
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
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatf@122");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $pattern;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_1(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatf@140");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $left;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_2(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $f, $a1) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatf@142");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = array(new _hx_lambda(array(&$a1, &$buf, &$culture, &$df, &$f, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_26"), 'execute');
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_3(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $i, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatf@142");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array($df, array($v[$i]));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_4(&$buf, &$culture, &$nullstring, &$pattern, $values) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatf@145");
		$製pos2 = $GLOBALS['%s']->length;
		if(null === $values) {
			$values = new _hx_array(array());
		}
		{
			$裨mp = Iterators::map($buf->iterator(), array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern, &$values), "Strings_27"), 'execute'))->join("");
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_5(&$culture, &$format, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatOnef@165");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_6(&$culture, &$format, &$len, &$param, &$params) {
	$製pos = $GLOBALS['%s']->length;
	if($params->length < 2) {
		return "...";
	} else {
		return $params[1];
	}
}
function Strings_7(&$culture, &$format, &$len, &$param, &$params) {
	$製pos = $GLOBALS['%s']->length;
	if($params->length < 2) {
		return " ";
	} else {
		return $params[1];
	}
}
function Strings_8(&$culture, &$format, &$len, &$pad, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatOnef@173");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = str_pad($v, $len, $pad, STR_PAD_RIGHT);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_9(&$culture, &$format, &$len, &$param, &$params) {
	$製pos = $GLOBALS['%s']->length;
	if($params->length < 2) {
		return " ";
	} else {
		return $params[1];
	}
}
function Strings_10(&$culture, &$format, &$len, &$pad, &$param, &$params, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::formatOnef@177");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = str_pad($v, $len, $pad, STR_PAD_LEFT);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_11(&$culture, &$format, &$param, &$params) {
	$製pos = $GLOBALS['%s']->length;
	throw new HException("Unsupported string format: " . $format);
}
function Strings_12(&$value) {
	$製pos = $GLOBALS['%s']->length;
	if($value === null) {
		return null;
	} else {
		return strtoupper(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
	}
}
function Strings_13(&$value) {
	$製pos = $GLOBALS['%s']->length;
	if($value === null) {
		return null;
	} else {
		return strtolower(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
	}
}
function Strings_14(&$value) {
	$製pos = $GLOBALS['%s']->length;
	if($value === null) {
		return null;
	} else {
		return strtoupper(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
	}
}
function Strings_15(&$a, &$b, &$equation, $value, $s, $f) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolatef@428");
		$製pos2 = $GLOBALS['%s']->length;
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
		$GLOBALS['%s']->pop();
	}
}
function Strings_16(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$sa, &$sb) {
	$製pos = $GLOBALS['%s']->length;
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
function Strings_17(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolatef@466");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_18(&$a, &$b, &$equation, &$extract, &$f, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb, $t) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolatef@469");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = "" . call_user_func_array($f, array($t));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_19(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s, &$sa, &$sb, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolatef@473");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_20(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolatef@487");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $rest;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_21(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $t) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolatef@488");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t), "Strings_28"), 'execute'))->join("");
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_22(&$a, &$aa, &$ab, &$ai, &$b, &$equation, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolateCharsf@509");
		$製pos2 = $GLOBALS['%s']->length;
		$r = new _hx_array(array());
		{
			$_g1 = 0; $_g = $ai->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r[$i] = call_user_func_array($ai[$i], array($v));
				unset($i);
			}
		}
		{
			$裨mp = trim($r->join(""));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_23(&$a, &$b, &$ca, &$cb, &$equation, &$i, $v) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::interpolateCharf@528");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = chr(call_user_func_array($i, array($v)));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_24(&$maxlen, &$s, &$symbol) {
	$製pos = $GLOBALS['%s']->length;
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
function Strings_25(&$maxlen, &$symbol, $s) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::ellipsisf@541");
		$製pos2 = $GLOBALS['%s']->length;
		if(strlen($s) > $maxlen) {
			$裨mp = _hx_substr($s, 0, Strings_29($maxlen, $s, $symbol)) . $symbol;
			$GLOBALS['%s']->pop();
			return $裨mp;
		} else {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_26(&$a1, &$buf, &$culture, &$df, &$f, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $a2) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::compare@142");
		$製pos3 = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array($f, array($a1, $a2));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_27(&$buf, &$culture, &$nullstring, &$pattern, &$values, $df, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::compare@149");
		$製pos3 = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array($df, array($values));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_28(&$a, &$b, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t, $f, $_) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Strings::compare@489");
		$製pos3 = $GLOBALS['%s']->length;
		{
			$裨mp = call_user_func_array($f, array($t));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Strings_29(&$maxlen, &$s, &$symbol) {
	$製pos = $GLOBALS['%s']->length;
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
