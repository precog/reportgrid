<?php

class thx_languages_En extends thx_culture_Language {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.languages.En::new");
		$»spos = $GLOBALS['%s']->length;
		$this->name = "en";
		$this->english = "English";
		$this->native = "English";
		$this->iso2 = "en";
		$this->iso3 = "eng";
		$this->pluralRule = 1;
		thx_culture_Language::add($this);
		$GLOBALS['%s']->pop();
	}}
	static $language;
	static function getLanguage() {
		$GLOBALS['%s']->push("thx.languages.En::getLanguage");
		$»spos = $GLOBALS['%s']->length;
		if(null === thx_languages_En::$language) {
			thx_languages_En::$language = new thx_languages_En();
		}
		{
			$»tmp = thx_languages_En::$language;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.languages.En'; }
}
thx_languages_En::getLanguage();
