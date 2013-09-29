<?php

class ufront_web_routing_Route extends ufront_web_routing_RouteBase {
	public function __construct($url, $handler, $defaults, $constraints) {
		if(!php_Boot::$skip_constructor) {
		if(null === $url) {
			throw new HException(new thx_error_NullArgument("url", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 39, "className" => "ufront.web.routing.Route", "methodName" => "new"))));
		}
		if(!StringTools::startsWith($url, "/")) {
			throw new HException(new thx_error_Error("invalid route url '{0}'; url must begin with '/'", null, $url, _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 41, "className" => "ufront.web.routing.Route", "methodName" => "new"))));
		}
		$this->url = $url;
		if(null === $handler) {
			throw new HException(new thx_error_NullArgument("handler", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 43, "className" => "ufront.web.routing.Route", "methodName" => "new"))));
		}
		$this->handler = $handler;
		if(null === $defaults) {
			$this->defaults = new Hash();
		} else {
			$this->defaults = $defaults;
		}
		if(null === $constraints) {
			$this->constraints = new _hx_array(array());
		} else {
			$this->constraints = $constraints;
		}
	}}
	public $url;
	public $handler;
	public $defaults;
	public $constraints;
	public $extractor;
	public $builder;
	public $_ast;
	public function getAst() {
		if(null === $this->_ast) {
			$this->_ast = ufront_web_routing_Route::$parser->parse($this->getUrl(), Hashes::setOfKeys($this->defaults));
		}
		return $this->_ast;
	}
	public function getRouteData($httpContext) {
		$requesturi = $httpContext->getRequestUri();
		if(!StringTools::startsWith($requesturi, "/")) {
			throw new HException(new thx_error_Error("invalid requestUri '{0}'", null, $requesturi, _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 67, "className" => "ufront.web.routing.Route", "methodName" => "getRouteData"))));
		}
		if(null === $this->extractor) {
			$this->extractor = new ufront_web_routing_RouteParamExtractor($this->getAst());
		}
		$params = $this->extractor->extract($requesturi);
		if(null === $params) {
			return null;
		} else {
			$r = $httpContext->getRequest();
			$params = Hashes::copyTo($params, Hashes::copyTo($r->getQuery(), Hashes::copyTo($r->getPost(), Hashes::hclone($this->defaults))));
			if(!$this->processConstraints($httpContext, $params, ufront_web_UrlDirection::$IncomingUrlRequest)) {
				return null;
			} else {
				return new ufront_web_routing_RouteData($this, $this->handler, $params);
			}
		}
	}
	public function getPath($httpContext, $data) {
		$params = ((null === $data) ? new Hash() : $data);
		if(!$this->processConstraints($httpContext, $params, ufront_web_UrlDirection::$UrlGeneration)) {
			return null;
		} else {
			if(null === $this->builder) {
				$this->builder = new ufront_web_routing_RouteUriBuilder($this->getAst());
			}
			if(null == $this->defaults) throw new HException('null iterable');
			$»it = $this->defaults->keys();
			while($»it->hasNext()) {
				$key = $»it->next();
				if($data->get($key) === $this->defaults->get($key)) {
					$data->remove($key);
				}
			}
			$url = $this->builder->build($params);
			if(null === $url || $params->exists("controller") || $params->exists("action")) {
				return null;
			}
			$qs = new _hx_array(array());
			if(null == $params) throw new HException('null iterable');
			$»it = $params->keys();
			while($»it->hasNext()) {
				$key = $»it->next();
				$qs->push(rawurlencode($key) . "=" . rawurlencode("" . $params->get($key)));
			}
			if($qs->length > 0) {
				$url .= "?" . $qs->join("&");
			}
			return $httpContext->generateUri($url);
		}
	}
	public function getUrl() {
		return $this->url;
	}
	public function processConstraints($httpContext, $params, $direction) {
		{
			$_g = 0; $_g1 = $this->constraints;
			while($_g < $_g1->length) {
				$constraint = $_g1[$_g];
				++$_g;
				if(!$constraint->match($httpContext, $this, $params, $direction)) {
					return false;
				}
				unset($constraint);
			}
		}
		return true;
	}
	public function toString() {
		return "{ url : " . $this->getUrl() . ", handler : " . $this->handler . ", defaults: " . $this->defaults . ", constraints : " . $this->constraints . " }";
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
	static $parser;
	static $__properties__ = array("get_url" => "getUrl");
	function __toString() { return $this->toString(); }
}
ufront_web_routing_Route::$parser = new ufront_web_routing_RouteUriParser();
