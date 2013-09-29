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
package model;

import thx.error.Error;

using Arrays;

class WKHtml
{
#if release
	public static var JS_DELAY = 30000;
#else
	public static var JS_DELAY = 5000;
#end
	var cmd : String;
	var _wkConfig : ConfigWKHtml;
	public var wkConfig(get, set) : ConfigWKHtml;
	public var format(get, set) : String;
	public var allowedFormats(default, null) : Array<String>;
	function new(cmd : String)
	{
		this.cmd = cmd;
	}

	public function render(content : String) : String
	{
		var ext = content.indexOf("-//W3C//DTD XHTML 1.0") >= 0 ? "xhtml" : "html";
		var t = tmp(ext);
		sys.io.File.saveContent(t, content);
		err = null;
		var r = renderUrl(t);
#if release
		sys.FileSystem.deleteFile(t);
#end
		if(null == r)
			throw new Error("unable to render the result");
		return r;
	}

	public function modify(content : String)
	{
		return content;
	}

	public function renderUrl(path : String) : String
	{
		var args = commandOptions(),
			out  = tmp(format);

		args.push(path);
		args.push(out);

		var ok = true;
		if(!execute(args))
		{
			ok = false;
			trace(cmdToString(cmd, args)+"\n" + cleanErr(err));
		} else if(#if release false #else true #end) {
			trace(cmdToString(cmd, args)+"\n" + cleanErr(err));
		}

		if(ok)
		{
			var result = thx.sys.io.File.getContent(out);
			thx.sys.FileSystem.deleteFile(out);
			return modify(result);
		} else {
			if(thx.sys.FileSystem.exists(out))
				thx.sys.FileSystem.deleteFile(out);
			return null;
		}
	}

	function cleanErr(err : String)
	{
		return (~/(\n\r|\n|\r)/gm).split(err).map(function(line, _) {
			return StringTools.trim(line);
		}).filter(function(line) {
			return line != "" && !(line.substr(0, 1) == "[" && line.substr(line.length-1, 1) == "%");
		}).join("\n");
	}

	var err : String;
	function execute(args : Array<String>) : Bool
	{
		var process = new thx.sys.io.Process(cmd, args.map(function(arg, _) {
			return StringTools.replace(arg, '"', '\\"');
		}));
//		var r = thx.sys.Sys.command(cmd, args);
//		var id = process.getPid();
		process.close();
		var r = process.exitCode();
//		trace(id);
		err = process.stderr.readAll().toString();
//		trace("PROC: " + err);
		var out = process.stdout.readAll().toString();

//		trace("OUT: " + out);
		return r == 0;
	}

	function commandOptions()
	{
		var args = [];

#if release
		args.push("--use-xserver");
#else
		args.push("--debug-javascript");
#end
		args.push("--disable-local-file-access");
		args.push("--javascript-delay"); args.push(""+JS_DELAY);
		args.push("--user-style-sheet"); args.push(App.RESET_CSS);
		args.push("--run-script"); args.push(finalscript());

//		args.push("--images");
//args.push("--debug-javascript");

		var cfg = wkConfig;
		if(null != cfg.zoom && cfg.zoom != 1)
		{
			args.push("--zoom"); args.push(""+cfg.zoom);
		}

		return args;
	}

	static function cmdToString(cmd : String, args : Array<String>)
	{
		args = args.map(function(arg, _) {
			return Floats.canParse(arg) || arg.substr(0, 1) == "-" ? arg : "'" + StringTools.replace(arg, "'", '"') + "'";
		});
		return cmd + (args.length > 0 ? " " : "") + args.join(" ");
	}

	function get_format() return format
	function set_format(f : String)
	{
		if(!allowedFormats.exists(f))
			throw new Error("invalid format {0}, you can use any of: {1}", [f, allowedFormats]);
		return format = f;
	}

	function get_wkConfig()
	{
		if(null == _wkConfig)
		{
			_wkConfig = new ConfigWKHtml();
		}
		return _wkConfig;
	}

	function set_wkConfig(c : model.ConfigWKHtml)
	{
		return _wkConfig = c;
	}

	static function tmp(ext : String) : String
	{
		var uid;
		do
		{
			uid = tmpuid(ext);
		} while(thx.sys.FileSystem.exists(uid));
		return uid;
	}

	static function tmpuid(ext : String)
	{
		var id = untyped __call__("uniqid", "WK_");
		return "/tmp/" + id + "." + ext;
	}

	static function finalscript()
	{
		var script = '(function(){
function log(s)
{
	if("undefined" != typeof console)
	{
		console.log(s);
	} else {
		var el = document.createElement("div");
		el.innerHTML = s;
		document.body.appendChild(el);
	}
}

function rgcomplete()
{
	var images = document.getElementsByTagName("img");
	for(var i = 0; i < images.length; i++)
	{
		var image = images[i];
		if(!image.complete)
		{
			setTimeout(rgcomplete, 50);
			return;
		}
	}
	/* if contains "image" elements allow for extra 500ms */
	if(document.getElementsByTagName("image").length > 0)
		setTimeout(window.print, 500);
	else
		window.print();
}
if("undefined" != typeof ReportGrid && "undefined" != typeof ReportGrid.charts && "undefined" != typeof ReportGrid.charts.ready)
{
	ReportGrid.charts.ready(rgcomplete);
} else {
	setTimeout(window.print, 250);
}
})()';
		return minifyJs(script);
	}

	public static function minifyJs(js : String)
	{
		return (~/\s+/mg).replace(js, " ");
	}
}