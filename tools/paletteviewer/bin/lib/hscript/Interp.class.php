<?php

class hscript_Interp {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("hscript.Interp::new");
		$»spos = $GLOBALS['%s']->length;
		$this->locals = new Hash();
		$this->declared = new _hx_array(array());
		$this->variables = new Hash();
		$this->variables->set("null", null);
		$this->variables->set("true", true);
		$this->variables->set("false", false);
		$this->variables->set("trace", array(new _hx_lambda(array(), "hscript_Interp_0"), 'execute'));
		$this->initOps();
		$GLOBALS['%s']->pop();
	}}
	public $variables;
	public $locals;
	public $binops;
	public $declared;
	public function initOps() {
		$GLOBALS['%s']->push("hscript.Interp::initOps");
		$»spos = $GLOBALS['%s']->length;
		$me = $this;
		$this->binops = new Hash();
		$this->binops->set("+", array(new _hx_lambda(array(&$me), "hscript_Interp_1"), 'execute'));
		$this->binops->set("-", array(new _hx_lambda(array(&$me), "hscript_Interp_2"), 'execute'));
		$this->binops->set("*", array(new _hx_lambda(array(&$me), "hscript_Interp_3"), 'execute'));
		$this->binops->set("/", array(new _hx_lambda(array(&$me), "hscript_Interp_4"), 'execute'));
		$this->binops->set("%", array(new _hx_lambda(array(&$me), "hscript_Interp_5"), 'execute'));
		$this->binops->set("&", array(new _hx_lambda(array(&$me), "hscript_Interp_6"), 'execute'));
		$this->binops->set("|", array(new _hx_lambda(array(&$me), "hscript_Interp_7"), 'execute'));
		$this->binops->set("^", array(new _hx_lambda(array(&$me), "hscript_Interp_8"), 'execute'));
		$this->binops->set("<<", array(new _hx_lambda(array(&$me), "hscript_Interp_9"), 'execute'));
		$this->binops->set(">>", array(new _hx_lambda(array(&$me), "hscript_Interp_10"), 'execute'));
		$this->binops->set(">>>", array(new _hx_lambda(array(&$me), "hscript_Interp_11"), 'execute'));
		$this->binops->set("==", array(new _hx_lambda(array(&$me), "hscript_Interp_12"), 'execute'));
		$this->binops->set("!=", array(new _hx_lambda(array(&$me), "hscript_Interp_13"), 'execute'));
		$this->binops->set(">=", array(new _hx_lambda(array(&$me), "hscript_Interp_14"), 'execute'));
		$this->binops->set("<=", array(new _hx_lambda(array(&$me), "hscript_Interp_15"), 'execute'));
		$this->binops->set(">", array(new _hx_lambda(array(&$me), "hscript_Interp_16"), 'execute'));
		$this->binops->set("<", array(new _hx_lambda(array(&$me), "hscript_Interp_17"), 'execute'));
		$this->binops->set("||", array(new _hx_lambda(array(&$me), "hscript_Interp_18"), 'execute'));
		$this->binops->set("&&", array(new _hx_lambda(array(&$me), "hscript_Interp_19"), 'execute'));
		$this->binops->set("=", (isset($this->assign) ? $this->assign: array($this, "assign")));
		$this->binops->set("...", array(new _hx_lambda(array(&$me), "hscript_Interp_20"), 'execute'));
		$this->assignOp("+=", array(new _hx_lambda(array(&$me), "hscript_Interp_21"), 'execute'));
		$this->assignOp("-=", array(new _hx_lambda(array(&$me), "hscript_Interp_22"), 'execute'));
		$this->assignOp("*=", array(new _hx_lambda(array(&$me), "hscript_Interp_23"), 'execute'));
		$this->assignOp("/=", array(new _hx_lambda(array(&$me), "hscript_Interp_24"), 'execute'));
		$this->assignOp("%=", array(new _hx_lambda(array(&$me), "hscript_Interp_25"), 'execute'));
		$this->assignOp("&=", array(new _hx_lambda(array(&$me), "hscript_Interp_26"), 'execute'));
		$this->assignOp("|=", array(new _hx_lambda(array(&$me), "hscript_Interp_27"), 'execute'));
		$this->assignOp("^=", array(new _hx_lambda(array(&$me), "hscript_Interp_28"), 'execute'));
		$this->assignOp("<<=", array(new _hx_lambda(array(&$me), "hscript_Interp_29"), 'execute'));
		$this->assignOp(">>=", array(new _hx_lambda(array(&$me), "hscript_Interp_30"), 'execute'));
		$this->assignOp(">>>=", array(new _hx_lambda(array(&$me), "hscript_Interp_31"), 'execute'));
		$GLOBALS['%s']->pop();
	}
	public function assign($e1, $e2) {
		$GLOBALS['%s']->push("hscript.Interp::assign");
		$»spos = $GLOBALS['%s']->length;
		$v = $this->expr($e2);
		$»t = ($e1);
		switch($»t->index) {
		case 1:
		$id = $»t->params[0];
		{
			$l = $this->locals->get($id);
			if($l === null) {
				$this->variables->set($id, $v);
			} else {
				$l->r = $v;
			}
		}break;
		case 5:
		$f = $»t->params[1]; $e = $»t->params[0];
		{
			$v = $this->set($this->expr($e), $f, $v);
		}break;
		case 16:
		$index = $»t->params[1]; $e = $»t->params[0];
		{
			_hx_array_assign($this->expr($e), $this->expr($index), $v);
		}break;
		default:{
			throw new HException(hscript_Error::EInvalidOp("="));
		}break;
		}
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function assignOp($op, $fop) {
		$GLOBALS['%s']->push("hscript.Interp::assignOp");
		$»spos = $GLOBALS['%s']->length;
		$me = $this;
		$this->binops->set($op, array(new _hx_lambda(array(&$fop, &$me, &$op), "hscript_Interp_32"), 'execute'));
		$GLOBALS['%s']->pop();
	}
	public function evalAssignOp($op, $fop, $e1, $e2) {
		$GLOBALS['%s']->push("hscript.Interp::evalAssignOp");
		$»spos = $GLOBALS['%s']->length;
		$v = null;
		$»t = ($e1);
		switch($»t->index) {
		case 1:
		$id = $»t->params[0];
		{
			$l = $this->locals->get($id);
			$v = call_user_func_array($fop, array($this->expr($e1), $this->expr($e2)));
			if($l === null) {
				$this->variables->set($id, $v);
			} else {
				$l->r = $v;
			}
		}break;
		case 5:
		$f = $»t->params[1]; $e = $»t->params[0];
		{
			$obj = $this->expr($e);
			$v = call_user_func_array($fop, array($this->get($obj, $f), $this->expr($e2)));
			$v = $this->set($obj, $f, $v);
		}break;
		case 16:
		$index = $»t->params[1]; $e = $»t->params[0];
		{
			$arr = $this->expr($e);
			$index1 = $this->expr($index);
			$v = call_user_func_array($fop, array($arr[$index1], $this->expr($e2)));
			$arr[$index1] = $v;
		}break;
		default:{
			throw new HException(hscript_Error::EInvalidOp($op));
		}break;
		}
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function increment($e, $prefix, $delta) {
		$GLOBALS['%s']->push("hscript.Interp::increment");
		$»spos = $GLOBALS['%s']->length;
		$»t = ($e);
		switch($»t->index) {
		case 1:
		$id = $»t->params[0];
		{
			$l = $this->locals->get($id);
			$v = hscript_Interp_33($this, $delta, $e, $id, $l, $prefix);
			if($prefix) {
				$v += $delta;
				if($l === null) {
					$this->variables->set($id, $v);
				} else {
					$l->r = $v;
				}
			} else {
				if($l === null) {
					$this->variables->set($id, $v + $delta);
				} else {
					$l->r = $v + $delta;
				}
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 5:
		$f = $»t->params[1]; $e1 = $»t->params[0];
		{
			$obj = $this->expr($e1);
			$v = $this->get($obj, $f);
			if($prefix) {
				$v += $delta;
				$this->set($obj, $f, $v);
			} else {
				$this->set($obj, $f, $v + $delta);
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 16:
		$index = $»t->params[1]; $e1 = $»t->params[0];
		{
			$arr = $this->expr($e1);
			$index1 = $this->expr($index);
			$v = $arr[$index1];
			if($prefix) {
				$v += $delta;
				$arr[$index1] = $v;
			} else {
				$arr[$index1] = $v + $delta;
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		default:{
			throw new HException(hscript_Error::EInvalidOp((($delta > 0) ? "++" : "--")));
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function execute($expr) {
		$GLOBALS['%s']->push("hscript.Interp::execute");
		$»spos = $GLOBALS['%s']->length;
		$this->locals = new Hash();
		{
			$»tmp = $this->exprReturn($expr);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function exprReturn($e) {
		$GLOBALS['%s']->push("hscript.Interp::exprReturn");
		$»spos = $GLOBALS['%s']->length;
		try {
			{
				$»tmp = $this->expr($e);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e1 = $_ex_) instanceof hscript__Interp_Stop){
				$GLOBALS['%e'] = new _hx_array(array());
				while($GLOBALS['%s']->length >= $»spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$»t = ($e1);
				switch($»t->index) {
				case 0:
				{
					throw new HException("Invalid break");
				}break;
				case 1:
				{
					throw new HException("Invalid continue");
				}break;
				case 2:
				$v = $»t->params[0];
				{
					$GLOBALS['%s']->pop();
					return $v;
				}break;
				}
			} else throw $»e;;
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function duplicate($h) {
		$GLOBALS['%s']->push("hscript.Interp::duplicate");
		$»spos = $GLOBALS['%s']->length;
		$h2 = new Hash();
		if(null == $h) throw new HException('null iterable');
		$»it = $h->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$h2->set($k, $h->get($k));
		}
		{
			$GLOBALS['%s']->pop();
			return $h2;
		}
		$GLOBALS['%s']->pop();
	}
	public function restore($old) {
		$GLOBALS['%s']->push("hscript.Interp::restore");
		$»spos = $GLOBALS['%s']->length;
		while($this->declared->length > $old) {
			$d = $this->declared->pop();
			$this->locals->set($d->n, $d->old);
			unset($d);
		}
		$GLOBALS['%s']->pop();
	}
	public function expr($e) {
		$GLOBALS['%s']->push("hscript.Interp::expr");
		$»spos = $GLOBALS['%s']->length;
		$»t = ($e);
		switch($»t->index) {
		case 0:
		$c = $»t->params[0];
		{
			$»t2 = ($c);
			switch($»t2->index) {
			case 0:
			$v = $»t2->params[0];
			{
				$GLOBALS['%s']->pop();
				return $v;
			}break;
			case 3:
			$v = $»t2->params[0];
			{
				$GLOBALS['%s']->pop();
				return $v;
			}break;
			case 1:
			$f = $»t2->params[0];
			{
				$GLOBALS['%s']->pop();
				return $f;
			}break;
			case 2:
			$s = $»t2->params[0];
			{
				$GLOBALS['%s']->pop();
				return $s;
			}break;
			}
		}break;
		case 1:
		$id = $»t->params[0];
		{
			$l = $this->locals->get($id);
			if($l !== null) {
				$»tmp = $l->r;
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
			$v = $this->variables->get($id);
			if($v === null && !$this->variables->exists($id)) {
				throw new HException(hscript_Error::EUnknownVariable($id));
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 2:
		$e1 = $»t->params[2]; $n = $»t->params[0];
		{
			$this->declared->push(_hx_anonymous(array("n" => $n, "old" => $this->locals->get($n))));
			$this->locals->set($n, _hx_anonymous(array("r" => (($e1 === null) ? null : $this->expr($e1)))));
			{
				$GLOBALS['%s']->pop();
				return null;
			}
		}break;
		case 3:
		$e1 = $»t->params[0];
		{
			$»tmp = $this->expr($e1);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 4:
		$exprs = $»t->params[0];
		{
			$old = $this->declared->length;
			$v = null;
			{
				$_g = 0;
				while($_g < $exprs->length) {
					$e1 = $exprs[$_g];
					++$_g;
					$v = $this->expr($e1);
					unset($e1);
				}
			}
			$this->restore($old);
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 5:
		$f = $»t->params[1]; $e1 = $»t->params[0];
		{
			$»tmp = $this->get($this->expr($e1), $f);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 6:
		$e2 = $»t->params[2]; $e1 = $»t->params[1]; $op = $»t->params[0];
		{
			$fop = $this->binops->get($op);
			if($fop === null) {
				throw new HException(hscript_Error::EInvalidOp($op));
			}
			{
				$»tmp = call_user_func_array($fop, array($e1, $e2));
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}break;
		case 7:
		$e1 = $»t->params[2]; $prefix = $»t->params[1]; $op = $»t->params[0];
		{
			switch($op) {
			case "!":{
				$»tmp = !_hx_equal($this->expr($e1), true);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			case "-":{
				$»tmp = -$this->expr($e1);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			case "++":{
				$»tmp = $this->increment($e1, $prefix, 1);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			case "--":{
				$»tmp = $this->increment($e1, $prefix, -1);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			case "~":{
				$»tmp = ~$this->expr($e1);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			default:{
				throw new HException(hscript_Error::EInvalidOp($op));
			}break;
			}
		}break;
		case 8:
		$params = $»t->params[1]; $e1 = $»t->params[0];
		{
			$args = new _hx_array(array());
			{
				$_g = 0;
				while($_g < $params->length) {
					$p = $params[$_g];
					++$_g;
					$args->push($this->expr($p));
					unset($p);
				}
			}
			$»t2 = ($e1);
			switch($»t2->index) {
			case 5:
			$f = $»t2->params[1]; $e2 = $»t2->params[0];
			{
				$obj = $this->expr($e2);
				if($obj === null) {
					throw new HException(hscript_Error::EInvalidAccess($f));
				}
				{
					$»tmp = $this->call($obj, Reflect::field($obj, $f), $args);
					$GLOBALS['%s']->pop();
					return $»tmp;
				}
			}break;
			default:{
				$»tmp = $this->call(null, $this->expr($e1), $args);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}break;
			}
		}break;
		case 9:
		$e2 = $»t->params[2]; $e1 = $»t->params[1]; $econd = $»t->params[0];
		{
			$»tmp = ((_hx_equal($this->expr($econd), true)) ? $this->expr($e1) : (($e2 === null) ? null : $this->expr($e2)));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 10:
		$e1 = $»t->params[1]; $econd = $»t->params[0];
		{
			$this->whileLoop($econd, $e1);
			{
				$GLOBALS['%s']->pop();
				return null;
			}
		}break;
		case 11:
		$e1 = $»t->params[2]; $it = $»t->params[1]; $v = $»t->params[0];
		{
			$this->forLoop($v, $it, $e1);
			{
				$GLOBALS['%s']->pop();
				return null;
			}
		}break;
		case 12:
		{
			throw new HException(hscript__Interp_Stop::$SBreak);
		}break;
		case 13:
		{
			throw new HException(hscript__Interp_Stop::$SContinue);
		}break;
		case 15:
		$e1 = $»t->params[0];
		{
			throw new HException(hscript__Interp_Stop::SReturn((($e1 === null) ? null : $this->expr($e1))));
		}break;
		case 14:
		$name = $»t->params[2]; $fexpr = $»t->params[1]; $params = $»t->params[0];
		{
			$capturedLocals = $this->duplicate($this->locals);
			$me = $this;
			$f = array(new _hx_lambda(array(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params), "hscript_Interp_34"), 'execute');
			$f1 = Reflect::makeVarArgs($f);
			if($name !== null) {
				$this->variables->set($name, $f1);
			}
			{
				$GLOBALS['%s']->pop();
				return $f1;
			}
		}break;
		case 17:
		$arr = $»t->params[0];
		{
			$a = new _hx_array(array());
			{
				$_g = 0;
				while($_g < $arr->length) {
					$e1 = $arr[$_g];
					++$_g;
					$a->push($this->expr($e1));
					unset($e1);
				}
			}
			{
				$GLOBALS['%s']->pop();
				return $a;
			}
		}break;
		case 16:
		$index = $»t->params[1]; $e1 = $»t->params[0];
		{
			$»tmp = _hx_array_get($this->expr($e1), $this->expr($index));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case 18:
		$params = $»t->params[1]; $cl = $»t->params[0];
		{
			$a = new _hx_array(array());
			{
				$_g = 0;
				while($_g < $params->length) {
					$e1 = $params[$_g];
					++$_g;
					$a->push($this->expr($e1));
					unset($e1);
				}
			}
			{
				$»tmp = $this->cnew($cl, $a);
				$GLOBALS['%s']->pop();
				return $»tmp;
			}
		}break;
		case 19:
		$e1 = $»t->params[0];
		{
			throw new HException($this->expr($e1));
		}break;
		case 20:
		$ecatch = $»t->params[3]; $n = $»t->params[1]; $e1 = $»t->params[0];
		{
			$old = $this->declared->length;
			try {
				$v = $this->expr($e1);
				$this->restore($old);
				{
					$GLOBALS['%s']->pop();
					return $v;
				}
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(($err = $_ex_) instanceof hscript__Interp_Stop){
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $»spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					throw new HException($err);
				}
				else { $err2 = $_ex_;
				{
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $»spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$this->restore($old);
					$this->declared->push(_hx_anonymous(array("n" => $n, "old" => $this->locals->get($n))));
					$this->locals->set($n, _hx_anonymous(array("r" => $err2)));
					$v = $this->expr($ecatch);
					$this->restore($old);
					{
						$GLOBALS['%s']->pop();
						return $v;
					}
				}}
			}
		}break;
		case 21:
		$fl = $»t->params[0];
		{
			$o = _hx_anonymous(array());
			{
				$_g = 0;
				while($_g < $fl->length) {
					$f = $fl[$_g];
					++$_g;
					$this->set($o, $f->name, $this->expr($f->e));
					unset($f);
				}
			}
			{
				$GLOBALS['%s']->pop();
				return $o;
			}
		}break;
		case 22:
		$e2 = $»t->params[2]; $e1 = $»t->params[1]; $econd = $»t->params[0];
		{
			$»tmp = ((_hx_equal($this->expr($econd), true)) ? $this->expr($e1) : $this->expr($e2));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function whileLoop($econd, $e) {
		$GLOBALS['%s']->push("hscript.Interp::whileLoop");
		$»spos = $GLOBALS['%s']->length;
		$old = $this->declared->length;
		while(_hx_equal($this->expr($econd), true)) {
			try {
				$this->expr($e);
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(($err = $_ex_) instanceof hscript__Interp_Stop){
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $»spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$»t = ($err);
					switch($»t->index) {
					case 1:
					{
					}break;
					case 0:
					{
						break 2;
					}break;
					case 2:
					{
						throw new HException($err);
					}break;
					}
				} else throw $»e;;
			}
			unset($err);
		}
		$this->restore($old);
		$GLOBALS['%s']->pop();
	}
	public function makeIterator($v) {
		$GLOBALS['%s']->push("hscript.Interp::makeIterator");
		$»spos = $GLOBALS['%s']->length;
		try {
			$v = $v->iterator();
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = new _hx_array(array());
				while($GLOBALS['%s']->length >= $»spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
			}
		}
		if(_hx_field($v, "hasNext") === null || _hx_field($v, "next") === null) {
			throw new HException(hscript_Error::EInvalidIterator($v));
		}
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function forLoop($n, $it, $e) {
		$GLOBALS['%s']->push("hscript.Interp::forLoop");
		$»spos = $GLOBALS['%s']->length;
		$old = $this->declared->length;
		$this->declared->push(_hx_anonymous(array("n" => $n, "old" => $this->locals->get($n))));
		$it1 = $this->makeIterator($this->expr($it));
		while($it1->hasNext()) {
			$this->locals->set($n, _hx_anonymous(array("r" => $it1->next())));
			try {
				$this->expr($e);
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(($err = $_ex_) instanceof hscript__Interp_Stop){
					$GLOBALS['%e'] = new _hx_array(array());
					while($GLOBALS['%s']->length >= $»spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$»t = ($err);
					switch($»t->index) {
					case 1:
					{
					}break;
					case 0:
					{
						break 2;
					}break;
					case 2:
					{
						throw new HException($err);
					}break;
					}
				} else throw $»e;;
			}
			unset($err);
		}
		$this->restore($old);
		$GLOBALS['%s']->pop();
	}
	public function get($o, $f) {
		$GLOBALS['%s']->push("hscript.Interp::get");
		$»spos = $GLOBALS['%s']->length;
		if($o === null) {
			throw new HException(hscript_Error::EInvalidAccess($f));
		}
		{
			$»tmp = Reflect::field($o, $f);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function set($o, $f, $v) {
		$GLOBALS['%s']->push("hscript.Interp::set");
		$»spos = $GLOBALS['%s']->length;
		if($o === null) {
			throw new HException(hscript_Error::EInvalidAccess($f));
		}
		$o->{$f} = $v;
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function call($o, $f, $args) {
		$GLOBALS['%s']->push("hscript.Interp::call");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Reflect::callMethod($o, $f, $args);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function cnew($cl, $args) {
		$GLOBALS['%s']->push("hscript.Interp::cnew");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Type::createInstance(Type::resolveClass($cl), $args);
			$GLOBALS['%s']->pop();
			return $»tmp;
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
	function __toString() { return 'hscript.Interp'; }
}
function hscript_Interp_0($e) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::new@48");
		$»spos2 = $GLOBALS['%s']->length;
		haxe_Log::trace(Std::string($e), _hx_anonymous(array("fileName" => "hscript", "lineNumber" => 0)));
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_1(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@55");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_add($me->expr($e1), $me->expr($e2));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_2(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@56");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) - $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_3(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@57");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) * $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_4(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@58");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) / $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_5(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@59");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) % $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_6(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@60");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) & $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_7(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@61");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) | $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_8(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@62");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) ^ $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_9(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@63");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) << $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_10(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@64");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) >> $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_11(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@65");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_shift_right($me->expr($e1), $me->expr($e2));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_12(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@66");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_equal($me->expr($e1), $me->expr($e2));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_13(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@67");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = !_hx_equal($me->expr($e1), $me->expr($e2));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_14(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@68");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) >= $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_15(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@69");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) <= $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_16(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@70");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) > $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_17(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@71");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->expr($e1) < $me->expr($e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_18(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@72");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_equal($me->expr($e1), true) || _hx_equal($me->expr($e2), true);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_19(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@73");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_equal($me->expr($e1), true) && _hx_equal($me->expr($e2), true);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_20(&$me, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@75");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = new IntIter($me->expr($e1), $me->expr($e2));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_21(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@76");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_add($v1, $v2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_22(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@77");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 - $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_23(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@78");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 * $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_24(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@79");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 / $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_25(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@80");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 % $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_26(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@81");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 & $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_27(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@82");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 | $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_28(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@83");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 ^ $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_29(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@84");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 << $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_30(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@85");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $v1 >> $v2;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_31(&$me, $v1, $v2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::initOps@86");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = _hx_shift_right($v1, $v2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_32(&$fop, &$me, &$op, $e1, $e2) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::assignOp@109");
		$»spos2 = $GLOBALS['%s']->length;
		{
			$»tmp = $me->evalAssignOp($op, $fop, $e1, $e2);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function hscript_Interp_33(&$»this, &$delta, &$e, &$id, &$l, &$prefix) {
	$»spos = $GLOBALS['%s']->length;
	if($l === null) {
		return $»this->variables->get($id);
	} else {
		return $l->r;
	}
}
function hscript_Interp_34(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params, $args) {
	$»spos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("hscript.Interp::expr@288");
		$»spos2 = $GLOBALS['%s']->length;
		if($args->length !== $params->length) {
			throw new HException("Invalid number of parameters");
		}
		$old = $me->locals;
		$me->locals = $me->duplicate($capturedLocals);
		{
			$_g1 = 0; $_g = $params->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$me->locals->set(_hx_array_get($params, $i)->name, _hx_anonymous(array("r" => $args[$i])));
				unset($i);
			}
		}
		$r = null;
		try {
			$r = $me->exprReturn($fexpr);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e1 = $_ex_;
			{
				$GLOBALS['%e'] = new _hx_array(array());
				while($GLOBALS['%s']->length >= $»spos2) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$me->locals = $old;
				throw new HException($e1);
			}
		}
		$me->locals = $old;
		{
			$GLOBALS['%s']->pop();
			return $r;
		}
		$GLOBALS['%s']->pop();
	}
}
