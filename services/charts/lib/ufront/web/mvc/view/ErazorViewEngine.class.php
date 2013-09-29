<?php

class ufront_web_mvc_view_ErazorViewEngine implements ufront_web_mvc_view_ITemplateViewEngine{
	public function __construct() { 
	}
	public function getTemplatesDirectory($controllerContext) {
		return $controllerContext->request->getScriptDirectory() . "view/";
	}
	public function findView($controllerContext, $viewName) {
		$template = $this->getTemplate($controllerContext, $viewName);
		if(null === $template) {
			return null;
		}
		return new ufront_web_mvc_ViewEngineResult(new ufront_web_mvc_view_ErazorView($template), $this);
	}
	public function _templatePath($controllerContext, $path) {
		return $this->getTemplatesDirectory($controllerContext) . $path . ufront_web_mvc_view_ErazorViewEngine::$DEFAULT_EXTENSION;
	}
	public function getTemplate($controllerContext, $path) {
		if(!StringTools::startsWith($path, "/")) {
			$parts = _hx_explode(".", Type::getClassName(Type::getClass($controllerContext->controller)));
			{
				$arr = ufront_web_mvc_view_ErazorViewEngine_0($this, $controllerContext, $parts, $path);
				$arr->remove("controllers");
				$arr;
			}
			$parts[$parts->length - 1] = ufront_web_mvc_view_ErazorViewEngine_1($this, $controllerContext, $parts, $path);
			$controllerPath = $parts->join("/");
			if(strtolower(_hx_substr($controllerPath, -10, null)) === "controller") {
				$controllerPath = _hx_substr($controllerPath, 0, -10);
			}
			$path = $controllerPath . "/" . $path;
		} else {
			$path = _hx_substr($path, 1, null);
		}
		$fullpath = $this->_templatePath($controllerContext, $path);
		if(!file_exists($fullpath)) {
			return null;
		} else {
			return new erazor_Template(sys_io_File::getContent($fullpath));
		}
	}
	public function releaseView($controllerContext, $view) {
	}
	static $DEFAULT_EXTENSION = ".html";
	function __toString() { return 'ufront.web.mvc.view.ErazorViewEngine'; }
}
function ufront_web_mvc_view_ErazorViewEngine_0(&$»this, &$controllerContext, &$parts, &$path) {
	{
		$parts->remove("controller");
		return $parts;
	}
}
function ufront_web_mvc_view_ErazorViewEngine_1(&$»this, &$controllerContext, &$parts, &$path) {
	{
		$value = $parts[$parts->length - 1];
		if($value === null) {
			return null;
		} else {
			return strtolower(_hx_char_at($value, 0)) . _hx_substr($value, 1, null);
		}
		unset($value);
	}
}
