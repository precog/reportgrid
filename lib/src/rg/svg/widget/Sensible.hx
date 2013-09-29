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
import rg.svg.panel.Panel;

class Sensible
{
	public static function sensibleZone(container : Selection, panel : Panel, click : js.html.Element -> Void, datapointover : js.html.Element -> Void, radius : Float)
	{
		if(null == click && null == datapointover)
			return;
		var sensible = container
			.append("svg:rect")
				.attr("class").string("sensible")
				.attr("x").float(0)
				.attr("y").float(0)
				.attr("width").float(panel.frame.width)
				.attr("height").float(panel.frame.height)
				.attr("fill").string("#000")
				.style("fill-opacity").float(0.0)
			;

		if(null != datapointover)
		{
			sensible.onNode("mousemove", function(_, _) {
				var r = findDataNodeNearMouse(container, radius);
				if(r.length > 0)
				{
					datapointover(r[0]);
					if(null != click)
					{
						sensible.classed().add("pointer");
					}
				} else if(null != click)
				{
					sensible.classed().remove("pointer");
				}
			});
		}
		if(null != click)
		{
			if(null == datapointover)
			{
				sensible.onNode("mousemove", function(_, _) {
					var r = findDataNodeNearMouse(container, radius);
					if(r.length > 0)
					{
						sensible.classed().add("pointer");
					} else {
						sensible.classed().remove("pointer");
					}
				});
			}
			sensible.onNode("click", function(_, _) {
				var r = findDataNodeNearMouse(container, radius);
				if(r.length > 0)
					click(r[0]);
			});
		}
	}

	public static function findDataNodeNearMouse(context : Selection, distance : Float)
	{
		var e = dhx.Dom.event;
		return findDataNodesNear({ x : untyped e.clientX, y : untyped e.clientY }, context, distance);
	}

	public static function findDataNodesNear(coords : { x : Int, y : Int }, context : Selection, distance : Float)
	{
		var nodes = context.selectAll(".rgdata"),
			result = [],
			distancep = distance * distance;
		nodes.eachNode(function(n : js.html.Element, i) {
			var rect : Dynamic<Float> = untyped n.getBoundingClientRect();
			var x = coords.x - (rect.left + rect.width / 2),
				y = coords.y - (rect.top + rect.height / 2);
			var dist = x * x + y * y;
			if(dist > distancep)
				return;
			result.push({ node : n, dist : dist });
		});
		result.sort(function(a, b) {
			return Floats.compare(a.dist, b.dist);
		});
		return Arrays.map(result, function(item, _) return item.node);
	}
}