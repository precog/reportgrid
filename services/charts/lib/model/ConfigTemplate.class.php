<?php

class model_ConfigTemplate {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->params = new thx_collection_Set();
		$this->allowedValues = new Hash();
		$this->defaults = new Hash();
	}}
	public $params;
	public $allowedValues;
	public $defaults;
	public function addParameter($name, $values) {
		$this->params->add($name);
		if(null !== $values) {
			$this->allowedValues->set($name, $values);
		}
	}
	public function isValid($name, $value) {
		$values = $this->allowedValues->get($name);
		if(null === $values) {
			return true;
		}
		return Arrays::exists($values, $value, null);
	}
	public function setDefault($name, $value) {
		$this->defaults->set($name, $value);
	}
	public function getDefault($name) {
		return $this->defaults->get($name);
	}
	public function replaceables() {
		$list = $this->params->harray();
		$list->sort(array(new _hx_lambda(array(&$list), "model_ConfigTemplate_0"), 'execute'));
		return $list;
	}
	public function toString() {
		return "ConfigTample: " . model_ConfigObjects::fieldsToString($this);
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
	function __toString() { return $this->toString(); }
}
function model_ConfigTemplate_0(&$list, $a, $b) {
	{
		$c = strlen($b) - strlen($a);
		if($c !== 0) {
			return $c;
		}
		return Strings::compare($a, $b);
	}
}
