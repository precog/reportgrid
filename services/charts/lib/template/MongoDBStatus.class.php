<?php

class template_MongoDBStatus extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>MongoDB Status and Setup</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>MongoDB Status and Setup</h1>\x0A<div>\x0A  <h2>DB</h2>\x0A  <dl>\x0A    <dt>name:</dt>\x0A    <dd>");
			$__b__->add($__context__->db->name);
			$__b__->add("</dd>\x0A    <dt>collections:</dt>\x0A    <dd>");
			$__b__->add($__context__->db->collections->join(", "));
			$__b__->add("</dd>\x0A  </dl>\x0A  <h2>Renderables</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($__context__->renderables->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($__context__->renderables->exists);
			$__b__->add("</dd>\x0A    <dt>renderables:</dt>\x0A    <dd>");
			$__b__->add($__context__->renderables->count);
			$__b__->add("</dd>\x0A  </dl>\x0A  <h2>Cache</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($__context__->cache->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($__context__->cache->exists);
			$__b__->add("</dd>\x0A    <dt>cached values:</dt>\x0A    <dd>");
			$__b__->add($__context__->cache->count);
			$__b__->add("</dd>\x0A  </dl>\x0A  <h2>Config</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($__context__->config->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($__context__->config->exists);
			$__b__->add("</dd>\x0A    <dt>config parameters count:</dt>\x0A    <dd>");
			$__b__->add($__context__->config->count);
			$__b__->add("</dd>\x0A  </dl>  <h2>Logs</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($__context__->logs->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($__context__->logs->exists);
			$__b__->add("</dd>\x0A    <dt>logs count:</dt>\x0A    <dd>");
			$__b__->add($__context__->logs->count);
			$__b__->add("</dd>\x0A  </dl>\x0A</div>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.MongoDBStatus'; }
}
