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
import thx.error.Error;

class Properties
{
	public inline static var TIME_TOKEN = "time:";

	inline public static function isTime(s : String)
	{
		return s.indexOf(TIME_TOKEN) >= 0;
	}

	inline public static function periodicity(s : String)
	{
		return s.substr(s.indexOf(TIME_TOKEN) + TIME_TOKEN.length);
	}

	inline public static function timeProperty(periodicity : String)
	{
		return "." + TIME_TOKEN + periodicity;
	}

	inline public static function humanize(s : String)
	{
		return RGStrings.humanize(s);
	}

	public static function formatValue(type : String, dp : Dynamic)
	{
		var value : Dynamic = DataPoints.value(dp, type);
		if(null == value)
			return value;
		if(Properties.isTime(type))
		{
			var periodicity = Properties.periodicity(type);
			return Periodicity.format(periodicity, Dates.snap(value, periodicity));
		}
		return RGStrings.humanize(value);
	}
}