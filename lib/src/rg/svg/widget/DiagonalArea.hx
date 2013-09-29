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
package rg.svg.widget;

import dhx.Selection;
import thx.svg.Diagonal;

class DiagonalArea
{
	public var g(default, null) : Selection;
	var diagonal : Diagonal<Array<Float>>;
	public var area(default, null) : Selection;
	var before : Selection;
	var after : Selection;
	public function new(container : Selection, classarea : String, classborder : String)
	{
		g       = container.append("svg:g").attr("class").string("diagonal");
		diagonal = Diagonal.forArray().projection(function(a, _) return [a[1], a[0]]);
		area     = g.append("svg:path").attr("class").string("diagonal-fill" + (null == classarea ? "" : " " + classarea));
		before   = g.append("svg:path").attr("class").string("diagonal-stroke before" + (null == classborder ? "" : " " + classborder));
		after    = g.append("svg:path").attr("class").string("diagonal-stroke after" + (null == classborder ? "" : " " + classborder));
	}

	public function addClass(cls : String)
	{
		g.classed().add(cls);
	}

	public function update(x1 : Float, y1 : Float, x2 : Float, y2 : Float, sw : Float, ew : Float)
	{

		var top    = diagonal.diagonal([y1,x1,y2,x2]),
			bottom = diagonal.diagonal([y2+ew,x2,y1+sw,x1]);

		var path = top + "L" + bottom.substr(1) + "z";

		before.attr("d").string(top);
		after.attr("d").string(bottom);
		area.attr("d").string(path);
	}
}