<?php

class ufront_web_mvc_ControllerBase implements haxe_rtti_Infos, ufront_web_mvc_IController{
	public function __construct() {
		;
	}
	public $controllerContext;
	public $_valueProvider;
	public $valueProvider;
	public function getValueProvider() {
		if($this->_valueProvider === null) {
			$this->_valueProvider = ufront_web_mvc_ValueProviderFactories::$factories->getValueProvider($this->controllerContext);
		}
		return $this->_valueProvider;
	}
	public function setValueProvider($valueProvider) {
		$this->_valueProvider = $valueProvider;
		return $this->_valueProvider;
	}
	public function executeCore($async) {
		throw new HException("executeCore() must be overridden in subclass.");
	}
	public function execute($requestContext, $async) {
		if(null === $requestContext) {
			throw new HException(new thx_error_NullArgument("requestContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ControllerBase.hx", "lineNumber" => 43, "className" => "ufront.web.mvc.ControllerBase", "methodName" => "execute"))));
		}
		if($this->controllerContext === null) {
			$this->controllerContext = new ufront_web_mvc_ControllerContext($this, $requestContext);
		}
		$this->executeCore($async);
	}
	public function getViewHelpers() {
		return new _hx_array(array());
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
	static $__rtti = "<class path=\"ufront.web.mvc.ControllerBase\" params=\"\">\x0A\x09<implements path=\"haxe.rtti.Infos\"/>\x0A\x09<implements path=\"ufront.web.mvc.IController\"/>\x0A\x09<controllerContext public=\"1\"><c path=\"ufront.web.mvc.ControllerContext\"/></controllerContext>\x0A\x09<_valueProvider><c path=\"ufront.web.mvc.IValueProvider\"/></_valueProvider>\x0A\x09<valueProvider public=\"1\" get=\"getValueProvider\" set=\"setValueProvider\"><c path=\"ufront.web.mvc.IValueProvider\"/></valueProvider>\x0A\x09<getValueProvider set=\"method\" line=\"24\"><f a=\"\"><c path=\"ufront.web.mvc.IValueProvider\"/></f></getValueProvider>\x0A\x09<setValueProvider set=\"method\" line=\"31\"><f a=\"valueProvider\">\x0A\x09<c path=\"ufront.web.mvc.IValueProvider\"/>\x0A\x09<c path=\"ufront.web.mvc.IValueProvider\"/>\x0A</f></setValueProvider>\x0A\x09<executeCore set=\"method\" line=\"39\"><f a=\"async\">\x0A\x09<c path=\"hxevents.Async\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></executeCore>\x0A\x09<execute public=\"1\" set=\"method\" line=\"41\"><f a=\"requestContext:async\">\x0A\x09<c path=\"ufront.web.routing.RequestContext\"/>\x0A\x09<c path=\"hxevents.Async\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></execute>\x0A\x09<getViewHelpers public=\"1\" set=\"method\" line=\"50\"><f a=\"\"><c path=\"Array\"><c path=\"ufront.web.mvc.IViewHelper\"/></c></f></getViewHelpers>\x0A\x09<new public=\"1\" set=\"method\" line=\"37\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	static $__properties__ = array("set_valueProvider" => "setValueProvider","get_valueProvider" => "getValueProvider");
	function __toString() { return 'ufront.web.mvc.ControllerBase'; }
}
