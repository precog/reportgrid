<?php

class ufront_web_mvc_DefaultModelBinder implements ufront_web_mvc_IModelBinder{
	public function __construct() { 
	}
	public function bindModel($controllerContext, $bindingContext) {
		$value = $bindingContext->valueProvider->getValue($bindingContext->modelName);
		$typeName = $bindingContext->modelType;
		if($value === null || _hx_field($value, "rawValue") === null) {
		}
		if($this->isSimpleType($typeName)) {
			if($value === null) {
				return null;
			}
			if(_hx_field($value, "rawValue") === null) {
				return $value->rawValue;
			}
			if($bindingContext->ctype !== null) {
				return ufront_web_mvc_ValueProviderResult::convertSimpleTypeRtti($value->attemptedValue, $bindingContext->ctype, false);
			} else {
				return ufront_web_mvc_ValueProviderResult::convertSimpleType($value->attemptedValue, $typeName);
			}
		}
		$enumType = Type::resolveEnum($typeName);
		if($enumType !== null) {
			return ufront_web_mvc_ValueProviderResult::convertEnum($value->attemptedValue, $enumType);
		}
		$classType = Type::resolveClass($typeName);
		if($classType === null) {
			throw new HException(new thx_error_Error("Could not bind to class " . $typeName, null, null, _hx_anonymous(array("fileName" => "DefaultModelBinder.hx", "lineNumber" => 50, "className" => "ufront.web.mvc.DefaultModelBinder", "methodName" => "bindModel"))));
		}
		if(null !== $value && null !== _hx_field($value, "rawValue")) {
			try {
				$v = haxe_Unserializer::run($value->rawValue);
				if(Std::is($v, $classType)) {
					return $v;
				}
			}catch(Exception $»e) {
				$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
				$e = $_ex_;
				{
				}
			}
		}
		if(!thx_type_Rttis::hasInfo($classType)) {
			return null;
		}
		$model = Type::createInstance($classType, new _hx_array(array()));
		$fields = thx_type_Rttis::getClassFields($classType);
		if(null == $fields) throw new HException('null iterable');
		$»it = $fields->iterator();
		while($»it->hasNext()) {
			$f = $»it->next();
			if(thx_type_Rttis::isMethod($f)) {
				continue;
			}
			$typeName1 = thx_type_Rttis::typeName($f->type, false);
			$context = new ufront_web_mvc_ModelBindingContext($f->name, $typeName1, $bindingContext->valueProvider, $f->type);
			$model->{$f->name} = $this->bindModel($controllerContext, $context);
			unset($typeName1,$context);
		}
		return $model;
	}
	public function isSimpleType($typeName) {
		return ufront_web_mvc_ValueProviderResult::$jugglers->exists($typeName);
	}
	function __toString() { return 'ufront.web.mvc.DefaultModelBinder'; }
}
