<?php

class ufront_web_routing_RouteCollection {
	public function __construct($routes) {
		if(!php_Boot::$skip_constructor) {
		$this->_routes = new _hx_array(array());
		if(null !== $routes) {
			if(null == $routes) throw new HException('null iterable');
			$»it = $routes->iterator();
			while($»it->hasNext()) {
				$route = $»it->next();
				$this->add($route);
			}
		}
	}}
	public $_routes;
	public function add($route) {
		$this->_routes->push($route);
		$r = $route;
		$r->setRoutes($this);
		return $this;
	}
	public function addRoute($uri, $defaults, $constraint, $constraints) {
		if(null !== $constraint) {
			$constraints = new _hx_array(array($constraint));
		}
		return $this->add(new ufront_web_routing_Route($uri, new ufront_web_mvc_MvcRouteHandler(), ((null === $defaults) ? null : DynamicsT::toHash($defaults)), $constraints));
	}
	public function iterator() {
		return $this->_routes->iterator();
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
	function __toString() { return 'ufront.web.routing.RouteCollection'; }
}
