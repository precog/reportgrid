<?php

class ufront_acl_Registry {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_roles = new Hash();
	}}
	public $_roles;
	public function add($role, $parent, $parents) {
		if($this->exists($role)) {
			throw new HException(new thx_error_Error("Role {0} already exists in the registry", null, $role, _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 19, "className" => "ufront.acl.Registry", "methodName" => "add"))));
		}
		$parents = ufront_acl_Registry_0($this, $parent, $parents, $role);
		$roleParents = new thx_collection_Set();
		{
			$_g = 0;
			while($_g < $parents->length) {
				$parent1 = $parents[$_g];
				++$_g;
				if(!$this->exists($parent1)) {
					throw new HException(new thx_error_Error("Parent Role '{0}' does not exist", null, $parent1, _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 26, "className" => "ufront.acl.Registry", "methodName" => "add"))));
				}
				$roleParents->add($parent1);
				$this->_roles->get($parent1)->children->add($role);
				unset($parent1);
			}
		}
		$this->_roles->set($role, _hx_anonymous(array("role" => $role, "parents" => $roleParents, "children" => new thx_collection_Set())));
	}
	public function exists($role) {
		return $this->_roles->exists($role);
	}
	public function getParents($role) {
		if(!$this->_roles->exists($role)) {
			throw new HException(new thx_error_Error("Role '{0}' does not exist in the registry", null, $role, _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 46, "className" => "ufront.acl.Registry", "methodName" => "getParents"))));
		}
		return $this->_roles->get($role)->parents->harray();
	}
	public function getChildren($role) {
		if(!$this->_roles->exists($role)) {
			throw new HException(new thx_error_Error("Role '{0}' does not exist in the registry", null, $role, _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 53, "className" => "ufront.acl.Registry", "methodName" => "getChildren"))));
		}
		return $this->_roles->get($role)->children->harray();
	}
	public function inherits($role, $inherit, $onlyParents) {
		if($onlyParents === null) {
			$onlyParents = false;
		}
		if(null === $role) {
			throw new HException(new thx_error_NullArgument("role", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 59, "className" => "ufront.acl.Registry", "methodName" => "inherits"))));
		}
		if(null === $inherit) {
			throw new HException(new thx_error_NullArgument("inherit", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 60, "className" => "ufront.acl.Registry", "methodName" => "inherits"))));
		}
		$r = $this->_roles->get($role);
		if(null === $r) {
			throw new HException(new thx_error_Error("Role '{0}' does not exist in the registry", null, $role, _hx_anonymous(array("fileName" => "Registry.hx", "lineNumber" => 64, "className" => "ufront.acl.Registry", "methodName" => "inherits"))));
		}
		$i = $r->parents->exists($inherit);
		if($i || $onlyParents) {
			return $i;
		}
		if(null == $r->parents) throw new HException('null iterable');
		$»it = $r->parents->iterator();
		while($»it->hasNext()) {
			$parent = $»it->next();
			if($this->inherits($parent, $inherit, null)) {
				return true;
			}
		}
		return false;
	}
	public function remove($role) {
		$item = $this->_roles->get($role);
		if(null === $item) {
			return false;
		}
		if(null == $item->children) throw new HException('null iterable');
		$»it = $item->children->iterator();
		while($»it->hasNext()) {
			$child = $»it->next();
			$this->_roles->get($child)->parents->remove($role);
		}
		if(null == $item->parents) throw new HException('null iterable');
		$»it = $item->parents->iterator();
		while($»it->hasNext()) {
			$parent = $»it->next();
			$this->_roles->get($parent)->children->remove($role);
		}
		$this->_roles->remove($role);
		return true;
	}
	public function removeAll() {
		$this->_roles = new Hash();
	}
	public function iterator() {
		return $this->_roles->keys();
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
	static function _parents($parent, $parents) {
		if(null === $parents) {
			$parents = new _hx_array(array());
		}
		if(null !== $parent) {
			$parents->push($parent);
		}
		return $parents;
	}
	function __toString() { return 'ufront.acl.Registry'; }
}
function ufront_acl_Registry_0(&$»this, &$parent, &$parents, &$role) {
	{
		$parents1 = $parents;
		if(null === $parents1) {
			$parents1 = new _hx_array(array());
		}
		if(null !== $parent) {
			$parents1->push($parent);
		}
		return $parents1;
	}
}
