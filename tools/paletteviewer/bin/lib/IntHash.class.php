<?php

class IntHash implements IteratorAggregate{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("IntHash::new");
		$»spos = $GLOBALS['%s']->length;
		$this->h = array();
		$GLOBALS['%s']->pop();
	}}
	public $h;
	public function set($key, $value) {
		$GLOBALS['%s']->push("IntHash::set");
		$»spos = $GLOBALS['%s']->length;
		$this->h[$key] = $value;
		$GLOBALS['%s']->pop();
	}
	public function get($key) {
		$GLOBALS['%s']->push("IntHash::get");
		$»spos = $GLOBALS['%s']->length;
		if(array_key_exists($key, $this->h)) {
			$»tmp = $this->h[$key];
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function exists($key) {
		$GLOBALS['%s']->push("IntHash::exists");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = array_key_exists($key, $this->h);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function remove($key) {
		$GLOBALS['%s']->push("IntHash::remove");
		$»spos = $GLOBALS['%s']->length;
		if(array_key_exists($key, $this->h)) {
			unset($this->h[$key]);
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		} else {
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	public function keys() {
		$GLOBALS['%s']->push("IntHash::keys");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new _hx_array_iterator(array_keys($this->h));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function iterator() {
		$GLOBALS['%s']->push("IntHash::iterator");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new _hx_array_iterator(array_values($this->h));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("IntHash::toString");
		$»spos = $GLOBALS['%s']->length;
		$s = "{";
		$it = $this->keys();
		$»it = $it;
		while($»it->hasNext()) {
			$i = $»it->next();
			$s .= $i;
			$s .= " => ";
			$s .= Std::string($this->get($i));
			if($it->hasNext()) {
				$s .= ", ";
			}
		}
		{
			$»tmp = $s . "}";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getIterator() {
		$GLOBALS['%s']->push("IntHash::getIterator");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->iterator();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
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
