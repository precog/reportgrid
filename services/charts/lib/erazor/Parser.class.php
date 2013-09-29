<?php

class erazor_Parser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->condMatch = new EReg("^@(?:if|for|while)\\b", "");
		$this->inConditionalMatch = new EReg("^(?:\\}[\\s\x0D\x0A]*else if\\b|\\}[\\s\x0D\x0A]*else[\\s\x0D\x0A]*{)", "");
		$this->variableChar = new EReg("^[_\\w\\.]\$", "");
	}}
	public $condMatch;
	public $inConditionalMatch;
	public $variableChar;
	public $context;
	public $bracketStack;
	public $conditionalStack;
	public $pos;
	public function parseScriptPart($template, $startBrace, $endBrace) {
		$insideSingleQuote = false;
		$insideDoubleQuote = false;
		$stack = (($startBrace === "") ? 1 : 0);
		$i = -1;
		while(++$i < strlen($template)) {
			$char = _hx_char_at($template, $i);
			if(!$insideDoubleQuote && !$insideSingleQuote) {
				switch($char) {
				case $startBrace:{
					++$stack;
				}break;
				case $endBrace:{
					--$stack;
					if($stack === 0) {
						return _hx_substr($template, 0, $i + 1);
					}
					if($stack < 0) {
						throw new HException(new erazor_error_ParserError("Unbalanced braces for block: ", $this->pos, _hx_substr($template, 0, 100)));
					}
				}break;
				case "\"":{
					$insideDoubleQuote = true;
				}break;
				case "'":{
					$insideSingleQuote = true;
				}break;
				}
			} else {
				if($insideDoubleQuote && $char === "\"" && _hx_char_at($template, $i - 1) !== "\\") {
					$insideDoubleQuote = false;
				} else {
					if($insideSingleQuote && $char === "'" && _hx_char_at($template, $i - 1) !== "\\") {
						$insideSingleQuote = false;
					}
				}
			}
			unset($char);
		}
		throw new HException(new erazor_error_ParserError("Failed to find a closing delimiter for the script block: ", $this->pos, _hx_substr($template, 0, 100)));
	}
	public function parseContext($template) {
		if($this->peek($template, null) === erazor_Parser::$at && $this->peek($template, 1) !== erazor_Parser::$at) {
			return erazor__Parser_ParseContext::$code;
		}
		if($this->conditionalStack > 0 && $this->peek($template, null) === "}") {
			$»t = ($this->bracketStack[$this->bracketStack->length - 1]);
			switch($»t->index) {
			case 1:
			{
				return erazor__Parser_ParseContext::$code;
			}break;
			default:{
			}break;
			}
		}
		return erazor__Parser_ParseContext::$literal;
	}
	public function accept($template, $acceptor, $throwAtEnd) {
		return $this->parseString($template, array(new _hx_lambda(array(&$acceptor, &$template, &$throwAtEnd), "erazor_Parser_0"), 'execute'), $throwAtEnd);
	}
	public function isIdentifier($char, $first) {
		if($first === null) {
			$first = true;
		}
		return erazor_Parser_1($this, $char, $first);
	}
	public function acceptIdentifier($template) {
		$first = true;
		$self = $this;
		return $this->accept($template, array(new _hx_lambda(array(&$first, &$self, &$template), "erazor_Parser_2"), 'execute'), false);
	}
	public function acceptBracket($template, $bracket) {
		return $this->parseScriptPart($template, $bracket, (($bracket === "(") ? ")" : "]"));
	}
	public function parseBlock($template) {
		return (($this->context == erazor__Parser_ParseContext::$code) ? $this->parseCodeBlock($template) : $this->parseLiteral($template));
	}
	public function parseConditional($template) {
		$str = $this->parseScriptPart($template, "", "{");
		return _hx_anonymous(array("block" => erazor_TBlock::codeBlock(_hx_substr($str, 1, null)), "length" => strlen($str), "start" => $this->pos));
	}
	public function peek($template, $offset) {
		if($offset === null) {
			$offset = 0;
		}
		return ((strlen($template) > $offset) ? _hx_char_at($template, $offset) : null);
	}
	public function parseVariable($template) {
		$output = "";
		$char = null;
		$part = null;
		$template = _hx_substr($template, 1, null);
		do {
			$part = $this->acceptIdentifier($template);
			$template = _hx_substr($template, strlen($part), null);
			$output .= $part;
			$char = $this->peek($template, null);
			while($char === "(" || $char === "[") {
				$part = $this->acceptBracket($template, $char);
				$template = _hx_substr($template, strlen($part), null);
				$output .= $part;
				$char = $this->peek($template, null);
			}
			if($char === "." && $this->isIdentifier($this->peek($template, 1), null)) {
				$template = _hx_substr($template, 1, null);
				$output .= ".";
			} else {
				break;
			}
		} while($char !== null);
		return _hx_anonymous(array("block" => erazor_TBlock::printBlock($output), "length" => strlen($output) + 1, "start" => $this->pos));
	}
	public function parseVariableChar($char) {
		return (($this->variableChar->match($char)) ? erazor__Parser_ParseResult::$keepGoing : erazor__Parser_ParseResult::$doneSkipCurrent);
	}
	public function parseCodeBlock($template) {
		if($this->bracketStack->length > 0 && $this->peek($template, null) === "}") {
			if($this->inConditionalMatch->match($template)) {
				$str = $this->parseScriptPart($template, "", "{");
				return _hx_anonymous(array("block" => erazor_TBlock::codeBlock($str), "length" => strlen($str), "start" => $this->pos));
			}
			if(erazor_Parser_3($this, $template)) {
				throw new HException(new erazor_error_ParserError(erazor_Parser::$bracketMismatch, $this->pos, null));
			}
			return _hx_anonymous(array("block" => erazor_TBlock::codeBlock("}"), "length" => 1, "start" => $this->pos));
		}
		if($this->condMatch->match($template)) {
			$this->bracketStack->push(erazor__Parser_ParseContext::$code);
			++$this->conditionalStack;
			return $this->parseConditional($template);
		}
		if($this->peek($template, null) === "@" && $this->isIdentifier($this->peek($template, 1), null)) {
			return $this->parseVariable($template);
		}
		$startBrace = $this->peek($template, 1);
		$endBrace = (($startBrace === "{") ? "}" : ")");
		$str = $this->parseScriptPart(_hx_substr($template, 1, null), $startBrace, $endBrace);
		$noBraces = trim(_hx_substr($str, 1, strlen($str) - 2));
		if($startBrace === "{") {
			return _hx_anonymous(array("block" => erazor_TBlock::codeBlock($noBraces), "length" => strlen($str) + 1, "start" => $this->pos));
		} else {
			return _hx_anonymous(array("block" => erazor_TBlock::printBlock($noBraces), "length" => strlen($str) + 1, "start" => $this->pos));
		}
	}
	public function parseString($str, $modifier, $throwAtEnd) {
		$insideSingleQuote = false;
		$insideDoubleQuote = false;
		$i = -1;
		while(++$i < strlen($str)) {
			$char = _hx_char_at($str, $i);
			if(!$insideDoubleQuote && !$insideSingleQuote) {
				$»t = (call_user_func_array($modifier, array($char)));
				switch($»t->index) {
				case 1:
				{
					return _hx_substr($str, 0, $i + 1);
				}break;
				case 2:
				{
					return _hx_substr($str, 0, $i);
				}break;
				case 0:
				{
				}break;
				}
				if($char === "\"") {
					$insideDoubleQuote = true;
				} else {
					if($char === "'") {
						$insideSingleQuote = true;
					}
				}
			} else {
				if($insideDoubleQuote && $char === "\"" && _hx_char_at($str, $i - 1) !== "\\") {
					$insideDoubleQuote = false;
				} else {
					if($insideSingleQuote && $char === "'" && _hx_char_at($str, $i - 1) !== "\\") {
						$insideSingleQuote = false;
					}
				}
			}
			unset($char);
		}
		if($throwAtEnd) {
			throw new HException(new erazor_error_ParserError("Failed to find a closing delimiter: ", $this->pos, _hx_substr($str, 0, 100)));
		}
		return $str;
	}
	public function parseLiteral($template) {
		$len = strlen($template);
		$i = -1;
		while(++$i < $len) {
			$char = _hx_char_at($template, $i);
			switch($char) {
			case erazor_Parser::$at:{
				if($len > $i + 1 && _hx_char_at($template, $i + 1) !== erazor_Parser::$at) {
					return _hx_anonymous(array("block" => erazor_TBlock::literal($this->escapeLiteral(_hx_substr($template, 0, $i))), "length" => $i, "start" => $this->pos));
				}
				++$i;
			}break;
			case "}":{
				if($this->bracketStack->length > 0) {
					$»t = ($this->bracketStack[$this->bracketStack->length - 1]);
					switch($»t->index) {
					case 1:
					{
						return _hx_anonymous(array("block" => erazor_TBlock::literal($this->escapeLiteral(_hx_substr($template, 0, $i))), "length" => $i, "start" => $this->pos));
					}break;
					case 0:
					{
						$this->bracketStack->pop();
					}break;
					}
				} else {
					throw new HException(new erazor_error_ParserError(erazor_Parser::$bracketMismatch, $this->pos, null));
				}
			}break;
			case "{":{
				$this->bracketStack->push(erazor__Parser_ParseContext::$literal);
			}break;
			}
			unset($char);
		}
		return _hx_anonymous(array("block" => erazor_TBlock::literal($this->escapeLiteral($template)), "length" => $len, "start" => $this->pos));
	}
	public function escapeLiteral($input) {
		return str_replace(erazor_Parser::$at . erazor_Parser::$at, erazor_Parser::$at, $input);
	}
	public function parse($template) {
		$this->pos = 0;
		$output = new _hx_array(array());
		$this->bracketStack = new _hx_array(array());
		$this->conditionalStack = 0;
		while($template !== "") {
			$this->context = $this->parseContext($template);
			$block = $this->parseBlock($template);
			if($block->block !== null) {
				$output->push($block->block);
			}
			$template = _hx_substr($template, _hx_len($block), null);
			$this->pos += _hx_len($block);
			unset($block);
		}
		if($this->bracketStack->length !== 0) {
			throw new HException(new erazor_error_ParserError(erazor_Parser::$bracketMismatch, $this->pos, null));
		}
		return $output;
	}
	public function parseWithPosition($template) {
		$this->pos = 0;
		$output = new _hx_array(array());
		$this->bracketStack = new _hx_array(array());
		$this->conditionalStack = 0;
		while($template !== "") {
			$this->context = $this->parseContext($template);
			$block = $this->parseBlock($template);
			if($block->block !== null) {
				$output->push($block);
			}
			$template = _hx_substr($template, _hx_len($block), null);
			$this->pos += _hx_len($block);
			unset($block);
		}
		if($this->bracketStack->length !== 0) {
			throw new HException(new erazor_error_ParserError(erazor_Parser::$bracketMismatch, $this->pos, null));
		}
		return $output;
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
	static $at = "@";
	static $bracketMismatch = "Bracket mismatch! Inside template, non-paired brackets, '{' or '}', should be replaced by @{'{'} and @{'}'}.";
	function __toString() { return 'erazor.Parser'; }
}
function erazor_Parser_0(&$acceptor, &$template, &$throwAtEnd, $chr) {
	{
		return ((call_user_func_array($acceptor, array($chr))) ? erazor__Parser_ParseResult::$keepGoing : erazor__Parser_ParseResult::$doneSkipCurrent);
	}
}
function erazor_Parser_1(&$»this, &$char, &$first) {
	if($first) {
		return $char >= "a" && $char <= "z" || $char >= "A" && $char <= "Z" || $char === "_";
	} else {
		return $char >= "a" && $char <= "z" || $char >= "A" && $char <= "Z" || $char >= "0" && $char <= "9" || $char === "_";
	}
}
function erazor_Parser_2(&$first, &$self, &$template, $chr) {
	{
		$status = $self->isIdentifier($chr, $first);
		$first = false;
		return $status;
	}
}
function erazor_Parser_3(&$»this, &$template) {
	$»t = ($»this->bracketStack->pop());
	switch($»t->index) {
	case 1:
	{
		return --$»this->conditionalStack < 0;
	}break;
	default:{
		return true;
	}break;
	}
}
