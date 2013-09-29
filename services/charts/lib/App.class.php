<?php

class App {
	public function __construct(){}
	static $AUTH = "6kdsbgv46272";
	static $MONGO_DB_NAME = "chartsrenderer1";
	static $RENDERABLES_COLLECTION = "renderables";
	static $CACHE_COLLECTION = "cache";
	static $CONFIG_COLLECTION = "config";
	static $LOG_COLLECTION = "log";
	static $SERVER_HOST;
	static $BASE_HOST;
	static $JS_PATH;
	static $CSS_PATH;
	static $BASE_PATH = "/charts/";
	static $RESET_CSS = "./css/reset.css";
	static $WKPDF = "DISPLAY=:0  /bin/wkhtmltopdf";
	static $WKIMAGE = "DISPLAY=:0  /bin/wkhtmltoimage";
	static $version;
	static function baseUrl() {
		return "http://" . $_SERVER["HTTP_HOST"] . "/services/viz";
	}
	static function main() {
		App::$version = "1.0.4.695";
		$locator = new thx_util_TypeLocator();
		$locator->memoize(_hx_qtype("model.WKHtmlToImage"), array(new _hx_lambda(array(&$locator), "App_0"), 'execute'));
		$locator->memoize(_hx_qtype("model.WKHtmlToPdf"), array(new _hx_lambda(array(&$locator), "App_1"), 'execute'));
		$locator->memoize(_hx_qtype("mongo.Mongo"), array(new _hx_lambda(array(&$locator), "App_2"), 'execute'));
		$locator->memoize(_hx_qtype("mongo.MongoDB"), array(new _hx_lambda(array(&$locator), "App_3"), 'execute'));
		$locator->memoize(_hx_qtype("model.RenderableGateway"), array(new _hx_lambda(array(&$locator), "App_4"), 'execute'));
		$locator->memoize(_hx_qtype("model.CacheGateway"), array(new _hx_lambda(array(&$locator), "App_5"), 'execute'));
		$locator->memoize(_hx_qtype("model.ConfigGateway"), array(new _hx_lambda(array(&$locator), "App_6"), 'execute'));
		ufront_web_mvc_DependencyResolver::$current = new ufront_external_mvc_ThxDependencyResolver($locator);
		$config = new ufront_web_AppConfiguration("controller", true, "/charts/", null, true); $routes = new ufront_web_routing_RouteCollection(null); $app = new ufront_web_mvc_MvcApplication($config, $routes, null);
		$app->modules->add(new util_TraceToMongo("chartsrenderer1", "log", App::serverName()));
		$routes->addRoute("/contact/{?message}", _hx_anonymous(array("controller" => "site", "action" => "contact")), null, null);
		$routes->addRoute("/", _hx_anonymous(array("controller" => "home", "action" => "index")), null, null);
		$routes->addRoute("/up/form/html", _hx_anonymous(array("controller" => "uploadForm", "action" => "display")), null, null);
		$routes->addRoute("/up/form/gist", _hx_anonymous(array("controller" => "uploadForm", "action" => "gist")), null, null);
		$routes->addRoute("/up.{outputformat}", _hx_anonymous(array("controller" => "renderableAPI", "action" => "upload")), null, new _hx_array(array(new ufront_web_routing_ValuesConstraint("outputformat", new _hx_array(array("json", "html")), null, null), new ufront_web_routing_HttpMethodConstraint("POST", null))));
		$routes->addRoute("/upandsee.{ext}", _hx_anonymous(array("controller" => "renderableAPI", "action" => "uploadAndDisplay")), null, new _hx_array(array(new ufront_web_routing_HttpMethodConstraint("POST", null))));
		$routes->addRoute("/up/gist/{gistid}.{outputformat}", _hx_anonymous(array("controller" => "gistUpload", "action" => "importGist")), null, new _hx_array(array(new ufront_web_routing_ValuesConstraint("outputformat", new _hx_array(array("json", "html")), null, null))));
		$routes->addRoute("/up/url.{outputformat}", _hx_anonymous(array("controller" => "renderableAPI", "action" => "uploadFromUrl")), null, new _hx_array(array(new ufront_web_routing_ValuesConstraint("outputformat", new _hx_array(array("json", "html")), null, null))));
		$routes->addRoute("/up/info/{uid}.{outputformat}", _hx_anonymous(array("controller" => "renderableAPI", "action" => "display")), null, new _hx_array(array(new ufront_web_routing_ValuesConstraint("outputformat", new _hx_array(array("json", "html")), null, null))));
		$routes->addRoute("/down/{uid}.{ext}", _hx_anonymous(array("controller" => "downloadAPI", "action" => "download")), null, null);
		$routes->addRoute("/status/info", _hx_anonymous(array("controller" => "setup", "action" => "info")), null, null);
		$routes->addRoute("/status/db", _hx_anonymous(array("controller" => "setup", "action" => "mongodb")), null, null);
		$routes->addRoute("/status/renderables", _hx_anonymous(array("controller" => "setup", "action" => "topRenderables")), null, null);
		$routes->addRoute("/maintenance/renderables/purge/unused", _hx_anonymous(array("controller" => "setup", "action" => "purgeRenderables")), null, null);
		$routes->addRoute("/maintenance/renderables/purge/expired", _hx_anonymous(array("controller" => "setup", "action" => "purgeExpiredRenderables")), null, null);
		$routes->addRoute("/maintenance/cache/purge", _hx_anonymous(array("controller" => "setup", "action" => "purgeCache")), null, null);
		$routes->addRoute("/maintenance/cache/clear", _hx_anonymous(array("controller" => "setup", "action" => "clearCache")), null, null);
		$routes->addRoute("/maintenance/logs/clear", _hx_anonymous(array("controller" => "setup", "action" => "clearLogs")), null, null);
		$routes->addRoute("/maintenance/logs.{format}", _hx_anonymous(array("controller" => "setup", "action" => "displayLogs")), null, new _hx_array(array(new ufront_web_routing_ValuesConstraint("outputformat", new _hx_array(array("json", "html")), null, null))));
		$routes->addRoute("/setup/collections/create", _hx_anonymous(array("controller" => "setup", "action" => "createCollections")), null, null);
		$routes->addRoute("/setup/collections/drop", _hx_anonymous(array("controller" => "setup", "action" => "dropCollections")), null, null);
		$routes->addRoute("/setup/renderables/drop", _hx_anonymous(array("controller" => "setup", "action" => "dropRenderables")), null, null);
		$routes->addRoute("/setup/cache/drop", _hx_anonymous(array("controller" => "setup", "action" => "dropCache")), null, null);
		$app->execute();
	}
	static function serverName() {
		return trim(`hostname -f`);
	}
	function __toString() { return 'App'; }
}
App::$SERVER_HOST = "http://" . $_SERVER["HTTP_HOST"];
App::$BASE_HOST = "http://" . $_SERVER["HTTP_HOST"] . "/services/viz";
App::$JS_PATH = "http://" . $_SERVER["HTTP_HOST"] . "/js/";
App::$CSS_PATH = "http://" . $_SERVER["HTTP_HOST"] . "/css/";
function App_0(&$locator) {
	{
		return new model_WKHtmlToImage("DISPLAY=:0  /bin/wkhtmltoimage");
	}
}
function App_1(&$locator) {
	{
		return new model_WKHtmlToPdf("DISPLAY=:0  /bin/wkhtmltopdf");
	}
}
function App_2(&$locator) {
	{
		return new mongo_Mongo();
	}
}
function App_3(&$locator) {
	{
		return new mongo_MongoDB($locator->get(_hx_qtype("mongo.Mongo"))->m->selectDB("chartsrenderer1"));
	}
}
function App_4(&$locator) {
	{
		return new model_RenderableGateway(new mongo_MongoCollection($locator->get(_hx_qtype("mongo.MongoDB"))->db->selectCollection("renderables")));
	}
}
function App_5(&$locator) {
	{
		return new model_CacheGateway(new mongo_MongoCollection($locator->get(_hx_qtype("mongo.MongoDB"))->db->selectCollection("cache")));
	}
}
function App_6(&$locator) {
	{
		return new model_ConfigGateway(new mongo_MongoCollection($locator->get(_hx_qtype("mongo.MongoDB"))->db->selectCollection("config")));
	}
}
