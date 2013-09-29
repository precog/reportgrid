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

import dhx.Selection;
import js.html.FrameElement;

class RGLegacyRenderer
{
	static var FORMAT = 'jpg';

	var serviceUrl : String;
	var container : Selection;
	var tokenId : String;

	public function new(container : Selection, serviceurl : String)
	{
		this.container = container;
		this.serviceUrl = serviceurl;
		this.tokenId = rg.util.RG.getTokenId();
	}

	function url()
	{
		return StringTools.replace(serviceUrl, '{ext}', FORMAT);
	}

	var readyHandler : Void -> Void;
	public function onReady(handler : Void -> Void)
	{
		readyHandler = handler;
	}

	public function display(params : Dynamic)
	{
		var size   = normalizeParams(params);
		// create iframe
		var id     = container.attr("id").get(),
			iframe = createIframe(size.width, size.height);
		if(null == id)
			id = "rgchart";
		var u = url();
		var h = html(id, params, size);
		var c = config(size);
		var content =
		'<form method="post" action="'
		+ u + '" name="VIZ"><textarea name="html" style="width:40em;height:50%">'
		+ h + '</textarea><textarea name="config" style="width:40em;height:50%">'
		+ c + '</textarea><script type="text/javascript">
setTimeout(function() { document.VIZ.submit(); }, 200);
</script>
</form>';
		haxe.Timer.delay(
			function() {
				writeToIframe(cast iframe.node(), content);
				if(null != readyHandler) readyHandler();
			}, 100);

		if(isIE7orBelow()) {
			var inode : FrameElement = cast iframe.node();
			untyped inode.attachEvent("onload", function() {
				var doc = getIframeDoc(inode);
				if(null != doc) {
					doc.body.scroll = "no";
					doc.body.style.overflow = "hidden";
					doc.body.frameBorder = "0";
					/*
					doc.vspace = "0";
					doc.body.hspace = "0";
					*/
					doc.body.style.border = 0;
					doc.body.style.margin = 0;
					doc.body.style.padding = 0;
				}
			});
		}
	}


	static var nextframeid = 0;
	function createIframe(width : Int, height : Int)
	{
		var id = "rgiframe" + (++nextframeid);
		return container.append("iframe")
			.attr("name").string(id)
			.attr("id").string(id)
			.attr("frameBorder").string("0")
			.attr("scrolling").string("no")
			.attr("width").string((0+width)+"")
			.attr("height").string((0+height)+"")
			.attr("marginwidth").string("0")
			.attr("marginheight").string("0")
			.attr("hspace").string("0")
			.attr("vspace").string("0")
			.attr("style").string("width:100%; border:0; height:100%; overflow:hidden;")
			.attr("src").string(
				isIE7orBelow()
					? "javascript:'<script>window.onload=function(){document.body.scroll=\"no\";document.body.style.overflow=\"hidden\";document.write(\\\'<script>document.domain=\\\\\""+js.Browser.document.domain+"\\\\\";<\\\\\\\\/script>\\\');document.close();};<\\/script>'"
					: "about:blank"
			)
		;
	}

	function writeToIframe(iframe : FrameElement, content : String)
	{
		var iframeDoc : Dynamic = getIframeDoc(iframe);
		if (null != iframeDoc)
		{
			iframeDoc.open();
			iframeDoc.write('<html><head><title></title></head><body style="visibility:hidden;border:none" scroll="no">'+content+'</body></html>');
			iframeDoc.close();
		}
	}

	static function getIframeDoc(iframe : FrameElement)
	{
		var iframeDoc : Dynamic = null;

		var attempts = [
				function() {
					if (untyped iframe.contentDocument)
					{
						iframeDoc = untyped iframe.contentDocument;
					}
				},
				function() {
					if (untyped iframe.contentWindow && iframe.contentWindow.document)
					{
						iframeDoc = untyped iframe.contentWindow.document;
					}
				},
				function() {
					if (null != untyped js.Browser.window.frames[iframe.name])
					{
						iframeDoc = untyped js.Browser.window.frames[iframe.name].document;
					}
				}
			];
		for(attempt in attempts)
		{
			try {
				attempt();
			} catch(e : Dynamic) { }
			if(null != iframeDoc)
				return iframeDoc;
		}
		return null;
	}

	function normalizeParams(params : Dynamic)
	{
		if(null == params.options)
			params.options = {};
		var size = rg.factory.FactoryLayout.size(container, params.options, 0);
		params.options.width = size.width;
		params.options.height = size.height;

		// remove functions
		removeFunctions(params.options);

		// remove empty objects
		removeEmpties(params);

		// remove dangerous stuff
		Reflect.deleteField(params, "load");
		Reflect.deleteField(params.options, "download");
		params.options.forcelegacy = false;

		return size;
	}

	static function isIE7orBelow() : Bool {
		return untyped (document.all && !document.querySelector);
	}

	static function removeFunctions(o : Dynamic)
	{
		for(field in Reflect.fields(o))
		{
			var f = Reflect.field(o, field);
			if(Reflect.isFunction(f))
			{
				Reflect.deleteField(o, field);
			} else if(Types.isAnonymous(o)) {
				removeFunctions(f);
			}
		}
	}

	static function removeEmpties(o : Dynamic)
	{
		for(field in Reflect.fields(o))
		{
			var f = Reflect.field(o, field);
			if(Types.isAnonymous(f))
			{
				removeEmpties(f);
				if(Reflect.fields(f).length == 0)
					Reflect.deleteField(o, field);
			} else if(null == f)
			{
				Reflect.deleteField(o, field);
			}
		}
	}

	function findJsSources() : Array<String>
	{
		var re  = ~/reportgrid-[^.]+\.js/;
		return dhx.Dom.selectAll("script").filterNode(function(n, _) {
			return  re.match(untyped n.src);
		}).mapNode(function(n, _) {
			return untyped n.src;
		});
	}

	function findCssSources() : Array<String>
	{
		return dhx.Dom.selectAll("link").filterNode(function(n, _) {
			return "stylesheet" == untyped n.rel;
		}).mapNode(function(n, _) {
			return untyped n.href;
		});
	}

	function html(id : String, params : Dynamic, size : { width : Int, height : Int })
	{
		var p       = thx.json.Json.encode(params),
			scripts = findJsSources(),
			css     = findCssSources(),
			classes = container.attr("class").get();
		if(null == classes)
			classes = "rg";
		else
			classes += " rg";
		var h = '<!DOCTYPE html>
<html>
<head>
<title></title>
'
+
(null == scripts ? "" : Arrays.map(scripts, function(src, _) {
	return '<script src="$src" type="text/javascript"></script>';
}).join("\n"))
+
(null == css ? "" : Arrays.map(css, function(href, _) {
	return '<link href="$href" rel="stylesheet" type="text/css" />';
}).join("\n"))
+ '
<script type="text/javascript">
function __RG__render()
{
ReportGrid.chart("#'+id+'", '+p+');
}
</script>
</head>
<body onload="__RG__render()">
<div id="'+id+'" class="'+classes+'" style="margin:0;width:'+size.width+'px;height:'+size.height+'px;"></div>
</body>
</html>';
		return h;
	}

	function config(size : { width : Int, height : Int })
	{
		var c = '"cache":"1d","duration":"1d","width":'+size.width+',"height":'+size.height+',"formats":["'+FORMAT+'"]';
		return '{'+c+'}';
	}
}