<?php

class IntIter {
	public function __construct($min, $max) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("IntIter::new");
		$»spos = $GLOBALS['%s']->length;
		$this->min = $min;
		$this->max = $max;
		$GLOBALS['%s']->pop();
	}}
	public $min;
	public $max;
	public function hasNext() {
		$GLOBALS['%s']->push("IntIter::hasNext");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->min < $this->max;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function next() {
		$GLOBALS['%s']->push("IntIter::next");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->min++;
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
	function __toString() { return 'IntIter'; }
}
