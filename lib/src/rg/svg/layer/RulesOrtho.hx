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
import rg.frame.Orientation;
using Arrays;

class RulesOrtho extends Layer
{
	public var orientation(default, null) : Orientation;

	public var displayMinor : Bool;
	public var displayMajor : Bool;
	public var displayAnchorLine : Bool;

	var translate : ITickmark<Dynamic> -> Int -> String;
	var x1 : ITickmark<Dynamic> -> Int -> Float;
	var y1 : ITickmark<Dynamic> -> Int -> Float;
	var x2 : ITickmark<Dynamic> -> Int -> Float;
	var y2 : ITickmark<Dynamic> -> Int -> Float;
	var x : ITickmark<Dynamic> -> Int -> Float;
	var y : ITickmark<Dynamic> -> Int -> Float;

	public function new(panel : Panel, orientation : Orientation)
	{
		super(panel);
		this.orientation = orientation;

		displayMinor = true;
		displayMajor = true;
		displayAnchorLine = true;

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
		this.axis = axis;
		this.min = min;
		this.max = max;
		redraw();
	}

	function updateAnchorLine()
	{
		var line = g.select("line.anchor-line");
		switch(orientation)
		{
			case Horizontal:
				line.attr("x1").float(0)
					.attr("y1").float(0)
					.attr("x2").float(0)
					.attr("y2").float(height);
			case Vertical:
				line.attr("x1").float(0)
					.attr("y1").float(height)
					.attr("x2").float(width)
					.attr("y2").float(height);
		}
	}

	function maxTicks()
	{
		var size = switch(orientation)
		{
			case Horizontal: width;
			case Vertical: height;
		}
		return Math.round(size / 2.5);
	}

	function id(d : ITickmark<Dynamic>, i) return "" + d.value;

	function redraw()
	{
		var ticks = maxTicks(),
			data = axis.ticks(min, max, ticks);

		// ticks
		var rule = g.selectAll("g.rule").data(data, id);
		var enter = rule.enter()
			.append("svg:g").attr("class").string("rule")
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
/*

			enter.filter(function(d, i) return d.major)
			.each(function(d, i) {
				g.append("svg:line")
					.attr("x1").float(x1(d,i))
					.attr("y1").float(y1(d,i))
					.attr("x2").float(x2(d,i))
					.attr("y2").float(y2(d,i))
					.style("stroke").string("black")
					.style("stroke-width").string("2")
//					.attr("class").stringf(tickClass)
				;
			});

			enter.filter(function(d, i) return d.major)
				.append("svg:path")
					.attr("d").stringf(function(d, i){
						return "M" + x1(d, i) + "," + y1(d, i) + "L" + x2(d, i) + "," + y2(d, i);
					})
					.style("stroke").string("red")
					.style("stroke-width").string("2")
				;
*/
		}

		rule.update()
			.attr("transform").stringf(translate);

		rule.exit()
			.remove();
	}

	function initf()
	{
		switch(orientation)
		{
			case Horizontal:
				translate = translateHorizontal;
				x1 = x1Horizontal;
				y1 = y1Horizontal;
				x2 = x2Horizontal;
				y2 = y2Horizontal;
			case Vertical:
				translate = translateVertical;
				x1 = x1Vertical;
				y1 = y1Vertical;
				x2 = x2Vertical;
				y2 = y2Vertical;
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

	function translateHorizontal(d : ITickmark<Dynamic>, i : Int)	return t(0, height - d.delta * height);
	function translateVertical(d : ITickmark<Dynamic>, i : Int)		return t(d.delta * width, 0);

	function x1Horizontal(d : ITickmark<Dynamic>, i : Int)	return 0;
	function x1Vertical(d : ITickmark<Dynamic>, i : Int)	return 0;
	function y1Horizontal(d : ITickmark<Dynamic>, i : Int)	return 0;
	function y1Vertical(d : ITickmark<Dynamic>, i : Int)	return 0;
	function x2Horizontal(d : ITickmark<Dynamic>, i : Int)	return width;
	function x2Vertical(d : ITickmark<Dynamic>, i : Int)	return 0;
	function y2Horizontal(d : ITickmark<Dynamic>, i : Int)	return 0;
	function y2Vertical(d : ITickmark<Dynamic>, i : Int)	return height;

	function tickClass(d : ITickmark<Dynamic>, i : Int)	return d.major ? "major" : null;
}