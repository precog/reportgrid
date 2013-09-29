/*
 *  ___ ___ ___  ___  ___ _____ ___ ___ ___ ___           ReportGrid (R)
 * | _ \ __| _ \/ _ \| _ \_   _/ __| _ \_ _|   \          Advanced HTML5 Charting Library
 * |   / _||  _/ (_) |   / | || (_ |   /| || |) |         Copyright (C) 2010 - 2013 SlamData, Inc.
 * |_|_\___|_|  \___/|_|_\ |_| \___|_|_\___|___/          All Rights Reserved.
 *
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the 
 * GNU Affero General Public License as published by the Free Software Foundation, either version 
 * 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See 
 * the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with this 
 * program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
import model.CacheGateway;
import model.RenderableGateway;
import model.ConfigGateway;
import thx.util.Imports;
import thx.util.MacroVersion;
import ufront.web.AppConfiguration;
import ufront.web.mvc.MvcApplication;
import ufront.web.routing.RouteCollection;
import ufront.web.routing.HttpMethodConstraint;
import ufront.web.routing.IRouteConstraint;
import ufront.web.routing.ValuesConstraint;
import mongo.Mongo;
import mongo.MongoDB;
import mongo.MongoCollection;

class App
{
	public static inline var AUTH = "6kdsbgv46272";
	public static inline var MONGO_DB_NAME = "chartsrenderer1";
	public static inline var RENDERABLES_COLLECTION = "renderables";
	public static inline var CACHE_COLLECTION = "cache";
	public static inline var CONFIG_COLLECTION = "config";
	public static inline var LOG_COLLECTION = "log";
#if release
	public static inline var SERVER_HOST = "http://" + untyped __var__("_SERVER", "HTTP_HOST");
	public static inline var BASE_HOST = SERVER_HOST + '/services/viz';
//	public static inline var HOST = "http://api.reportgrid.com";
	public static inline var JS_PATH = SERVER_HOST + "/js/";
	public static inline var CSS_PATH = SERVER_HOST + "/css/";
	public static inline var BASE_PATH = "/charts/";
	public static inline var RESET_CSS = "./css/reset.css";

	public static inline var WKPDF = "DISPLAY=:0  /bin/wkhtmltopdf";
	public static inline var WKIMAGE = "DISPLAY=:0  /bin/wkhtmltoimage";
#else
	public static inline var SERVER_HOST = "http://" + untyped __var__("_SERVER", "HTTP_HOST");
	public static inline var BASE_HOST = SERVER_HOST + '';
	public static inline var JS_PATH = SERVER_HOST + "/rg/charts/js/";
	public static inline var CSS_PATH = SERVER_HOST + "/rg/charts/css/";
	public static inline var BASE_PATH = "/rg/services/viz/charts/";
	public static inline var RESET_CSS = "/Users/francoponticelli/Projects/reportgrid/visualizations/services/charts/css/reset.css";

	public static inline var WKPDF = "/usr/lib/wkhtmltopdf.app/Contents/MacOS/wkhtmltopdf";
	public static inline var WKIMAGE = "/usr/lib/wkhtmltoimage.app/Contents/MacOS/wkhtmltoimage";
#end
	public static var version(default, null) : String;

	public static function baseUrl()
		return BASE_HOST;

	static function main()
	{
		App.version = MacroVersion.next();

		var locator = new thx.util.TypeLocator();
		locator.memoize(model.WKHtmlToImage, function() {
			return new model.WKHtmlToImage(WKIMAGE);
		});
		locator.memoize(model.WKHtmlToPdf, function() {
			return new model.WKHtmlToPdf(WKPDF);
		});
		locator.memoize(Mongo, function() {
			return new Mongo();
		});
		locator.memoize(MongoDB, function() {
			return locator.get(Mongo).selectDB(MONGO_DB_NAME);
		});
		locator.memoize(RenderableGateway, function() {
			return new RenderableGateway(locator.get(MongoDB).selectCollection(RENDERABLES_COLLECTION));
		});
		locator.memoize(CacheGateway, function() {
			return new CacheGateway(locator.get(MongoDB).selectCollection(CACHE_COLLECTION));
		});
		locator.memoize(ConfigGateway, function() {
			return new ConfigGateway(locator.get(MongoDB).selectCollection(CONFIG_COLLECTION));
		});

		ufront.web.mvc.DependencyResolver.current = new ufront.external.mvc.ThxDependencyResolver(locator);

		Imports.pack("controller", true);

		var config = new AppConfiguration(
				"controller",
				true, // mod rewrite
				BASE_PATH,
#if release
				true // disable browser trace
#else
				false
#end
			),
			routes = new RouteCollection(),
			app    = new MvcApplication(config, routes);

		app.modules.add(new util.TraceToMongo(MONGO_DB_NAME, LOG_COLLECTION, serverName()));

		routes.addRoute("/contact/{?message}", {controller:"site", action:"contact"});

		routes.addRoute('/', {
			controller : "home", action : "index"
		});

		routes.addRoute('/up/form/html', {
			controller : "uploadForm", action : "display"
		});

		routes.addRoute('/up/form/gist', {
			controller : "uploadForm", action : "gist"
		});

		routes.addRoute('/up.{outputformat}', {
				controller : "renderableAPI", action : "upload"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint),
				new HttpMethodConstraint("POST")
			]
		);

		routes.addRoute('/upandsee.{ext}', {
				controller : "renderableAPI", action : "uploadAndDisplay"
			},
			[
				cast(new HttpMethodConstraint("POST"), IRouteConstraint)
			]
		);

		routes.addRoute('/up/gist/{gistid}.{outputformat}', {
				controller : "gistUpload", action : "importGist"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);
		routes.addRoute('/up/url.{outputformat}', {
				controller : "renderableAPI", action : "uploadFromUrl"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);
		routes.addRoute('/up/info/{uid}.{outputformat}', {
				controller : "renderableAPI", action : "display"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);

		routes.addRoute('/down/{uid}.{ext}', {
			controller : "downloadAPI", action : "download"
		});

// this should run only on localhost
		routes.addRoute('/status/info', {
			controller : "setup", action : "info"
		});
		routes.addRoute('/status/db', {
			controller : "setup", action : "mongodb"
		});
		routes.addRoute('/status/renderables', {
			controller : "setup", action : "topRenderables"
		});
		routes.addRoute('/maintenance/renderables/purge/unused', {
			controller : "setup", action : "purgeRenderables"
		});
		routes.addRoute('/maintenance/renderables/purge/expired', {
			controller : "setup", action : "purgeExpiredRenderables"
		});
		routes.addRoute('/maintenance/cache/purge', {
			controller : "setup", action : "purgeCache"
		});
		routes.addRoute('/maintenance/cache/clear', {
			controller : "setup", action : "clearCache"
		});

		routes.addRoute('/maintenance/logs/clear', {
			controller : "setup", action : "clearLogs"
		});
		routes.addRoute('/maintenance/logs.{format}', {
				controller : "setup", action : "displayLogs"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);

		routes.addRoute('/setup/collections/create', {
			controller : "setup", action : "createCollections"
		});
		routes.addRoute('/setup/collections/drop', {
			controller : "setup", action : "dropCollections"
		});
		routes.addRoute('/setup/renderables/drop', {
			controller : "setup", action : "dropRenderables"
		});
		routes.addRoute('/setup/cache/drop', {
			controller : "setup", action : "dropCache"
		});

/*
		php.Lib.print("<pre>");
		php.Lib.println(app.request.uri);
		php.Lib.println(HOST);
		php.Lib.println(BASE_PATH);

		untyped __call__("phpinfo");
*/
		app.execute();
	}

	static function serverName() : String
	{
		return untyped __php__("trim(`hostname -f`)");
	}
}