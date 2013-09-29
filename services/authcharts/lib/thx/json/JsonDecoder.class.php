<?php

class thx_json_JsonDecoder {
	public function __construct($handler, $tabsize) {
		if(!php_Boot::$skip_constructor) {
		if($tabsize === null) {
			$tabsize = 4;
		}
		$this->handler = $handler;
		$this->tabsize = $tabsize;
	}}
	public $col;
	public $line;
	public $tabsize;
	public $src;
	public $char;
	public $pos;
	public $handler;
	public function decode($s) {
		$this->col = 0;
		$this->line = 0;
		$this->src = $s;
		$this->char = null;
		$this->pos = 0;
		$this->ignoreWhiteSpace();
		$p = null;
		$this->handler->start();
		try {
			$p = $this->parse();
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
				$this->error("unexpected end of stream");
			} else throw $»e;;
		}
		$this->ignoreWhiteSpace();
		if($this->pos < strlen($this->src)) {
			$this->error("the stream contains unrecognized characters at its end");
		}
		$this->handler->end();
	}
	public function ignoreWhiteSpace() {
		while($this->pos < strlen($this->src)) {
			$c = $this->readChar();
			switch($c) {
			case " ":{
				$this->col++;
			}break;
			case "\x0A":{
				$this->col = 0;
				$this->line++;
			}break;
			case "\x0D":{
			}break;
			case "\x09":{
				$this->col += $this->tabsize;
			}break;
			default:{
				$this->char = $c;
				return;
			}break;
			}
			unset($c);
		}
	}
	public function parse() {
		$c = $this->readChar();
		switch($c) {
		case "{":{
			$this->col++;
			$this->ignoreWhiteSpace();
			$this->parseObject();
			return;
		}break;
		case "[":{
			$this->col++;
			$this->ignoreWhiteSpace();
			$this->parseArray();
			return;
		}break;
		case "\"":{
			$this->char = $c;
			$this->parseString();
			return;
		}break;
		default:{
			$this->char = $c;
			$this->parseValue();
			return;
		}break;
		}
	}
	public function readChar() {
		if(null === $this->char) {
			if($this->pos === strlen($this->src)) {
				throw new HException(thx_json__JsonDecoder_StreamError::$Eof);
			}
			return _hx_char_at($this->src, $this->pos++);
		} else {
			$c = $this->char;
			$this->char = null;
			return $c;
		}
	}
	public function expect($word) {
		$test = thx_json_JsonDecoder_0($this, $word);
		if($test === $word) {
			if(null === $this->char) {
				$this->pos += strlen($word);
			} else {
				$this->pos += strlen($word) - 1;
				$this->char = null;
			}
			return true;
		} else {
			return false;
		}
	}
	public function parseObject() {
		$first = true;
		$this->handler->startObject();
		while(true) {
			$this->ignoreWhiteSpace();
			if($this->expect("}")) {
				break;
			} else {
				if($first) {
					$first = false;
				} else {
					if($this->expect(",")) {
						$this->ignoreWhiteSpace();
					} else {
						$this->error("expected ','");
					}
				}
			}
			$k = $this->_parseString();
			$this->ignoreWhiteSpace();
			if(!$this->expect(":")) {
				$this->error("expected ':'");
			}
			$this->ignoreWhiteSpace();
			$this->handler->startField($k);
			$this->parse();
			$this->handler->endField();
			unset($k);
		}
		$this->handler->endObject();
	}
	public function parseArray() {
		$this->ignoreWhiteSpace();
		$first = true;
		$this->handler->startArray();
		while(true) {
			$this->ignoreWhiteSpace();
			if($this->expect("]")) {
				break;
			} else {
				if($first) {
					$first = false;
				} else {
					if($this->expect(",")) {
						$this->ignoreWhiteSpace();
					} else {
						$this->error("expected ','");
					}
				}
			}
			$this->handler->startItem();
			$this->parse();
			$this->handler->endItem();
		}
		$this->handler->endArray();
	}
	public function parseValue() {
		if($this->expect("true")) {
			$this->handler->bool(true);
		} else {
			if($this->expect("false")) {
				$this->handler->bool(false);
			} else {
				if($this->expect("null")) {
					$this->handler->null();
				} else {
					$this->parseFloat();
				}
			}
		}
	}
	public function parseString() {
		$this->handler->string($this->_parseString());
	}
	public function _parseString() {
		if(!$this->expect("\"")) {
			$this->error("expected double quote");
		}
		$buf = "";
		$esc = false;
		while(true) {
			$c = $this->readChar();
			$this->col++;
			if($esc) {
				switch($c) {
				case "\"":{
					$buf .= "\"";
				}break;
				case "\\":{
					$buf .= "\\";
				}break;
				case "/":{
					$buf .= "/";
				}break;
				case "b":{
					$buf .= chr(8);
				}break;
				case "f":{
					$buf .= chr(12);
				}break;
				case "n":{
					$buf .= "\x0A";
				}break;
				case "r":{
					$buf .= "\x0D";
				}break;
				case "t":{
					$buf .= "\x09";
				}break;
				case "u":{
					$utf = new php_Utf8();
					$utf->addChar($this->parseHexa());
					$buf .= $utf->toString();
				}break;
				default:{
					$this->error("unexpected char " . $c);
				}break;
				}
				$esc = false;
			} else {
				switch($c) {
				case "\\":{
					$esc = true;
				}break;
				case "\"":{
					break 2;
				}break;
				default:{
					$buf .= $c;
				}break;
				}
			}
			unset($c);
		}
		return $buf;
	}
	public function parseHexa() {
		$v = new _hx_array(array());
		{
			$_g = 0;
			while($_g < 4) {
				$i = $_g++;
				$c = $this->readChar();
				$i1 = _hx_char_code_at(strtolower($c), 0);
				if(!($i1 >= 48 && $i1 <= 57 || $i1 >= 97 && $i1 <= 102)) {
					$this->error("invalid hexadecimal value " . $c);
				}
				$v->push($c);
				unset($i1,$i,$c);
			}
		}
		$this->handler->int(Std::parseInt("0x" . $v->join("")));
		return Std::parseInt("0x" . $v->join(""));
	}
	public function parseFloat() {
		$v = "";
		if($this->expect("-")) {
			$v = "-";
		}
		if($this->expect("0")) {
			$v .= "0";
		} else {
			$c = $this->readChar();
			$i = _hx_char_code_at($c, 0);
			if($i < 49 || $i > 57) {
				$this->error("expected digit between 1 and 9");
			}
			$v .= $c;
			$this->col++;
		}
		try {
			$v .= $this->parseDigits(null);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
				$this->handler->int(Std::parseInt($v));
				return;
			} else throw $»e;;
		}
		try {
			if($this->expect(".")) {
				$v .= "." . $this->parseDigits(1);
			} else {
				$this->handler->int(Std::parseInt($v));
				return;
			}
			if($this->expect("e") || $this->expect("E")) {
				$v .= "e";
				if($this->expect("+")) {
				} else {
					if($this->expect("-")) {
						$v .= "-";
					}
				}
				$v .= $this->parseDigits(1);
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e2 = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
				$this->handler->float(Std::parseFloat($v));
				return;
			} else throw $»e;;
		}
		$this->handler->float(Std::parseFloat($v));
	}
	public function parseDigits($atleast) {
		if($atleast === null) {
			$atleast = 0;
		}
		$buf = "";
		while(true) {
			$c = null;
			try {
				$c = $this->readChar();
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(($e = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
					if(strlen($buf) < $atleast) {
						$this->error("expected digit");
					}
					return $buf;
				} else throw $»e;;
			}
			$i = _hx_char_code_at($c, 0);
			if($i < 48 || $i > 57) {
				if(strlen($buf) < $atleast) {
					$this->error("expected digit");
				}
				$this->col += strlen($buf);
				$this->char = $c;
				return $buf;
			} else {
				$buf .= $c;
			}
			unset($i,$e,$c);
		}
		return null;
	}
	public function error($msg) {
		$context = thx_json_JsonDecoder_1($this, $msg);
		throw new HException(new thx_error_Error("error at L {0} C {1}: {2}{3}", new _hx_array(array($this->line, $this->col, $msg, $context)), null, _hx_anonymous(array("fileName" => "JsonDecoder.hx", "lineNumber" => 358, "className" => "thx.json.JsonDecoder", "methodName" => "error"))));
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
	function __toString() { return 'thx.json.JsonDecoder'; }
}
function thx_json_JsonDecoder_0(&$»this, &$word) {
	if(null === $»this->char) {
		return _hx_substr($»this->src, $»this->pos, strlen($word));
	} else {
		return $»this->char . _hx_substr($»this->src, $»this->pos, strlen($word) - 1);
	}
}
function thx_json_JsonDecoder_1(&$»this, &$msg) {
	if($»this->pos === strlen($»this->src)) {
		return "";
	} else {
		return "\x0Arest: " . (thx_json_JsonDecoder_2($»this, $msg)) . _hx_substr($»this->src, $»this->pos, null) . "...";
	}
}
function thx_json_JsonDecoder_2(&$»this, &$msg) {
	if(null !== $»this->char) {
		return $»this->char;
	} else {
		return "";
	}
}
