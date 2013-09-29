<?php

class erazor_Template {
	public function __construct($template) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("erazor.Template::new");
		$»spos = $GLOBALS['%s']->length;
		$this->template = $template;
		$GLOBALS['%s']->pop();
	}}
	public $template;
	public $variables;
	public function execute($content) {
		$GLOBALS['%s']->push("erazor.Template::execute");
		$»spos = $GLOBALS['%s']->length;
		$buffer = new StringBuf();
		$parsedBlocks = _hx_deref(new erazor_Parser())->parse($this->template);
		$script = _hx_deref(new erazor_ScriptBuilder("__b__"))->build($parsedBlocks);
		$parser = new hscript_Parser();
		$program = $parser->parseString($script);
		$interp = new erazor_hscript_EnhancedInterp();
		$this->variables = $interp->variables;
		$bufferStack = new _hx_array(array());
		$this->setInterpreterVars($interp, $content);
		$interp->variables->set("__b__", $buffer);
		$interp->variables->set("__string_buf__", array(new _hx_lambda(array(&$buffer, &$bufferStack, &$content, &$interp, &$parsedBlocks, &$parser, &$program, &$script), "erazor_Template_0"), 'execute'));
		$interp->variables->set("__restore_buf__", array(new _hx_lambda(array(&$buffer, &$bufferStack, &$content, &$interp, &$parsedBlocks, &$parser, &$program, &$script), "erazor_Template_1"), 'execute'));
		$interp->execute($program);
		{
			$»tmp = $buffer->b;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function setInterpreterVars($interp, $content) {
		$GLOBALS['%s']->push("erazor.Template::setInterpreterVars");
		$»spos = $GLOBALS['%s']->length;
		if(Std::is($content, _hx_qtype("Hash"))) {
			$hash = $content;
			if(null == $hash) throw new HException('null iterable');
			$»it = $hash->keys();
			while($»it->hasNext()) {
				$field = $»it->next();
				$interp->variables->set($field, $hash->get($field));
			}
		} else {
			$_g = 0; $_g1 = Reflect::fields($content);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$interp->variables->set($field, Reflect::field($content, $field));
				unset($field);
			}
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
	function __toString() { return 'erazor.Template'; }
}
function erazor_Template_0(&$buffer, &$bufferStack, &$content, &$interp, &$parsedBlocks, &$parser, &$program, &$script, $current) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("erazor.Template::execute@45");
		$»spos2 = $GLOBALS['%s']->length;
		$bufferStack->push($current);
		{
			$»tmp = new StringBuf();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function erazor_Template_1(&$buffer, &$bufferStack, &$content, &$interp, &$parsedBlocks, &$parser, &$program, &$script) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("erazor.Template::execute@50");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $bufferStack->pop();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
