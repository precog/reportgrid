<?php

class thx_text_ERegs {
	public function __construct(){}
	static $_escapePattern;
	static function escapeERegChars($s) {
		return thx_text_ERegs::$_escapePattern->customReplace($s, array(new _hx_lambda(array(&$s), "thx_text_ERegs_0"), 'execute'));
	}
	function __toString() { return 'thx.text.ERegs'; }
}
thx_text_ERegs::$_escapePattern = new EReg("[*+?|{[()^\$.# \\\\]", "");
function thx_text_ERegs_0(&$s, $e) {
	{
		return "\\" . $e->matched(0);
	}
}
