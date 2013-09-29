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

package rg.svg.layer;
import rg.axis.IAxis;
import rg.layout.Anchor;
import rg.svg.panel.Layer;
import rg.svg.panel.Panel;
import rg.axis.ITickmark;
import dhx.Dom;
import rg.svg.widget.Label;
import rg.svg.widget.LabelOrientation;
import rg.svg.widget.GridAnchor;
using Arrays;

class TickmarksOrtho extends Layer
{
	public var anchor(default, null) : Anchor;

	public var displayMinor : Bool;
	public var displayMajor : Bool;
	public var displayLabel : Bool;
	public var displayAnchorLine : Bool;
	public var lengthMinor : Float;
	public var lengthMajor : Float;
	public var paddingMinor : Float;
	public var paddingMajor : Float;
	public var paddingLabel : Float;
	public var labelOrientation : LabelOrientation;
	public var labelAnchor : GridAnchor;
	public var labelAngle : Float;
	public var desiredSize(default, null) : Float;
	public var tickLabel : Dynamic -> String;

	var translate : ITickmark<Dynamic> -> Int -> String;
	var x1 : ITickmark<Dynamic> -> Int -> Float;
	var y1 : ITickmark<Dynamic> -> Int -> Float;
	var x2 : ITickmark<Dynamic> -> Int -> Float;
	var y2 : ITickmark<Dynamic> -> Int -> Float;
	var x : ITickmark<Dynamic> -> Int -> Float;
	var y : ITickmark<Dynamic> -> Int -> Float;

	public function new(panel : Panel, anchor : Anchor)
	{
		super(panel);
		this.anchor = anchor;

		displayMinor = true;
		displayMajor = true;
		displayLabel = true;
		displayAnchorLine = false;
		lengthMinor = 2;
		lengthMajor = 5;
		paddingMinor = 1;
		paddingMajor = 1;
		paddingLabel = 10;

		g.classed().add("tickmarks");
	}

	var axis : IAxis<Dynamic>;
	var min : Dynamic;
	var max : Dynamic;

	override function resize()
	{
		if (null == axis)
			return;
		if (displayAnchorLine)
			updateAnchorLine();
		redraw();
	}

	public function update(axis : IAxis<Dynamic>, min : Dynamic, max : Dynamic)
	{
//		if(this.axis == axis && this.min == min && this.max == max)
//			return;
		this.axis = axis;
		this.min  = min;
		this.max  = max;
		redraw();
	}

	function updateAnchorLine()
	{
		var line = g.select("line.anchor-line");
		switch(anchor)
		{
			case Top:
				line.attr("x1").float(0)
					.attr("y1").float(0)
					.attr("x2").float(panel.frame.width)
					.attr("y2").float(0);
			case Bottom:
				line.attr("x1").float(0)
					.attr("y1").float(panel.frame.height)
					.attr("x2").float(panel.frame.width)
					.attr("y2").float(panel.frame.height);
			case Left:
				line.attr("x1").float(0)
					.attr("y1").float(0)
					.attr("x2").float(0)
					.attr("y2").float(panel.frame.height);
			case Right:
				line.attr("x1").float(panel.frame.width)
					.attr("y1").float(0)
					.attr("x2").float(panel.frame.width)
					.attr("y2").float(panel.frame.height);
		}
	}

	function maxTicks()
	{
		var size = switch(anchor)
		{
			case Left, Right: height;
			case Top, Bottom: width;
		}
		return Math.round(size / 2.5);
	}

	function id(d : ITickmark<Dynamic>, i) return "" + d.value;

	function redraw()
	{
		desiredSize = Math.max(paddingMinor + lengthMinor, paddingMajor + lengthMajor);

		var ticks = maxTicks(),
			data = axis.ticks(min, max, ticks);
		// ticks
		var tick = g.selectAll("g.tick").data(data, id);
		var enter = tick.enter()
			.append("svg:g").attr("class").string("tick")
			.attr("transform").stringf(translate);

		if (displayMinor)
		{
			enter.filter(function(d, i) return !d.major)
				.append("svg:line")
					.attr("x1").floatf(x1)
					.attr("y1").floatf(y1)
					.attr("x2").floatf(x2)
					.attr("y2").floatf(y2)
					.attr("class").stringf(tickClass);
		}

		if (displayMajor)
		{
			enter.filter(function(d, i) return d.major)
				.append("svg:line")
					.attr("x1").floatf(x1)
					.attr("y1").floatf(y1)
					.attr("x2").floatf(x2)
					.attr("y2").floatf(y2)
					.attr("class").stringf(tickClass);
		}

		/*
		if (displayMinor || displayMajor)
		{
			enter
				.append("svg:line")
					.attr("x1").floatf(x1)
					.attr("y1").floatf(y1)
					.attr("x2").floatf(x2)
					.attr("y2").floatf(y2)
					.attr("class").stringf(tickClass);
		}
		*/
		if(displayLabel)
			enter.eachNode(createLabel);

		tick.update()
			.attr("transform").stringf(translate);

		tick.exit()
			.remove();
	}

	function createLabel(n, i)
	{
		var d : ITickmark<Dynamic> = dhx.Access.getData(n);
		if (!d.major)
			return;
		var label = new Label(Dom.selectNode(n), false, false, false);
		label.anchor = labelAnchor;
		label.orientation = labelOrientation;
		var padding = paddingLabel;
		label.text = null == tickLabel ? d.label : tickLabel(d.value);
		switch(anchor)
		{
			case Top:
				label.place(0, padding, labelAngle);
			case Bottom:
				label.place(0, -padding, labelAngle);
			case Left:
				label.place(padding, 0, labelAngle);
			case Right:
				label.place(-padding, 0, labelAngle);
		}

		var s = switch(anchor)
		{
			case Top, Bottom:
				label.getSize().height + padding;
			case Left, Right:
				label.getSize().width + padding;
		};
		if (s > desiredSize)
			desiredSize = s;
	}

	function initf()
	{
		switch(anchor)
		{
			case Top:
				translate = translateTop;
				x1 = x1Top;
				y1 = y1Top;
				x2 = x2Top;
				y2 = y2Top;
			case Bottom:
				translate = translateBottom;
				x1 = x1Bottom;
				y1 = y1Bottom;
				x2 = x2Bottom;
				y2 = y2Bottom;
			case Left:
				translate = translateLeft;
				x1 = x1Left;
				y1 = y1Left;
				x2 = x2Left;
				y2 = y2Left;
			case Right:
				translate = translateRight;
				x1 = x1Right;
				y1 = y1Right;
				x2 = x2Right;
				y2 = y2Right;
		}
		if (null == labelOrientation)
		{
			switch(anchor)
			{
				case Top, Bottom:
					labelOrientation = LabelOrientation.Orthogonal;
				case Left, Right:
					labelOrientation = LabelOrientation.Aligned;
			}
		} else if(null == labelAnchor)
		{
			switch(labelOrientation)
			{
				case Aligned:
					switch(anchor)
					{
						case Top, Left:
							labelAnchor = GridAnchor.Left;
						case Bottom, Right:
							labelAnchor = GridAnchor.Right;
					}
				case Orthogonal:
					switch(anchor)
					{
						case Top, Left:
							labelAnchor = GridAnchor.Top;
						case Bottom, Right:
							labelAnchor = GridAnchor.Bottom;
					}
				case FixedAngle(_):
			}
		}

		if (null == labelAnchor)
		{
			switch(anchor)
			{
				case Top:
					labelAnchor = GridAnchor.Top;
				case Bottom:
					labelAnchor = GridAnchor.Bottom;
				case Left:
					labelAnchor = GridAnchor.Left;
				case Right:
					labelAnchor = GridAnchor.Right;
			}
		}
		if (null == labelAngle)
		{
			switch(anchor)
			{
				case Top:
					labelAngle = 90;
				case Bottom:
					labelAngle = 90;
				case Left:
					labelAngle = 0;
				case Right:
					labelAngle = 0;
			}
		}
	}

	public function init()
	{
		initf();
		if (displayAnchorLine)
		{
			g.append("svg:line").attr("class").string("anchor-line");
			updateAnchorLine();
		}
	}

	inline function t(x : Float, y : Float) return "translate(" + x + "," + y + ")";

	function translateTop(d : ITickmark<Dynamic>, i : Int)		return t(d.delta * panel.frame.width, 0);
	function translateBottom(d : ITickmark<Dynamic>, i : Int)	return t(d.delta * panel.frame.width, panel.frame.height);
	function translateLeft(d : ITickmark<Dynamic>, i : Int)		return t(0, panel.frame.height - d.delta * panel.frame.height);
	function translateRight(d : ITickmark<Dynamic>, i : Int)	return t(panel.frame.width, panel.frame.height - d.delta * panel.frame.height);

	function x1Top(d : ITickmark<Dynamic>, i : Int)		return 0;
	function x1Bottom(d : ITickmark<Dynamic>, i : Int)	return 0;
	function x1Left(d : ITickmark<Dynamic>, i : Int)	return d.major ? paddingMajor : paddingMinor;
	function x1Right(d : ITickmark<Dynamic>, i : Int)	return -(d.major ? paddingMajor : paddingMinor);
	function y1Top(d : ITickmark<Dynamic>, i : Int)		return d.major ? paddingMajor : paddingMinor;
	function y1Bottom(d : ITickmark<Dynamic>, i : Int)	return -(d.major ? paddingMajor : paddingMinor);
	function y1Left(d : ITickmark<Dynamic>, i : Int)	return 0;
	function y1Right(d : ITickmark<Dynamic>, i : Int)	return 0;

	function x2Top(d : ITickmark<Dynamic>, i : Int)		return 0;
	function x2Bottom(d : ITickmark<Dynamic>, i : Int)	return 0;
	function x2Left(d : ITickmark<Dynamic>, i : Int)	return d.major ? lengthMajor + paddingMajor : lengthMinor + paddingMinor;
	function x2Right(d : ITickmark<Dynamic>, i : Int)	return -(d.major ? lengthMajor + paddingMajor : lengthMinor + paddingMinor);

	function y2Top(d : ITickmark<Dynamic>, i : Int)		return d.major ? lengthMajor + paddingMajor : lengthMinor + paddingMinor;
	function y2Bottom(d : ITickmark<Dynamic>, i : Int)	return -(d.major ? lengthMajor + paddingMajor : lengthMinor + paddingMinor);
	function y2Left(d : ITickmark<Dynamic>, i : Int)	return 0;
	function y2Right(d : ITickmark<Dynamic>, i : Int)	return 0;

	function tickClass(d : ITickmark<Dynamic>, i : Int)	return d.major ? "major" : null;
}