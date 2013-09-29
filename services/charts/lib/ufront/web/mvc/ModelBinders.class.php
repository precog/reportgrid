<?php

class ufront_web_mvc_ModelBinders {
	public function __construct(){}
	static $binders;
	function __toString() { return 'ufront.web.mvc.ModelBinders'; }
}
ufront_web_mvc_ModelBinders::$binders = new ufront_web_mvc_ModelBinderDictionary();
