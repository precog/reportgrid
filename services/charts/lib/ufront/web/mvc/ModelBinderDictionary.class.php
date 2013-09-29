<?php

class ufront_web_mvc_ModelBinderDictionary {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_innerDictionary = new Hash();
	}}
	public $count;
	public function getCount() {
		return Lambda::count($this->_innerDictionary, null);
	}
	public $_defaultBinder;
	public $defaultBinder;
	public function getDefaultBinder() {
		if($this->_defaultBinder === null) {
			$this->_defaultBinder = new ufront_web_mvc_DefaultModelBinder();
		}
		return $this->_defaultBinder;
	}
	public function setDefaultBinder($v) {
		$this->_defaultBinder = $v;
		return $this->_defaultBinder;
	}
	public $keys;
	public function getKeys() {
		return $this->_innerDictionary->keys();
	}
	public $values;
	public function getValues() {
		return $this->_innerDictionary->iterator();
	}
	public function add($key, $value) {
		$this->_innerDictionary->set($this->typeString($key), $value);
	}
	public function remove($key) {
		$this->_innerDictionary->remove($this->typeString($key));
	}
	public function clear() {
		if(null == $this->_innerDictionary) throw new HException('null iterable');
		$»it = $this->_innerDictionary->keys();
		while($»it->hasNext()) {
			$v = $»it->next();
			$this->_innerDictionary->remove($v);
		}
	}
	public function contains($item) {
		return Lambda::exists($this->_innerDictionary, array(new _hx_lambda(array(&$item), "ufront_web_mvc_ModelBinderDictionary_0"), 'execute'));
	}
	public function containsKey($key) {
		return $this->_innerDictionary->exists($this->typeString($key));
	}
	public function getBinder($type, $fallbackBinder, $fallbackToDefault) {
		if($fallbackToDefault === null) {
			$fallbackToDefault = true;
		}
		if($this->containsKey($type)) {
			return $this->_innerDictionary->get($this->typeString($type));
		}
		return (($fallbackBinder !== null) ? $fallbackBinder : (($fallbackToDefault) ? $this->getDefaultBinder() : null));
	}
	public function typeString($type) {
		if(Std::is($type, _hx_qtype("String"))) {
			return $type;
		}
		if(Std::is($type, _hx_qtype("Class"))) {
			return Type::getClassName($type);
		}
		throw new HException("Couldn't find a binder class for " . $type);
	}
	public function iterator() {
		return $this->_innerDictionary->iterator();
	}
	public $_innerDictionary;
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
	static $__properties__ = array("get_values" => "getValues","get_keys" => "getKeys","set_defaultBinder" => "setDefaultBinder","get_defaultBinder" => "getDefaultBinder","get_count" => "getCount");
	function __toString() { return 'ufront.web.mvc.ModelBinderDictionary'; }
}
function ufront_web_mvc_ModelBinderDictionary_0(&$item, $binder) {
	{
		return $binder === $item;
	}
}
