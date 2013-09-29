<?php

interface thx_translation_ITranslation {
	//;
	function singular($id, $domain);
	function plural($ids, $idp, $quantifier, $domain);
	static $__properties__ = array("set_domain" => "setDomain","get_domain" => "getDomain");
}
