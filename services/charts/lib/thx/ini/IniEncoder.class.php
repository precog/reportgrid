<?php

class thx_ini_IniEncoder implements thx_data_IDataHandler{
	public function __construct($newline, $ignorecomments) {
		if(!php_Boot::$skip_constructor) {
		if($ignorecomments === null) {
			$ignorecomments = true;
		}
		if($newline === null) {
			$newline = "\x0A";
		}
		$this->newline = $newline;
		$this->ignorecomments = $ignorecomments;
	}}
	public $ignorecomments;
	public $newline;
	public $buf;
	public $encodedString;
	public $inarray;
	public $cache;
	public $value;
	public $stack;
	public function start() {
		$this->inarray = 0;
		$this->stack = new _hx_array(array());
		$this->cache = new Hash();
	}
	public function end() {
		$keys = thx_ini_IniEncoder_0($this);
		$lines = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if("" !== $key) {
					$lines->push("");
					$lines->push("[" . $key . "]");
				}
				$lines = $lines->concat($this->cache->get($key));
				unset($key);
			}
		}
		$this->encodedString = trim($lines->join($this->newline));
	}
	public function objectStart() {
		if($this->inarray > 0) {
			throw new HException(new thx_error_Error("arrays must contain only primitive values", null, null, _hx_anonymous(array("fileName" => "IniEncoder.hx", "lineNumber" => 58, "className" => "thx.ini.IniEncoder", "methodName" => "objectStart"))));
		}
	}
	public function objectFieldStart($name) {
		$this->stack->push($this->enc($name));
		$this->value = "";
	}
	public function objectFieldEnd() {
		if(null === $this->value) {
			return;
		}
		$key = $this->stack->pop();
		$name = $this->stack->join(".");
		$section = $this->getSection($name);
		$section->push($key . "=" . $this->value);
		$this->value = null;
	}
	public function getSection($name) {
		$section = $this->cache->get($name);
		if(null === $section) {
			$section = new _hx_array(array());
			$this->cache->set($name, $section);
		}
		return $section;
	}
	public function objectEnd() {
		$this->stack->pop();
	}
	public function arrayStart() {
		if($this->inarray > 0) {
			throw new HException(new thx_error_Error("nested arrays are not supported in the .ini format", null, null, _hx_anonymous(array("fileName" => "IniEncoder.hx", "lineNumber" => 97, "className" => "thx.ini.IniEncoder", "methodName" => "arrayStart"))));
		}
		$this->inarray = 1;
		$this->value = "";
	}
	public function arrayItemStart() {
		if($this->inarray === 1) {
			$this->inarray = 2;
		} else {
			$this->value .= ", ";
		}
	}
	public function arrayItemEnd() {
	}
	public function arrayEnd() {
		$this->inarray = 0;
	}
	public function valueDate($d) {
		if($d->getSeconds() === 0 && $d->getMinutes() === 0 && $d->getHours() === 0) {
			$this->value .= Dates::format($d, "C", new _hx_array(array("%Y-%m-%d")), null);
		} else {
			$this->value .= Dates::format($d, "C", new _hx_array(array("%Y-%m-%d %H:%M:%S")), null);
		}
	}
	public function valueString($s) {
		if(trim($s) === $s) {
			$this->value .= $this->enc($s);
		} else {
			$this->value .= $this->quote($s);
		}
	}
	public function enc($s) {
		{
			$_g1 = 0; $_g = thx_ini_IniEncoder::$decoded->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$s = str_replace(thx_ini_IniEncoder::$decoded[$i], thx_ini_IniEncoder::$encoded[$i], $s);
				unset($i);
			}
		}
		return $s;
	}
	public function quote($s) {
		return "\"" . str_replace("\"", "\\\"", $this->enc($s)) . "\"";
	}
	public function valueInt($i) {
		$this->value .= $i;
	}
	public function valueFloat($f) {
		$this->value .= $f;
	}
	public function valueNull() {
		$this->value .= "";
	}
	public function comment($s) {
		if(!$this->ignorecomments) {
			$this->value .= "#" . $s;
		}
	}
	public function valueBool($b) {
		$this->value .= (($b) ? "ON" : "OFF");
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
	static $decoded;
	static $encoded;
	function __toString() { return 'thx.ini.IniEncoder'; }
}
thx_ini_IniEncoder::$decoded = new _hx_array(array("\\", chr(0), chr(7), chr(8), "\x09", "\x0D", "\x0A", ";", "#", "=", ":"));
thx_ini_IniEncoder::$encoded = new _hx_array(array("\\\\", "\\0", "\\a", "\\b", "\\t", "\\r", "\\n", "\\;", "\\#", "\\=", "\\:"));
function thx_ini_IniEncoder_0(&$»this) {
	{
		$arr = Iterators::harray($»this->cache->keys());
		$arr->sort((isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare")));
		return $arr;
	}
}
