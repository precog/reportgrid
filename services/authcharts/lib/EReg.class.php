<?php

class EReg {
	public function __construct($r, $opt) {
		if(!php_Boot::$skip_constructor) {
		$this->pattern = $r;
		$a = _hx_explode("g", $opt);
		$this->hglobal = $a->length > 1;
		if($this->hglobal) {
			$opt = $a->join("");
		}
		$this->options = $opt;
		$this->re = "/" . (str_replace("/", "\\/", $r) . "/" . $opt);
	}}
	public $r;
	public $last;
	public $hglobal;
	public $pattern;
	public $options;
	public $re;
	public $matches;
	public function match($s) {
		$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		if($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		return $p > 0;
	}
	public function matched($n) {
		if($n < 0) {
			throw new HException("EReg::matched");
		}
		if($n >= count($this->matches)) {
			return null;
		}
		if($this->matches[$n][1] < 0) {
			return null;
		}
		return $this->matches[$n][0];
	}
	public function matchedLeft() {
		if(count($this->matches) === 0) {
			throw new HException("No string matched");
		}
		return _hx_substr($this->last, 0, $this->matches[0][1]);
	}
	public function matchedRight() {
		if(count($this->matches) === 0) {
			throw new HException("No string matched");
		}
		return _hx_substr($this->last, $this->matches[0][1] + strlen($this->matches[0][0]), null);
	}
	public function matchedPos() {
		return _hx_anonymous(array("pos" => $this->matches[0][1], "len" => strlen($this->matches[0][0])));
	}
	public function split($s) {
		return new _hx_array(preg_split($this->re, $s, $this->hglobal ? -1 : 2));
	}
	public function replace($s, $by) {
		$by = str_replace("\$\$", "\\\$", $by);
		if(!preg_match('/\\([^?].+?\\)/', $this->re)) $by = preg_replace('/\$(\d+)/', '\\\$\1', $by);
		return preg_replace($this->re, $by, $s, (($this->hglobal) ? -1 : 1));
	}
	public function customReplace($s, $f) {
		$buf = new StringBuf();
		while(true) {
			if(!$this->match($s)) {
				break;
			}
			{
				$x = $this->matchedLeft();
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
				unset($x);
			}
			{
				$x = call_user_func_array($f, array($this));
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$buf->b .= $x;
				unset($x);
			}
			$s = $this->matchedRight();
		}
		{
			$x = $s;
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$buf->b .= $x;
		}
		return $buf->b;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->�dynamics[$m]) && is_callable($this->�dynamics[$m]))
			return call_user_func_array($this->�dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	function __toString() { return 'EReg'; }
}
