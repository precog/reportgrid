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

package rg.svg.panel;

class Panels
{
	public static function rootSize(panel : Panel)
	{
		var p = panel.parent;
		while (p != null)
		{
			var t = p;
			p = panel.parent;
			panel = t;
		}
		return { width : panel.frame.width, height : panel.frame.height };
	}

	public static function absolutePos(panel : Panel)
	{
		var p = panel, x = 0, y = 0;
		while (null != p)
		{
			panel = p;
			x += p.frame.x;
			y += p.frame.y;
			p = p.parent;
		}
		var node = htmlContainer(panel),
			left = js.Scroll.getLeft(),
			top  = js.Scroll.getTop();
		if(null == node)
		{
			return {
				x : left,
				y : top
			}
		}
		var rect : Dynamic<Int> = untyped node.getBoundingClientRect();
		return {
			x : rect.left + x + left,
			y : rect.top + y + top
		};
	}
	public static function svgContainer(panel : Panel)
	{
		var node = panel.g.node();
		do {
			node = untyped node.ownerSVGElement;
		} while(null != node && null != Reflect.field(untyped node.ownerSVGElement, "ownerSVGElement"));
		return null == node ? null : node;
	}

	public static function htmlContainer(panel : Panel)
	{
		var svg = svgContainer(panel);
		if(null == svg)
			return null;
		else
			return svg.parentNode;
	}

	public static function boundingBox(panel : Panel, ?ancestor : Panel)
	{
		var p = panel, x = 0, y = 0;
		while (ancestor != p)
		{
			x += p.frame.x;
			y += p.frame.y;
			p = p.parent;
		}
		return {
			x : x,
			y : y,
			width : panel.frame.width,
			height : panel.frame.height
		};
	}

	public static function ancestorBoundingBox(panel : Panel, ?ancestor : Panel)
	{
		var p = panel, x = 0, y = 0, w = 0, h = 0;
		while (ancestor != p)
		{
			x += p.frame.x;
			y += p.frame.y;
			w = p.frame.width;
			h = p.frame.height;
			p = p.parent;
		}
		return {
			x : -x,
			y : -y,
			width : w,
			height : h
		};
	}
}