<?php

class controller_GistUploadController extends controller_BaseController {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function importGist($gistid, $outputformat) {
		$gist = controller_GistUploadController::getGistDescription($gistid);
		if(null !== $gist->error) {
			return $this->error($gist->error, $outputformat);
		} else {
			$html = null; $config = null;
			{
				$_g = 0; $_g1 = Reflect::fields($gist->data->files);
				while($_g < $_g1->length) {
					$field = $_g1[$_g];
					++$_g;
					$file = Reflect::field($gist->data->files, $field);
					switch(_hx_string_call($file->language, "toLowerCase", array())) {
					case "html":case "htm":{
						if(null === $html) {
							$html = $this->loadFile($file->raw_url);
							if(null === $html) {
								return $this->error("unable to load file in GIST: " . $this->lastError, $outputformat);
							}
						}
					}break;
					case "json":case "ini":{
						if(null === $config) {
							$config = $this->loadFile($file->raw_url);
							if(null === $config) {
								return $this->error("unable to load file in GIST: " . $this->lastError, $outputformat);
							}
						}
					}break;
					}
					unset($file,$field);
				}
			}
			if(null === $html) {
				return $this->error("The GIST doesn't inclide the required HTML file", $outputformat);
			}
			$controller1 = ufront_web_mvc_DependencyResolver::$current->getService(_hx_qtype("controller.RenderableAPIController"));
			$controller1->controllerContext = $this->controllerContext;
			return $controller1->upload($html, $config, $outputformat);
		}
	}
	public $lastError;
	public function loadFile($url) {
		$me = $this;
		$url = "https://raw.github.com/gist/" . _hx_explode("/raw/", $url)->pop();
		$http = new haxe_Http($url); $result = null;
		$http->onError = array(new _hx_lambda(array(&$http, &$me, &$result, &$url), "controller_GistUploadController_0"), 'execute');
		$http->onData = array(new _hx_lambda(array(&$http, &$me, &$result, &$url), "controller_GistUploadController_1"), 'execute');
		$http->request(false);
		return $result;
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
	static $__rtti = "<class path=\"controller.GistUploadController\" params=\"\">\x0A\x09<extends path=\"controller.BaseController\"/>\x0A\x09<GIST_REST_API public=\"1\" line=\"5\" static=\"1\"><c path=\"String\"/></GIST_REST_API>\x0A\x09<getGistDescription public=\"1\" set=\"method\" line=\"68\" static=\"1\"><f a=\"id\">\x0A\x09<c path=\"String\"/>\x0A\x09<a>\x0A\x09\x09<error><t path=\"Null\"><c path=\"String\"/></t></error>\x0A\x09\x09<data><t path=\"Null\"><a>\x0A\x09<user><a>\x0A\x09<url><c path=\"String\"/></url>\x0A\x09<login><c path=\"String\"/></login>\x0A\x09<id><c path=\"Int\"/></id>\x0A\x09<gravatar_id><c path=\"String\"/></gravatar_id>\x0A\x09<avatar_url><c path=\"String\"/></avatar_url>\x0A</a></user>\x0A\x09<url><c path=\"String\"/></url>\x0A\x09<updated_at><c path=\"String\"/></updated_at>\x0A\x09<id><c path=\"String\"/></id>\x0A\x09<html_url><c path=\"String\"/></html_url>\x0A\x09<history><c path=\"Array\"><d/></c></history>\x0A\x09<git_push_url><c path=\"String\"/></git_push_url>\x0A\x09<git_pull_url><c path=\"String\"/></git_pull_url>\x0A\x09<forks><c path=\"Array\"><d/></c></forks>\x0A\x09<files><d><a>\x0A\x09<type><c path=\"String\"/></type>\x0A\x09<size><c path=\"Int\"/></size>\x0A\x09<raw_url><c path=\"String\"/></raw_url>\x0A\x09<language><c path=\"String\"/></language>\x0A\x09<filename><c path=\"String\"/></filename>\x0A\x09<content><c path=\"String\"/></content>\x0A</a></d></files>\x0A\x09<description><c path=\"String\"/></description>\x0A\x09<created_at><c path=\"String\"/></created_at>\x0A\x09<comments><c path=\"Int\"/></comments>\x0A</a></t></data>\x0A\x09</a>\x0A</f></getGistDescription>\x0A\x09<importGist public=\"1\" set=\"method\" line=\"12\"><f a=\"gistid:outputformat\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></importGist>\x0A\x09<lastError><c path=\"String\"/></lastError>\x0A\x09<loadFile set=\"method\" line=\"50\"><f a=\"url\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></loadFile>\x0A\x09<new public=\"1\" set=\"method\" line=\"7\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	static $GIST_REST_API = "https://api.github.com/gists/{id}";
	static function getGistDescription($id) {
		$url = str_replace("{id}", $id, controller_GistUploadController::$GIST_REST_API); $http = new haxe_Http($url); $result = _hx_anonymous(array("error" => null, "data" => null));
		$http->onError = array(new _hx_lambda(array(&$http, &$id, &$result, &$url), "controller_GistUploadController_2"), 'execute');
		$http->onData = array(new _hx_lambda(array(&$http, &$id, &$result, &$url), "controller_GistUploadController_3"), 'execute');
		$http->request(false);
		return $result;
	}
	static $__properties__ = array("get_urlHelper" => "getUrlHelper","set_invoker" => "setInvoker","get_invoker" => "getInvoker","set_valueProvider" => "setValueProvider","get_valueProvider" => "getValueProvider");
	function __toString() { return 'controller.GistUploadController'; }
}
function controller_GistUploadController_0(&$http, &$me, &$result, &$url, $e) {
	{
		$me->lastError = $e;
		$result = null;
	}
}
function controller_GistUploadController_1(&$http, &$me, &$result, &$url, $s) {
	{
		$result = $s;
	}
}
function controller_GistUploadController_2(&$http, &$id, &$result, &$url, $e) {
	{
		$result->error = $e;
	}
}
function controller_GistUploadController_3(&$http, &$id, &$result, &$url, $s) {
	{
		$result->data = thx_json_Json::decode($s);
	}
}
