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
import rg.util.DataPoints;
using Arrays;

class Segmenter
{
	var on : String;
	var transform : Array<Dynamic> -> Array<Dynamic>;
	var scale : Array<Dynamic> -> Array<Dynamic>;
	var values : Array<String>;
	public function new(on : String, transform : Array<Dynamic> -> Array<Dynamic>, scale : Array<Dynamic> -> Array<Dynamic>, values : Array<String>)
	{
		this.on = on;
		this.transform = transform;
		this.scale = scale;
		this.values = values;
	}

	public function segment(data : Array<Dynamic>) : Array<Array<Dynamic>>
	{
		var segmented;
		if (null == on) {
			segmented = [data];
		} else if(values.length > 0) {
			segmented = [];
			for(value in values) {
				segmented.push(data.filter(function(dp) {
					return Reflect.field(dp, on) == value;
				}));
			}
		} else {
			segmented = DataPoints.partition(data, on);
		}
		if (null != scale)
		{
			for (i in 0...segmented.length)
			{
				segmented[i] = scale(segmented[i]);
			}
		}
		if (null != transform)
		{
			var rotated = Arrays.rotate(segmented);
			for (i in 0...rotated.length)
			{
				rotated[i] = transform(rotated[i]);
			}
			segmented = Arrays.rotate(rotated);
//			segmented.reverse();
			// TODO needs to be reversed?
		}
		return segmented;
	}
}