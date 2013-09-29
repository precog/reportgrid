<?php

class thx_ini_IniDecoder {
	public function __construct($handler, $explodesections, $emptytonull) {
		if(!php_Boot::$skip_constructor) {
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
	}}
	public $emptytonull;
	public $explodesections;
	public $handler;
	public $other;
	public $value;
	public $insection;
	public function decode($s) {
		$this->handler->start();
		$this->handler->objectStart();
		$this->insection = false;
		$this->decodeLines($s);
		if($this->insection) {
			$this->handler->objectEnd();
			$this->handler->objectFieldEnd();
		}
		$this->handler->objectEnd();
		$this->handler->end();
		if($this->explodesections) {
			_hx_deref(new thx_data_ValueEncoder($this->other))->encode(thx_ini_IniDecoder::explodeSections($this->value->value));
		}
	}
	public function decodeLines($s) {
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
	}
	public function decodeLine($line) {
		if(trim($line) === "") {
			return;
		}
		$line = ltrim($line);
		$c = _hx_substr($line, 0, 1);
		switch($c) {
		case "[":{
			if($this->insection) {
				$this->handler->objectEnd();
				$this->handler->objectFieldEnd();
			} else {
				$this->insection = true;
			}
			$this->handler->objectFieldStart(_hx_substr($line, 1, _hx_index_of($line, "]", null) - 1));
			$this->handler->objectStart();
			return;
		}break;
		case "#":case ";":{
			$this->handler->comment(_hx_substr($line, 1, null));
			return;
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
		$this->handler->objectFieldStart($key);
		$this->decodeValue($parts[0]);
		if($parts->length > 1) {
			$this->handler->comment($parts[1]);
		}
		$this->handler->objectFieldEnd();
	}
	public function dec($s) {
		{
			$_g1 = 0; $_g = thx_ini_IniEncoder::$encoded->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$s = str_replace(thx_ini_IniEncoder::$encoded[$i], thx_ini_IniEncoder::$decoded[$i], $s);
				unset($i);
			}
		}
		return $s;
	}
	public function decodeValue($s) {
		$s = trim($s);
		$c = _hx_substr($s, 0, 1);
		if($c === "\"" || $c === "'" && _hx_substr($s, -1, null) === $c) {
			$this->handler->valueString($this->dec(_hx_substr($s, 1, strlen($s) - 2)));
			return;
		}
		if(Ints::canParse($s)) {
			$this->handler->valueInt(Ints::parse($s));
		} else {
			if(Floats::canParse($s)) {
				$this->handler->valueFloat(Floats::parse($s));
			} else {
				if(Dates::canParse($s)) {
					$this->handler->valueDate(Dates::parse($s));
				} else {
					if($this->emptytonull && "" === $s) {
						$this->handler->valueNull();
					} else {
						switch(strtolower($s)) {
						case "yes":case "true":case "on":{
							$this->handler->valueBool(true);
						}break;
						case "no":case "false":case "off":{
							$this->handler->valueBool(false);
						}break;
						default:{
							$parts = _hx_explode(", ", $s);
							if($parts->length > 1) {
								$this->handler->arrayStart();
								{
									$_g = 0;
									while($_g < $parts->length) {
										$part = $parts[$_g];
										++$_g;
										$this->handler->arrayItemStart();
										$this->decodeValue($part);
										$this->handler->arrayItemEnd();
										unset($part);
									}
								}
								$this->handler->arrayEnd();
							} else {
								$s = $this->dec($s);
								$this->handler->valueString($s);
							}
						}break;
						}
					}
				}
			}
		}
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
		return $o;
	}
	function __toString() { return 'thx.ini.IniDecoder'; }
}
thx_ini_IniDecoder::$linesplitter = new EReg("[^\\\\](#|;)", "");
