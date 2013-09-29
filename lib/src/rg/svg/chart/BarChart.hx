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

import rg.axis.ScaleDistribution;
import rg.util.RGColors;
import dhx.Selection;
import rg.util.DataPoints;
import dhx.Access;
import rg.svg.panel.Panel;
import rg.util.DataPoints;
import rg.axis.IAxisDiscrete;
import dhx.Dom;
import thx.color.Hsl;
import thx.color.Colors;
import rg.util.RGColors;
import rg.axis.Stats;
import rg.data.VariableIndependent;
import rg.data.VariableDependent;
import rg.data.Variable;
import rg.axis.IAxis;
import rg.svg.util.PointLabel;
using Arrays;

class BarChart extends CartesianChart<{ data : Array<Array<Array<Dynamic>>>, segments : Null<Array<String>> }>
{
	public var stacked : Bool;

	var chart : Selection;
	var defs : Selection;
	var dps : Array<Array<Array<Dynamic>>>;
	public var gradientLightness : Float;
	public var displayGradient : Bool;
	public var padding : Float;
	public var paddingAxis : Float;
	public var paddingDataPoint : Float;
	public var horizontal : Bool;
	public var startat : Null<String>;
	public var segmentProperty : Null<String>;
	public var barClass : Dynamic -> Stats<Dynamic> -> String;

	public function new(panel : Panel)
	{
		super(panel);

		addClass("bar-chart");
		defs = g.append("svg:defs");
		chart = g.append("svg:g");
		gradientLightness = 2;
		displayGradient = true;
		padding = 10;
		paddingAxis = 4;
		paddingDataPoint = 2;
		horizontal = false;
		startat = null;
		segmentProperty = null;
	}

	override function setVariables(variables : Array<Variable<Dynamic, IAxis<Dynamic>>>, variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, result : { data : Array<Array<Array<Dynamic>>>, segments : Null<Array<String>> })
	{
		if(horizontal)
		{
			this.xVariable  = cast variableDependents[0];
			this.yVariables = cast variableIndependents;
		} else {
			this.xVariable  = cast variableIndependents[0];
			this.yVariables = cast variableDependents;
		}
		if (visuallyStacked())
		{
			for (v in variableDependents)
				v.meta.max = Math.NEGATIVE_INFINITY;

			// datapoints
			var data = result.data;
			for (i in 0...data.length)
			{
				// y axis
				for (j in 0...data[i].length)
				{
					var v = variableDependents[j],
						t = 0.0;
					// segment
					for (k in 0...data[i][j].length)
					{
						t += DataPoints.valueAlt(data[i][j][k], v.type, 0.0);
					}
					if (v.meta.max < t)
						v.meta.max = t;
				}
			}
		}
	}

	function visuallyStacked() return stacked && startat == null;


	override function data(result : { data : Array<Array<Array<Dynamic>>>, segments : Null<Array<String>> })
	{
		if(horizontal)
			datah(result.data, result.segments);
		else
			datav(result.data, result.segments);
	}

	function datah(dps : Array<Array<Array<Dynamic>>>, segments : Null<Array<String>>)
	{

		var axisgs = new Map (),
			span = (height - (padding * (dps.length - 1))) / dps.length;

		function getGroup(name : String, container : Selection)
		{
			var gr = axisgs.get(name);
			if (null == gr)
			{
				gr = container.append("svg:g").attr("class").string(name);
				axisgs.set(name, gr);
			}
			return gr;
		}

		// dependent values
		for (i in 0...dps.length)
		{
			var valuedps = dps[i],
				dist = (span - (paddingAxis * (valuedps.length - 1))) / valuedps.length;

			// axis values
			for (j in 0...valuedps.length)
			{
				var axisdps = valuedps[j],
					axisg   = getGroup("group-" + j, chart),
					xtype   = xVariable.type,
					xaxis   = xVariable.axis,
					xmin    = xVariable.min(),
					xmax    = xVariable.max(),
					ytype   = yVariables[j].type,
					yaxis   = yVariables[j].axis,
					ymin    = yVariables[j].min(),
					ymax    = yVariables[j].max(),
					pad     = Math.max(1, (dist - (paddingDataPoint * (axisdps.length - 1))) / axisdps.length),
					offset  = - span / 2 + j * (dist + paddingAxis),
					stats   = xVariable.stats,
					over    = onmouseover.bind(stats),
					click   = onclick.bind(stats)
				;

				var prev = 0.0;
				// segment values, datapoints
				for (k in 0...axisdps.length)
				{
					var dp = axisdps[k],
						seggroup = getGroup("fill-" + (segmentProperty == null ? k : Arrays.indexOf(segments, DataPoints.value(dp, segmentProperty))), axisg),
						x = startat == null ? prev : xaxis.scale(xmin, xmax, DataPoints.value(dp, startat)) * width,
						y = Math.max(height * yaxis.scale(ymin, ymax, DataPoints.value(dp, ytype)), 1),
						w = xaxis.scale(xmin, xmax, DataPoints.value(dp, xtype)) * width - (
								startat == null
									? 0
									: x
							);
					if(Math.isNaN(x)) continue;
					if(w < 0) {
						x -= w;
						w = -w;
					} else if(Math.isNaN(w))
						w = 0;
					var bar = seggroup.append("svg:rect")
						.attr("class").string("bar")
						.attr("x").float(x)
						.attr("y").float(height - (stacked ? y - offset : y - offset - k * (pad + paddingDataPoint)))
						.attr("height").float(stacked ? dist : pad)
						.attr("width").float(w)
						.onNode("mouseover", over)
						.onNode("click", click.bind(dp))
					;
					Access.setData(bar.node(), dp);
					if(null != barClass)
					{
						var cls = barClass(dp, stats);
						if(null != cls)
							bar.classed().add(cls);
					}

					RGColors.storeColorForSelection(bar);
					if(displayGradient)
						bar.eachNode(applyGradient);
					if(visuallyStacked())
						prev = x + w;
				}
			}
		}
		ready.dispatch();
	}

	function datav(dps : Array<Array<Array<Dynamic>>>, segments : Null<Array<String>>)
	{
		var axisgs = new Map (),
			span = (width - (padding * (dps.length - 1))) / dps.length;

		function getGroup(name : String, container : Selection)
		{
			var gr = axisgs.get(name);
			if (null == gr)
			{
				gr = container.append("svg:g").attr("class").string(name);
				axisgs.set(name, gr);
			}
			return gr;
		}

		var label_group = null != labelDataPoint ? g.append("svg:g").attr("class").string("datapoint-labels") : null;
		// dependent values
		for (i in 0...dps.length)
		{
			var valuedps = dps[i],
				dist = (span - (paddingAxis * (valuedps.length - 1))) / valuedps.length;
			// axis values
			for (j in 0...valuedps.length)
			{
				var axisdps = valuedps[j],
					axisg = getGroup("group-" + j, chart),
					xtype = xVariable.type,
					xaxis = xVariable.axis,
					xmin  = xVariable.min(),
					xmax  = xVariable.max(),
					ytype = yVariables[j].type,
					yaxis = yVariables[j].axis,
					ymin  = yVariables[j].min(),
					ymax  = yVariables[j].max(),
					pad   = Math.max(1, (dist - (paddingDataPoint * (axisdps.length - 1))) / axisdps.length),
					offset = - span / 2 + j * (dist + paddingAxis),
					stats = yVariables[j].stats,
					over = onmouseover.bind(stats),
					click = onclick.bind(stats)
				;

				var prev = 0.0;
				// segment values, datapoints
				for (k in 0...axisdps.length)
				{
					var dp = axisdps[k],
						seggroup = getGroup("fill-" + (segmentProperty == null ? k : Arrays.indexOf(segments, DataPoints.value(dp, segmentProperty))), axisg),
						x = width * xaxis.scale(xmin, xmax, DataPoints.value(dp, xtype)),
						y = startat == null ? prev : yaxis.scale(ymin, ymax, DataPoints.value(dp, startat)) * height,
						h = yaxis.scale(ymin, ymax, DataPoints.value(dp, ytype)) * height - (
								startat == null
									? 0
									: y
							);
					if(Math.isNaN(y)) continue;
					if(h < 0) {
						y += h;
						h = -h;
					} else if(Math.isNaN(h))
						h = 0;
					var w = Math.max(stacked ? dist : pad, 1),
						ax = stacked ? x + offset : x + offset + k * (pad + paddingDataPoint),
						ay = height - h - y,
						bar = seggroup.append("svg:rect")
						.attr("class").string("bar")
						.attr("x").float(ax)
						.attr("width").float(w)
						.attr("y").float(ay)
						.attr("height").float(h)
						.onNode("mouseover", over)
						.onNode("click", click.bind(dp))
					;
					Access.setData(bar.node(), dp);

					if(null != barClass)
					{
						var cls = barClass(dp, stats);
						if(null != cls)
							bar.classed().add(cls);
					}

					RGColors.storeColorForSelection(bar);
					if(displayGradient)
						bar.eachNode(applyGradient);
					if(visuallyStacked())
						prev = y + h;

					if(null != labelDataPoint)
					{
						PointLabel.label(
							label_group,
							labelDataPoint(dp, stats),
							(stacked ? x + offset : x + offset + k * (pad + paddingDataPoint)) + w / 2,
							height - h - y - labelDataPointVerticalOffset,
							labelDataPointShadow,
							labelDataPointOutline
						);
					}
				}
			}
		}
		ready.dispatch();
	}

	function onclick(stats : Stats<Dynamic>, dp : Dynamic, _, i : Int)
	{
		click(dp, stats);
	}

	function onmouseover(stats : Stats<Dynamic>, n : js.html.Element, i : Int)
	{
		var dp = Access.getData(n),
			text = labelDataPointOver(dp, stats);
		if (null == text)
			tooltip.hide();
		else
		{
			var sel = dhx.Dom.selectNode(n),
				x = sel.attr("x").getFloat(),
				y = sel.attr("y").getFloat(),
				w = sel.attr("width").getFloat();

			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(x + w / 2, y, RGColors.extractColor(n));
		}
	}

	function applyGradient(n, i : Int)
	{
		var ng = Dom.selectNodeData(n),
			dp = Access.getData(n),
			scolor = ng.style("fill").get(),
			color = RGColors.parse(scolor, "#ccc"),
			id = "rg_bar_gradient_" + color.hex("");
		if (defs.select('#'+id).empty())
		{
			var scolor = RGColors.applyLightness(Hsl.toHsl(color), gradientLightness).toRgbString();

			var gradient = defs
				.append("svg:linearGradient")
				.attr("gradientUnits").string("objectBoundingBox")
				.attr("id").string(id)
				.attr("x1").float(0)
				.attr("x2").float(0)
				.attr("y1").float(1)
				.attr("y2").float(0)
				.attr("spreadMethod").string("pad")
			;
			gradient.append("svg:stop")
				.attr("offset").float(0)
				.attr("stop-color").string(scolor)
				.attr("stop-opacity").float(1);
			gradient.append("svg:stop")
				.attr("offset").float(1)
				.attr("stop-color").string(color.toRgbString())
				.attr("stop-opacity").float(1);
		}
		ng.attr("style").string("fill:url(#" + id + ")");
	}
}