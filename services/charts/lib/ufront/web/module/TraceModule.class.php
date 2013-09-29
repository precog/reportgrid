<?php

class ufront_web_module_TraceModule implements ufront_web_IHttpModule{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_old = haxe_Log::$trace;
		haxe_Log::$trace = (isset($this->trace) ? $this->trace: array($this, "trace"));
		$this->messages = new _hx_array(array());
	}}
	public $messages;
	public $_old;
	public function init($application) {
		$application->onLogRequest->add((isset($this->_sendContent) ? $this->_sendContent: array($this, "_sendContent")));
	}
	public function _sendContent($application) {
		$results = new _hx_array(array());
		{
			$_g = 0; $_g1 = $this->messages;
			while($_g < $_g1->length) {
				$msg = $_g1[$_g];
				++$_g;
				$results->push($this->_formatMessage($msg));
				unset($msg);
			}
		}
		if($results->length > 0) {
			$application->getResponse()->write("\x0A<script type=\"text/javascript\">\x0A" . $results->join("\x0A") . "\x0A</script>");
		}
		$this->messages = new _hx_array(array());
	}
	public function _formatMessage($m) {
		$type = ufront_web_module_TraceModule_0($this, $m);
		if($type !== "warn" && $type !== "info" && $type !== "debug" && $type !== "error") {
			$type = ((_hx_field($m, "pos") === null) ? "error" : "log");
		}
		$msg = _hx_explode(".", $m->pos->className)->pop() . "." . $m->pos->methodName . "(" . $m->pos->lineNumber . "): " . Std::string($m->msg);
		return "console." . $type . "(decodeURIComponent(\"" . rawurlencode($msg) . "\"))";
	}
	public function dispose() {
		haxe_Log::$trace = $this->_old;
	}
	public function trace($v, $pos) {
		$this->messages->push(_hx_anonymous(array("msg" => $v, "pos" => $pos)));
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
	function __toString() { return 'ufront.web.module.TraceModule'; }
}
function ufront_web_module_TraceModule_0(&$»this, &$m) {
	if(_hx_field($m, "pos") !== null && $m->pos->customParams !== null) {
		return $m->pos->customParams[0];
	}
}
