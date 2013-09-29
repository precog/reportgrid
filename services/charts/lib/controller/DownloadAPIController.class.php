<?php

class controller_DownloadAPIController extends ufront_web_mvc_Controller {
	public function __construct($cache, $renderables, $topdf, $toimage) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->cache = $cache;
		$this->renderables = $renderables;
		$this->topdf = $topdf;
		$this->toimage = $toimage;
	}}
	public $cache;
	public $renderables;
	public $topdf;
	public $toimage;
	public function download($uid, $ext, $forceDownload) {
		if($forceDownload === null) {
			$forceDownload = false;
		}
		$renderable = $this->renderables->load($uid);
		if(null === $renderable) {
			return $this->error("uid '" . $uid . "' doesn't exist", $ext);
		}
		return $this->renderRenderable($renderable, $ext, $forceDownload);
	}
	public function renderRenderable($renderable, $ext, $forceDownload) {
		if(!$renderable->canRenderTo($ext)) {
			return $this->error("this visualization cannot be rendered to '" . $ext . "'", $ext);
		}
		$params = $this->getParams($renderable->config->template); $cached = $this->cache->load($renderable->getUid(), $ext, $params);
		if(null === $cached) {
			$html = null;
			try {
				$html = $this->processHtml($renderable->html, $params, $renderable->config->template);
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				$e = $_ex_;
				{
					return $this->error("" . $e, $ext);
				}
			}
			$content = $this->renderHtml($html, $renderable->config, $ext);
			$cached = $this->cache->insert($renderable->getUid(), $ext, $params, $content, Date::now()->getTime() + $renderable->config->cacheExpirationTime);
		}
		$this->setHeaders($ext, strlen($cached->content->bin), $forceDownload);
		$this->renderables->huse($renderable->getUid());
		return $cached->content->bin;
	}
	public function getParams($config) {
		$params = new thx_collection_HashList(); $requestParams = $this->controllerContext->request->getParams(); $value = null;
		{
			$_g = 0; $_g1 = $config->replaceables();
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$value = $requestParams->get($param);
				if(null === $value) {
					$value = $config->getDefault($param);
				}
				if(null === $value) {
					throw new HException(new thx_error_Error("the parameter '{0}' is mandatory", new _hx_array(array($value)), null, _hx_anonymous(array("fileName" => "DownloadAPIController.hx", "lineNumber" => 102, "className" => "controller.DownloadAPIController", "methodName" => "getParams"))));
				}
				$params->set($param, $value);
				unset($param);
			}
		}
		return $params;
	}
	public function processHtml($html, $params, $config) {
		{
			$_g = 0; $_g1 = $config->replaceables();
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$value = $params->get($param);
				if(!$config->isValid($param, $value)) {
					throw new HException(new thx_error_Error("invalid value '{0}' for the parameter '{1}'", new _hx_array(array($value, $param)), null, _hx_anonymous(array("fileName" => "DownloadAPIController.hx", "lineNumber" => 114, "className" => "controller.DownloadAPIController", "methodName" => "processHtml"))));
				}
				$html = str_replace("\$" . $param, "" . $value, $html);
				unset($value,$param);
			}
		}
		return $html;
	}
	public function error($msg, $ext) {
		haxe_Log::trace("ERROR: " . $msg . " (." . $ext . ")", _hx_anonymous(array("fileName" => "DownloadAPIController.hx", "lineNumber" => 122, "className" => "controller.DownloadAPIController", "methodName" => "error")));
		$ext1 = strtolower($ext); $content = _hx_deref(new template_Error())->execute(_hx_anonymous(array("baseurl" => App::baseUrl(), "url" => new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext), "data" => _hx_anonymous(array("error" => $msg)))));
		return $this->renderHtml($content, null, $ext1);
	}
	public function renderHtml($html, $config, $ext) {
		$result = null;
		switch($ext) {
		case "pdf":case "ps":{
			$this->topdf->setFormat($ext);
			if(null !== $config) {
				$this->topdf->setWKConfig($config->wk);
				$this->topdf->setPdfConfig($config->pdf);
			}
			$result = $this->topdf->render($html);
		}break;
		case "png":case "jpg":case "bmp":case "tif":case "svg":{
			$this->toimage->setFormat($ext);
			if(null !== $config) {
				$this->toimage->setWKConfig($config->wk);
				$this->toimage->setImageConfig($config->image);
			}
			$result = $this->toimage->render($html);
		}break;
		default:{
			$result = $html;
		}break;
		}
		$this->setHeaders($ext, strlen($result), false);
		return $result;
	}
	public function setHeaders($ext, $len, $forceDownload) {
		$response = $this->controllerContext->response;
		switch($ext) {
		case "pdf":{
			$response->setContentType("application/pdf");
		}break;
		case "ps":{
			$response->setContentType("application/postscript");
		}break;
		case "png":{
			$response->setContentType("image/png");
		}break;
		case "svg":{
			$response->setContentType("image/svg+xml");
		}break;
		case "jpeg":case "jpg":{
			$response->setContentType("image/jpeg");
		}break;
		case "bmp":{
			$response->setContentType("image/bmp");
		}break;
		case "tif":case "tiff":{
			$response->setContentType("image/tiff");
		}break;
		default:{
		}break;
		}
		if($forceDownload) {
			$response->setHeader("Content-Description", "File Transfer");
			$response->setHeader("Content-Disposition", "attachment; filename=visualization." . $ext);
			$response->setHeader("Content-Transfer-Encoding", "binary");
		}
		$response->setHeader("Content-Length", "" . $len);
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
	static $__rtti = "<class path=\"controller.DownloadAPIController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<cache><c path=\"model.CacheGateway\"/></cache>\x0A\x09<renderables><c path=\"model.RenderableGateway\"/></renderables>\x0A\x09<topdf><c path=\"model.WKHtmlToPdf\"/></topdf>\x0A\x09<toimage><c path=\"model.WKHtmlToImage\"/></toimage>\x0A\x09<download public=\"1\" set=\"method\" line=\"30\"><f a=\"uid:ext:?forceDownload\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<e path=\"Bool\"/>\x0A\x09<c path=\"String\"/>\x0A</f></download>\x0A\x09<renderRenderable public=\"1\" set=\"method\" line=\"65\"><f a=\"renderable:ext:forceDownload\">\x0A\x09<c path=\"model.Renderable\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<e path=\"Bool\"/>\x0A\x09<c path=\"String\"/>\x0A</f></renderRenderable>\x0A\x09<getParams set=\"method\" line=\"91\"><f a=\"config\">\x0A\x09<c path=\"model.ConfigTemplate\"/>\x0A\x09<c path=\"thx.collection.HashList\"><c path=\"String\"/></c>\x0A</f></getParams>\x0A\x09<processHtml set=\"method\" line=\"108\"><f a=\"html:params:config\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"thx.collection.HashList\"><c path=\"String\"/></c>\x0A\x09<c path=\"model.ConfigTemplate\"/>\x0A\x09<c path=\"String\"/>\x0A</f></processHtml>\x0A\x09<error set=\"method\" line=\"120\"><f a=\"msg:ext\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></error>\x0A\x09<renderHtml set=\"method\" line=\"132\"><f a=\"html:config:ext\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"model.ConfigRendering\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></renderHtml>\x0A\x09<setHeaders set=\"method\" line=\"159\"><f a=\"ext:len:forceDownload\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"Int\"/>\x0A\x09<e path=\"Bool\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></setHeaders>\x0A\x09<new public=\"1\" set=\"method\" line=\"21\"><f a=\"cache:renderables:topdf:toimage\">\x0A\x09<c path=\"model.CacheGateway\"/>\x0A\x09<c path=\"model.RenderableGateway\"/>\x0A\x09<c path=\"model.WKHtmlToPdf\"/>\x0A\x09<c path=\"model.WKHtmlToImage\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></new>\x0A</class>";
	static $__properties__ = array("set_invoker" => "setInvoker","get_invoker" => "getInvoker","set_valueProvider" => "setValueProvider","get_valueProvider" => "getValueProvider");
	function __toString() { return 'controller.DownloadAPIController'; }
}
