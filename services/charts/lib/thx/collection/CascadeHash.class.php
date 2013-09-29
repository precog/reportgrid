<?php

class thx_collection_CascadeHash {
	public function __construct($hashes) {
		if(!php_Boot::$skip_constructor) {
		if(null === $hashes) {
			throw new HException(new thx_error_NullArgument("hashes", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "CascadeHash.hx", "lineNumber" => 15, "className" => "thx.collection.CascadeHash", "methodName" => "new"))));
		}
		$this->_h = new HList();
		{
			$_g = 0;
			while($_g < $hashes->length) {
				$h = $hashes[$_g];
				++$_g;
				$this->_h->add($h);
				unset($h);
			}
		}
	}}
	public $_h;
	public function set($key, $value) {
		$this->_h->first()->set($key, $value);
	}
	public function remove($key) {
		if(null == $this->_h) throw new HException('null iterable');
		$»it = $this->_h->iterator();
		while($»it->hasNext()) {
			$h = $»it->next();
			if($h->remove($key)) {
				return true;
			}
		}
		return false;
	}
	public function get($key) {
		if(null == $this->_h) throw new HException('null iterable');
		$»it = $this->_h->iterator();
		while($»it->hasNext()) {
			$h = $»it->next();
			if($h->exists($key)) {
				return $h->get($key);
			}
		}
		return null;
	}
	public function exists($key) {
		if(null == $this->_h) throw new HException('null iterable');
		$»it = $this->_h->iterator();
		while($»it->hasNext()) {
			$h = $»it->next();
			if($h->exists($key)) {
				return true;
			}
		}
		return false;
	}
	public function iterator() {
		$list = new HList();
		if(null == $this) throw new HException('null iterable');
		$»it = $this->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$list->push($this->get($k));
		}
		return $list->iterator();
	}
	public function keys() {
		$s = new thx_collection_Set();
		if(null == $this->_h) throw new HException('null iterable');
		$»it = $this->_h->iterator();
		while($»it->hasNext()) {
			$h = $»it->next();
			if(null == $h) throw new HException('null iterable');
			$»it2 = $h->keys();
			while($»it2->hasNext()) {
				$k = $»it2->next();
				$s->add($k);
			}
		}
		return $s->iterator();
	}
	public function toString() {
		$arr = new _hx_array(array());
		if(null == $this) throw new HException('null iterable');
		$»it = $this->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$arr->push($k . ": " . $this->get($k));
		}
		return "{" . $arr->join(", ") . "}";
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
