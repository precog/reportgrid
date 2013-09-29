<?php

class template_RenderableDisplay extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Visualization Info</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Visualization Info</h1>\x0A<h2>General</h2>\x0A<dl>\x0A  <dt>uid:</dt>\x0A  <dd>");
			$__b__->add($__context__->data->uid);
			$__b__->add("</dd>\x0A  <dt>created on:</dt>\x0A  <dd>");
			$__b__->add($__context__->data->createdOn);
			$__b__->add("</dd>\x0A</dl>\x0A<h2>Duration</h2>\x0A<dl>\x0A  <dt>will be erased on:</dt>\x0A");
			if(null === $__context__->data->expiresOn) {
				$__b__->add("\x0A  <dd>will be erased after not being used for ");
				$__b__->add(thx_date_Milli::toString($__context__->data->preserveTimeAfterLastUsage, false));
				$__b__->add("</dd>\x0A");
				null;
			} else {
				$__b__->add("\x0A  <dd>");
				$__b__->add($__context__->data->expiresOn->toString());
				$__b__->add("</dd>\x0A");
				null;
			}
			$__b__->add("\x0A</dl>\x0A<h2>Cache</h2>\x0A<dl>\x0A  <dt>cache expires after:</dt>\x0A  <dd>");
			$__b__->add(thx_date_Milli::toString($__context__->data->cacheExpirationTime, false));
			$__b__->add("</dd>\x0A</dl>\x0A<h2>Download</h2>\x0A<dl class=\"bullet\">\x0A");
			{
				$_g = 0; $_g1 = $__context__->data->formats;
				while($_g < $_g1->length) {
					$format = $_g1[$_g];
					++$_g;
					$__b__->add("\x0A");
					$p = Reflect::field($__context__->data->service, $format);
					$__b__->add("\x0A  <dt>");
					$__b__->add(strtoupper($format));
					$__b__->add(":</dt>\x0A  <dd><a href=\"");
					$__b__->add($p);
					$__b__->add("\">");
					$__b__->add($p);
					$__b__->add("</a></dd>\x0A");
					null;
					unset($p,$format);
				}
			}
			$__b__->add("\x0A</dl>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.RenderableDisplay'; }
}
