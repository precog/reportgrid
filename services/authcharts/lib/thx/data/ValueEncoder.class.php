<?php

class thx_data_ValueEncoder {
	public function __construct($handler) {
		if(!php_Boot::$skip_constructor) {
		$this->handler = $handler;
	}}
	public $handler;
	public function encode($o) {
		$this->handler->start();
		$this->encodeValue($o);
		$this->handler->end();
	}
	public function encodeValue($o) {
		$»t = (Type::typeof($o));
		switch($»t->index) {
		case 0:
		{
			$this->handler->null();
		}break;
		case 1:
		{
			$this->handler->int($o);
		}break;
		case 2:
		{
			$this->handler->float($o);
		}break;
		case 3:
		{
			$this->handler->bool($o);
		}break;
		case 4:
		{
			$this->encodeObject($o);
		}break;
		case 5:
		{
			throw new HException(new thx_error_Error("unable to encode TFunction type", null, null, _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 39, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
		}break;
		case 6:
		$c = $»t->params[0];
		{
			if(Std::is($o, _hx_qtype("String"))) {
				$this->handler->string($o);
			} else {
				if(Std::is($o, _hx_qtype("Array"))) {
					$this->encodeArray($o);
				} else {
					if(Std::is($o, _hx_qtype("Date"))) {
						$this->handler->date($o);
					} else {
						if(Std::is($o, _hx_qtype("Hash"))) {
							$this->encodeHash($o);
						} else {
							if(Std::is($o, _hx_qtype("List"))) {
								$this->encodeList($o);
							} else {
								throw new HException(new thx_error_Error("unable to encode class '{0}'", null, Type::getClassName($c), _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 53, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
							}
						}
					}
				}
			}
		}break;
		case 7:
		$e = $»t->params[0];
		{
			throw new HException(new thx_error_Error("unable to encode TEnum type '{0}'", null, Type::getEnumName($e), _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 55, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
		}break;
		case 8:
		{
			throw new HException(new thx_error_Error("unable to encode TUnknown type", null, null, _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 57, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
		}break;
		}
	}
	public function encodeObject($o) {
		$this->handler->startObject();
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$this->handler->startField($key);
				$this->encodeValue(Reflect::field($o, $key));
				$this->handler->endField();
				unset($key);
			}
		}
		$this->handler->endObject();
	}
	public function encodeHash($o) {
		$this->handler->startObject();
		if(null == $o) throw new HException('null iterable');
		$»it = $o->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			$this->handler->startField($key);
			$this->encodeValue($o->get($key));
			$this->handler->endField();
		}
		$this->handler->endObject();
	}
	public function encodeList($list) {
		$this->handler->startArray();
		if(null == $list) throw new HException('null iterable');
		$»it = $list->iterator();
		while($»it->hasNext()) {
			$item = $»it->next();
			$this->handler->startItem();
			$this->encodeValue($item);
			$this->handler->endItem();
		}
		$this->handler->endArray();
	}
	public function encodeArray($a) {
		$this->handler->startArray();
		{
			$_g = 0;
			while($_g < $a->length) {
				$item = $a[$_g];
				++$_g;
				$this->handler->startItem();
				$this->encodeValue($item);
				$this->handler->endItem();
				unset($item);
			}
		}
		$this->handler->endArray();
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
	function __toString() { return 'thx.data.ValueEncoder'; }
}
