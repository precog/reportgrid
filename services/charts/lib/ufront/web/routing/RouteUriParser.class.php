<?php

class ufront_web_routing_RouteUriParser {
	public function __construct() {
		;
	}
	public $restUsed;
	public function parse($uri, $implicitOptionals) {
		if(null === $uri) {
			throw new HException(new thx_error_NullArgument("uri", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 16, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "parse"))));
		}
		$segments = _hx_explode("/", $uri);
		if($segments->length <= 1) {
			throw new HException(new thx_error_Error("a uri must start with a slash", null, null, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 19, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "parse"))));
		}
		$strip = $segments->shift();
		if(strlen($strip) > 0) {
			throw new HException(new thx_error_Error("there can't be anything before the first slash", null, null, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 23, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "parse"))));
		}
		$this->restUsed = false;
		$capturedParams = new thx_collection_Set();
		$result = new _hx_array(array());
		$segment = null;
		while(null !== ($segment = $segments->shift())) {
			$result->push($this->_parseSegment($segment, $segments, $implicitOptionals, $capturedParams));
		}
		return $result;
	}
	public function _assembleSegment($stack) {
		$parts = new _hx_array(array());
		$optional = true;
		$rest = false;
		$last = $stack->length - 1;
		$i = 0;
		while($i <= $last) {
			$seg = $stack[$i];
			if(0 === $i && $i === $last) {
				$퍁 = ($seg);
				switch($퍁->index) {
				case 0:
				case 1:
				{
					$parts->push($seg);
					$optional = false;
				}break;
				case 6:
				{
					$parts->push($seg);
					$optional = false;
					$rest = true;
				}break;
				case 2:
				{
					$parts->push($seg);
				}break;
				case 7:
				{
					$parts->push($seg);
					$rest = true;
				}break;
				case 3:
				case 4:
				case 5:
				$name = $퍁->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
				}break;
				case 8:
				case 9:
				case 10:
				$name = $퍁->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
					$rest = true;
				}break;
				}
			} else {
				if($i === $last) {
					$퍁 = ($seg);
					switch($퍁->index) {
					case 0:
					case 1:
					{
						$parts->push($seg);
						$optional = false;
					}break;
					case 6:
					{
						$parts->push($seg);
						$optional = false;
						$rest = true;
					}break;
					case 2:
					{
						$parts->push($seg);
					}break;
					case 7:
					{
						$parts->push($seg);
						$rest = true;
					}break;
					case 3:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
						} else {
							$parts->push($seg);
						}
					}break;
					case 8:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
						} else {
							$parts->push($seg);
						}
						$rest = true;
					}break;
					case 4:
					$name = $퍁->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
					}break;
					case 5:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptLParam($name, $left));
					}break;
					case 9:
					$name = $퍁->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
						$rest = true;
					}break;
					case 10:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptLRest($name, $left));
						$rest = true;
					}break;
					}
				} else {
					$퍁 = ($seg);
					switch($퍁->index) {
					case 0:
					$value = $퍁->params[0];
					{
						$퍁2 = ($stack[$i + 1]);
						switch($퍁2->index) {
						case 3:
						$name = $퍁2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptLParam($name, $value));
							$i++;
						}break;
						case 8:
						$name = $퍁2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptLRest($name, $value));
							$i++;
							$rest = true;
						}break;
						case 5:
						$name = $퍁2->params[0];
						{
							$stack[$i + 1] = ufront_web_routing_UriPart::UPOptBParam($name, $value, null);
						}break;
						case 10:
						$name = $퍁2->params[0];
						{
							$stack[$i + 1] = ufront_web_routing_UriPart::UPOptBRest($name, $value, null);
							$rest = true;
						}break;
						case 0:
						case 1:
						case 2:
						case 4:
						{
							$parts->push($seg);
							$optional = false;
						}break;
						case 6:
						case 7:
						case 9:
						{
							$parts->push($seg);
							$optional = false;
							$rest = true;
						}break;
						}
					}break;
					case 1:
					{
						$parts->push($seg);
						$optional = false;
					}break;
					case 6:
					{
						$parts->push($seg);
						$optional = false;
						$rest = true;
					}break;
					case 2:
					{
						$parts->push($seg);
					}break;
					case 7:
					{
						$parts->push($seg);
						$rest = true;
					}break;
					case 3:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
						} else {
							$parts->push($seg);
						}
					}break;
					case 4:
					$name = $퍁->params[0];
					{
						$퍁2 = ($stack[$i + 1]);
						switch($퍁2->index) {
						case 0:
						$value = $퍁2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptRParam($name, $value));
							$i++;
						}break;
						default:{
							ufront_web_routing_UriPart::UPOptParam($name);
						}break;
						}
					}break;
					case 5:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						$퍁2 = ($stack[$i + 1]);
						switch($퍁2->index) {
						case 0:
						$value = $퍁2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptBParam($name, $left, $value));
							$i++;
						}break;
						default:{
							ufront_web_routing_UriPart::UPOptLParam($name, $left);
						}break;
						}
					}break;
					case 8:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
						} else {
							$parts->push($seg);
						}
						$rest = true;
					}break;
					case 9:
					$name = $퍁->params[0];
					{
						$퍁2 = ($stack[$i + 1]);
						switch($퍁2->index) {
						case 0:
						$value = $퍁2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptRRest($name, $value));
							$i++;
						}break;
						default:{
							ufront_web_routing_UriPart::UPOptRest($name);
						}break;
						}
						$rest = true;
					}break;
					case 10:
					$left = $퍁->params[1]; $name = $퍁->params[0];
					{
						$퍁2 = ($stack[$i + 1]);
						switch($퍁2->index) {
						case 0:
						$value = $퍁2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptBRest($name, $left, $value));
							$i++;
						}break;
						default:{
							ufront_web_routing_UriPart::UPOptLRest($name, $left);
						}break;
						}
						$rest = true;
					}break;
					}
				}
			}
			$i++;
			unset($seg);
		}
		if($parts->length === 0) {
			$optional = false;
		}
		return _hx_anonymous(array("optional" => $optional, "rest" => $rest, "parts" => $parts));
	}
	public function _parseSegment($segment, $segments, $implicitOptionals, $capturedParams) {
		$stack = new _hx_array(array());
		$seg = $segment;
		while(strlen($seg) > 0) {
			if(ufront_web_routing_RouteUriParser::$constPattern->match($seg)) {
				$stack->push(ufront_web_routing_UriPart::UPConst(ufront_web_routing_RouteUriParser::$constPattern->matched(1)));
				$seg = ufront_web_routing_RouteUriParser::$constPattern->matchedRight();
			} else {
				if(ufront_web_routing_RouteUriParser::$paramPattern->match($seg)) {
					$name = ufront_web_routing_RouteUriParser::$paramPattern->matched(3);
					if($capturedParams->exists($name)) {
						throw new HException(new thx_error_Error("param '{0}' already used in path", null, $name, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 215, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "_parseSegment"))));
					} else {
						$capturedParams->add($name);
					}
					$isleftopt = ufront_web_routing_RouteUriParser::$paramPattern->matched(1) === "?";
					$isrest = ufront_web_routing_RouteUriParser::$paramPattern->matched(2) === "*";
					$isrightopt = ufront_web_routing_RouteUriParser::$paramPattern->matched(4) === "?";
					$isopt = ufront_web_routing_RouteUriParser::$paramPattern->matched(1) === "\$" || !$isleftopt && !$isrightopt && $implicitOptionals->exists($name);
					if($this->restUsed) {
						throw new HException(new thx_error_Error("there can be just one rest (*) parameter and it must be the last one", null, null, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 225, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "_parseSegment"))));
					}
					if($isrest) {
						$this->restUsed = true;
						if($isleftopt && $isrightopt) {
							$stack->push(ufront_web_routing_UriPart::UPOptBRest($name, null, null));
						} else {
							if($isleftopt) {
								$stack->push(ufront_web_routing_UriPart::UPOptLRest($name, null));
							} else {
								if($isrightopt) {
									$stack->push(ufront_web_routing_UriPart::UPOptRRest($name, null));
								} else {
									if($isopt) {
										$stack->push(ufront_web_routing_UriPart::UPOptRest($name));
									} else {
										$stack->push(ufront_web_routing_UriPart::UPRest($name));
									}
								}
							}
						}
						$seg = ufront_web_routing_RouteUriParser::$paramPattern->matchedRight() . ufront_web_routing_RouteUriParser::reduceRestSegments($segments);
					} else {
						if($isleftopt && $isrightopt) {
							$stack->push(ufront_web_routing_UriPart::UPOptBParam($name, null, null));
						} else {
							if($isleftopt) {
								$stack->push(ufront_web_routing_UriPart::UPOptLParam($name, null));
							} else {
								if($isrightopt) {
									$stack->push(ufront_web_routing_UriPart::UPOptRParam($name, null));
								} else {
									if($isopt) {
										$stack->push(ufront_web_routing_UriPart::UPOptParam($name));
									} else {
										$stack->push(ufront_web_routing_UriPart::UPParam($name));
									}
								}
							}
						}
						$seg = ufront_web_routing_RouteUriParser::$paramPattern->matchedRight();
					}
					unset($name,$isrightopt,$isrest,$isopt,$isleftopt);
				} else {
					throw new HException(new thx_error_Error("invalid uri segment '{0}'", null, $seg, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 256, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "_parseSegment"))));
				}
			}
		}
		return $this->_assembleSegment($stack);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->팪ynamics[$m]) && is_callable($this->팪ynamics[$m]))
			return call_user_func_array($this->팪ynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	static $constPattern;
	static $paramPattern;
	static function reduceRestSegments($segments) {
		if($segments->length === 0) {
			return "";
		}
		$segment = "/" . $segments->join("/");
		while($segments->length > 0) {
			$segments->pop();
		}
		return $segment;
	}
	function __toString() { return 'ufront.web.routing.RouteUriParser'; }
}
ufront_web_routing_RouteUriParser::$constPattern = new EReg("^([^{]+)", "");
ufront_web_routing_RouteUriParser::$paramPattern = new EReg("^\\{([?\$])?([*])?([a-z0-9_]+)(\\?)?\\}", "");
