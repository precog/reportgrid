<?php

class model_ConfigObjects {
	public function __construct(){}
	static $FORMATS;
	static function createDefault() {
		return _hx_anonymous(array("cacheExpires" => 43200000., "duration" => null, "allowedFormats" => new _hx_array(array("pdf", "png", "jpg", "svg")), "params" => _hx_anonymous(array()), "defaults" => _hx_anonymous(array()), "zoom" => 1.0, "dpi" => null, "grayscale" => false, "imageDpi" => null, "imageQuality" => null, "lowQuality" => false, "marginTop" => null, "marginBottom" => null, "marginLeft" => null, "marginRight" => null, "portrait" => true, "pageHeight" => null, "pageSize" => null, "pageWidth" => null, "title" => null, "usePrintMediaType" => false, "disableSmartShrinking" => false, "footerCenter" => null, "footerLeft" => null, "footerRight" => null, "footerFontName" => null, "footerFontSize" => null, "footerHtml" => null, "footerSpacing" => null, "footerLine" => false, "headerCenter" => null, "headerLeft" => null, "headerRight" => null, "headerFontName" => null, "headerFontSize" => null, "headerHtml" => null, "headerSpacing" => null, "headerLine" => false, "x" => null, "y" => null, "width" => null, "height" => null, "screenWidth" => null, "screenHeight" => null, "quality" => null, "disableSmartWidth" => false, "transparent" => false));
	}
	static function overrideValues($config, $over) {
		if(null !== _hx_field($over, "duration")) {
			$e = $over->duration;
			if(Std::is($e, _hx_qtype("Float"))) {
				if($e <= 0) {
					throw new HException(new thx_error_Error("invalid negative value for duration: {0}", new _hx_array(array($e)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 80, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
				}
				$config->duration = $e;
			} else {
				if(Std::is($e, _hx_qtype("String"))) {
					$v = thx_date_Milli::parse($e);
					if($v <= 0) {
						throw new HException(new thx_error_Error("invalid expression for duration: {0}", new _hx_array(array($e)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 85, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
					}
					$config->duration = $v;
				} else {
					throw new HException(new thx_error_Error("invalid value type for duration: {0}", new _hx_array(array($e)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 88, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
				}
			}
		}
		if(null !== _hx_field($over, "cache")) {
			$e = $over->cache;
			if(Std::is($e, _hx_qtype("Float"))) {
				if($e <= 0) {
					throw new HException(new thx_error_Error("invalid negative value for cacheExpires: {0}", new _hx_array(array($e)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 97, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
				}
				$config->cacheExpires = $e;
			} else {
				if(Std::is($e, _hx_qtype("String"))) {
					$v = thx_date_Milli::parse($e);
					if($v <= 0) {
						throw new HException(new thx_error_Error("invalid expression for cacheExpires: {0}", new _hx_array(array($e)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 102, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
					}
					$config->cacheExpires = $v;
				} else {
					throw new HException(new thx_error_Error("invalid value type for cacheExpires: {0}", new _hx_array(array($e)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 105, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
				}
			}
		}
		if(null !== _hx_field($over, "formats")) {
			$v = $over->formats; $values = new thx_collection_Set();
			if(Std::is($v, _hx_qtype("String"))) {
				$s = $v;
				$arr = _hx_explode(",", $s);
				{
					$_g = 0;
					while($_g < $arr->length) {
						$item = $arr[$_g];
						++$_g;
						$values->add($item);
						unset($item);
					}
				}
			} else {
				if(Std::is($v, _hx_qtype("Array"))) {
					$arr = $v;
					{
						$_g = 0;
						while($_g < $arr->length) {
							$item = $arr[$_g];
							++$_g;
							$values->add("" . $item);
							unset($item);
						}
					}
				}
			}
			$config->allowedFormats = new _hx_array(array());
			if(null == $values) throw new HException('null iterable');
			$»it = $values->iterator();
			while($»it->hasNext()) {
				$item = $»it->next();
				$s = strtolower(trim($item));
				if(!Arrays::exists(model_ConfigObjects::$FORMATS, $s, null)) {
					throw new HException(new thx_error_Error("the format '{0}' is not supported", new _hx_array(array($item)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 128, "className" => "model.ConfigObjects", "methodName" => "overrideValues"))));
				}
				$config->allowedFormats->push($s);
				unset($s);
			}
		}
		if(null !== _hx_field($over, "params")) {
			$_g = 0; $_g1 = Reflect::fields($over->params);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$value = Reflect::field($over->params, $param);
				if(Std::is($value, _hx_qtype("Array"))) {
					$config->params->{$param} = $value;
				} else {
					$config->params->{$param} = true;
				}
				unset($value,$param);
			}
		}
		if(null !== _hx_field($over, "defaults")) {
			$_g = 0; $_g1 = Reflect::fields($over->defaults);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$value = Reflect::field($over->defaults, $param);
				$config->defaults->{$param} = $value;
				unset($value,$param);
			}
		}
		$config->zoom = model_ConfigObjects::parseFloat($over->zoom, "zoom");
		$config->dpi = model_ConfigObjects::parseInt($over->dpi, "dpi");
		$config->grayscale = model_ConfigObjects::parseBool($over->grayscale, null, "grayscale");
		$config->imageDpi = model_ConfigObjects::parseInt($over->imageDpi, "imageDpi");
		$config->imageQuality = model_ConfigObjects::parseInt($over->imageQuality, "imageQuality");
		$config->lowQuality = model_ConfigObjects::parseBool($over->lowQuality, null, "lowQuality");
		$config->marginTop = model_ConfigObjects::parseUnit($over->marginTop, "marginTop");
		$config->marginBottom = model_ConfigObjects::parseUnit($over->marginBottom, "marginBottom");
		$config->marginLeft = model_ConfigObjects::parseUnit($over->marginLeft, "marginLeft");
		$config->marginRight = model_ConfigObjects::parseUnit($over->marginRight, "marginRight");
		$config->portrait = model_ConfigObjects::parseBool($over->portrait, true, "portrait");
		$config->pageHeight = model_ConfigObjects::parseUnit($over->pageHeight, "pageHeight");
		$config->pageSize = model_ConfigObjects::parsePaperSize($over->pageSize, "pageSize");
		$config->pageWidth = model_ConfigObjects::parseUnit($over->pageWidth, "pageWidth");
		$config->title = model_ConfigObjects::parseString($over->title, "title");
		$config->usePrintMediaType = model_ConfigObjects::parseBool($over->usePrintMediaType, null, "usePrintMediaType");
		$config->disableSmartShrinking = model_ConfigObjects::parseBool($over->disableSmartShrinking, null, "disableSmartShrinking");
		$config->footerCenter = model_ConfigObjects::parseString($over->footerCenter, "footerCenter");
		$config->footerLeft = model_ConfigObjects::parseString($over->footerLeft, "footerLeft");
		$config->footerRight = model_ConfigObjects::parseString($over->footerRight, "footerRight");
		$config->footerFontName = model_ConfigObjects::parseString($over->footerFontName, "footerFontName");
		$config->footerFontSize = model_ConfigObjects::parseString($over->footerFontSize, "footerFontSize");
		$config->footerHtml = model_ConfigObjects::parseString($over->footerHtml, "footerHtml");
		$config->footerSpacing = model_ConfigObjects::parseFloat($over->footerSpacing, "footerSpacing");
		$config->footerLine = model_ConfigObjects::parseBool($over->footerLine, null, "footerLine");
		$config->headerCenter = model_ConfigObjects::parseString($over->headerCenter, "headerCenter");
		$config->headerLeft = model_ConfigObjects::parseString($over->headerLeft, "headerLeft");
		$config->headerRight = model_ConfigObjects::parseString($over->headerRight, "headerRight");
		$config->headerFontName = model_ConfigObjects::parseString($over->headerFontName, "headerFontName");
		$config->headerFontSize = model_ConfigObjects::parseString($over->headerFontSize, "headerFontSize");
		$config->headerHtml = model_ConfigObjects::parseString($over->headerHtml, "headerHtml");
		$config->headerSpacing = model_ConfigObjects::parseFloat($over->headerSpacing, "headerSpacing");
		$config->headerLine = model_ConfigObjects::parseBool($over->headerLine, null, "headerLine");
		$config->x = model_ConfigObjects::parseInt($over->x, "x");
		$config->y = model_ConfigObjects::parseInt($over->y, "y");
		$config->width = model_ConfigObjects::parseInt($over->width, "width");
		$config->height = model_ConfigObjects::parseInt($over->height, "height");
		$config->screenWidth = model_ConfigObjects::parseInt($over->screenWidth, "screenWidth");
		$config->screenHeight = model_ConfigObjects::parseInt($over->screenHeight, "screenHeight");
		$config->quality = model_ConfigObjects::parseQuality($over->quality, "quality");
		$config->disableSmartWidth = model_ConfigObjects::parseBool($over->disableSmartWidth, null, "disableSmartWidth");
		$config->transparent = model_ConfigObjects::parseBool($over->transparent, null, "transparent");
		return $config;
	}
	static function parsePaperSize($v, $field) {
		$s = model_ConfigObjects::parseString($v, $field);
		if(null === $s) {
			return $s;
		}
		if(!Arrays::exists(model_WKHtmlToPdf::$allowedPaperSize, $s, null)) {
			throw new HException(new thx_error_Error("invalid paper size '{0}'", new _hx_array(array($v)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 210, "className" => "model.ConfigObjects", "methodName" => "parsePaperSize"))));
		}
		return $s;
	}
	static function parseUnit($v, $field) {
		$s = model_ConfigObjects::parseString($v, $field);
		if(null === $s) {
			return $s;
		}
		if(!model_WKHtmlToPdf::validateUnitReal($s)) {
			throw new HException(new thx_error_Error("invalid unit size '{0}' for '{1}'", new _hx_array(array($v, $field)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 220, "className" => "model.ConfigObjects", "methodName" => "parseUnit"))));
		}
		return $s;
	}
	static function parseQuality($v, $field) {
		$i = model_ConfigObjects::parseInt($v, $field);
		if(null === $i) {
			return null;
		}
		if($i < 0 || $i > 100) {
			throw new HException(new thx_error_Error("quality must be an integer value between 0 and 100", null, null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 230, "className" => "model.ConfigObjects", "methodName" => "parseQuality"))));
		}
		return $i;
	}
	static function parseString($v, $field) {
		if(null === $v) {
			return null;
		} else {
			return "" . $v;
		}
	}
	static function parseBool($v, $alt, $field) {
		if($alt === null) {
			$alt = false;
		}
		if(null === $v) {
			return $alt;
		}
		if(Std::is($v, _hx_qtype("Bool"))) {
			return $v;
		} else {
			if(Std::is($v, _hx_qtype("Int"))) {
				return !_hx_equal($v, 0);
			} else {
				if(Std::is($v, _hx_qtype("String")) && Bools::canParse($v)) {
					return Bools::parse($v);
				} else {
					throw new HException(new thx_error_Error("unsupported value '{0}' for {1}", new _hx_array(array($v, $field)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 252, "className" => "model.ConfigObjects", "methodName" => "parseBool"))));
				}
			}
		}
	}
	static function parseInt($v, $field) {
		if(null === $v) {
			return null;
		}
		if(Std::is($v, _hx_qtype("Int"))) {
			return $v;
		} else {
			if(Std::is($v, _hx_qtype("String")) && Ints::canParse($v)) {
				return Ints::parse($v);
			} else {
				throw new HException(new thx_error_Error("unsupported value '{0}' for {1}", new _hx_array(array($v, $field)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 263, "className" => "model.ConfigObjects", "methodName" => "parseInt"))));
			}
		}
	}
	static function parseFloat($v, $field) {
		if(null === $v) {
			return null;
		}
		if(Std::is($v, _hx_qtype("Float"))) {
			return $v;
		} else {
			if(Std::is($v, _hx_qtype("String")) && Floats::canParse($v)) {
				return Floats::parse($v);
			} else {
				throw new HException(new thx_error_Error("unsupported value '{0}' for {1}", new _hx_array(array($v, $field)), null, _hx_anonymous(array("fileName" => "ConfigObjects.hx", "lineNumber" => 274, "className" => "model.ConfigObjects", "methodName" => "parseFloat"))));
			}
		}
	}
	static function fieldsToString($o) {
		$fields = Reflect::fields($o); $pairs = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $fields->length) {
				$field = $fields[$_g];
				++$_g;
				$value = Reflect::field($o, $field);
				if(null === $value) {
					continue;
				}
				$pairs->push($field . ": " . $value);
				unset($value,$field);
			}
		}
		return $pairs->join(", ");
	}
	function __toString() { return 'model.ConfigObjects'; }
}
model_ConfigObjects::$FORMATS = new _hx_array(array("pdf", "png", "jpg", "html", "ps", "svg", "bmp", "tif"));
