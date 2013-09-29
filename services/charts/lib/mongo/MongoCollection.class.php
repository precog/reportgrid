<?php

class mongo_MongoCollection {
	public function __construct($c) {
		if(!php_Boot::$skip_constructor) {
		$this->c = $c;
	}}
	public $c;
	public function validate() {
		return php_Lib::objectOfAssociativeArray($this->c->validate());
	}
	public function ensureIndex($keys, $options) {
		if(null !== $options) {
			return $this->c->ensureIndex(php_Lib::associativeArrayOfObject($keys), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->ensureIndex(php_Lib::associativeArrayOfObject($keys));
		}
	}
	public function ensureIndexOn($key, $options) {
		if(null !== $options) {
			return $this->c->ensureIndex($key, php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->ensureIndex($key);
		}
	}
	public function insert($data, $options) {
		if(null !== $options) {
			return $this->c->insert(php_Lib::associativeArrayOfObject($data), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->insert(php_Lib::associativeArrayOfObject($data));
		}
	}
	public function remove($criteria, $options) {
		if(null !== $options) {
			return $this->c->remove(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->remove(php_Lib::associativeArrayOfObject($criteria));
		}
	}
	public function update($criteria, $newob, $options) {
		if(null !== $options) {
			return $this->c->update(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($newob), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->update(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($newob));
		}
	}
	public function findOne($criteria, $fields) {
		$r = null;
		if(null === $fields) {
			$r = $this->c->findOne(php_Lib::associativeArrayOfObject($criteria));
		} else {
			$r = $this->c->findOne(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($fields));
		}
		if(null === $r) {
			return null;
		} else {
			return php_Lib::objectOfAssociativeArray($r);
		}
	}
	public function find($criteria, $fields) {
		$r = null;
		if(null === $fields) {
			$r = $this->c->find(php_Lib::associativeArrayOfObject($criteria));
		} else {
			$r = $this->c->find(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($fields));
		}
		return new mongo_MongoCursor($r);
	}
	public function drop() {
		$this->c->drop();
	}
	public function count() {
		return $this->c->count();
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
	function __toString() { return 'mongo.MongoCollection'; }
}
