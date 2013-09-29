<?php

class util_TraceToMongo implements ufront_web_module_ITraceModule{
	public function __construct($dbname, $collname, $servername) {
		if(!php_Boot::$skip_constructor) {
		$this->dbname = $dbname;
		$this->collname = $collname;
		$this->servername = $servername;
	}}
	public $coll;
	public $dbname;
	public $collname;
	public $servername;
	public function init($application) {
	}
	public function trace($msg, $pos) {
		$p = _hx_anonymous(array("fileName" => $pos->fileName, "className" => $pos->className, "methodName" => $pos->methodName, "lineNumber" => $pos->lineNumber));
		$this->getColl()->insert(_hx_anonymous(array("msg" => Dynamics::string($msg), "pos" => $p, "time" => Date::now()->getTime(), "server" => $this->servername)), null);
	}
	public function dispose() {
	}
	public function getColl() {
		if(null === $this->coll) {
			$m = new mongo_Mongo(); $db = new mongo_MongoDB($m->m->selectDB($this->dbname));
			$this->coll = new mongo_MongoCollection($db->db->selectCollection($this->collname));
		}
		return $this->coll;
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
	static $__properties__ = array("get_coll" => "getColl");
	function __toString() { return 'util.TraceToMongo'; }
}
