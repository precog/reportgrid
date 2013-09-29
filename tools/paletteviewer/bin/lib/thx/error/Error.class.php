<?php

class thx_error_Error extends thx_util_Message {
	public function __construct($message, $params, $param, $pos) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.error.Error::new");
		$»spos = $GLOBALS['%s']->length;
		parent::__construct($message,$params,$param);
		$this->pos = $pos;
		$GLOBALS['%s']->pop();
	}}
	public $pos;
	public $inner;
	public function setInner($inner) {
		$GLOBALS['%s']->push("thx.error.Error::setInner");
		$»spos = $GLOBALS['%s']->length;
		$this->inner = $inner;
		{
			$GLOBALS['%s']->pop();
			return $this;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("thx.error.Error::toString");
		$»spos = $GLOBALS['%s']->length;
		try {
			{
				$»tmp = Strings::format($this->message, $this->params, null, null);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = new _hx_array(array());
				while($GLOBALS['%s']->length >= $»spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$ps = $this->pos->className . "." . $this->pos->methodName . "(" . $this->pos->lineNumber . ")";
				haxe_Log::trace("wrong parameters passed for pattern '" . $this->message . "' at " . $ps, _hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 34, "className" => "thx.error.Error", "methodName" => "toString")));
				{
					$GLOBALS['%s']->pop();
					return "";
				}
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
	function __toString() { return $this->toString(); }
}
