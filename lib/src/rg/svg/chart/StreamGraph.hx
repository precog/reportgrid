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
import rg.util.DataPoints;
import rg.svg.panel.Panel;
import rg.svg.widget.Balloon;
import thx.svg.LineInterpolator;
import thx.geom.layout.Stack;
import rg.data.VariableIndependent;
import rg.data.VariableDependent;
import rg.data.Variable;
import rg.axis.IAxis;
import thx.svg.Area;
import dhx.Dom;
import dhx.Selection;
import thx.color.Hsl;
import thx.color.Rgb;
import dhx.Svg;
import dhx.Access;
import rg.util.RGColors;
import js.html.Element;
using Arrays;


class StreamGraph extends CartesianChart<Array<Array<Dynamic>>>
{
	public function new(panel : Panel)
	{
		super(panel);
		interpolator = LineInterpolator.Cardinal(0.6);
		gradientLightness = 0.75;
		gradientStyle = 1;
	}

	public var interpolator : LineInterpolator;
	public var gradientLightness : Float;
	public var gradientStyle : Int; // 0: none, 1: vertical, 2: horizontal

	var dps : Array<Array<Dynamic>>;
	var area : Area<TransformedData>;
	var transformedData : Array<Array<TransformedData>>;
	var stats : Stats<Dynamic>;
	var defs : Selection;
	var maxy : Float;

	override function init()
	{
		super.init();
		defs = g.append("svg:defs");
		g.classed().add("stream-chart");
	}

	override function setVariables(variables : Array<Variable<Dynamic, IAxis<Dynamic>>>, variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, data : Array<Array<Dynamic>>)
	{
		super.setVariables(variables, variableIndependents, variableDependents, data);
	}

	override public function data(dps : Array<Array<Dynamic>>)
	{
		this.dps = dps;
		prepareData();
		redraw();
	}

	function redraw()
	{
		if (null == transformedData)
			return;

		// LAYER
		var layer = g.selectAll("g.group").data(transformedData);

		// update
		layer.update()
//			.attr("transform").string("translate(0,0)")
			.select("path.line").attr("d").stringf(area.shape);

		// enter
		var g = layer.enter()
			.append("svg:g")
			.attr("class").string("group");
//			.attr("transform").string("translate(0,0)");
//			.onNode("mouseout", out);
		var path = g.append("svg:path")
				.attr("class").stringf(function(d, i) return "line fill-" + i + " stroke-" + i)
				.attr("d").stringf(area.shape)
				.onNode("mousemove", onover)
				.onNode("click", onclick)
				;
		RGColors.storeColorForSelection(cast path);
		if(gradientStyle != 0)
			path.each(gradientStyle == 1 ? applyGradientV : applyGradientH);
		// exit
		layer.exit().remove();
		ready.dispatch();
	}

	function getDataAtNode(n : Element, i)
	{
		var px = Svg.mouse(n)[0],
			x = Floats.uninterpolatef(transformedData[i].first().coord.x, transformedData[i].last().coord.x)(px / width);

		var data : Array<TransformedData> = Access.getData(cast n);

		return Arrays.nearest(transformedData[i], x, function(d) return d.coord.x);
	}

	function onover(n : Element, i)
	{
		if (null == labelDataPointOver)
			return;
		var dp = getDataAtNode(n, i);
		tooltip.html(labelDataPointOver(dp.dp, stats).split("\n").join("<br>"));
//		tooltip.show();
		moveTooltip(dp.coord.x * width, height - (dp.coord.y + dp.coord.y0) * height / maxy, RGColors.extractColor(cast n));
	}

	function onclick(n : Element, i)
	{
		if (null == this.click)
			return;
		var dp = getDataAtNode(n, i);
		click(dp.dp, stats);
	}

	function prepareData()
	{
		defs.selectAll("linearGradient.h").remove();
		var xscale = xVariable.axis.scale.bind(xVariable.min(), xVariable.max()),
			xtype = xVariable.type,
			x = function(d) return xscale(DataPoints.value(d, xtype)),
			yscale = yVariables[0].axis.scale.bind(yVariables[0].min(), yVariables[0].max()),
			ytype = yVariables[0].type,
			y = function(d) return yscale(DataPoints.value(d, ytype)),
			m = Std.int(dps.floatMax(function(d) return d.length));

		function altDp(pos : Int)
		{
			for(i in 0...dps.length)
				if(null != dps[i][pos])
					return dps[i][pos];
			return null;
		}

		var coords = Arrays.map(dps, function(d : Array<Dynamic>, j) {
			return Arrays.map(Ints.range(0, m), function(_, i) {
				var dp = d[i];
				if(null == dp)
					return { x : x(altDp(i)), y : .0 };
				return {
					x : x(dp),
					y : Math.max(0, y(dp))
				};
			});
		});

		var data = new Stack()
			.offset(StackOffset.Silhouette)
			.order(StackOrder.DefaultOrder)
			.stack(coords);

		transformedData = Arrays.map(data, function(d, i) return Arrays.map(d, function(d, j) {
			return {
				coord : d,
				dp : dps[i][j]
			}
		}));

		stats = yVariables[0].stats;

		maxy = data.floatMax(function(d) return d.floatMax(function(d) return d.y0 + d.y));

		area = new Area<TransformedData>()
			.interpolator(interpolator)
			.x(function(d, i) return d.coord.x * width)
			.y0(function(d, i) return height - d.coord.y0 * height / maxy)
			.y1(function(d, i) return height - (d.coord.y + d.coord.y0) * height / maxy)
		;
	}

	function applyGradientV(d : Array<TransformedData>, i : Int)
	{
		var gn = Selection.current,
			color = RGColors.parse(gn.style("fill").get(), "#cccccc"),
			id = "rg_stream_gradient_h_" + color.hex("");
		if (defs.select('#'+id).empty())
		{

			var scolor = RGColors.applyLightness(Hsl.toHsl(color), gradientLightness).toRgbString();

			var gradient = defs
				.append("svg:linearGradient")
				.attr("gradientUnits").string("objectBoundingBox")
				.attr("id").string(id)
				.attr("x1").string("0%")
				.attr("x2").string("0%")
				.attr("y1").string("100%")
				.attr("y2").string("0%")
				.attr("spreadMethod").string("pad")
			;
			gradient.append("svg:stop")
				.attr("offset").string("0%")
				.attr("stop-color").string(scolor)
				.attr("stop-opacity").float(1);
			gradient.append("svg:stop")
				.attr("offset").string("100%")
				.attr("stop-color").string(color.toRgbString())
				.attr("stop-opacity").float(1);
		}
		gn.attr("style").string("fill:url(#" + id + ")");
	}

	static var vid = 0;
	function applyGradientH(d : Array<TransformedData>, i : Int)
	{
		var gn = Selection.current,
			color = Hsl.toHsl(RGColors.parse(gn.style("fill").get(), "#cccccc")),
			id = "rg_stream_gradient_v_" + vid++;

		var gradient = defs
			.append("svg:linearGradient")
			.attr("gradientUnits").string("objectBoundingBox")
			.attr("class").string("x")
			.attr("id").string(id)
			.attr("x1").string("0%")
			.attr("x2").string("100%")
			.attr("y1").string("0%")
			.attr("y2").string("0%")
	//		.attr("spreadMethod").string("pad")
		;

		var bx = d.first().coord.x,
			ax = d.last().coord.x,
			span = ax - bx,
			percent = function(x : Float) {
				return Math.round((x - bx) / span * 10000) / 100;
			},
			max = d.floatMax(function(d) return d.coord.y);

//		var lastv = 0.0, tollerance = 0.25;
		for (i in 0...d.length)
		{
			var dp = d[i],
				v = dp.coord.y / max;
			var gcolor = RGColors.applyLightness(color, gradientLightness, v);
			gradient.append("svg:stop")
				.attr("offset").string(percent(dp.coord.x) +  "%")
				.attr("stop-color").string(gcolor.toCss())
				.attr("stop-opacity").float(1);
//			lastv = v;
		}
/*
		gradient.append("svg:stop")
			.attr("offset").string("0%")
			.attr("stop-color").string(scolor)
			.attr("stop-opacity").float(1);
		gradient.append("svg:stop")
			.attr("offset").string("100%")
			.attr("stop-color").string(color.toRgbString())
			.attr("stop-opacity").float(1);
*/
		gn.attr("style").string("fill:url(#" + id + ")");
	}
}

typedef XYY0 = {
	x : Float,
	y : Float,
	y0 : Float
}

typedef TransformedData = { coord : XYY0, dp : Dynamic }