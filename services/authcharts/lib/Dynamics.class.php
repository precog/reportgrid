<?php

class Dynamics {
	public function __construct(){}
	static function format($v, $param, $params, $nullstring, $culture) {
		return Dynamics::formatf($param, $params, $nullstring, $culture)($v);
	}
	static function formatf($param, $params, $nullstring, $culture) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		return array(new _hx_lambda(array(&$culture, &$nullstring, &$param, &$params), "Dynamics_0"), 'execute');
	}
	static function interpolate($v, $a, $b, $equation) {
		return Dynamics::interpolatef($a, $b, $equation)($v);
	}
	static function interpolatef($a, $b, $equation) {
		$ta = Type::typeof($a);
		$tb = Type::typeof($b);
		if(!((Std::is($a, _hx_qtype("Float")) || Std::is($a, _hx_qtype("Int"))) && (Std::is($b, _hx_qtype("Float")) || Std::is($b, _hx_qtype("Int")))) && !Type::enumEq($ta, $tb)) {
			throw new HException(new thx_error_Error("arguments a ({0}) and b ({0}) have different types", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 57, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}
		$퍁 = ($ta);
		switch($퍁->index) {
		case 0:
		{
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$ta, &$tb), "Dynamics_1"), 'execute');
		}break;
		case 1:
		{
			if(Std::is($b, _hx_qtype("Int"))) {
				return Ints::interpolatef($a, $b, $equation);
			} else {
				return Floats::interpolatef($a, $b, $equation);
			}
		}break;
		case 2:
		{
			return Floats::interpolatef($a, $b, $equation);
		}break;
		case 3:
		{
			return Bools::interpolatef($a, $b, $equation);
		}break;
		case 4:
		{
			return Objects::interpolatef($a, $b, $equation);
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "String":{
				return Strings::interpolatef($a, $b, $equation);
			}break;
			case "Date":{
				return Dates::interpolatef($a, $b, $equation);
			}break;
			default:{
				throw new HException(new thx_error_Error("cannot interpolate on instances of {0}", null, $name, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 75, "className" => "Dynamics", "methodName" => "interpolatef"))));
			}break;
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("cannot interpolate on functions/enums/unknown", null, null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 77, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}break;
		}
	}
	static function string($v) {
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			return "null";
		}break;
		case 1:
		{
			return Ints::format($v, null, null, null);
		}break;
		case 2:
		{
			return Floats::format($v, null, null, null);
		}break;
		case 3:
		{
			return Bools::format($v, null, null, null);
		}break;
		case 4:
		{
			$keys = Reflect::fields($v);
			$result = new _hx_array(array());
			{
				$_g = 0;
				while($_g < $keys->length) {
					$key = $keys[$_g];
					++$_g;
					$result->push($key . " : " . Dynamics::string(Reflect::field($v, $key)));
					unset($key);
				}
			}
			return "{" . $result->join(", ") . "}";
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				return Arrays::string($v);
			}break;
			case "String":{
				$s = $v;
				if(_hx_index_of($s, "\"", null) < 0) {
					return "\"" . $s . "\"";
				} else {
					if(_hx_index_of($s, "'", null) < 0) {
						return "'" . $s . "'";
					} else {
						return "\"" . str_replace("\"", "\\\"", $s) . "\"";
					}
				}
			}break;
			case "Date":{
				return Dates::format($v, null, null, null);
			}break;
			default:{
				return Std::string($v);
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			return Enums::string($v);
		}break;
		case 8:
		{
			return "<unknown>";
		}break;
		case 5:
		{
			return "<function>";
		}break;
		}
	}
	static function compare($a, $b) {
		if(!Types::sameType($a, $b)) {
			throw new HException(new thx_error_Error("cannot compare 2 different types", null, null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 129, "className" => "Dynamics", "methodName" => "compare"))));
		}
		if(null === $a && null === $b) {
			return 0;
		}
		if(null === $a) {
			return -1;
		}
		if(null === $b) {
			return 1;
		}
		$퍁 = (Type::typeof($a));
		switch($퍁->index) {
		case 1:
		{
			return $a - $b;
		}break;
		case 2:
		{
			return (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
		}break;
		case 3:
		{
			return ((_hx_equal($a, $b)) ? 0 : (($a) ? -1 : 1));
		}break;
		case 4:
		{
			return Objects::compare($a, $b);
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				return Arrays::compare($a, $b);
			}break;
			case "String":{
				return Strings::compare($a, $b);
			}break;
			case "Date":{
				return Dynamics_2($a, $b, $c, $name);
			}break;
			default:{
				return Strings::compare(Std::string($a), Std::string($b));
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			return Enums::compare($a, $b);
		}break;
		default:{
			return 0;
		}break;
		}
	}
	static function comparef($sample) {
		$퍁 = (Type::typeof($sample));
		switch($퍁->index) {
		case 1:
		{
			return (isset(Ints::$compare) ? Ints::$compare: array("Ints", "compare"));
		}break;
		case 2:
		{
			return (isset(Floats::$compare) ? Floats::$compare: array("Floats", "compare"));
		}break;
		case 3:
		{
			return (isset(Bools::$compare) ? Bools::$compare: array("Bools", "compare"));
		}break;
		case 4:
		{
			return (isset(Objects::$compare) ? Objects::$compare: array("Objects", "compare"));
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				return (isset(Arrays::$compare) ? Arrays::$compare: array("Arrays", "compare"));
			}break;
			case "String":{
				return (isset(Strings::$compare) ? Strings::$compare: array("Strings", "compare"));
			}break;
			case "Date":{
				return (isset(Dates::$compare) ? Dates::$compare: array("Dates", "compare"));
			}break;
			default:{
				return array(new _hx_lambda(array(&$c, &$name, &$sample), "Dynamics_3"), 'execute');
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			return (isset(Enums::$compare) ? Enums::$compare: array("Enums", "compare"));
		}break;
		default:{
			return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
		}break;
		}
	}
	static function hclone($v) {
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			return null;
		}break;
		case 1:
		case 2:
		case 3:
		case 7:
		case 8:
		case 5:
		{
			return $v;
		}break;
		case 4:
		{
			$o = _hx_anonymous(array());
			Objects::copyTo($v, $o);
			return $o;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				$src = $v; $a = new _hx_array(array());
				{
					$_g = 0;
					while($_g < $src->length) {
						$i = $src[$_g];
						++$_g;
						$a->push(Dynamics::hclone($i));
						unset($i);
					}
				}
				return $a;
			}break;
			case "String":case "Date":{
				return $v;
			}break;
			default:{
				$o = Type::createEmptyInstance($c);
				{
					$_g = 0; $_g1 = Reflect::fields($v);
					while($_g < $_g1->length) {
						$field = $_g1[$_g];
						++$_g;
						$o->{$field} = Dynamics::hclone(Reflect::field($v, $field));
						unset($field);
					}
				}
				return $o;
			}break;
			}
		}break;
		}
	}
	static function same($a, $b) {
		$ta = Types::typeName($a); $tb = Types::typeName($b);
		if($ta !== $tb) {
			return false;
		}
		$퍁 = (Type::typeof($a));
		switch($퍁->index) {
		case 2:
		{
			return Floats::equals($a, $b, null);
		}break;
		case 0:
		case 1:
		case 3:
		{
			return $a === $b;
		}break;
		case 5:
		{
			return Reflect::compareMethods($a, $b);
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$ca = Type::getClassName($c); $cb = Type::getClassName(Type::getClass($b));
			if($ca !== $cb) {
				return false;
			}
			if(Std::is($a, _hx_qtype("String")) && $a !== $b) {
				return false;
			}
			if(Std::is($a, _hx_qtype("Array"))) {
				$aa = $a; $ab = $b;
				if($aa->length !== $ab->length) {
					return false;
				}
				{
					$_g1 = 0; $_g = $aa->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						if(!Dynamics::same($aa[$i], $ab[$i])) {
							return false;
						}
						unset($i);
					}
				}
				return true;
			}
			if(Std::is($a, _hx_qtype("Date"))) {
				return _hx_equal($a->getTime(), $b->getTime());
			}
			if(Std::is($a, _hx_qtype("Hash")) || Std::is($a, _hx_qtype("IntHash"))) {
				$ha = $a; $hb = $b;
				$ka = Iterators::harray($ha->keys()); $kb = Iterators::harray($hb->keys());
				if($ka->length !== $kb->length) {
					return false;
				}
				{
					$_g = 0;
					while($_g < $ka->length) {
						$key = $ka[$_g];
						++$_g;
						if(!$hb->exists($key) || !Dynamics::same($ha->get($key), $hb->get($key))) {
							return false;
						}
						unset($key);
					}
				}
				return true;
			}
			$t = false;
			if(($t = Iterators::isIterator($a)) || Iterables::isIterable($a)) {
				$va = (($t) ? Iterators::harray($a) : Iterators::harray($a->iterator())); $vb = (($t) ? Iterators::harray($b) : Iterators::harray($b->iterator()));
				if($va->length !== $vb->length) {
					return false;
				}
				{
					$_g1 = 0; $_g = $va->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						if(!Dynamics::same($va[$i], $vb[$i])) {
							return false;
						}
						unset($i);
					}
				}
				return true;
			}
			$fields = Type::getInstanceFields(Type::getClass($a));
			{
				$_g = 0;
				while($_g < $fields->length) {
					$field = $fields[$_g];
					++$_g;
					$va = Reflect::field($a, $field);
					if(Reflect::isFunction($va)) {
						continue;
					}
					$vb = Reflect::field($b, $field);
					if(!Dynamics::same($va, $vb)) {
						return false;
					}
					unset($vb,$va,$field);
				}
			}
			return true;
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			$ea = Type::getEnumName($e); $eb = Type::getEnumName(Type::getEnum($b));
			if($ea !== $eb) {
				return false;
			}
			if($a->index !== $b->index) {
				return false;
			}
			$pa = Type::enumParameters($a); $pb = Type::enumParameters($b);
			{
				$_g1 = 0; $_g = $pa->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(!Dynamics::same($pa[$i], $pb[$i])) {
						return false;
					}
					unset($i);
				}
			}
			return true;
		}break;
		case 4:
		{
			$fa = Reflect::fields($a); $fb = Reflect::fields($b);
			{
				$_g = 0;
				while($_g < $fa->length) {
					$field = $fa[$_g];
					++$_g;
					$fb->remove($field);
					if(!_hx_has_field($b, $field)) {
						return false;
					}
					$va = Reflect::field($a, $field);
					if(Reflect::isFunction($va)) {
						continue;
					}
					$vb = Reflect::field($b, $field);
					if(!Dynamics::same($va, $vb)) {
						return false;
					}
					unset($vb,$va,$field);
				}
			}
			if($fb->length > 0) {
				return false;
			}
			$t = false;
			if(($t = Iterators::isIterator($a)) || Iterables::isIterable($a)) {
				if($t && !Iterators::isIterator($b)) {
					return false;
				}
				if(!$t && !Iterables::isIterable($b)) {
					return false;
				}
				$aa = (($t) ? Iterators::harray($a) : Iterators::harray($a->iterator()));
				$ab = (($t) ? Iterators::harray($b) : Iterators::harray($b->iterator()));
				if($aa->length !== $ab->length) {
					return false;
				}
				{
					$_g1 = 0; $_g = $aa->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						if(!Dynamics::same($aa[$i], $ab[$i])) {
							return false;
						}
						unset($i);
					}
				}
				return true;
			}
			return true;
		}break;
		case 8:
		{
			Dynamics_4($a, $b, $ta, $tb);
		}break;
		}
		Dynamics_5($a, $b, $ta, $tb);
	}
	static function number($v) {
		if(Std::is($v, _hx_qtype("Bool"))) {
			return ((_hx_equal($v, true)) ? 1 : 0);
		} else {
			if(Std::is($v, _hx_qtype("Date"))) {
				return $v->getTime();
			} else {
				if(Std::is($v, _hx_qtype("String"))) {
					return Std::parseFloat($v);
				} else {
					return Math::$NaN;
				}
			}
		}
	}
	function __toString() { return 'Dynamics'; }
}
function Dynamics_0(&$culture, &$nullstring, &$param, &$params, $v) {
	{
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			return $nullstring;
		}break;
		case 1:
		{
			return Ints::format($v, $param, $params, $culture);
		}break;
		case 2:
		{
			return Floats::format($v, $param, $params, $culture);
		}break;
		case 3:
		{
			return Bools::format($v, $param, $params, $culture);
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			if($c === _hx_qtype("String")) {
				return Strings::formatOne($v, $param, $params, $culture);
			} else {
				if($c === _hx_qtype("Array")) {
					return Arrays::format($v, $param, $params, $culture);
				} else {
					if($c === _hx_qtype("Date")) {
						return Dates::format($v, $param, $params, $culture);
					} else {
						return Objects::format($v, $param, $params, $culture);
					}
				}
			}
		}break;
		case 4:
		{
			return Objects::format($v, $param, $params, $culture);
		}break;
		default:{
			Dynamics_6($culture, $nullstring, $param, $params, $v);
		}break;
		}
	}
}
function Dynamics_1(&$a, &$b, &$equation, &$ta, &$tb, $_) {
	{
		return null;
	}
}
function Dynamics_2(&$a, &$b, &$c, &$name) {
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
function Dynamics_3(&$c, &$name, &$sample, $a, $b) {
	{
		return Strings::compare(Std::string($a), Std::string($b));
	}
}
function Dynamics_4(&$a, &$b, &$ta, &$tb) {
	throw new HException("Unable to compare two unknown types");
}
function Dynamics_5(&$a, &$b, &$ta, &$tb) {
	throw new HException(new thx_error_Error("Unable to compare values: {0} and {1}", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 364, "className" => "Dynamics", "methodName" => "same"))));
}
function Dynamics_6(&$culture, &$nullstring, &$param, &$params, &$v) {
	throw new HException(new thx_error_Error("Unsupported type format: {0}", null, Type::typeof($v), _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 42, "className" => "Dynamics", "methodName" => "formatf"))));
}
