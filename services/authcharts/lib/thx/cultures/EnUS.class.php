<?php

class thx_cultures_EnUS extends thx_culture_Culture {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$this->language = thx_languages_En::getLanguage();
		$this->name = "en-US";
		$this->english = "English (United States)";
		$this->native = "English (United States)";
		$this->date = new thx_culture_core_DateTimeInfo(new _hx_array(array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "")), new _hx_array(array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "")), new _hx_array(array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")), new _hx_array(array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat")), new _hx_array(array("Su", "Mo", "Tu", "We", "Th", "Fr", "Sa")), "AM", "PM", "/", ":", 0, "%B, %Y", "%B %d", "%A, %B %d, %Y", "%f/%e/%Y", "%a, %d %b %Y %H:%M:%S GMT", "%A, %B %d, %Y %l:%M:%S %p", "%Y-%m-%d %H:%M:%SZ", "%Y-%m-%dT%H:%M:%S", "%l:%M:%S %p", "%l:%M %p");
		$this->symbolNaN = "NaN";
		$this->symbolPercent = "%";
		$this->symbolPermille = "‰";
		$this->signNeg = "-";
		$this->signPos = "+";
		$this->symbolNegInf = "-Infinity";
		$this->symbolPosInf = "Infinity";
		$this->number = new thx_culture_core_NumberInfo(2, ".", new _hx_array(array(3)), ",", "-n", "n");
		$this->currency = new thx_culture_core_NumberInfo(2, ".", new _hx_array(array(3)), ",", "(\$n)", "\$n");
		$this->percent = new thx_culture_core_NumberInfo(2, ".", new _hx_array(array(3)), ",", "-n %", "n %");
		$this->pluralRule = 1;
		$this->englishCurrency = "US Dollar";
		$this->nativeCurrency = "US Dollar";
		$this->currencySymbol = "\$";
		$this->currencyIso = "USD";
		$this->englishRegion = "United States";
		$this->nativeRegion = "United States";
		$this->iso2 = "US";
		$this->iso3 = "USA";
		$this->isMetric = false;
		thx_culture_Culture::add($this);
	}}
	static $culture;
	static function getCulture() {
		if(null === thx_cultures_EnUS::$culture) {
			thx_cultures_EnUS::$culture = new thx_cultures_EnUS();
		}
		return thx_cultures_EnUS::$culture;
	}
	function __toString() { return 'thx.cultures.EnUS'; }
}
thx_cultures_EnUS::getCulture();
