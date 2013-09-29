<?php

class thx_ini_IniEncoder implements thx_data_IDataHandler{
	public function __construct($newline, $ignorecomments) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::new");
		$»spos = $GLOBALS['%s']->length;
		if($ignorecomments === null) {
			$ignorecomments = true;
		}
		if($newline === null) {
			$newline = "\x0A";
		}
		$this->newline = $newline;
		$this->ignorecomments = $ignorecomments;
		$GLOBALS['%s']->pop();
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
		$GLOBALS['%s']->push("thx.ini.IniEncoder::start");
		$»spos = $GLOBALS['%s']->length;
		$this->inarray = 0;
		$this->stack = new _hx_array(array());
		$this->cache = new Hash();
		$GLOBALS['%s']->pop();
	}
	public function end() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::end");
		$»spos = $GLOBALS['%s']->length;
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
		$GLOBALS['%s']->pop();
	}
	public function startObject() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::startObject");
		$»spos = $GLOBALS['%s']->length;
		if($this->inarray > 0) {
			throw new HException(new thx_error_Error("arrays must contain only primitive values", null, null, _hx_anonymous(array("fileName" => "IniEncoder.hx", "lineNumber" => 58, "className" => "thx.ini.IniEncoder", "methodName" => "startObject"))));
		}
		$GLOBALS['%s']->pop();
	}
	public function startField($name) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::startField");
		$»spos = $GLOBALS['%s']->length;
		$this->stack->push($this->enc($name));
		$this->value = "";
		$GLOBALS['%s']->pop();
	}
	public function endField() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::endField");
		$»spos = $GLOBALS['%s']->length;
		if(null === $this->value) {
			$GLOBALS['%s']->pop();
			return;
		}
		$key = $this->stack->pop();
		$name = $this->stack->join(".");
		$section = $this->getSection($name);
		$section->push($key . "=" . $this->value);
		$this->value = null;
		$GLOBALS['%s']->pop();
	}
	public function getSection($name) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::getSection");
		$»spos = $GLOBALS['%s']->length;
		$section = $this->cache->get($name);
		if(null === $section) {
			$section = new _hx_array(array());
			$this->cache->set($name, $section);
		}
		{
			$GLOBALS['%s']->pop();
			return $section;
		}
		$GLOBALS['%s']->pop();
	}
	public function endObject() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::endObject");
		$»spos = $GLOBALS['%s']->length;
		$this->stack->pop();
		$GLOBALS['%s']->pop();
	}
	public function startArray() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::startArray");
		$»spos = $GLOBALS['%s']->length;
		if($this->inarray > 0) {
			throw new HException(new thx_error_Error("nested arrays are not supported in the .ini format", null, null, _hx_anonymous(array("fileName" => "IniEncoder.hx", "lineNumber" => 97, "className" => "thx.ini.IniEncoder", "methodName" => "startArray"))));
		}
		$this->inarray = 1;
		$this->value = "";
		$GLOBALS['%s']->pop();
	}
	public function startItem() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::startItem");
		$»spos = $GLOBALS['%s']->length;
		if($this->inarray === 1) {
			$this->inarray = 2;
		} else {
			$this->value .= ", ";
		}
		$GLOBALS['%s']->pop();
	}
	public function endItem() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::endItem");
		$»spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function endArray() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::endArray");
		$»spos = $GLOBALS['%s']->length;
		$this->inarray = 0;
		$GLOBALS['%s']->pop();
	}
	public function date($d) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::date");
		$»spos = $GLOBALS['%s']->length;
		if($d->getSeconds() === 0 && $d->getMinutes() === 0 && $d->getHours() === 0) {
			$this->value .= Dates::format($d, "C", new _hx_array(array("%Y-%m-%d")), null);
		} else {
			$this->value .= Dates::format($d, "C", new _hx_array(array("%Y-%m-%d %H:%M:%S")), null);
		}
		$GLOBALS['%s']->pop();
	}
	public function string($s) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::string");
		$»spos = $GLOBALS['%s']->length;
		if(trim($s) === $s) {
			$this->value .= $this->enc($s);
		} else {
			$this->value .= $this->quote($s);
		}
		$GLOBALS['%s']->pop();
	}
	public function enc($s) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::enc");
		$»spos = $GLOBALS['%s']->length;
		{
			$_g1 = 0; $_g = thx_ini_IniEncoder::$decoded->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$s = str_replace(thx_ini_IniEncoder::$decoded[$i], thx_ini_IniEncoder::$encoded[$i], $s);
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function quote($s) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::quote");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = "\"" . str_replace("\"", "\\\"", $this->enc($s)) . "\"";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function int($i) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::int");
		$»spos = $GLOBALS['%s']->length;
		$this->value .= $i;
		$GLOBALS['%s']->pop();
	}
	public function float($f) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::float");
		$»spos = $GLOBALS['%s']->length;
		$this->value .= $f;
		$GLOBALS['%s']->pop();
	}
	public function null() {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::null");
		$»spos = $GLOBALS['%s']->length;
		$this->value .= "";
		$GLOBALS['%s']->pop();
	}
	public function comment($s) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::comment");
		$»spos = $GLOBALS['%s']->length;
		if(!$this->ignorecomments) {
			$this->value .= "#" . $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function bool($b) {
		$GLOBALS['%s']->push("thx.ini.IniEncoder::bool");
		$»spos = $GLOBALS['%s']->length;
		$this->value .= (($b) ? "ON" : "OFF");
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
	static $decoded;
	static $encoded;
	function __toString() { return 'thx.ini.IniEncoder'; }
}
thx_ini_IniEncoder::$decoded = new _hx_array(array("\\", chr(0), chr(7), chr(8), "\x09", "\x0D", "\x0A", ";", "#", "=", ":"));
thx_ini_IniEncoder::$encoded = new _hx_array(array("\\\\", "\\0", "\\a", "\\b", "\\t", "\\r", "\\n", "\\;", "\\#", "\\=", "\\:"));
function thx_ini_IniEncoder_0(&$»this) {
	$»spos = $GLOBALS['%s']->length;
	{
		$arr = Iterators::harray($»this->cache->keys());
		$arr->sort((isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare")));
		return $arr;
	}
}
