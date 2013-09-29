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
		if(null === thx_culture_Culture::$cultures) {
			thx_culture_Culture::$cultures = new Hash();
		}
		return thx_culture_Culture::$cultures;
	}
	static function get($name) {
		return thx_culture_Culture::getCultures()->get(strtolower($name));
	}
	static function names() {
		return thx_culture_Culture::getCultures()->keys();
	}
	static function exists($culture) {
		return thx_culture_Culture::getCultures()->exists(strtolower($culture));
	}
	static $_defaultCulture;
	static $defaultCulture;
	static function getDefaultCulture() {
		if(null === thx_culture_Culture::$_defaultCulture) {
			return thx_cultures_EnUS::getCulture();
		} else {
			return thx_culture_Culture::$_defaultCulture;
		}
	}
	static function setDefaultCulture($culture) {
		return thx_culture_Culture::$_defaultCulture = $culture;
	}
	static function add($culture) {
		if(null === thx_culture_Culture::$_defaultCulture) {
			thx_culture_Culture::$_defaultCulture = $culture;
		}
		$name = strtolower($culture->name);
		if(!thx_culture_Culture::getCultures()->exists($name)) {
			thx_culture_Culture::getCultures()->set($name, $culture);
		}
	}
	static function loadAll() {
		$dir = Sys::getCwd() . "lib/thx/cultures/";
		{
			$_g = 0; $_g1 = sys_FileSystem::readDirectory($dir);
			while($_g < $_g1->length) {
				$file = $_g1[$_g];
				++$_g;
				require_once($dir . $file);
				unset($file);
			}
		}
	}
	static $__properties__ = array("set_defaultCulture" => "setDefaultCulture","get_defaultCulture" => "getDefaultCulture","get_cultures" => "getCultures");
	function __toString() { return 'thx.culture.Culture'; }
}
