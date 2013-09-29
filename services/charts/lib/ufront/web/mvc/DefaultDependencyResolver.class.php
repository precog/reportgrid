<?php

class ufront_web_mvc_DefaultDependencyResolver implements ufront_web_mvc_IDependencyResolver{
	public function __construct($alt) {
		if(!php_Boot::$skip_constructor) {
		$this->alt = $alt;
	}}
	public $alt;
	public function getService($type) {
		try {
			$args = new _hx_array(array());
			if(null !== $this->alt && thx_type_Rttis::hasInfo($type)) {
				$types = thx_type_Rttis::methodArgumentTypes($type, "new");
				if(null !== $types) {
					$_g = 0;
					while($_g < $types->length) {
						$type1 = $types[$_g];
						++$_g;
						$args->push($this->alt->getService(Type::resolveClass($type1)));
						unset($type1);
					}
				}
			}
			return Type::createInstance($type, $args);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				return null;
			}
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
	function __toString() { return 'ufront.web.mvc.DefaultDependencyResolver'; }
}
