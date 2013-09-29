<?php

class ufront_web_mvc_view_XHtmlHelperInst extends ufront_web_mvc_view_HtmlHelperInst {
	public function __construct($urlHelper) { if(!php_Boot::$skip_constructor) {
		parent::__construct($urlHelper);
	}}
	public function open($name, $attrs) {
		return "<" . $name . $this->_attrs($attrs) . ">";
	}
	public function close($name) {
		return "</" . $name . ">";
	}
	public function tag($name, $attrs) {
		return "<" . $name . $this->_attrs($attrs) . "/>";
	}
	public function _attrs($attrs) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($attrs);
			while($_g < $_g1->length) {
				$name = $_g1[$_g];
				++$_g;
				$arr->push($name . "=" . $this->_qatt(Reflect::field($attrs, $name)));
				unset($name);
			}
		}
		if($arr->length === 0) {
			return "";
		} else {
			return " " . $arr->join(" ");
		}
	}
	public function _qatt($value) {
		return "\"" . $this->attributeEncode($value) . "\"";
	}
	function __toString() { return 'ufront.web.mvc.view.XHtmlHelperInst'; }
}
