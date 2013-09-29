<?php

class ufront_web_module_TraceToFileModule implements ufront_web_module_ITraceModule{
	public function __construct($path) {
		if(!php_Boot::$skip_constructor) {
		$this->path = $path;
	}}
	public $file;
	public $path;
	public function init($application) {
	}
	public function trace($msg, $pos) {
		$this->getFile()->writeString(ufront_web_module_TraceToFileModule::format($msg, $pos) . "\x0A");
	}
	public function dispose() {
		$this->path = null;
		if(null === $this->file) {
			return;
		}
		$this->file->close();
		$this->file = null;
	}
	public function getFile() {
		if(null === $this->file) {
			$this->file = sys_io_File::append($this->path, null);
		}
		return $this->file;
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
	static $REMOVENL;
	static function format($msg, $pos) {
		$msg = ufront_web_module_TraceToFileModule::$REMOVENL->replace($msg, "\\n");
		return "" . Date::now() . ": " . $pos->className . "." . $pos->methodName . "(" . $pos->lineNumber . ") " . Dynamics::string($msg);
	}
	function __toString() { return 'ufront.web.module.TraceToFileModule'; }
}
ufront_web_module_TraceToFileModule::$REMOVENL = new EReg("[\x0A\x0D]", "g");
