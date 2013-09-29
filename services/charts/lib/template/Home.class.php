<?php

class template_Home extends erazor_macro_Template {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute($__context__) {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Rendering Service (v.");
			$__b__->add($__context__->version);
			$__b__->add(")</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Rendering Service (v.");
			$__b__->add($__context__->version);
			$__b__->add(")</h1>\x0A<h2>Upload Options</h2>\x0A<h3>HTML/Config</h3>\x0A<ul class=\"bullet\">\x0A  <li>Upload using a form: <a href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "display"))));
			$__b__->add("\" class=\"tag\">");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "display"))));
			$__b__->add("</a></li>\x0A  <li>Upload using a form and display result: <a href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "display", "displayFormat" => "png"))));
			$__b__->add("\" class=\"tag\">");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "display", "displayFormat" => "png"))));
			$__b__->add("</a></li>\x0A  <li>Upload making a POST call to these services <span class=\"params\">(parameters: html (string), ?config (ini or json string)</span>:\x0A    <dl>\x0A      <dt>HTML output:</dt>\x0A      <dd>");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "renderableAPI", "action" => "upload", "outputformat" => "html"))));
			$__b__->add("</dd>\x0A      <dt>JSON output:</dt>\x0A      <dd>");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "renderableAPI", "action" => "upload", "outputformat" => "json"))));
			$__b__->add("</dd>\x0A    </dl>\x0A  </li>\x0A  <li>Upload making a GET/POST call to these service <span class=\"params\">(parameters: urlhtml (path to a html resource), ?urlconfig (path to a ini or json resource)</span>:\x0A    <dl>\x0A      <dt>HTML output:</dt>\x0A      <dd>");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "renderableAPI", "action" => "uploadFromUrl", "outputformat" => "html", "urlhtml" => "http://example.com/chart.hml"))));
			$__b__->add("</dd>\x0A      <dt>JSON output:</dt>\x0A      <dd>");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "renderableAPI", "action" => "uploadFromUrl", "outputformat" => "json", "urlhtml" => "http://example.com/chart.hml"))));
			$__b__->add("</dd>\x0A    </dl>\x0A  </li>\x0A</ul>\x0A<h3>GIST</h3>\x0A<ul class=\"bullet\">\x0A  <li>Upload GIST using a form: <a href=\"");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "gist"))));
			$__b__->add("\" class=\"tag\">");
			$__b__->add($__context__->baseurl);
			$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "uploadForm", "action" => "gist"))));
			$__b__->add("</a></li>\x0A  <li>Upload from GIST using these services:\x0A    <dl>\x0A      <dt>HTML output:</dt>\x0A");
			$path = $__context__->baseurl . $__context__->url->route(_hx_anonymous(array("controller" => "gistUpload", "action" => "importGist", "gistid" => "1732325", "outputformat" => "html")));
			$__b__->add("\x0A      <dd><a href=\"");
			$__b__->add($path);
			$__b__->add("\">");
			$__b__->add($path);
			$__b__->add("</a></dd>\x0A      <dt>JSON output:</dt>\x0A");
			$path1 = $__context__->baseurl . $__context__->url->route(_hx_anonymous(array("controller" => "gistUpload", "action" => "importGist", "gistid" => "1732325", "outputformat" => "json")));
			$__b__->add("\x0A      <dd><a href=\"");
			$__b__->add($path1);
			$__b__->add("\">");
			$__b__->add($path1);
			$__b__->add("</a></dd>\x0A    </dl>\x0A  </li>\x0A</ul>\x0A\x0A\x0A<h2>Download</h2>\x0A<dl class=\"bullet\">\x0A");
			$uid = $__context__->sampleuid;
			$__b__->add("\x0A");
			{
				$_g = 0; $_g1 = new _hx_array(array("html", "json"));
				while($_g < $_g1->length) {
					$ext = $_g1[$_g];
					++$_g;
					$__b__->add("\x0A  ");
					$p = $__context__->baseurl . $__context__->url->route(_hx_anonymous(array("controller" => "renderableAPI", "action" => "display", "uid" => ((null === $uid) ? "uid" : $uid), "outputformat" => $ext)));
					$__b__->add("\x0A  <dt>");
					$__b__->add(strtoupper($ext));
					$__b__->add(" Information:</dt>\x0A  ");
					if(null === $uid) {
						$__b__->add("\x0A    <dd>");
						$__b__->add($p);
						$__b__->add("</dd>\x0A  ");
						null;
					} else {
						$__b__->add("\x0A    <dd><a href=\"");
						$__b__->add($p);
						$__b__->add("\">");
						$__b__->add($p);
						$__b__->add("</a></dd>\x0A  ");
						null;
					}
					$__b__->add("\x0A");
					null;
					unset($p,$ext);
				}
			}
			$__b__->add("\x0A</dl>\x0A\x0A");
			if($__context__->authorized) {
				$__b__->add("\x0A<h2>Status</h2>\x0A<ul class=\"bullet\">\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "mongodb", "auth" => $__context__->auth))));
				$__b__->add("\">DB</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "topRenderables", "auth" => $__context__->auth))));
				$__b__->add("\">Renderables</a></li>\x0A</ul>\x0A\x0A<h2>Maintenance</h2>\x0A<ul class=\"bullet\">\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "purgeCache", "auth" => $__context__->auth))));
				$__b__->add("\">Purge Cache</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "clearCache", "auth" => $__context__->auth))));
				$__b__->add("\">Clear Cache</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "purgeRenderables", "auth" => $__context__->auth))));
				$__b__->add("\">Purge Unused Renderables</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "purgeExpiredRenderables", "auth" => $__context__->auth))));
				$__b__->add("\">Purge Expired Renderables</a></li>\x0A\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "displayLogs", "auth" => $__context__->auth, "format" => "json"))));
				$__b__->add("\">Logs (json)</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "displayLogs", "auth" => $__context__->auth, "format" => "html"))));
				$__b__->add("\">Logs (html)</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "clearLogs", "auth" => $__context__->auth))));
				$__b__->add("\">Clear Logs</a></li>\x0A</ul>\x0A\x0A\x0A<h2>Setup</h2>\x0A<ul class=\"bullet\">\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "createCollections", "auth" => $__context__->auth))));
				$__b__->add("\">Create Collections</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "dropCollections", "auth" => $__context__->auth))));
				$__b__->add("\">Drop Collections</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "dropCache", "auth" => $__context__->auth))));
				$__b__->add("\">Drop Cache</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "dropRenderables", "auth" => $__context__->auth))));
				$__b__->add("\">Drop Renderables</a></li>\x0A  <li><a href=\"");
				$__b__->add($__context__->baseurl);
				$__b__->add($__context__->url->route(_hx_anonymous(array("controller" => "setup", "action" => "info", "auth" => $__context__->auth))));
				$__b__->add("\">PHP Info</a></li>\x0A</ul>\x0A");
				null;
			}
			$__b__->add("\x0A\x0A\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	function __toString() { return 'template.Home'; }
}
