<?php

class ufront_web_AppConfiguration {
	public function __construct($controllerPackage, $modRewrite, $basePath, $logFile, $disableBrowserTrace) {
		if(!php_Boot::$skip_constructor) {
		if($disableBrowserTrace === null) {
			$disableBrowserTrace = false;
		}
		if($basePath === null) {
			$basePath = "/";
		}
		$this->modRewrite = (($modRewrite === null) ? false : $modRewrite);
		$this->basePath = $basePath;
		$this->controllerPackages = new _hx_array(array((($controllerPackage === null) ? "" : $controllerPackage)));
		$this->attributePackages = new _hx_array(array("ufront.web.mvc.attributes"));
		$this->logFile = $logFile;
		$this->disableBrowserTrace = $disableBrowserTrace;
	}}
	public $modRewrite;
	public $controllerPackages;
	public $attributePackages;
	public $basePath;
	public $logFile;
	public $disableBrowserTrace;
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
	function __toString() { return 'ufront.web.AppConfiguration'; }
}
