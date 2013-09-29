<?php

class thx_culture_Info {
	public function __construct(){}
	public $name;
	public $native;
	public $english;
	public $iso2;
	public $iso3;
	public $pluralRule;
	public function toString() {
		$GLOBALS['%s']->push("thx.culture.Info::toString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->native . " (" . $this->english . ")";
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
