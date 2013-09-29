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
package rg.svg.util;

import dhx.Selection;
import rg.axis.Stats;
import rg.util.RGColors;
using StringTools;
using Arrays;

class SVGSymbolBuilder
{

	public static function generate(container : BoundSelection<Dynamic, Dynamic>, stats : Stats<Dynamic> , symbol : Dynamic -> Stats<Dynamic> -> String, style : Dynamic -> Stats<Dynamic> -> String)
	{
		if(null == symbol) return;
		var element = createElement(container, stats, symbol);
		RGColors.storeColorForSelection(cast element, "stroke");
		applyStyle(element, stats, style);
	}

	static function createElement(container : BoundSelection<Dynamic, Dynamic>, stats : Stats<Dynamic> , symbol : Dynamic -> Stats<Dynamic> -> String)
	{
		container.each(function(dp : Dynamic, index : Int) {
			var description = symbol(dp, stats);

			createNode(Selection.current, description)
				.classed().add("symbol-item");
		});
		return container.selectAll(".symbol-item");
	}

	static function createNode(container : Selection, description : String)
	{
		if(description.startsWith("image")) {
			var options = parseImageArguments(description.split(":").shift().substr(5));
			return createImage(
					container,
					description.split(":").slice(1).join(":"),
					options);
		} else {
			return createPath(container, description);
		}
	}

	static function createPath(container : Selection, path : String)
	{
		return container
			.append("svg:path")
			.attr("d").string(path);
	}

	static function createImage(container : Selection, url : String, options : ImageOptions)
	{
		var image = container
			.append("svg:image")
				.attr("xlink:href").string(url)
				.attr("width").float(options.width)
				.attr("height").float(options.height)
				.attr("preserveAspectRatio").string(options.aspect)
		;
		image.attr("x").float(switch(options.horizontal) {
			case "right" : -options.width;
			case "center": -options.width / 2;
			default      : 0;
		});
		image.attr("y").float(switch(options.vertical) {
			case "bottom": -options.height;
			case "center": -options.height / 2;
			default      : 0;
		});
		return image;
	}

	static function parseImageArguments(description : String) : ImageOptions
	{
		var options = {
				width      : 50.0,
				height     : 50.0,
				vertical   : "center",
				horizontal : "center",
				aspect     : "none"
			};

		description
			.split(",")
			.map(function(v : String) return v.trim()).filter(function(v) return v != "")
			.each(function(v : String, _) appendOption(options, v))
		;

		return options;
	}

	static var SIZE_PATTERN = ~/^(\d+)x(\d+)$/;
	static var ALIGN_PATTERN = ~/^(center|left|right)\s+(center|top|bottom)$/i;
	static var HORIZONTAL_PATTERN = ~/^(center|left|right)$/i;
	static var VERTICAL_PATTERN = ~/^(top|bottom)$/i;

	static function appendOption(options : ImageOptions, value : String)
	{
		if(SIZE_PATTERN.match(value)) {
			options.width = Std.parseInt(SIZE_PATTERN.matched(1));
			options.height = Std.parseInt(SIZE_PATTERN.matched(2));
		} else if(ALIGN_PATTERN.match(value)) {
			options.horizontal = ALIGN_PATTERN.matched(1).toLowerCase();
			options.vertical = ALIGN_PATTERN.matched(2).toLowerCase();
		} else if(HORIZONTAL_PATTERN.match(value)) {
			options.horizontal = HORIZONTAL_PATTERN.matched(1).toLowerCase();
		} else if(VERTICAL_PATTERN.match(value)) {
			options.vertical = VERTICAL_PATTERN.matched(1).toLowerCase();
		}
	}

	static function applyStyle(element : BoundSelection<Dynamic, Dynamic>, stats : Stats<Dynamic>, style : Dynamic -> Stats<Dynamic> -> String)
	{
		if(null == style) return;
		element.attr("style").stringf(function(dp, _) return style(dp, stats));
	}
}

private typedef ImageOptions = {
	width : Float,
	height : Float,
	vertical : String,
	horizontal : String,
	aspect : String
}