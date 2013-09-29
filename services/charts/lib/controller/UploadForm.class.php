<?php

class controller_UploadForm extends ufront_web_mvc_Controller {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function display($html, $config, $displayFormat) {
		$ob = _hx_anonymous(array("baseurl" => App::baseUrl(), "url" => new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext), "html" => $html, "config" => $config, "errors" => new Hash(), "displayFormat" => $displayFormat));
		if($this->controllerContext->request->getHttpMethod() === "POST") {
			$haserrors = false;
			if(null === $html || "" === ($html = trim($html))) {
				$haserrors = true;
				$ob->errors->set("html", "html cannot be left empty");
			} else {
				if(_hx_index_of(strtolower($html), "reportgrid", null) < 0) {
					$haserrors = true;
					$ob->errors->set("html", "html does not contain any reference to reportgrid");
				}
			}
			if(null !== $config && $config !== "") {
				$config = trim($config);
				try {
					thx_ini_Ini::decode($config);
				}catch(Exception $»e) {
					$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
					$e = $_ex_;
					{
						$haserrors = true;
						$ob->errors->set("config", "the config file is not well formed: " . $e);
					}
				}
			}
			if(!$haserrors) {
				$controller1 = ufront_web_mvc_DependencyResolver::$current->getService(_hx_qtype("controller.RenderableAPIController"));
				$controller1->controllerContext = $this->controllerContext;
				if(null !== $displayFormat) {
					return $controller1->uploadAndDisplay($html, $config, $displayFormat, null);
				} else {
					return $controller1->upload($html, $config, "html");
				}
			}
		} else {
			if(null === $html && null === $config) {
				$ob->html = model_Sample::$html;
				$ob->config = model_Sample::$config;
			}
		}
		return new ufront_web_mvc_ContentResult(_hx_deref(new template_FormUpload())->execute($ob), null);
	}
	public $lastError;
	public function gist($gistid) {
		$id = $this->validateGist($gistid);
		if(null !== $id) {
			$controller1 = ufront_web_mvc_DependencyResolver::$current->getService(_hx_qtype("controller.GistUploadController"));
			$controller1->controllerContext = $this->controllerContext;
			return $controller1->importGist($id, "html");
		} else {
			$ob = _hx_anonymous(array("baseurl" => App::baseUrl(), "error" => $this->lastError, "url" => new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext), "gistid" => $gistid));
			return new ufront_web_mvc_ContentResult(_hx_deref(new template_GistUpload())->execute($ob), null);
		}
	}
	public function validateGist($id) {
		if(null === $id || $id === "") {
			return null;
		}
		if(_hx_substr($id, 0, 8) === "https://" || _hx_substr($id, 0, 7) === "http://") {
			$id = _hx_explode("/", $id)->pop();
		}
		$des = controller_GistUploadController::getGistDescription($id);
		if(null !== $des->error) {
			$this->lastError = $des->error;
			return null;
		} else {
			return $id;
		}
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
	static $__rtti = "<class path=\"controller.UploadForm\" params=\"\" module=\"controller.UploadFormController\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<display public=\"1\" set=\"method\" line=\"8\"><f a=\"?html:?config:?displayFormat\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<d/>\x0A</f></display>\x0A\x09<lastError><c path=\"String\"/></lastError>\x0A\x09<gist public=\"1\" set=\"method\" line=\"62\"><f a=\"?gistid\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></gist>\x0A\x09<validateGist set=\"method\" line=\"81\"><f a=\"id\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></validateGist>\x0A\x09<new public=\"1\" set=\"method\" line=\"6\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	static $__properties__ = array("set_invoker" => "setInvoker","get_invoker" => "getInvoker","set_valueProvider" => "setValueProvider","get_valueProvider" => "getValueProvider");
	function __toString() { return 'controller.UploadForm'; }
}
