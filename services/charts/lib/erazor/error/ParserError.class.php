<?php

class erazor_error_ParserError {
	public function __construct($msg, $pos, $excerpt) {
		if(!php_Boot::$skip_constructor) {
		$this->msg = $msg;
		$this->pos = $pos;
		$this->excerpt = $excerpt;
	}}
	public $msg;
	public $pos;
	public $excerpt;
	public function toString() {
		$excerpt = $this->excerpt;
		if($excerpt !== null) {
			$nl = _hx_index_of($excerpt, "\x0A", null);
			if($nl !== -1) {
				$excerpt = _hx_substr($excerpt, 0, $nl);
			}
		}
		return $this->msg . " @ " . $this->pos . (erazor_error_ParserError_0($this, $excerpt));
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
function erazor_error_ParserError_0(&$»this, &$excerpt) {
	if($excerpt !== null) {
		return " ( \"" . $excerpt . "\" )";
	} else {
		return "";
	}
}
