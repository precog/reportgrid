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

class ConfigRendering
{
	public static function create(options : model.ConfigObject) : ConfigRendering
	{
		var config = new ConfigRendering();
		config.cacheExpirationTime = options.cacheExpires;
		config.duration = null == options.duration ? null : options.duration;
		config.allowedFormats = options.allowedFormats;
		config.wk.zoom = options.zoom;

		// pdf
		config.pdf.dpi						= options.dpi;
		config.pdf.grayscale				= options.grayscale;
		config.pdf.imageDpi					= options.imageDpi;
		config.pdf.imageQuality				= options.imageQuality;
		config.pdf.lowQuality				= options.lowQuality;
		config.pdf.marginTop				= options.marginTop;
		config.pdf.marginBottom				= options.marginBottom;
		config.pdf.marginLeft				= options.marginLeft;
		config.pdf.marginRight				= options.marginRight;
		config.pdf.portrait					= options.portrait;
		config.pdf.pageHeight				= options.pageHeight;
		config.pdf.pageSize					= options.pageSize;
		config.pdf.pageWidth				= options.pageWidth;
		config.pdf.title					= options.title;
		config.pdf.usePrintMediaType		= options.usePrintMediaType;
		config.pdf.disableSmartShrinking	= options.disableSmartShrinking;

		config.pdf.footerCenter				= options.footerCenter;
		config.pdf.footerLeft				= options.footerLeft;
		config.pdf.footerRight				= options.footerRight;
		config.pdf.footerFontName			= options.footerFontName;
		config.pdf.footerFontSize			= options.footerFontSize;
		config.pdf.footerHtml				= options.footerHtml;
		config.pdf.footerSpacing			= options.footerSpacing;
		config.pdf.footerLine				= options.footerLine;

		config.pdf.headerCenter				= options.headerCenter;
		config.pdf.headerLeft				= options.headerLeft;
		config.pdf.headerRight				= options.headerRight;
		config.pdf.headerFontName			= options.headerFontName;
		config.pdf.headerFontSize			= options.headerFontSize;
		config.pdf.headerHtml				= options.headerHtml;
		config.pdf.headerSpacing			= options.headerSpacing;
		config.pdf.headerLine				= options.headerLine;

		// image
		config.image.x						= options.x;
		config.image.y						= options.y;
		config.image.width					= options.width;
		config.image.height					= options.height;
		config.image.screenWidth			= options.screenWidth;
		config.image.screenHeight			= options.screenHeight;
		config.image.quality				= options.quality;
		config.image.disableSmartWidth		= options.disableSmartWidth;
		config.image.transparent			= options.transparent;
		// template
		for(param in Reflect.fields(options.params))
		{
			var value = Reflect.field(options.params, param);
			config.template.addParameter(param, value == true ? null : cast value);
		}
		for(param in Reflect.fields(options.defaults))
		{
			var value = Reflect.field(options.defaults, param);
			config.template.setDefault(param, value);
		}
		return config;
	}

	public var allowedFormats : Array<String>;
	public var duration : Null<Float>;
	public var cacheExpirationTime : Float;

	public var pdf : ConfigPdf;
	public var image : ConfigImage;
	public var wk : ConfigWKHtml;
	public var template : model.ConfigTemplate;

	function new()
	{
		pdf      = new ConfigPdf();
		image    = new ConfigImage();
		wk       = new ConfigWKHtml();
		template = new ConfigTemplate();
		allowedFormats;
	}

	public function toString()
	{
		return "ConfigRendering: " + ConfigObjects.fieldsToString(this);
	}
}