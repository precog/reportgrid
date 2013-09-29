<?php

class thx_color_Rgb {
	public function __construct($r, $g, $b) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.color.Rgb::new");
		$»spos = $GLOBALS['%s']->length;
		$this->red = Ints::clamp($r, 0, 255);
		$this->green = Ints::clamp($g, 0, 255);
		$this->blue = Ints::clamp($b, 0, 255);
		$GLOBALS['%s']->pop();
	}}
	public $blue;
	public $green;
	public $red;
	public function int() {
		$GLOBALS['%s']->push("thx.color.Rgb::int");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ($this->red & 255) << 16 | ($this->green & 255) << 8 | $this->blue & 255;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function hex($prefix) {
		$GLOBALS['%s']->push("thx.color.Rgb::hex");
		$»spos = $GLOBALS['%s']->length;
		if($prefix === null) {
			$prefix = "";
		}
		{
			$»tmp = $prefix . StringTools::hex($this->red, 2) . StringTools::hex($this->green, 2) . StringTools::hex($this->blue, 2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toCss() {
		$GLOBALS['%s']->push("thx.color.Rgb::toCss");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->hex("#");
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toRgbString() {
		$GLOBALS['%s']->push("thx.color.Rgb::toRgbString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = "rgb(" . $this->red . "," . $this->green . "," . $this->blue . ")";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("thx.color.Rgb::toString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->toRgbString();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
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
		$GLOBALS['%s']->push("thx.color.Rgb::fromFloats");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new thx_color_Rgb(thx_color_Rgb_0($b, $g, $r), thx_color_Rgb_1($b, $g, $r), thx_color_Rgb_2($b, $g, $r));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromInt($v) {
		$GLOBALS['%s']->push("thx.color.Rgb::fromInt");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new thx_color_Rgb($v >> 16 & 255, $v >> 8 & 255, $v & 255);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function equals($a, $b) {
		$GLOBALS['%s']->push("thx.color.Rgb::equals");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $a->red === $b->red && $a->green === $b->green && $a->blue === $b->blue;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function darker($color, $t, $equation) {
		$GLOBALS['%s']->push("thx.color.Rgb::darker");
		$»spos = $GLOBALS['%s']->length;
		$interpolator = Ints::interpolatef(0, 255, $equation);
		$t /= 255;
		{
			$»tmp = new thx_color_Rgb(call_user_func_array($interpolator, array($t * $color->red)), call_user_func_array($interpolator, array($t * $color->green)), call_user_func_array($interpolator, array($t * $color->blue)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($a, $b, $t, $equation) {
		$GLOBALS['%s']->push("thx.color.Rgb::interpolate");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new thx_color_Rgb(thx_color_Rgb_3($a, $b, $equation, $t), thx_color_Rgb_4($a, $b, $equation, $t), thx_color_Rgb_5($a, $b, $equation, $t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolatef($a, $b, $equation) {
		$GLOBALS['%s']->push("thx.color.Rgb::interpolatef");
		$»spos = $GLOBALS['%s']->length;
		$r = Ints::interpolatef($a->red, $b->red, $equation); $g = Ints::interpolatef($a->green, $b->green, $equation); $b1 = Ints::interpolatef($a->blue, $b->blue, $equation);
		{
			$»tmp = array(new _hx_lambda(array(&$a, &$b, &$b1, &$equation, &$g, &$r), "thx_color_Rgb_6"), 'execute');
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function contrast($c) {
		$GLOBALS['%s']->push("thx.color.Rgb::contrast");
		$»spos = $GLOBALS['%s']->length;
		$nc = thx_color_Hsl::toHsl($c);
		if($nc->lightness < .5) {
			$»tmp = new thx_color_Hsl($nc->hue, $nc->saturation, $nc->lightness + 0.5);
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = new thx_color_Hsl($nc->hue, $nc->saturation, $nc->lightness - 0.5);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function contrastBW($c) {
		$GLOBALS['%s']->push("thx.color.Rgb::contrastBW");
		$»spos = $GLOBALS['%s']->length;
		$g = thx_color_Grey::toGrey($c, null);
		$nc = thx_color_Hsl::toHsl($c);
		if($g->grey < .5) {
			$»tmp = new thx_color_Hsl($nc->hue, $nc->saturation, 1.0);
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = new thx_color_Hsl($nc->hue, $nc->saturation, 0);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return $this->toString(); }
}
function thx_color_Rgb_0(&$b, &$g, &$r) {
	$»spos = $GLOBALS['%s']->length;
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($r)) * 255);
	}
}
function thx_color_Rgb_1(&$b, &$g, &$r) {
	$»spos = $GLOBALS['%s']->length;
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($g)) * 255);
	}
}
function thx_color_Rgb_2(&$b, &$g, &$r) {
	$»spos = $GLOBALS['%s']->length;
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($b)) * 255);
	}
}
function thx_color_Rgb_3(&$a, &$b, &$equation, &$t) {
	$»spos = $GLOBALS['%s']->length;
	{
		$min = $a->red; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->red - $min));
	}
}
function thx_color_Rgb_4(&$a, &$b, &$equation, &$t) {
	$»spos = $GLOBALS['%s']->length;
	{
		$min = $a->green; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->green - $min));
	}
}
function thx_color_Rgb_5(&$a, &$b, &$equation, &$t) {
	$»spos = $GLOBALS['%s']->length;
	{
		$min = $a->blue; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->blue - $min));
	}
}
function thx_color_Rgb_6(&$a, &$b, &$b1, &$equation, &$g, &$r, $t) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("thx.color.Rgb::interpolatef@97");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = new thx_color_Rgb(call_user_func_array($r, array($t)), call_user_func_array($g, array($t)), call_user_func_array($b1, array($t)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
