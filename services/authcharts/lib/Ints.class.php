<?php

class Ints {
	public function __construct(){}
	static function range($start, $stop, $step) {
		if($step === null) {
			$step = 1;
		}
		if(null === $stop) {
			$stop = $start;
			$start = 0;
		}
		if(($stop - $start) / $step === Math::$POSITIVE_INFINITY) {
			throw new HException(new thx_error_Error("infinite range", null, null, _hx_anonymous(array("fileName" => "Ints.hx", "lineNumber" => 19, "className" => "Ints", "methodName" => "range"))));
		}
		$range = new _hx_array(array()); $i = -1; $j = null;
		if($step < 0) {
			while(($j = $start + $step * ++$i) > $stop) {
				$range->push($j);
			}
		} else {
			while(($j = $start + $step * ++$i) < $stop) {
				$range->push($j);
			}
		}
		return $range;
	}
	static function sign($v) {
		return (($v < 0) ? -1 : 1);
	}
	static function abs($a) {
		return (($a < 0) ? -$a : $a);
	}
	static function min($a, $b) {
		return (($a < $b) ? $a : $b);
	}
	static function max($a, $b) {
		return (($a > $b) ? $a : $b);
	}
	static function wrap($v, $min, $max) {
		return Math::round(Floats::wrap($v, $min, $max));
	}
	static function clamp($v, $min, $max) {
		if($v < $min) {
			return $min;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function clampSym($v, $max) {
		if($v < -$max) {
			return -$max;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function interpolate($f, $min, $max, $equation) {
		if($max === null) {
			$max = 100.0;
		}
		if($min === null) {
			$min = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation, array($f)) * ($max - $min));
	}
	static function interpolatef($min, $max, $equation) {
		if($max === null) {
			$max = 1.0;
		}
		if($min === null) {
			$min = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		$d = $max - $min;
		return array(new _hx_lambda(array(&$d, &$equation, &$max, &$min), "Ints_0"), 'execute');
	}
	static function format($v, $param, $params, $culture) {
		return Ints::formatf($param, $params, $culture)($v);
	}
	static function formatf($param, $params, $culture) {
		return Floats::formatf(null, thx_culture_FormatParams::params($param, $params, "I"), $culture);
	}
	static $_reparse;
	static function canParse($s) {
		return Ints::$_reparse->match($s);
	}
	static function parse($s) {
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		return Std::parseInt($s);
	}
	static function compare($a, $b) {
		return $a - $b;
	}
	function __toString() { return 'Ints'; }
}
Ints::$_reparse = new EReg("^([+-])?\\d+\$", "");
function Ints_0(&$d, &$equation, &$max, &$min, $f) {
	{
		return Math::round($min + call_user_func_array($equation, array($f)) * $d);
	}
}
