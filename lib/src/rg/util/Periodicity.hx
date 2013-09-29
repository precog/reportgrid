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
import thx.culture.FormatDate;
import thx.date.DateParser;
using Arrays;

class Periodicity
{
	public static function defaultPeriodicity(span : Float)
	{
		if (null == span || 0 == span)
			return "eternity";
		if (span <= 6 * 60 * 60 * 1000)
			return "minute";
		else if (span <=  2 * 24 * 60 * 60 * 1000)
			return "hour";
		else if (span <=  60 * 24 * 60 * 60 * 1000)
			return "day";
		else if (span <=  720 * 24 * 60 * 60 * 1000)
			return "month";
		else
			return "year";
	}

	public static function defaultRange(periodicity : String) : Array<Float>
	{
		return switch(periodicity)
		{
			case "eternity", "single":
				[0.0, 0.0];
			case "minute":
				parsePair("6 hours ago", "now");
			case "hour":
				parsePair("2 days ago", "now");
			case "day":
				parsePair("14 days ago", "today");
//			case "week":
//				parsePair("6 weeks ago", "today");
			case "month":
				parsePair("6 months ago", "today");
			case "year":
				parsePair("6 years ago", "today");
			case _:
				throw "invalid periodicity: " + periodicity;
		}
	}

	static var validPeriods = ["minute", "hour", "day", "week", "month", "year", "eternity"];
	public static function isValid(v : String)
	{
		return Arrays.exists(validPeriods, v);
	}

	public static function calculateBetween(a : Null<Date>, b : Null<Date>, disc = 2)
	{
		if (null == a || null == b)
			return "eternity";
		var delta = Math.abs(b.getTime() - a.getTime());
		if (delta >= DateTools.days(365 * disc))
			return "year";
		else if (delta >= DateTools.days(30 * disc))
			return "month";
		else if (delta >= DateTools.days(7 * disc))
			return "week";
		else if (delta >= DateTools.days(disc))
			return "day";
		else if (delta >= DateTools.hours(disc))
			return "hour";
		else
			return "minute";
	}

	public static function unitsBetween(start : Float, end : Float, periodicity : String) : Int
	{
		return switch(periodicity)
		{
			case "eternity", "single": 1;
			case "minute":   Math.floor((end - start) / 60000);
			case "hour":     Math.floor((end - start) / (60 * 60000));
			case "day":      Math.floor((end - start) / (24 * 60 * 60000));
			case "week":     Math.floor((end - start) / (7 * 24 * 60 * 60000));
			case "month":
				var s = Date.fromTime(start),
					e = Date.fromTime(end),
					sy = s.getFullYear(),
					ey = e.getFullYear(),
					sm = s.getMonth(),
					em = e.getMonth();
				(ey - sy) * 12 + (em - sm);
			case "year":
				Math.floor(unitsBetween(start, end, "month") / 12);
			case _:
				throw "invalid periodicity: " + periodicity;
		}
	}

	public static function units(value : Float, periodicity : String) {
		return unitsBetween(0, value, periodicity) + switch(periodicity) {
			case "hour" : 1;
			default: 0;
		};
	}

	public static function range(start : Float, end : Float, periodicity : String) : Array<Float>
	{
		var step = 1000;
//		start = Dates.snap(start, periodicity);
//		end = Dates.snap(end, periodicity);
		switch(periodicity)
		{
			case "eternity", "single":
				return [0.0];
			case "minute":
				step = 60000;
			case "hour":
				step = 60 * 60000;
			case "day":
//				step = 24 * 60 * 60000;

				var s = Dates.snap(start, "day"), // dateUtc(start).getTime(),
					e = Dates.snap(end, "day"); // dateUtc(end).getTime();
				var result = [];
				while(s <= e)
				{
					result.push(s);
					s = Dates.snap(s+24*60*60*1000, "day");
				}
				return result;
			case "week":
				step = 7 * 24 * 60 * 60000;
			case "month":
				var s = dateUtc(start),
					e = dateUtc(end),
					sy = s.getFullYear(),
					ey = e.getFullYear(),
					sm = s.getMonth(),
					em = e.getMonth();
				var result = [];
				while (sy < ey || (sy == ey && sm <= em))
				{
					result.push(new Date(sy, sm, 1, 0, 0, 0).getTime());
					sm++;
					if (sm > 11)
					{
						sm = 0;
						sy++;
					}
				}
				return result;
			case "year":
				var result = Ints.range(dateUtc(start).getFullYear(), dateUtc(end).getFullYear()+1, 1).map(function(d) {
					return new Date(d, 0, 1, 0, 0, 0).getTime();
				});
				return result;
		}
		return Floats.range(start, end + step, step);
	}

	public static function next(periodicity : String, ?date : Float, ?step = 1) : Float
	{
		if (null == date)
			date = Date.now().getTime();
		if (0 == step)
			return date;
		return switch(periodicity)
		{
			case "eternity", "single": date;
			case "minute": date + 60000 * step;
			case "hour": date + 60 * 60000 * step;
			case "day": date + 24 * 60 * 60000 * step;
			case "week": date + 7 * 24 * 60 * 60000 * step;
			case "month":
				var d = Date.fromTime(date),
					y = d.getFullYear(),
					m = d.getMonth() + step;
				new Date(y, m, d.getDay(), d.getHours(), d.getMinutes(), d.getSeconds()).getTime();
			case "year":
				var d = Date.fromTime(date);
				new Date(d.getFullYear() + step, d.getMonth(), d.getDay(), d.getHours(), d.getMinutes(), d.getSeconds()).getTime();
			case _:
				throw "invalid periodicity: " + periodicity;
		}
	}

	public static function minForPeriodicityInSeries(arr : Array<Dynamic<Dynamic<Int>>>, periodicity : String)
	{
		return Arrays.floatMin(arr, function(d) {
			return Arrays.floatMin(Reflect.fields(Reflect.field(d, periodicity)), function(d) return Std.parseFloat(d));
		});
	}

	public static function maxForPeriodicityInSeries(arr : Array<Dynamic<Dynamic<Int>>>, periodicity : String)
	{
		return Arrays.floatMax(arr, function(d) {
			return Arrays.floatMax(Reflect.fields(Reflect.field(d, periodicity)), function(d) return Std.parseFloat(d));
		});
	}

	public static function formatf(periodicity : String) : Float -> String
	{
		return switch(periodicity)
		{
			case "eternity": function(_ : Float) return "all time";
			case "single": function(_ : Float) return "period";
			case "minute", "hour": function(v : Float) return FormatDate.timeShort(Date.fromTime(v));
			case "day", "week": function(v : Float) return FormatDate.dateShort(Date.fromTime(v));
			case "month": function(v : Float) return FormatDate.yearMonth(Date.fromTime(v));
			case "year": function(v : Float) return FormatDate.year(Date.fromTime(v));
			case _:
				throw "invalid periodicity: " + periodicity;
		}
	}

	public static function format(periodicity : String, v : Float) : String
	{
		switch(periodicity)
		{
			case "eternity": return "all time";
			case "single": return "period";
			case "minute": return FormatDate.timeShort(Date.fromTime(v));
			case "hour": return FormatDate.hourShort(Date.fromTime(v));
			case "day", "week": return FormatDate.dateShort(Date.fromTime(v));
			case "month": return FormatDate.yearMonth(Date.fromTime(v));
			case "year": return FormatDate.year(Date.fromTime(v));
			default: return periodicity + ": " + v;
		}
	}

	public static function smartFormat(periodicity : String, v : Float) : String
	{
		switch(periodicity)
		{
			case "eternity", "single":
				return "all time";
			case "minute":
				if (firstInSeries("hour", v))
					return FormatDate.timeShort(Date.fromTime(v));
				else
					return formatDate("%i", Date.fromTime(v));
			case "hour":
				if (firstInSeries("day", v))
					return formatDate("%b %e", dateUtc(v));
				else
					return FormatDate.hourShort(Date.fromTime(v));
			case "day":
				if (firstInSeries("month", v))
					return formatDate("%b %e", dateUtc(v));
				else
					return formatDate("%e", dateUtc(v));
			case "week":
				var d = dateUtc(v);
				if (d.getDate() <= 7)
					return formatDate("%b %e", d);
				else
					return formatDate("%e", d);
			case "month":
				if (firstInSeries("year", v))
					return FormatDate.year(dateUtc(v));
				else
					return formatDate("%b", dateUtc(v));
			case "year":
				return FormatDate.year(dateUtc(v));
			default:
				return periodicity + ": " + Date.fromTime(v);
		}
	}

	static function formatDate(pattern : String, date : Date)
	{
		return FormatDate.format(date, pattern);
	}

	public static function firstInSeries(periodicity : String, v : Float) : Bool
	{
		return switch(periodicity)
		{
			case "eternity", "single": 0 == v;
			case "minute":   0 == v % 60000;
			case "hour":     0 == v % (60000 * 60);
			case "day":
				var d = Date.fromTime(v);
				0 == d.getHours() && 0 == d.getMinutes() && 0 == d.getSeconds();
			case "week":
				var d = Date.fromTime(v);
				0 == d.getDay();
			case "month":
				var d = Date.fromTime(v);
				1 == d.getDate();
			case "year":
				var d = Date.fromTime(v);
				1 == d.getDate() && 0 == d.getMonth();
			default: false;
		}
	}

	public static function nextPeriodicity(periodicity : String) : String
	{
		return switch(periodicity)
		{
			case "minute":      "hour";
			case "hour":        "day";
			case "day", "week": "month";
			case "month":       "year";
			default: "year";
		}
	}

	public static function prevPeriodicity(periodicity : String) : String
	{
		return switch(periodicity)
		{
			case "minute":			"hour";
			case "hour":			"minute";
			case "day":				"hour";
			case "week", "month":	"day";
			default: "minute";
		}
	}

	static function parsePair(start : String, end : String) : Array<Float>
	{
		return [
			DateParser.parse(start).getTime(),
			DateParser.parse(end).getTime()
		];
	}

	static inline function timezoneOffset(d : Date) : Float
	{
		return untyped d.getTimezoneOffset();
	}

	static function dateUtc(v : Float)
	{
		var d = Date.fromTime(v),
			offset : Float = timezoneOffset(d);
		if (offset < 0)
			offset = 0;
		return Date.fromTime(v + 60000 * offset);
	}

	static var validGroupValues = ["hour", "day", "week", "month", "year"];
	public static function isValidGroupBy(value : String)
	{
		return validGroupValues.exists(value);
	}

}