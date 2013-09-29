<?php

class thx_color_Rgb {
	public function __construct($r, $g, $b) {
		if(!php_Boot::$skip_constructor) {
		$this->red = Ints::clamp($r, 0, 255);
		$this->green = Ints::clamp($g, 0, 255);
		$this->blue = Ints::clamp($b, 0, 255);
	}}
	public $blue;
	public $green;
	public $red;
	public function int() {
		return ($this->red & 255) << 16 | ($this->green & 255) << 8 | $this->blue & 255;
	}
	public function hex($prefix) {
		if($prefix === null) {
			$prefix = "";
		}
		return $prefix . StringTools::hex($this->red, 2) . StringTools::hex($this->green, 2) . StringTools::hex($this->blue, 2);
	}
	public function toCss() {
		return $this->hex("#");
	}
	public function toRgbString() {
		return "rgb(" . $this->red . "," . $this->green . "," . $this->blue . ")";
	}
	public function toString() {
		return $this->toRgbString();
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
	static function fromFloats($r, $g, $b) {
		return new thx_color_Rgb(thx_color_Rgb_0($b, $g, $r), thx_color_Rgb_1($b, $g, $r), thx_color_Rgb_2($b, $g, $r));
	}
	static function fromInt($v) {
		return new thx_color_Rgb($v >> 16 & 255, $v >> 8 & 255, $v & 255);
	}
	static function equals($a, $b) {
		return $a->red === $b->red && $a->green === $b->green && $a->blue === $b->blue;
	}
	static function darker($color, $t, $equation) {
		$interpolator = Ints::interpolatef(0, 255, $equation);
		$t /= 255;
		return new thx_color_Rgb(call_user_func_array($interpolator, array($t * $color->red)), call_user_func_array($interpolator, array($t * $color->green)), call_user_func_array($interpolator, array($t * $color->blue)));
	}
	static function interpolate($a, $b, $t, $equation) {
		return new thx_color_Rgb(thx_color_Rgb_3($a, $b, $equation, $t), thx_color_Rgb_4($a, $b, $equation, $t), thx_color_Rgb_5($a, $b, $equation, $t));
	}
	static function interpolatef($a, $b, $equation) {
		$r = Ints::interpolatef($a->red, $b->red, $equation); $g = Ints::interpolatef($a->green, $b->green, $equation); $b1 = Ints::interpolatef($a->blue, $b->blue, $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$b1, &$equation, &$g, &$r), "thx_color_Rgb_6"), 'execute');
	}
	static function contrast($c) {
		$nc = thx_color_Hsl::toHsl($c);
		if($nc->lightness < .5) {
			return new thx_color_Hsl($nc->hue, $nc->saturation, $nc->lightness + 0.5);
		} else {
			return new thx_color_Hsl($nc->hue, $nc->saturation, $nc->lightness - 0.5);
		}
	}
	static function contrastBW($c) {
		$g = thx_color_Grey::toGrey($c, null);
		$nc = thx_color_Hsl::toHsl($c);
		if($g->grey < .5) {
			return new thx_color_Hsl($nc->hue, $nc->saturation, 1.0);
		} else {
			return new thx_color_Hsl($nc->hue, $nc->saturation, 0);
		}
	}
	static function interpolateBrightness($t, $equation) {
		return thx_color_Rgb::interpolateBrightnessf($equation)($t);
	}
	static function interpolateBrightnessf($equation) {
		$i = Ints::interpolatef(0, 255, $equation);
		return array(new _hx_lambda(array(&$equation, &$i), "thx_color_Rgb_7"), 'execute');
	}
	static function interpolateHeat($t, $middle, $equation) {
		return thx_color_Rgb::interpolateHeatf($middle, $equation)($t);
	}
	static function interpolateHeatf($middle, $equation) {
		return thx_color_Rgb::interpolateStepsf(new _hx_array(array(new thx_color_Rgb(0, 0, 0), ((null !== $middle) ? $middle : new thx_color_Rgb(255, 127, 0)), new thx_color_Rgb(255, 255, 255))), $equation);
	}
	static function interpolateRainbow($t, $equation) {
		return thx_color_Rgb::interpolateRainbowf($equation)($t);
	}
	static function interpolateRainbowf($equation) {
		return thx_color_Rgb::interpolateStepsf(new _hx_array(array(new thx_color_Rgb(0, 0, 255), new thx_color_Rgb(0, 255, 255), new thx_color_Rgb(0, 255, 0), new thx_color_Rgb(255, 255, 0), new thx_color_Rgb(255, 0, 0))), $equation);
	}
	static function interpolateStepsf($steps, $equation) {
		if($steps->length <= 0) {
			thx_color_Rgb_8($equation, $steps);
		} else {
			if($steps->length === 1) {
				return array(new _hx_lambda(array(&$equation, &$steps), "thx_color_Rgb_9"), 'execute');
			} else {
				if($steps->length === 2) {
					return thx_color_Rgb::interpolatef($steps[0], $steps[1], $equation);
				}
			}
		}
		$len = $steps->length - 1; $step = 1 / $len; $f = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $len) {
				$i = $_g++;
				$f[$i] = thx_color_Rgb::interpolatef($steps[$i], $steps[$i + 1], null);
				unset($i);
			}
		}
		return array(new _hx_lambda(array(&$equation, &$f, &$len, &$step, &$steps), "thx_color_Rgb_10"), 'execute');
	}
	function __toString() { return $this->toString(); }
}
function thx_color_Rgb_0(&$b, &$g, &$r) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($r)) * 255);
	}
}
function thx_color_Rgb_1(&$b, &$g, &$r) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($g)) * 255);
	}
}
function thx_color_Rgb_2(&$b, &$g, &$r) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($b)) * 255);
	}
}
function thx_color_Rgb_3(&$a, &$b, &$equation, &$t) {
	{
		$min = $a->red; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->red - $min));
	}
}
function thx_color_Rgb_4(&$a, &$b, &$equation, &$t) {
	{
		$min = $a->green; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->green - $min));
	}
}
function thx_color_Rgb_5(&$a, &$b, &$equation, &$t) {
	{
		$min = $a->blue; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->blue - $min));
	}
}
function thx_color_Rgb_6(&$a, &$b, &$b1, &$equation, &$g, &$r, $t) {
	{
		return new thx_color_Rgb(call_user_func_array($r, array($t)), call_user_func_array($g, array($t)), call_user_func_array($b1, array($t)));
	}
}
function thx_color_Rgb_7(&$equation, &$i, $t) {
	{
		$g = call_user_func_array($i, array($t));
		return new thx_color_Rgb($g, $g, $g);
	}
}
function thx_color_Rgb_8(&$equation, &$steps) {
	throw new HException(new thx_error_Error("invalid number of steps", null, null, _hx_anonymous(array("fileName" => "Rgb.hx", "lineNumber" => 157, "className" => "thx.color.Rgb", "methodName" => "interpolateStepsf"))));
}
function thx_color_Rgb_9(&$equation, &$steps, $t) {
	{
		return $steps[0];
	}
}
function thx_color_Rgb_10(&$equation, &$f, &$len, &$step, &$steps, $t) {
	{
		if($t < 0) {
			$t = 0;
		} else {
			if($t > 1) {
				$t = 1;
			}
		}
		$pos = thx_color_Rgb_11($equation, $f, $len, $step, $steps, $t);
		return call_user_func_array($f[$pos], array($len * ($t - $pos * $step)));
	}
}
function thx_color_Rgb_11(&$equation, &$f, &$len, &$step, &$steps, &$t) {
	if(_hx_equal($t, 1)) {
		return $len - 1;
	} else {
		return Math::floor($t / $step);
	}
}
