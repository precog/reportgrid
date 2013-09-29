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
package rg.interactive;

import js.Browser;
import haxe.Http;
import thx.error.Error;
import dhx.Selection;

class RGDownloader
{
	static var ALLOWED_FORMATS = ['pdf', 'ps', 'png', 'jpg', 'svg']; //bmp, tif, html

	var serviceUrl : String;
	var container : Selection;
	var format : String;
	var tokenId : String;

	public function new(container : Selection, serviceurl : String)
	{
		this.container = container;
		this.serviceUrl = serviceurl;
		this.tokenId = rg.util.RG.getTokenId();
	}

	function url(ext : String)
	{
		return StringTools.replace(serviceUrl, '{ext}', ext);
	}

	public function download(format : String, backgroundcolor : Null<String>, success : Dynamic -> Bool, error : String -> Void)
	{
		if (!Arrays.exists(ALLOWED_FORMATS, format))
			throw new Error("The download format '{0}' is not correct", [format]);

		this.format = format;
		var http = new Http(url(format));
		http.setHeader("Accept", "application/json");
		if(null != error)
			http.onError = error;
		else
			http.onError = function(e) { trace(e); };

		http.onData = complete.bind(success, error);
		http.setParameter('html', html());
		http.setParameter('config', config());
		http.request(true);
	}

	function findCssSources() : Array<String>
	{
		return dhx.Dom.selectAll("link").filterNode(function(n, _) {
			return "stylesheet" == untyped n.rel;
		}).mapNode(function(n, _) {
			return untyped n.href;
		});
	}

	function extractSvg(s : String)
	{
		var start = ~/<svg/,
			end   = ~/<\/svg>/;
		start.match(s);
		s = start.matchedRight();
		end.match(s);
		return '<svg' + end.matchedLeft() + '</svg>';
	}

	function html()
	{
		var css     = findCssSources(),
			classes = container.attr("class").get(),
			svg     = extractSvg(container.html().get());
		if(null == classes)
			classes = "rg";
		else
			classes += " rg";
		var html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
'
+
(null == css ? '' : Arrays.map(css, function(href, _) {
	return '<link href="$href" rel="stylesheet" type="text/css" />';
}).join("\n"))
+ '
</head>
<body>
<div class="'+classes+'">'+svg+'</div>
</body>
</html>';
		return html;
	}

	function config()
	{
		var svg    = container.select("svg"),
			width  = svg.attr("width").getFloat(),
			height = svg.attr("height").getFloat();
		var config = '"cache":"1d","duration":"1d","width":'+width+',"height":'+height+',"formats":["'+ALLOWED_FORMATS.join('","')+'"]';
		if(null != tokenId)
			config += ',"params":{"tokenId":true}';
		return '{'+config+'}';
	}

	static function getClassName(container : Selection)
	{
		var name = container.attr("class").get();
		name = StringTools.trim((~/\s+/g).replace((~/(^rg$|^rg\s+|\s+rg\s+|\s+rg$)/g).replace(name, " "), " "));
		return ("" == name) ? null : name;
	}

	function complete(success : {} -> Bool, error : String -> Void, content : String)
	{
		var ob : {
			?error : String,
			service : Dynamic<String>
		} = thx.json.Json.decode(content);
		if(null != ob.error)
		{
			if (null != error)
				error(ob.error);
		} else if(success(ob)) {
			var url = Reflect.field(ob.service, format);
			if(null != tokenId)
			{
				url = appendArgument(url, "tokenId", tokenId);
			}
			url = appendArgument(url, "forceDownload", "true");
//			dhx.Dom.select("body").append("img").attr("src").string(url);
			Browser.window.location.href = url;
		}
		/*
		if(content.substr(0, ERROR_PREFIX.length) == ERROR_PREFIX)
		{
			if (null != error)
				error(content.substr(ERROR_PREFIX.length));
		} else if (null == success || success(content))
			Browser.window.location.href = content;
		*/
	}

	static function appendArgument(url : String, name : String, value : String)
	{
		var sep = url.indexOf("?") >= 0 ? '&' : '?';
		return url + sep + name + '=' + StringTools.urlEncode(value);
	}
}