<?php

class thx_color_Grey extends thx_color_Rgb {
	public function __construct($value) {
		if(!php_Boot::$skip_constructor) {
		$this->grey = Floats::normalize($value);
		$c = thx_color_Grey_0($this, $value);
		parent::__construct($c,$c,$c);
	}}
	public $grey;
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
	static function toGrey($rgb, $luminance) {
		if(null === $luminance) {
			$luminance = thx_color_PerceivedLuminance::$Perceived;
		}
		$»t = ($luminance);
		switch($»t->index) {
		case 0:
		{
			return new thx_color_Grey($rgb->red / 255 * .2126 + $rgb->green / 255 * .7152 + $rgb->blue / 255 * .0722);
		}break;
		case 1:
		{
			return new thx_color_Grey($rgb->red / 255 * .299 + $rgb->green / 255 * .587 + $rgb->blue / 255 * .114);
		}break;
		case 2:
		{
			return new thx_color_Grey(Math::sqrt(0.241 * Math::pow($rgb->red / 255, 2) + 0.691 * Math::pow($rgb->green / 255, 2) + 0.068 * Math::pow($rgb->blue / 255, 2)));
		}break;
		}
	}
	static function equals($a, $b) {
		return $a->grey === $b->grey;
	}
	static function darker($color, $t, $equation) {
		$v = $t * $color->grey;
		return new thx_color_Grey(Floats::interpolate($v, 0, 1, $equation));
	}
	static function interpolate($a, $b, $t, $equation) {
		return new thx_color_Grey(Floats::interpolate($t, $a->grey, $b->grey, $equation));
	}
	function __toString() { return 'thx.color.Grey'; }
}
function thx_color_Grey_0(&$»this, &$value) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($»this->grey)) * 255);
	}
}
