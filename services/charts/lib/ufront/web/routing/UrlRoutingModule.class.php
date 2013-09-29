<?php

class ufront_web_routing_UrlRoutingModule implements ufront_web_IHttpModule{
	public function __construct($routeCollection) {
		if(!php_Boot::$skip_constructor) {
		$this->routeCollection = (($routeCollection !== null) ? $routeCollection : new ufront_web_routing_RouteCollection(null));
	}}
	public $routeCollection;
	public $httpHandler;
	public function init($application) {
		$application->onPostResolveRequestCache->add((isset($this->setHttpHandler) ? $this->setHttpHandler: array($this, "setHttpHandler")));
		$application->onPostMapRequestHandler->addAsync((isset($this->executeHttpHandler) ? $this->executeHttpHandler: array($this, "executeHttpHandler")));
	}
	public function setHttpHandler($application) {
		$httpContext = $application->httpContext;
		if(null == $this->routeCollection) throw new HException('null iterable');
		$»it = $this->routeCollection->iterator();
		while($»it->hasNext()) {
			$route = $»it->next();
			$data = $route->getRouteData($httpContext);
			if($data === null) {
				continue;
			}
			$requestContext = new ufront_web_routing_RequestContext($httpContext, $data, $this->routeCollection);
			$this->httpHandler = $data->routeHandler->getHttpHandler($requestContext);
			return;
			unset($requestContext,$data);
		}
		throw new HException(new ufront_web_error_PageNotFoundError(_hx_anonymous(array("fileName" => "UrlRoutingModule.hx", "lineNumber" => 43, "className" => "ufront.web.routing.UrlRoutingModule", "methodName" => "setHttpHandler"))));
	}
	public function executeHttpHandler($application, $async) {
		$this->httpHandler->processRequest($application->httpContext, $async);
	}
	public function dispose() {
		$this->routeCollection = null;
		$this->httpHandler = null;
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
	function __toString() { return 'ufront.web.routing.UrlRoutingModule'; }
}
