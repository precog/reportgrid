<?php

class ufront_web_mvc_ViewResult extends ufront_web_mvc_ActionResult {
	public function __construct($data, $dataObj) {
		if(!php_Boot::$skip_constructor) {
		if(null === $data) {
			$this->viewData = new Hash();
		} else {
			$this->viewData = $data;
		}
		if(null !== $dataObj) {
			Hashes::importObject($this->viewData, $dataObj);
		}
	}}
	public $view;
	public $viewData;
	public $viewName;
	public function createContext($result, $controllerContext) {
		return new ufront_web_mvc_ViewContext($controllerContext, $this->view, $result->viewEngine, $this->viewData, $controllerContext->controller->getViewHelpers());
	}
	public function executeResult($context) {
		if(null === $context) {
			throw new HException(new thx_error_NullArgument("context", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 30, "className" => "ufront.web.mvc.ViewResult", "methodName" => "executeResult"))));
		}
		if(null === $this->viewName || "" === $this->viewName) {
			$this->viewName = $context->routeData->getRequired("action");
		}
		$result = null;
		if(null === $this->view) {
			$result = $this->findView($context, $this->viewName);
			if(null === $result) {
				throw new HException(new thx_error_Error("unable to find a view for '{0}'", null, Types::typeName($context->controller) . "/" . $this->viewName, _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 39, "className" => "ufront.web.mvc.ViewResult", "methodName" => "executeResult"))));
			}
			$this->view = $result->view;
		}
		$viewContext = $this->createContext($result, $context);
		$data = new Hash();
		$r = null;
		try {
			$r = $this->view->render($viewContext, $data);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				throw new HException(new thx_error_Error("error in the template processing: {0}", null, Std::string($e), _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 48, "className" => "ufront.web.mvc.ViewResult", "methodName" => "executeResult"))));
			}
		}
		$this->writeResponse($context, $r, $data);
		if(null !== $result) {
			$result->viewEngine->releaseView($context, $this->view);
		}
	}
	public function writeResponse($context, $content, $data) {
		$context->response->write($content);
	}
	public function findView($context, $viewName) {
		if(null === $viewName) {
			throw new HException(new thx_error_NullArgument("viewName", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 62, "className" => "ufront.web.mvc.ViewResult", "methodName" => "findView"))));
		}
		if(null == ufront_web_mvc_ViewEngines::getEngines()) throw new HException('null iterable');
		$»it = ufront_web_mvc_ViewEngines::getEngines()->iterator();
		while($»it->hasNext()) {
			$engine = $»it->next();
			$result = $engine->findView($context, $viewName);
			if(null !== $result) {
				return $result;
			}
			unset($result);
		}
		return null;
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
	function __toString() { return 'ufront.web.mvc.ViewResult'; }
}
