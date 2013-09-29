<?php

class erazor_ScriptBuilder {
	public function __construct($context) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("erazor.ScriptBuilder::new");
		$»spos = $GLOBALS['%s']->length;
		$this->context = $context;
		$GLOBALS['%s']->pop();
	}}
	public $context;
	public function build($blocks) {
		$GLOBALS['%s']->push("erazor.ScriptBuilder::build");
		$»spos = $GLOBALS['%s']->length;
		$buffer = new StringBuf();
		{
			$_g = 0;
			while($_g < $blocks->length) {
				$block = $blocks[$_g];
				++$_g;
				$buffer->b .= $this->blockToString($block);
				unset($block);
			}
		}
		{
			$»tmp = $buffer->b;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function blockToString($block) {
		$GLOBALS['%s']->push("erazor.ScriptBuilder::blockToString");
		$»spos = $GLOBALS['%s']->length;
		$»t = ($block);
		switch($»t->index) {
		case 0:
		$s = $»t->params[0];
		{
			$»tmp = $this->context . ".add('" . str_replace("'", "\\'", $s) . "');\x0A";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 1:
		$s = $»t->params[0];
		{
			$»tmp = $s . "\x0A";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 2:
		$s = $»t->params[0];
		{
			$»tmp = $this->context . ".add(" . $s . ");\x0A";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
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
	function __toString() { return 'erazor.ScriptBuilder'; }
}
