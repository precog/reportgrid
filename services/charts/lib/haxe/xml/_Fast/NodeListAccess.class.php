<?php

class haxe_xml__Fast_NodeListAccess {
	public function __construct($x) {
		if(!php_Boot::$skip_constructor) {
		$this->__x = $x;
	}}
	public $__x;
	public function resolve($name) {
		$l = new HList();
		if(null == $this->__x) throw new HException('null iterable');
		$»it = $this->__x->elementsNamed($name);
		while($»it->hasNext()) {
			$x = $»it->next();
			$l->add(new haxe_xml_Fast($x));
		}
		return $l;
	}
	public $»dynamics = array();
	public function __get($n) {
		if(isset($this->»dynamics[$n]))
			return $this->»dynamics[$n];
	}
	public function __set($n, $v) {
		$this->»dynamics[$n] = $v;
	}
	public function __call($n, $a) {
		if(isset($this->»dynamics[$n]) && is_callable($this->»dynamics[$n]))
			return call_user_func_array($this->»dynamics[$n], $a);
		if('toString' == $n)
			return $this->__toString();
		throw new HException("Unable to call «".$n."»");
	}
	function __toString() { return 'haxe.xml._Fast.NodeListAccess'; }
}
