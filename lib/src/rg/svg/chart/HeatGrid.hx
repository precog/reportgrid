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
import rg.axis.Stats;
import rg.data.VariableDependent;
import rg.data.Variable;
import rg.axis.IAxis;
import rg.svg.panel.Panel;
import rg.util.RGColors;
import thx.color.Rgb;
import thx.color.Colors;
import thx.geom.Contour;
import dhx.Access;
import dhx.Selection;
import rg.data.VariableIndependent;
import rg.axis.IAxis;
import thx.math.scale.Linears;
import thx.math.scale.LinearT;
import thx.color.Hsl;
import thx.color.NamedColors;
import rg.util.DataPoints;
import thx.svg.Line;
import thx.svg.LineInterpolator;
import rg.svg.chart.ColorScaleMode;
import rg.svg.util.RGCss;
import rg.svg.util.PointLabel;
using Arrays;

class HeatGrid extends CartesianChart<Array<Dynamic>>
{
	public var useContour : Bool;
	@:isVar public var colorMode(get, set) : ColorScaleMode;
	var dps : Array<Dynamic>;
	var variableDependent : VariableDependent<Dynamic>;

	public function new(panel : Panel)
	{
		super(panel);
		useContour = false;
		colorMode = FromCss();
	}

	override function setVariables(variables : Array<Variable<Dynamic, IAxis<Dynamic>>>, variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, data : Array<Dynamic>)
	{
		xVariable = cast variableIndependents[0];
		yVariables = cast [variableIndependents[1]];
		variableDependent = variableDependents[0];
	}

	override function init()
	{
		super.init();
		g.classed().add("heat-grid");
	}

	override function resize()
	{
		super.resize();
		redraw();
	}

	override function data(dps : Array<Dynamic>)
	{
		this.dps = dps;
		redraw();
	}

	function value(dp)
	{
		var v = DataPoints.value(dp, variableDependent.type);
		return scale(v);
	}

	function scale(v)
	{
		return variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), v);
	}

	var xrange : Array<Dynamic>;
	var yrange : Array<Dynamic>;
	var cols : Int;
	var rows : Int;
	var w : Float;
	var h : Float;
	var stats : Stats<Dynamic>;

	function x(dp, i) return Arrays.indexOf(xrange, DataPoints.value(dp, xVariable.type)) * w;
	function y(dp, i) return height - (1 + Arrays.indexOf(yrange, DataPoints.value(dp, yVariables[0].type))) * h;

	function redraw()
	{
		if (null == dps || 0 == dps.length)
			return;

		stats = variableDependent.stats;
		xrange = range(cast xVariable);
		yrange = range(yVariables[0]);
		cols = xrange.length;
		rows = yrange.length;
		w = width / cols;
		h = height / rows;

		if (useContour)
			drawContour();
		else
			drawSquares();

		ready.dispatch();
	}

	function drawContour()
	{
/*
		var map = xrange.map(function(v, i) return dps.filter(function(dp) return DataPoints.value(dp, xVariable.type) == v)).map(function(arr, i) {
				var r = [];
				for (i in 0...rows)
					r.push(arr.filter(function(dp) return DataPoints.value(dp, yVariables[0].type) == yrange[i]).shift());
				return r;
			}),
			level = 0.0,
			min = scale(variableDependent.min()),
			max = scale(variableDependent.max()),
			span = max - min,
			padding;

		function grid(x : Int, y : Int) {
			var ys = map[x];
			if (null == ys)
				return false;
			var dp = ys[y];
			if (null == dp)
				return false;
			var v = value(dp);
			return v >= level;
		};

		for (i in 0...levels)
		{
			var color = colorScale.scale(level);
			padding = 0; // i * h / (levels + 1);
			level = min + (span / levels) * i;

			var map = createGridMap(grid);

			function createContour(?start)
			{
				var contour = Contour.contour(grid, start).map(function(d, i) {
					map.remove(d[1] + "-" + d[0]);
					return [padding + d[0] * w, padding + height - d[1] * h];
				});
				if (contour.length > 0)
					contour.push(contour[0]);

				var line = Line.pointArray(LineInterpolator.Linear).shape(contour);
				var path = g.append("svg:path")
					.attr("d").string(line)
//					.style("fill").color(color)
				;
				stylefeature(path, path);
			}

			createContour();
		}
*/
	}

	function createGridMap(grid)
	{
		var map = new Map ();
		for(r in 0...rows)
			for (c in 0...cols)
				if(grid(c, r))
					map.set(r + "-" + c, [r, c]);
		return map;
	}

	var currentNode : js.html.Element;
	function drawSquares()
	{
		var choice = g.selectAll("rect").data(dps);
		var rect = choice.enter().append("svg:rect")
			.attr("x").floatf(x)
			.attr("y").floatf(y)
			.attr("width").float(w)
			.attr("height").float(h)
			.each(function(dp, _) {
				stylefeature(Selection.current, dp);
			})
			.on("click", onclick)
			.onNode("mouseover", function(n, i) {
				currentNode = n;
				onmouseover(Access.getData(n), i);
			})
		;
		if(null != labelDataPoint)
		{
			var label_group = g.append("svg:g").attr("class").string("datapoint-labels");
			 g.selectAll("rect").data(dps).eachNode(function(n, i) {
				var dp = Access.getData(n);
				PointLabel.label(
					label_group,
					labelDataPoint(dp, stats),
					x(dp, i) + w / 2,
					y(dp, i) - labelDataPointVerticalOffset + h / 2,
					labelDataPointShadow,
					labelDataPointOutline
				);
			});
		}
		RGColors.storeColorForSelection(cast rect);
	}

	function onmouseover(dp : Dynamic, i : Int)
	{
		if (null == labelDataPointOver)
			return;
		var text = labelDataPointOver(dp, stats);
		if (null == text)
			tooltip.hide();
		else {
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(x(dp, i) + w / 2, y(dp, i) + h / 2, RGColors.extractColor(currentNode));
		}
	}

	function onclick(dp : Dynamic, i : Int)
	{
		if (null == click)
			return;
		click(dp, stats);
	}

	function range(variable : rg.data.Variable<Dynamic, IAxis<Dynamic>>) : Array<Dynamic>
	{
		var v : VariableIndependent<Dynamic> = Types.as(variable, VariableIndependent);
		if (null != v)
			return v.axis.range(v.min(), v.max());
		var tickmarks = variable.axis.ticks(variable.min(), variable.max());
		return tickmarks.map(function(d) return d.value);
	}

	dynamic function stylefeature(svg : Selection, dp : Dynamic) {}

	function get_colorMode() return colorMode;
	function set_colorMode(v : ColorScaleMode)
	{
		switch(colorMode = v)
		{
			case FromCssInterpolation(g):
				if (null == g)
					g = 1;
				var colors = RGCss.colorsInCss();
				if (colors.length > g)
				{
					colors = colors.slice(0, g);
				}
				if (colors.length == 1) {
					colors.push(Hsl.lighter(Hsl.toHsl(Colors.parse(colors[0])), 0.9).toCss());
				}
				colors.reverse();
				set_colorMode(Interpolation(colors.map(function(s) return Colors.parse(s))));
			case FromCss(g):
				if (null == g)
					g = RGCss.numberOfColorsInCss();
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					var t = variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), DataPoints.value(dp, variableDependent.type)),
						index = Math.floor(g * t);
					svg.attr("class").string("fill-" + index);
				}
			case Sequence(c):
				var colors = Arrays.map(c, function(d, _) return d.toCss());
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					var t = variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), DataPoints.value(dp, variableDependent.type)),
						index = Math.floor(colors.length * t);
					svg.style("fill").string(colors[index]);
				}
			case Interpolation(colors):
				var interpolator = Rgb.interpolateStepsf(colors);
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					var t = variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), DataPoints.value(dp, variableDependent.type));
					svg.style("fill").string(interpolator(t).toCss());
				}
			case Fixed(c):
				var color = c.toCss();
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					svg.style("fill").string(color);
				}
			case Fun(f):
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					svg.style("fill").string(f(dp, variableDependent.stats));
				}
		}
		return v;
	}
}