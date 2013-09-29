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

class LineEffects
{
	public static function parse(s : String) : LineEffect
	{
		var parts = s.toLowerCase().split(":");
		switch(parts.shift())
		{
			case "dropshadow":
				var offsetx = 0.5,
					offsety = 0.5,
					levels = 2,
					parameters = parts.pop();
				if (null != parameters)
				{
					var parameters = parameters.split(",");
					offsetx = Std.parseFloat(parameters[0]);
					if(parameters.length > 1)
						offsety = Std.parseFloat(parameters[1]);
					else
						offsety = offsetx;
					if (parameters.length > 2)
						levels =  Std.parseInt(parameters[2]);
				}
				return LineEffect.DropShadow(offsetx, offsety, levels);
			case "gradient":
				var lightness = 0.75,
					levels = 2,
					parameters = parts.pop();
				if (null != parameters)
				{
					lightness = Std.parseFloat(parameters.split(",").shift());
					var nlevels = parameters.split(",").pop();
					if (null != nlevels)
						levels =  Std.parseInt(nlevels);
				}
				return LineEffect.Gradient(lightness, levels);
			default:
				return LineEffect.NoEffect;
		}
	}
}