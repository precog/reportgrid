<?php

class controller_UploadAPIController extends controller_BaseController {
	public function __construct($gateway) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->gateway = $gateway;
	}}
	public $gateway;
	public function uploadFromUrl($urlhtml, $urlconfig, $outputformat) {
		$http = new haxe_Http($urlhtml); $html = null; $config = null; $errormsg = null;
		$http->onData = array(new _hx_lambda(array(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml), "controller_UploadAPIController_0"), 'execute');
		$http->onError = array(new _hx_lambda(array(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml), "controller_UploadAPIController_1"), 'execute');
		$http->request(false);
		if(null !== $urlconfig) {
			$http = new haxe_Http($urlconfig);
			$http->onData = array(new _hx_lambda(array(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml), "controller_UploadAPIController_2"), 'execute');
			$http->onError = array(new _hx_lambda(array(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml), "controller_UploadAPIController_3"), 'execute');
			$http->request(false);
		}
		if(null !== $errormsg) {
			return $this->error($errormsg, $outputformat);
		}
		return $this->upload($html, $config, $outputformat);
	}
	public function upload($html, $config, $outputformat) {
		if(!$this->validateHtml($html)) {
			return $this->error("invalid content for HTML", $outputformat);
		}
		$cobj = model_ConfigObjects::createDefault();
		if(null !== $config && "" !== ($config = trim($config))) {
			$params = $this->tryParseIni($config);
			if(null === $params) {
				$params = $this->tryParseJson($config);
			}
			if(null === $params) {
				return $this->error("unable to parse the config argument: '{0}', it should be either a valid INI or JSON string", $config);
			}
			$cobj = model_ConfigObjects::overrideValues($cobj, $params);
		}
		$renderable = new model_Renderable($html, model_ConfigRendering::create($cobj), null, null, null);
		if($this->gateway->exists($renderable->getUid())) {
			$renderable = $this->gateway->load($renderable->getUid());
		} else {
			$this->gateway->insert($renderable);
		}
		return $this->success($renderable, $outputformat);
	}
	public function tryParseIni($s) {
		try {
			return thx_ini_Ini::decode($s);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				return null;
			}
		}
	}
	public function tryParseJson($s) {
		try {
			return thx_json_Json::decode($s);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				return null;
			}
		}
	}
	public function validateHtml($html) {
		return _hx_index_of(strtolower($html), "reportgrid", null) >= 0;
	}
	public function success($r, $format) {
		return $this->output(_hx_anonymous(array("uid" => $r->getUid(), "pdf" => $this->serviceUrl($r->getUid(), "pdf"), "png" => $this->serviceUrl($r->getUid(), "png"), "jpg" => $this->serviceUrl($r->getUid(), "jpg"), "html" => $this->serviceUrl($r->getUid(), "html"))), $format, _hx_qtype("template.UploadAPIOutput"));
	}
	public function serviceUrl($uid, $format) {
		return "http://localhost" . $this->getUrlHelper()->route(_hx_anonymous(array("controller" => "downloadAPI", "action" => "download", "uid" => $uid, "ext" => $format)));
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
	static $__rtti = "<class path=\"controller.UploadAPIController\" params=\"\">\x0A\x09<extends path=\"controller.BaseController\"/>\x0A\x09<gateway><c path=\"model.RenderableGateway\"/></gateway>\x0A\x09<uploadFromUrl public=\"1\" set=\"method\" line=\"34\"><f a=\"urlhtml:?urlconfig:outputformat\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></uploadFromUrl>\x0A\x09<upload public=\"1\" set=\"method\" line=\"60\"><f a=\"html:?config:outputformat\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></upload>\x0A\x09<tryParseIni set=\"method\" line=\"85\"><f a=\"s\">\x0A\x09<c path=\"String\"/>\x0A\x09<unknown/>\x0A</f></tryParseIni>\x0A\x09<tryParseJson set=\"method\" line=\"95\"><f a=\"s\">\x0A\x09<c path=\"String\"/>\x0A\x09<unknown/>\x0A</f></tryParseJson>\x0A\x09<validateHtml set=\"method\" line=\"105\"><f a=\"html\">\x0A\x09<c path=\"String\"/>\x0A\x09<e path=\"Bool\"/>\x0A</f></validateHtml>\x0A\x09<success set=\"method\" line=\"110\"><f a=\"r:format\">\x0A\x09<c path=\"model.Renderable\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></success>\x0A\x09<serviceUrl set=\"method\" line=\"121\"><f a=\"uid:format\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></serviceUrl>\x0A\x09<new public=\"1\" set=\"method\" line=\"28\"><f a=\"gateway\">\x0A\x09<c path=\"model.RenderableGateway\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></new>\x0A</class>";
	function __toString() { return 'controller.UploadAPIController'; }
}
function controller_UploadAPIController_0(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml, $data) {
	{
		$html = $data;
	}
}
function controller_UploadAPIController_1(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml, $msg) {
	{
		$errormsg = $msg;
	}
}
function controller_UploadAPIController_2(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml, $data) {
	{
		$config = $data;
	}
}
function controller_UploadAPIController_3(&$config, &$errormsg, &$html, &$http, &$outputformat, &$urlconfig, &$urlhtml, $msg) {
	{
		$errormsg = $msg;
	}
}
