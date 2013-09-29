<?php

class ufront_web_mvc_ValueProviderCollection extends HList implements ufront_web_mvc_IValueProvider{
	public function __construct($list) { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		if($list !== null) {
			$_g = 0;
			while($_g < $list->length) {
				$v = $list[$_g];
				++$_g;
				$this->add($v);
				unset($v);
			}
		}
	}}
	public function containsPrefix($prefix) {
		if(null == $this) throw new HException('null iterable');
		$»it = $this->iterator();
		while($»it->hasNext()) {
			$v = $»it->next();
			if($v->containsPrefix($prefix)) {
				return true;
			}
		}
		return false;
	}
	public function getValue($key) {
		if(null == $this) throw new HException('null iterable');
		$»it = $this->iterator();
		while($»it->hasNext()) {
			$v = $»it->next();
			$output = $v->getValue($key);
			if($output !== null) {
				return $output;
			}
			unset($output);
		}
		return null;
	}
	function __toString() { return 'ufront.web.mvc.ValueProviderCollection'; }
}
