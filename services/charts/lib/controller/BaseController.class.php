<?php

class controller_BaseController extends ufront_web_mvc_Controller {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $urlHelper;
	public function getUrlHelper() {
		if(null === $this->urlHelper) {
			$this->urlHelper = new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext);
		}
		return $this->urlHelper;
	}
	public function error($message, $format) {
		return $this->output(_hx_anonymous(array("error" => $message)), $format, _hx_qtype("template.Error"));
	}
	public function output($data, $format, $templateClass) {
		$format = $this->normalizeFormat($format);
		switch($format) {
		case "html":{
			$template = Type::createInstance($templateClass, new _hx_array(array()));
			$content = _hx_anonymous(array("baseurl" => App::baseUrl(), "url" => $this->getUrlHelper(), "data" => $data));
			return new ufront_web_mvc_ContentResult($template->execute($content), null);
		}break;
		case "json":{
			return ufront_web_mvc_JsonPResult::auto($data, $this->controllerContext->request->getQuery()->get("callback"));
		}break;
		default:{
			controller_BaseController_0($this, $data, $format, $templateClass);
		}break;
		}
	}
	public function normalizeFormat($f) {
		$f = strtolower($f);
		return controller_BaseController_1($this, $f);
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
	static $__rtti = "<class path=\"controller.BaseController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<urlHelper public=\"1\" get=\"getUrlHelper\" set=\"null\"><c path=\"ufront.web.mvc.view.UrlHelperInst\"/></urlHelper>\x0A\x09<getUrlHelper set=\"method\" line=\"13\"><f a=\"\"><c path=\"ufront.web.mvc.view.UrlHelperInst\"/></f></getUrlHelper>\x0A\x09<error set=\"method\" line=\"22\"><f a=\"message:format\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></error>\x0A\x09<output params=\"T\" set=\"method\" line=\"27\"><f a=\"data:format:templateClass\">\x0A\x09<c path=\"output.T\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"Class\"><d/></c>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></output>\x0A\x09<normalizeFormat set=\"method\" line=\"46\"><f a=\"f\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></normalizeFormat>\x0A\x09<new public=\"1\" set=\"method\" line=\"10\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	static $__properties__ = array("get_urlHelper" => "getUrlHelper","set_invoker" => "setInvoker","get_invoker" => "getInvoker","set_valueProvider" => "setValueProvider","get_valueProvider" => "getValueProvider");
	function __toString() { return 'controller.BaseController'; }
}
function controller_BaseController_0(&$»this, &$data, &$format, &$templateClass) {
	throw new HException(new thx_error_Error("invalid format '{0}'", new _hx_array(array($format)), null, _hx_anonymous(array("fileName" => "BaseController.hx", "lineNumber" => 42, "className" => "controller.BaseController", "methodName" => "output"))));
}
function controller_BaseController_1(&$»this, &$f) {
	switch($f) {
	case "html":case "json":{
		return $f;
	}break;
	default:{
		return "html";
	}break;
	}
}
