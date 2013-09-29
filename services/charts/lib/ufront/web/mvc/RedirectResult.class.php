<?php

class ufront_web_mvc_RedirectResult extends ufront_web_mvc_ActionResult {
	public function __construct($url, $permanentRedirect) {
		if(!php_Boot::$skip_constructor) {
		if($permanentRedirect === null) {
			$permanentRedirect = false;
		}
		if(null === $url) {
			throw new HException(new thx_error_NullArgument("url", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "RedirectResult.hx", "lineNumber" => 13, "className" => "ufront.web.mvc.RedirectResult", "methodName" => "new"))));
		}
		$this->url = $url;
		$this->permanentRedirect = $permanentRedirect;
	}}
	public $url;
	public $permanentRedirect;
	public function executeResult($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "RedirectResult.hx", "lineNumber" => 20, "className" => "ufront.web.mvc.RedirectResult", "methodName" => "executeResult"))));
		}
		$controllerContext->response->clear();
		if($this->permanentRedirect) {
			$controllerContext->response->permanentRedirect($this->url);
		} else {
			$controllerContext->response->redirect($this->url);
		}
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
	function __toString() { return 'ufront.web.mvc.RedirectResult'; }
}
