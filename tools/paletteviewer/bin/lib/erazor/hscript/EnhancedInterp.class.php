<?php

class erazor_hscript_EnhancedInterp extends hscript_Interp {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("erazor.hscript.EnhancedInterp::new");
		$»spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	public function call($o, $f, $args) {
		$GLOBALS['%s']->push("erazor.hscript.EnhancedInterp::call");
		$»spos = $GLOBALS['%s']->length;
		while(true) {
			try {
				{
					$»tmp = Reflect::callMethod($o, $f, $args);
					$GLOBALS['%s']->pop();
					return $»tmp;
					unset($»tmp);
				}
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(is_string($e = $_ex_)){
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $»spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					if(_hx_substr($e, 0, 16) !== "Missing argument") {
						php_Lib::rethrow($e);
					}
					$expected = $args->length + 1;
					if(erazor_hscript_EnhancedInterp::$re->match($e)) {
						$expected = Std::parseInt(erazor_hscript_EnhancedInterp::$re->matched(1));
					}
					if($expected > 15) {
						throw new HException("invalid number of arguments");
					} else {
						if($expected < $args->length) {
							$args = $args->slice(0, $expected);
						} else {
							while($expected > $args->length) {
								$args->push(null);
							}
						}
					}
					unset($expected);
				} else throw $»e;;
			}
			unset($e);
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function expr($e) {
		$GLOBALS['%s']->push("erazor.hscript.EnhancedInterp::expr");
		$»spos = $GLOBALS['%s']->length;
		$»t = ($e);
		switch($»t->index) {
		case 14:
		$ret = $»t->params[3]; $name = $»t->params[2]; $fexpr = $»t->params[1]; $params = $»t->params[0];
		{
			$capturedLocals = $this->duplicate($this->locals);
			$me = $this;
			$f = array(new _hx_lambda(array(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params, &$ret), "erazor_hscript_EnhancedInterp_0"), 'execute');
			$f1 = Reflect::makeVarArgs($f);
			if($name !== null) {
				$this->variables->set($name, $f1);
			}
			{
				$GLOBALS['%s']->pop();
				return $f1;
			}
		}break;
		default:{
			$»tmp = parent::expr($e);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static $re;
	function __toString() { return 'erazor.hscript.EnhancedInterp'; }
}
erazor_hscript_EnhancedInterp::$re = new EReg("^[^0-9]+(\\d+)", "");
function erazor_hscript_EnhancedInterp_0(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params, &$ret, $args) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("erazor.hscript.EnhancedInterp::expr@70");
		$»spos2 = $GLOBALS['%s']->length;
		$old = $me->locals;
		$me->locals = $me->duplicate($capturedLocals);
		{
			$_g1 = 0; $_g = $params->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$me->locals->set(_hx_array_get($params, $i)->name, _hx_anonymous(array("r" => $args[$i])));
				unset($i);
			}
		}
		$r = null;
		try {
			$r = $me->exprReturn($fexpr);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e1 = $_ex_;
			{
				$GLOBALS['%e'] = new _hx_array(array());
				while($GLOBALS['%s']->length >= $»spos2) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$me->locals = $old;
				throw new HException($e1);
			}
		}
		$me->locals = $old;
		{
			$GLOBALS['%s']->pop();
			return $r;
		}
		$GLOBALS['%s']->pop();
	}
}
