<?php

class model_RenderableGateway {
	public function __construct($coll) {
		if(!php_Boot::$skip_constructor) {
		$this->coll = $coll;
	}}
	public $coll;
	public function exists($uid) {
		return null !== $this->coll->findOne(_hx_anonymous(array("uid" => $uid)), _hx_anonymous(array()));
	}
	public function insert($r) {
		$ob = _hx_anonymous(array("uid" => $r->getUid(), "config" => model_RenderableGateway::serialize($r->config), "createdOn" => $r->createdOn->getTime(), "html" => $r->html, "lastUsage" => $r->lastUsage->getTime(), "usages" => $r->usages, "expiresOn" => model_RenderableGateway_0($this, $r)));
		$this->coll->insert($ob, null);
	}
	public function load($uid) {
		$o = $this->coll->findOne(_hx_anonymous(array("uid" => $uid)), null);
		if(null === $o) {
			return null;
		}
		return new model_Renderable($o->html, model_RenderableGateway::unserialize($o->config), Date::fromTime($o->createdOn), Date::fromTime($o->lastUsage), $o->usages);
	}
	public function topByUsage($limit) {
		return $this->coll->find(_hx_anonymous(array()), _hx_anonymous(array("uid" => true, "createdOn" => true, "lastUsage" => true, "usages" => true)))->sort(_hx_anonymous(array("usages" => -1)))->limit($limit)->toArray();
	}
	public function huse($uid) {
		$this->coll->update(_hx_anonymous(array("uid" => $uid)), _hx_anonymous(array("\$set" => _hx_anonymous(array("lastUsage" => Date::now()->getTime())), "\$inc" => _hx_anonymous(array("usages" => 1)))), null);
	}
	public function removeExpired() {
		return $this->coll->remove(_hx_anonymous(array("expiresOn" => _hx_anonymous(array("\$lt" => Date::now()->getTime())))), null);
	}
	public function removeOldAndUnused($age) {
		if(null === $age) {
			$age = model_RenderableGateway::$DELETE_IF_NOT_USED_FOR;
		}
		$exp = Date::now()->getTime() - $age;
		return $this->coll->remove(_hx_anonymous(array("lastUsage" => _hx_anonymous(array("\$lt" => $exp)))), null);
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
	static $DELETE_IF_NOT_USED_FOR;
	static function serialize($o) {
		return new MongoBinData(php_Lib::serialize($o), 2);
	}
	static function unserialize($s) {
		return php_Lib::unserialize($s->bin);
	}
	function __toString() { return 'model.RenderableGateway'; }
}
model_RenderableGateway::$DELETE_IF_NOT_USED_FOR = thx_date_Milli::parse("366 days");
function model_RenderableGateway_0(&$»this, &$r) {
	if(null === $r->config->duration) {
		return null;
	} else {
		return Date::now()->getTime() + $r->config->duration;
	}
}
