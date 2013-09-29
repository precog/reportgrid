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

package rg.svg.chart;

import thx.error.Error;
import thx.color.Colors;
using Arrays;

class ColorScaleModes
{
	public static function canParse(v : Dynamic) : Bool {
		try {
			createFromDynamic(v);
			return true;
		} catch(e : Dynamic) {
			return false;
		}
	}

	public static function createFromDynamic(v : Dynamic) : ColorScaleMode
	{
		if (Reflect.isFunction(v))
			return ColorScaleMode.Fun(v);
		if (!Std.is(v, String))
			return throw new Error("invalid color mode '{0}'", [v]);
		var s = cast(v, String).split(":");

		switch(s[0].toLowerCase())
		{
			case "css":
				return ColorScaleMode.FromCss(null == s[1] ? null : Std.parseInt(s[1]));
			case "i", "interpolated":
				return ColorScaleMode.Interpolation(s[1].split(",").map(function(d) {
					return Colors.parse(d);
				}));
			case "s", "sequence":
				return ColorScaleMode.Sequence(s[1].split(",").map(function(d) {
					return Colors.parse(d);
				}));
			case "f", "fixed":
				return ColorScaleMode.Fixed(Colors.parse(s[1]));
			default:
				if (s[0].indexOf(",") >= 0)
					return ColorScaleMode.Sequence(s[0].split(",").map(function(d) {
						return Colors.parse(d);
					}));
				else
					return ColorScaleMode.Fixed(Colors.parse(s[0]));
		}
	}
}