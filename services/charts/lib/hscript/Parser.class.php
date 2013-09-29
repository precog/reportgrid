<?php

class hscript_Parser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
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
		throw new HException($err);
	}
	public function invalidChar($c) {
		throw new HException(hscript_Error::EInvalidChar($c));
	}
	public function parseString($s) {
		$this->line = 1;
		return $this->parse(new haxe_io_StringInput($s));
	}
	public function parse($s) {
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
		return hscript_Parser_0($this, $a, $s);
	}
	public function unexpected($tk) {
		throw new HException(hscript_Error::EUnexpected($this->tokenString($tk)));
		return null;
	}
	public function push($tk) {
		$_this = $this->tokens;
		$_this->head = new haxe_FastCell($tk, $_this->head);
	}
	public function ensure($tk) {
		$t = $this->token();
		if($t !== $tk) {
			$this->unexpected($t);
		}
	}
	public function expr($e) {
		return $e;
	}
	public function pmin($e) {
		return 0;
	}
	public function pmax($e) {
		return 0;
	}
	public function mk($e, $pmin, $pmax) {
		return $e;
	}
	public function isBlock($e) {
		return hscript_Parser_1($this, $e);
	}
	public function parseFullExpr() {
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
		return $e;
	}
	public function parseObject($p1) {
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
		return $this->parseExprNext(hscript_Expr::EObject($fl));
	}
	public function parseExpr() {
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
			return $this->parseExprNext($e);
		}break;
		case 1:
		$c = $�t->params[0];
		{
			return $this->parseExprNext(hscript_Expr::EConst($c));
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
			return $this->parseExprNext(hscript_Expr::EParent($e));
		}break;
		case 6:
		{
			$tk = $this->token();
			$�t2 = ($tk);
			switch($�t2->index) {
			case 7:
			{
				return $this->parseExprNext(hscript_Expr::EObject(new _hx_array(array())));
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
					return $this->parseExprNext($this->parseObject(0));
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
							return $this->parseExprNext($this->parseObject(0));
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
			return hscript_Expr::EBlock($a);
		}break;
		case 3:
		$op = $�t->params[0];
		{
			if($this->unops->exists($op)) {
				return $this->makeUnop($op, $this->parseExpr());
			}
			return $this->unexpected($tk);
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
			return $this->parseExprNext(hscript_Expr::EArrayDecl($a));
		}break;
		default:{
			return $this->unexpected($tk);
		}break;
		}
	}
	public function makeUnop($op, $e) {
		return hscript_Parser_2($this, $e, $op);
	}
	public function makeBinop($op, $e1, $e) {
		return hscript_Parser_3($this, $e, $e1, $op);
	}
	public function parseStructure($id) {
		return hscript_Parser_4($this, $id);
	}
	public function parseExprNext($e1) {
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
					return $e1;
				}
				return $this->parseExprNext(hscript_Expr::EUnop($op, false, $e1));
			}
			return $this->makeBinop($op, $e1, $this->parseExpr());
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
			return $this->parseExprNext(hscript_Expr::EField($e1, $field));
		}break;
		case 4:
		{
			return $this->parseExprNext(hscript_Expr::ECall($e1, $this->parseExprList(hscript_Token::$TPClose)));
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
			return $this->parseExprNext(hscript_Expr::EArray($e1, $e2));
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
			return hscript_Expr::ETernary($e1, $e2, $e3);
		}break;
		default:{
			{
				$_this = $this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
			return $e1;
		}break;
		}
	}
	public function parseType() {
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
			return $this->parseTypeNext(hscript_CType::CTPath($path, $params));
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
			return $this->parseTypeNext(hscript_CType::CTParent($t1));
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
			return $this->parseTypeNext(hscript_CType::CTAnon($fields));
		}break;
		default:{
			return $this->unexpected($t);
		}break;
		}
	}
	public function parseTypeNext($t) {
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
				return $t;
			}
		}break;
		default:{
			{
				$_this = $this->tokens;
				$_this->head = new haxe_FastCell($tk, $_this->head);
			}
			return $t;
		}break;
		}
		$t2 = $this->parseType();
		$�t = ($t2);
		switch($�t->index) {
		case 1:
		$ret = $�t->params[1]; $args = $�t->params[0];
		{
			$args->unshift($t);
			return $t2;
		}break;
		default:{
			return hscript_CType::CTFun(new _hx_array(array($t)), $t2);
		}break;
		}
	}
	public function parseExprList($etk) {
		$args = new _hx_array(array());
		$tk = $this->token();
		if($tk === $etk) {
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
		return $args;
	}
	public function incPos() {
	}
	public function readChar() {
		null;
		return hscript_Parser_6($this);
	}
	public function readString($until) {
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
		return $b->getBytes()->toString();
	}
	public function token() {
		if(!($this->tokens->head === null)) {
			return hscript_Parser_7($this);
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
				return hscript_Token::$TEof;
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
								return hscript_Token::TConst(((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n)));
							}
							$this->invalidChar($char);
						}
						$exp = 1;
					}break;
					case 120:{
						if($n > 0 || $exp > 0) {
							$this->invalidChar($char);
						}
						$n1 = 0 | 0;
						while(true) {
							$char = $this->readChar();
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$n1 = ($n1 << 4) + ($char - 48) | 0;
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$n1 = ($n1 << 4) + ($char - 55) | 0;
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$n1 = ($n1 << 4) + ($char - 87) | 0;
							}break;
							default:{
								$this->char = $char;
								$v = hscript_Parser_8($this, $char, $exp, $n, $n1);
								return hscript_Token::TConst($v);
							}break;
							}
						}
					}break;
					default:{
						$this->char = $char;
						$i = intval($n);
						return hscript_Token::TConst((($exp > 0) ? hscript_Const::CFloat($n * 10 / $exp) : ((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n))));
					}break;
					}
				}
			}break;
			case 59:{
				return hscript_Token::$TSemicolon;
			}break;
			case 40:{
				return hscript_Token::$TPOpen;
			}break;
			case 41:{
				return hscript_Token::$TPClose;
			}break;
			case 44:{
				return hscript_Token::$TComma;
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
							return hscript_Token::TConst(hscript_Const::CFloat($n / $exp));
						}break;
						}
					}
				}break;
				case 46:{
					$char = $this->readChar();
					if($char !== 46) {
						$this->invalidChar($char);
					}
					return hscript_Token::TOp("...");
				}break;
				default:{
					$this->char = $char;
					return hscript_Token::$TDot;
				}break;
				}
			}break;
			case 123:{
				return hscript_Token::$TBrOpen;
			}break;
			case 125:{
				return hscript_Token::$TBrClose;
			}break;
			case 91:{
				return hscript_Token::$TBkOpen;
			}break;
			case 93:{
				return hscript_Token::$TBkClose;
			}break;
			case 39:{
				return hscript_Token::TConst(hscript_Const::CString($this->readString(39)));
			}break;
			case 34:{
				return hscript_Token::TConst(hscript_Const::CString($this->readString(34)));
			}break;
			case 63:{
				return hscript_Token::$TQuestion;
			}break;
			case 58:{
				return hscript_Token::$TDoubleDot;
			}break;
			default:{
				if($this->ops[$char]) {
					$op = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->ops[$char]) {
							if(_hx_char_code_at($op, 0) === 47) {
								return $this->tokenComment($op, $char);
							}
							$this->char = $char;
							return hscript_Token::TOp($op);
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
							return hscript_Token::TId($id);
						}
						$id .= chr($char);
					}
				}
				$this->invalidChar($char);
			}break;
			}
			$char = $this->readChar();
		}
		return null;
	}
	public function tokenComment($op, $char) {
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
				}
			}
			return $this->token();
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
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedComment);
				}
			}
			return $this->token();
		}
		$this->char = $char;
		return hscript_Token::TOp($op);
	}
	public function constString($c) {
		return hscript_Parser_9($this, $c);
	}
	public function tokenString($t) {
		return hscript_Parser_10($this, $t);
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
	if($a->length === 1) {
		return $a[0];
	} else {
		return hscript_Expr::EBlock($a);
	}
}
function hscript_Parser_1(&$�this, &$e) {
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
	try {
		return $�this->input->readByte();
	}catch(Exception $�e) {
		$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
		$e = $_ex_;
		{
			return 0;
		}
	}
}
function hscript_Parser_7(&$�this) {
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
	try {
		return hscript_Const::CInt(hscript_Parser_12($char, $exp, $n, $n1));
	}catch(Exception $�e) {
		$_ex_ = ($�e instanceof HException) ? $�e->e : $�e;
		$e = $_ex_;
		{
			return hscript_Const::CInt32($n1);
		}
	}
}
function hscript_Parser_9(&$�this, &$c) {
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
	{
		if(($n1 >> 30 & 1) !== _hx_shift_right($n1, 31)) {
			throw new HException("Overflow " . $n1);
		}
		return $n1 & -1;
	}
}
