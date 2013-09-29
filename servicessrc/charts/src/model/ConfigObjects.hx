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

import thx.collection.Set;
import thx.date.Milli;
import thx.error.Error;
using Arrays;

class ConfigObjects
{
	static var FORMATS = ['pdf', 'png', 'jpg', 'html', 'ps', 'svg', 'bmp', 'tif'];
	public static function createDefault() : ConfigObject
	{
		return {
			cacheExpires			: 2 * 24 * 60 * 60 * 1000.0,
			duration				: null,
#if release
			allowedFormats			: ['pdf', 'png', 'jpg', 'svg'],
#else
			allowedFormats			: ['pdf', 'ps', 'png', 'jpg', 'bmp', 'tif', 'svg', 'html'],
#end
			params					: {},
			defaults				: {},
			zoom					: 1.0,
// PDF
			dpi						: null,
			grayscale				: false,
			imageDpi				: null,
			imageQuality			: null,
			lowQuality				: false,
			marginTop				: null,
			marginBottom			: null,
			marginLeft				: null,
			marginRight				: null,
			portrait				: true,
			pageHeight				: null,
			pageSize				: null,
			pageWidth				: null,
			title					: null,
			usePrintMediaType		: false,
			disableSmartShrinking	: false,

			footerCenter			: null,
			footerLeft				: null,
			footerRight				: null,
			footerFontName			: null,
			footerFontSize			: null,
			footerHtml				: null,
			footerSpacing			: null,
			footerLine				: false,

			headerCenter			: null,
			headerLeft				: null,
			headerRight				: null,
			headerFontName			: null,
			headerFontSize			: null,
			headerHtml				: null,
			headerSpacing			: null,
			headerLine				: false,
// IMAGE
			x						: null,
			y						: null,
			width					: null,
			height					: null,
			screenWidth				: null,
			screenHeight			: null,
			quality					: null,
			disableSmartWidth		: false,
			transparent				: false
		};
	}

	public static function overrideValues(config : ConfigObject, over : Dynamic)
	{
		if(null != over.duration)
		{
			var e : Dynamic = over.duration;
			if(Std.is(e, Float))
			{
				if(e <= 0)
					throw new Error("invalid negative value for duration: {0}", [e]);
				config.duration = e;
			} else if(Std.is(e, String)) {
				var v = Milli.parse(e);
				if(v <= 0)
					throw new Error("invalid expression for duration: {0}", [e]);
				config.duration = v;
			} else {
				throw new Error("invalid value type for duration: {0}", [e]);
			}
		}
		if(null != over.cache)
		{
			var e : Dynamic = over.cache;
			if(Std.is(e, Float))
			{
				if(e <= 0)
					throw new Error("invalid negative value for cacheExpires: {0}", [e]);
				config.cacheExpires = e;
			} else if(Std.is(e, String)) {
				var v = Milli.parse(e);
				if(v <= 0)
					throw new Error("invalid expression for cacheExpires: {0}", [e]);
				config.cacheExpires = v;
			} else {
				throw new Error("invalid value type for cacheExpires: {0}", [e]);
			}
		}
		if(null != over.formats)
		{
			var v : Dynamic = over.formats,
				values = new Set<String>();
			if(Std.is(v, String))
			{
				var s : String = v;
				var arr : Array<String> = s.split(",");
				for(item in arr)
					values.add(item);
			} else if(Std.is(v, Array)) {
				var arr : Array<String> = v;
				for(item in arr)
					values.add(""+item);
			}
			config.allowedFormats = [];
			for(item in values)
			{
				var s = StringTools.trim(item).toLowerCase();
				if(!FORMATS.exists(s))
					throw new Error("the format '{0}' is not supported", [item]);
				config.allowedFormats.push(s);
			}
		}
		if(null != over.params)
		{
			for(param in Reflect.fields(over.params))
			{
				var value = Reflect.field(over.params, param);
				if(Std.is(value, Array))
				{
					Reflect.setField(config.params, param, value);
				} else {
					Reflect.setField(config.params, param, true);
				}
			}
		}
		if(null != over.defaults)
		{
			for(param in Reflect.fields(over.defaults))
			{
				var value = Reflect.field(over.defaults, param);
				Reflect.setField(config.defaults, param, value);
			}
		}

		config.zoom						= parseFloat(over.zoom, "zoom");

		// PDF
		config.dpi						= parseInt(over.dpi, "dpi");
		config.grayscale				= parseBool(over.grayscale, "grayscale");
		config.imageDpi					= parseInt(over.imageDpi, "imageDpi");
		config.imageQuality				= parseInt(over.imageQuality, "imageQuality");
		config.lowQuality				= parseBool(over.lowQuality, "lowQuality");
		config.marginTop				= parseUnit(over.marginTop, "marginTop");
		config.marginBottom				= parseUnit(over.marginBottom, "marginBottom");
		config.marginLeft				= parseUnit(over.marginLeft, "marginLeft");
		config.marginRight				= parseUnit(over.marginRight, "marginRight");
		config.portrait					= parseBool(over.portrait, true, "portrait");
		config.pageHeight				= parseUnit(over.pageHeight, "pageHeight");
		config.pageSize					= parsePaperSize(over.pageSize, "pageSize");
		config.pageWidth				= parseUnit(over.pageWidth, "pageWidth");
		config.title					= parseString(over.title, "title");
		config.usePrintMediaType		= parseBool(over.usePrintMediaType, "usePrintMediaType");
		config.disableSmartShrinking	= parseBool(over.disableSmartShrinking, "disableSmartShrinking");

		config.footerCenter				= parseString(over.footerCenter, "footerCenter");
		config.footerLeft				= parseString(over.footerLeft, "footerLeft");
		config.footerRight				= parseString(over.footerRight, "footerRight");
		config.footerFontName			= parseString(over.footerFontName, "footerFontName");
		config.footerFontSize			= parseString(over.footerFontSize, "footerFontSize");
		config.footerHtml				= parseString(over.footerHtml, "footerHtml");
		config.footerSpacing			= parseFloat(over.footerSpacing, "footerSpacing");
		config.footerLine				= parseBool(over.footerLine, "footerLine");

		config.headerCenter				= parseString(over.headerCenter, "headerCenter");
		config.headerLeft				= parseString(over.headerLeft, "headerLeft");
		config.headerRight				= parseString(over.headerRight, "headerRight");
		config.headerFontName			= parseString(over.headerFontName, "headerFontName");
		config.headerFontSize			= parseString(over.headerFontSize, "headerFontSize");
		config.headerHtml				= parseString(over.headerHtml, "headerHtml");
		config.headerSpacing			= parseFloat(over.headerSpacing, "headerSpacing");
		config.headerLine				= parseBool(over.headerLine, "headerLine");
		// IMAGE
		config.x						= parseInt(over.x, "x");
		config.y						= parseInt(over.y, "y");
		config.width					= parseInt(over.width, "width");
		config.height					= parseInt(over.height, "height");
		config.screenWidth				= parseInt(over.screenWidth, "screenWidth");
		config.screenHeight				= parseInt(over.screenHeight, "screenHeight");
		config.quality					= parseQuality(over.quality, "quality");
		config.disableSmartWidth		= parseBool(over.disableSmartWidth, "disableSmartWidth");
		config.transparent				= parseBool(over.transparent, "transparent");
		return config;
	}

	static function parsePaperSize(v : Dynamic, field : String) : Null<String>
	{
		var s = parseString(v, field);
		if(null == s)
			return s;
		if(!model.WKHtmlToPdf.allowedPaperSize.exists(s))
			throw new Error("invalid paper size '{0}'", [v]);
		return s;
	}

	static function parseUnit(v : Dynamic, field : String) : Null<String>
	{
		var s = parseString(v, field);
		if(null == s)
			return s;
		if(!model.WKHtmlToPdf.validateUnitReal(s))
			throw new Error("invalid unit size '{0}' for '{1}'", [v, field]);
		return s;
	}

	static function parseQuality(v : Dynamic, field : String) : Null<Int>
	{
		var i = parseInt(v, field);
		if(null == i)
			return null;
		if(i < 0 || i > 100)
			throw new Error("quality must be an integer value between 0 and 100");
		return i;
	}

	static function parseString(v : Dynamic, field : String) : Null<String>
	{
		if(null == v)
			return null;
		else
			return "" + v;
	}
	static function parseBool(v : Dynamic, alt = false, field : String) : Null<Bool>
	{
		if(null == v)
			return alt;
		if(Std.is(v, Bool))
			return v;
		else if(Std.is(v, Int))
			return v != 0;
		else if(Std.is(v, String) && Bools.canParse(v))
			return Bools.parse(v);
		else
			throw new Error("unsupported value '{0}' for {1}", [v, field]);
	}
	static function parseInt(v : Dynamic, field : String) : Null<Int>
	{
		if(null == v)
			return null;
		if(Std.is(v, Int))
			return v;
		else if(Std.is(v, String) && Ints.canParse(v))
			return Ints.parse(v);
		else
			throw new Error("unsupported value '{0}' for {1}", [v, field]);
	}
	static function parseFloat(v : Dynamic, field : String) : Null<Float>
	{
		if(null == v)
			return null;
		if(Std.is(v, Float))
			return v;
		else if(Std.is(v, String) && Floats.canParse(v))
			return Floats.parse(v);
		else
			throw new Error("unsupported value '{0}' for {1}", [v, field]);
	}

	public static function fieldsToString(o : Dynamic)
	{
		var fields = Reflect.fields(o),
			pairs = [];
		for(field in fields)
		{
			var value = Reflect.field(o, field);
			if(null == value) continue;
			pairs.push(field + ": " + value);
		}
		return pairs.join(", ");
	}
}