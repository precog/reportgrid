<?php

class ufront_web_mvc_Controller extends ufront_web_mvc_ControllerBase implements ufront_web_mvc_IExceptionFilter, ufront_web_mvc_IResultFilter, ufront_web_mvc_IAuthorizationFilter, ufront_web_mvc_IActionFilter{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $_invoker;
	public $invoker;
	public function getInvoker() {
		if($this->_invoker === null) {
			$this->_invoker = new ufront_web_mvc_ControllerActionInvoker(ufront_web_mvc_ModelBinders::$binders, ufront_web_mvc_ControllerBuilder::$current, ufront_web_mvc_DependencyResolver::$current);
		}
		return $this->_invoker;
	}
	public function setInvoker($i) {
		$this->_invoker = $i;
		return $this->_invoker;
	}
	public function executeCore($async) {
		if($this->getInvoker() === null) {
			throw new HException(new thx_error_Error("No IActionInvoker set on controller '" . Type::getClassName(Type::getClass($this)) . "'", null, null, _hx_anonymous(array("fileName" => "Controller.hx", "lineNumber" => 36, "className" => "ufront.web.mvc.Controller", "methodName" => "executeCore"))));
		}
		$action = $this->controllerContext->routeData->get("action", null);
		if(null === $action) {
			throw new HException(new thx_error_Error("No 'action' data found on route.", null, null, _hx_anonymous(array("fileName" => "Controller.hx", "lineNumber" => 41, "className" => "ufront.web.mvc.Controller", "methodName" => "executeCore"))));
		}
		$this->getInvoker()->invokeAction($this->controllerContext, $action, $async);
	}
	public function onActionExecuting($filterContext) {
	}
	public function onActionExecuted($filterContext) {
	}
	public function onAuthorization($filterContext) {
	}
	public function onException($filterContext) {
	}
	public function onResultExecuted($filterContext) {
	}
	public function onResultExecuting($filterContext) {
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
	static $__rtti = "<class path=\"ufront.web.mvc.Controller\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.ControllerBase\"/>\x0A\x09<implements path=\"ufront.web.mvc.IExceptionFilter\"/>\x0A\x09<implements path=\"ufront.web.mvc.IResultFilter\"/>\x0A\x09<implements path=\"ufront.web.mvc.IAuthorizationFilter\"/>\x0A\x09<implements path=\"ufront.web.mvc.IActionFilter\"/>\x0A\x09<_invoker><c path=\"ufront.web.mvc.IActionInvoker\"/></_invoker>\x0A\x09<invoker public=\"1\" get=\"getInvoker\" set=\"setInvoker\"><c path=\"ufront.web.mvc.IActionInvoker\"/></invoker>\x0A\x09<getInvoker set=\"method\" line=\"15\"><f a=\"\"><c path=\"ufront.web.mvc.IActionInvoker\"/></f></getInvoker>\x0A\x09<setInvoker set=\"method\" line=\"22\"><f a=\"i\">\x0A\x09<c path=\"ufront.web.mvc.IActionInvoker\"/>\x0A\x09<c path=\"ufront.web.mvc.IActionInvoker\"/>\x0A</f></setInvoker>\x0A\x09<executeCore set=\"method\" line=\"33\" override=\"1\"><f a=\"async\">\x0A\x09<c path=\"hxevents.Async\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></executeCore>\x0A\x09<onActionExecuting public=\"1\" set=\"method\" line=\"45\"><f a=\"filterContext\">\x0A\x09<c path=\"ufront.web.mvc.ActionExecutingContext\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></onActionExecuting>\x0A\x09<onActionExecuted public=\"1\" set=\"method\" line=\"46\"><f a=\"filterContext\">\x0A\x09<c path=\"ufront.web.mvc.ActionExecutedContext\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></onActionExecuted>\x0A\x09<onAuthorization public=\"1\" set=\"method\" line=\"47\"><f a=\"filterContext\">\x0A\x09<c path=\"ufront.web.mvc.AuthorizationContext\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></onAuthorization>\x0A\x09<onException public=\"1\" set=\"method\" line=\"48\"><f a=\"filterContext\">\x0A\x09<c path=\"ufront.web.mvc.ExceptionContext\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></onException>\x0A\x09<onResultExecuted public=\"1\" set=\"method\" line=\"49\"><f a=\"filterContext\">\x0A\x09<c path=\"ufront.web.mvc.ResultExecutedContext\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></onResultExecuted>\x0A\x09<onResultExecuting public=\"1\" set=\"method\" line=\"50\"><f a=\"filterContext\">\x0A\x09<c path=\"ufront.web.mvc.ResultExecutingContext\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></onResultExecuting>\x0A\x09<new public=\"1\" set=\"method\" line=\"28\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	static $__properties__ = array("set_invoker" => "setInvoker","get_invoker" => "getInvoker","set_valueProvider" => "setValueProvider","get_valueProvider" => "getValueProvider");
	function __toString() { return 'ufront.web.mvc.Controller'; }
}
