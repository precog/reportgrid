<?php

class ufront_web_mvc_view_UrlHelper implements ufront_web_mvc_IViewHelper{
	public function __construct($name, $requestContext) {
		if(!php_Boot::$skip_constructor) {
		if($name === null) {
			$name = "Url";
		}
		$this->name = $name;
		$this->requestContext = $requestContext;
		$this->inst = new ufront_web_mvc_view_UrlHelperInst($requestContext);
	}}
	public $name;
	public $requestContext;
	public $inst;
	public function register($data) {
		$data->set($this->name, $this->inst);
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
	function __toString() { return 'ufront.web.mvc.view.UrlHelper'; }
}
