<?php

class erazor_ScriptBuilder {
	public function __construct($context) {
		if(!php_Boot::$skip_constructor) {
		$this->context = $context;
	}}
	public $context;
	public function build($blocks) {
		$buffer = new StringBuf();
		{
			$_g = 0;
			while($_g < $blocks->length) {
				$block = $blocks[$_g];
				++$_g;
				$buffer->add($this->blockToString($block));
				unset($block);
			}
		}
		return $buffer->b;
	}
	public function blockToString($block) {
		$»t = ($block);
		switch($»t->index) {
		case 0:
		$s = $»t->params[0];
		{
			return $this->context . ".add('" . str_replace("'", "\\'", $s) . "');\x0A";
		}break;
		case 1:
		$s = $»t->params[0];
		{
			return $s . "\x0A";
		}break;
		case 2:
		$s = $»t->params[0];
		{
			return $this->context . ".add(" . $s . ");\x0A";
		}break;
		}
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
	function __toString() { return 'erazor.ScriptBuilder'; }
}
