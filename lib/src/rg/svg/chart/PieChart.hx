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
import haxe.crypto.Md5;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.svg.widget.Balloon;
import thx.culture.FormatNumber;
import dhx.Selection;
import rg.svg.panel.Layer;
import rg.svg.panel.Panel;
import thx.geom.layout.Pie;
import dhx.Svg;
import thx.math.Const;
import thx.svg.Arc;
import dhx.Dom;
import dhx.Access;
import thx.color.Hsl;
import thx.color.Colors;
import rg.util.DataPoints;
import rg.axis.Stats;
import rg.svg.widget.LabelOrientation;
import rg.svg.widget.Label;
import rg.svg.widget.GridAnchor;
import rg.util.RGColors;
using Arrays;

// TODO add overDataPoint
// TODO improve automatic title when the axis is time
class PieChart extends Chart
{
	public var innerRadius : Float;
	public var outerRadius : Float;
	public var overRadius : Float;
	public var labelRadius : Float;
	public var tooltipRadius : Float;

	var arcNormal : Arc<{ startAngle : Float, endAngle : Float }>;
	var arcStart : Arc<{ startAngle : Float, endAngle : Float }>;
	var arcBig : Arc<{ startAngle : Float, endAngle : Float }>;
	var pie : Pie<Float>;
	var radius : Float;
	var stats : Stats<Dynamic>;
	var variableDependent : VariableDependent<Dynamic>;
	public var gradientLightness : Float;
	public var displayGradient : Bool;
	public var animationDelay : Int;

	public var labelOrientation : LabelOrientation;
	public var labelDontFlip : Bool;

	var labels : Map<String, Label>;

	public var mouseClick : Dynamic -> Void;

	public function new(panel : Panel)
	{
		super(panel);
		addClass("pie-chart");
		g.append("svg:defs");
		pie = new Pie();
		gradientLightness = 0.75;
		displayGradient = true;
		animationDelay = 0;
		innerRadius = 0.0;
		outerRadius = 0.9;
		overRadius = 0.95;
		labelRadius = 0.45;
		tooltipRadius = 0.5;
		labels = new Map ();

		labelOrientation = LabelOrientation.Orthogonal;
		labelDontFlip = true;
	}

	public function setVariables(variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>)
	{
		variableDependent = variableDependents[0];
	}

	override function resize()
	{
		super.resize();
		radius = Math.min(width, height) / 2;
		arcStart = Arc.fromAngleObject()
			.innerRadius(radius * innerRadius)
			.outerRadius(radius * innerRadius);
		arcNormal = Arc.fromAngleObject()
			.innerRadius(radius * innerRadius)
			.outerRadius(radius * outerRadius);
		arcBig = Arc.fromAngleObject()
			.innerRadius(radius * innerRadius)
			.outerRadius(radius * overRadius);

		// recenter the chart
		if (width > height)
			g.attr("transform").string("translate(" + (width/2-height/2) + ",0)");
		else
			g.attr("transform").string("translate(0," + (height/2-width/2) + ")");
	}

	public function data(dp : Array<Dynamic>)
	{
		var pv = variableDependent.type;
		// filter out dp with zero values
//		dp = dp.filter(function(dp) {
//			return DataPoints.value(dp, pv) > 0;
//		});

		stats = variableDependent.stats;
		// data
		var choice = g.selectAll("g.group").data(pief(dp), id);

		// enter
		var enter = choice.enter();
		var arc = enter.append("svg:g")
			.attr("class").stringf(function(d, i) return "group fill-" + i)
			.attr("transform").string("translate(" + radius + "," + radius + ")");
		var path = arc
			.append("svg:path")
			.attr("class").string("slice");
		RGColors.storeColorForSelection(cast arc);
		if(displayGradient)
			arc.eachNode(applyGradient);
		if (animated)
		{
			path.attr("d").stringf(arcShape(arcStart));
			arc
				.eachNode(fadein)
				.onNode("mouseover.animation", highlight)
				.onNode("mouseout.animation", backtonormal);
		} else {
			path.attr("d").stringf(arcShape(arcNormal));
		}
		arc.onNode("mouseover.label", onMouseOver);
//		if (null != labelDataPoint)
//			arc.eachNode(appendLabel);
		if (null != mouseClick)
			arc.onNode("click.user", onMouseClick);

		if (null != labelDataPoint)
			choice.enter()
				.append("svg:g")
					.attr("transform").string("translate(" + radius + "," + radius + ")")
					.eachNode(appendLabel);

		// update
		choice.update()
			.select("path")
			.transition()
				.ease(animationEase)
				.duration(animationDuration)
				.attr("d").stringf(arcShape(arcNormal));
		if (null != labelDataPoint)
			choice.update().eachNode(updateLabel);

		// exit
		choice.exit()
			.eachNode(removeLabel)
			.remove();

		ready.dispatch();
	}

	function onMouseOver(dom, i)
	{
		if (null == labelDataPointOver)
			return;
		var d : { dp : Dynamic, startAngle : Float, endAngle : Float } = Access.getData(dom),
			text = labelDataPointOver(d.dp, stats);

		if (null == text)
			tooltip.hide();
		else
		{
			var a = d.startAngle + (d.endAngle - d.startAngle) / 2 - Math.PI / 2,
				r = radius * tooltipRadius;
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(width / 2 + Math.cos(a) * r, height / 2 + Math.sin(a) * r, RGColors.extractColor(dom));
		}
	}

	function onMouseClick(dom, i)
	{
		var d : { dp : Dynamic } = Access.getData(dom);
		mouseClick(d.dp);
	}

	function removeLabel(dom, i)
	{
		var n = Dom.selectNode(dom),
			d : { id : String } = Access.getData(dom);
		var label = labels.get(d.id);
		label.destroy();
		labels.remove(d.id);
	}

	function updateLabel(dom, i)
	{
		var n = Dom.selectNode(dom),
			d : { startAngle : Float, endAngle : Float, id : String, dp : Dynamic } = Access.getData(dom),
			label = labels.get(d.id),
			r = radius * labelRadius,
			a = d.startAngle + (d.endAngle - d.startAngle) / 2 - Math.PI / 2;

		label.text = labelDataPoint(d.dp, stats);
		label.place(
			-2.5 + Math.cos(a) * r,
			-2.5 + Math.sin(a) * r,
			Const.TO_DEGREE * a);
		if(DataPoints.value(d.dp, stats.type) == 0)
			label.hide();
		else
			label.show();
	}

	function appendLabel(dom, i : Int)
	{
		var n = Dom.selectNode(dom),
			label = new Label(n, labelDontFlip, true, true),
			d : { startAngle : Float, endAngle : Float, id : String, dp : Dynamic } = Access.getData(dom),
			r = radius * labelRadius,
			a = d.startAngle + (d.endAngle - d.startAngle) / 2 - Math.PI / 2;
		label.orientation = labelOrientation;
		switch(labelOrientation)
		{
			case FixedAngle(_):
				label.anchor = GridAnchor.Center;
			case Aligned:
				label.anchor = GridAnchor.Left;
			case Orthogonal:
				label.anchor = GridAnchor.Top;
		}
		label.text = labelDataPoint(d.dp, stats);
		label.place(
			-2.5 + Math.cos(a) * r,
			-2.5 + Math.sin(a) * r,
			Const.TO_DEGREE * a);
		labels.set(d.id, label);
		if(DataPoints.value(d.dp, stats.type) <= 0)
			label.hide();
	}

	function applyGradient(n, i : Int)
	{
		var gn = Dom.selectNodeData(n),
			dp = Access.getData(n),
			id = dp.id;
		if (g.select("defs").select("#rg_pie_gradient_" + id).empty())
		{
			var slice = gn.select("path.slice"),
				shape = arcNormal.shape(Access.getData(n)),
				t = gn.append("svg:path").attr("d").string(shape),
				box : { x : Float, y : Float, width : Float, height : Float } = try { untyped t.node().getBBox(); } catch (e : Dynamic) { { x : 0.0, y : 0.0, width : 0.0, height : 0.0 }; };
			t.remove();
			var color = RGColors.parse(slice.style("fill").get(), "#cccccc"),
				scolor = RGColors.applyLightness(Hsl.toHsl(color), gradientLightness);

			var ratio = box.width / box.height,
				cx = -box.x * 100 / box.width,
				cy = -box.y * 100 / box.height / ratio,
				r = Math.max(cx, cy);
			var stops = g.select("defs")
				.append("svg:radialGradient")
				.attr("gradientUnits").string("objectBoundingBox")
				.attr("id").string("rg_pie_gradient_" + id)
				.attr("cx").string(cx + "%")
				.attr("cy").string(cy + "%")
				.attr("gradientTransform").string("scale(1 "+ratio+")")
				.attr("r").string(r+"%")
			;
			stops.append("svg:stop")
				.attr("offset").string((100*innerRadius)+"%")
				.attr("stop-color").string(color.toRgbString())
				.attr("stop-opacity").float(1);
			stops.append("svg:stop")
				.attr("offset").string("100%")
				.attr("stop-color").string(scolor.toRgbString())
				.attr("stop-opacity").float(1);
		}
		gn.select("path.slice")
			.attr("style").string("fill:url(#rg_pie_gradient_" + id + ")");
	}

	function fadein(n, i : Int)
	{
		var gn = Dom.selectNodeData(n),
			shape = arcNormal.shape(Access.getData(n));

		gn.selectAll("path.slice")
			.transition().ease(animationEase).duration(animationDuration)
			.delay(animationDelay)
			.attr("d").string(shape)
		;
	}

	function highlight(d, i : Int)
	{
		var slice = Dom.selectNodeData(d).selectAll("path");
		slice
			.transition().ease(animationEase).duration(animationDuration)
			.attr("d").stringf(arcShape(arcBig));
	}

	function backtonormal(d, i : Int)
	{
		var slice = Dom.selectNodeData(d).selectAll("path");
		slice
			.transition().ease(animationEase).duration(animationDuration)
			.attr("d").stringf(arcShape(arcNormal));
	}

	function id(dp : Dynamic, i : Int) return dp.id;

	function makeid(dp : Dynamic)
	{
		var c = Objects.clone(dp);
		Reflect.deleteField(c, variableDependent.type);
		return Md5.encode(Dynamics.string(c));
	}

	function arcShape(a : Arc<{ startAngle : Float, endAngle : Float }>)
	{
		return function(d : { startAngle : Float, endEngle : Float, id : String, dp : Dynamic }, i : Int)
		{
			return a.shape(cast d);
		}
	}

	function pief(dp : Array<Dynamic>) : Array<{ startAngle : Float, endEngle : Float, id : String, dp : Dynamic }>
	{
		var name = variableDependent.type,
			temp = dp.map(function(d) return Reflect.field(d, name)),
			arr : Dynamic = pie.pie(temp);
		for (i in 0...arr.length)
		{
			var id = makeid(dp[i]);
			Reflect.setField(arr[i], "id", id);
			Reflect.setField(arr[i], "dp", dp[i]);
		}
		return arr;
	}

	override function destroy()
	{
		for (label in labels)
			label.destroy();
		super.destroy();
	}
}