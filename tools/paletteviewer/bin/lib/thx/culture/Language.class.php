<?php

class thx_culture_Language extends thx_culture_Info {
	static $languages;
	static function getLanguages() {
		$GLOBALS['%s']->push("thx.culture.Language::getLanguages");
		$�spos = $GLOBALS['%s']->length;
		if(null === thx_culture_Language::$languages) {
			thx_culture_Language::$languages = new Hash();
		}
		{
			$�tmp = thx_culture_Language::$languages;
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function get($name) {
		$GLOBALS['%s']->push("thx.culture.Language::get");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_Language::getLanguages()->get(strtolower($name));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function names() {
		$GLOBALS['%s']->push("thx.culture.Language::names");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = thx_culture_Language::getLanguages()->keys();
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function add($language) {
		$GLOBALS['%s']->push("thx.culture.Language::add");
		$�spos = $GLOBALS['%s']->length;
		if(!thx_culture_Language::getLanguages()->exists($language->iso2)) {
			thx_culture_Language::getLanguages()->set($language->iso2, $language);
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.culture.Language'; }
}
