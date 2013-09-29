<?php

class thx_culture_Culture extends thx_culture_Info {
	public $language;
	public $date;
	public $englishCurrency;
	public $nativeCurrency;
	public $currencySymbol;
	public $currencyIso;
	public $englishRegion;
	public $nativeRegion;
	public $isMetric;
	public $digits;
	public $signNeg;
	public $signPos;
	public $symbolNaN;
	public $symbolPercent;
	public $symbolPermille;
	public $symbolNegInf;
	public $symbolPosInf;
	public $number;
	public $currency;
	public $percent;
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
	static $cultures;
	static function getCultures() {
		$GLOBALS['%s']->push("thx.culture.Culture::getCultures");
		$»spos = $GLOBALS['%s']->length;
		if(null === thx_culture_Culture::$cultures) {
			thx_culture_Culture::$cultures = new Hash();
		}
		{
			$»tmp = thx_culture_Culture::$cultures;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function get($name) {
		$GLOBALS['%s']->push("thx.culture.Culture::get");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_Culture::getCultures()->get(strtolower($name));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function names() {
		$GLOBALS['%s']->push("thx.culture.Culture::names");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_Culture::getCultures()->keys();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static $_defaultCulture;
	static $defaultCulture;
	static function getDefaultCulture() {
		$GLOBALS['%s']->push("thx.culture.Culture::getDefaultCulture");
		$»spos = $GLOBALS['%s']->length;
		if(null === thx_culture_Culture::$_defaultCulture) {
			$»tmp = thx_cultures_EnUS::getCulture();
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = thx_culture_Culture::$_defaultCulture;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function setDefaultCulture($culture) {
		$GLOBALS['%s']->push("thx.culture.Culture::setDefaultCulture");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = thx_culture_Culture::$_defaultCulture = $culture;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function add($culture) {
		$GLOBALS['%s']->push("thx.culture.Culture::add");
		$»spos = $GLOBALS['%s']->length;
		if(null === thx_culture_Culture::$_defaultCulture) {
			thx_culture_Culture::$_defaultCulture = $culture;
		}
		$name = strtolower($culture->name);
		if(!thx_culture_Culture::getCultures()->exists($name)) {
			thx_culture_Culture::getCultures()->set($name, $culture);
		}
		$GLOBALS['%s']->pop();
	}
	static function loadAll() {
		$GLOBALS['%s']->push("thx.culture.Culture::loadAll");
		$»spos = $GLOBALS['%s']->length;
		$dir = php_Sys::getCwd() . "lib/thx/cultures/";
		{
			$_g = 0; $_g1 = php_FileSystem::readDirectory($dir);
			while($_g < $_g1->length) {
				$file = $_g1[$_g];
				++$_g;
				require_once($dir . $file);
				unset($file);
			}
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.culture.Culture'; }
}
