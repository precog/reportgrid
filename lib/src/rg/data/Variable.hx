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

package rg.data;

import rg.axis.IAxis;
import rg.axis.Stats;
import rg.axis.ScaleDistribution;
import thx.error.Error;

class Variable<T, TAxis : IAxis<T>>
{
	public var type : String;
	public var scaleDistribution : Null<ScaleDistribution>;
	public var axis(default, null) : TAxis;
	public var stats(default, null) : Stats<T>;
	public var meta(default, null) : Dynamic;
	@:isVar public var minf(get, set) : Stats<T> -> Dynamic -> T;
	@:isVar public var maxf(get, set) : Stats<T> -> Dynamic -> T;

	public function new(type : String, scaleDistribution : Null<ScaleDistribution>)
	{
		this.type = type;
		this.scaleDistribution = scaleDistribution;
		this.meta = { };
	}

	public function setAxis(axis : TAxis)
	{
		this.axis = axis;
		if (null != axis)
			this.stats = axis.createStats(type);
		else
			this.stats = null;
	}

	public function min() return minf(stats, meta);
	public function max() return maxf(stats, meta);

	function set_minf(f : Stats<T> -> Dynamic -> T) return minf = f;
	function set_maxf(f : Stats<T> -> Dynamic -> T) return maxf = f;

	function get_minf()
	{
		if (null == minf)
		{
			if (null == axis)
				throw new Error("axis is null in '{0}' variable (required by min)", [type]);
			minf = axis.min;
		}
		return minf;
	}

	function get_maxf()
	{
		if (null == maxf)
		{
			if (null == axis)
				throw new Error("axis is null in '{0}' variable (required by max)", [type]);
			maxf = axis.max;
		}
		return maxf;
	}
}