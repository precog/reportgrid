<?php

class ufront_web_mvc_HashValueProvider implements ufront_web_mvc_IValueProvider{
	public function __construct($collection) {
		if(!php_Boot::$skip_constructor) {
		$this->prefixes = new thx_collection_Set();
		$this->values = new Hash();
		$this->addValues($collection);
	}}
	public $prefixes;
	public $values;
	public function addValues($collection) {
		if($collection->iterator()->hasNext()) {
			$this->prefixes->add("");
		}
		if(null == $collection) throw new HException('null iterable');
		$»it = $collection->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			{
				$_g = 0; $_g1 = ufront_web_mvc_ValueProviderUtil::getPrefixes($key);
				while($_g < $_g1->length) {
					$prefix = $_g1[$_g];
					++$_g;
					$this->prefixes->add($prefix);
					unset($prefix);
				}
				unset($_g1,$_g);
			}
			$value = $collection->get($key);
			$this->values->set($key, new ufront_web_mvc_ValueProviderResult($value, Std::string($value)));
			unset($value);
		}
	}
	public function containsPrefix($prefix) {
		return $this->prefixes->exists($prefix);
	}
	public function getValue($key) {
		return (($this->values->exists($key)) ? $this->values->get($key) : null);
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
	function __toString() { return 'ufront.web.mvc.HashValueProvider'; }
}
