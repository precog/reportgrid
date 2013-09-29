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

package rg.frame;

class Frame
{

	public var x(default, null) : Int;
	public var y(default, null) : Int;
	public var width(default, null) : Int;
	public var height(default, null) : Int;

	public dynamic function change() {}

	public function new()
	{
		x = y = width = height = 0;
	}

	function set_layout(x : Int, y : Int, width : Int, height : Int)
	{
		if (this.x == x && this.y == y && this.width == width && this.height == height)
			return;
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
		change();
	}

	public function toString() return "[x: " + x +", y: " + y + ", width: " + width + ", height: " + height + "]";
}

typedef FrameFriend = {
	private function set_layout(x : Int, y : Int, width : Int, height : Int) : Void;
}