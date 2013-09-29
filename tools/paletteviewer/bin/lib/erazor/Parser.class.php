<?php

class erazor_Parser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("erazor.Parser::new");
		$»spos = $GLOBALS['%s']->length;
		$this->condMatch = new EReg("^@(?:if|for|while)\\b", "");
		$this->inConditionalMatch = new EReg("^(?:\\}[\\s\x0D\x0A]*else if\\b|\\}[\\s\x0D\x0A]*else[\\s\x0D\x0A]*{)", "");
		$this->variableChar = new EReg("^[_\\w\\.]\$", "");
		$GLOBALS['%s']->pop();
	}}
	public $condMatch;
	public $inConditionalMatch;
	public $variableChar;
	public $context;
	public $conditionalStack;
	public function parseScriptPart($template, $startBrace, $endBrace) {
		$GLOBALS['%s']->push("erazor.Parser::parseScriptPart");
		$»spos = $GLOBALS['%s']->length;
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
						$»tmp = _hx_substr($template, 0, $i + 1);
						$GLOBALS['%s']->pop();
						return $»tmp;
					}
					if($stack < 0) {
						throw new HException("Unbalanced braces for block: " . _hx_substr($template, 0, 100) . " ...");
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
		throw new HException("Failed to find a closing delimiter for the script block: " . _hx_substr($template, 0, 100));
		$GLOBALS['%s']->pop();
	}
	public function parseContext($template) {
		$GLOBALS['%s']->push("erazor.Parser::parseContext");
		$»spos = $GLOBALS['%s']->length;
		if($this->peek($template, null) === erazor_Parser::$at && $this->peek($template, 1) !== erazor_Parser::$at) {
			$»tmp = erazor__Parser_ParseContext::$code;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		if($this->conditionalStack > 0 && $this->peek($template, null) === "}") {
			$»tmp = erazor__Parser_ParseContext::$code;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		{
			$»tmp = erazor__Parser_ParseContext::$literal;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function accept($template, $acceptor, $throwAtEnd) {
		$GLOBALS['%s']->push("erazor.Parser::accept");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->parseString($template, array(new _hx_lambda(array(&$acceptor, &$template, &$throwAtEnd), "erazor_Parser_0"), 'execute'), $throwAtEnd);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function isIdentifier($char, $first) {
		$GLOBALS['%s']->push("erazor.Parser::isIdentifier");
		$»spos = $GLOBALS['%s']->length;
		if($first === null) {
			$first = true;
		}
		{
			$»tmp = erazor_Parser_1($this, $char, $first);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function acceptIdentifier($template) {
		$GLOBALS['%s']->push("erazor.Parser::acceptIdentifier");
		$»spos = $GLOBALS['%s']->length;
		$first = true;
		$self = $this;
		{
			$»tmp = $this->accept($template, array(new _hx_lambda(array(&$first, &$self, &$template), "erazor_Parser_2"), 'execute'), false);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function acceptBracket($template, $bracket) {
		$GLOBALS['%s']->push("erazor.Parser::acceptBracket");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->parseScriptPart($template, $bracket, (($bracket === "(") ? ")" : "]"));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseBlock($template) {
		$GLOBALS['%s']->push("erazor.Parser::parseBlock");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (($this->context == erazor__Parser_ParseContext::$code) ? $this->parseCodeBlock($template) : $this->parseLiteral($template));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseConditional($template) {
		$GLOBALS['%s']->push("erazor.Parser::parseConditional");
		$»spos = $GLOBALS['%s']->length;
		$str = $this->parseScriptPart($template, "", "{");
		{
			$»tmp = _hx_anonymous(array("block" => erazor_TBlock::codeBlock(_hx_substr($str, 1, null)), "length" => strlen($str)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function peek($template, $offset) {
		$GLOBALS['%s']->push("erazor.Parser::peek");
		$»spos = $GLOBALS['%s']->length;
		if($offset === null) {
			$offset = 0;
		}
		{
			$»tmp = ((strlen($template) > $offset) ? _hx_char_at($template, $offset) : null);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseVariable($template) {
		$GLOBALS['%s']->push("erazor.Parser::parseVariable");
		$»spos = $GLOBALS['%s']->length;
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
		{
			$»tmp = _hx_anonymous(array("block" => erazor_TBlock::printBlock($output), "length" => strlen($output) + 1));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseVariableChar($char) {
		$GLOBALS['%s']->push("erazor.Parser::parseVariableChar");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = (($this->variableChar->match($char)) ? erazor__Parser_ParseResult::$keepGoing : erazor__Parser_ParseResult::$doneSkipCurrent);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseCodeBlock($template) {
		$GLOBALS['%s']->push("erazor.Parser::parseCodeBlock");
		$»spos = $GLOBALS['%s']->length;
		if($this->conditionalStack > 0 && $this->peek($template, null) === "}") {
			if($this->inConditionalMatch->match($template)) {
				$str = $this->parseScriptPart($template, "", "{");
				{
					$»tmp = _hx_anonymous(array("block" => erazor_TBlock::codeBlock($str), "length" => strlen($str)));
					$GLOBALS['%s']->pop();
					return $»tmp;
				}
			}
			--$this->conditionalStack;
			{
				$»tmp = _hx_anonymous(array("block" => erazor_TBlock::codeBlock("}"), "length" => 1));
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}
		if($this->condMatch->match($template)) {
			++$this->conditionalStack;
			{
				$»tmp = $this->parseConditional($template);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}
		if($this->peek($template, null) === "@" && $this->isIdentifier($this->peek($template, 1), null)) {
			$»tmp = $this->parseVariable($template);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$startBrace = $this->peek($template, 1);
		$endBrace = (($startBrace === "{") ? "}" : ")");
		$str = $this->parseScriptPart(_hx_substr($template, 1, null), $startBrace, $endBrace);
		$noBraces = trim(_hx_substr($str, 1, strlen($str) - 2));
		if($startBrace === "{") {
			$»tmp = _hx_anonymous(array("block" => erazor_TBlock::codeBlock($noBraces), "length" => strlen($str) + 1));
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$»tmp = _hx_anonymous(array("block" => erazor_TBlock::printBlock($noBraces), "length" => strlen($str) + 1));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseString($str, $modifier, $throwAtEnd) {
		$GLOBALS['%s']->push("erazor.Parser::parseString");
		$»spos = $GLOBALS['%s']->length;
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
					$»tmp = _hx_substr($str, 0, $i + 1);
					$GLOBALS['%s']->pop();
					return $»tmp;
				}break;
				case 2:
				{
					$»tmp = _hx_substr($str, 0, $i);
					$GLOBALS['%s']->pop();
					return $»tmp;
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
			throw new HException("Failed to find a closing delimiter: " . _hx_substr($str, 0, 100));
		}
		{
			$GLOBALS['%s']->pop();
			return $str;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseLiteral($template) {
		$GLOBALS['%s']->push("erazor.Parser::parseLiteral");
		$»spos = $GLOBALS['%s']->length;
		$nextAt = _hx_index_of($template, erazor_Parser::$at, null);
		$nextBracket = (($this->conditionalStack > 0) ? _hx_index_of($template, "}", null) : -1);
		while($nextAt >= 0 || $nextBracket >= 0) {
			if($nextBracket >= 0 && ($nextAt === -1 || $nextBracket < $nextAt)) {
				$»tmp = _hx_anonymous(array("block" => erazor_TBlock::literal($this->escapeLiteral(_hx_substr($template, 0, $nextBracket))), "length" => $nextBracket));
				$GLOBALS['%s']->pop();
				return $»tmp;
				unset($»tmp);
			}
			$len = strlen($template);
			if($len > $nextAt + 1 && _hx_char_at($template, $nextAt + 1) !== erazor_Parser::$at) {
				$»tmp = _hx_anonymous(array("block" => erazor_TBlock::literal($this->escapeLiteral(_hx_substr($template, 0, $nextAt))), "length" => $nextAt));
				$GLOBALS['%s']->pop();
				return $»tmp;
				unset($»tmp);
			}
			if($nextAt + 2 >= strlen($template)) {
				$nextAt = -1;
			} else {
				$nextAt = _hx_index_of($template, erazor_Parser::$at, $nextAt + 2);
			}
			unset($len);
		}
		{
			$»tmp = _hx_anonymous(array("block" => erazor_TBlock::literal($this->escapeLiteral($template)), "length" => strlen($template)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function escapeLiteral($input) {
		$GLOBALS['%s']->push("erazor.Parser::escapeLiteral");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = str_replace(erazor_Parser::$at . erazor_Parser::$at, erazor_Parser::$at, $input);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parse($template) {
		$GLOBALS['%s']->push("erazor.Parser::parse");
		$»spos = $GLOBALS['%s']->length;
		$output = new _hx_array(array());
		$this->conditionalStack = 0;
		while($template !== "") {
			$this->context = $this->parseContext($template);
			$block = $this->parseBlock($template);
			if($block->block !== null) {
				$output->push($block->block);
			}
			$template = _hx_substr($template, _hx_len($block), null);
			unset($block);
		}
		{
			$GLOBALS['%s']->pop();
			return $output;
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
	static $at = "@";
	function __toString() { return 'erazor.Parser'; }
}
function erazor_Parser_0(&$acceptor, &$template, &$throwAtEnd, $chr) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("erazor.Parser::accept@97");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = ((call_user_func_array($acceptor, array($chr))) ? erazor__Parser_ParseResult::$keepGoing : erazor__Parser_ParseResult::$doneSkipCurrent);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function erazor_Parser_1(&$»this, &$char, &$first) {
	$»spos = $GLOBALS['%s']->length;
	if($first) {
		return $char >= "a" && $char <= "z" || $char >= "A" && $char <= "Z" || $char === "_";
	} else {
		return $char >= "a" && $char <= "z" || $char >= "A" && $char <= "Z" || $char >= "0" && $char <= "9" || $char === "_";
	}
}
function erazor_Parser_2(&$first, &$self, &$template, $chr) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("erazor.Parser::acceptIdentifier@114");
		$»spos2 = $GLOBALS['%s']->length;
		$status = $self->isIdentifier($chr, $first);
		$first = false;
		{
			$GLOBALS['%s']->pop();
			return $status;
		}
		$GLOBALS['%s']->pop();
	}
}
