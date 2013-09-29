<?php

class haxe_rtti_Meta {
	public function __construct(){}
	static function getType($t) {
		$meta = $t->__meta__;
		return haxe_rtti_Meta_0($meta, $t);
	}
	static function getStatics($t) {
		$meta = $t->__meta__;
		return haxe_rtti_Meta_1($meta, $t);
	}
	static function getFields($t) {
		$meta = $t->__meta__;
		return haxe_rtti_Meta_2($meta, $t);
	}
	function __toString() { return 'haxe.rtti.Meta'; }
}
function haxe_rtti_Meta_0(&$meta, &$t) {
	if($meta === null || _hx_field($meta, "obj") === null) {
		return _hx_anonymous(array());
	} else {
		return $meta->obj;
	}
}
function haxe_rtti_Meta_1(&$meta, &$t) {
	if($meta === null || _hx_field($meta, "statics") === null) {
		return _hx_anonymous(array());
	} else {
		return $meta->statics;
	}
}
function haxe_rtti_Meta_2(&$meta, &$t) {
	if($meta === null || _hx_field($meta, "fields") === null) {
		return _hx_anonymous(array());
	} else {
		return $meta->fields;
	}
}
