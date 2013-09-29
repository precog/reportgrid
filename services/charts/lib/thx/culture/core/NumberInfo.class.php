<?php

class thx_culture_core_NumberInfo {
	public function __construct($decimals, $decimalsSeparator, $groups, $groupsSeparator, $patternNegative, $patternPositive) {
		if(!php_Boot::$skip_constructor) {
		$this->decimals = $decimals;
		$this->decimalsSeparator = $decimalsSeparator;
		$this->groups = $groups;
		$this->groupsSeparator = $groupsSeparator;
		$this->patternNegative = $patternNegative;
		$this->patternPositive = $patternPositive;
	}}
	public $decimals;
	public $decimalsSeparator;
	public $groups;
	public $groupsSeparator;
	public $patternNegative;
	public $patternPositive;
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
	function __toString() { return 'thx.culture.core.NumberInfo'; }
}
