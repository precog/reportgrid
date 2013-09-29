<?php

class ufront_web_mvc_view_TemplateHelper implements ufront_web_mvc_IViewHelper{
	public function __construct($context, $template) {
		if(!php_Boot::$skip_constructor) {
		$this->context = $context;
		$this->template = $template;
	}}
	public $context;
	public $template;
	public function get($key, $alt) {
		if(null === $alt) {
			$alt = "";
		}
		$hash = $this->template->data();
		return (($hash->exists($key)) ? $hash->get($key) : $alt);
	}
	public function routeData() {
		return Hashes::toDynamic($this->context->routeData->data);
	}
	public function exists($key) {
		return $this->template->data()->exists($key);
	}
	public function set($key, $value) {
		$this->template->data()->set($key, $value);
	}
	public function has($value, $key) {
		return _hx_has_field($value, $key);
	}
	public function notempty($key) {
		$v = $this->template->data()->get($key);
		if($v === null || _hx_equal($v, "")) {
			return false;
		} else {
			if(Std::is($v, _hx_qtype("Array"))) {
				return _hx_len($v) > 0;
			} else {
				if(Std::is($v, _hx_qtype("Bool"))) {
					return $v;
				} else {
					return true;
				}
			}
		}
	}
	public function push($varname, $element) {
		$hash = $this->template->data();
		$arr = $hash->get($varname);
		if(null === $arr) {
			$arr = new _hx_array(array());
			$hash->set($varname, $arr);
		}
		$arr->push($element);
	}
	public function unshift($varname, $element) {
		$hash = $this->template->data();
		$arr = $hash->get($varname);
		if(null === $arr) {
			$arr = new _hx_array(array());
			$hash->set($varname, $arr);
		}
		$arr->unshift($element);
	}
	public function wrap($templatepath, $contentvar) {
		if(null === $contentvar) {
			$contentvar = "layoutContent";
		}
		$engine = $this->context->viewEngine;
		$t = $engine->getTemplate($this->context->controllerContext, $templatepath);
		if(null === $t) {
			throw new HException(new thx_error_Error("the wrap template '{0}' does not exist", null, $templatepath, _hx_anonymous(array("fileName" => "TemplateHelper.hx", "lineNumber" => 92, "className" => "ufront.web.mvc.view.TemplateHelper", "methodName" => "wrap"))));
		}
		$this->template->wrappers->set($contentvar, $t);
		return "";
	}
	public function hinclude($templatepath, $data) {
		$engine = $this->context->viewEngine;
		$t = $engine->getTemplate($this->context->controllerContext, $templatepath);
		if(null === $t) {
			throw new HException(new thx_error_Error("the include template '{0}' does not exist", null, $templatepath, _hx_anonymous(array("fileName" => "TemplateHelper.hx", "lineNumber" => 104, "className" => "ufront.web.mvc.view.TemplateHelper", "methodName" => "include"))));
		}
		$variables = $this->template->data();
		$restore = ufront_web_mvc_view_TemplateHelper_0($this, $data, $engine, $t, $templatepath, $variables);
		$result = $this->template->executeTemplate($t, $variables);
		call_user_func($restore);
		return $result;
	}
	public function merge($dst, $src) {
		if(null === $src) {
			$src = $this->routeData();
		}
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				if(!_hx_has_field($dst, $key)) {
					$dst->{$key} = Reflect::field($src, $key);
				}
				unset($key);
			}
		}
		return $dst;
	}
	public function register($data) {
		$data->set("get", (isset($this->get) ? $this->get: array($this, "get")));
		$data->set("set", (isset($this->set) ? $this->set: array($this, "set")));
		$data->set("exists", (isset($this->exists) ? $this->exists: array($this, "exists")));
		$data->set("has", (isset($this->has) ? $this->has: array($this, "has")));
		$data->set("include", (isset($this->hinclude) ? $this->hinclude: array($this, "hinclude")));
		$data->set("notempty", (isset($this->notempty) ? $this->notempty: array($this, "notempty")));
		$data->set("push", (isset($this->push) ? $this->push: array($this, "push")));
		$data->set("unshift", (isset($this->unshift) ? $this->unshift: array($this, "unshift")));
		$data->set("wrap", (isset($this->wrap) ? $this->wrap: array($this, "wrap")));
		$data->set("routeData", (isset($this->routeData) ? $this->routeData: array($this, "routeData")));
		$data->set("merge", (isset($this->merge) ? $this->merge: array($this, "merge")));
		$data->set("now", Date::now());
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
	function __toString() { return 'ufront.web.mvc.view.TemplateHelper'; }
}
function ufront_web_mvc_view_TemplateHelper_0(&$»this, &$data, &$engine, &$t, &$templatepath, &$variables) {
	if(null !== $data) {
		$old = new Hash();
		$toremove = new thx_collection_Set();
		$fields = Reflect::fields($data);
		{
			$_g = 0;
			while($_g < $fields->length) {
				$field = $fields[$_g];
				++$_g;
				$value = $variables->get($field);
				if(null !== $value) {
					$old->set($field, $value);
				} else {
					$toremove->add($field);
				}
				$variables->set($field, Reflect::field($data, $field));
				unset($value,$field);
			}
		}
		return array(new _hx_lambda(array(&$data, &$engine, &$fields, &$old, &$t, &$templatepath, &$toremove, &$variables), "ufront_web_mvc_view_TemplateHelper_1"), 'execute');
	} else {
		return array(new _hx_lambda(array(&$data, &$engine, &$t, &$templatepath, &$variables), "ufront_web_mvc_view_TemplateHelper_2"), 'execute');
	}
}
function ufront_web_mvc_view_TemplateHelper_1(&$data, &$engine, &$fields, &$old, &$t, &$templatepath, &$toremove, &$variables) {
	{
		if(null == $toremove) throw new HException('null iterable');
		$»it = $toremove->iterator();
		while($»it->hasNext()) {
			$key = $»it->next();
			$variables->remove($key);
		}
		if(null == $old) throw new HException('null iterable');
		$»it = $old->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			$variables->set($key, $old->get($key));
		}
	}
}
function ufront_web_mvc_view_TemplateHelper_2(&$data, &$engine, &$t, &$templatepath, &$variables) {
	{
	}
}
