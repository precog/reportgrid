<?php

class DynamicsT {
	public function __construct(){}
	static function toHash($ob) {
		$hash = new Hash();
		return DynamicsT::copyToHash($ob, $hash);
	}
	static function copyToHash($ob, $hash) {
		{
			$_g = 0; $_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$hash->set($field, Reflect::field($ob, $field));
				unset($field);
			}
		}
		return $hash;
	}
	function __toString() { return 'DynamicsT'; }
}
