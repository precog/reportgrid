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

package rg.util;
import thx.color.Colors;
import thx.color.Hsl;

class RGColors
{
	public static function parse(s : String, alt : String)
	{
		try {
			var c = Colors.parse(s);
			if (null != c)
				return c;
		} catch (_:Dynamic) { };
		return Colors.parse(alt);
	}

	public static function applyLightness(color : Hsl, lightness : Float, ?t : Float)
	{
		if (null == t)
		{
			t = 1 / Math.abs(lightness);
		}
		return lightness >= 0
			? Hsl.lighter(color, (1 - t) * (1 + lightness))
			: Hsl.darker(color, (1 - t) * (1 - lightness));
	}

	public static function extractColor(n : js.html.Element) : String
	{
		return untyped n.__rgcolor__;
	}

	public static function storeColor(n : js.html.Element, color)
	{
		untyped n.__rgcolor__ = color;
	}

	public static function storeColorForSelection(n : dhx.Selection, style = "fill", ?color : String)
	{
		n.eachNode(function(n, _) {
			var c = (null == color) ? dhx.Selection.current.style(style).get() : color;
			RGColors.storeColor(n, c);
		});
	}
}