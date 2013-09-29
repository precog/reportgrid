<?php

class thx_json_JsonEncoder implements thx_data_IDataHandler{
	public function __construct() {
		;
	}
	public $encodedString;
	public $buf;
	public $lvl;
	public $count;
	public function start() {
		$this->lvl = 0;
		$this->buf = new StringBuf();
		$this->encodedString = null;
		$this->count = new _hx_array(array());
	}
	public function end() {
		$this->encodedString = $this->buf->b;
		$this->buf = null;
	}
	public function startObject() {
		{
			$x = "{";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
		$this->count->push(0);
	}
	public function startField($name) {
		if($this->count->»a[$this->count->length - 1]++ > 0) {
			$x = ",";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
		{
			$x = $this->quote($name) . ":";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
	}
	public function endField() {
	}
	public function endObject() {
		{
			$x = "}";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
		$this->count->pop();
	}
	public function startArray() {
		{
			$x = "[";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
		$this->count->push(0);
	}
	public function startItem() {
		if($this->count->»a[$this->count->length - 1]++ > 0) {
			$x = ",";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
	}
	public function endItem() {
	}
	public function endArray() {
		{
			$x = "]";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
		$this->count->pop();
	}
	public function date($d) {
		$x = $d->getTime();
		if(is_null($x)) {
			$x = "null";
		} else {
			if(is_bool($x)) {
				$x = (($x) ? "true" : "false");
			}
		}
		$this->buf->b .= $x;
	}
	public function string($s) {
		$x = $this->quote($s);
		if(is_null($x)) {
			$x = "null";
		} else {
			if(is_bool($x)) {
				$x = (($x) ? "true" : "false");
			}
		}
		$this->buf->b .= $x;
	}
	public function int($i) {
		$x = $i;
		if(is_null($x)) {
			$x = "null";
		} else {
			if(is_bool($x)) {
				$x = (($x) ? "true" : "false");
			}
		}
		$this->buf->b .= $x;
	}
	public function float($f) {
		$x = $f;
		if(is_null($x)) {
			$x = "null";
		} else {
			if(is_bool($x)) {
				$x = (($x) ? "true" : "false");
			}
		}
		$this->buf->b .= $x;
	}
	public function null() {
		$x = "null";
		if(is_null($x)) {
			$x = "null";
		} else {
			if(is_bool($x)) {
				$x = (($x) ? "true" : "false");
			}
		}
		$this->buf->b .= $x;
	}
	public function bool($b) {
		$x = (($b) ? "true" : "false");
		if(is_null($x)) {
			$x = "null";
		} else {
			if(is_bool($x)) {
				$x = (($x) ? "true" : "false");
			}
		}
		$this->buf->b .= $x;
	}
	public function comment($s) {
	}
	public function quote($s) {
		return "\"" . _hx_deref(new EReg(".", ""))->customReplace(_hx_deref(new EReg("(\x0A)", "g"))->replace(_hx_deref(new EReg("(\"|\\\\)", "g"))->replace($s, "\\\$1"), "\\n"), array(new _hx_lambda(array(&$s), "thx_json_JsonEncoder_0"), 'execute')) . "\"";
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
	function __toString() { return 'thx.json.JsonEncoder'; }
}
function thx_json_JsonEncoder_0(&$s, $r) {
	{
		$c = _hx_char_code_at($r->matched(0), 0);
		return thx_json_JsonEncoder_1($»this, $c, $r, $s);
	}
}
function thx_json_JsonEncoder_1(&$»this, &$c, &$r, &$s) {
	if($c >= 32 && $c <= 127) {
		return chr($c);
	} else {
		return "\\u" . StringTools::hex($c, 4);
	}
}
