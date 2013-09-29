<?php

class thx_collection_HashList {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->length = 0;
		$this->__keys = new _hx_array(array());
		$this->__hash = new Hash();
	}}
	public $length;
	public function set($key, $value) {
		if(!$this->__hash->exists($key)) {
			$this->__keys->push($key);
			$this->length++;
		}
		$this->__hash->set($key, $value);
	}
	public function setAt($index, $key, $value) {
		$this->remove($key);
		$this->__keys->insert($index, $key);
		$this->__hash->set($key, $value);
		$this->length++;
	}
	public function get($key) {
		return $this->__hash->get($key);
	}
	public function getAt($index) {
		return $this->__hash->get($this->__keys[$index]);
	}
	public function indexOf($key) {
		if(!$this->__hash->exists($key)) {
			return -1;
		}
		{
			$_g1 = 0; $_g = $this->__keys->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($this->__keys[$i] === $key) {
					return $i;
				}
				unset($i);
			}
		}
		thx_collection_HashList_0($this, $key);
	}
	public function exists($key) {
		return $this->__hash->exists($key);
	}
	public function remove($key) {
		$item = $this->__hash->get($key);
		if($item === null) {
			return null;
		}
		$this->__hash->remove($key);
		$this->__keys->remove($key);
		$this->length--;
		return $item;
	}
	public function removeAt($index) {
		$key = $this->__keys[$index];
		if($key === null) {
			return null;
		}
		$item = $this->__hash->get($key);
		$this->__hash->remove($key);
		$this->__keys->remove($key);
		$this->length--;
		return $item;
	}
	public function keyAt($index) {
		return $this->__keys[$index];
	}
	public function keys() {
		return $this->__keys->iterator();
	}
	public function iterator() {
		return $this->harray()->iterator();
	}
	public function clear() {
		$this->__hash = new Hash();
		$this->__keys = new _hx_array(array());
		$this->length = 0;
	}
	public function harray() {
		$values = new _hx_array(array());
		{
			$_g = 0; $_g1 = $this->__keys;
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$values->push($this->__hash->get($k));
				unset($k);
			}
		}
		return $values;
	}
	public function toString() {
		$s = new StringBuf();
		$s->add("{");
		$it = $this->keys();
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			$s->add($i);
			$s->add(" => ");
			$s->add(Std::string($this->get($i)));
			if($it->hasNext()) {
				$s->add(", ");
			}
		}
		$s->add("}");
		return $s->b;
	}
	public $__keys;
	public $__hash;
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
function thx_collection_HashList_0(&$»this, &$key) {
	throw new HException("this should never happen");
}
