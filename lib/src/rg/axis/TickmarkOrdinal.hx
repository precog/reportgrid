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
import rg.util.RGStrings;

using Arrays;

class TickmarkOrdinal<T> implements ITickmark<T>
{
	public static function fromArray<T>(values : Array<T>, scaleDistribution : ScaleDistribution)
	{
		return Arrays.map(values, function(_, i) return new TickmarkOrdinal<T>(i, values, scaleDistribution));
	}

	var pos : Int;
	var values : Array<T>;
	var scaleDistribution : ScaleDistribution;
	public function new(pos : Int, values : Array<T>, major = true, scaleDistribution : ScaleDistribution)
	{
		this.pos = pos;
		this.values = values;
		this.scaleDistribution = scaleDistribution;
		this.major = major;
	}
	public var delta(get, null) : Float;
	function get_delta()
	{
		return ScaleDistributions.distribute(scaleDistribution, pos, values.length);
	}

	@:isVar public var major(get, null) : Bool;
	function get_major() return major;

	public var value(get, null) : T;
	function get_value()
	{
		return values[pos];
	}

	public var label(get, null) : String;
	function get_label()
	{
		return RGStrings.humanize(values[pos]);
	}

	function toString() return Tickmarks.string(this);
}