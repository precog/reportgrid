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
import rg.util.Periodicity;
import rg.axis.ScaleDistribution;
import rg.axis.Stats;
using Arrays;

class AxisTime implements IAxisDiscrete<Float>
{
	public var periodicity(default, null) : String;
	public var scaleDistribution(default, set) : ScaleDistribution;
	public function new(periodicity)
	{
		this.periodicity = periodicity;
		this.scaleDistribution = ScaleFill;
	}

	static var snapping = {
		minute : [ { to : 10, s : 1 }, { to : 20, s : 2 }, { to : 30, s : 5 }, { to : 60, s : 10 }, { to : 120, s : 30 }, { to : 240, s : 60 }, { to : 960, s : 240 } ],
		minutetop : 480,
		hour : [ { to : 12, s : 1 }, { to : 24, s : 6 }, { to : 60, s : 12 }, { to :240, s : 24 }, { to : 480, s : 48 }, { to : 960, s : 120 } ],
		hourtop : 240,
		month : [ { to : 13, s : 1 }, { to : 25, s : 2 }, { to : 49, s : 4 }, { to : 73, s : 6 } ] ,
		monthtop : 12,
		year : [ { to : 10, s : 1 }, { to : 20, s : 2 }, { to : 50, s : 5 } ],
		yeartop : 10
	};

	function isMajor(units : Int, value : Float)
	{
		switch(periodicity)
		{
			case "day":
				if (units <= 31)
					return true;
				if (units < 121)
				{
					var d = Date.fromTime(value).getDate();
					return Periodicity.firstInSeries("month", value) || Periodicity.firstInSeries("week", value);
				}
				return Periodicity.firstInSeries("month", value);
			case "week":
				if (units < 31)
					return true;
				else
					return Date.fromTime(value).getDate() <= 7;
			default:
				var series : Array<{ to : Int, s : Int }> = Reflect.field(snapping, periodicity),
					unit = Periodicity.units(value, periodicity);
				if (null == series)
					return true;
				for (item in series)
				{
					if (units > item.to)
						continue;
					return 0 == unit % item.s;
				}
				var top = Reflect.field(snapping, periodicity + "top");
				if (null == top)
					top = 1;
				return 0 == unit % top;
		}
	}

	public function ticks(start: Float, end: Float, ?upperBound: Int) : Array<ITickmark<Float>>
	{
		var span = end - start,
			units = Periodicity.unitsBetween(start, end, periodicity),
			values = range(start, end),
			range = values.map(function(value) : ITickmark<Float> {
				return new TickmarkTime(value, values, isMajor(units, value), periodicity, scaleDistribution);
			});
		return Tickmarks.bound(range, upperBound);
	}

	public function range(start: Float, end: Float)
	{
		return Periodicity.range(start, end, periodicity);
	}

	public function scale(start : Float, end : Float, v : Float)
	{
		switch (scaleDistribution) {
			case ScaleFill:
				return (v - start) / (end - start);
			default:
				var values = range(start, end);
				return ScaleDistributions.distribute(scaleDistribution, Arrays.indexOf(values, Dates.snap(v, periodicity)), values.length);
		}
	}

	function set_scaleDistribution(v : ScaleDistribution)
	{
		return this.scaleDistribution = v;
	}

	public function min(stats : Stats<Float>, meta : Dynamic) : Float
	{
		return stats.min;
	}
	public function max(stats : Stats<Float>, meta : Dynamic) : Float
	{
		return stats.max;
	}

	public function createStats(type : String) : Stats<Float> return new StatsNumeric(type);
}