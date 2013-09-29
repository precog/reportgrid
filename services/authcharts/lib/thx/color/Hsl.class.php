<?php

class thx_color_Hsl extends thx_color_Rgb {
	public function __construct($h, $s, $l) {
		if(!php_Boot::$skip_constructor) {
		$this->hue = $h = Floats::circularWrap($h, 360);
		$this->saturation = $s = Floats::normalize($s);
		$this->lightness = $l = Floats::normalize($l);
		parent::__construct(thx_color_Hsl_0($this, $h, $l, $s),thx_color_Hsl_1($this, $h, $l, $s),thx_color_Hsl_2($this, $h, $l, $s));
	}}
	public $hue;
	public $saturation;
	public $lightness;
	public function toHslString() {
		return "hsl(" . $this->hue . "," . $this->saturation * 100 . "%," . $this->lightness * 100 . "%)";
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static function _c($d, $s, $l) {
		$m2 = thx_color_Hsl_3($d, $l, $s);
		$m1 = 2 * $l - $m2;
		$d = Floats::circularWrap($d, 360);
		if($d < 60) {
			return $m1 + ($m2 - $m1) * $d / 60;
		} else {
			if($d < 180) {
				return $m2;
			} else {
				if($d < 240) {
					return $m1 + ($m2 - $m1) * (240 - $d) / 60;
				} else {
					return $m1;
				}
			}
		}
	}
	static function toHsl($c) {
		$r = $c->red / 255.0;
		$g = $c->green / 255.0; $b = $c->blue / 255.0; $min = thx_color_Hsl_4($b, $c, $g, $r); $max = thx_color_Hsl_5($b, $c, $g, $min, $r); $delta = $max - $min; $h = null; $s = null; $l = ($max + $min) / 2;
		if($delta === 0.0) {
			$s = $h = 0.0;
		} else {
			$s = thx_color_Hsl_6($b, $c, $delta, $g, $h, $l, $max, $min, $r, $s);
			if($r === $max) {
				$h = ($g - $b) / $delta + ((($g < $b) ? 6 : 0));
			} else {
				if($g === $max) {
					$h = ($b - $r) / $delta + 2;
				} else {
					$h = ($r - $g) / $delta + 4;
				}
			}
			$h *= 60;
		}
		return new thx_color_Hsl($h, $s, $l);
	}
	static function equals($a, $b) {
		return $a->hue === $b->hue && $a->saturation === $b->saturation && $a->lightness === $b->lightness;
	}
	static function darker($color, $t, $equation) {
		$v = $color->lightness * $t;
		return new thx_color_Hsl($color->hue, $color->saturation, Floats::interpolate($v, 0, 1, $equation));
	}
	static function interpolate($a, $b, $t, $equation) {
		return new thx_color_Hsl(Floats::interpolate($t, $a->hue, $b->hue, $equation), Floats::interpolate($t, $a->saturation, $b->saturation, $equation), Floats::interpolate($t, $a->lightness, $b->lightness, $equation));
	}
	static function interpolatef($a, $b, $equation) {
		return array(new _hx_lambda(array(&$a, &$b, &$equation), "thx_color_Hsl_7"), 'execute');
	}
	function __toString() { return 'thx.color.Hsl'; }
}
function thx_color_Hsl_0(&$»this, &$h, &$l, &$s) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(thx_color_Hsl::_c($h + 120, $s, $l))) * 255);
	}
}
function thx_color_Hsl_1(&$»this, &$h, &$l, &$s) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(thx_color_Hsl::_c($h, $s, $l))) * 255);
	}
}
function thx_color_Hsl_2(&$»this, &$h, &$l, &$s) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(thx_color_Hsl::_c($h - 120, $s, $l))) * 255);
	}
}
function thx_color_Hsl_3(&$d, &$l, &$s) {
	if($l <= 0.5) {
		return $l * (1 + $s);
	} else {
		return $l + $s - $l * $s;
	}
}
function thx_color_Hsl_4(&$b, &$c, &$g, &$r) {
	{
		$a = (($r < $g) ? $r : $g);
		if($a < $b) {
			return $a;
		} else {
			return $b;
		}
		unset($a);
	}
}
function thx_color_Hsl_5(&$b, &$c, &$g, &$min, &$r) {
	{
		$a = (($r > $g) ? $r : $g);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($a);
	}
}
function thx_color_Hsl_6(&$b, &$c, &$delta, &$g, &$h, &$l, &$max, &$min, &$r, &$s) {
	if($l < 0.5) {
		return $delta / ($max + $min);
	} else {
		return $delta / (2 - $max - $min);
	}
}
function thx_color_Hsl_7(&$a, &$b, &$equation, $t) {
	{
		return new thx_color_Hsl(Floats::interpolate($t, $a->hue, $b->hue, $equation), Floats::interpolate($t, $a->saturation, $b->saturation, $equation), Floats::interpolate($t, $a->lightness, $b->lightness, $equation));
	}
}
