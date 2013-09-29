<?php

class ufront_web_module_TraceToBrowserModule implements ufront_web_module_ITraceModule{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->messages = new _hx_array(array());
	}}
	public $messages;
	public function init($application) {
		$application->onLogRequest->add((isset($this->_sendContent) ? $this->_sendContent: array($this, "_sendContent")));
	}
	public function trace($msg, $pos) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos)));
	}
	public function dispose() {
	}
	public function _sendContent($application) {
		if($application->getResponse()->getContentType() !== "text/html") {
			$this->messages = new _hx_array(array());
			return;
		}
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
		$type = ufront_web_module_TraceToBrowserModule_0($this, $m);
		if($type !== "warn" && $type !== "info" && $type !== "debug" && $type !== "error") {
			$type = ((_hx_field($m, "pos") === null) ? "error" : "log");
		}
		$msg = _hx_explode(".", $m->pos->className)->pop() . "." . $m->pos->methodName . "(" . $m->pos->lineNumber . "): " . Std::string($m->msg);
		return "console." . $type . "(decodeURIComponent(\"" . rawurlencode($msg) . "\"))";
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->�dynamics[$m]) && is_callable($this->�dynamics[$m]))
			return call_user_func_array($this->�dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	function __toString() { return 'ufront.web.module.TraceToBrowserModule'; }
}
function ufront_web_module_TraceToBrowserModule_0(&$�this, &$m) {
	if(_hx_field($m, "pos") !== null && $m->pos->customParams !== null) {
		return $m->pos->customParams[0];
	}
}
