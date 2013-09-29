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
/**
 * ...
 * @author Franco Ponticelli
 */

package rg.svg.util;
import js.Browser;
import dhx.Dom;
import dhx.Selection;

class RGCss
{
	static var cache : Array<String>;
	public static function cssSources()
	{
		var sources = [];
		Dom.selectAll('link[rel="stylesheet"]').eachNode(function(n, _) {
			sources.push(untyped n.href);
		});
		return sources;
	}

	public static function colorsInCss()
	{
		if (null != cache)
			return cache;
		var container = Dom.select("body").append("svg:svg").attr("class").string("rg"),
			first = createBlock(container, 0).style("fill").get();
		cache = [first];
		for (i in 1...1000) // tollerance value
		{
			var other = createBlock(container, i).style("fill").get();
			if (first == other)
			{
				break;
			} else
				cache.push(other);
		}
		container.remove();
		haxe.Timer.delay(function() {
			cache = null;
		}, 1000);
		return cache;
	}

	public static function numberOfColorsInCss()
	{
		return colorsInCss().length;
	}

	static function createBlock(container : Selection, pos : Int)
	{
		return container.append("svg:rect").attr("class").string("fill-" + pos);
	}
}