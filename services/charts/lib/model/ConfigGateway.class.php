<?php

class model_ConfigGateway {
	public function __construct($coll) {
		if(!php_Boot::$skip_constructor) {
		$this->coll = $coll;
	}}
	public $coll;
	public function setSampleUID($id) {
		$this->coll->insert(_hx_anonymous(array("name" => model_ConfigGateway::$SAMPLE_UID, "value" => $id)), null);
	}
	public function getSampleUID() {
		$o = $this->coll->findOne(_hx_anonymous(array("name" => model_ConfigGateway::$SAMPLE_UID)), null);
		if(null === $o) {
			return null;
		} else {
			return $o->value;
		}
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
	static $SAMPLE_UID = "sample_uid";
	function __toString() { return 'model.ConfigGateway'; }
}
