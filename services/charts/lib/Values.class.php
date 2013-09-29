<?php

class Values {
	public function __construct(){}
	static function alt($value, $altValue) {
		return ((null === $value) ? $altValue : $value);
	}
	function __toString() { return 'Values'; }
}
