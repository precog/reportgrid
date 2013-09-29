<?php

class hscript_Interp {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->locals = new Hash();
		$this->declared = new _hx_array(array());
		$this->variables = new Hash();
		$this->variables->set("null", null);
		$this->variables->set("true", true);
		$this->variables->set("false", false);
		$this->variables->set("trace", array(new _hx_lambda(array(), "hscript_Interp_0"), 'execute'));
		$this->initOps();
	}}
	public $variables;
	public $locals;
	public $binops;
	public $declared;
	public function initOps() {
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
	}
	public function assign($e1, $e2) {
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
		return $v;
	}
	public function assignOp($op, $fop) {
		$me = $this;
		$this->binops->set($op, array(new _hx_lambda(array(&$fop, &$me, &$op), "hscript_Interp_32"), 'execute'));
	}
	public function evalAssignOp($op, $fop, $e1, $e2) {
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
		return $v;
	}
	public function increment($e, $prefix, $delta) {
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
			return $v;
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
			return $v;
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
			return $v;
		}break;
		default:{
			throw new HException(hscript_Error::EInvalidOp((($delta > 0) ? "++" : "--")));
		}break;
		}
	}
	public function execute($expr) {
		$this->locals = new Hash();
		return $this->exprReturn($expr);
	}
	public function exprReturn($e) {
		try {
			return $this->expr($e);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e1 = $_ex_) instanceof hscript__Interp_Stop){
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
					return $v;
				}break;
				}
			} else throw $»e;;
		}
		return null;
	}
	public function duplicate($h) {
		$h2 = new Hash();
		if(null == $h) throw new HException('null iterable');
		$»it = $h->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$h2->set($k, $h->get($k));
		}
		return $h2;
	}
	public function restore($old) {
		while($this->declared->length > $old) {
			$d = $this->declared->pop();
			$this->locals->set($d->n, $d->old);
			unset($d);
		}
	}
	public function expr($e) {
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
				return $v;
			}break;
			case 3:
			$v = $»t2->params[0];
			{
				return $v;
			}break;
			case 1:
			$f = $»t2->params[0];
			{
				return $f;
			}break;
			case 2:
			$s = $»t2->params[0];
			{
				return $s;
			}break;
			}
		}break;
		case 1:
		$id = $»t->params[0];
		{
			$l = $this->locals->get($id);
			if($l !== null) {
				return $l->r;
			}
			$v = $this->variables->get($id);
			if($v === null && !$this->variables->exists($id)) {
				throw new HException(hscript_Error::EUnknownVariable($id));
			}
			return $v;
		}break;
		case 2:
		$e1 = $»t->params[2]; $n = $»t->params[0];
		{
			$this->declared->push(_hx_anonymous(array("n" => $n, "old" => $this->locals->get($n))));
			$this->locals->set($n, _hx_anonymous(array("r" => (($e1 === null) ? null : $this->expr($e1)))));
			return null;
		}break;
		case 3:
		$e1 = $»t->params[0];
		{
			return $this->expr($e1);
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
			return $v;
		}break;
		case 5:
		$f = $»t->params[1]; $e1 = $»t->params[0];
		{
			return $this->get($this->expr($e1), $f);
		}break;
		case 6:
		$e2 = $»t->params[2]; $e1 = $»t->params[1]; $op = $»t->params[0];
		{
			$fop = $this->binops->get($op);
			if($fop === null) {
				throw new HException(hscript_Error::EInvalidOp($op));
			}
			return call_user_func_array($fop, array($e1, $e2));
		}break;
		case 7:
		$e1 = $»t->params[2]; $prefix = $»t->params[1]; $op = $»t->params[0];
		{
			switch($op) {
			case "!":{
				return !_hx_equal($this->expr($e1), true);
			}break;
			case "-":{
				return -$this->expr($e1);
			}break;
			case "++":{
				return $this->increment($e1, $prefix, 1);
			}break;
			case "--":{
				return $this->increment($e1, $prefix, -1);
			}break;
			case "~":{
				return ~$this->expr($e1);
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
				return $this->call($obj, Reflect::field($obj, $f), $args);
			}break;
			default:{
				return $this->call(null, $this->expr($e1), $args);
			}break;
			}
		}break;
		case 9:
		$e2 = $»t->params[2]; $e1 = $»t->params[1]; $econd = $»t->params[0];
		{
			return ((_hx_equal($this->expr($econd), true)) ? $this->expr($e1) : (($e2 === null) ? null : $this->expr($e2)));
		}break;
		case 10:
		$e1 = $»t->params[1]; $econd = $»t->params[0];
		{
			$this->whileLoop($econd, $e1);
			return null;
		}break;
		case 11:
		$e1 = $»t->params[2]; $it = $»t->params[1]; $v = $»t->params[0];
		{
			$this->forLoop($v, $it, $e1);
			return null;
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
			return $f1;
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
			return $a;
		}break;
		case 16:
		$index = $»t->params[1]; $e1 = $»t->params[0];
		{
			return _hx_array_get($this->expr($e1), $this->expr($index));
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
			return $this->cnew($cl, $a);
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
				return $v;
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(($err = $_ex_) instanceof hscript__Interp_Stop){
					throw new HException($err);
				}
				else { $err2 = $_ex_;
				{
					$this->restore($old);
					$this->declared->push(_hx_anonymous(array("n" => $n, "old" => $this->locals->get($n))));
					$this->locals->set($n, _hx_anonymous(array("r" => $err2)));
					$v = $this->expr($ecatch);
					$this->restore($old);
					return $v;
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
			return $o;
		}break;
		case 22:
		$e2 = $»t->params[2]; $e1 = $»t->params[1]; $econd = $»t->params[0];
		{
			return ((_hx_equal($this->expr($econd), true)) ? $this->expr($e1) : $this->expr($e2));
		}break;
		}
		return null;
	}
	public function whileLoop($econd, $e) {
		$old = $this->declared->length;
		while(_hx_equal($this->expr($econd), true)) {
			try {
				$this->expr($e);
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				if(($err = $_ex_) instanceof hscript__Interp_Stop){
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
	}
	public function makeIterator($v) {
		try {
			$v = $v->iterator();
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
			}
		}
		if(_hx_field($v, "hasNext") === null || _hx_field($v, "next") === null) {
			throw new HException(hscript_Error::EInvalidIterator($v));
		}
		return $v;
	}
	public function forLoop($n, $it, $e) {
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
	}
	public function get($o, $f) {
		if($o === null) {
			throw new HException(hscript_Error::EInvalidAccess($f));
		}
		return Reflect::field($o, $f);
	}
	public function set($o, $f, $v) {
		if($o === null) {
			throw new HException(hscript_Error::EInvalidAccess($f));
		}
		$o->{$f} = $v;
		return $v;
	}
	public function call($o, $f, $args) {
		return Reflect::callMethod($o, $f, $args);
	}
	public function cnew($cl, $args) {
		return Type::createInstance(Type::resolveClass($cl), $args);
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
	{
		haxe_Log::trace(Std::string($e), _hx_anonymous(array("fileName" => "hscript", "lineNumber" => 0)));
	}
}
function hscript_Interp_1(&$me, $e1, $e2) {
	{
		return _hx_add($me->expr($e1), $me->expr($e2));
	}
}
function hscript_Interp_2(&$me, $e1, $e2) {
	{
		return $me->expr($e1) - $me->expr($e2);
	}
}
function hscript_Interp_3(&$me, $e1, $e2) {
	{
		return $me->expr($e1) * $me->expr($e2);
	}
}
function hscript_Interp_4(&$me, $e1, $e2) {
	{
		return $me->expr($e1) / $me->expr($e2);
	}
}
function hscript_Interp_5(&$me, $e1, $e2) {
	{
		return $me->expr($e1) % $me->expr($e2);
	}
}
function hscript_Interp_6(&$me, $e1, $e2) {
	{
		return $me->expr($e1) & $me->expr($e2);
	}
}
function hscript_Interp_7(&$me, $e1, $e2) {
	{
		return $me->expr($e1) | $me->expr($e2);
	}
}
function hscript_Interp_8(&$me, $e1, $e2) {
	{
		return $me->expr($e1) ^ $me->expr($e2);
	}
}
function hscript_Interp_9(&$me, $e1, $e2) {
	{
		return $me->expr($e1) << $me->expr($e2);
	}
}
function hscript_Interp_10(&$me, $e1, $e2) {
	{
		return $me->expr($e1) >> $me->expr($e2);
	}
}
function hscript_Interp_11(&$me, $e1, $e2) {
	{
		return _hx_shift_right($me->expr($e1), $me->expr($e2));
	}
}
function hscript_Interp_12(&$me, $e1, $e2) {
	{
		return _hx_equal($me->expr($e1), $me->expr($e2));
	}
}
function hscript_Interp_13(&$me, $e1, $e2) {
	{
		return !_hx_equal($me->expr($e1), $me->expr($e2));
	}
}
function hscript_Interp_14(&$me, $e1, $e2) {
	{
		return $me->expr($e1) >= $me->expr($e2);
	}
}
function hscript_Interp_15(&$me, $e1, $e2) {
	{
		return $me->expr($e1) <= $me->expr($e2);
	}
}
function hscript_Interp_16(&$me, $e1, $e2) {
	{
		return $me->expr($e1) > $me->expr($e2);
	}
}
function hscript_Interp_17(&$me, $e1, $e2) {
	{
		return $me->expr($e1) < $me->expr($e2);
	}
}
function hscript_Interp_18(&$me, $e1, $e2) {
	{
		return _hx_equal($me->expr($e1), true) || _hx_equal($me->expr($e2), true);
	}
}
function hscript_Interp_19(&$me, $e1, $e2) {
	{
		return _hx_equal($me->expr($e1), true) && _hx_equal($me->expr($e2), true);
	}
}
function hscript_Interp_20(&$me, $e1, $e2) {
	{
		return new IntIter($me->expr($e1), $me->expr($e2));
	}
}
function hscript_Interp_21(&$me, $v1, $v2) {
	{
		return _hx_add($v1, $v2);
	}
}
function hscript_Interp_22(&$me, $v1, $v2) {
	{
		return $v1 - $v2;
	}
}
function hscript_Interp_23(&$me, $v1, $v2) {
	{
		return $v1 * $v2;
	}
}
function hscript_Interp_24(&$me, $v1, $v2) {
	{
		return $v1 / $v2;
	}
}
function hscript_Interp_25(&$me, $v1, $v2) {
	{
		return $v1 % $v2;
	}
}
function hscript_Interp_26(&$me, $v1, $v2) {
	{
		return $v1 & $v2;
	}
}
function hscript_Interp_27(&$me, $v1, $v2) {
	{
		return $v1 | $v2;
	}
}
function hscript_Interp_28(&$me, $v1, $v2) {
	{
		return $v1 ^ $v2;
	}
}
function hscript_Interp_29(&$me, $v1, $v2) {
	{
		return $v1 << $v2;
	}
}
function hscript_Interp_30(&$me, $v1, $v2) {
	{
		return $v1 >> $v2;
	}
}
function hscript_Interp_31(&$me, $v1, $v2) {
	{
		return _hx_shift_right($v1, $v2);
	}
}
function hscript_Interp_32(&$fop, &$me, &$op, $e1, $e2) {
	{
		return $me->evalAssignOp($op, $fop, $e1, $e2);
	}
}
function hscript_Interp_33(&$»this, &$delta, &$e, &$id, &$l, &$prefix) {
	if($l === null) {
		return $»this->variables->get($id);
	} else {
		return $l->r;
	}
}
function hscript_Interp_34(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params, $args) {
	{
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
				$me->locals = $old;
				throw new HException($e1);
			}
		}
		$me->locals = $old;
		return $r;
	}
}
