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

class Tickmark<T> implements ITickmark<T>
{
	@:isVar public var delta(get, null) : Float;
	@:isVar public var major(get, null) : Bool;
	@:isVar public var value(get, null) : T;
	public var label(get, null) : String;

	public function new(value : T, major : Bool, delta : Float)
	{
		this.value = value;
		this.major = major;
		this.delta = delta;
	}

	function get_delta() return delta;
	function get_major() return major;
	function get_value() return value;
	function get_label() return RGStrings.humanize(value);

	function toString() return Tickmarks.string(this);
}