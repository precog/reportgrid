<?php

class ufront_web_UserAgent {
	public function __construct($browser, $version, $majorVersion, $minorVersion, $platform) {
		if(!php_Boot::$skip_constructor) {
		$this->browser = $browser;
		$this->version = $version;
		$this->majorVersion = $majorVersion;
		$this->minorVersion = $minorVersion;
		$this->platform = $platform;
	}}
	public $browser;
	public $version;
	public $majorVersion;
	public $minorVersion;
	public $platform;
	public function toString() {
		return $this->browser . " v." . $this->majorVersion . "." . $this->minorVersion . " (" . $this->version . ") on " . $this->platform;
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
	static $dataBrowser;
	static $dataOS;
	static function fromString($s) {
		$ua = new ufront_web_UserAgent("unknown", "", 0, 0, "unknown");
		$info = ufront_web_UserAgent::searchString(ufront_web_UserAgent::$dataBrowser, $s);
		if(null !== $info) {
			$ua->browser = $info->app;
			$version = ufront_web_UserAgent::extractVersion($info->versionString, $s);
			if(null !== $version) {
				$ua->version = $version->version;
				$ua->majorVersion = $version->majorVersion;
				$ua->minorVersion = $version->minorVersion;
			}
		}
		$info1 = ufront_web_UserAgent::searchString(ufront_web_UserAgent::$dataOS, $s);
		if(null !== $info1) {
			$ua->platform = $info1->app;
		}
		return $ua;
	}
	static function extractVersion($searchString, $s) {
		$index = _hx_index_of($s, $searchString, null);
		if($index < 0) {
			return null;
		}
		$re = new EReg("(\\d+)\\.(\\d+)[^ ();]*", "");
		if(!$re->match(_hx_substr($s, $index + strlen($searchString) + 1, null))) {
			return null;
		}
		return _hx_anonymous(array("version" => $re->matched(0), "majorVersion" => Std::parseInt($re->matched(1)), "minorVersion" => Std::parseInt($re->matched(2))));
	}
	static function searchString($data, $s) {
		{
			$_g = 0;
			while($_g < $data->length) {
				$d = $data[$_g];
				++$_g;
				if(_hx_index_of($s, $d->subString, null) >= 0) {
					return _hx_anonymous(array("app" => $d->identity, "versionString" => ufront_web_UserAgent_0($_g, $d, $data, $s)));
				}
				unset($d);
			}
		}
		return null;
	}
	function __toString() { return $this->toString(); }
}
ufront_web_UserAgent::$dataBrowser = new _hx_array(array(_hx_anonymous(array("subString" => "Chrome", "identity" => "Chrome")), _hx_anonymous(array("subString" => "OmniWeb", "versionSearch" => "OmniWeb/", "identity" => "OmniWeb")), _hx_anonymous(array("subString" => "Apple", "identity" => "Safari", "versionSearch" => "Version")), _hx_anonymous(array("subString" => "Opera", "versionSearch" => "Version", "identity" => "Opera")), _hx_anonymous(array("subString" => "iCab", "identity" => "iCab")), _hx_anonymous(array("subString" => "KDE", "identity" => "Konqueror")), _hx_anonymous(array("subString" => "Firefox", "identity" => "Firefox")), _hx_anonymous(array("subString" => "Camino", "identity" => "Camino")), _hx_anonymous(array("subString" => "Netscape", "identity" => "Netscape")), _hx_anonymous(array("subString" => "MSIE", "identity" => "Explorer", "versionSearch" => "MSIE")), _hx_anonymous(array("subString" => "Gecko", "identity" => "Mozilla", "versionSearch" => "rv")), _hx_anonymous(array("subString" => "Mozilla", "identity" => "Netscape", "versionSearch" => "Mozilla"))));
ufront_web_UserAgent::$dataOS = new _hx_array(array(_hx_anonymous(array("subString" => "Win", "identity" => "Windows")), _hx_anonymous(array("subString" => "Mac", "identity" => "Mac")), _hx_anonymous(array("subString" => "iPhone", "identity" => "iPhone/iPod")), _hx_anonymous(array("subString" => "Linux", "identity" => "Linux"))));
function ufront_web_UserAgent_0(&$_g, &$d, &$data, &$s) {
	if(null === _hx_field($d, "versionSearch")) {
		return $d->identity;
	} else {
		return $d->versionSearch;
	}
}
