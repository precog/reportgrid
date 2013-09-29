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

class StreamEffects
{
	static function getLightness(p : String, alt : Float)
	{
		if (null == p)
			return alt;
		else
			return Std.parseFloat(p);
	}

	public static function parse(s : String) : StreamEffect
	{
		var parts = s.toLowerCase().split(":");
		switch(parts.shift())
		{
			case "gradient", "gradientv", "gradientvert", "gradientvertical":
				return StreamEffect.GradientVertical(getLightness(parts.pop(), 0.75));
			case "gradienth", "gradienthoriz", "gradienthorizontal":
				return StreamEffect.GradientHorizontal(getLightness(parts.pop(), 0.75));
			default:
				return StreamEffect.NoEffect;
		}
	}
}