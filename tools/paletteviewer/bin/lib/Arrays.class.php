<?php

class Arrays {
	public function __construct(){}
	static function addIf($arr, $condition, $value) {
		$GLOBALS['%s']->push("Arrays::addIf");
		$�spos = $GLOBALS['%s']->length;
		if(null !== $condition) {
			if($condition) {
				$arr->push($value);
			}
		} else {
			if(null !== $value) {
				$arr->push($value);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function add($arr, $value) {
		$GLOBALS['%s']->push("Arrays::add");
		$�spos = $GLOBALS['%s']->length;
		$arr->push($value);
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function delete($arr, $value) {
		$GLOBALS['%s']->push("Arrays::delete");
		$�spos = $GLOBALS['%s']->length;
		$arr->remove($value);
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function filter($arr, $f) {
		$GLOBALS['%s']->push("Arrays::filter");
		$�spos = $GLOBALS['%s']->length;
		$result = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $arr->length) {
				$i = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($i))) {
					$result->push($i);
				}
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $result;
		}
		$GLOBALS['%s']->pop();
	}
	static function min($arr, $f) {
		$GLOBALS['%s']->push("Arrays::min");
		$�spos = $GLOBALS['%s']->length;
		if($arr->length === 0) {
			$GLOBALS['%s']->pop();
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(Reflect::compare($a, $arr[$i]) > 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			{
				$�tmp = $arr[$p];
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		} else {
			$a = call_user_func_array($f, array($arr[0])); $p = 0; $b = null;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
						$a = $b;
						$p = $i;
					}
					unset($i);
				}
			}
			{
				$�tmp = $arr[$p];
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function floatMin($arr, $f) {
		$GLOBALS['%s']->push("Arrays::floatMin");
		$�spos = $GLOBALS['%s']->length;
		if($arr->length === 0) {
			$�tmp = Math::$NaN;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$a = call_user_func_array($f, array($arr[0])); $b = null;
		{
			$_g1 = 1; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $a;
		}
		$GLOBALS['%s']->pop();
	}
	static function max($arr, $f) {
		$GLOBALS['%s']->push("Arrays::max");
		$�spos = $GLOBALS['%s']->length;
		if($arr->length === 0) {
			$GLOBALS['%s']->pop();
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(Reflect::compare($a, $arr[$i]) < 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			{
				$�tmp = $arr[$p];
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		} else {
			$a = call_user_func_array($f, array($arr[0])); $p = 0; $b = null;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if($a < ($b = call_user_func_array($f, array($arr[$i])))) {
						$a = $b;
						$p = $i;
					}
					unset($i);
				}
			}
			{
				$�tmp = $arr[$p];
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function floatMax($arr, $f) {
		$GLOBALS['%s']->push("Arrays::floatMax");
		$�spos = $GLOBALS['%s']->length;
		if($arr->length === 0) {
			$�tmp = Math::$NaN;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$a = call_user_func_array($f, array($arr[0])); $b = null;
		{
			$_g1 = 1; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a < ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $a;
		}
		$GLOBALS['%s']->pop();
	}
	static function flatten($arr) {
		$GLOBALS['%s']->push("Arrays::flatten");
		$�spos = $GLOBALS['%s']->length;
		$r = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				$r = $r->concat($v);
				unset($v);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $r;
		}
		$GLOBALS['%s']->pop();
	}
	static function map($arr, $f) {
		$GLOBALS['%s']->push("Arrays::map");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::map($arr->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function reduce($arr, $f, $initialValue) {
		$GLOBALS['%s']->push("Arrays::reduce");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::reduce($arr->iterator(), $f, $initialValue);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function order($arr, $f) {
		$GLOBALS['%s']->push("Arrays::order");
		$�spos = $GLOBALS['%s']->length;
		$arr->sort(Arrays_0($arr, $f));
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function orderMultiple($arr, $f, $rest) {
		$GLOBALS['%s']->push("Arrays::orderMultiple");
		$�spos = $GLOBALS['%s']->length;
		$swap = true; $t = null;
		$rest->remove($arr);
		while($swap) {
			$swap = false;
			{
				$_g1 = 0; $_g = $arr->length - 1;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(call_user_func_array($f, array($arr[$i], $arr[$i + 1])) > 0) {
						$swap = true;
						$t = $arr[$i];
						$arr[$i] = $arr[$i + 1];
						$arr[$i + 1] = $t;
						{
							$_g2 = 0;
							while($_g2 < $rest->length) {
								$a = $rest[$_g2];
								++$_g2;
								$t = $a[$i];
								$a[$i] = $a[$i + 1];
								$a[$i + 1] = $t;
								unset($a);
							}
							unset($_g2);
						}
					}
					unset($i);
				}
				unset($_g1,$_g);
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function split($arr, $f) {
		$GLOBALS['%s']->push("Arrays::split");
		$�spos = $GLOBALS['%s']->length;
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$arr, &$f), "Arrays_1"), 'execute');
		}
		$arrays = new _hx_array(array()); $i = -1; $values = new _hx_array(array()); $value = null;
		{
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				if(call_user_func_array($f, array($value = $arr[$i1], $i1))) {
					$values = new _hx_array(array());
				} else {
					if($values->length === 0) {
						$arrays->push($values);
					}
					$values->push($value);
				}
				unset($i1);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $arrays;
		}
		$GLOBALS['%s']->pop();
	}
	static function exists($arr, $value, $f) {
		$GLOBALS['%s']->push("Arrays::exists");
		$�spos = $GLOBALS['%s']->length;
		if(null !== $f) {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					$GLOBALS['%s']->pop();
					return true;
				}
				unset($v);
			}
		} else {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if($v === $value) {
					$GLOBALS['%s']->pop();
					return true;
				}
				unset($v);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Arrays::format");
		$�spos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			if($v->length === 0) {
				$empty = Arrays_2($culture, $format, $param, $params, $v);
				{
					$GLOBALS['%s']->pop();
					return $empty;
				}
			}
			$sep = Arrays_3($culture, $format, $param, $params, $v);
			$max = (($params[3] === null) ? null : (("" === $params[3]) ? null : Std::parseInt($params[3])));
			if(null !== $max && $max < $v->length) {
				$elipsis = Arrays_4($culture, $format, $max, $param, $params, $sep, $v);
				{
					$�tmp = Iterators::map($v->copy()->splice(0, $max)->iterator(), array(new _hx_lambda(array(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_5"), 'execute'))->join($sep) . $elipsis;
					$GLOBALS['%s']->pop();
					return $�tmp;
				}
			} else {
				$�tmp = Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_6"), 'execute'))->join($sep);
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case "C":{
			$�tmp = Ints::format($v->length, "I", new _hx_array(array()), $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		default:{
			throw new HException("Unsupported array format: " . $format);
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Arrays::formatf");
		$�spos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Arrays_7"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "C":{
			$f = Ints::formatf("I", new _hx_array(array()), $culture);
			{
				$�tmp = array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Arrays_8"), 'execute');
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		default:{
			throw new HException("Unsupported array format: " . $format);
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Arrays::interpolate");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Arrays::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Arrays::interpolatef");
		$�spos = $GLOBALS['%s']->length;
		$functions = new _hx_array(array()); $i = 0; $min = Arrays_9($a, $b, $equation, $functions, $i);
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_10"), 'execute'));
				unset($v);
			} else {
				$functions->push(Floats::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_11"), 'execute'));
			$i++;
			unset($v);
		}
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_12"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateStrings($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Arrays::interpolateStrings");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Arrays::interpolateStringsf($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateStringsf($a, $b, $equation) {
		$GLOBALS['%s']->push("Arrays::interpolateStringsf");
		$�spos = $GLOBALS['%s']->length;
		$functions = new _hx_array(array()); $i = 0; $min = Arrays_13($a, $b, $equation, $functions, $i);
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_14"), 'execute'));
				unset($v);
			} else {
				$functions->push(Strings::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_15"), 'execute'));
			$i++;
			unset($v);
		}
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_16"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateInts($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Arrays::interpolateInts");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Arrays::interpolateIntsf($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolateIntsf($a, $b, $equation) {
		$GLOBALS['%s']->push("Arrays::interpolateIntsf");
		$�spos = $GLOBALS['%s']->length;
		$functions = new _hx_array(array()); $i = 0; $min = Arrays_17($a, $b, $equation, $functions, $i);
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_18"), 'execute'));
				unset($v);
			} else {
				$functions->push(Ints::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_19"), 'execute'));
			$i++;
			unset($v);
		}
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_20"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function indexOf($arr, $el) {
		$GLOBALS['%s']->push("Arrays::indexOf");
		$�spos = $GLOBALS['%s']->length;
		$len = $arr->length;
		{
			$_g = 0;
			while($_g < $len) {
				$i = $_g++;
				if($arr[$i] === $el) {
					$GLOBALS['%s']->pop();
					return $i;
				}
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return -1;
		}
		$GLOBALS['%s']->pop();
	}
	static function every($arr, $f) {
		$GLOBALS['%s']->push("Arrays::every");
		$�spos = $GLOBALS['%s']->length;
		{
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(!call_user_func_array($f, array($arr[$i], $i))) {
					$GLOBALS['%s']->pop();
					return false;
				}
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	static function each($arr, $f) {
		$GLOBALS['%s']->push("Arrays::each");
		$�spos = $GLOBALS['%s']->length;
		$_g1 = 0; $_g = $arr->length;
		while($_g1 < $_g) {
			$i = $_g1++;
			call_user_func_array($f, array($arr[$i], $i));
			unset($i);
		}
		$GLOBALS['%s']->pop();
	}
	static function any($arr, $f) {
		$GLOBALS['%s']->push("Arrays::any");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::any($arr->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function all($arr, $f) {
		$GLOBALS['%s']->push("Arrays::all");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::all($arr->iterator(), $f);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function random($arr) {
		$GLOBALS['%s']->push("Arrays::random");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = $arr[Std::random($arr->length)];
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function string($arr) {
		$GLOBALS['%s']->push("Arrays::string");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = "[" . Iterators::map($arr->iterator(), array(new _hx_lambda(array(&$arr), "Arrays_21"), 'execute'))->join(", ") . "]";
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function last($arr) {
		$GLOBALS['%s']->push("Arrays::last");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = $arr[$arr->length - 1];
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function lastf($arr, $f) {
		$GLOBALS['%s']->push("Arrays::lastf");
		$�spos = $GLOBALS['%s']->length;
		$i = $arr->length;
		while(--$i >= 0) {
			if(call_user_func_array($f, array($arr[$i]))) {
				$�tmp = $arr[$i];
				$GLOBALS['%s']->pop();
				return $�tmp;
				unset($�tmp);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static function first($arr) {
		$GLOBALS['%s']->push("Arrays::first");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = $arr[0];
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function firstf($arr, $f) {
		$GLOBALS['%s']->push("Arrays::firstf");
		$�spos = $GLOBALS['%s']->length;
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					$GLOBALS['%s']->pop();
					return $v;
				}
				unset($v);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static function bisect($a, $x, $lo, $hi) {
		$GLOBALS['%s']->push("Arrays::bisect");
		$�spos = $GLOBALS['%s']->length;
		if($lo === null) {
			$lo = 0;
		}
		{
			$�tmp = Arrays::bisectRight($a, $x, $lo, $hi);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function bisectRight($a, $x, $lo, $hi) {
		$GLOBALS['%s']->push("Arrays::bisectRight");
		$�spos = $GLOBALS['%s']->length;
		if($lo === null) {
			$lo = 0;
		}
		if(null === $hi) {
			$hi = $a->length;
		}
		while($lo < $hi) {
			$mid = $lo + $hi >> 1;
			if($x < $a[$mid]) {
				$hi = $mid;
			} else {
				$lo = $mid + 1;
			}
			unset($mid);
		}
		{
			$GLOBALS['%s']->pop();
			return $lo;
		}
		$GLOBALS['%s']->pop();
	}
	static function bisectLeft($a, $x, $lo, $hi) {
		$GLOBALS['%s']->push("Arrays::bisectLeft");
		$�spos = $GLOBALS['%s']->length;
		if($lo === null) {
			$lo = 0;
		}
		if(null === $hi) {
			$hi = $a->length;
		}
		while($lo < $hi) {
			$mid = $lo + $hi >> 1;
			if($a->�a[$mid] < $x) {
				$lo = $mid + 1;
			} else {
				$hi = $mid;
			}
			unset($mid);
		}
		{
			$GLOBALS['%s']->pop();
			return $lo;
		}
		$GLOBALS['%s']->pop();
	}
	static function nearest($a, $x, $f) {
		$GLOBALS['%s']->push("Arrays::nearest");
		$�spos = $GLOBALS['%s']->length;
		$delta = new _hx_array(array());
		{
			$_g1 = 0; $_g = $a->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$delta->push(_hx_anonymous(array("i" => $i, "v" => Math::abs(call_user_func_array($f, array($a[$i])) - $x))));
				unset($i);
			}
		}
		$delta->sort(array(new _hx_lambda(array(&$a, &$delta, &$f, &$x), "Arrays_22"), 'execute'));
		{
			$�tmp = $a[_hx_array_get($delta, 0)->i];
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Arrays::compare");
		$�spos = $GLOBALS['%s']->length;
		$v = null;
		if(($v = $a->length - $b->length) !== 0) {
			$GLOBALS['%s']->pop();
			return $v;
		}
		{
			$_g1 = 0; $_g = $a->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(($v = Dynamics::compare($a[$i], $b[$i])) !== 0) {
					$GLOBALS['%s']->pop();
					return $v;
				}
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return 0;
		}
		$GLOBALS['%s']->pop();
	}
	static function product($a) {
		$GLOBALS['%s']->push("Arrays::product");
		$�spos = $GLOBALS['%s']->length;
		if($a->length === 0) {
			$�tmp = new _hx_array(array());
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$arr = $a->copy(); $result = new _hx_array(array()); $temp = null;
		{
			$_g = 0; $_g1 = $arr[0];
			while($_g < $_g1->length) {
				$value = $_g1[$_g];
				++$_g;
				$result->push(new _hx_array(array($value)));
				unset($value);
			}
		}
		{
			$_g1 = 1; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$temp = new _hx_array(array());
				{
					$_g2 = 0;
					while($_g2 < $result->length) {
						$acc = $result[$_g2];
						++$_g2;
						$_g3 = 0; $_g4 = $arr[$i];
						while($_g3 < $_g4->length) {
							$value = $_g4[$_g3];
							++$_g3;
							$temp->push($acc->copy()->concat(new _hx_array(array($value))));
							unset($value);
						}
						unset($acc,$_g4,$_g3);
					}
					unset($_g2);
				}
				$result = $temp;
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $result;
		}
		$GLOBALS['%s']->pop();
	}
	static function rotate($a) {
		$GLOBALS['%s']->push("Arrays::rotate");
		$�spos = $GLOBALS['%s']->length;
		if($a->length === 0) {
			$�tmp = new _hx_array(array());
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$result = new _hx_array(array());
		{
			$_g1 = 0; $_g = _hx_array_get($a, 0)->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$result[$i] = new _hx_array(array());
				unset($i);
			}
		}
		{
			$_g1 = 0; $_g = $a->length;
			while($_g1 < $_g) {
				$j = $_g1++;
				$_g3 = 0; $_g2 = _hx_array_get($a, 0)->length;
				while($_g3 < $_g2) {
					$i = $_g3++;
					$result[$i][$j] = $a[$j][$i];
					unset($i);
				}
				unset($j,$_g3,$_g2);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $result;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Arrays'; }
}
function Arrays_0(&$arr, &$f) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
function Arrays_1(&$arr, &$f, $v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::split@166");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = $v === null;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_2(&$culture, &$format, &$param, &$params, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $params[1]) {
		return "[]";
	} else {
		return $params[1];
	}
}
function Arrays_3(&$culture, &$format, &$param, &$params, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $params[2]) {
		return ", ";
	} else {
		return $params[2];
	}
}
function Arrays_4(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $params[4]) {
		return " ...";
	} else {
		return $params[4];
	}
}
function Arrays_5(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::format@216");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Dynamics::format($d, $params[0], null, null, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_6(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::format@218");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Dynamics::format($d, $params[0], null, null, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_7(&$culture, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::formatf@233");
		$�spos2 = $GLOBALS['%s']->length;
		if($v->length === 0) {
			$empty = Arrays_23($culture, $format, $param, $params, $v);
			{
				$GLOBALS['%s']->pop();
				return $empty;
			}
		}
		$sep = Arrays_24($culture, $format, $param, $params, $v);
		$max = (($params[3] === null) ? null : (("" === $params[3]) ? null : Std::parseInt($params[3])));
		if(null !== $max && $max < $v->length) {
			$elipsis = Arrays_25($culture, $format, $max, $param, $params, $sep, $v);
			{
				$�tmp = Iterators::map($v->copy()->splice(0, $max)->iterator(), array(new _hx_lambda(array(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_26"), 'execute'))->join($sep) . $elipsis;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		} else {
			$�tmp = Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_27"), 'execute'))->join($sep);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_8(&$culture, &$f, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::formatf@252");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array($f, array(_hx_len($v)));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_9(&$a, &$b, &$equation, &$functions, &$i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$a1 = $a->length; $b1 = $b->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Arrays_10(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolatef@274");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_11(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolatef@282");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_12(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolatef@285");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_28"), 'execute'));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_13(&$a, &$b, &$equation, &$functions, &$i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$a1 = $a->length; $b1 = $b->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Arrays_14(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolateStringsf@304");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_15(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolateStringsf@312");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_16(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolateStringsf@315");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_29"), 'execute'));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_17(&$a, &$b, &$equation, &$functions, &$i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$a1 = $a->length; $b1 = $b->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Arrays_18(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolateIntsf@334");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_19(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolateIntsf@342");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_20(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::interpolateIntsf@345");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_30"), 'execute'));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_21(&$arr, $v, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::string@400");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Dynamics::string($v);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_22(&$a, &$delta, &$f, &$x, $a1, $b) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::nearest@470");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Arrays_31($a, $a1, $b, $delta, $f, $x);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_23(&$culture, &$format, &$param, &$params, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $params[1]) {
		return "[]";
	} else {
		return $params[1];
	}
}
function Arrays_24(&$culture, &$format, &$param, &$params, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $params[2]) {
		return ", ";
	} else {
		return $params[2];
	}
}
function Arrays_25(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(null === $params[4]) {
		return " ...";
	} else {
		return $params[4];
	}
}
function Arrays_26(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::rotate@246");
		$�spos3 = $GLOBALS['%s']->length;
		{
			$�tmp = Dynamics::format($d, $params[0], null, null, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_27(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::rotate@248");
		$�spos3 = $GLOBALS['%s']->length;
		{
			$�tmp = Dynamics::format($d, $params[0], null, null, $culture);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_28(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::rotate@285");
		$�spos3 = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array($f, array($t));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_29(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::rotate@315");
		$�spos3 = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array($f, array($t));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_30(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Arrays::rotate@345");
		$�spos3 = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array($f, array($t));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Arrays_31(&$a, &$a1, &$b, &$delta, &$f, &$x) {
	$�spos = $GLOBALS['%s']->length;
	{
		$a2 = $a1->v; $b1 = $b->v;
		if($a2 < $b1) {
			return -1;
		} else {
			if($a2 > $b1) {
				return 1;
			} else {
				return 0;
			}
		}
		unset($b1,$a2);
	}
}
