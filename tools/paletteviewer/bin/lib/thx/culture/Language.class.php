<?php

class thx_culture_Language extends thx_culture_Info {
	static $languages;
	static function getLanguages() {
		$GLOBALS['%s']->push("thx.culture.Language::getLanguages");
		$製pos = $GLOBALS['%s']->length;
		if(null === thx_culture_Language::$languages) {
			thx_culture_Language::$languages = new Hash();
		}
		{
			$裨mp = thx_culture_Language::$languages;
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function get($name) {
		$GLOBALS['%s']->push("thx.culture.Language::get");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_Language::getLanguages()->get(strtolower($name));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function names() {
		$GLOBALS['%s']->push("thx.culture.Language::names");
		$製pos = $GLOBALS['%s']->length;
		{
			$裨mp = thx_culture_Language::getLanguages()->keys();
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
	static function add($language) {
		$GLOBALS['%s']->push("thx.culture.Language::add");
		$製pos = $GLOBALS['%s']->length;
		if(!thx_culture_Language::getLanguages()->exists($language->iso2)) {
			thx_culture_Language::getLanguages()->set($language->iso2, $language);
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.culture.Language'; }
}
