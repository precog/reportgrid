<?php

class ufront_web_error_HttpError extends thx_error_Error {
	public function __construct($code, $message, $params, $param, $pos) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct("Error " . $code . ": " . $message,$params,$param,$pos);
		$this->code = $code;
	}}
	public $code;
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
	function __toString() { return 'ufront.web.error.HttpError'; }
}
