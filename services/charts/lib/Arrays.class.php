<?php

class Arrays {
	public function __construct(){}
	static function addIf($arr, $condition, $value) {
		if(null !== $condition) {
			if($condition) {
				$arr->push($value);
			}
		} else {
			if(null !== $value) {
				$arr->push($value);
			}
		}
		return $arr;
	}
	static function add($arr, $value) {
		$arr->push($value);
		return $arr;
	}
	static function delete($arr, $value) {
		$arr->remove($value);
		return $arr;
	}
	static function removef($arr, $f) {
		$index = -1;
		{
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(call_user_func_array($f, array($arr[$i]))) {
					$index = $i;
					break;
				}
				unset($i);
			}
		}
		if($index < 0) {
			return false;
		}
		$arr->splice($index, 1);
		return true;
	}
	static function deletef($arr, $f) {
		Arrays::removef($arr, $f);
		return $arr;
	}
	static function filter($arr, $f) {
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
		return $result;
	}
	static function min($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			$comp = Dynamics::comparef($a);
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(call_user_func_array($comp, array($a, $arr[$i])) > 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			return $arr[$p];
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
			return $arr[$p];
		}
	}
	static function floatMin($arr, $f) {
		if($arr->length === 0) {
			return Math::$NaN;
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
		return $a;
	}
	static function bounds($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			$b = $arr[0]; $q = 0;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					$comp = Dynamics::comparef($a);
					if(call_user_func_array($comp, array($a, $arr[$i])) > 0) {
						$a = $arr[$p = $i];
					}
					if(call_user_func_array($comp, array($b, $arr[$i])) < 0) {
						$b = $arr[$q = $i];
					}
					unset($i,$comp);
				}
			}
			return new _hx_array(array($arr[$p], $arr[$q]));
		} else {
			$a = call_user_func_array($f, array($arr[0])); $p = 0; $b = null;
			$c = call_user_func_array($f, array($arr[0])); $q = 0; $d = null;
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
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if($c < ($d = call_user_func_array($f, array($arr[$i])))) {
						$c = $d;
						$q = $i;
					}
					unset($i);
				}
			}
			return new _hx_array(array($arr[$p], $arr[$q]));
		}
	}
	static function boundsFloat($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		$a = call_user_func_array($f, array($arr[0])); $b = null;
		$c = call_user_func_array($f, array($arr[0])); $d = null;
		{
			$_g1 = 1; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				if($c < ($d = call_user_func_array($f, array($arr[$i])))) {
					$c = $d;
				}
				unset($i);
			}
		}
		return new _hx_array(array($a, $c));
	}
	static function max($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			$comp = Dynamics::comparef($a);
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(call_user_func_array($comp, array($a, $arr[$i])) < 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			return $arr[$p];
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
			return $arr[$p];
		}
	}
	static function floatMax($arr, $f) {
		if($arr->length === 0) {
			return Math::$NaN;
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
		return $a;
	}
	static function flatten($arr) {
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
		return $r;
	}
	static function map($arr, $f) {
		return Iterators::map($arr->iterator(), $f);
	}
	static function reduce($arr, $f, $initialValue) {
		return Iterators::reduce($arr->iterator(), $f, $initialValue);
	}
	static function order($arr, $f) {
		$arr->sort(Arrays_0($arr, $f));
		return $arr;
	}
	static function orderMultiple($arr, $f, $rest) {
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
	}
	static function split($arr, $f) {
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
		return $arrays;
	}
	static function exists($arr, $value, $f) {
		if(null !== $f) {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					return true;
				}
				unset($v);
			}
		} else {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if($v == $value) {
					return true;
				}
				unset($v);
			}
		}
		return false;
	}
	static function format($v, $param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			if($v->length === 0) {
				$empty = Arrays_2($culture, $format, $param, $params, $v);
				return $empty;
			}
			$sep = Arrays_3($culture, $format, $param, $params, $v);
			$max = (($params[3] === null) ? null : (("" === $params[3]) ? null : Std::parseInt($params[3])));
			if(null !== $max && $max < $v->length) {
				$elipsis = Arrays_4($culture, $format, $max, $param, $params, $sep, $v);
				return Iterators::map($v->copy()->splice(0, $max)->iterator(), array(new _hx_lambda(array(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_5"), 'execute'))->join($sep) . $elipsis;
			} else {
				return Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_6"), 'execute'))->join($sep);
			}
		}break;
		case "C":{
			return Ints::format($v->length, "I", new _hx_array(array()), $culture);
		}break;
		default:{
			throw new HException("Unsupported array format: " . $format);
		}break;
		}
	}
	static function formatf($param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Arrays_7"), 'execute');
		}break;
		case "C":{
			$f = Ints::formatf("I", new _hx_array(array()), $culture);
			return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Arrays_8"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported array format: " . $format);
		}break;
		}
	}
	static function interpolate($v, $a, $b, $equation) {
		return call_user_func_array(Arrays::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation) {
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
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_12"), 'execute');
	}
	static function interpolateStrings($v, $a, $b, $equation) {
		return call_user_func_array(Arrays::interpolateStringsf($a, $b, $equation), array($v));
	}
	static function interpolateStringsf($a, $b, $equation) {
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
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_16"), 'execute');
	}
	static function interpolateInts($v, $a, $b, $equation) {
		return call_user_func_array(Arrays::interpolateIntsf($a, $b, $equation), array($v));
	}
	static function interpolateIntsf($a, $b, $equation) {
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
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_20"), 'execute');
	}
	static function indexOf($arr, $el) {
		$len = $arr->length;
		{
			$_g = 0;
			while($_g < $len) {
				$i = $_g++;
				if($arr[$i] == $el) {
					return $i;
				}
				unset($i);
			}
		}
		return -1;
	}
	static function every($arr, $f) {
		{
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(!call_user_func_array($f, array($arr[$i], $i))) {
					return false;
				}
				unset($i);
			}
		}
		return true;
	}
	static function each($arr, $f) {
		$_g1 = 0; $_g = $arr->length;
		while($_g1 < $_g) {
			$i = $_g1++;
			call_user_func_array($f, array($arr[$i], $i));
			unset($i);
		}
	}
	static function any($arr, $f) {
		return Iterators::any($arr->iterator(), $f);
	}
	static function all($arr, $f) {
		return Iterators::all($arr->iterator(), $f);
	}
	static function random($arr) {
		return $arr[Std::random($arr->length)];
	}
	static function string($arr) {
		return "[" . Iterators::map($arr->iterator(), array(new _hx_lambda(array(&$arr), "Arrays_21"), 'execute'))->join(", ") . "]";
	}
	static function last($arr) {
		return $arr[$arr->length - 1];
	}
	static function lastf($arr, $f) {
		$i = $arr->length;
		while(--$i >= 0) {
			if(call_user_func_array($f, array($arr[$i]))) {
				return $arr[$i];
			}
		}
		return null;
	}
	static function first($arr) {
		return $arr[0];
	}
	static function firstf($arr, $f) {
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					return $v;
				}
				unset($v);
			}
		}
		return null;
	}
	static function bisect($a, $x, $lo, $hi) {
		if($lo === null) {
			$lo = 0;
		}
		return Arrays::bisectRight($a, $x, $lo, $hi);
	}
	static function bisectRight($a, $x, $lo, $hi) {
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
		return $lo;
	}
	static function bisectLeft($a, $x, $lo, $hi) {
		if($lo === null) {
			$lo = 0;
		}
		if(null === $hi) {
			$hi = $a->length;
		}
		while($lo < $hi) {
			$mid = $lo + $hi >> 1;
			if($a->»a[$mid] < $x) {
				$lo = $mid + 1;
			} else {
				$hi = $mid;
			}
			unset($mid);
		}
		return $lo;
	}
	static function nearest($a, $x, $f) {
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
		return $a[_hx_array_get($delta, 0)->i];
	}
	static function compare($a, $b) {
		$v = null;
		if(($v = $a->length - $b->length) !== 0) {
			return $v;
		}
		{
			$_g1 = 0; $_g = $a->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(($v = Dynamics::compare($a[$i], $b[$i])) !== 0) {
					return $v;
				}
				unset($i);
			}
		}
		return 0;
	}
	static function product($a) {
		if($a->length === 0) {
			return new _hx_array(array());
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
		return $result;
	}
	static function rotate($a) {
		if($a->length === 0) {
			return new _hx_array(array());
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
		return $result;
	}
	static function shuffle($a) {
		$t = Ints::range($a->length, null, null); $arr = new _hx_array(array());
		while($t->length > 0) {
			$pos = Std::random($t->length); $index = $t[$pos];
			$t->splice($pos, 1);
			$arr->push($a[$index]);
			unset($pos,$index);
		}
		return $arr;
	}
	static function scanf($arr, $weightf, $incremental) {
		if($incremental === null) {
			$incremental = true;
		}
		$tot = 0.0; $weights = new _hx_array(array());
		if($incremental) {
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$weights[$i] = $tot += call_user_func_array($weightf, array($arr[$i], $i));
				unset($i);
			}
		} else {
			{
				$_g1 = 0; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					$weights[$i] = call_user_func_array($weightf, array($arr[$i], $i));
					unset($i);
				}
			}
			$tot = $weights[$weights->length - 1];
		}
		$scan = Arrays_23($arr, $incremental, $tot, $weightf, $weights);
		return array(new _hx_lambda(array(&$arr, &$incremental, &$scan, &$tot, &$weightf, &$weights), "Arrays_24"), 'execute');
	}
	function __toString() { return 'Arrays'; }
}
function Arrays_0(&$arr, &$f) {
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
function Arrays_1(&$arr, &$f, $v, $_) {
	{
		return $v === null;
	}
}
function Arrays_2(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[1]) {
		return "[]";
	} else {
		return $params[1];
	}
}
function Arrays_3(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[2]) {
		return ", ";
	} else {
		return $params[2];
	}
}
function Arrays_4(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v) {
	if(null === $params[4]) {
		return " ...";
	} else {
		return $params[4];
	}
}
function Arrays_5(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_6(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_7(&$culture, &$format, &$param, &$params, $v) {
	{
		if($v->length === 0) {
			$empty = Arrays_25($culture, $format, $param, $params, $v);
			return $empty;
		}
		$sep = Arrays_26($culture, $format, $param, $params, $v);
		$max = (($params[3] === null) ? null : (("" === $params[3]) ? null : Std::parseInt($params[3])));
		if(null !== $max && $max < $v->length) {
			$elipsis = Arrays_27($culture, $format, $max, $param, $params, $sep, $v);
			return Iterators::map($v->copy()->splice(0, $max)->iterator(), array(new _hx_lambda(array(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_28"), 'execute'))->join($sep) . $elipsis;
		} else {
			return Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_29"), 'execute'))->join($sep);
		}
	}
}
function Arrays_8(&$culture, &$f, &$format, &$param, &$params, $v) {
	{
		return call_user_func_array($f, array(_hx_len($v)));
	}
}
function Arrays_9(&$a, &$b, &$equation, &$functions, &$i) {
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
	{
		return $v;
	}
}
function Arrays_11(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_12(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_30"), 'execute'));
	}
}
function Arrays_13(&$a, &$b, &$equation, &$functions, &$i) {
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
	{
		return $v;
	}
}
function Arrays_15(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_16(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_31"), 'execute'));
	}
}
function Arrays_17(&$a, &$b, &$equation, &$functions, &$i) {
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
	{
		return $v;
	}
}
function Arrays_19(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_20(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_32"), 'execute'));
	}
}
function Arrays_21(&$arr, $v, $_) {
	{
		return Dynamics::string($v);
	}
}
function Arrays_22(&$a, &$delta, &$f, &$x, $a1, $b) {
	{
		return Arrays_33($a, $a1, $b, $delta, $f, $x);
	}
}
function Arrays_23(&$arr, &$incremental, &$tot, &$weightf, &$weights) {
	{
		$scan = null;
		$scan = array(new _hx_lambda(array(&$arr, &$incremental, &$scan, &$tot, &$weightf, &$weights), "Arrays_34"), 'execute');
		return $scan;
	}
}
function Arrays_24(&$arr, &$incremental, &$scan, &$tot, &$weightf, &$weights, $v) {
	{
		if($v < 0 || $v > $tot) {
			return null;
		}
		return call_user_func_array($scan, array($v, 0, $weights->length - 1));
	}
}
function Arrays_25(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[1]) {
		return "[]";
	} else {
		return $params[1];
	}
}
function Arrays_26(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[2]) {
		return ", ";
	} else {
		return $params[2];
	}
}
function Arrays_27(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v) {
	if(null === $params[4]) {
		return " ...";
	} else {
		return $params[4];
	}
}
function Arrays_28(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_29(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_30(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_31(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_32(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_33(&$a, &$a1, &$b, &$delta, &$f, &$x) {
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
function Arrays_34(&$arr, &$incremental, &$scan, &$tot, &$weightf, &$weights, $v, $start, $end) {
	{
		if($start === $end) {
			return $arr[$start];
		}
		$mid = Math::floor(($end - $start) / 2) + $start; $value = $weights[$mid];
		if($v < $value) {
			return call_user_func_array($scan, array($v, $start, $mid));
		} else {
			return call_user_func_array($scan, array($v, $mid + 1, $end));
		}
	}
}
