<?php

class MongoCollections {
	public function __construct(){}
	static function validate($coll) {
		return php_Lib::objectOfAssociativeArray($coll->validate());
	}
	function __toString() { return 'MongoCollections'; }
}
