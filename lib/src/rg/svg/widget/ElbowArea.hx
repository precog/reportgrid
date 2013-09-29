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

class ElbowArea
{
	public var g(default, null) : Selection;
	public var area(default, null)  : Selection;
	var outer : Selection;
	var inner : Selection;
	public function new(container : Selection, classarea : String, classborder : String)
	{
		g     = container.append("svg:g").attr("class").string("elbow");
		area  = g.append("svg:path").attr("class").string("elbow-fill" + (null == classarea ? "" : " " + classarea));
		outer = g.append("svg:path").attr("class").string("elbow-stroke outer" + (null == classborder ? "" : " " + classborder));
		inner = g.append("svg:path").attr("class").string("elbow-stroke inner" + (null == classborder ? "" : " " + classborder));
	}

	public function addClass(cls : String)
	{
		g.classed().add(cls);
	}

	public function update(orientation : Orientation, weight : Float, x : Float, y : Float, minradius = 3.0, maxradius = 16.0, before = 0.0, after = 10.0)
	{
		if(weight == 0)
			return;
		var dinner = "",
			douter = "",
			rad = weight < 0 ? Math.max(maxradius, weight) : Math.min(maxradius, weight);

		switch(orientation)
		{
			case RightBottom:
				dinner = "M" + (before+x+minradius)+","+(y+minradius+after)+"L"+(before+x+minradius)+","+(y+minradius)+"A"+Math.abs(minradius)+","+Math.abs(minradius)+" 0 0,0 "+(before+x)+","+y+"L"+x+","+y;
				douter = "M"+x+","+(y-weight)+"L"+(before+x)+","+(y-weight)+"A"+Math.abs(rad)+","+Math.abs(rad)+" 0 0,1 "+(before+x+rad)+","+(y-weight+rad)+"L"+(before+x+rad)+","+(y+after+minradius);
			case LeftBottom:

			case RightTop:

			case LeftTop:
				update(RightBottom, -weight, x, y, -minradius, -maxradius, -before, -after);
				return;
			case BottomRight:

			case BottomLeft:

			case TopRight:

			case TopLeft:
		}
		var darea = douter + "L" + dinner.substr(1) + "z";
		inner.attr("d").string(dinner);
		outer.attr("d").string(douter);
		area.attr("d").string(darea);
	}
}

enum Orientation
{
	RightBottom;
	LeftBottom;
	RightTop;
	LeftTop;
	BottomRight;
	BottomLeft;
	TopRight;
	TopLeft;
}