<?php

class ufront_web_mvc_view_HtmlHelperInst {
	public function __construct($urlHelper) {
		if(!php_Boot::$skip_constructor) {
		$this->__url = $urlHelper;
	}}
	public $__url;
	public function encode($s) {
		return StringTools::htmlEscape($s);
	}
	public function attributeEncode($s) {
		return str_replace("<", "&lt;", str_replace("&", "&amp;", str_replace("\"", "&quot;", $s)));
	}
	public function link($text, $url, $attrs) {
		if(null === $attrs) {
			$attrs = _hx_anonymous(array());
		}
		$attrs->href = $url;
		return $this->open("a", $attrs) . $text . $this->close("a");
	}
	public function route($text, $data, $attrs) {
		return $this->link($text, $this->__url->route($data), $attrs);
	}
	public function linkif($test, $text, $url, $attrs) {
		if(null === $attrs) {
			$attrs = _hx_anonymous(array());
		}
		if(null === $test) {
			$test = $this->__url->current(null);
		}
		if($url === $test) {
			return $this->open("span", $attrs) . $text . $this->close("span");
		} else {
			$attrs->href = $url;
			return $this->open("a", $attrs) . $text . $this->close("a");
		}
	}
	public function routeif($test, $text, $data, $attrs) {
		return $this->linkif($test, $text, $this->__url->route($data), $attrs);
	}
	public function open($name, $attrs) {
		return "<" . $name . $this->_attrs($attrs) . ">";
	}
	public function close($name) {
		return "</" . $name . ">";
	}
	public function tag($name, $attrs) {
		return "<" . $name . $this->_attrs($attrs) . ">";
	}
	public function _attrs($attrs) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($attrs);
			while($_g < $_g1->length) {
				$name = $_g1[$_g];
				++$_g;
				$value = Reflect::field($attrs, $name);
				if($value === $name) {
					$arr->push($name);
				} else {
					$arr->push($name . "=" . $this->_qatt(Reflect::field($attrs, $name)));
				}
				unset($value,$name);
			}
		}
		if($arr->length === 0) {
			return "";
		} else {
			return " " . $arr->join(" ");
		}
	}
	public function _qatt($value) {
		if(ufront_web_mvc_view_HtmlHelperInst::$WS_PATTERN->match($value)) {
			return "\"" . $this->attributeEncode($value) . "\"";
		} else {
			return $this->attributeEncode($value);
		}
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
	static $WS_PATTERN;
	function __toString() { return 'ufront.web.mvc.view.HtmlHelperInst'; }
}
ufront_web_mvc_view_HtmlHelperInst::$WS_PATTERN = new EReg("\\s", "m");
