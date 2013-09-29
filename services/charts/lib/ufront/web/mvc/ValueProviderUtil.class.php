<?php

class ufront_web_mvc_ValueProviderUtil {
	public function __construct(){}
	static function getPrefixes($key) {
		$output = new _hx_array(array($key));
		$length = strlen($key);
		{
			$_g = 0;
			while($_g < $length) {
				$i = $_g++;
				$char = _hx_char_at($key, $length - $i);
				if($char === "." || $char === "[") {
					$output->push(_hx_substr($key, 0, $length - $i));
				}
				unset($i,$char);
			}
		}
		return $output;
	}
	function __toString() { return 'ufront.web.mvc.ValueProviderUtil'; }
}
