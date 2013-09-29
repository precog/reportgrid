<?php

class ufront_web_module_TraceCompositeModule implements ufront_web_module_ITraceModule{
	public function __construct($tracers) {
		if(!php_Boot::$skip_constructor) {
		$this->tracers = ((null === $tracers) ? new _hx_array(array()) : $tracers);
	}}
	public $tracers;
	public function add($tracer) {
		$this->tracers->push($tracer);
	}
	public function init($application) {
		Arrays::each($this->tracers, array(new _hx_lambda(array(&$application), "ufront_web_module_TraceCompositeModule_0"), 'execute'));
	}
	public function trace($msg, $pos) {
		Arrays::each($this->tracers, array(new _hx_lambda(array(&$msg, &$pos), "ufront_web_module_TraceCompositeModule_1"), 'execute'));
	}
	public function dispose() {
		Arrays::each($this->tracers, array(new _hx_lambda(array(), "ufront_web_module_TraceCompositeModule_2"), 'execute'));
		$this->tracers = new _hx_array(array());
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
	function __toString() { return 'ufront.web.module.TraceCompositeModule'; }
}
function ufront_web_module_TraceCompositeModule_0(&$application, $tracer, $_) {
	{
		$tracer->init($application);
	}
}
function ufront_web_module_TraceCompositeModule_1(&$msg, &$pos, $tracer, $_) {
	{
		$tracer->trace($msg, $pos);
	}
}
function ufront_web_module_TraceCompositeModule_2($tracer, $_) {
	{
		$tracer->dispose();
	}
}
