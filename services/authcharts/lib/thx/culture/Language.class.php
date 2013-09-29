<?php

class thx_culture_Language extends thx_culture_Info {
	static $languages;
	static function getLanguages() {
		if(null === thx_culture_Language::$languages) {
			thx_culture_Language::$languages = new Hash();
		}
		return thx_culture_Language::$languages;
	}
	static function get($name) {
		return thx_culture_Language::getLanguages()->get(strtolower($name));
	}
	static function names() {
		return thx_culture_Language::getLanguages()->keys();
	}
	static function add($language) {
		if(!thx_culture_Language::getLanguages()->exists($language->iso2)) {
			thx_culture_Language::getLanguages()->set($language->iso2, $language);
		}
	}
	function __toString() { return 'thx.culture.Language'; }
}
