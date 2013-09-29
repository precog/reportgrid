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

typedef ConfigObject = {
	cacheExpires			: Float,
	duration				: Null<Float>,
	allowedFormats			: Array<String>,
	params					: Dynamic,
	defaults				: Dynamic,
	zoom					: Null<Float>,
	// PDF
	dpi						: Null<Int>,
	grayscale				: Bool,
	imageDpi				: Null<Int>,
	imageQuality			: Null<Int>,
	lowQuality				: Bool,
	marginTop				: Null<String>,
	marginBottom			: Null<String>,
	marginLeft				: Null<String>,
	marginRight				: Null<String>,
	portrait				: Bool,
	pageHeight				: Null<String>,
	pageSize				: Null<String>,
	pageWidth				: Null<String>,
	title					: Null<String>,
	usePrintMediaType		: Bool,
	disableSmartShrinking	: Bool,

	footerCenter			: Null<String>,
	footerLeft				: Null<String>,
	footerRight				: Null<String>,
	footerFontName			: Null<String>,
	footerFontSize			: Null<String>,
	footerHtml				: Null<String>,
	footerSpacing			: Null<Float>,
	footerLine				: Bool,

	headerCenter			: Null<String>,
	headerLeft				: Null<String>,
	headerRight				: Null<String>,
	headerFontName			: Null<String>,
	headerFontSize			: Null<String>,
	headerHtml				: Null<String>,
	headerSpacing			: Null<Float>,
	headerLine				: Bool,
// IMAGE
	x						: Null<Int>,
	y						: Null<Int>,
	width					: Null<Int>,
	height					: Null<Int>,
	screenWidth				: Null<Int>,
	screenHeight			: Null<Int>,
	quality					: Null<Int>,
	disableSmartWidth		: Bool,
	transparent				: Bool
}