<?php

class thx_color_Cmyk extends thx_color_Rgb {
	public function __construct($cyan, $magenta, $yellow, $black) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct(thx_color_Cmyk_0($this, $black, $cyan, $magenta, $yellow),thx_color_Cmyk_1($this, $black, $cyan, $magenta, $yellow),thx_color_Cmyk_2($this, $black, $cyan, $magenta, $yellow));
		$this->cyan = Floats::normalize($cyan);
		$this->magenta = Floats::normalize($magenta);
		$this->yellow = Floats::normalize($yellow);
		$this->black = Floats::normalize($black);
	}}
	public $black;
	public $cyan;
	public $magenta;
	public $yellow;
	public function toCmykString() {
		return "cmyk(" . $this->cyan . "," . $this->magenta . "," . $this->yellow . "," . $this->black . ")";
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
	static function toCmyk($rgb) {
		$c = 0.0; $y = 0.0; $m = 0.0; $k = null;
		if($rgb->red + $rgb->blue + $rgb->green === 0) {
			$k = 1.0;
		} else {
			$c = 1 - $rgb->red / 255;
			$m = 1 - $rgb->green / 255;
			$y = 1 - $rgb->blue / 255;
			$k = thx_color_Cmyk_3($c, $k, $m, $rgb, $y);
			$c = ($c - $k) / (1 - $k);
			$m = ($m - $k) / (1 - $k);
			$y = ($y - $k) / (1 - $k);
		}
		return new thx_color_Cmyk($c, $m, $y, $k);
	}
	static function equals($a, $b) {
		return $a->black === $b->black && $a->cyan === $b->cyan && $a->magenta === $b->magenta && $a->yellow === $b->yellow;
	}
	static function darker($color, $t, $equation) {
		$v = $t * $color->black;
		return new thx_color_Cmyk($color->cyan, $color->magenta, $color->yellow, Floats::interpolate($v, 0, 1, $equation));
	}
	static function interpolate($a, $b, $t, $equation) {
		return new thx_color_Cmyk(Floats::interpolate($t, $a->cyan, $b->cyan, $equation), Floats::interpolate($t, $a->magenta, $b->magenta, $equation), Floats::interpolate($t, $a->yellow, $b->yellow, $equation), Floats::interpolate($t, $a->black, $b->black, $equation));
	}
	function __toString() { return 'thx.color.Cmyk'; }
}
function thx_color_Cmyk_0(&$»this, &$black, &$cyan, &$magenta, &$yellow) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(Floats::normalize(1 - $cyan - $black))) * 255);
	}
}
function thx_color_Cmyk_1(&$»this, &$black, &$cyan, &$magenta, &$yellow) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(Floats::normalize(1 - $magenta - $black))) * 255);
	}
}
function thx_color_Cmyk_2(&$»this, &$black, &$cyan, &$magenta, &$yellow) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(Floats::normalize(1 - $yellow - $black))) * 255);
	}
}
function thx_color_Cmyk_3(&$c, &$k, &$m, &$rgb, &$y) {
	{
		$a = (($c < $m) ? $c : $m);
		if($a < $y) {
			return $a;
		} else {
			return $y;
		}
		unset($a);
	}
}
