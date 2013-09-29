<?php

class ufront_web_mvc_ControllerActionInvoker implements ufront_web_mvc_IActionInvoker{
	public function __construct($binders, $controllerBuilder, $dependencyResolver) {
		if(!php_Boot::$skip_constructor) {
		$this->binders = $binders;
		$this->controllerBuilder = $controllerBuilder;
		$this->dependencyResolver = $dependencyResolver;
	}}
	public $controllerBuilder;
	public $binders;
	public $valueProvider;
	public $dependencyResolver;
	public function getParameterValue($controllerContext, $parameter) {
		$binder = $this->getModelBinder($parameter);
		$bindingContext = new ufront_web_mvc_ModelBindingContext($parameter->name, $parameter->type, $controllerContext->controller->getValueProvider(), $parameter->ctype);
		return $binder->bindModel($controllerContext, $bindingContext);
	}
	public function getModelBinder($parameter) {
		return $this->binders->getBinder($parameter->type, null, null);
	}
	public function getParameters($controllerContext, $argsinfo, $typeParameters) {
		$arguments = new thx_collection_HashList();
		{
			$_g = 0;
			while($_g < $argsinfo->length) {
				$info = $argsinfo[$_g];
				++$_g;
				$tname = thx_type_Rttis::typeName($info->t, false);
				$t = $info->t;
				if($typeParameters->exists($tname)) {
					$t = $typeParameters->get($tname);
					$tname = thx_type_Rttis::typeName($t, false);
				}
				$parameter = new ufront_web_mvc_ParameterDescriptor($info->name, $tname, $t);
				$value = $this->getParameterValue($controllerContext, $parameter);
				if(null === $value) {
					if(thx_type_Rttis::argumentAcceptNull($info)) {
						$arguments->set($info->name, null);
					} else {
						throw new HException(new thx_error_Error("argument {0} cannot be null", null, $info->name, _hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 76, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "getParameters"))));
					}
				} else {
					$arguments->set($info->name, $value);
				}
				unset($value,$tname,$t,$parameter,$info);
			}
		}
		return $arguments;
	}
	public function invokeAction($controllerContext, $actionName, $async) {
		$controller = $controllerContext->controller;
		$cls = Type::getClass($controller);
		$fields = thx_type_Rttis::getClassFields($cls);
		$method = $fields->get($actionName);
		$arguments = null;
		$isasync = ufront_web_mvc_ControllerActionInvoker::isAsync($method);
		try {
			if(null === $method) {
				throw new HException(new thx_error_Error("action {0} does not exist on this controller", null, $actionName, _hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 122, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "invokeAction"))));
			}
			if(!$method->isPublic) {
				throw new HException(new thx_error_Error("action {0} must be a public method", null, $actionName, _hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 125, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "invokeAction"))));
			}
			$argsinfo = thx_type_Rttis::methodArguments($method);
			if(null === $argsinfo) {
				throw new HException(new thx_error_Error("action {0} is not a method", null, $actionName, _hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 129, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "invokeAction"))));
			}
			if($isasync) {
				$argsinfo->pop();
			}
			$arguments = $this->getParameters($controllerContext, $argsinfo, thx_type_Rttis::typeParametersMap($cls, null));
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($e = $_ex_) instanceof thx_error_Error){
				$this->_handleUnknownAction($actionName, $async, $e);
				return;
			} else throw $»e;;
		}
		$action = $actionName;
		if(ufront_web_mvc_ControllerActionInvoker::$_mapper->exists($actionName)) {
			$action = "h" . $actionName;
		}
		$filterInfo = $this->getFilters($controllerContext, $action);
		try {
			$authorizationContext = new ufront_web_mvc_AuthorizationContext($controllerContext, $actionName, $arguments);
			{
				$_g = 0; $_g1 = $filterInfo->authorizationFilters;
				while($_g < $_g1->length) {
					$filter = $_g1[$_g];
					++$_g;
					$filter->onAuthorization($authorizationContext);
					unset($filter);
				}
			}
			if(null !== $authorizationContext->result) {
				$authorizationContext->result->executeResult($controllerContext);
			} else {
				$executingContext = new ufront_web_mvc_ActionExecutingContext($controllerContext, $actionName, $arguments);
				{
					$_g = 0; $_g1 = $filterInfo->actionFilters;
					while($_g < $_g1->length) {
						$filter = $_g1[$_g];
						++$_g;
						$filter->onActionExecuting($executingContext);
						unset($filter);
					}
				}
				if(null !== $executingContext->result || !$isasync) {
					if(null === $executingContext->result) {
						$executingContext->result = Reflect::callMethod($controller, Reflect::field($controller, $action), $arguments->harray());
					}
					$value = ufront_web_mvc_ControllerActionInvoker::createActionResult($executingContext->result);
					$executedContext = new ufront_web_mvc_ActionExecutedContext($controllerContext, $actionName, $value);
					{
						$_g = 0; $_g1 = ufront_web_mvc_ControllerActionInvoker::reverse($filterInfo->actionFilters);
						while($_g < $_g1->length) {
							$filter = $_g1[$_g];
							++$_g;
							$filter->onActionExecuted($executedContext);
							unset($filter);
						}
					}
					$this->processContent($value, $controllerContext, $filterInfo);
					$async->completed();
				} else {
					$me = $this;
					$handler = array(new _hx_lambda(array(&$action, &$actionName, &$arguments, &$async, &$authorizationContext, &$cls, &$controller, &$controllerContext, &$e, &$executingContext, &$fields, &$filterInfo, &$isasync, &$me, &$method), "ufront_web_mvc_ControllerActionInvoker_0"), 'execute');
					$args = $arguments->harray();
					$args->push($handler);
					Reflect::callMethod($controller, Reflect::field($controller, $action), $args);
				}
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e2 = $_ex_;
			{
				$exceptionContext = new ufront_web_mvc_ExceptionContext($controllerContext, $e2);
				{
					$_g = 0; $_g1 = $filterInfo->exceptionFilters;
					while($_g < $_g1->length) {
						$filter = $_g1[$_g];
						++$_g;
						$filter->onException($exceptionContext);
						unset($filter);
					}
				}
				if($exceptionContext->exceptionHandled !== true) {
					throw new HException($e2);
				}
				ufront_web_mvc_ControllerActionInvoker::createActionResult($exceptionContext->getResult())->executeResult($controllerContext);
			}
		}
	}
	public function handleExecution($value) {
	}
	public function processContent($result, $controllerContext, $filters) {
		$executingContext = new ufront_web_mvc_ResultExecutingContext($controllerContext, $result);
		{
			$_g = 0; $_g1 = $filters->resultFilters;
			while($_g < $_g1->length) {
				$filter = $_g1[$_g];
				++$_g;
				$filter->onResultExecuting($executingContext);
				unset($filter);
			}
		}
		$result->executeResult($controllerContext);
		$executedContext = new ufront_web_mvc_ResultExecutedContext($controllerContext, $result);
		{
			$_g = 0; $_g1 = ufront_web_mvc_ControllerActionInvoker::reverse($filters->resultFilters);
			while($_g < $_g1->length) {
				$filter = $_g1[$_g];
				++$_g;
				$filter->onResultExecuted($executedContext);
				unset($filter);
			}
		}
	}
	public function getFilters($context, $actionField) {
		$attributes = $this->getAttributes($context->controller, $actionField);
		$attributes->sort(array(new _hx_lambda(array(&$actionField, &$attributes, &$context), "ufront_web_mvc_ControllerActionInvoker_1"), 'execute'));
		$output = new ufront_web_mvc_FilterInfo($attributes);
		$output->mergeControllerFilters($context->controller);
		return $output;
	}
	public function getAttributes($controller, $actionField) {
		$classes = $this->createClassTree(Type::getClass($controller), null);
		$metadata = Lambda::map($classes, array(new _hx_lambda(array(&$actionField, &$classes, &$controller), "ufront_web_mvc_ControllerActionInvoker_2"), 'execute'));
		$metadata->add($this->getFieldAttributes($controller, $actionField));
		$hash = Lambda::fold($metadata, array(new _hx_lambda(array(&$actionField, &$classes, &$controller, &$metadata), "ufront_web_mvc_ControllerActionInvoker_3"), 'execute'), new Hash());
		$self = $this;
		$objects = Lambda::map(_hx_anonymous(array("iterator" => (isset($hash->keys) ? $hash->keys: array($hash, "keys")))), array(new _hx_lambda(array(&$actionField, &$classes, &$controller, &$hash, &$metadata, &$self), "ufront_web_mvc_ControllerActionInvoker_4"), 'execute'));
		return Lambda::harray(Lambda::filter($objects, array(new _hx_lambda(array(&$actionField, &$classes, &$controller, &$hash, &$metadata, &$objects, &$self), "ufront_web_mvc_ControllerActionInvoker_5"), 'execute')));
	}
	public function createClassTree($cls, $array) {
		if($array === null) {
			$array = new _hx_array(array());
		}
		$array->unshift($cls);
		$superClass = Type::getSuperClass($cls);
		return (($superClass !== null) ? $this->createClassTree($superClass, $array) : $array);
	}
	public function getAttributeClass($className) {
		if(null == $this->controllerBuilder->attributes) throw new HException('null iterable');
		$»it = $this->controllerBuilder->attributes->iterator();
		while($»it->hasNext()) {
			$pack = $»it->next();
			$c = Type::resolveClass($pack . "." . (ufront_web_mvc_ControllerActionInvoker_6($this, $className, $pack)) . "Attribute");
			if($c !== null && $this->inheritsFrom($c, _hx_qtype("ufront.web.mvc.attributes.FilterAttribute"))) {
				return $c;
			}
			unset($c);
		}
		return null;
	}
	public function getFieldAttributes($object, $field) {
		$metadata = haxe_rtti_Meta::getFields(Type::getClass($object));
		return Reflect::field($metadata, $field);
	}
	public function inheritsFrom($c, $superClass) {
		$parent = Type::getSuperClass($c);
		if($parent === $superClass) {
			return true;
		}
		return (($parent === null) ? false : $this->inheritsFrom($parent, $superClass));
	}
	public function _handleUnknownAction($action, $async, $err) {
		$error = new ufront_web_error_PageNotFoundError(_hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 358, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "_handleUnknownAction")));
		if(Std::is($err, _hx_qtype("thx.error.Error"))) {
			$error->setInner($err);
		} else {
			$error->setInner(new thx_error_Error("action can't be executed because {0}", null, Std::string($err), _hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 363, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "_handleUnknownAction"))));
		}
		$async->error($error);
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
	static function isAsync($method) {
		$arguments = thx_type_Rttis::methodArguments($method);
		if(0 === $arguments->length) {
			return false;
		}
		$last = $arguments->pop();
		return ufront_web_mvc_ControllerActionInvoker_7($arguments, $last, $method);
	}
	static function createActionResult($actionReturnValue) {
		if($actionReturnValue === null) {
			return new ufront_web_mvc_EmptyResult();
		}
		if(Std::is($actionReturnValue, _hx_qtype("ufront.web.mvc.ActionResult"))) {
			return $actionReturnValue;
		}
		return new ufront_web_mvc_ContentResult(Std::string($actionReturnValue), null);
	}
	static function reverse($list) {
		$output = $list->copy();
		$output->reverse();
		return $output;
	}
	static $_mapper;
	function __toString() { return 'ufront.web.mvc.ControllerActionInvoker'; }
}
{
	ufront_web_mvc_ControllerActionInvoker::$_mapper = new thx_collection_Set();
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("and");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("or");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("xor");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("exception");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("array");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("as");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("const");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("declare");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("die");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("echo");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("elseif");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("empty");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("enddeclare");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("endfor");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("endforeach");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("endif");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("endswitch");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("endwhile");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("eval");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("exit");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("foreach");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("global");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("include");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("include_once");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("isset");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("list");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("print");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("require");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("require_once");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("unset");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("use");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("final");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("php_user_filter");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("protected");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("abstract");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("__set");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("__get");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("__call");
	ufront_web_mvc_ControllerActionInvoker::$_mapper->add("clone");
}
function ufront_web_mvc_ControllerActionInvoker_0(&$action, &$actionName, &$arguments, &$async, &$authorizationContext, &$cls, &$controller, &$controllerContext, &$e, &$executingContext, &$fields, &$filterInfo, &$isasync, &$me, &$method, $value) {
	{
		$executedContext = new ufront_web_mvc_ActionExecutedContext($controllerContext, $actionName, ufront_web_mvc_ControllerActionInvoker::createActionResult($value));
		{
			$_g = 0; $_g1 = ufront_web_mvc_ControllerActionInvoker::reverse($filterInfo->actionFilters);
			while($_g < $_g1->length) {
				$filter = $_g1[$_g];
				++$_g;
				$filter->onActionExecuted($executedContext);
				unset($filter);
			}
		}
		$me->processContent($value, $controllerContext, $filterInfo);
		$async->completed();
	}
}
function ufront_web_mvc_ControllerActionInvoker_1(&$actionField, &$attributes, &$context, $x, $y) {
	{
		return $x->order - $y->order;
	}
}
function ufront_web_mvc_ControllerActionInvoker_2(&$actionField, &$classes, &$controller, $c) {
	{
		return haxe_rtti_Meta::getType($c);
	}
}
function ufront_web_mvc_ControllerActionInvoker_3(&$actionField, &$classes, &$controller, &$metadata, $meta, $output) {
	{
		if($meta === null) {
			return $output;
		}
		{
			$_g = 0; $_g1 = Reflect::fields($meta);
			while($_g < $_g1->length) {
				$className = $_g1[$_g];
				++$_g;
				$field = Reflect::field($meta, $className);
				if(!Std::is($field, _hx_qtype("Array"))) {
					$output->set($className, null);
				} else {
					$output->set($className, $field[0]);
				}
				unset($field,$className);
			}
		}
		return $output;
	}
}
function ufront_web_mvc_ControllerActionInvoker_4(&$actionField, &$classes, &$controller, &$hash, &$metadata, &$self, $key) {
	{
		$c = $self->getAttributeClass($key);
		if($c === null) {
			return null;
		}
		$instance = $self->dependencyResolver->getService($c);
		$args = $hash->get($key);
		{
			$_g = 0; $_g1 = Reflect::fields($args);
			while($_g < $_g1->length) {
				$arg = $_g1[$_g];
				++$_g;
				if(!_hx_has_field($instance, $arg)) {
					throw new HException(new thx_error_Error("Filter " . Type::getClassName(Type::getClass($instance)) . " has no field " . $arg, null, null, _hx_anonymous(array("fileName" => "ControllerActionInvoker.hx", "lineNumber" => 294, "className" => "ufront.web.mvc.ControllerActionInvoker", "methodName" => "getAttributes"))));
				}
				$instance->{$arg} = Reflect::field($args, $arg);
				unset($arg);
			}
		}
		return $instance;
	}
}
function ufront_web_mvc_ControllerActionInvoker_5(&$actionField, &$classes, &$controller, &$hash, &$metadata, &$objects, &$self, $o) {
	{
		return $o !== null;
	}
}
function ufront_web_mvc_ControllerActionInvoker_6(&$»this, &$className, &$pack) {
	if($className === null) {
		return null;
	} else {
		return strtoupper(_hx_char_at($className, 0)) . _hx_substr($className, 1, null);
	}
}
function ufront_web_mvc_ControllerActionInvoker_7(&$arguments, &$last, &$method) {
	$»t = ($last->t);
	switch($»t->index) {
	case 4:
	$ret = $»t->params[1]; $args = $»t->params[0];
	{
		if($args->length !== 1) {
			false;
		}
		$»t2 = ($ret);
		switch($»t2->index) {
		case 1:
		$t = $»t2->params[0];
		{
			return $t === "Void";
		}break;
		default:{
			return false;
		}break;
		}
	}break;
	default:{
		return false;
	}break;
	}
}
