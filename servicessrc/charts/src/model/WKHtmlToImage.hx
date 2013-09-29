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

class WKHtmlToImage extends WKHtml
{
	var _imageConfig : ConfigImage;
	public var imageConfig(get, set) : ConfigImage;
	public function new(binpath : String)
	{
		allowedFormats = ['png', 'jpg', 'svg', 'bmp', 'tif'];
		super(binpath);
	}

	function get_imageConfig()
	{
		if(null == _imageConfig)
		{
			_imageConfig = new ConfigImage();
		}
		return _imageConfig;
	}

	function set_imageConfig(c : model.ConfigImage)
	{
		return _imageConfig = c;
	}

	static var MATCHX = ~/x1="((?:\d+\.)\d+)"\s+y1="((?:\d+\.)\d+)"\s+x2="((?:\d+\.)\d+)"\s+y2="((?:\d+\.)\d+)"/ig;
	override public function modify(content : String)
	{
		switch(format)
		{
			case "svg":
				// normalize xml:id
				content = StringTools.replace(content, "xml:id", "id");
				// trim title
				// trim desc

				// for some reasong grardientUnits="userSpaceOnUse" is always enforced even if manually set to another value
				content = StringTools.replace(content, 'gradientUnits="userSpaceOnUse"', 'gradientUnits="objectBoundingBox"');
		}
		return content;
	}

	override function commandOptions()
	{
		var args = [],
			cfg  = imageConfig;


		if(null != cfg.x)
		{
			args.push("--crop-x"); args.push(""+cfg.x);
		}
		if(null != cfg.y)
		{
			args.push("--crop-y"); args.push(""+cfg.y);
		}
		if(null != cfg.width)
		{
			args.push("--crop-w"); args.push(""+cfg.width);
		}
		if(null != cfg.height)
		{
			args.push("--crop-h"); args.push(""+cfg.height);
		}
		if(null != cfg.screenWidth)
		{
			args.push("--width"); args.push(""+cfg.screenWidth);
		}
		if(null != cfg.screenHeight)
		{
			args.push("--height"); args.push(""+cfg.screenHeight);
		}
		if(null != cfg.quality)
		{
			args.push("--quality"); args.push(""+cfg.quality);
		}
		if(true == cfg.disableSmartWidth)
		{
			args.push("--disable-smart-width");
		}
		if(true == cfg.transparent)
		{
			args.push("--transparent");
		}

		if(format == 'svg')
		{
			args.push("--run-script"); args.push(svgAdjust());
		}
		return super.commandOptions().concat(args);
	}


	static function svgAdjust()
	{
		return WKHtml.minifyJs("(function(){
function fixSvg()
{
	var ns = 'http://www.w3.org/2000/svg';
	var els = document.getElementsByTagNameNS(ns, 'line');
	console.log(els.length);

	function g(node, name)
	{
		return node.getAttribute(name);
	}

	function s(node, name, value)
	{
		return node.setAttribute(name, value);
	}

	function inc(node, name, value)
	{
		return s(node, name, g(node, name)+value);
	}

	for(var i = 0; i < els.length; i++)
	{
		var el = els[i];
		if(g(el, 'x1') == g(el, 'x2')) inc(el, 'x2', 0.0000000001);
		if(g(el, 'y1') == g(el, 'y2')) inc(el, 'y2', 0.0000000001);
	}
}

if('undefined' != typeof ReportGrid && 'undefined' != typeof ReportGrid.charts && 'undefined' != typeof ReportGrid.charts.ready)
{
	ReportGrid.charts.ready(fixSvg);
} else {
	fixSvg();
}
})()");
	}
}