<?php

class Objects {
	public function __construct(){}
	static function field($o, $fieldname, $alt) {
		$GLOBALS['%s']->push("Objects::field");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = ((_hx_has_field($o, $fieldname)) ? Reflect::field($o, $fieldname) : $alt);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function keys($o) {
		$GLOBALS['%s']->push("Objects::keys");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Reflect::fields($o);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function values($o) {
		$GLOBALS['%s']->push("Objects::values");
		$�spos = $GLOBALS['%s']->length;
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(Reflect::field($o, $key));
				unset($key);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function entries($o) {
		$GLOBALS['%s']->push("Objects::entries");
		$�spos = $GLOBALS['%s']->length;
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(_hx_anonymous(array("key" => $key, "value" => Reflect::field($o, $key))));
				unset($key);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function with($ob, $f) {
		$GLOBALS['%s']->push("Objects::with");
		$�spos = $GLOBALS['%s']->length;
		call_user_func_array($f, array($ob));
		{
			$GLOBALS['%s']->pop();
			return $ob;
		}
		$GLOBALS['%s']->pop();
	}
	static function toHash($ob) {
		$GLOBALS['%s']->push("Objects::toHash");
		$�spos = $GLOBALS['%s']->length;
		$hash = new Hash();
		{
			$�tmp = Objects::copyToHash($ob, $hash);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function copyToHash($ob, $hash) {
		$GLOBALS['%s']->push("Objects::copyToHash");
		$�spos = $GLOBALS['%s']->length;
		{
			$_g = 0; $_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$hash->set($field, Reflect::field($ob, $field));
				unset($field);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $hash;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($v, $a, $b, $equation) {
		$GLOBALS['%s']->push("Objects::interpolate");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Objects::interpolatef($a, $b, $equation), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("Objects::interpolatef");
		$�spos = $GLOBALS['%s']->length;
		$i = _hx_anonymous(array()); $c = _hx_anonymous(array()); $keys = Reflect::fields($a);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(_hx_has_field($b, $key)) {
					$va = Reflect::field($a, $key);
					$i->{$key} = call_user_func_array(Objects::interpolateByName($key, $va), array($va, Reflect::field($b, $key), null));
					unset($va);
				} else {
					$c->{$key} = Reflect::field($a, $key);
				}
				unset($key);
			}
		}
		$keys = Reflect::fields($b);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(!_hx_has_field($a, $key)) {
					$c->{$key} = Reflect::field($b, $key);
				}
				unset($key);
			}
		}
		{
			$�tmp = array(new _hx_lambda(array(&$a, &$b, &$c, &$equation, &$i, &$keys), "Objects_0"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_reCheckKeyIsColor;
	static function interpolateByName($k, $v) {
		$GLOBALS['%s']->push("Objects::interpolateByName");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = Objects_1($k, $v);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function copyTo($src, $dst) {
		$GLOBALS['%s']->push("Objects::copyTo");
		$�spos = $GLOBALS['%s']->length;
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$sv = Dynamics::hclone(Reflect::field($src, $field));
				$dv = Reflect::field($dst, $field);
				if(Reflect::isObject($sv) && null === Type::getClass($sv) && (Reflect::isObject($dv) && null === Type::getClass($dv))) {
					Objects::copyTo($sv, $dv);
				} else {
					$dst->{$field} = $sv;
				}
				unset($sv,$field,$dv);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $dst;
		}
		$GLOBALS['%s']->pop();
	}
	static function hclone($src) {
		$GLOBALS['%s']->push("Objects::clone");
		$�spos = $GLOBALS['%s']->length;
		$dst = _hx_anonymous(array());
		{
			$�tmp = Objects::copyTo($src, $dst);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function mergef($ob, $new_ob, $f) {
		$GLOBALS['%s']->push("Objects::mergef");
		$�spos = $GLOBALS['%s']->length;
		$_g = 0; $_g1 = Reflect::fields($new_ob);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$new_val = Reflect::field($new_ob, $field);
			if(_hx_has_field($ob, $field)) {
				$old_val = Reflect::field($ob, $field);
				$ob->{$field} = call_user_func_array($f, array($field, $old_val, $new_val));
				unset($old_val);
			} else {
				$ob->{$field} = $new_val;
			}
			unset($new_val,$field);
		}
		$GLOBALS['%s']->pop();
	}
	static function merge($ob, $new_ob) {
		$GLOBALS['%s']->push("Objects::merge");
		$�spos = $GLOBALS['%s']->length;
		Objects::mergef($ob, $new_ob, array(new _hx_lambda(array(&$new_ob, &$ob), "Objects_2"), 'execute'));
		$GLOBALS['%s']->pop();
	}
	static function _flatten($src, $cum, $arr, $levels, $level) {
		$GLOBALS['%s']->push("Objects::_flatten");
		$�spos = $GLOBALS['%s']->length;
		$_g = 0; $_g1 = Reflect::fields($src);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$clone = Objects::hclone($cum);
			$v = Reflect::field($src, $field);
			$clone->fields->push($field);
			if(Reflect::isObject($v) && null === Type::getClass($v) && ($levels === 0 || $level + 1 < $levels)) {
				Objects::_flatten($v, $clone, $arr, $levels, $level + 1);
			} else {
				$clone->value = $v;
				$arr->push($clone);
			}
			unset($v,$field,$clone);
		}
		$GLOBALS['%s']->pop();
	}
	static function flatten($src, $levels) {
		$GLOBALS['%s']->push("Objects::flatten");
		$�spos = $GLOBALS['%s']->length;
		if($levels === null) {
			$levels = 0;
		}
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$v = Reflect::field($src, $field);
				if(Reflect::isObject($v) && null === Type::getClass($v) && $levels !== 1) {
					$item = _hx_anonymous(array("fields" => new _hx_array(array($field)), "value" => null));
					Objects::_flatten($v, $item, $arr, $levels, 1);
					unset($item);
				} else {
					$arr->push(_hx_anonymous(array("fields" => new _hx_array(array($field)), "value" => $v)));
				}
				unset($v,$field);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $arr;
		}
		$GLOBALS['%s']->pop();
	}
	static function compare($a, $b) {
		$GLOBALS['%s']->push("Objects::compare");
		$�spos = $GLOBALS['%s']->length;
		$v = null; $fields = null;
		if(($v = Arrays::compare($fields = Reflect::fields($a), Reflect::fields($b))) !== 0) {
			$GLOBALS['%s']->pop();
			return $v;
		}
		{
			$_g = 0;
			while($_g < $fields->length) {
				$field = $fields[$_g];
				++$_g;
				if(($v = Dynamics::compare(Reflect::field($a, $field), Reflect::field($b, $field))) !== 0) {
					$GLOBALS['%s']->pop();
					return $v;
				}
				unset($field);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return 0;
		}
		$GLOBALS['%s']->pop();
	}
	static function addFields($o, $fields, $values) {
		$GLOBALS['%s']->push("Objects::addFields");
		$�spos = $GLOBALS['%s']->length;
		{
			$_g1 = 0; $_g = $fields->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				Objects::addField($o, $fields[$i], $values[$i]);
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $o;
		}
		$GLOBALS['%s']->pop();
	}
	static function addField($o, $field, $value) {
		$GLOBALS['%s']->push("Objects::addField");
		$�spos = $GLOBALS['%s']->length;
		$o->{$field} = $value;
		{
			$GLOBALS['%s']->pop();
			return $o;
		}
		$GLOBALS['%s']->pop();
	}
	static function format($v, $param, $params, $culture) {
		$GLOBALS['%s']->push("Objects::format");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = call_user_func_array(Objects::formatf($param, $params, $culture), array($v));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function formatf($param, $params, $culture) {
		$GLOBALS['%s']->push("Objects::formatf");
		$�spos = $GLOBALS['%s']->length;
		$params = thx_culture_FormatParams::params($param, $params, "R");
		$format = $params->shift();
		switch($format) {
		case "O":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Objects_3"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case "R":{
			$�tmp = array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Objects_4"), 'execute');
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		default:{
			$�tmp = Objects_5($culture, $format, $param, $params);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Objects'; }
}
Objects::$_reCheckKeyIsColor = new EReg("color\\b|\\bbackground\\b|\\bstroke\\b|\\bfill\\b", "");
function Objects_0(&$a, &$b, &$c, &$equation, &$i, &$keys, $t) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Objects::interpolatef@85");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$_g = 0; $_g1 = Reflect::fields($i);
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$c->{$k} = Reflect::callMethod($i, Reflect::field($i, $k), new _hx_array(array($t)));
				unset($k);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $c;
		}
		$GLOBALS['%s']->pop();
	}
}
function Objects_1(&$k, &$v) {
	$�spos = $GLOBALS['%s']->length;
	if(Std::is($v, _hx_qtype("String")) && Objects::$_reCheckKeyIsColor->match($k)) {
		return (isset(thx_color_Colors::$interpolatef) ? thx_color_Colors::$interpolatef: array("thx_color_Colors", "interpolatef"));
	} else {
		return (isset(Dynamics::$interpolatef) ? Dynamics::$interpolatef: array("Dynamics", "interpolatef"));
	}
}
function Objects_2(&$new_ob, &$ob, $key, $old_v, $new_v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Objects::merge@153");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $new_v;
		}
		$GLOBALS['%s']->pop();
	}
}
function Objects_3(&$culture, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Objects::formatf@235");
		$�spos2 = $GLOBALS['%s']->length;
		{
			$�tmp = Std::string($v);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Objects_4(&$culture, &$format, &$param, &$params, $v) {
	$�spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Objects::formatf@237");
		$�spos2 = $GLOBALS['%s']->length;
		$buf = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($v);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$buf->push($field . ":" . Dynamics::format(Reflect::field($v, $field), null, null, null, $culture));
				unset($field);
			}
		}
		{
			$�tmp = "{" . $buf->join(",") . "}";
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Objects_5(&$culture, &$format, &$param, &$params) {
	$�spos = $GLOBALS['%s']->length;
	throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Objects.hx", "lineNumber" => 245, "className" => "Objects", "methodName" => "formatf"))));
}
