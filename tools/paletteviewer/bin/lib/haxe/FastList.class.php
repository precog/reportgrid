<?php

class haxe_FastList {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("haxe.FastList::new");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}}
	public $head;
	public function add($item) {
		$GLOBALS['%s']->push("haxe.FastList::add");
		$»spos = $GLOBALS['%s']->length;
		$this->head = new haxe_FastCell($item, $this->head);
		$GLOBALS['%s']->pop();
	}
	public function first() {
		$GLOBALS['%s']->push("haxe.FastList::first");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = haxe_FastList_0($this);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function pop() {
		$GLOBALS['%s']->push("haxe.FastList::pop");
		$»spos = $GLOBALS['%s']->length;
		$k = $this->head;
		if($k === null) {
			$GLOBALS['%s']->pop();
			return null;
		} else {
			$this->head = $k->next;
			{
				$»tmp = $k->elt;
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function isEmpty() {
		$GLOBALS['%s']->push("haxe.FastList::isEmpty");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->head === null;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function remove($v) {
		$GLOBALS['%s']->push("haxe.FastList::remove");
		$»spos = $GLOBALS['%s']->length;
		$prev = null;
		$l = $this->head;
		while($l !== null) {
			if($l->elt === $v) {
				if($prev === null) {
					$this->head = $l->next;
				} else {
					$prev->next = $l->next;
				}
				break;
			}
			$prev = $l;
			$l = $l->next;
		}
		{
			$»tmp = $l !== null;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function iterator() {
		$GLOBALS['%s']->push("haxe.FastList::iterator");
		$»spos = $GLOBALS['%s']->length;
		$l = $this->head;
		{
			$»tmp = _hx_anonymous(array("hasNext" => array(new _hx_lambda(array(&$l), "haxe_FastList_1"), 'execute'), "next" => array(new _hx_lambda(array(&$l), "haxe_FastList_2"), 'execute')));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("haxe.FastList::toString");
		$»spos = $GLOBALS['%s']->length;
		$a = new _hx_array(array());
		$l = $this->head;
		while($l !== null) {
			$a->push($l->elt);
			$l = $l->next;
		}
		{
			$»tmp = "{" . $a->join(",") . "}";
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
function haxe_FastList_0(&$»this) {
	$»spos = $GLOBALS['%s']->length;
	if($»this->head === null) {
		return null;
	} else {
		return $»this->head->elt;
	}
}
function haxe_FastList_1(&$l) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("haxe.FastList::iterator@126");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $l !== null;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function haxe_FastList_2(&$l) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("haxe.FastList::iterator@129");
		$»spos2 = $GLOBALS['%s']->length;
		$k = $l;
		$l = $k->next;
		{
			$»tmp = $k->elt;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
