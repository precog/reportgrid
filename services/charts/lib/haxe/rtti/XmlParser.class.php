<?php

class haxe_rtti_XmlParser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->root = new _hx_array(array());
	}}
	public $root;
	public $curplatform;
	public function sort($l) {
		if($l === null) {
			$l = $this->root;
		}
		$l->sort(array(new _hx_lambda(array(&$l), "haxe_rtti_XmlParser_0"), 'execute'));
		{
			$_g = 0;
			while($_g < $l->length) {
				$x = $l[$_g];
				++$_g;
				$»t = ($x);
				switch($»t->index) {
				case 0:
				$l1 = $»t->params[2];
				{
					$this->sort($l1);
				}break;
				case 1:
				$c = $»t->params[0];
				{
					$c->fields = $this->sortFields($c->fields);
					$c->statics = $this->sortFields($c->statics);
				}break;
				case 2:
				$e = $»t->params[0];
				{
				}break;
				case 3:
				{
				}break;
				}
				unset($x);
			}
		}
	}
	public function sortFields($fl) {
		$a = Lambda::harray($fl);
		$a->sort(array(new _hx_lambda(array(&$a, &$fl), "haxe_rtti_XmlParser_1"), 'execute'));
		return Lambda::hlist($a);
	}
	public function process($x, $platform) {
		$this->curplatform = $platform;
		$this->xroot(new haxe_xml_Fast($x));
	}
	public function mergeRights($f1, $f2) {
		if($f1->get == haxe_rtti_Rights::$RInline && $f1->set == haxe_rtti_Rights::$RNo && $f2->get == haxe_rtti_Rights::$RNormal && $f2->set == haxe_rtti_Rights::$RMethod) {
			$f1->get = haxe_rtti_Rights::$RNormal;
			$f1->set = haxe_rtti_Rights::$RMethod;
			return true;
		}
		return false;
	}
	public function mergeFields($f, $f2) {
		return haxe_rtti_TypeApi::fieldEq($f, $f2) || $f->name === $f2->name && ($this->mergeRights($f, $f2) || $this->mergeRights($f2, $f)) && haxe_rtti_TypeApi::fieldEq($f, $f2);
	}
	public function mergeClasses($c, $c2) {
		if($c->isInterface != $c2->isInterface) {
			return false;
		}
		if($this->curplatform !== null) {
			$c->platforms->add($this->curplatform);
		}
		if($c->isExtern != $c2->isExtern) {
			$c->isExtern = false;
		}
		if(null == $c2->fields) throw new HException('null iterable');
		$»it = $c2->fields->iterator();
		while($»it->hasNext()) {
			$f2 = $»it->next();
			$found = null;
			if(null == $c->fields) throw new HException('null iterable');
			$»it2 = $c->fields->iterator();
			while($»it2->hasNext()) {
				$f = $»it2->next();
				if($this->mergeFields($f, $f2)) {
					$found = $f;
					break;
				}
			}
			if($found === null) {
				$c->fields->add($f2);
			} else {
				if($this->curplatform !== null) {
					$found->platforms->add($this->curplatform);
				}
			}
			unset($found);
		}
		if(null == $c2->statics) throw new HException('null iterable');
		$»it = $c2->statics->iterator();
		while($»it->hasNext()) {
			$f2 = $»it->next();
			$found = null;
			if(null == $c->statics) throw new HException('null iterable');
			$»it2 = $c->statics->iterator();
			while($»it2->hasNext()) {
				$f = $»it2->next();
				if($this->mergeFields($f, $f2)) {
					$found = $f;
					break;
				}
			}
			if($found === null) {
				$c->statics->add($f2);
			} else {
				if($this->curplatform !== null) {
					$found->platforms->add($this->curplatform);
				}
			}
			unset($found);
		}
		return true;
	}
	public function mergeEnums($e, $e2) {
		if($e->isExtern != $e2->isExtern) {
			return false;
		}
		if($this->curplatform !== null) {
			$e->platforms->add($this->curplatform);
		}
		if(null == $e2->constructors) throw new HException('null iterable');
		$»it = $e2->constructors->iterator();
		while($»it->hasNext()) {
			$c2 = $»it->next();
			$found = null;
			if(null == $e->constructors) throw new HException('null iterable');
			$»it2 = $e->constructors->iterator();
			while($»it2->hasNext()) {
				$c = $»it2->next();
				if(haxe_rtti_TypeApi::constructorEq($c, $c2)) {
					$found = $c;
					break;
				}
			}
			if($found === null) {
				return false;
			}
			if($this->curplatform !== null) {
				$found->platforms->add($this->curplatform);
			}
			unset($found);
		}
		return true;
	}
	public function mergeTypedefs($t, $t2) {
		if($this->curplatform === null) {
			return false;
		}
		$t->platforms->add($this->curplatform);
		$t->types->set($this->curplatform, $t2->type);
		return true;
	}
	public function merge($t) {
		$inf = haxe_rtti_TypeApi::typeInfos($t);
		$pack = _hx_explode(".", $inf->path);
		$cur = $this->root;
		$curpack = new _hx_array(array());
		$pack->pop();
		{
			$_g = 0;
			while($_g < $pack->length) {
				$p = $pack[$_g];
				++$_g;
				$found = false;
				{
					$_g1 = 0;
					while($_g1 < $cur->length) {
						$pk = $cur[$_g1];
						++$_g1;
						$»t = ($pk);
						switch($»t->index) {
						case 0:
						$subs = $»t->params[2]; $pname = $»t->params[0];
						{
							if($pname === $p) {
								$found = true;
								$cur = $subs;
								break 2;
							}
						}break;
						default:{
						}break;
						}
						unset($pk);
					}
					unset($_g1);
				}
				$curpack->push($p);
				if(!$found) {
					$pk = new _hx_array(array());
					$cur->push(haxe_rtti_TypeTree::TPackage($p, $curpack->join("."), $pk));
					$cur = $pk;
					unset($pk);
				}
				unset($p,$found);
			}
		}
		$prev = null;
		{
			$_g = 0;
			while($_g < $cur->length) {
				$ct = $cur[$_g];
				++$_g;
				$tinf = null;
				try {
					$tinf = haxe_rtti_TypeApi::typeInfos($ct);
				}catch(Exception $»e) {
					$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
					$e = $_ex_;
					{
						continue;
					}
				}
				if($tinf->path === $inf->path) {
					$sameType = true;
					if(($tinf->doc === null) != ($inf->doc === null)) {
						if($inf->doc === null) {
							$inf->doc = $tinf->doc;
						} else {
							$tinf->doc = $inf->doc;
						}
					}
					if($tinf->module === $inf->module && $tinf->doc === $inf->doc && $tinf->isPrivate == $inf->isPrivate) {
						$»t = ($ct);
						switch($»t->index) {
						case 1:
						$c = $»t->params[0];
						{
							$»t2 = ($t);
							switch($»t2->index) {
							case 1:
							$c2 = $»t2->params[0];
							{
								if($this->mergeClasses($c, $c2)) {
									return;
								}
							}break;
							default:{
								$sameType = false;
							}break;
							}
						}break;
						case 2:
						$e2 = $»t->params[0];
						{
							$»t2 = ($t);
							switch($»t2->index) {
							case 2:
							$e22 = $»t2->params[0];
							{
								if($this->mergeEnums($e2, $e22)) {
									return;
								}
							}break;
							default:{
								$sameType = false;
							}break;
							}
						}break;
						case 3:
						$td = $»t->params[0];
						{
							$»t2 = ($t);
							switch($»t2->index) {
							case 3:
							$td2 = $»t2->params[0];
							{
								if($this->mergeTypedefs($td, $td2)) {
									return;
								}
							}break;
							default:{
							}break;
							}
						}break;
						case 0:
						{
							$sameType = false;
						}break;
						}
					}
					$msg = haxe_rtti_XmlParser_2($this, $_g, $ct, $cur, $curpack, $e, $inf, $pack, $prev, $sameType, $t, $tinf);
					throw new HException("Incompatibilities between " . $tinf->path . " in " . $tinf->platforms->join(",") . " and " . $this->curplatform . " (" . $msg . ")");
					unset($sameType,$msg);
				}
				unset($tinf,$e,$ct);
			}
		}
		$cur->push($t);
	}
	public function mkPath($p) {
		return $p;
	}
	public function mkTypeParams($p) {
		$pl = _hx_explode(":", $p);
		if($pl[0] === "") {
			return new _hx_array(array());
		}
		return $pl;
	}
	public function mkRights($r) {
		return haxe_rtti_XmlParser_3($this, $r);
	}
	public function xerror($c) {
		haxe_rtti_XmlParser_4($this, $c);
	}
	public function xroot($x) {
		if(null == $x->x) throw new HException('null iterable');
		$»it = $x->x->elements();
		while($»it->hasNext()) {
			$c = $»it->next();
			$this->merge($this->processElement($c));
		}
	}
	public function processElement($x) {
		$c = new haxe_xml_Fast($x);
		return haxe_rtti_XmlParser_5($this, $c, $x);
	}
	public function xpath($x) {
		$path = $this->mkPath($x->att->resolve("path"));
		$params = new HList();
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$c = $»it->next();
			$params->add($this->xtype($c));
		}
		return _hx_anonymous(array("path" => $path, "params" => $params));
	}
	public function xclass($x) {
		$csuper = null;
		$doc = null;
		$tdynamic = null;
		$interfaces = new HList();
		$fields = new HList();
		$statics = new HList();
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$c = $»it->next();
			switch($c->getName()) {
			case "haxe_doc":{
				$doc = $c->getInnerData();
			}break;
			case "extends":{
				$csuper = $this->xpath($c);
			}break;
			case "implements":{
				$interfaces->add($this->xpath($c));
			}break;
			case "haxe_dynamic":{
				$tdynamic = $this->xtype(new haxe_xml_Fast($c->x->firstElement()));
			}break;
			default:{
				if($c->x->exists("static")) {
					$statics->add($this->xclassfield($c));
				} else {
					$fields->add($this->xclassfield($c));
				}
			}break;
			}
		}
		return _hx_anonymous(array("path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "isExtern" => $x->x->exists("extern"), "isInterface" => $x->x->exists("interface"), "params" => $this->mkTypeParams($x->att->resolve("params")), "superClass" => $csuper, "interfaces" => $interfaces, "fields" => $fields, "statics" => $statics, "tdynamic" => $tdynamic, "platforms" => $this->defplat()));
	}
	public function xclassfield($x) {
		$e = $x->getElements();
		$t = $this->xtype($e->next());
		$doc = null;
		$»it = $e;
		while($»it->hasNext()) {
			$c = $»it->next();
			switch($c->getName()) {
			case "haxe_doc":{
				$doc = $c->getInnerData();
			}break;
			default:{
				$this->xerror($c);
			}break;
			}
		}
		return _hx_anonymous(array("name" => $x->getName(), "type" => $t, "isPublic" => $x->x->exists("public"), "isOverride" => $x->x->exists("override"), "doc" => $doc, "get" => (($x->has->resolve("get")) ? $this->mkRights($x->att->resolve("get")) : haxe_rtti_Rights::$RNormal), "set" => (($x->has->resolve("set")) ? $this->mkRights($x->att->resolve("set")) : haxe_rtti_Rights::$RNormal), "params" => (($x->has->resolve("params")) ? $this->mkTypeParams($x->att->resolve("params")) : null), "platforms" => $this->defplat()));
	}
	public function xenum($x) {
		$cl = new HList();
		$doc = null;
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$c = $»it->next();
			if($c->getName() === "haxe_doc") {
				$doc = $c->getInnerData();
			} else {
				$cl->add($this->xenumfield($c));
			}
		}
		return _hx_anonymous(array("path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "isExtern" => $x->x->exists("extern"), "params" => $this->mkTypeParams($x->att->resolve("params")), "constructors" => $cl, "platforms" => $this->defplat()));
	}
	public function xenumfield($x) {
		$args = null;
		$xdoc = $x->x->elementsNamed("haxe_doc")->next();
		if($x->has->resolve("a")) {
			$names = _hx_explode(":", $x->att->resolve("a"));
			$elts = $x->getElements();
			$args = new HList();
			{
				$_g = 0;
				while($_g < $names->length) {
					$c = $names[$_g];
					++$_g;
					$opt = false;
					if(_hx_char_at($c, 0) === "?") {
						$opt = true;
						$c = _hx_substr($c, 1, null);
					}
					$args->add(_hx_anonymous(array("name" => $c, "opt" => $opt, "t" => $this->xtype($elts->next()))));
					unset($opt,$c);
				}
			}
		}
		return _hx_anonymous(array("name" => $x->getName(), "args" => $args, "doc" => (($xdoc === null) ? null : _hx_deref(new haxe_xml_Fast($xdoc))->getInnerData()), "platforms" => $this->defplat()));
	}
	public function xtypedef($x) {
		$doc = null;
		$t = null;
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$c = $»it->next();
			if($c->getName() === "haxe_doc") {
				$doc = $c->getInnerData();
			} else {
				$t = $this->xtype($c);
			}
		}
		$types = new Hash();
		if($this->curplatform !== null) {
			$types->set($this->curplatform, $t);
		}
		return _hx_anonymous(array("path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "params" => $this->mkTypeParams($x->att->resolve("params")), "type" => $t, "types" => $types, "platforms" => $this->defplat()));
	}
	public function xtype($x) {
		return haxe_rtti_XmlParser_6($this, $x);
	}
	public function xtypeparams($x) {
		$p = new HList();
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$c = $»it->next();
			$p->add($this->xtype($c));
		}
		return $p;
	}
	public function defplat() {
		$l = new HList();
		if($this->curplatform !== null) {
			$l->add($this->curplatform);
		}
		return $l;
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
	function __toString() { return 'haxe.rtti.XmlParser'; }
}
function haxe_rtti_XmlParser_0(&$l, $e1, $e2) {
	{
		$n1 = haxe_rtti_XmlParser_7($»this, $e1, $e2, $l);
		$n2 = haxe_rtti_XmlParser_8($»this, $e1, $e2, $l, $n1);
		if($n1 > $n2) {
			return 1;
		}
		return -1;
	}
}
function haxe_rtti_XmlParser_1(&$a, &$fl, $f1, $f2) {
	{
		$v1 = haxe_rtti_TypeApi::isVar($f1->type);
		$v2 = haxe_rtti_TypeApi::isVar($f2->type);
		if($v1 && !$v2) {
			return -1;
		}
		if($v2 && !$v1) {
			return 1;
		}
		if($f1->name === "new") {
			return -1;
		}
		if($f2->name === "new") {
			return 1;
		}
		if($f1->name > $f2->name) {
			return 1;
		}
		return -1;
	}
}
function haxe_rtti_XmlParser_2(&$»this, &$_g, &$ct, &$cur, &$curpack, &$e, &$inf, &$pack, &$prev, &$sameType, &$t, &$tinf) {
	if($tinf->module !== $inf->module) {
		return "module " . $inf->module . " should be " . $tinf->module;
	} else {
		if($tinf->doc !== $inf->doc) {
			return "documentation is different";
		} else {
			if($tinf->isPrivate != $inf->isPrivate) {
				return "private flag is different";
			} else {
				if(!$sameType) {
					return "type kind is different";
				} else {
					return "could not merge definition";
				}
			}
		}
	}
}
function haxe_rtti_XmlParser_3(&$»this, &$r) {
	switch($r) {
	case "null":{
		return haxe_rtti_Rights::$RNo;
	}break;
	case "method":{
		return haxe_rtti_Rights::$RMethod;
	}break;
	case "dynamic":{
		return haxe_rtti_Rights::$RDynamic;
	}break;
	case "inline":{
		return haxe_rtti_Rights::$RInline;
	}break;
	default:{
		return haxe_rtti_Rights::RCall($r);
	}break;
	}
}
function haxe_rtti_XmlParser_4(&$»this, &$c) {
	throw new HException("Invalid " . $c->getName());
}
function haxe_rtti_XmlParser_5(&$»this, &$c, &$x) {
	switch($c->getName()) {
	case "class":{
		return haxe_rtti_TypeTree::TClassdecl($»this->xclass($c));
	}break;
	case "enum":{
		return haxe_rtti_TypeTree::TEnumdecl($»this->xenum($c));
	}break;
	case "typedef":{
		return haxe_rtti_TypeTree::TTypedecl($»this->xtypedef($c));
	}break;
	default:{
		return $»this->xerror($c);
	}break;
	}
}
function haxe_rtti_XmlParser_6(&$»this, &$x) {
	switch($x->getName()) {
	case "unknown":{
		return haxe_rtti_CType::$CUnknown;
	}break;
	case "e":{
		return haxe_rtti_CType::CEnum($»this->mkPath($x->att->resolve("path")), $»this->xtypeparams($x));
	}break;
	case "c":{
		return haxe_rtti_CType::CClass($»this->mkPath($x->att->resolve("path")), $»this->xtypeparams($x));
	}break;
	case "t":{
		return haxe_rtti_CType::CTypedef($»this->mkPath($x->att->resolve("path")), $»this->xtypeparams($x));
	}break;
	case "f":{
		$args = new HList();
		$aname = _hx_explode(":", $x->att->resolve("a"));
		$eargs = $aname->iterator();
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$e = $»it->next();
			$opt = false;
			$a = $eargs->next();
			if($a === null) {
				$a = "";
			}
			if(_hx_char_at($a, 0) === "?") {
				$opt = true;
				$a = _hx_substr($a, 1, null);
			}
			$args->add(_hx_anonymous(array("name" => $a, "opt" => $opt, "t" => $»this->xtype($e))));
			unset($opt,$a);
		}
		$ret = $args->last();
		$args->remove($ret);
		return haxe_rtti_CType::CFunction($args, $ret->t);
	}break;
	case "a":{
		$fields = new HList();
		if(null == $x) throw new HException('null iterable');
		$»it = $x->getElements();
		while($»it->hasNext()) {
			$f = $»it->next();
			$fields->add(_hx_anonymous(array("name" => $f->getName(), "t" => $»this->xtype(new haxe_xml_Fast($f->x->firstElement())))));
		}
		return haxe_rtti_CType::CAnonymous($fields);
	}break;
	case "d":{
		$t = null;
		$tx = $x->x->firstElement();
		if($tx !== null) {
			$t = $»this->xtype(new haxe_xml_Fast($tx));
		}
		return haxe_rtti_CType::CDynamic($t);
	}break;
	default:{
		return $»this->xerror($x);
	}break;
	}
}
function haxe_rtti_XmlParser_7(&$»this, &$e1, &$e2, &$l) {
	$»t = ($e1);
	switch($»t->index) {
	case 0:
	$p = $»t->params[0];
	{
		return " " . $p;
	}break;
	default:{
		return haxe_rtti_TypeApi::typeInfos($e1)->path;
	}break;
	}
}
function haxe_rtti_XmlParser_8(&$»this, &$e1, &$e2, &$l, &$n1) {
	$»t = ($e2);
	switch($»t->index) {
	case 0:
	$p = $»t->params[0];
	{
		return " " . $p;
	}break;
	default:{
		return haxe_rtti_TypeApi::typeInfos($e2)->path;
	}break;
	}
}
