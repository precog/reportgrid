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

class ConfigPdf
{
	public var dpi						: Null<Int>;
	public var grayscale				: Bool;
	public var imageDpi					: Null<Int>;
	public var imageQuality				: Null<Int>;
	public var lowQuality				: Bool;
	public var marginTop				: Null<String>;
	public var marginBottom				: Null<String>;
	public var marginLeft				: Null<String>;
	public var marginRight				: Null<String>;
	public var portrait					: Bool;
	public var pageHeight				: Null<String>;
	public var pageSize					: Null<String>;
	public var pageWidth				: Null<String>;
	public var title					: Null<String>;
	public var usePrintMediaType		: Bool;
	public var disableSmartShrinking	: Bool;

	public var footerCenter				: Null<String>;
	public var footerLeft				: Null<String>;
	public var footerRight				: Null<String>;
	public var footerFontName			: Null<String>;
	public var footerFontSize			: Null<String>;
	public var footerHtml				: Null<String>;
	public var footerSpacing			: Null<Float>;
	public var footerLine				: Bool;

	public var headerCenter				: Null<String>;
	public var headerLeft				: Null<String>;
	public var headerRight				: Null<String>;
	public var headerFontName			: Null<String>;
	public var headerFontSize			: Null<String>;
	public var headerHtml				: Null<String>;
	public var headerSpacing			: Null<Float>;
	public var headerLine				: Bool;
	public function new()
	{
		grayscale = false;
		lowQuality = false;
		portrait = true;
		usePrintMediaType = false;
		disableSmartShrinking = false;
		footerLine = false;
		headerLine = false;
	}

	public function toString()
	{
		return "ConfigPdf: " + ConfigObjects.fieldsToString(this);
	}
}