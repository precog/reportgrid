<?php

class mongo_MongoDB {
	public function __construct($db) {
		if(!php_Boot::$skip_constructor) {
		$this->db = $db;
	}}
	public $db;
	public function listCollections() {
		return new _hx_array($this->db->listCollections());
	}
	public function selectCollection($name) {
		return new mongo_MongoCollection($this->db->selectCollection($name));
	}
	public function createCollection($name) {
		return new mongo_MongoCollection($this->db->createCollection($name));
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
	function __toString() { return 'mongo.MongoDB'; }
}
