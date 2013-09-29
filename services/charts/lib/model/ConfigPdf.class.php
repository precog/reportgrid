<?php

class model_ConfigPdf {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->grayscale = false;
		$this->lowQuality = false;
		$this->portrait = true;
		$this->usePrintMediaType = false;
		$this->disableSmartShrinking = false;
		$this->footerLine = false;
		$this->headerLine = false;
	}}
	public $dpi;
	public $grayscale;
	public $imageDpi;
	public $imageQuality;
	public $lowQuality;
	public $marginTop;
	public $marginBottom;
	public $marginLeft;
	public $marginRight;
	public $portrait;
	public $pageHeight;
	public $pageSize;
	public $pageWidth;
	public $title;
	public $usePrintMediaType;
	public $disableSmartShrinking;
	public $footerCenter;
	public $footerLeft;
	public $footerRight;
	public $footerFontName;
	public $footerFontSize;
	public $footerHtml;
	public $footerSpacing;
	public $footerLine;
	public $headerCenter;
	public $headerLeft;
	public $headerRight;
	public $headerFontName;
	public $headerFontSize;
	public $headerHtml;
	public $headerSpacing;
	public $headerLine;
	public function toString() {
		return "ConfigPdf: " . model_ConfigObjects::fieldsToString($this);
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
	function __toString() { return $this->toString(); }
}
