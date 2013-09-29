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
import dhx.Selection;
using Arrays;

class Layer
{
	var panel : Panel;
	var frame : Frame;
	var g : Selection;
	public var width(default, null) : Int;
	public var height(default, null) : Int;

	public var customClass(default, set) : String;

	public function new(panel : Panel)
	{
		this.frame = (this.panel = panel).frame;
		var p : SvgPanelFriend = panel;
		p.addLayer(this);
		g = panel.g.append("svg:g");
		g.attr("class").string("layer");
		_resize();
	}

	public function addClass(name : String)
	{
		name.split(" ").each(function(d, i) g.classed().add(d));
	}

	public function removeClass(name : String)
	{
		g.classed().remove(name);
	}

	public function toggleClass(name : String)
	{
		g.classed().toggle(name);
	}

	function _resize()
	{
		width = frame.width;
		height = frame.height;
		resize();
	}

	function resize() { }

	public function destroy()
	{
		var p : SvgPanelFriend = panel;
		p.removeLayer(this);
		g.remove();
	}

	function set_customClass(v : String)
	{
		if (null != customClass)
			g.classed().remove(customClass);
		g.classed().add(v);
		return this.customClass = v;
	}
}

typedef SvgPanelFriend = {
	private function addLayer(layer : Layer) : Void;
	private function removeLayer(layer : Layer) : Void;
}