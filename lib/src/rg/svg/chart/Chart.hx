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

package rg.svg.chart;
import rg.svg.panel.Panel;
import rg.svg.panel.Layer;
import rg.axis.Stats;
import rg.html.widget.Tooltip;
import thx.math.Equations;
import rg.svg.panel.Panels;
import hxevents.Notifier;

class Chart extends Layer
{
	public var animated : Bool;
	public var animationDuration : Int;
	public var animationEase : Float -> Float;
	public var click : Dynamic -> Stats<Dynamic> -> Void;
	public var labelDataPoint : Dynamic -> Stats<Dynamic> -> String;
	public var labelDataPointOver : Dynamic -> Stats<Dynamic> -> String;
	public var ready(default, null) : Notifier;

	var panelx : Float;
	var panely : Float;
	var tooltip : Tooltip;

	public function new(panel : Panel)
	{
		super(panel);
		animated = true;
		animationDuration = 1500;
		animationEase = Equations.linear;
		ready = new Notifier();
	}

	override function resize()
	{
		var coords = Panels.absolutePos(panel);
		panelx = coords.x;
		panely = coords.y;
	}

	public function init()
	{
		if (null != labelDataPointOver)
		{
			tooltip = Tooltip.instance;
		}
		resize();
	}

	function moveTooltip(x : Float, y : Float, color : Null<String>)
	{
		var coords = Panels.absolutePos(panel);
		panelx = coords.x;
		panely = coords.y;
		tooltip.setAnchorColor(color);
		tooltip.showAt(Std.int(panelx + x), Std.int(panely + y));
	}
}