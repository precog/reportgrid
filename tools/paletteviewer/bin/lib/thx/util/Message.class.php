<?php

class thx_util_Message {
	public function __construct($message, $params, $param) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.util.Message::new");
		$»spos = $GLOBALS['%s']->length;
		$this->message = $message;
		if(null === $params) {
			$this->params = new _hx_array(array());
		} else {
			$this->params = $params;
		}
		if(null !== $param) {
			$this->params->push($param);
		}
		$GLOBALS['%s']->pop();
	}}
	public $message;
	public $params;
	public function toString() {
		$GLOBALS['%s']->push("thx.util.Message::toString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Strings::format($this->message, $this->params, null, null);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function translatef($translator) {
		$GLOBALS['%s']->push("thx.util.Message::translatef");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Strings::format(call_user_func_array($translator, array($this->message)), $this->params, null, null);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function translate($translator, $domain) {
		$GLOBALS['%s']->push("thx.util.Message::translate");
		$»spos = $GLOBALS['%s']->length;
		if(null === $domain) {
			$domain = $translator->getDomain();
		}
		$culture = thx_culture_Culture::get($domain);
		if($this->params->length === 1 && Std::is($this->params[0], _hx_qtype("Int"))) {
			$»tmp = Strings::format($translator->__(null, $this->message, $this->params[0], $domain), $this->params, null, $culture);
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = Strings::format($translator->_($this->message, $domain), $this->params, null, $culture);
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
