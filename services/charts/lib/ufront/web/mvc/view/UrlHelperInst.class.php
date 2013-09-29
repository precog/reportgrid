<?php

class ufront_web_mvc_view_UrlHelperInst {
	public function __construct($requestContext) {
		if(!php_Boot::$skip_constructor) {
		$this->__req = $requestContext;
	}}
	public $__req;
	public function base($uri) {
		if(null === $uri) {
			$uri = "/";
		}
		return $this->__req->httpContext->generateUri($uri);
	}
	public function current($params) {
		$url = $this->__req->httpContext->getRequestUri();
		if(null !== $params) {
			$qs = new _hx_array(array());
			{
				$_g = 0; $_g1 = Reflect::fields($params);
				while($_g < $_g1->length) {
					$field = $_g1[$_g];
					++$_g;
					$value = Reflect::field($params, $field);
					$qs->push($field . "=" . $this->encode($value));
					unset($value,$field);
				}
			}
			if($qs->length > 0) {
				$url .= (((_hx_index_of($url, "?", null) >= 0) ? "&" : "?")) . $qs->join("&");
			}
		}
		return $this->__req->httpContext->generateUri($url);
	}
	public function encode($s) {
		return rawurlencode($s);
	}
	public function route($data) {
		$hash = null;
		if(null === $data) {
			$hash = new Hash();
		} else {
			if(Std::is($data, _hx_qtype("Hash"))) {
				$hash = Hashes::hclone($data);
			} else {
				$hash = DynamicsT::toHash($data);
			}
		}
		if(null === $hash->get("controller")) {
			$route = Types::has($this->__req->routeData->route, _hx_qtype("ufront.web.routing.Route"));
			if(null === $route) {
				throw new HException(new thx_error_Error("unable to find a controller for {0}", null, Std::string($hash), _hx_anonymous(array("fileName" => "UrlHelper.hx", "lineNumber" => 78, "className" => "ufront.web.mvc.view.UrlHelperInst", "methodName" => "route"))));
			}
			$hash->set("controller", $route->defaults->get("controller"));
			if(null === $hash->get("controller")) {
				throw new HException(new thx_error_Error("the routed data doesn't include the 'controller' parameter", null, null, _hx_anonymous(array("fileName" => "UrlHelper.hx", "lineNumber" => 81, "className" => "ufront.web.mvc.view.UrlHelperInst", "methodName" => "route"))));
			}
		}
		if(null == $this->__req->routeData->route->routes) throw new HException('null iterable');
		$»it = $this->__req->routeData->route->routes->iterator();
		while($»it->hasNext()) {
			$route = $»it->next();
			$url = $route->getPath($this->__req->httpContext, Hashes::hclone($hash));
			if(null !== $url) {
				return $url;
			}
			unset($url);
		}
		throw new HException(new thx_error_Error("unable to find a suitable route for {0}", null, Std::string($hash), _hx_anonymous(array("fileName" => "UrlHelper.hx", "lineNumber" => 90, "className" => "ufront.web.mvc.view.UrlHelperInst", "methodName" => "route"))));
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
	function __toString() { return 'ufront.web.mvc.view.UrlHelperInst'; }
}
