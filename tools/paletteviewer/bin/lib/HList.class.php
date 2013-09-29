<?php

class HList implements IteratorAggregate{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("List::new");
		$»spos = $GLOBALS['%s']->length;
		$this->length = 0;
		$GLOBALS['%s']->pop();
	}}
	public $h;
	public $q;
	public $length;
	public function add($item) {
		$GLOBALS['%s']->push("List::add");
		$»spos = $GLOBALS['%s']->length;
		$x = array($item, null);
		if($this->h === null) {
			$this->h =& $x;
		} else {
			$this->q[1] =& $x;
		}
		$this->q =& $x;
		$this->length++;
		$GLOBALS['%s']->pop();
	}
	public function push($item) {
		$GLOBALS['%s']->push("List::push");
		$»spos = $GLOBALS['%s']->length;
		$x = array($item, &$this->h);
		$this->h =& $x;
		if($this->q === null) {
			$this->q =& $x;
		}
		$this->length++;
		$GLOBALS['%s']->pop();
	}
	public function first() {
		$GLOBALS['%s']->push("List::first");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = HList_0($this);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function last() {
		$GLOBALS['%s']->push("List::last");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = HList_1($this);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function pop() {
		$GLOBALS['%s']->push("List::pop");
		$»spos = $GLOBALS['%s']->length;
		if($this->h === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		$x = $this->h[0];
		$this->h = $this->h[1];
		if($this->h === null) {
			$this->q = null;
		}
		$this->length--;
		{
			$GLOBALS['%s']->pop();
			return $x;
		}
		$GLOBALS['%s']->pop();
	}
	public function isEmpty() {
		$GLOBALS['%s']->push("List::isEmpty");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->h === null;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function clear() {
		$GLOBALS['%s']->push("List::clear");
		$»spos = $GLOBALS['%s']->length;
		$this->h = null;
		$this->q = null;
		$this->length = 0;
		$GLOBALS['%s']->pop();
	}
	public function remove($v) {
		$GLOBALS['%s']->push("List::remove");
		$»spos = $GLOBALS['%s']->length;
		$prev = null;
		$l = & $this->h;
		while($l !== null) {
			if($l[0] === $v) {
				if($prev === null) {
					$this->h =& $l[1];
				} else {
					$prev[1] =& $l[1];
				}
				if(($this->q === $l)) {
					$this->q =& $prev;
				}
				$this->length--;
				{
					$GLOBALS['%s']->pop();
					return true;
				}
			}
			$prev =& $l;
			$l =& $l[1];
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	public function iterator() {
		$GLOBALS['%s']->push("List::iterator");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = new _hx_list_iterator($this);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("List::toString");
		$»spos = $GLOBALS['%s']->length;
		$s = "";
		$first = true;
		$l = $this->h;
		while($l !== null) {
			if($first) {
				$first = false;
			} else {
				$s .= ", ";
			}
			$s .= Std::string($l[0]);
			$l = $l[1];
		}
		{
			$»tmp = "{" . $s . "}";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function join($sep) {
		$GLOBALS['%s']->push("List::join");
		$»spos = $GLOBALS['%s']->length;
		$s = "";
		$first = true;
		$l = $this->h;
		while($l !== null) {
			if($first) {
				$first = false;
			} else {
				$s .= $sep;
			}
			$s .= $l[0];
			$l = $l[1];
		}
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function filter($f) {
		$GLOBALS['%s']->push("List::filter");
		$»spos = $GLOBALS['%s']->length;
		$l2 = new HList();
		$l = $this->h;
		while($l !== null) {
			$v = $l[0];
			$l = $l[1];
			if(call_user_func_array($f, array($v))) {
				$l2->add($v);
			}
			unset($v);
		}
		{
			$GLOBALS['%s']->pop();
			return $l2;
		}
		$GLOBALS['%s']->pop();
	}
	public function map($f) {
		$GLOBALS['%s']->push("List::map");
		$»spos = $GLOBALS['%s']->length;
		$b = new HList();
		$l = $this->h;
		while($l !== null) {
			$v = $l[0];
			$l = $l[1];
			$b->add(call_user_func_array($f, array($v)));
			unset($v);
		}
		{
			$GLOBALS['%s']->pop();
			return $b;
		}
		$GLOBALS['%s']->pop();
	}
	public function getIterator() {
		$GLOBALS['%s']->push("List::getIterator");
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
function HList_0(&$»this) {
	$»spos = $GLOBALS['%s']->length;
	if($»this->h === null) {
		return null;
	} else {
		return $»this->h[0];
	}
}
function HList_1(&$»this) {
	$»spos = $GLOBALS['%s']->length;
	if($»this->q === null) {
		return null;
	} else {
		return $»this->q[0];
	}
}
