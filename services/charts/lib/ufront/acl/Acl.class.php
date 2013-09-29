<?php

class ufront_acl_Acl {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_registry = new ufront_acl_Registry();
		$this->_resources = new Hash();
		$this->_rules = _hx_anonymous(array("allResources" => _hx_anonymous(array("allRoles" => _hx_anonymous(array("allPrivileges" => _hx_anonymous(array("type" => ufront_acl_AccessType::$Deny, "assert" => null)), "byPrivilegeId" => new Hash())), "byRoleId" => new Hash())), "byResourceId" => new Hash()));
		$this->_isAllowedPrivilege = null;
	}}
	public $_registry;
	public $_resources;
	public $_rules;
	public $_isAllowedRole;
	public $_isAllowedResource;
	public $_isAllowedPrivilege;
	public function addRole($role, $parent, $parents) {
		$this->_registry->add($role, $parent, $parents);
		return $this;
	}
	public function getRoles() {
		return $this->_registry->iterator();
	}
	public function existsRole($role) {
		return $this->_registry->exists($role);
	}
	public function inheritsRole($role, $inherit, $onlyParents) {
		return $this->_registry->inherits($role, $inherit, $onlyParents);
	}
	public function removeRole($role) {
		if(!$this->_registry->remove($role)) {
			return false;
		}
		if(null == $this->_rules->allResources->byRoleId) throw new HException('null iterable');
		$»it = $this->_rules->allResources->byRoleId->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			if($role === $key) {
				$this->_rules->allResources->byRoleId->remove($key);
			}
		}
		if(null == $this->_rules->byResourceId) throw new HException('null iterable');
		$»it = $this->_rules->byResourceId->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			$rules = $this->_rules->byResourceId->get($key);
			if(null == $rules->byRoleId) throw new HException('null iterable');
			$»it2 = $rules->byRoleId->keys();
			while($»it2->hasNext()) {
				$r = $»it2->next();
				if($r === $role) {
					$rules->byRoleId->remove($r);
				}
			}
			unset($rules);
		}
		return true;
	}
	public function removeRoleAll() {
		$this->_registry->removeAll();
		$this->_rules = _hx_anonymous(array("allResources" => _hx_anonymous(array("allRoles" => _hx_anonymous(array("allPrivileges" => _hx_anonymous(array("type" => ufront_acl_AccessType::$Deny, "assert" => null)), "byPrivilegeId" => new Hash())), "byRoleId" => new Hash())), "byResourceId" => new Hash()));
		return $this;
	}
	public function addResource($resource, $parent) {
		if(null === $resource) {
			throw new HException(new thx_error_NullArgument("resource", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 132, "className" => "ufront.acl.Acl", "methodName" => "addResource"))));
		}
		if($this->existsResource($resource)) {
			throw new HException(new thx_error_Error("Resource '{0}' already exists in the ACL", null, $resource, _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 134, "className" => "ufront.acl.Acl", "methodName" => "addResource"))));
		}
		if(null !== $parent) {
			if(!$this->existsResource($parent)) {
				throw new HException(new thx_error_Error("Parent resource '{0}' does not exist in the ACL", null, $parent, _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 138, "className" => "ufront.acl.Acl", "methodName" => "addResource"))));
			}
			$this->_resources->get($parent)->children->add($resource);
		}
		$this->_resources->set($resource, _hx_anonymous(array("resource" => $resource, "parent" => $parent, "children" => new thx_collection_Set())));
		return $this;
	}
	public function existsResource($resource) {
		return $this->_resources->exists($resource);
	}
	public function inheritsResource($resource, $inherit, $onlyParent) {
		if($onlyParent === null) {
			$onlyParent = false;
		}
		if(null === $resource) {
			throw new HException(new thx_error_NullArgument("resource", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 157, "className" => "ufront.acl.Acl", "methodName" => "inheritsResource"))));
		}
		if(null === $inherit) {
			throw new HException(new thx_error_NullArgument("inherit", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 158, "className" => "ufront.acl.Acl", "methodName" => "inheritsResource"))));
		}
		$r = $this->_resources->get($resource);
		if(null === $r) {
			throw new HException(new thx_error_Error("Resource '{0}' does not exist in the registry", null, $resource, _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 162, "className" => "ufront.acl.Acl", "methodName" => "inheritsResource"))));
		}
		if($r->parent === $inherit) {
			return true;
		} else {
			if($onlyParent || null === $r->parent) {
				return false;
			}
		}
		$p = $r->parent;
		while(null !== $p) {
			$r1 = $this->_resources->get($p);
			if($r1->parent === $inherit) {
				return true;
			}
			$p = $r1->parent;
			unset($r1);
		}
		return false;
	}
	public function removeResource($resource) {
		if(null === $resource) {
			throw new HException(new thx_error_NullArgument("resource", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 182, "className" => "ufront.acl.Acl", "methodName" => "removeResource"))));
		}
		if(!$this->existsResource($resource)) {
			return false;
		}
		$removed = new _hx_array(array($resource));
		$p = $this->_resources->get($resource);
		if(null !== $p->parent) {
			$this->_resources->get($p->parent)->children->remove($resource);
		}
		if(null == $p->children) throw new HException('null iterable');
		$»it = $p->children->iterator();
		while($»it->hasNext()) {
			$child = $»it->next();
			$this->removeResource($child);
			$removed->push($child);
		}
		{
			$_g = 0;
			while($_g < $removed->length) {
				$r = $removed[$_g];
				++$_g;
				if(null == $this->_rules->byResourceId) throw new HException('null iterable');
				$»it = $this->_rules->byResourceId->keys();
				while($»it->hasNext()) {
					$res = $»it->next();
					if($res === $resource) {
						$this->_rules->byResourceId->remove($res);
					}
				}
				unset($r);
			}
		}
		$this->_resources->remove($resource);
		return true;
	}
	public function removeAll() {
		if(null == $this->_resources) throw new HException('null iterable');
		$»it = $this->_resources->keys();
		while($»it->hasNext()) {
			$resource = $»it->next();
			if(null == $this->_rules->byResourceId) throw new HException('null iterable');
			$»it2 = $this->_rules->byResourceId->keys();
			while($»it2->hasNext()) {
				$res = $»it2->next();
				if($res === $resource) {
					$this->_rules->byResourceId->remove($res);
				}
			}
		}
		$this->_resources = new Hash();
		return $this;
	}
	public function allow($roles, $resources, $privileges, $assert) {
		return $this->setRule(ufront_acl_Operation::$Add, ufront_acl_AccessType::$Allow, $roles, $resources, $privileges, $assert);
	}
	public function deny($roles, $resources, $privileges, $assert) {
		return $this->setRule(ufront_acl_Operation::$Add, ufront_acl_AccessType::$Deny, $roles, $resources, $privileges, $assert);
	}
	public function removeAllow($roles, $resources, $privileges, $assert) {
		return $this->setRule(ufront_acl_Operation::$Remove, ufront_acl_AccessType::$Allow, $roles, $resources, $privileges, $assert);
	}
	public function removeDeny($roles, $resources, $privileges, $assert) {
		return $this->setRule(ufront_acl_Operation::$Remove, ufront_acl_AccessType::$Deny, $roles, $resources, $privileges, $assert);
	}
	public function setRule($operation, $type, $roles, $resources, $privileges, $assert) {
		if(null === $roles || $roles->length === 0) {
			$roles = new _hx_array(array(null));
		}
		if(null === $resources || $resources->length === 0) {
			$resources = new _hx_array(array(null));
		}
		if(null === $privileges) {
			$privileges = new _hx_array(array());
		}
		$»t = ($operation);
		switch($»t->index) {
		case 0:
		{
			$_g = 0;
			while($_g < $resources->length) {
				$resource = $resources[$_g];
				++$_g;
				{
					$_g1 = 0;
					while($_g1 < $roles->length) {
						$role = $roles[$_g1];
						++$_g1;
						$rules = $this->_getRules($resource, $role, true);
						if($privileges->length === 0) {
							$rules->allPrivileges = _hx_anonymous(array("type" => $type, "assert" => $assert));
						} else {
							$_g2 = 0;
							while($_g2 < $privileges->length) {
								$privilege = $privileges[$_g2];
								++$_g2;
								$rules->byPrivilegeId->set($privilege, _hx_anonymous(array("type" => $type, "assert" => $assert)));
								unset($privilege);
							}
							unset($_g2);
						}
						unset($rules,$role);
					}
					unset($_g1);
				}
				unset($resource);
			}
		}break;
		case 1:
		{
			$_g = 0;
			while($_g < $resources->length) {
				$resource = $resources[$_g];
				++$_g;
				{
					$_g1 = 0;
					while($_g1 < $roles->length) {
						$role = $roles[$_g1];
						++$_g1;
						$rules = $this->_getRules($resource, $role, null);
						if(null === $rules) {
							continue;
						}
						if($privileges->length === 0) {
							if(null === $resource && null === $role) {
								if(Type::enumEq($type, $rules->allPrivileges->type)) {
									$rules->allPrivileges->type = ufront_acl_AccessType::$Deny;
									$rules->allPrivileges->assert = null;
									$rules->byPrivilegeId = new Hash();
								}
								continue;
							}
							if(Type::enumEq($type, $rules->allPrivileges->type)) {
								$rules->allPrivileges->type = ufront_acl_AccessType::$Deny;
								$rules->allPrivileges->assert = null;
							}
						} else {
							$_g2 = 0;
							while($_g2 < $privileges->length) {
								$privilege = $privileges[$_g2];
								++$_g2;
								if($rules->byPrivilegeId->exists($privilege) && Type::enumEq($type, $rules->byPrivilegeId->get($privilege)->type)) {
									$rules->byPrivilegeId->remove($privilege);
								}
								unset($privilege);
							}
							unset($_g2);
						}
						unset($rules,$role);
					}
					unset($_g1);
				}
				unset($resource);
			}
		}break;
		}
		return $this;
	}
	public function isAllowed($role, $resource, $privilege) {
		$this->_isAllowedPrivilege = null;
		$this->_isAllowedRole = ((null !== $role) ? $role : null);
		$this->_isAllowedResource = ((null !== $resource) ? $resource : null);
		if(null === $privilege) {
			do {
				if(null !== $role) {
					$result = $this->_roleDFSAllPrivileges($role, $resource);
					if(null !== $result) {
						return $result;
					}
					unset($result);
				}
				$rules = $this->_getRules($resource, null, null);
				if(null !== $rules) {
					if(null == $rules->byPrivilegeId) throw new HException('null iterable');
					$»it = $rules->byPrivilegeId->keys();
					while($»it->hasNext()) {
						$privilege1 = $»it->next();
						if(Type::enumEq(ufront_acl_AccessType::$Deny, $this->_getRuleType($resource, null, $privilege1))) {
							return false;
						}
					}
					$type = $this->_getRuleType($resource, null, null);
					if(null !== $type) {
						return Type::enumEq(ufront_acl_AccessType::$Allow, $type);
					}
					unset($type);
				}
				$resource = $this->_resources->get($resource)->parent;
				unset($rules);
			} while(true);
		} else {
			$this->_isAllowedPrivilege = $privilege;
			do {
				if(null !== $role) {
					$result = $this->_roleDFSOnePrivilege($role, $resource, $privilege);
					if(null !== $result) {
						return $result;
					}
					unset($result);
				}
				$type = $this->_getRuleType($resource, null, $privilege);
				if(null !== $type) {
					return Type::enumEq(ufront_acl_AccessType::$Allow, $type);
				}
				$type = $this->_getRuleType($resource, null, null);
				if(null !== $type) {
					return Type::enumEq(ufront_acl_AccessType::$Allow, $type);
				}
				$resource = $this->_resources->get($resource)->parent;
				unset($type);
			} while(true);
		}
		return false;
	}
	public function _roleDFSAllPrivileges($role, $resource) {
		$dfs = _hx_anonymous(array("visited" => new thx_collection_Set(), "stack" => new _hx_array(array())));
		$result = $this->_roleDFSVisitAllPrivileges($role, $resource, $dfs);
		if(null !== $result) {
			return $result;
		}
		while(null !== ($role = $dfs->stack->pop())) {
			if(!$dfs->visited->exists($role)) {
				$result1 = $this->_roleDFSVisitAllPrivileges($role, $resource, $dfs);
				if(null !== $result1) {
					return $result1;
				}
				unset($result1);
			}
		}
		return null;
	}
	public function _roleDFSVisitAllPrivileges($role, $resource, $dfs) {
		$rules = $this->_getRules($resource, $role, null);
		if(null !== $rules) {
			if(null == $rules->byPrivilegeId) throw new HException('null iterable');
			$»it = $rules->byPrivilegeId->keys();
			while($»it->hasNext()) {
				$privilege = $»it->next();
				if(Type::enumEq(ufront_acl_AccessType::$Deny, $this->_getRuleType($resource, $role, $privilege))) {
					return false;
				}
			}
			$type = $this->_getRuleType($resource, $role, null);
			if(null !== $type) {
				return Type::enumEq(ufront_acl_AccessType::$Allow, $type);
			}
		}
		$dfs->visited->add($role);
		{
			$_g = 0; $_g1 = $this->_registry->getParents($role);
			while($_g < $_g1->length) {
				$parent = $_g1[$_g];
				++$_g;
				$dfs->stack->push($parent);
				unset($parent);
			}
		}
		return null;
	}
	public function _roleDFSOnePrivilege($role, $resource, $privilege) {
		if(null === $privilege) {
			throw new HException(new thx_error_NullArgument("privilege", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 424, "className" => "ufront.acl.Acl", "methodName" => "_roleDFSOnePrivilege"))));
		}
		$dfs = _hx_anonymous(array("visited" => new thx_collection_Set(), "stack" => new _hx_array(array())));
		$result = $this->_roleDFSVisitOnePrivilege($role, $resource, $privilege, $dfs);
		if(null !== $result) {
			return $result;
		}
		$r = null;
		while(null !== ($r = $dfs->stack->pop())) {
			if(!$dfs->visited->exists($r)) {
				$result1 = $this->_roleDFSVisitOnePrivilege($r, $resource, $privilege, $dfs);
				if(null !== $result1) {
					return $result1;
				}
				unset($result1);
			}
		}
		return null;
	}
	public function _roleDFSVisitOnePrivilege($role, $resource, $privilege, $dfs) {
		if(null === $privilege) {
			throw new HException(new thx_error_NullArgument("privilege", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "Acl.hx", "lineNumber" => 451, "className" => "ufront.acl.Acl", "methodName" => "_roleDFSVisitOnePrivilege"))));
		}
		$result = $this->_getRuleType($resource, $role, $privilege);
		if(null !== $result) {
			return Type::enumEq(ufront_acl_AccessType::$Allow, $result);
		}
		$result = $this->_getRuleType($resource, $role, null);
		if(null !== $result) {
			return Type::enumEq(ufront_acl_AccessType::$Allow, $result);
		}
		$dfs->visited->add($role);
		{
			$_g = 0; $_g1 = $this->_registry->getParents($role);
			while($_g < $_g1->length) {
				$parent = $_g1[$_g];
				++$_g;
				$dfs->stack->push($parent);
				unset($parent);
			}
		}
		return null;
	}
	public function _getRuleType($resource, $role, $privilege) {
		$rules = $this->_getRules($resource, $role, null);
		if(null === $rules) {
			return null;
		}
		$rule = null;
		if(null === $privilege) {
			if(null !== _hx_field($rules, "allPrivileges")) {
				$rule = $rules->allPrivileges;
			} else {
				return null;
			}
		} else {
			if(!$rules->byPrivilegeId->exists($privilege)) {
				return null;
			} else {
				$rule = $rules->byPrivilegeId->get($privilege);
			}
		}
		$assertionValue = false;
		if(null !== $rule->assert) {
			$assertionValue = $rule->assert($this, $role, $resource, $this->_isAllowedPrivilege);
		}
		if(null === $rule->assert || $assertionValue) {
			return $rule->type;
		} else {
			if(null !== $resource || null !== $role || null !== $privilege) {
				return null;
			} else {
				if(Type::enumEq(ufront_acl_AccessType::$Allow, $rule->type)) {
					return ufront_acl_AccessType::$Deny;
				} else {
					return ufront_acl_AccessType::$Allow;
				}
			}
		}
	}
	public function _getRules($resource, $role, $create) {
		if($create === null) {
			$create = false;
		}
		$visitor = null;
		if(null === $resource) {
			$visitor = $this->_rules->allResources;
		} else {
			if(!$this->_rules->byResourceId->exists($resource)) {
				if(!$create) {
					return null;
				}
				$this->_rules->byResourceId->set($resource, _hx_anonymous(array("byRoleId" => new Hash(), "allRoles" => _hx_anonymous(array("allPrivileges" => null, "byPrivilegeId" => new Hash())))));
			}
			$visitor = $this->_rules->byResourceId->get($resource);
		}
		if(null === $role) {
			return $visitor->allRoles;
		}
		if(!$visitor->byRoleId->exists($role)) {
			if(!$create) {
				return null;
			}
			$visitor->byRoleId->set($role, _hx_anonymous(array("byPrivilegeId" => new Hash(), "allPrivileges" => null)));
		}
		return $visitor->byRoleId->get($role);
	}
	public function getResources() {
		return $this->_resources->keys();
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
	function __toString() { return 'ufront.acl.Acl'; }
}
