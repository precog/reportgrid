<?php

class thx_languages_En extends thx_culture_Language {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$this->name = "en";
		$this->english = "English";
		$this->native = "English";
		$this->iso2 = "en";
		$this->iso3 = "eng";
		$this->pluralRule = 1;
		thx_culture_Language::add($this);
	}}
	static $language;
	static function getLanguage() {
		if(null === thx_languages_En::$language) {
			thx_languages_En::$language = new thx_languages_En();
		}
		return thx_languages_En::$language;
	}
	static $__properties__ = array("get_language" => "getLanguage","get_languages" => "getLanguages");
	function __toString() { return 'thx.languages.En'; }
}
thx_languages_En::getLanguage();
