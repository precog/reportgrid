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
import dhx.Dom;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.data.Variable;
import rg.axis.IAxis;
import rg.svg.panel.Panel;
import rg.util.RGColors;
import thx.color.Hsl;
import dhx.Selection;
import rg.util.DataPoints;
import thx.svg.Line;
import rg.axis.Stats;
import thx.svg.LineInterpolator;
import dhx.Access;
import thx.svg.Area;
import rg.svg.util.PointLabel;
import rg.svg.widget.Sensible;
import rg.svg.util.SVGSymbolBuilder;
using Arrays;

// TODO transition animation
// TODO expose options: label.orientation
// TODO expose options: label.place (distance, angle)
// TODO expose options: label.anchor

class LineChart extends CartesianChart<Array<Array<Array<Dynamic>>>>
{
	public var symbol : Dynamic -> Stats<Dynamic> -> String;
	public var symbolStyle : Dynamic -> Stats<Dynamic> -> String;
	public var lineInterpolator : LineInterpolator;
	public var lineEffect : LineEffect;
	public var y0property : String;
	public var sensibleRadius : Int;

	var linePathShape : Array<Array<Dynamic> -> Int -> String>;
	var chart : Selection;
	var dps : Array<Array<Array<Dynamic>>>;
	var segment : Int;
	var stats : Array<Stats<Dynamic>>;


	public function new(panel : Panel)
	{
		super(panel);

		addClass("line-chart");
		chart = g.append("svg:g");
		sensibleRadius = 100;
	}

	override function setVariables(variables : Array<Variable<Dynamic, IAxis<Dynamic>>>, variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, data : Array<Array<Array<Dynamic>>>)
	{
		super.setVariables(variables, variableIndependents, variableDependents, data);
		if (y0property != null && y0property != "")
		{
			var t, dp;
			for (v in variableDependents)
				v.meta.max = Math.NEGATIVE_INFINITY;
			// y axis
			for (i in 0...data.length)
			{
				var v = variableDependents[i];
				// segment
				for (j in 0...data[i].length)
				{
					// datapoints
					for (k in 0...data[i][j].length)
					{
						dp = data[i][j][k];
						t = DataPoints.valueAlt(dp, v.type, 0.0) + DataPoints.valueAlt(dp, y0property, 0.0);
						if (v.meta.max < t)
							v.meta.max = t;
					}
				}
			}
		}
	}

	function x(d : Dynamic, ?i)
	{
		var value   = DataPoints.value(d, xVariable.type),
			scaled  = xVariable.axis.scale(xVariable.min(), xVariable.max(), value),
			scaledw = scaled * width;
		return scaledw;
	}

	function getY1(pos : Int)
	{
		var v = yVariables[pos],
			scale = v.axis.scale.bind(v.min(), v.max());
		if (null != y0property)
		{
			var min = scale(v.min()) * height;
			return function(d : Dynamic, i : Int)
			{
				return getY0(pos)(d, i) - (scale(DataPoints.value(d, v.type)) * height) + min;
			}
		} else {
			return function(d : Dynamic, i : Int)
			{
				var value   = DataPoints.value(d, v.type),
					scaled  = scale(value),
					scaledh = scaled * height;
				return height - scaledh;
			}
		}
	}

	function getY0(pos : Int)
	{
		var v = yVariables[pos],
			scale = v.axis.scale.bind(v.min(), v.max());
		return function(d : Dynamic, i : Int)
		{
			return height - (scale(DataPoints.valueAlt(d, y0property, v.min())) * height);
		}
	}

	var segments : Array<Array<Dynamic>>;

	public function classsf(pos : Int, cls : String)
	{
		return function(_, i : Int)
		{
			return cls + " stroke-" + (pos + i);
		}
	}

	public function classff(pos : Int, cls : String)
	{
		return function(_, i : Int)
		{
			return cls + " fill-" + (pos + i);
		}
	}

	override function data(dps : Array<Array<Array<Dynamic>>>)
	{
		linePathShape = [];
		for (i in 0...yVariables.length)
		{
			var line = new Line(x, getY1(i));
			if (null != lineInterpolator)
				line.interpolator(lineInterpolator);
			linePathShape[i] = function(dp, i)
			{
				segment = i;
				return line.shape(dp, i);
			};
		}

		var axisgroup = chart.selectAll("g.group").data(dps);
		// axis enter
		var axisenter = axisgroup.enter()
			.append("svg:g")
			.attr("class").stringf(function(_, i) return "group group-" + i);

		// axis exit
		axisgroup.exit().remove();
		stats = [];
		for (i in 0...dps.length)
		{
			segments = dps[i];

			var gi = chart.select("g.group-" + i)//,
			;
			stats[i] = new Stats(yVariables[i].type);
			stats[i].addMany(DataPoints.values(segments.flatten(), yVariables[i].type));


			if (null != y0property)
			{
				var area = new Area(x, getY0(i), getY1(i));
				if (null != lineInterpolator)
					area.interpolator(lineInterpolator);
				gi.selectAll("path.area")
					.data(segments)
					.enter()
						.append("svg:path")
						.attr("class").stringf(classff(i, "area area-"+i))
						.attr("d").stringf(area.shape);
			}

			// TODO add id function
			var segmentgroup = gi.selectAll("path.main").data(segments);
			switch(lineEffect)
			{
				case LineEffect.Gradient(lightness, levels):
					var fs = [];
					segmentgroup.enter()
						.append("svg:path")
						.attr("class").stringf(classsf(i, "line"))
						.eachNode(function(n, i) {
							var start = Hsl.toHsl(RGColors.parse(Dom.selectNode(n).style("stroke").get(), "#000000")),
								end = RGColors.applyLightness(start, lightness);
							fs[i] = Hsl.interpolatef(end, start);
						}).remove();

					for (j in 0...levels)
					{
						segmentgroup.enter()
							.append("svg:path")
							.attr("class").string("line grad-" + (levels-j-1))
							.style("stroke").stringf(function(_,i) {
								return fs[i](j/levels).toCss();
							})
							.attr("d").stringf(linePathShape[i]);
					}
				case LineEffect.DropShadow(ox, oy, levels):
					for (j in 0...levels)
					{
						segmentgroup.enter()
							.append("svg:path")
							.attr("transform").string("translate("+((1+j)*ox)+","+((1+j)*oy)+")")
							.attr("class").stringf(classsf(i, "line shadow shadow-" + (j)))
							.attr("d").stringf(linePathShape[i]);
					}
				default: // do nothing
			}

			var path = segmentgroup.enter()
				.append("svg:path")
				.attr("class").stringf(classsf(i, "line"))
				.attr("d").stringf(linePathShape[i]);

			switch(lineEffect)
			{
				case Gradient(_, _):
					path.classed().add("gradient");
				case DropShadow(_, _, _):
					path.classed().add("dropshadow");
				case NoEffect:
					path.classed().add("noeffect");
			}

			segmentgroup.update()
				.attr("d").stringf(linePathShape[i]);

			segmentgroup.exit().remove();

			var gsymbols = gi.selectAll("g.symbols").data(segments),
				vars = this.yVariables;
			var enter = gsymbols.enter()
				.append("svg:g")
				.attr("class").stringf(classsf(i, "symbols"));

			// TODO add id function
			var gsymbol = enter.selectAll("g.symbol").dataf(function(d,i) return d).enter()
				.append("svg:g")
				.attr("transform").stringf(getTranslatePointf(i));

			var circle = gsymbol.append("svg:circle")
				.attr("r").float(6)
				.attr("opacity").float(0.0)
				.style("fill").string("#000000")
			;
			if (null != labelDataPointOver)
				circle
					.classed().add("rgdata");
			RGColors.storeColorForSelection(cast circle, "stroke");


			SVGSymbolBuilder.generate(gsymbol, stats[i], symbol, symbolStyle);

			if(null != labelDataPoint)
			{
				var label_group = chart.append("svg:g").attr("class").string("datapoint-labels");
				gsymbol.eachNode(function(n, j) {
					var dp = Access.getData(n);
					PointLabel.label(
						label_group,
						labelDataPoint(dp, stats[i]),
						x(dp),
						getY1(i)(dp, j) - labelDataPointVerticalOffset,
						labelDataPointShadow,
						labelDataPointOutline
					);
				});
			}

			gsymbols.update()
				.selectAll("g.symbol")
				.dataf(function(d, i) return d)
				.update()
				.attr("transform").stringf(getTranslatePointf(i))
			;

			gsymbols.exit().remove();
		}
		Sensible.sensibleZone(g, panel, null == click ? null : onclick, null == labelDataPointOver ? null : onmouseover, sensibleRadius);
		ready.dispatch();
	}

	function getTranslatePointf(pos : Int)
	{
		var x = this.x,
			y = getY1(pos);
		return function(dp, i)
		{
			return "translate("+x(dp)+","+y(dp,i)+")";
		};
	}

	function getStats(dp : Dynamic)
	{
		for(s in stats)
			if(Reflect.field(dp, s.type) != null)
				return s;
		return null;
	}

	function onmouseover(n : js.html.Element)
	{
		var dp = Access.getData(n),
			stats = getStats(dp),
			text = labelDataPointOver(dp, stats);
		if (null == text)
			tooltip.hide();
		else
		{
			var sel = dhx.Dom.selectNode(cast n.parentNode),
				coords = Coords.fromTransform(sel.attr("transform").get());
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(coords[0], coords[1], RGColors.extractColor(n));
		}
	}

	function onclick(n : js.html.Element)
	{
		var dp = Access.getData(n),
			stats = getStats(dp);
		click(dp, stats);
	}
}