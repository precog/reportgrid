<?php

class mongo_MongoBinData {
	public function __construct(){}
	static function createByteArray($data) {
		return new MongoBinData($data, 2);
	}
	function __toString() { return 'mongo.MongoBinData'; }
}
