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

package rg.svg.widget;

class BalloonShape 
{

	public static function shape(width : Float, height : Float, rc : Float, rp : Float, side : Int, offset : Float) 
	{
		var w = width - rc * 2,
			h = height - rc * 2;

		var buf = "M" + rc + ",0";
	
		// top
		if (0 == side)
		{
			buf += "h" + offset;
			buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + -rc;
			buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + rc;
			buf += "h" + (w - (offset + 2 * rc));
		} else
			buf += "h" + w;
		// top-right
		buf += "a" + rc + "," + rc + ",0,0,1," + rc + "," + rc;
		// right
		if (1 == side)
		{
			buf += "v" + (offset - rc);
			buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + rc;
			buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + rc;
			buf += "v" + (h - (offset + rc));
		} else
			buf += "v" + h;
		// bottom-right
		buf += "a" + rc + "," + rc + ",0,0,1," + -rc + "," + rc;
		// bottom
		if (2 == side)
		{
			buf += "h" + -(w - (offset + 2 * rc));
			buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + rc;
			buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + -rc;
			buf += "h" + -(offset);
		} else
			buf += "h" + -w;
		// bottom-left
		buf += "a" + rc + "," + rc + ",0,0,1," + -rc + "," + -rc;
		// left
		if (3 == side)
		{
			buf += "v" + -(h - (offset + rc));
			buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + -rc;
			buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + -rc;
			buf += "v" + -(offset - rc);
		} else
			buf += "v" + -h;
		// top-left
		buf += "a" + rc + "," + rc + ",0,0,1," + rc + "," + -rc;
		
		return buf + "Z"
		;
	}
}