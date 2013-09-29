<?php

class Dynamics {
	public function __construct(){}
	static function format($v, $param, $params, $nullstring, $culture) {
		$GLOBALS['%s']->push("Dynamics::format");
		$퍀pos = $GLOBALS['%s']->length;
		{
			$퍁mp = call_user_func_array(Dynamics::formatf($param, $params, $nullstring, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $nullstring, $culture) {
		$GLOBALS['%s']->push("Dynamics::formatf");
		$퍀pos = $GLOBALS['%s']->length;
		if($nullstring === null) {
			$nullstring = "null";
		}
		{
			$퍁mp = array(new _hx_lambda(array(&$culture, &$nullstring, &$param, &$params), "Dynamics_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Dynamics::interpolate");
		$퍀pos = $GLOBALS['%s']->length;
		{
			$퍁mp = call_user_func_array(Dynamics::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Dynamics::interpolatef");
		$퍀pos = $GLOBALS['%s']->length;
		$ta = Type::typeof($a);
		$tb = Type::typeof($b);
		if(!((Std::is($a, _hx_qtype("Float")) || Std::is($a, _hx_qtype("Int"))) && (Std::is($b, _hx_qtype("Float")) || Std::is($b, _hx_qtype("Int")))) && !Type::enumEq($ta, $tb)) {
			throw new HException(new thx_error_Error("arguments a ({0}) and b ({0}) have different types", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 57, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}
		$퍁 = ($ta);
		switch($퍁->index) {
		case 0:
		{
			$퍁mp = array(new _hx_lambda(array(&$a, &$b, &$equation, &$ta, &$tb), "Dynamics_1"), 'execute');
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 1:
		{
			if(Std::is($b, _hx_qtype("Int"))) {
				$퍁mp = Ints::interpolatef($a, $b, $equation);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			} else {
				$퍁mp = Floats::interpolatef($a, $b, $equation);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}
		}break;
		case 2:
		{
			$퍁mp = Floats::interpolatef($a, $b, $equation);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 3:
		{
			$퍁mp = Bools::interpolatef($a, $b, $equation);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 4:
		{
			$퍁mp = Objects::interpolatef($a, $b, $equation);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "String":{
				$퍁mp = Strings::interpolatef($a, $b, $equation);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			case "Date":{
				$퍁mp = Dates::interpolatef($a, $b, $equation);
				$GLOBALS['%s']->pop();
				return $퍁mp;
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
		$GLOBALS['%s']->pop();
	}
	static function string($v) {
		$GLOBALS['%s']->push("Dynamics::string");
		$퍀pos = $GLOBALS['%s']->length;
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			$GLOBALS['%s']->pop();
			return "null";
		}break;
		case 1:
		{
			$퍁mp = Ints::format($v, null, null, null);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 2:
		{
			$퍁mp = Floats::format($v, null, null, null);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 3:
		{
			$퍁mp = Bools::format($v, null, null, null);
			$GLOBALS['%s']->pop();
			return $퍁mp;
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
			{
				$퍁mp = "{" . $result->join(", ") . "}";
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				$퍁mp = Arrays::string($v);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			case "String":{
				$s = $v;
				if(_hx_index_of($s, "\"", null) < 0) {
					$퍁mp = "\"" . $s . "\"";
					$GLOBALS['%s']->pop();
					return $퍁mp;
				} else {
					if(_hx_index_of($s, "'", null) < 0) {
						$퍁mp = "'" . $s . "'";
						$GLOBALS['%s']->pop();
						return $퍁mp;
					} else {
						$퍁mp = "\"" . str_replace("\"", "\\\"", $s) . "\"";
						$GLOBALS['%s']->pop();
						return $퍁mp;
					}
				}
			}break;
			case "Date":{
				$퍁mp = Dates::format($v, null, null, null);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			default:{
				$퍁mp = Std::string($v);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			$퍁mp = Enums::string($v);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 8:
		{
			$GLOBALS['%s']->pop();
			return "<unknown>";
		}break;
		case 5:
		{
			$GLOBALS['%s']->pop();
			return "<function>";
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Dynamics::compare");
		$퍀pos = $GLOBALS['%s']->length;
		if(!Types::sameType($a, $b)) {
			throw new HException(new thx_error_Error("cannot compare 2 different types", null, null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 129, "className" => "Dynamics", "methodName" => "compare"))));
		}
		if(null === $a && null === $b) {
			$GLOBALS['%s']->pop();
			return 0;
		}
		if(null === $a) {
			$GLOBALS['%s']->pop();
			return -1;
		}
		if(null === $b) {
			$GLOBALS['%s']->pop();
			return 1;
		}
		$퍁 = (Type::typeof($a));
		switch($퍁->index) {
		case 1:
		{
			$퍁mp = $a - $b;
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 2:
		{
			$퍁mp = (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 3:
		{
			$퍁mp = ((_hx_equal($a, $b)) ? 0 : (($a) ? -1 : 1));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 4:
		{
			$퍁mp = Objects::compare($a, $b);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				$퍁mp = Arrays::compare($a, $b);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			case "String":{
				$퍁mp = Strings::compare($a, $b);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			case "Date":{
				$퍁mp = Dynamics_2($a, $b, $c, $name);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			default:{
				$퍁mp = Strings::compare(Std::string($a), Std::string($b));
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			$퍁mp = Enums::compare($a, $b);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		default:{
			$GLOBALS['%s']->pop();
			return 0;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function comparef($sample) {
		$GLOBALS['%s']->push("Dynamics::comparef");
		$퍀pos = $GLOBALS['%s']->length;
		$퍁 = (Type::typeof($sample));
		switch($퍁->index) {
		case 1:
		{
			$퍁mp = (isset(Ints::$compare) ? Ints::$compare: array("Ints", "compare"));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 2:
		{
			$퍁mp = (isset(Floats::$compare) ? Floats::$compare: array("Floats", "compare"));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 3:
		{
			$퍁mp = (isset(Bools::$compare) ? Bools::$compare: array("Bools", "compare"));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 4:
		{
			$퍁mp = (isset(Objects::$compare) ? Objects::$compare: array("Objects", "compare"));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				$퍁mp = (isset(Arrays::$compare) ? Arrays::$compare: array("Arrays", "compare"));
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			case "String":{
				$퍁mp = (isset(Strings::$compare) ? Strings::$compare: array("Strings", "compare"));
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			case "Date":{
				$퍁mp = (isset(Dates::$compare) ? Dates::$compare: array("Dates", "compare"));
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			default:{
				$퍁mp = array(new _hx_lambda(array(&$c, &$name, &$sample), "Dynamics_3"), 'execute');
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			$퍁mp = (isset(Enums::$compare) ? Enums::$compare: array("Enums", "compare"));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		default:{
			$퍁mp = (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function hclone($v) {
		$GLOBALS['%s']->push("Dynamics::clone");
		$퍀pos = $GLOBALS['%s']->length;
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			$GLOBALS['%s']->pop();
			return null;
		}break;
		case 1:
		case 2:
		case 3:
		case 7:
		case 8:
		case 5:
		{
			$GLOBALS['%s']->pop();
			return $v;
		}break;
		case 4:
		{
			$o = _hx_anonymous(array());
			Objects::copyTo($v, $o);
			{
				$GLOBALS['%s']->pop();
				return $o;
			}
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
				{
					$GLOBALS['%s']->pop();
					return $a;
				}
			}break;
			case "String":case "Date":{
				$GLOBALS['%s']->pop();
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
				{
					$GLOBALS['%s']->pop();
					return $o;
				}
			}break;
			}
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function same($a, $b) {
		$GLOBALS['%s']->push("Dynamics::same");
		$퍀pos = $GLOBALS['%s']->length;
		$ta = Types::typeName($a); $tb = Types::typeName($b);
		if($ta !== $tb) {
			$GLOBALS['%s']->pop();
			return false;
		}
		$퍁 = (Type::typeof($a));
		switch($퍁->index) {
		case 2:
		{
			$퍁mp = Floats::equals($a, $b, null);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 0:
		case 1:
		case 3:
		{
			$퍁mp = $a === $b;
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 5:
		{
			$퍁mp = Reflect::compareMethods($a, $b);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$ca = Type::getClassName($c); $cb = Type::getClassName(Type::getClass($b));
			if($ca !== $cb) {
				$GLOBALS['%s']->pop();
				return false;
			}
			if(Std::is($a, _hx_qtype("String")) && $a !== $b) {
				$GLOBALS['%s']->pop();
				return false;
			}
			if(Std::is($a, _hx_qtype("Array"))) {
				$aa = $a; $ab = $b;
				if($aa->length !== $ab->length) {
					$GLOBALS['%s']->pop();
					return false;
				}
				{
					$_g1 = 0; $_g = $aa->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						if(!Dynamics::same($aa[$i], $ab[$i])) {
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
			}
			if(Std::is($a, _hx_qtype("Date"))) {
				$퍁mp = _hx_equal($a->getTime(), $b->getTime());
				$GLOBALS['%s']->pop();
				return $퍁mp;
			}
			if(Std::is($a, _hx_qtype("Hash")) || Std::is($a, _hx_qtype("IntHash"))) {
				$ha = $a; $hb = $b;
				$ka = Iterators::harray($ha->keys()); $kb = Iterators::harray($hb->keys());
				if($ka->length !== $kb->length) {
					$GLOBALS['%s']->pop();
					return false;
				}
				{
					$_g = 0;
					while($_g < $ka->length) {
						$key = $ka[$_g];
						++$_g;
						if(!$hb->exists($key) || !Dynamics::same($ha->get($key), $hb->get($key))) {
							$GLOBALS['%s']->pop();
							return false;
						}
						unset($key);
					}
				}
				{
					$GLOBALS['%s']->pop();
					return true;
				}
			}
			$t = false;
			if(($t = Iterators::isIterator($a)) || Iterables::isIterable($a)) {
				$va = (($t) ? Iterators::harray($a) : Iterators::harray($a->iterator())); $vb = (($t) ? Iterators::harray($b) : Iterators::harray($b->iterator()));
				if($va->length !== $vb->length) {
					$GLOBALS['%s']->pop();
					return false;
				}
				{
					$_g1 = 0; $_g = $va->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						if(!Dynamics::same($va[$i], $vb[$i])) {
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
						$GLOBALS['%s']->pop();
						return false;
					}
					unset($vb,$va,$field);
				}
			}
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			$ea = Type::getEnumName($e); $eb = Type::getEnumName(Type::getEnum($b));
			if($ea !== $eb) {
				$GLOBALS['%s']->pop();
				return false;
			}
			if($a->index !== $b->index) {
				$GLOBALS['%s']->pop();
				return false;
			}
			$pa = Type::enumParameters($a); $pb = Type::enumParameters($b);
			{
				$_g1 = 0; $_g = $pa->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(!Dynamics::same($pa[$i], $pb[$i])) {
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
						$GLOBALS['%s']->pop();
						return false;
					}
					$va = Reflect::field($a, $field);
					if(Reflect::isFunction($va)) {
						continue;
					}
					$vb = Reflect::field($b, $field);
					if(!Dynamics::same($va, $vb)) {
						$GLOBALS['%s']->pop();
						return false;
					}
					unset($vb,$va,$field);
				}
			}
			if($fb->length > 0) {
				$GLOBALS['%s']->pop();
				return false;
			}
			$t = false;
			if(($t = Iterators::isIterator($a)) || Iterables::isIterable($a)) {
				if($t && !Iterators::isIterator($b)) {
					$GLOBALS['%s']->pop();
					return false;
				}
				if(!$t && !Iterables::isIterable($b)) {
					$GLOBALS['%s']->pop();
					return false;
				}
				$aa = (($t) ? Iterators::harray($a) : Iterators::harray($a->iterator()));
				$ab = (($t) ? Iterators::harray($b) : Iterators::harray($b->iterator()));
				if($aa->length !== $ab->length) {
					$GLOBALS['%s']->pop();
					return false;
				}
				{
					$_g1 = 0; $_g = $aa->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						if(!Dynamics::same($aa[$i], $ab[$i])) {
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
			}
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		}break;
		case 8:
		{
			$퍁mp = Dynamics_4($a, $b, $ta, $tb);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		}
		{
			$퍁mp = Dynamics_5($a, $b, $ta, $tb);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function number($v) {
		$GLOBALS['%s']->push("Dynamics::number");
		$퍀pos = $GLOBALS['%s']->length;
		if(Std::is($v, _hx_qtype("Bool"))) {
			$퍁mp = ((_hx_equal($v, true)) ? 1 : 0);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		} else {
			if(Std::is($v, _hx_qtype("Date"))) {
				$퍁mp = $v->getTime();
				$GLOBALS['%s']->pop();
				return $퍁mp;
			} else {
				if(Std::is($v, _hx_qtype("String"))) {
					$퍁mp = Std::parseFloat($v);
					$GLOBALS['%s']->pop();
					return $퍁mp;
				} else {
					$퍁mp = Math::$NaN;
					$GLOBALS['%s']->pop();
					return $퍁mp;
				}
			}
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Dynamics'; }
}
function Dynamics_0(&$culture, &$nullstring, &$param, &$params, $v) {
	$퍀pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dynamics::formatf@18");
		$퍀pos2 = $GLOBALS['%s']->length;
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			$GLOBALS['%s']->pop();
			return $nullstring;
		}break;
		case 1:
		{
			$퍁mp = Ints::format($v, $param, $params, $culture);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 2:
		{
			$퍁mp = Floats::format($v, $param, $params, $culture);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 3:
		{
			$퍁mp = Bools::format($v, $param, $params, $culture);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			if($c === _hx_qtype("String")) {
				$퍁mp = Strings::formatOne($v, $param, $params, $culture);
				$GLOBALS['%s']->pop();
				return $퍁mp;
			} else {
				if($c === _hx_qtype("Array")) {
					$퍁mp = Arrays::format($v, $param, $params, $culture);
					$GLOBALS['%s']->pop();
					return $퍁mp;
				} else {
					if($c === _hx_qtype("Date")) {
						$퍁mp = Dates::format($v, $param, $params, $culture);
						$GLOBALS['%s']->pop();
						return $퍁mp;
					} else {
						$퍁mp = Objects::format($v, $param, $params, $culture);
						$GLOBALS['%s']->pop();
						return $퍁mp;
					}
				}
			}
		}break;
		case 4:
		{
			$퍁mp = Objects::format($v, $param, $params, $culture);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		default:{
			$퍁mp = Dynamics_6($culture, $nullstring, $param, $params, $v);
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dynamics_1(&$a, &$b, &$equation, &$ta, &$tb, $_) {
	$퍀pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dynamics::interpolatef@60");
		$퍀pos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dynamics_2(&$a, &$b, &$c, &$name) {
	$퍀pos = $GLOBALS['%s']->length;
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
	$퍀pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Dynamics::comparef@181");
		$퍀pos2 = $GLOBALS['%s']->length;
		{
			$퍁mp = Strings::compare(Std::string($a), Std::string($b));
			$GLOBALS['%s']->pop();
			return $퍁mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Dynamics_4(&$a, &$b, &$ta, &$tb) {
	$퍀pos = $GLOBALS['%s']->length;
	throw new HException("Unable to compare two unknown types");
}
function Dynamics_5(&$a, &$b, &$ta, &$tb) {
	$퍀pos = $GLOBALS['%s']->length;
	throw new HException(new thx_error_Error("Unable to compare values: {0} and {1}", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 364, "className" => "Dynamics", "methodName" => "same"))));
}
function Dynamics_6(&$culture, &$nullstring, &$param, &$params, &$v) {
	$퍀pos = $GLOBALS['%s']->length;
	throw new HException(new thx_error_Error("Unsupported type format: {0}", null, Type::typeof($v), _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 42, "className" => "Dynamics", "methodName" => "formatf"))));
}
