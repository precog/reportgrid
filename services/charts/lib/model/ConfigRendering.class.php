<?php

class model_ConfigRendering {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->pdf = new model_ConfigPdf();
		$this->image = new model_ConfigImage();
		$this->wk = new model_ConfigWKHtml();
		$this->template = new model_ConfigTemplate();
		$this->allowedFormats;
	}}
	public $allowedFormats;
	public $duration;
	public $cacheExpirationTime;
	public $pdf;
	public $image;
	public $wk;
	public $template;
	public function toString() {
		return "ConfigRendering: " . model_ConfigObjects::fieldsToString($this);
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
	static function create($options) {
		$config = new model_ConfigRendering();
		$config->cacheExpirationTime = $options->cacheExpires;
		$config->duration = model_ConfigRendering_0($config, $options);
		$config->allowedFormats = $options->allowedFormats;
		$config->wk->zoom = $options->zoom;
		$config->pdf->dpi = $options->dpi;
		$config->pdf->grayscale = $options->grayscale;
		$config->pdf->imageDpi = $options->imageDpi;
		$config->pdf->imageQuality = $options->imageQuality;
		$config->pdf->lowQuality = $options->lowQuality;
		$config->pdf->marginTop = $options->marginTop;
		$config->pdf->marginBottom = $options->marginBottom;
		$config->pdf->marginLeft = $options->marginLeft;
		$config->pdf->marginRight = $options->marginRight;
		$config->pdf->portrait = $options->portrait;
		$config->pdf->pageHeight = $options->pageHeight;
		$config->pdf->pageSize = $options->pageSize;
		$config->pdf->pageWidth = $options->pageWidth;
		$config->pdf->title = $options->title;
		$config->pdf->usePrintMediaType = $options->usePrintMediaType;
		$config->pdf->disableSmartShrinking = $options->disableSmartShrinking;
		$config->pdf->footerCenter = $options->footerCenter;
		$config->pdf->footerLeft = $options->footerLeft;
		$config->pdf->footerRight = $options->footerRight;
		$config->pdf->footerFontName = $options->footerFontName;
		$config->pdf->footerFontSize = $options->footerFontSize;
		$config->pdf->footerHtml = $options->footerHtml;
		$config->pdf->footerSpacing = $options->footerSpacing;
		$config->pdf->footerLine = $options->footerLine;
		$config->pdf->headerCenter = $options->headerCenter;
		$config->pdf->headerLeft = $options->headerLeft;
		$config->pdf->headerRight = $options->headerRight;
		$config->pdf->headerFontName = $options->headerFontName;
		$config->pdf->headerFontSize = $options->headerFontSize;
		$config->pdf->headerHtml = $options->headerHtml;
		$config->pdf->headerSpacing = $options->headerSpacing;
		$config->pdf->headerLine = $options->headerLine;
		$config->image->x = $options->x;
		$config->image->y = $options->y;
		$config->image->width = $options->width;
		$config->image->height = $options->height;
		$config->image->screenWidth = $options->screenWidth;
		$config->image->screenHeight = $options->screenHeight;
		$config->image->quality = $options->quality;
		$config->image->disableSmartWidth = $options->disableSmartWidth;
		$config->image->transparent = $options->transparent;
		{
			$_g = 0; $_g1 = Reflect::fields($options->params);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$value = Reflect::field($options->params, $param);
				$config->template->addParameter($param, (($value === true) ? null : $value));
				unset($value,$param);
			}
		}
		{
			$_g = 0; $_g1 = Reflect::fields($options->defaults);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$value = Reflect::field($options->defaults, $param);
				$config->template->setDefault($param, $value);
				unset($value,$param);
			}
		}
		return $config;
	}
	function __toString() { return $this->toString(); }
}
function model_ConfigRendering_0(&$config, &$options) {
	if(null === $options->duration) {
		return null;
	} else {
		return $options->duration;
	}
}
