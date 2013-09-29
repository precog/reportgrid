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

class Stats<T>
{
	public var min(default, null) : Null<T>;
	public var max(default, null) : Null<T>;
	public var count(default, null) : Int;
	public var values(default, null) : Array<T>;
	public var sortf(default, null) : T -> T -> Int;
	public var type(default, null) : String;

	public function new(type : String, ?sortf : T -> T -> Int)
	{
		this.type = type;
		this.sortf = sortf;
		reset();
	}

	public function reset() : Stats<T>
	{
		min = null;
		max = null;
		count = 0;
		values = [];
		return this;
	}

	public function add(v : T) : Stats<T>
	{
		count++;
		if (values.exists(v))
			return this;

		values.push(v);
		if (null != sortf)
			values.sort(sortf);
		min = values.first();
		max = values.last();
		return this;
	}

	public function addMany(it : Iterable<T>) : Stats<T>
	{
		for (v in it)
		{
			count++;
			if (values.exists(v))
				continue;
			values.push(v);
		}
		if (null != sortf)
			values.sort(sortf);
		min = values.first();
		max = values.last();
		return this;
	}
}

class StatsNumeric extends Stats<Float>
{
	public var tot : Float;
	public function new(type : String, ?sortf : Float -> Float -> Int)
	{
		if (null == sortf)
			sortf = Floats.compare;
		super(type, sortf);
	}

	override function reset() : Stats<Float>
	{
		super.reset();
		tot = 0.0;
		return this;
	}

	override function add(v : Float) : Stats<Float>
	{
		super.add(v);
		tot += v;
		return this;
	}

	override function addMany(it : Iterable<Float>) : Stats<Float>
	{
		super.addMany(it);
		for (v in it)
			tot += v;
		return this;
	}
}