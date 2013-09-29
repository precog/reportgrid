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

package rg.axis;
using Arrays;

class Tickmarks
{
	public static function bound<T>(tickmarks : Array<ITickmark<T>>, ?max : Int) : Array<ITickmark<T>>
	{
		if (null == max || tickmarks.length <= Ints.max(2, max))
			return tickmarks;

		var majors = tickmarks.filter(function(d) return d.major);
		if (majors.length > max)
			return reduce(majors, max);
		var result = reduce(tickmarks.filter(function(d) return !d.major), max - majors.length).concat(majors);
		result.sort(function(a, b) return Floats.compare(a.delta, b.delta));
		return result;
	}

	static function reduce<T>(arr : Array<T>, max : Int)
	{
		if (max == 1)
			return [arr[0]];
		if (max == 2)
			return [arr[arr.length - 1]];
		var keep = arr.length / max,
			result = [],
			i = 0;
		do
		{
			result.push(arr[Math.round(keep * i++)]);
		} while (max > result.length);
		return result;
	}

	public static function string<T>(tick : ITickmark<T>)
	{
		return Dynamics.string(tick.value) + " (" + (tick.major ? "Major" : "minor") + ", " + Floats.format(tick.delta) + ")";
	}

	inline public static function forFloat(start : Float, end : Float, value : Float, major : Bool) : ITickmark<Float>
	{
		return new Tickmark(value, major, (value - start) / (end - start));
	}
}