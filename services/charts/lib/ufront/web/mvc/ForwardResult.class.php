<?php

class ufront_web_mvc_ForwardResult extends ufront_web_mvc_ActionResult {
	public function __construct($params, $o) {
		if(!php_Boot::$skip_constructor) {
		$this->params = ((null === $params) ? new Hash() : $params);
		if(null !== $o) {
			Hashes::importObject($this->params, $o);
		}
		if(null === $this->params->get("action")) {
			$this->params->set("action", "index");
		}
	}}
	public $params;
	public function executeResult($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ForwardResult.hx", "lineNumber" => 26, "className" => "ufront.web.mvc.ForwardResult", "methodName" => "executeResult"))));
		}
		$url = _hx_deref(new ufront_web_mvc_view_UrlHelperInst($controllerContext->requestContext))->route($this->params);
		$redirect = new ufront_web_mvc_RedirectResult($url, false);
		$redirect->executeResult($controllerContext);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return 'ufront.web.mvc.ForwardResult'; }
}
