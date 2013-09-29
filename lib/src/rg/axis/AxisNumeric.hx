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
import rg.axis.Stats;
import thx.math.Const;
using Arrays;

class AxisNumeric implements IAxis<Float>
{
	public function new() { }
	public function scale(start : Float, end : Float, v : Float)
	{
		if (start == end)
			return start;
		return Floats.uninterpolatef(start, end)(v);
	}

	public function ticks(start : Float, end : Float, ?maxTicks : Int) : Array<ITickmark<Float>>
	{
		var span = end - start,
			step = 1.0,
			minors, majors;
		if ((start % step == 0) && (end % step == 0) && span < 10 && span >= step)
		{
			majors = Floats.range(start, end + step, step);
			minors = null;
		} else {
			var mM = 5,
				mm = 20,
				stepM = _step(span, mM),
				stepm = _step(span, mm);
			if(stepm == 0)
				minors = [0.0];
			else
				minors = Floats.range(start, end, stepm, true, true);
			if(stepM == 0)
				majors = [0.0];
			else
				majors = Floats.range(start, end, stepM, true, true);
		}
		var r = Tickmarks.bound(null == minors
			? majors.map(function(d : Float) return Tickmarks.forFloat(start, end, d, true))
			: minors.map(function(d : Float) return Tickmarks.forFloat(start, end, d, majors.remove(d))
		), maxTicks);
		return r;
	}

	static function _step(span : Float, m : Int)
	{
		var step = Math.pow(10, Math.floor(Math.log(span / m) / Const.LN10)),
			err = m / span * step;
		if (err <= .15)
			step *= 10;
		else if (err <= .35)
			step *= 5;
		else if (err <= .75)
			step *= 2;
		return step;
	}

	inline static function nice(v : Float)
	{
		return Math.pow(10, Math.round(Math.log(v) / Const.LN10) - 1);
	}

	inline static function niceMin(d : Float, v : Float)
	{
		var dv = nice(d);
		return Math.floor(v/dv)*dv;
	}

	inline static function niceMax(d : Float, v : Float)
	{
		var dv = nice(d);
		return Math.ceil(v/dv)*dv;
	}

	public function min(stats : Stats<Float>, meta : Dynamic) : Float
	{
		if(null != meta.min)
			return meta.min;
		var min = niceMin(stats.max - stats.min, stats.min);
		if (min < 0)
			return min;
		else
			return 0.0;
	}

	public function max(stats : Stats<Float>, meta : Dynamic) : Float
	{
		if(null != meta.max)
			return meta.max;
		var max = niceMax(stats.max - stats.min, stats.max);
		if (max > 0)
			return max;
		else
			return 0.0;
	}

	public function createStats(type : String) : Stats<Float> return new StatsNumeric(type);
}