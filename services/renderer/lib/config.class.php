<?php

class Config
{
	private static $VALID_FORMATS = array('png', 'pdf', 'jpg', 'html');
	private static $VALID_ELEMENTS = array('div', 'span');
	private static $POST_CSS = array('../css/clean.css');

	private $tokenId;
	private $css;
	private $id;
	private $className;
	private $format;
	private $xml;
	private $params;
	private $paramsObject;
	private $backgroundColor;
	private $element;
	private $width;
	private $height;

	public function __construct($tokenId, $css, $id, $className, $format, $xml, $params, $backgroundColor, $element)
	{
		$this->tokenId = $tokenId;
		$this->css = $css;
		$this->id = $id;
		$this->className = $className;
		$this->format = $format;
		$this->xml = $xml;
		$this->params = $params;
		$this->backgroundColor = $backgroundColor;
		$this->element = $element;

		$this->validate();
	}

	public function hash()
	{
		$format = $this->format;
		$this->format = null;
		$hash = hash('md5', var_export($this, true));
		$this->format = $format;
		return $hash;
	}

	private function validate()
	{
		if(!$this->tokenId)
			throw new Exception("Token cannot be empty or null");
		if(!$this->css)
			$this->css = array();
		else if(is_string($this->css))
			$this->css = explode(",",$this->css);
		else if(!is_array($this->css))
			throw new Exception("CSS must be a string or an array of strings");

		if(null == $this->id)
			$this->id = "chart";

		if($this->className)
		{
			// sanitize classname
			$parts = preg_split('/\s+/', $this->className);
			$rg = array_search('rg', $parts);
			if($rg !== false)
				unset($parts[$rg]);
			$this->className = implode(' ', $parts);
		}

		if(null == $this->format)
			$this->format = "png";
		else
			$this->format = strtolower($this->format);

		if(!in_array($this->format, Config::$VALID_FORMATS))
			throw new Exception("Invalid output format '{$this->format}'");

		if(($this->xml && $this->params) || (!$this->xml && !$this->params))
			throw new Exception("You must pass either the 'xml' or 'params' argument");

		// protect against injections or malicious scripts
		if($this->xml)
		{
			if(get_magic_quotes_gpc())
				$this->xml = stripslashes($this->xml);
//			$dom = new DomDocument();
//			$dom->loadXML($this->xml);
//			$this->xml = $dom->saveXML();
		}

		if($this->params)
		{
			if(get_magic_quotes_gpc())
				$this->params = stripslashes($this->params);
			$this->paramsObject = json_decode($this->params, true);
//			$this->params = json_encode(json_decode($this->params, true), true);
		}

		if(!$this->element)
			$this->element = 'div';
		else
			$this->element = strtolower($this->element);

		if(!in_array($this->element, Config::$VALID_ELEMENTS))
			throw new Exception("invalid element container '{$this->element}'");
	}

	public static function fromQueryString($params)
	{
		return new Config(@$params['tokenId'], @$params['css'], @$params['id'], @$params['className'], @$params['format'], @$params['xml'], @$params['params'], @$params['backgroundcolor'], @$params['element']);
	}

	public function tokenId() { return $this->tokenId; }
	public function css() { return array_merge($this->css, Config::$POST_CSS); }
	public function id() { return $this->id; }
	public function className() { return $this->className; }
	public function format() { return $this->format; }
	public function xml() { return $this->xml; }
	public function params() { return $this->params; }
	public function backgroundColor() { return $this->backgroundColor != '' ? $this->backgroundColor : ($this->format == 'jpg' ? '#ffffff' : null); }
	public function element() { return $this->element; }
	public function width()
	{
		if(null == $this->width)
		{
			if(null != $this->xml)
			{
				preg_match('/width="(\d+)"/', $this->xml, $matches);
				$this->width = intval($matches[1]);
			} else {
				$this->width = $this->paramsObject['options']['width'];
			}
		}
		return $this->width;
	}
	public function height()
	{
		if(null == $this->height)
		{
			if(null != $this->xml)
			{
				preg_match('/height="(\d+)"/', $this->xml, $matches);
				$this->height = intval($matches[1]);
			} else {
				$this->height = $this->paramsObject['options']['height'];
			}
		}
		return $this->height;
	}
}