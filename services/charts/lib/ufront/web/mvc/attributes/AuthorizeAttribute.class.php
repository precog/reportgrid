<?php

class ufront_web_mvc_attributes_AuthorizeAttribute extends ufront_web_mvc_attributes_FilterAttribute implements ufront_web_mvc_IAuthorizationFilter{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->roles = new _hx_array(array());
		$this->users = new _hx_array(array());
		$this->currentRoles = new _hx_array(array());
		$this->currentUser = null;
	}}
	public $acl;
	public $roles;
	public $users;
	public $currentRoles;
	public $currentUser;
	public function onAuthorization($e) {
		$cname = Type::getClassName(Type::getClass($e->controllerContext->controller));
		if(!$this->acl->existsResource($cname)) {
			$this->acl->addResource($cname, null);
		}
		{
			$_g = 0; $_g1 = $this->roles;
			while($_g < $_g1->length) {
				$role = $_g1[$_g];
				++$_g;
				if(!$this->acl->existsRole($role)) {
					$this->acl->addRole($role, null, null);
				}
				unset($role);
			}
		}
		if($this->roles->length > 0) {
			$this->acl->allow($this->roles, new _hx_array(array($cname)), new _hx_array(array($e->actionName)), null);
		}
		if(!$this->isAllowed($cname, $e->actionName)) {
			$e->result = new ufront_web_mvc_HttpUnauthorizedResult();
		}
	}
	public function isAllowed($resource, $privilege) {
		if(Lambda::has($this->users, $this->currentUser, null)) {
			return true;
		}
		{
			$_g = 0; $_g1 = $this->currentRoles;
			while($_g < $_g1->length) {
				$role = $_g1[$_g];
				++$_g;
				if($this->acl->existsRole($role) && $this->acl->isAllowed($role, $resource, $privilege)) {
					return true;
				}
				unset($role);
			}
		}
		return false;
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
	function __toString() { return 'ufront.web.mvc.attributes.AuthorizeAttribute'; }
}
