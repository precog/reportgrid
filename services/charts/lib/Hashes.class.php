<?php

class Hashes {
	public function __construct(){}
	static function entries($h) {
		$arr = new _hx_array(array());
		if(null == $h) throw new HException('null iterable');
		$»it = $h->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			$arr->push(_hx_anonymous(array("key" => $key, "value" => $h->get($key))));
		}
		return $arr;
	}
	static function toDynamic($hash) {
		$o = _hx_anonymous(array());
		if(null == $hash) throw new HException('null iterable');
		$»it = $hash->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			$o->{$key} = $hash->get($key);
		}
		return $o;
	}
	static function importObject($hash, $ob) {
		return DynamicsT::copyToHash($ob, $hash);
	}
	static function copyTo($from, $to) {
		if(null == $from) throw new HException('null iterable');
		$»it = $from->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$to->set($k, $from->get($k));
		}
		return $to;
	}
	static function hclone($src) {
		$h = new Hash();
		Hashes::copyTo($src, $h);
		return $h;
	}
	static function arrayOfKeys($hash) {
		return Iterators::harray($hash->keys());
	}
	static function setOfKeys($hash) {
		$set = new thx_collection_Set();
		if(null == $hash) throw new HException('null iterable');
		$»it = $hash->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$set->add($k);
		}
		return $set;
	}
	static function hempty($hash) {
		return Hashes::count($hash) === 0;
	}
	static function count($hash) {
		return count($hash->h);
	}
	static function mergef($hash, $new_hash, $f) {
		if(null == $new_hash) throw new HException('null iterable');
		$»it = $new_hash->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$new_val = $new_hash->get($k);
			if($hash->exists($k)) {
				$old_val = $hash->get($k);
				$hash->set($k, call_user_func_array($f, array($k, $old_val, $new_val)));
				unset($old_val);
			} else {
				$hash->set($k, $new_val);
			}
			unset($new_val);
		}
	}
	static function merge($hash, $new_hash) {
		Hashes::mergef($hash, $new_hash, array(new _hx_lambda(array(&$hash, &$new_hash), "Hashes_0"), 'execute'));
	}
	static function clear($hash) {
		$_hash = $hash;
		$_hash->h = array();
	}
	function __toString() { return 'Hashes'; }
}
function Hashes_0(&$hash, &$new_hash, $key, $old_v, $new_v) {
	{
		return $new_v;
	}
}
