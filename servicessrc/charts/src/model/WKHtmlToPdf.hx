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

class WKHtmlToPdf extends WKHtml
{
	public static var allowedPaperSize = [ "A0", "A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8", "A9", "B0", "B1", "B2", "B3", "B4", "B5", "B6", "B7", "B8", "B9", "B10", "C5E", "Comm10E", "DLE", "Executive", "Folio", "Ledger", "Legal", "Letter", "Tabloid" ];
	var _pdfConfig : ConfigPdf;
	public var pdfConfig(get, set) : ConfigPdf;
	public function new(binpath : String)
	{
		allowedFormats = ['pdf', 'ps'];
		super(binpath);
	}

	static var UNIT_PATTERN = ~/^\d+(\.\d+)?\s*(mm|cm|pt|in|pc|bp|sp)$/i;
	public static function validateUnitReal(v : String)
	{
		return UNIT_PATTERN.match(v);
	}

	function get_pdfConfig()
	{
		if(null == _pdfConfig)
		{
			_pdfConfig = new ConfigPdf();
		}
		return _pdfConfig;
	}

	function set_pdfConfig(c : model.ConfigPdf)
	{
		return _pdfConfig = c;
	}

	override function commandOptions()
	{
		var args = [],
			cfg  = pdfConfig;
		if(null != cfg.dpi)
		{
			args.push("--dpi"); args.push("" + cfg.dpi);
		}
		if(true == cfg.grayscale)
		{
			args.push("--grayscale");
		}
		if(null != cfg.imageDpi)
		{
			args.push("--image-dpi"); args.push("" + cfg.imageDpi);
		}
		if(null != cfg.imageQuality)
		{
			args.push("--image-quality"); args.push("" + cfg.imageQuality);
		}
		if(true == cfg.lowQuality)
		{
			args.push("--lowquality");
		}
		if(null != cfg.marginTop)
		{
			args.push("--margin-top"); args.push("" + cfg.marginTop);
		}
		if(null != cfg.marginBottom)
		{
			args.push("--margin-bottom"); args.push("" + cfg.marginBottom);
		}
		if(null != cfg.marginLeft)
		{
			args.push("--margin-left"); args.push("" + cfg.marginLeft);
		}
		if(null != cfg.marginRight)
		{
			args.push("--margin-right"); args.push("" + cfg.marginRight);
		}
		if(false == cfg.portrait)
		{
			args.push("--orientation"); args.push("Landscape");
		}
		if(null != cfg.pageSize)
		{
			args.push("--page-size"); args.push(cfg.pageSize);
		}
		if(null != cfg.pageHeight)
		{
			args.push("--page-height"); args.push(cfg.pageHeight);
		}
		if(null != cfg.pageWidth)
		{
			args.push("--page-width"); args.push(cfg.pageWidth);
		}
		if(null != cfg.title)
		{
			args.push("--title"); args.push(cfg.title);
		}
		if(true == cfg.usePrintMediaType)
		{
			args.push("--print-media-type");
		}
		if(true == cfg.disableSmartShrinking)
		{
			args.push("--disable-smart-shrinking");
		}

		// footers
		if(null != cfg.footerCenter)
		{
			args.push("--footer-center"); args.push(cfg.footerCenter);
		}
		if(null != cfg.footerLeft)
		{
			args.push("--footer-left"); args.push(cfg.footerLeft);
		}
		if(null != cfg.footerRight)
		{
			args.push("--footer-right"); args.push(cfg.footerRight);
		}
		if(null != cfg.footerFontName)
		{
			args.push("--footer-font-name"); args.push(cfg.footerFontName);
		}
		if(null != cfg.footerFontSize)
		{
			args.push("--footer-font-size"); args.push(cfg.footerFontSize);
		}
		if(null != cfg.footerHtml)
		{
			args.push("--footer-html"); args.push(cfg.footerHtml);
		}
		if(null != cfg.footerSpacing)
		{
			args.push("--footer-spacing"); args.push(""+cfg.footerSpacing);
		}
		if(true == cfg.footerLine)
		{
			args.push("--footer-line");
		}
		// headers
		if(null != cfg.headerCenter)
		{
			args.push("--header-center"); args.push(cfg.headerCenter);
		}
		if(null != cfg.headerLeft)
		{
			args.push("--header-left"); args.push(cfg.headerLeft);
		}
		if(null != cfg.headerRight)
		{
			args.push("--header-right"); args.push(cfg.headerRight);
		}
		if(null != cfg.headerFontName)
		{
			args.push("--header-font-name"); args.push(cfg.headerFontName);
		}
		if(null != cfg.headerFontSize)
		{
			args.push("--header-font-size"); args.push(cfg.headerFontSize);
		}
		if(null != cfg.headerHtml)
		{
			args.push("--header-html"); args.push(cfg.headerHtml);
		}
		if(null != cfg.headerSpacing)
		{
			args.push("--header-spacing"); args.push(""+cfg.headerSpacing);
		}
		if(true == cfg.headerLine)
		{
			args.push("--header-line");
		}

		return super.commandOptions().concat(args);
	}
}