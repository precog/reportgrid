<?php

class haxe_rtti_TypeApi {
	public function __construct(){}
	static function typeInfos($t) {
		$inf = null;
		$퍁 = ($t);
		switch($퍁->index) {
		case 1:
		$c = $퍁->params[0];
		{
			$inf = $c;
		}break;
		case 2:
		$e = $퍁->params[0];
		{
			$inf = $e;
		}break;
		case 3:
		$t1 = $퍁->params[0];
		{
			$inf = $t1;
		}break;
		case 0:
		{
			throw new HException("Unexpected Package");
		}break;
		}
		return $inf;
	}
	static function isVar($t) {
		return haxe_rtti_TypeApi_0($t);
	}
	static function leq($f, $l1, $l2) {
		$it = $l2->iterator();
		if(null == $l1) throw new HException('null iterable');
		$팱t = $l1->iterator();
		while($팱t->hasNext()) {
			$e1 = $팱t->next();
			if(!$it->hasNext()) {
				return false;
			}
			$e2 = $it->next();
			if(!call_user_func_array($f, array($e1, $e2))) {
				return false;
			}
			unset($e2);
		}
		if($it->hasNext()) {
			return false;
		}
		return true;
	}
	static function rightsEq($r1, $r2) {
		if($r1 === $r2) {
			return true;
		}
		$퍁 = ($r1);
		switch($퍁->index) {
		case 2:
		$m1 = $퍁->params[0];
		{
			$퍁2 = ($r2);
			switch($퍁2->index) {
			case 2:
			$m2 = $퍁2->params[0];
			{
				return $m1 === $m2;
			}break;
			default:{
			}break;
			}
		}break;
		default:{
		}break;
		}
		return false;
	}
	static function typeEq($t1, $t2) {
		$퍁 = ($t1);
		switch($퍁->index) {
		case 0:
		{
			return $t2 === haxe_rtti_CType::$CUnknown;
		}break;
		case 1:
		$params = $퍁->params[1]; $name = $퍁->params[0];
		{
			$퍁2 = ($t2);
			switch($퍁2->index) {
			case 1:
			$params2 = $퍁2->params[1]; $name2 = $퍁2->params[0];
			{
				return $name === $name2 && haxe_rtti_TypeApi::leq((isset(haxe_rtti_TypeApi::$typeEq) ? haxe_rtti_TypeApi::$typeEq: array("haxe_rtti_TypeApi", "typeEq")), $params, $params2);
			}break;
			default:{
			}break;
			}
		}break;
		case 2:
		$params = $퍁->params[1]; $name = $퍁->params[0];
		{
			$퍁2 = ($t2);
			switch($퍁2->index) {
			case 2:
			$params2 = $퍁2->params[1]; $name2 = $퍁2->params[0];
			{
				return $name === $name2 && haxe_rtti_TypeApi::leq((isset(haxe_rtti_TypeApi::$typeEq) ? haxe_rtti_TypeApi::$typeEq: array("haxe_rtti_TypeApi", "typeEq")), $params, $params2);
			}break;
			default:{
			}break;
			}
		}break;
		case 3:
		$params = $퍁->params[1]; $name = $퍁->params[0];
		{
			$퍁2 = ($t2);
			switch($퍁2->index) {
			case 3:
			$params2 = $퍁2->params[1]; $name2 = $퍁2->params[0];
			{
				return $name === $name2 && haxe_rtti_TypeApi::leq((isset(haxe_rtti_TypeApi::$typeEq) ? haxe_rtti_TypeApi::$typeEq: array("haxe_rtti_TypeApi", "typeEq")), $params, $params2);
			}break;
			default:{
			}break;
			}
		}break;
		case 4:
		$ret = $퍁->params[1]; $args = $퍁->params[0];
		{
			$퍁2 = ($t2);
			switch($퍁2->index) {
			case 4:
			$ret2 = $퍁2->params[1]; $args2 = $퍁2->params[0];
			{
				return haxe_rtti_TypeApi::leq(array(new _hx_lambda(array(&$args, &$args2, &$ret, &$ret2, &$t1, &$t2), "haxe_rtti_TypeApi_1"), 'execute'), $args, $args2) && haxe_rtti_TypeApi::typeEq($ret, $ret2);
			}break;
			default:{
			}break;
			}
		}break;
		case 5:
		$fields = $퍁->params[0];
		{
			$퍁2 = ($t2);
			switch($퍁2->index) {
			case 5:
			$fields2 = $퍁2->params[0];
			{
				return haxe_rtti_TypeApi::leq(array(new _hx_lambda(array(&$fields, &$fields2, &$t1, &$t2), "haxe_rtti_TypeApi_2"), 'execute'), $fields, $fields2);
			}break;
			default:{
			}break;
			}
		}break;
		case 6:
		$t = $퍁->params[0];
		{
			$퍁2 = ($t2);
			switch($퍁2->index) {
			case 6:
			$t21 = $퍁2->params[0];
			{
				if(($t === null) != ($t21 === null)) {
					return false;
				}
				return $t === null || haxe_rtti_TypeApi::typeEq($t, $t21);
			}break;
			default:{
			}break;
			}
		}break;
		}
		return false;
	}
	static function fieldEq($f1, $f2) {
		if($f1->name !== $f2->name) {
			return false;
		}
		if(!haxe_rtti_TypeApi::typeEq($f1->type, $f2->type)) {
			return false;
		}
		if($f1->isPublic != $f2->isPublic) {
			return false;
		}
		if($f1->doc !== $f2->doc) {
			return false;
		}
		if(!haxe_rtti_TypeApi::rightsEq($f1->get, $f2->get)) {
			return false;
		}
		if(!haxe_rtti_TypeApi::rightsEq($f1->set, $f2->set)) {
			return false;
		}
		if(($f1->params === null) != ($f2->params === null)) {
			return false;
		}
		if($f1->params !== null && $f1->params->join(":") !== $f2->params->join(":")) {
			return false;
		}
		return true;
	}
	static function constructorEq($c1, $c2) {
		if($c1->name !== $c2->name) {
			return false;
		}
		if($c1->doc !== $c2->doc) {
			return false;
		}
		if(($c1->args === null) != ($c2->args === null)) {
			return false;
		}
		if($c1->args !== null && !haxe_rtti_TypeApi::leq(array(new _hx_lambda(array(&$c1, &$c2), "haxe_rtti_TypeApi_3"), 'execute'), $c1->args, $c2->args)) {
			return false;
		}
		return true;
	}
	function __toString() { return 'haxe.rtti.TypeApi'; }
}
function haxe_rtti_TypeApi_0(&$t) {
	$퍁 = ($t);
	switch($퍁->index) {
	case 4:
	{
		return false;
	}break;
	default:{
		return true;
	}break;
	}
}
function haxe_rtti_TypeApi_1(&$args, &$args2, &$ret, &$ret2, &$t1, &$t2, $a, $b) {
	{
		return $a->name === $b->name && $a->opt == $b->opt && haxe_rtti_TypeApi::typeEq($a->t, $b->t);
	}
}
function haxe_rtti_TypeApi_2(&$fields, &$fields2, &$t1, &$t2, $a, $b) {
	{
		return $a->name === $b->name && haxe_rtti_TypeApi::typeEq($a->t, $b->t);
	}
}
function haxe_rtti_TypeApi_3(&$c1, &$c2, $a, $b) {
	{
		return $a->name === $b->name && $a->opt == $b->opt && haxe_rtti_TypeApi::typeEq($a->t, $b->t);
	}
}
