<?php

class Lambda {
	public function __construct(){}
	static function harray($it) {
		$GLOBALS['%s']->push("Lambda::array");
		$»spos = $GLOBALS['%s']->length;
		$a = new _hx_array(array());
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$i = $»it->next();
			$a->push($i);
		}
		{
			$GLOBALS['%s']->pop();
			return $a;
		}
		$GLOBALS['%s']->pop();
	}
	static function hlist($it) {
		$GLOBALS['%s']->push("Lambda::list");
		$»spos = $GLOBALS['%s']->length;
		$l = new HList();
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$i = $»it->next();
			$l->add($i);
		}
		{
			$GLOBALS['%s']->pop();
			return $l;
		}
		$GLOBALS['%s']->pop();
	}
	static function map($it, $f) {
		$GLOBALS['%s']->push("Lambda::map");
		$»spos = $GLOBALS['%s']->length;
		$l = new HList();
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$l->add(call_user_func_array($f, array($x)));
		}
		{
			$GLOBALS['%s']->pop();
			return $l;
		}
		$GLOBALS['%s']->pop();
	}
	static function mapi($it, $f) {
		$GLOBALS['%s']->push("Lambda::mapi");
		$»spos = $GLOBALS['%s']->length;
		$l = new HList();
		$i = 0;
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$l->add(call_user_func_array($f, array($i++, $x)));
		}
		{
			$GLOBALS['%s']->pop();
			return $l;
		}
		$GLOBALS['%s']->pop();
	}
	static function has($it, $elt, $cmp) {
		$GLOBALS['%s']->push("Lambda::has");
		$»spos = $GLOBALS['%s']->length;
		if($cmp === null) {
			if(null == $it) throw new HException('null iterable');
			$»it = $it->iterator();
			while($»it->hasNext()) {
				$x = $»it->next();
				if($x === $elt) {
					$GLOBALS['%s']->pop();
					return true;
				}
			}
		} else {
			if(null == $it) throw new HException('null iterable');
			$»it = $it->iterator();
			while($»it->hasNext()) {
				$x = $»it->next();
				if(call_user_func_array($cmp, array($x, $elt))) {
					$GLOBALS['%s']->pop();
					return true;
				}
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function exists($it, $f) {
		$GLOBALS['%s']->push("Lambda::exists");
		$»spos = $GLOBALS['%s']->length;
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			if(call_user_func_array($f, array($x))) {
				$GLOBALS['%s']->pop();
				return true;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	static function hforeach($it, $f) {
		$GLOBALS['%s']->push("Lambda::foreach");
		$»spos = $GLOBALS['%s']->length;
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			if(!call_user_func_array($f, array($x))) {
				$GLOBALS['%s']->pop();
				return false;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	static function iter($it, $f) {
		$GLOBALS['%s']->push("Lambda::iter");
		$»spos = $GLOBALS['%s']->length;
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			call_user_func_array($f, array($x));
		}
		$GLOBALS['%s']->pop();
	}
	static function filter($it, $f) {
		$GLOBALS['%s']->push("Lambda::filter");
		$»spos = $GLOBALS['%s']->length;
		$l = new HList();
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			if(call_user_func_array($f, array($x))) {
				$l->add($x);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $l;
		}
		$GLOBALS['%s']->pop();
	}
	static function fold($it, $f, $first) {
		$GLOBALS['%s']->push("Lambda::fold");
		$»spos = $GLOBALS['%s']->length;
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$first = call_user_func_array($f, array($x, $first));
		}
		{
			$GLOBALS['%s']->pop();
			return $first;
		}
		$GLOBALS['%s']->pop();
	}
	static function count($it, $pred) {
		$GLOBALS['%s']->push("Lambda::count");
		$»spos = $GLOBALS['%s']->length;
		$n = 0;
		if($pred === null) {
			if(null == $it) throw new HException('null iterable');
			$»it = $it->iterator();
			while($»it->hasNext()) {
				$_ = $»it->next();
				$n++;
			}
		} else {
			if(null == $it) throw new HException('null iterable');
			$»it = $it->iterator();
			while($»it->hasNext()) {
				$x = $»it->next();
				if(call_user_func_array($pred, array($x))) {
					$n++;
				}
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $n;
		}
		$GLOBALS['%s']->pop();
	}
	static function hempty($it) {
		$GLOBALS['%s']->push("Lambda::empty");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = !$it->iterator()->hasNext();
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function indexOf($it, $v) {
		$GLOBALS['%s']->push("Lambda::indexOf");
		$»spos = $GLOBALS['%s']->length;
		$i = 0;
		if(null == $it) throw new HException('null iterable');
		$»it = $it->iterator();
		while($»it->hasNext()) {
			$v2 = $»it->next();
			if($v === $v2) {
				$GLOBALS['%s']->pop();
				return $i;
			}
			$i++;
		}
		{
			$GLOBALS['%s']->pop();
			return -1;
		}
		$GLOBALS['%s']->pop();
	}
	static function concat($a, $b) {
		$GLOBALS['%s']->push("Lambda::concat");
		$»spos = $GLOBALS['%s']->length;
		$l = new HList();
		if(null == $a) throw new HException('null iterable');
		$»it = $a->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$l->add($x);
		}
		if(null == $b) throw new HException('null iterable');
		$»it = $b->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$l->add($x);
		}
		{
			$GLOBALS['%s']->pop();
			return $l;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Lambda'; }
}
