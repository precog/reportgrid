<?php

class thx_color_Cmyk extends thx_color_Rgb {
	public function __construct($cyan, $magenta, $yellow, $black) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.color.Cmyk::new");
		$»spos = $GLOBALS['%s']->length;
		parent::__construct(thx_color_Cmyk_0($this, $black, $cyan, $magenta, $yellow),thx_color_Cmyk_1($this, $black, $cyan, $magenta, $yellow),thx_color_Cmyk_2($this, $black, $cyan, $magenta, $yellow));
		$this->cyan = Floats::normalize($cyan);
		$this->magenta = Floats::normalize($magenta);
		$this->yellow = Floats::normalize($yellow);
		$this->black = Floats::normalize($black);
		$GLOBALS['%s']->pop();
	}}
	public $black;
	public $cyan;
	public $magenta;
	public $yellow;
	public function toCmykString() {
		$GLOBALS['%s']->push("thx.color.Cmyk::toCmykString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = "cmyk(" . $this->cyan . "," . $this->magenta . "," . $this->yellow . "," . $this->black . ")";
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
	static function toCmyk($rgb) {
		$GLOBALS['%s']->push("thx.color.Cmyk::toCmyk");
		$»spos = $GLOBALS['%s']->length;
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
		{
			$»tmp = new thx_color_Cmyk($c, $m, $y, $k);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function equals($a, $b) {
		$GLOBALS['%s']->push("thx.color.Cmyk::equals");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $a->black === $b->black && $a->cyan === $b->cyan && $a->magenta === $b->magenta && $a->yellow === $b->yellow;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function darker($color, $t, $equation) {
		$GLOBALS['%s']->push("thx.color.Cmyk::darker");
		$»spos = $GLOBALS['%s']->length;
		$v = $t * $color->black;
		{
			$»tmp = new thx_color_Cmyk($color->cyan, $color->magenta, $color->yellow, Floats::interpolate($v, 0, 1, $equation));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function interpolate($a, $b, $t, $equation) {
		$GLOBALS['%s']->push("thx.color.Cmyk::interpolate");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new thx_color_Cmyk(Floats::interpolate($t, $a->cyan, $b->cyan, $equation), Floats::interpolate($t, $a->magenta, $b->magenta, $equation), Floats::interpolate($t, $a->yellow, $b->yellow, $equation), Floats::interpolate($t, $a->black, $b->black, $equation));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.color.Cmyk'; }
}
function thx_color_Cmyk_0(&$»this, &$black, &$cyan, &$magenta, &$yellow) {
	$»spos = $GLOBALS['%s']->length;
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(Floats::normalize(1 - $cyan - $black))) * 255);
	}
}
function thx_color_Cmyk_1(&$»this, &$black, &$cyan, &$magenta, &$yellow) {
	$»spos = $GLOBALS['%s']->length;
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(Floats::normalize(1 - $magenta - $black))) * 255);
	}
}
function thx_color_Cmyk_2(&$»this, &$black, &$cyan, &$magenta, &$yellow) {
	$»spos = $GLOBALS['%s']->length;
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array(Floats::normalize(1 - $yellow - $black))) * 255);
	}
}
function thx_color_Cmyk_3(&$c, &$k, &$m, &$rgb, &$y) {
	$»spos = $GLOBALS['%s']->length;
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
