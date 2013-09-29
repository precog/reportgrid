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
import rg.frame.Frame;
import rg.frame.StackItem;
import dhx.Selection;
using Arrays;

class Panel
{
	public var frame(default, null) : Frame;
	public var g(default, null) : Selection;
	public var parent(default, null) : Container;

	var _layers : Array<Layer>;

	public function new(frame : StackItem)
	{
		this.frame = frame;
		frame.change = reframe;
		_layers = [];
	}

	public function toString()
	{
		return Type.getClassName(Type.getClass(this)).split('.').pop();
	}

	function addLayer(layer : Layer)
	{
		_layers.remove(layer);
		_layers.push(layer);
	}

	function removeLayer(layer : Layer)
	{
		_layers.remove(layer);
	}

	function setParent(container : Container)
	{
		if (null != g)
			g.remove();

		parent = container;
		if (null == container)
			return;

		init(container.g);
	}

	function init(container : Selection)
	{
		g = container.append("svg:g")
			.attr("class").string("panel")
			.attr("transform").string("translate(" + frame.x + "," + frame.y + ")");
#if debug
		g.append("svg:rect")
			.attr("class").string("panel-frame")
			.attr("width").float(frame.width)
			.attr("height").float(frame.height);
#end
	}

	function reframe()
	{
		g
			.attr("transform").string("translate(" + frame.x + "," + frame.y + ")")
#if debug
			.select("rect.panel-frame")
				.attr("width").float(frame.width)
				.attr("height").float(frame.height)
#end
		;

		var layer : { private function _resize() : Void; };
		for (i in 0..._layers.length)
		{
			layer = _layers[i];
			layer._resize();
		}
	}
}