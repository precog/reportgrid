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
import thx.error.Error;

class AxisGroupByTime extends AxisOrdinalFixedValues<Int>
{
	public function new(groupby : String)
	{
		super(valuesByGroup(groupby));
		groupBy = groupby;
	}

	public var groupBy(default, null) : String;

	public static function valuesByGroup(groupby : String)
	{
		return Ints.range(defaultMin(groupby), defaultMax(groupby) + 1);
	}


	public static function defaultMin(periodicity : String)
	{
		switch(periodicity)
		{
			case "minute", "hour", "week", "month":
				return 0;
			case "day":
				return 1;
			default:
				throw new Error("invalid periodicity '{0}' for groupBy min", periodicity);
		}
	}

	public static function defaultMax(periodicity : String)
	{
		switch(periodicity)
		{
			case "minute":	return 59;
			case "hour":	return 23;
			case "day":		return 31;
			case "week":	return 6;
			case "month":	return 11;
			default:
				throw new Error("invalid periodicity '{0}' for groupBy max", periodicity);
		}
	}
}