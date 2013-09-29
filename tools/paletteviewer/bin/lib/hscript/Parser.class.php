<?php

class hscript_Parser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("hscript.Parser::new");
		$�spos = $GLOBALS['%s']->length;
		$this->line = 1;
		$this->opChars = "+*/-=!><&|^%~";
		$this->identChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_";
		$priorities = new _hx_array(array(new _hx_array(array("%")), new _hx_array(array("*", "/")), new _hx_array(array("+", "-")), new _hx_array(array("<<", ">>", ">>>")), new _hx_array(array("|", "&", "^")), new _hx_array(array("==", "!=", ">", "<", ">=", "<=")), new _hx_array(array("...")), new _hx_array(array("&&")), new _hx_array(array("||")), new _hx_array(array("=", "+=", "-=", "*=", "/=", "%=", "<<=", ">>=", ">>>=", "|=", "&=", "^="))));
		$this->opPriority = new Hash();
		$this->opRightAssoc = new Hash();
		{
			$_g1 = 0; $_g = $priorities->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$_g2 = 0; $_g3 = $priorities[$i];
				while($_g2 < $_g3->length) {
					$x = $_g3[$_g2];
					++$_g2;
					$this->opPriority->set($x, $i);
					if($i === 9) {
						$this->opRightAssoc->set($x, true);
					}
					unset($x);
				}
				unset($i,$_g3,$_g2);
			}
		}
		$this->unops = new Hash();
		{
			$_g = 0; $_g1 = new _hx_array(array("!", "++", "--", "-", "~"));
			while($_g < $_g1->length) {
				$x = $_g1[$_g];
				++$_g;
				$this->unops->set($x, $x === "++" || $x === "--");
				unset($x);
			}
		}
		$GLOBALS['%s']->pop();
	}}
	public $line;
	public $opChars;
	public $identChars;
	public $opPriority;
	public $opRightAssoc;
	public $unops;
	public $allowJSON;
	public $allowTypes;
	public $input;
	public $char;
	public $ops;
	public $idents;
	public $tokens;
	public function error($err, $pmin, $pmax) {
		$GLOBALS['%s']->push("hscript.Parser::error");
		$�spos = $GLOBALS['%s']->length;
		throw new HException($err);
		$GLOBALS['%s']->pop();
	}
	public function invalidChar($c) {
		$GLOBALS['%s']->push("hscript.Parser::invalidChar");
		$�spos = $GLOBALS['%s']->length;
		throw new HException(hscript_Error::EInvalidChar($c));
		$GLOBALS['%s']->pop();
	}
	public function parseString($s) {
		$GLOBALS['%s']->push("hscript.Parser::parseString");
		$�spos = $GLOBALS['%s']->length;
		$this->line = 1;
		{
			$�tmp = $this->parse(new haxe_io_StringInput($s));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parse($s) {
		$GLOBALS['%s']->push("hscript.Parser::parse");
		$�spos = $GLOBALS['%s']->length;
		$this->tokens = new haxe_FastList();
		$this->char = -1;
		$this->input = $s;
		$this->ops = new _hx_array(array());
		$this->idents = new _hx_array(array());
		{
			$_g1 = 0; $_g = strlen($this->opChars);
			while($_g1 < $_g) {
				$i = $_g1++;
				$this->ops[_hx_char_code_at($this->opChars, $i)] = true;
				unset($i);
			}
		}
		{
			$_g1 = 0; $_g = strlen($this->identChars);
			while($_g1 < $_g) {
				$i = $_g1++;
				$this->idents[_hx_char_code_at($this->identChars, $i)] = true;
				unset($i);
			}
		}
		$a = new _hx_array(array());
		while(true) {
			$tk = $this->token();
			if($tk === hscript_Token::$TEof) {
				break;
			}
			{
				$_this = $this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
				unset($_this);
			}
			$a->push($this->parseFullExpr());
			unset($tk);
		}
		{
			$�tmp = hscript_Parser_0($this, $a, $s);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function unexpected($tk) {
		$GLOBALS['%s']->push("hscript.Parser::unexpected");
		$�spos = $GLOBALS['%s']->length;
		throw new HException(hscript_Error::EUnexpected($this->tokenString($tk)));
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function push($tk) {
		$GLOBALS['%s']->push("hscript.Parser::push");
		$�spos = $GLOBALS['%s']->length;
		$_this = $this->tokens;
		$_this->head = new haxe_FastCell($tk, $_this->head);
		$GLOBALS['%s']->pop();
	}
	public function ensure($tk) {
		$GLOBALS['%s']->push("hscript.Parser::ensure");
		$�spos = $GLOBALS['%s']->length;
		$t = $this->token();
		if($t !== $tk) {
			$this->unexpected($t);
		}
		$GLOBALS['%s']->pop();
	}
	public function expr($e) {
		$GLOBALS['%s']->push("hscript.Parser::expr");
		$�spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $e;
		}
		$GLOBALS['%s']->pop();
	}
	public function pmin($e) {
		$GLOBALS['%s']->push("hscript.Parser::pmin");
		$�spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return 0;
		}
		$GLOBALS['%s']->pop();
	}
	public function pmax($e) {
		$GLOBALS['%s']->push("hscript.Parser::pmax");
		$�spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return 0;
		}
		$GLOBALS['%s']->pop();
	}
	public function mk($e, $pmin, $pmax) {
		$GLOBALS['%s']->push("hscript.Parser::mk");
		$�spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $e;
		}
		$GLOBALS['%s']->pop();
	}
	public function isBlock($e) {
		$GLOBALS['%s']->push("hscript.Parser::isBlock");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = hscript_Parser_1($this, $e);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseFullExpr() {
		$GLOBALS['%s']->push("hscript.Parser::parseFullExpr");
		$�spos = $GLOBALS['%s']->length;
		$e = $this->parseExpr();
		$tk = $this->token();
		if($tk !== hscript_Token::$TSemicolon && $tk !== hscript_Token::$TEof) {
			if($this->isBlock($e)) {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
				}
			} else {
				$this->unexpected($tk);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $e;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseObject($p1) {
		$GLOBALS['%s']->push("hscript.Parser::parseObject");
		$�spos = $GLOBALS['%s']->length;
		$fl = new _hx_array(array());
		while(true) {
			$tk = $this->token();
			$id = null;
			$�t = ($tk);
			switch($�t->index) {
			case 2:
			$i = $�t->params[0];
			{
				$id = $i;
			}break;
			case 1:
			$c = $�t->params[0];
			{
				if(!$this->allowJSON) {
					$this->unexpected($tk);
				}
				$�t2 = ($c);
				switch($�t2->index) {
				case 2:
				$s = $�t2->params[0];
				{
					$id = $s;
				}break;
				default:{
					$this->unexpected($tk);
				}break;
				}
			}break;
			case 7:
			{
				break 2;
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			{
				$t = $this->token();
				if($t !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t);
				}
				unset($t);
			}
			$fl->push(_hx_anonymous(array("name" => $id, "e" => $this->parseExpr())));
			$tk = $this->token();
			$�t = ($tk);
			switch($�t->index) {
			case 7:
			{
				break 2;
			}break;
			case 9:
			{
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			unset($tk,$id);
		}
		{
			$�tmp = $this->parseExprNext(hscript_Expr::EObject($fl));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseExpr() {
		$GLOBALS['%s']->push("hscript.Parser::parseExpr");
		$�spos = $GLOBALS['%s']->length;
		$tk = $this->token();
		$�t = ($tk);
		switch($�t->index) {
		case 2:
		$id = $�t->params[0];
		{
			$e = $this->parseStructure($id);
			if($e === null) {
				$e = hscript_Expr::EIdent($id);
			}
			{
				$�tmp = $this->parseExprNext($e);
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 1:
		$c = $�t->params[0];
		{
			$�tmp = $this->parseExprNext(hscript_Expr::EConst($c));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case 4:
		{
			$e = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TPClose) {
					$this->unexpected($t);
				}
			}
			{
				$�tmp = $this->parseExprNext(hscript_Expr::EParent($e));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 6:
		{
			$tk = $this->token();
			$�t2 = ($tk);
			switch($�t2->index) {
			case 7:
			{
				$�tmp = $this->parseExprNext(hscript_Expr::EObject(new _hx_array(array())));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 2:
			$id = $�t2->params[0];
			{
				$tk2 = $this->token();
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk2, $_this->head);
				}
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
				}
				$�t3 = ($tk2);
				switch($�t3->index) {
				case 14:
				{
					$�tmp = $this->parseExprNext($this->parseObject(0));
					$GLOBALS['%s']->pop();
					return $�tmp;
				}break;
				default:{
				}break;
				}
			}break;
			case 1:
			$c = $�t2->params[0];
			{
				if($this->allowJSON) {
					$�t3 = ($c);
					switch($�t3->index) {
					case 2:
					{
						$tk2 = $this->token();
						{
							$_this = $this->tokens;
							$_this->head = new haxe_FastCell($tk2, $_this->head);
						}
						{
							$_this = $this->tokens;
							$_this->head = new haxe_FastCell($tk, $_this->head);
						}
						$�t4 = ($tk2);
						switch($�t4->index) {
						case 14:
						{
							$�tmp = $this->parseExprNext($this->parseObject(0));
							$GLOBALS['%s']->pop();
							return $�tmp;
						}break;
						default:{
						}break;
						}
					}break;
					default:{
						{
							$_this = $this->tokens;
							$_this->head = new haxe_FastCell($tk, $_this->head);
						}
					}break;
					}
				} else {
					{
						$_this = $this->tokens;
						$_this->head = new haxe_FastCell($tk, $_this->head);
					}
				}
			}break;
			default:{
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
				}
			}break;
			}
			$a = new _hx_array(array());
			while(true) {
				$a->push($this->parseFullExpr());
				$tk = $this->token();
				if($tk === hscript_Token::$TBrClose) {
					break;
				}
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
					unset($_this);
				}
			}
			{
				$�tmp = hscript_Expr::EBlock($a);
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 3:
		$op = $�t->params[0];
		{
			if($this->unops->exists($op)) {
				$�tmp = $this->makeUnop($op, $this->parseExpr());
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
			{
				$�tmp = $this->unexpected($tk);
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 11:
		{
			$a = new _hx_array(array());
			$tk = $this->token();
			while($tk !== hscript_Token::$TBkClose) {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
					unset($_this);
				}
				$a->push($this->parseExpr());
				$tk = $this->token();
				if($tk === hscript_Token::$TComma) {
					$tk = $this->token();
				}
			}
			{
				$�tmp = $this->parseExprNext(hscript_Expr::EArrayDecl($a));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		default:{
			$�tmp = $this->unexpected($tk);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function makeUnop($op, $e) {
		$GLOBALS['%s']->push("hscript.Parser::makeUnop");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = hscript_Parser_2($this, $e, $op);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function makeBinop($op, $e1, $e) {
		$GLOBALS['%s']->push("hscript.Parser::makeBinop");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = hscript_Parser_3($this, $e, $e1, $op);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseStructure($id) {
		$GLOBALS['%s']->push("hscript.Parser::parseStructure");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = hscript_Parser_4($this, $id);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseExprNext($e1) {
		$GLOBALS['%s']->push("hscript.Parser::parseExprNext");
		$�spos = $GLOBALS['%s']->length;
		$tk = $this->token();
		$�t = ($tk);
		switch($�t->index) {
		case 3:
		$op = $�t->params[0];
		{
			if($this->unops->get($op)) {
				if($this->isBlock($e1) || hscript_Parser_5($this, $e1, $op, $tk)) {
					{
						$_this = $this->tokens;
						$_this->head = new haxe_FastCell($tk, $_this->head);
					}
					{
						$GLOBALS['%s']->pop();
						return $e1;
					}
				}
				{
					$�tmp = $this->parseExprNext(hscript_Expr::EUnop($op, false, $e1));
					$GLOBALS['%s']->pop();
					return $�tmp;
				}
			}
			{
				$�tmp = $this->makeBinop($op, $e1, $this->parseExpr());
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 8:
		{
			$tk = $this->token();
			$field = null;
			$�t2 = ($tk);
			switch($�t2->index) {
			case 2:
			$id = $�t2->params[0];
			{
				$field = $id;
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			{
				$�tmp = $this->parseExprNext(hscript_Expr::EField($e1, $field));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 4:
		{
			$�tmp = $this->parseExprNext(hscript_Expr::ECall($e1, $this->parseExprList(hscript_Token::$TPClose)));
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		case 11:
		{
			$e2 = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TBkClose) {
					$this->unexpected($t);
				}
			}
			{
				$�tmp = $this->parseExprNext(hscript_Expr::EArray($e1, $e2));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 13:
		{
			$e2 = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t);
				}
			}
			$e3 = $this->parseExpr();
			{
				$�tmp = hscript_Expr::ETernary($e1, $e2, $e3);
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		default:{
			{
				$_this = $this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
			{
				$GLOBALS['%s']->pop();
				return $e1;
			}
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseType() {
		$GLOBALS['%s']->push("hscript.Parser::parseType");
		$�spos = $GLOBALS['%s']->length;
		$t = $this->token();
		$�t = ($t);
		switch($�t->index) {
		case 2:
		$v = $�t->params[0];
		{
			$path = new _hx_array(array($v));
			while(true) {
				$t = $this->token();
				if($t !== hscript_Token::$TDot) {
					break;
				}
				$t = $this->token();
				$�t2 = ($t);
				switch($�t2->index) {
				case 2:
				$v1 = $�t2->params[0];
				{
					$path->push($v1);
				}break;
				default:{
					$this->unexpected($t);
				}break;
				}
			}
			$params = null;
			$�t2 = ($t);
			switch($�t2->index) {
			case 3:
			$op = $�t2->params[0];
			{
				if($op === "<") {
					$params = new _hx_array(array());
					while(true) {
						$params->push($this->parseType());
						$t = $this->token();
						$�t3 = ($t);
						switch($�t3->index) {
						case 9:
						{
							continue 2;
						}break;
						case 3:
						$op1 = $�t3->params[0];
						{
							if($op1 === ">") {
								break 2;
							}
						}break;
						default:{
						}break;
						}
						$this->unexpected($t);
					}
				}
			}break;
			default:{
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($t, $_this->head);
				}
			}break;
			}
			{
				$�tmp = $this->parseTypeNext(hscript_CType::CTPath($path, $params));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 4:
		{
			$t1 = $this->parseType();
			{
				$t2 = $this->token();
				if($t2 !== hscript_Token::$TPClose) {
					$this->unexpected($t2);
				}
			}
			{
				$�tmp = $this->parseTypeNext(hscript_CType::CTParent($t1));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		case 6:
		{
			$fields = new _hx_array(array());
			while(true) {
				$t = $this->token();
				$�t2 = ($t);
				switch($�t2->index) {
				case 7:
				{
					break 2;
				}break;
				case 2:
				$name = $�t2->params[0];
				{
					{
						$t1 = $this->token();
						if($t1 !== hscript_Token::$TDoubleDot) {
							$this->unexpected($t1);
						}
					}
					$fields->push(_hx_anonymous(array("name" => $name, "t" => $this->parseType())));
					$t = $this->token();
					$�t3 = ($t);
					switch($�t3->index) {
					case 9:
					{
					}break;
					case 7:
					{
						break 3;
					}break;
					default:{
						$this->unexpected($t);
					}break;
					}
				}break;
				default:{
					$this->unexpected($t);
				}break;
				}
			}
			{
				$�tmp = $this->parseTypeNext(hscript_CType::CTAnon($fields));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}break;
		default:{
			$�tmp = $this->unexpected($t);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseTypeNext($t) {
		$GLOBALS['%s']->push("hscript.Parser::parseTypeNext");
		$�spos = $GLOBALS['%s']->length;
		$tk = $this->token();
		$�t = ($tk);
		switch($�t->index) {
		case 3:
		$op = $�t->params[0];
		{
			if($op !== "->") {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
				}
				{
					$GLOBALS['%s']->pop();
					return $t;
				}
			}
		}break;
		default:{
			{
				$_this = $this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
			{
				$GLOBALS['%s']->pop();
				return $t;
			}
		}break;
		}
		$t2 = $this->parseType();
		$�t = ($t2);
		switch($�t->index) {
		case 1:
		$ret = $�t->params[1]; $args = $�t->params[0];
		{
			$args->unshift($t);
			{
				$GLOBALS['%s']->pop();
				return $t2;
			}
		}break;
		default:{
			$�tmp = hscript_CType::CTFun(new _hx_array(array($t)), $t2);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function parseExprList($etk) {
		$GLOBALS['%s']->push("hscript.Parser::parseExprList");
		$�spos = $GLOBALS['%s']->length;
		$args = new _hx_array(array());
		$tk = $this->token();
		if($tk === $etk) {
			$GLOBALS['%s']->pop();
			return $args;
		}
		{
			$_this = $this->tokens;
			$_this->head = new haxe_FastCell($tk, $_this->head);
		}
		while(true) {
			$args->push($this->parseExpr());
			$tk = $this->token();
			$�t = ($tk);
			switch($�t->index) {
			case 9:
			{
			}break;
			default:{
				if($tk === $etk) {
					break 2;
				}
				$this->unexpected($tk);
			}break;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $args;
		}
		$GLOBALS['%s']->pop();
	}
	public function incPos() {
		$GLOBALS['%s']->push("hscript.Parser::incPos");
		$�spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function readChar() {
		$GLOBALS['%s']->push("hscript.Parser::readChar");
		$�spos = $GLOBALS['%s']->length;
		null;
		{
			$�tmp = hscript_Parser_6($this);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function readString($until) {
		$GLOBALS['%s']->push("hscript.Parser::readString");
		$�spos = $GLOBALS['%s']->length;
		$c = null;
		$b = new haxe_io_BytesOutput();
		$esc = false;
		$old = $this->line;
		$s = $this->input;
		while(true) {
			try {
				null;
				$c = $s->readByte();
			}catch(Exception $�e) {
				$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
				$e = $_ex_;
				{
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $�spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedString);
				}
			}
			if($esc) {
				$esc = false;
				switch($c) {
				case 110:{
					$b->writeByte(10);
				}break;
				case 114:{
					$b->writeByte(13);
				}break;
				case 116:{
					$b->writeByte(9);
				}break;
				case 39:case 34:case 92:{
					$b->writeByte($c);
				}break;
				case 47:{
					if($this->allowJSON) {
						$b->writeByte($c);
					} else {
						$this->invalidChar($c);
					}
				}break;
				case 117:{
					if(!$this->allowJSON) {
						throw new HException($this->invalidChar($c));
					}
					$code = null;
					try {
						null;
						null;
						null;
						null;
						$code = $s->readString(4);
					}catch(Exception $�e) {
						$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
						$e2 = $_ex_;
						{
							$GLOBALS['%e'] = new _hx_array(array());
							while($GLOBALS['%s']->length >= $�spos) {
								$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
							}
							$GLOBALS['%s']->push($GLOBALS['%e'][0]);
							$this->line = $old;
							throw new HException(hscript_Error::$EUnterminatedString);
						}
					}
					$k = 0;
					{
						$_g = 0;
						while($_g < 4) {
							$i = $_g++;
							$k <<= 4;
							$char = _hx_char_code_at($code, $i);
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$k += $char - 48;
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$k += $char - 55;
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$k += $char - 87;
							}break;
							default:{
								$this->invalidChar($char);
							}break;
							}
							unset($i,$char);
						}
					}
					if($k <= 127) {
						$b->writeByte($k);
					} else {
						if($k <= 2047) {
							$b->writeByte(192 | $k >> 6);
							$b->writeByte(128 | $k & 63);
						} else {
							$b->writeByte(224 | $k >> 12);
							$b->writeByte(128 | $k >> 6 & 63);
							$b->writeByte(128 | $k & 63);
						}
					}
				}break;
				default:{
					$this->invalidChar($c);
				}break;
				}
			} else {
				if($c === 92) {
					$esc = true;
				} else {
					if($c === $until) {
						break;
					} else {
						if($c === 10) {
							$this->line++;
						}
						$b->writeByte($c);
					}
				}
			}
			unset($e);
		}
		{
			$�tmp = $b->getBytes()->toString();
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function token() {
		$GLOBALS['%s']->push("hscript.Parser::token");
		$�spos = $GLOBALS['%s']->length;
		if(!($this->tokens->head === null)) {
			$�tmp = hscript_Parser_7($this);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$char = null;
		if($this->char < 0) {
			$char = $this->readChar();
		} else {
			$char = $this->char;
			$this->char = -1;
		}
		while(true) {
			switch($char) {
			case 0:{
				$�tmp = hscript_Token::$TEof;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 32:case 9:case 13:{
			}break;
			case 10:{
				$this->line++;
			}break;
			case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
				$n = ($char - 48) * 1.0;
				$exp = 0;
				while(true) {
					$char = $this->readChar();
					$exp *= 10;
					switch($char) {
					case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
						$n = $n * 10 + ($char - 48);
					}break;
					case 46:{
						if($exp > 0) {
							if($exp === 10 && $this->readChar() === 46) {
								{
									$_this = $this->tokens;
									$_this->head = new haxe_FastCell(hscript_Token::TOp("..."), $_this->head);
								}
								$i = intval($n);
								{
									$�tmp = hscript_Token::TConst(((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n)));
									$GLOBALS['%s']->pop();
									return $�tmp;
								}
							}
							$this->invalidChar($char);
						}
						$exp = 1;
					}break;
					case 120:{
						if($n > 0 || $exp > 0) {
							$this->invalidChar($char);
						}
						$n1 = 0;
						while(true) {
							$char = $this->readChar();
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$n1 = ($n1 << 4) + ($char - 48);
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$n1 = ($n1 << 4) + ($char - 55);
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$n1 = ($n1 << 4) + ($char - 87);
							}break;
							default:{
								$this->char = $char;
								$v = hscript_Parser_8($this, $char, $exp, $n, $n1);
								{
									$�tmp = hscript_Token::TConst($v);
									$GLOBALS['%s']->pop();
									return $�tmp;
								}
							}break;
							}
						}
					}break;
					default:{
						$this->char = $char;
						$i = intval($n);
						{
							$�tmp = hscript_Token::TConst((($exp > 0) ? hscript_Const::CFloat($n * 10 / $exp) : ((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n))));
							$GLOBALS['%s']->pop();
							return $�tmp;
						}
					}break;
					}
				}
			}break;
			case 59:{
				$�tmp = hscript_Token::$TSemicolon;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 40:{
				$�tmp = hscript_Token::$TPOpen;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 41:{
				$�tmp = hscript_Token::$TPClose;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 44:{
				$�tmp = hscript_Token::$TComma;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 46:{
				$char = $this->readChar();
				switch($char) {
				case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
					$n = $char - 48;
					$exp = 1;
					while(true) {
						$char = $this->readChar();
						$exp *= 10;
						switch($char) {
						case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
							$n = $n * 10 + ($char - 48);
						}break;
						default:{
							$this->char = $char;
							{
								$�tmp = hscript_Token::TConst(hscript_Const::CFloat($n / $exp));
								$GLOBALS['%s']->pop();
								return $�tmp;
							}
						}break;
						}
					}
				}break;
				case 46:{
					$char = $this->readChar();
					if($char !== 46) {
						$this->invalidChar($char);
					}
					{
						$�tmp = hscript_Token::TOp("...");
						$GLOBALS['%s']->pop();
						return $�tmp;
					}
				}break;
				default:{
					$this->char = $char;
					{
						$�tmp = hscript_Token::$TDot;
						$GLOBALS['%s']->pop();
						return $�tmp;
					}
				}break;
				}
			}break;
			case 123:{
				$�tmp = hscript_Token::$TBrOpen;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 125:{
				$�tmp = hscript_Token::$TBrClose;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 91:{
				$�tmp = hscript_Token::$TBkOpen;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 93:{
				$�tmp = hscript_Token::$TBkClose;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 39:{
				$�tmp = hscript_Token::TConst(hscript_Const::CString($this->readString(39)));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 34:{
				$�tmp = hscript_Token::TConst(hscript_Const::CString($this->readString(34)));
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 63:{
				$�tmp = hscript_Token::$TQuestion;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			case 58:{
				$�tmp = hscript_Token::$TDoubleDot;
				$GLOBALS['%s']->pop();
				return $�tmp;
			}break;
			default:{
				if($this->ops[$char]) {
					$op = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->ops[$char]) {
							if(_hx_char_code_at($op, 0) === 47) {
								$�tmp = $this->tokenComment($op, $char);
								$GLOBALS['%s']->pop();
								return $�tmp;
								unset($�tmp);
							}
							$this->char = $char;
							{
								$�tmp = hscript_Token::TOp($op);
								$GLOBALS['%s']->pop();
								return $�tmp;
								unset($�tmp);
							}
						}
						$op .= chr($char);
					}
				}
				if($this->idents[$char]) {
					$id = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->idents[$char]) {
							$this->char = $char;
							{
								$�tmp = hscript_Token::TId($id);
								$GLOBALS['%s']->pop();
								return $�tmp;
								unset($�tmp);
							}
						}
						$id .= chr($char);
					}
				}
				$this->invalidChar($char);
			}break;
			}
			$char = $this->readChar();
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function tokenComment($op, $char) {
		$GLOBALS['%s']->push("hscript.Parser::tokenComment");
		$�spos = $GLOBALS['%s']->length;
		$c = _hx_char_code_at($op, 1);
		$s = $this->input;
		if($c === 47) {
			try {
				while($char !== 10 && $char !== 13) {
					null;
					$char = $s->readByte();
				}
				$this->char = $char;
			}catch(Exception $�e) {
				$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
				$e = $_ex_;
				{
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $�spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				}
			}
			{
				$�tmp = $this->token();
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}
		if($c === 42) {
			$old = $this->line;
			try {
				while(true) {
					while($char !== 42) {
						if($char === 10) {
							$this->line++;
						}
						null;
						$char = $s->readByte();
					}
					null;
					$char = $s->readByte();
					if($char === 47) {
						break;
					}
				}
			}catch(Exception $�e) {
				$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
				$e = $_ex_;
				{
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $�spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedComment);
				}
			}
			{
				$�tmp = $this->token();
				$GLOBALS['%s']->pop();
				return $�tmp;
			}
		}
		$this->char = $char;
		{
			$�tmp = hscript_Token::TOp($op);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function constString($c) {
		$GLOBALS['%s']->push("hscript.Parser::constString");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = hscript_Parser_9($this, $c);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function tokenString($t) {
		$GLOBALS['%s']->push("hscript.Parser::tokenString");
		$�spos = $GLOBALS['%s']->length;
		{
			$�tmp = hscript_Parser_10($this, $t);
			$GLOBALS['%s']->pop();
			return $�tmp;
		}
		$GLOBALS['%s']->pop();
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
	static $p1 = 0;
	static $readPos = 0;
	static $tokenMin = 0;
	static $tokenMax = 0;
	function __toString() { return 'hscript.Parser'; }
}
function hscript_Parser_0(&$�this, &$a, &$s) {
	$�spos = $GLOBALS['%s']->length;
	if($a->length === 1) {
		return $a[0];
	} else {
		return hscript_Expr::EBlock($a);
	}
}
function hscript_Parser_1(&$�this, &$e) {
	$�spos = $GLOBALS['%s']->length;
	$�t = ($e);
	switch($�t->index) {
	case 4:
	case 21:
	{
		return true;
	}break;
	case 14:
	$e1 = $�t->params[1];
	{
		return $�this->isBlock($e1);
	}break;
	case 2:
	$e1 = $�t->params[2];
	{
		return $e1 !== null && $�this->isBlock($e1);
	}break;
	case 9:
	$e2 = $�t->params[2]; $e1 = $�t->params[1];
	{
		if($e2 !== null) {
			return $�this->isBlock($e2);
		} else {
			return $�this->isBlock($e1);
		}
	}break;
	case 6:
	$e1 = $�t->params[2];
	{
		return $�this->isBlock($e1);
	}break;
	case 7:
	$e1 = $�t->params[2]; $prefix = $�t->params[1];
	{
		return !$prefix && $�this->isBlock($e1);
	}break;
	case 10:
	$e1 = $�t->params[1];
	{
		return $�this->isBlock($e1);
	}break;
	case 11:
	$e1 = $�t->params[2];
	{
		return $�this->isBlock($e1);
	}break;
	case 15:
	$e1 = $�t->params[0];
	{
		return $e1 !== null && $�this->isBlock($e1);
	}break;
	default:{
		return false;
	}break;
	}
}
function hscript_Parser_2(&$�this, &$e, &$op) {
	$�spos = $GLOBALS['%s']->length;
	$�t = ($e);
	switch($�t->index) {
	case 6:
	$e2 = $�t->params[2]; $e1 = $�t->params[1]; $bop = $�t->params[0];
	{
		return hscript_Expr::EBinop($bop, $�this->makeUnop($op, $e1), $e2);
	}break;
	case 22:
	$e3 = $�t->params[2]; $e2 = $�t->params[1]; $e1 = $�t->params[0];
	{
		return hscript_Expr::ETernary($�this->makeUnop($op, $e1), $e2, $e3);
	}break;
	default:{
		return hscript_Expr::EUnop($op, true, $e);
	}break;
	}
}
function hscript_Parser_3(&$�this, &$e, &$e1, &$op) {
	$�spos = $GLOBALS['%s']->length;
	$�t = ($e);
	switch($�t->index) {
	case 6:
	$e3 = $�t->params[2]; $e2 = $�t->params[1]; $op2 = $�t->params[0];
	{
		if($�this->opPriority->get($op) <= $�this->opPriority->get($op2) && !$�this->opRightAssoc->exists($op)) {
			return hscript_Expr::EBinop($op2, $�this->makeBinop($op, $e1, $e2), $e3);
		} else {
			return hscript_Expr::EBinop($op, $e1, $e);
		}
	}break;
	case 22:
	$e4 = $�t->params[2]; $e3 = $�t->params[1]; $e2 = $�t->params[0];
	{
		if($�this->opRightAssoc->exists($op)) {
			return hscript_Expr::EBinop($op, $e1, $e);
		} else {
			return hscript_Expr::ETernary($�this->makeBinop($op, $e1, $e2), $e3, $e4);
		}
	}break;
	default:{
		return hscript_Expr::EBinop($op, $e1, $e);
	}break;
	}
}
function hscript_Parser_4(&$�this, &$id) {
	$�spos = $GLOBALS['%s']->length;
	switch($id) {
	case "if":{
		$cond = $�this->parseExpr();
		$e1 = $�this->parseExpr();
		$e2 = null;
		$semic = false;
		$tk = $�this->token();
		if($tk === hscript_Token::$TSemicolon) {
			$semic = true;
			$tk = $�this->token();
		}
		if(Type::enumEq($tk, hscript_Token::TId("else"))) {
			$e2 = $�this->parseExpr();
		} else {
			{
				$_this = $�this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
			if($semic) {
				{
					$_this = $�this->tokens;
					$_this->head = new haxe_FastCell(hscript_Token::$TSemicolon, $_this->head);
				}
			}
		}
		return hscript_Expr::EIf($cond, $e1, $e2);
	}break;
	case "var":{
		$tk = $�this->token();
		$ident = null;
		$�t = ($tk);
		switch($�t->index) {
		case 2:
		$id1 = $�t->params[0];
		{
			$ident = $id1;
		}break;
		default:{
			$�this->unexpected($tk);
		}break;
		}
		$tk = $�this->token();
		$t = null;
		if($tk === hscript_Token::$TDoubleDot && $�this->allowTypes) {
			$t = $�this->parseType();
			$tk = $�this->token();
		}
		$e = null;
		if(Type::enumEq($tk, hscript_Token::TOp("="))) {
			$e = $�this->parseExpr();
		} else {
			{
				$_this = $�this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
		}
		return hscript_Expr::EVar($ident, $t, $e);
	}break;
	case "while":{
		$econd = $�this->parseExpr();
		$e = $�this->parseExpr();
		return hscript_Expr::EWhile($econd, $e);
	}break;
	case "for":{
		{
			$t = $�this->token();
			if($t !== hscript_Token::$TPOpen) {
				$�this->unexpected($t);
			}
		}
		$tk = $�this->token();
		$vname = null;
		$�t = ($tk);
		switch($�t->index) {
		case 2:
		$id1 = $�t->params[0];
		{
			$vname = $id1;
		}break;
		default:{
			$�this->unexpected($tk);
		}break;
		}
		$tk = $�this->token();
		if(!Type::enumEq($tk, hscript_Token::TId("in"))) {
			$�this->unexpected($tk);
		}
		$eiter = $�this->parseExpr();
		{
			$t = $�this->token();
			if($t !== hscript_Token::$TPClose) {
				$�this->unexpected($t);
			}
		}
		$e = $�this->parseExpr();
		return hscript_Expr::EFor($vname, $eiter, $e);
	}break;
	case "break":{
		return hscript_Expr::$EBreak;
	}break;
	case "continue":{
		return hscript_Expr::$EContinue;
	}break;
	case "else":{
		return $�this->unexpected(hscript_Token::TId($id));
	}break;
	case "function":{
		$tk = $�this->token();
		$name = null;
		$�t = ($tk);
		switch($�t->index) {
		case 2:
		$id1 = $�t->params[0];
		{
			$name = $id1;
		}break;
		default:{
			{
				$_this = $�this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
		}break;
		}
		{
			$t = $�this->token();
			if($t !== hscript_Token::$TPOpen) {
				$�this->unexpected($t);
			}
		}
		$args = new _hx_array(array());
		$tk = $�this->token();
		if($tk !== hscript_Token::$TPClose) {
			while(true) {
				$name1 = null;
				$�t = ($tk);
				switch($�t->index) {
				case 2:
				$id1 = $�t->params[0];
				{
					$name1 = $id1;
				}break;
				default:{
					$�this->unexpected($tk);
				}break;
				}
				$tk = $�this->token();
				$t = null;
				if($tk === hscript_Token::$TDoubleDot && $�this->allowTypes) {
					$t = $�this->parseType();
					$tk = $�this->token();
				}
				$args->push(_hx_anonymous(array("name" => $name1, "t" => $t)));
				$�t = ($tk);
				switch($�t->index) {
				case 9:
				{
				}break;
				case 5:
				{
					break 2;
				}break;
				default:{
					$�this->unexpected($tk);
				}break;
				}
				$tk = $�this->token();
				unset($t,$name1);
			}
		}
		$ret = null;
		if($�this->allowTypes) {
			$tk = $�this->token();
			if($tk !== hscript_Token::$TDoubleDot) {
				{
					$_this = $�this->tokens;
					$_this->head = new haxe_FastCell($tk, $_this->head);
				}
			} else {
				$ret = $�this->parseType();
			}
		}
		$body = $�this->parseExpr();
		return hscript_Expr::EFunction($args, $body, $name, $ret);
	}break;
	case "return":{
		$tk = $�this->token();
		{
			$_this = $�this->tokens;
			$_this->head = new haxe_FastCell($tk, $_this->head);
		}
		$e = (($tk === hscript_Token::$TSemicolon) ? null : $�this->parseExpr());
		return hscript_Expr::EReturn($e);
	}break;
	case "new":{
		$a = new _hx_array(array());
		$tk = $�this->token();
		$�t = ($tk);
		switch($�t->index) {
		case 2:
		$id1 = $�t->params[0];
		{
			$a->push($id1);
		}break;
		default:{
			$�this->unexpected($tk);
		}break;
		}
		while(true) {
			$tk = $�this->token();
			$�t = ($tk);
			switch($�t->index) {
			case 8:
			{
				$tk = $�this->token();
				$�t2 = ($tk);
				switch($�t2->index) {
				case 2:
				$id1 = $�t2->params[0];
				{
					$a->push($id1);
				}break;
				default:{
					$�this->unexpected($tk);
				}break;
				}
			}break;
			case 4:
			{
				break 2;
			}break;
			default:{
				$�this->unexpected($tk);
			}break;
			}
		}
		$args = $�this->parseExprList(hscript_Token::$TPClose);
		return hscript_Expr::ENew($a->join("."), $args);
	}break;
	case "throw":{
		$e = $�this->parseExpr();
		return hscript_Expr::EThrow($e);
	}break;
	case "try":{
		$e = $�this->parseExpr();
		$tk = $�this->token();
		if(!Type::enumEq($tk, hscript_Token::TId("catch"))) {
			$�this->unexpected($tk);
		}
		{
			$t = $�this->token();
			if($t !== hscript_Token::$TPOpen) {
				$�this->unexpected($t);
			}
		}
		$tk = $�this->token();
		$vname = hscript_Parser_11($e, $id, $tk);
		{
			$t = $�this->token();
			if($t !== hscript_Token::$TDoubleDot) {
				$�this->unexpected($t);
			}
		}
		$t = null;
		if($�this->allowTypes) {
			$t = $�this->parseType();
		} else {
			$tk = $�this->token();
			if(!Type::enumEq($tk, hscript_Token::TId("Dynamic"))) {
				$�this->unexpected($tk);
			}
		}
		{
			$t1 = $�this->token();
			if($t1 !== hscript_Token::$TPClose) {
				$�this->unexpected($t1);
			}
		}
		$ec = $�this->parseExpr();
		return hscript_Expr::ETry($e, $vname, $t, $ec);
	}break;
	default:{
		return null;
	}break;
	}
}
function hscript_Parser_5(&$�this, &$e1, &$op, &$tk) {
	$�spos = $GLOBALS['%s']->length;
	$�t2 = ($e1);
	switch($�t2->index) {
	case 3:
	{
		return true;
	}break;
	default:{
		return false;
	}break;
	}
}
function hscript_Parser_6(&$�this) {
	$�spos = $GLOBALS['%s']->length;
	try {
		return $�this->input->readByte();
	}catch(Exception $�e) {
		$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
		$e = $_ex_;
		{
			$GLOBALS['%e'] = new _hx_array(array());
			while($GLOBALS['%s']->length >= $�spos) {
				$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
			}
			$GLOBALS['%s']->push($GLOBALS['%e'][0]);
			return 0;
		}
	}
}
function hscript_Parser_7(&$�this) {
	$�spos = $GLOBALS['%s']->length;
	{
		$_this = $�this->tokens;
		$k = $_this->head;
		if($k === null) {
			return null;
		} else {
			$_this->head = $k->next;
			return $k->elt;
		}
		unset($k,$_this);
	}
}
function hscript_Parser_8(&$�this, &$char, &$exp, &$n, &$n1) {
	$�spos = $GLOBALS['%s']->length;
	try {
		return hscript_Const::CInt(hscript_Parser_12($char, $exp, $n, $n1));
	}catch(Exception $�e) {
		$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
		$e = $_ex_;
		{
			$GLOBALS['%e'] = new _hx_array(array());
			while($GLOBALS['%s']->length >= $�spos) {
				$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
			}
			$GLOBALS['%s']->push($GLOBALS['%e'][0]);
			return hscript_Const::CInt32($n1);
		}
	}
}
function hscript_Parser_9(&$�this, &$c) {
	$�spos = $GLOBALS['%s']->length;
	$�t = ($c);
	switch($�t->index) {
	case 0:
	$v = $�t->params[0];
	{
		return Std::string($v);
	}break;
	case 3:
	$v = $�t->params[0];
	{
		return Std::string($v);
	}break;
	case 1:
	$f = $�t->params[0];
	{
		return Std::string($f);
	}break;
	case 2:
	$s = $�t->params[0];
	{
		return $s;
	}break;
	}
}
function hscript_Parser_10(&$�this, &$t) {
	$�spos = $GLOBALS['%s']->length;
	$�t = ($t);
	switch($�t->index) {
	case 0:
	{
		return "<eof>";
	}break;
	case 1:
	$c = $�t->params[0];
	{
		return $�this->constString($c);
	}break;
	case 2:
	$s = $�t->params[0];
	{
		return $s;
	}break;
	case 3:
	$s = $�t->params[0];
	{
		return $s;
	}break;
	case 4:
	{
		return "(";
	}break;
	case 5:
	{
		return ")";
	}break;
	case 6:
	{
		return "{";
	}break;
	case 7:
	{
		return "}";
	}break;
	case 8:
	{
		return ".";
	}break;
	case 9:
	{
		return ",";
	}break;
	case 10:
	{
		return ";";
	}break;
	case 11:
	{
		return "[";
	}break;
	case 12:
	{
		return "]";
	}break;
	case 13:
	{
		return "?";
	}break;
	case 14:
	{
		return ":";
	}break;
	}
}
function hscript_Parser_11(&$e, &$id, &$tk) {
	$�spos = $GLOBALS['%s']->length;
	$�t = ($tk);
	switch($�t->index) {
	case 2:
	$id1 = $�t->params[0];
	{
		return $id1;
	}break;
	default:{
		return $�this->unexpected($tk);
	}break;
	}
}
function hscript_Parser_12(&$char, &$exp, &$n, &$n1) {
	$�spos = $GLOBALS['%s']->length;
	{
		if(($n1 >> 30 & 1) !== _hx_shift_right($n1, 31)) {
			throw new HException("Overflow " . $n1);
		}
		return $n1 & -1;
	}
}
