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

class RGStrings 
{
	static var range = ~/(\d+(?:\.\d+)?|\.\d+)?-(\d+(?:\.\d+|\.\d+)?)?/;
	public static function humanize(d : Dynamic) 
	{
		if (Std.is(d, Int))
			return Ints.format(d);
		if (Std.is(d, Float))
			return Floats.format(d);
		var s = Std.string(d);
		if (range.match(s))
		{
			var v1 = range.matched(1),
				v2 = range.matched(2);
			if (null != v1)
				v1 = Ints.canParse(v1) ? Ints.format(Ints.parse(v1)) : Floats.format(Floats.parse(v1));
			else
				v1 = '';
			if (null != v2)
				v2 = Ints.canParse(v2) ? Ints.format(Ints.parse(v2)) : Floats.format(Floats.parse(v2));
			else
				v2 = '';
			return hstring(range.matchedLeft()) + v1 + "-" + v2 + hstring(range.matchedRight());
		} else {
			return hstring(s);
		}
	}

	static function hstring(s : String)
	{
		return Strings.ucwords(Strings.humanize(s));
	}
}