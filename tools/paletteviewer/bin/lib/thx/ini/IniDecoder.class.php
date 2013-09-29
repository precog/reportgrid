<?php

class thx_ini_IniDecoder {
	public function __construct($handler, $explodesections, $emptytonull) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::new");
		$»spos = $GLOBALS['%s']->length;
		if($emptytonull === null) {
			$emptytonull = true;
		}
		if($explodesections === null) {
			$explodesections = true;
		}
		$this->explodesections = $explodesections;
		if($explodesections) {
			$this->handler = $this->value = new thx_data_ValueHandler();
			$this->other = $handler;
		} else {
			$this->handler = $handler;
		}
		$this->emptytonull = $emptytonull;
		$GLOBALS['%s']->pop();
	}}
	public $emptytonull;
	public $explodesections;
	public $handler;
	public $other;
	public $value;
	public $insection;
	public function decode($s) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::decode");
		$»spos = $GLOBALS['%s']->length;
		$this->handler->start();
		$this->handler->startObject();
		$this->insection = false;
		$this->decodeLines($s);
		if($this->insection) {
			$this->handler->endObject();
			$this->handler->endField();
		}
		$this->handler->endObject();
		$this->handler->end();
		if($this->explodesections) {
			_hx_deref(new thx_data_ValueEncoder($this->other))->encode(thx_ini_IniDecoder::explodeSections($this->value->value));
		}
		$GLOBALS['%s']->pop();
	}
	public function decodeLines($s) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::decodeLines");
		$»spos = $GLOBALS['%s']->length;
		$lines = _hx_deref(new EReg("(\x0A\x0D|\x0A|\x0D)", "g"))->split($s);
		{
			$_g = 0;
			while($_g < $lines->length) {
				$line = $lines[$_g];
				++$_g;
				$this->decodeLine($line);
				unset($line);
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function decodeLine($line) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::decodeLine");
		$»spos = $GLOBALS['%s']->length;
		if(trim($line) === "") {
			$GLOBALS['%s']->pop();
			return;
		}
		$line = ltrim($line);
		$c = _hx_substr($line, 0, 1);
		switch($c) {
		case "[":{
			if($this->insection) {
				$this->handler->endObject();
				$this->handler->endField();
			} else {
				$this->insection = true;
			}
			$this->handler->startField(_hx_substr($line, 1, _hx_index_of($line, "]", null) - 1));
			$this->handler->startObject();
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}break;
		case "#":case ";":{
			$this->handler->comment(_hx_substr($line, 1, null));
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}break;
		}
		$pos = 0;
		do {
			$pos = _hx_index_of($line, "=", $pos);
		} while($pos > 0 && _hx_substr($line, $pos - 1, 1) === "\\");
		if($pos <= 0) {
			throw new HException(new thx_error_Error("invalid key pair (missing '=' symbol?): {0}", null, $line, _hx_anonymous(array("fileName" => "IniDecoder.hx", "lineNumber" => 118, "className" => "thx.ini.IniDecoder", "methodName" => "decodeLine"))));
		}
		$key = trim($this->dec(_hx_substr($line, 0, $pos)));
		$value = _hx_substr($line, $pos + 1, null);
		$parts = thx_ini_IniDecoder::$linesplitter->split($value);
		$this->handler->startField($key);
		$this->decodeValue($parts[0]);
		if($parts->length > 1) {
			$this->handler->comment($parts[1]);
		}
		$this->handler->endField();
		$GLOBALS['%s']->pop();
	}
	public function dec($s) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::dec");
		$»spos = $GLOBALS['%s']->length;
		{
			$_g1 = 0; $_g = thx_ini_IniEncoder::$encoded->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$s = str_replace(thx_ini_IniEncoder::$encoded[$i], thx_ini_IniEncoder::$decoded[$i], $s);
				unset($i);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function decodeValue($s) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::decodeValue");
		$»spos = $GLOBALS['%s']->length;
		$s = trim($s);
		$c = _hx_substr($s, 0, 1);
		if($c === "\"" || $c === "'" && _hx_substr($s, -1, null) === $c) {
			$this->handler->string($this->dec(_hx_substr($s, 1, strlen($s) - 2)));
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		if(Ints::canParse($s)) {
			$this->handler->int(Ints::parse($s));
		} else {
			if(Floats::canParse($s)) {
				$this->handler->float(Floats::parse($s));
			} else {
				if(Dates::canParse($s)) {
					$this->handler->date(Dates::parse($s));
				} else {
					if($this->emptytonull && "" === $s) {
						$this->handler->null();
					} else {
						switch(strtolower($s)) {
						case "yes":case "true":case "on":{
							$this->handler->bool(true);
						}break;
						case "no":case "false":case "off":{
							$this->handler->bool(false);
						}break;
						default:{
							$parts = _hx_explode(", ", $s);
							if($parts->length > 1) {
								$this->handler->startArray();
								{
									$_g = 0;
									while($_g < $parts->length) {
										$part = $parts[$_g];
										++$_g;
										$this->handler->startItem();
										$this->decodeValue($part);
										$this->handler->endItem();
										unset($part);
									}
								}
								$this->handler->endArray();
							} else {
								$s = $this->dec($s);
								$this->handler->string($s);
							}
						}break;
						}
					}
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
	static $linesplitter;
	static function explodeSections($o) {
		$GLOBALS['%s']->push("thx.ini.IniDecoder::explodeSections");
		$»spos = $GLOBALS['%s']->length;
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$parts = _hx_explode(".", $field);
				if($parts->length === 1) {
					continue;
				}
				$ref = $o;
				{
					$_g3 = 0; $_g2 = $parts->length - 1;
					while($_g3 < $_g2) {
						$i = $_g3++;
						$name = $parts[$i];
						if(!_hx_has_field($ref, $name)) {
							$ref->{$name} = _hx_anonymous(array());
						}
						$ref = Reflect::field($ref, $name);
						unset($name,$i);
					}
					unset($_g3,$_g2);
				}
				$last = $parts[$parts->length - 1];
				$v = Reflect::field($o, $field);
				Reflect::deleteField($o, $field);
				$ref->{$last} = $v;
				unset($v,$ref,$parts,$last,$field);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $o;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'thx.ini.IniDecoder'; }
}
thx_ini_IniDecoder::$linesplitter = new EReg("[^\\\\](#|;)", "");
