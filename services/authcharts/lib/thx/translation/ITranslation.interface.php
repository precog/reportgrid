<?php

interface thx_translation_ITranslation {
	//;
	function _($id, $domain);
	function __($ids, $idp, $quantifier, $domain);
}
