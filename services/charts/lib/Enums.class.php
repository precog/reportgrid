<?php

class Enums {
	public function __construct(){}
	static function string($e) {
		$cons = Type::enumConstructor($e);
		$params = new _hx_array(array());
		{
			$_g = 0; $_g1 = Type::enumParameters($e);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$params->push(Dynamics::string($param));
				unset($param);
			}
		}
		return $cons . (Enums_0($cons, $e, $params));
	}
	static function compare($a, $b) {
		$v = null;
		if(($v = $a->index - $b->index) !== 0) {
			return $v;
		}
		return Arrays::compare(Type::enumParameters($a), Type::enumParameters($b));
	}
	function __toString() { return 'Enums'; }
}
function Enums_0(&$cons, &$e, &$params) {
	if($params->length === 0) {
		return "";
	} else {
		return "(" . $params->join(", ") . ")";
	}
}
