<?php

class template_RenderablesInfo extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Download Error</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Top #");
			$__b__->add($__context__->top);
			$__b__->add(" used renderables</h1>\x0A");
			if(null === $__context__->renderables || $__context__->renderables->length === 0) {
				$__b__->add("\x0A\x09<div class=\"warning\">The list is empty</div>\x0A");
				null;
			} else {
				$__b__->add("\x0A\x09<dl>\x0A\x09");
				{
					$_g = 0; $_g1 = $__context__->renderables;
					while($_g < $_g1->length) {
						$item = $_g1[$_g];
						++$_g;
						$__b__->add("\x0A\x09  <dt><a href=\"");
						$__b__->add($__context__->baseurl);
						$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "renderableAPI", "action" => "display", "uid" => $item->uid, "outputformat" => "html"))));
						$__b__->add("\">");
						$__b__->add($item->uid);
						$__b__->add("</a></dt>\x0A\x09  <dd>");
						$__b__->add($item->usages);
						$__b__->add(", created on: ");
						$__b__->add(Date::fromTime($item->createdOn));
						$__b__->add(" ");
						if($item->createdOn !== $item->lastUsage) {
							$__b__->add(", last usage on: ");
							$__b__->add(Date::fromTime($item->lastUsage));
							null;
						}
						$__b__->add("</dd>\x0A\x09");
						null;
						unset($item);
					}
				}
				$__b__->add("\x0A\x09</dl>\x0A");
				null;
			}
			$__b__->add("\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.RenderablesInfo'; }
}
