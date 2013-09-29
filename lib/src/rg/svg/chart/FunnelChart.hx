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
import rg.data.VariableIndependent;
import rg.data.VariableDependent;
import rg.util.RGStrings;
import rg.svg.panel.Panel;
import rg.svg.panel.Layer;
import rg.axis.Stats;
import rg.svg.widget.GridAnchor;
import rg.svg.widget.Label;
import thx.culture.FormatNumber;
import dhx.Access;
import dhx.Selection;
import dhx.Dom;
import rg.util.RGColors;
import thx.color.Hsl;
import thx.color.NamedColors;
import thx.math.scale.Linear;
import thx.svg.Diagonal;
import rg.svg.widget.Balloon;
import thx.svg.Symbol;
import rg.util.DataPoints;
using Arrays;

class FunnelChart extends Chart
{
//	public var click : Dynamic -> Stats -> Void;
	public var padding : Float;
	public var flatness : Float;
	public var displayGradient : Bool;
	public var gradientLightness : Float;
	public var arrowSize : Float;
	public var labelArrow : Dynamic -> Stats<Dynamic> -> String;

	var variableIndependent : VariableIndependent<Dynamic>;
	var variableDependent : VariableDependent<Dynamic>;
	var defs : Selection;
	var dps : Array<Dynamic>;

	public function new(panel : Panel)
	{
		super(panel);
		padding = 2.5;
		flatness = 1.0;
		arrowSize = 30;
		gradientLightness = 1;
		displayGradient = true;

		labelArrow = defaultLabelArrow;
		labelDataPoint = defaultLabelDataPoint;
		labelDataPointOver = defaultLabelDataPointOver;
	}

	public function defaultLabelArrow(dp : Dynamic, stats : Stats<Dynamic>)
	{
		var value = Reflect.field(dp, variableDependent.type) / stats.max;
		return FormatNumber.percent(100 * value, 0);
	}

	public function defaultLabelDataPoint(dp : Dynamic, stats : Stats<Dynamic>)
	{
		return RGStrings.humanize(DataPoints.value(dp, variableIndependent.type)).split(" ").join("\n");
	}

	public function defaultLabelDataPointOver(dp : Dynamic, stats : Stats<Dynamic>)
	{
		return Ints.format(Reflect.field(dp, variableDependent.type));
	}

	public function setVariables(variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>)
	{
		variableIndependent = variableIndependents[0];
		variableDependent = variableDependents[0];
	}

	public function data(dps : Array<Dynamic>)
	{
		this.dps = dps;
		redraw();
	}

	override function resize()
	{
		super.resize();
		redraw();
	}

	function dpvalue(dp : Dynamic) return DataPoints.value(dp, variableDependent.type);

	var stats : Stats<Dynamic>;
	var topheight : Float;
	var h : Float;
	var currentNode : js.html.Element;
	function scale(value : Dynamic)
	{
		return variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), value);
	}

	function next(i : Int) return dpvalue(dps[(i + 1) < dps.length ? i + 1 : i]);

	function redraw()
	{

		if (null == dps || 0 == dps.length)
			return;

		// cleanup
		g.selectAll("g").remove();
		g.selectAll("radialGradient").remove();

		// prepare
		stats = variableDependent.stats;
		var max = scale(stats.max),
			wscale = function(v) {
				return scale(v) / max * (width-2) / 2;
			},
			fx1 = function(v) return (width / 2 - wscale(v)),
			fx2 = function(v) return width - fx1(v),
			diagonal1 = new Diagonal()
				.sourcef(function(o, i) return [ fx1(dpvalue(o)), 0.0 ] )
				.targetf(function(o, i) return [ fx1(next(i)), h ] ),
			diagonal2 = new Diagonal()
				.sourcef(function(o, i) return [ fx2(next(i)), h ] )
				.targetf(function(o, i) return [ fx2(dpvalue(o)), 0.0 ] ),
			conj = function(v : Float, r : Bool, dir : Int)
			{
				var x2 = r ? fx1(v) - fx2(v) : fx2(v) - fx1(v),
					a = 5,
					d = r ? (dir == 0 ? 1 : 0) : dir
				;
				return " a " + a + " " + flatness + " 0 0 " + d + " " + x2 + " 0";
			},
			conj1 = function(d, ?i)
			{
				return conj(dpvalue(d), true, 0);
			},
			conj2 = function(d, ?i)
			{
				return conj(next(i), false, 0);
			},
			conjr = function(d, ?i)
			{
				var v = dpvalue(d);
				return " M " + fx1(v) + " 0 " +conj(v, false, 0) + conj(v, true, 1);
			}
		;

		var top = g.append("svg:g");
		var path = top
			.append("svg:path")
			.attr("class").string("funnel-inside fill-0")
			.attr("d").string(conjr(dps[0]))
		;
		if (null != click)
			top.onNode("click", function(_, _) click(dps[0], stats));
		if(displayGradient)
			internalGradient(path);
		path.onNode("mouseover", function(d, _) {
			currentNode = d;
			mouseOver(dps[0], 0, stats);
		});
		RGColors.storeColorForSelection(path);
		topheight = Math.ceil(untyped path.node().getBBox().height / 2) + 1;

		// calculate bottom
		var index = dps.length - 1,
			bottom = g
				.append("svg:path")
				.attr("class").string("funnel-inside fill-" + index)
				.attr("d").string(conjr(dps[index])),
			bottomheight : Float = Math.ceil(untyped bottom.node().getBBox().height / 2) + 1;
		bottom.remove();

		// calculate h
		h = ((height - topheight - bottomheight) - (dps.length - 1) * padding) / dps.length;
		top.attr("transform").string("translate(0," + (1 + topheight) + ")");

		var section = g.selectAll("g.section").data(dps);
		var enter = section.enter()
			.append("svg:g")
			.attr("class").string("section")
			.attr("transform").stringf(function(d, i) {
				return "translate(0,"
				+ (topheight + i * (padding + h))
				+ ")";
			})
		;

		var funnel = enter
			.append("svg:path")
			.attr("class").stringf(function(d, i) return "funnel-outside fill-" + i)
			.attr("d").stringf(function(d, i) {
				var t = diagonal2.diagonal(d, i).split('C');
				t.shift();
				var d2 = 'C' + t.join('C');
				return diagonal1.diagonal(d, i) + conj2(d, i) + d2 + conj1(d, i);
			});
		if (null != click)
			funnel.on("click", function(d, _) click(d, stats));
		RGColors.storeColorForSelection(cast funnel);
		funnel.onNode("mouseover", function(d, i) {
			currentNode = d;
			mouseOver(Access.getData(d), i, stats);
		});
		if(displayGradient)
			enter.eachNode(externalGradient);
		var ga = g.selectAll("g.arrow")
			.data(dps)
			.enter()
			.append("svg:g")
			.attr("class").string("arrow")
			.attr("transform").stringf(function(d, i) {
				return "translate(" + (width / 2) + "," + (topheight + h * i + arrowSize / 2) + ")";
			});

		ga.each(function(d, i) {
			if (null == labelArrow)
				return;
			var text = labelArrow(d, stats);
			if (null == text)
				return;
			var node = Selection.current;

			node
				.append("svg:path")
				.attr("transform").string("scale(1.1,0.85)translate(1,1)")
				.attr("class").string("shadow")
				.style("fill").string("#000")
				.attr("opacity").float(.25)
				.attr("d").string(Symbol.arrowDownWide(arrowSize*arrowSize))
			;

			node
				.append("svg:path")
				.attr("transform").string("scale(1.1,0.8)")
				.attr("d").string(Symbol.arrowDownWide(arrowSize*arrowSize))
			;

			var label = new Label(node, true, false, true);
			label.anchor = GridAnchor.Bottom;
			label.text = text;
		});

		ga.each(function(d, i) {
			if (null == labelDataPoint)
				return;
			var text = labelDataPoint(d, stats);
			if (null == text)
				return;
			var balloon = new Balloon(g);
			balloon.boundingBox = cast {
				x : width / 2 + arrowSize / 3 * 2,
				y : 0,
				width : width,
				height : height
			};
			balloon.preferredSide = 3;

			balloon.text = text.split("\n");
			balloon.moveTo(width / 2, topheight + h * .6 + (h + padding) * i, false);
		});
		ready.dispatch();
	}

	function mouseOver(dp : Dynamic, i : Int, stats : Stats<Dynamic>)
	{
		if (null == labelDataPointOver)
			return;
		var text = labelDataPointOver(dp, stats);
		if (null == text)
			tooltip.hide()
		else
		{
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(width / 2, topheight + h * .6 + (h + padding) * i, RGColors.extractColor(currentNode));
		}
	}

	override public function init()
	{
		super.init();
		if (null != tooltip)
		{
			tooltip.anchor("bottomright");
		}
		defs = g.classed().add("funnel-chart")
			.append("svg:defs");
	}

	function internalGradient(d : Selection)
	{
		var color = RGColors.parse(d.style("fill").get(), "#cccccc"),
			stops = defs
			.append("svg:radialGradient")
			.attr("gradientUnits").string("objectBoundingBox")
			.attr("id").string("rg_funnel_int_gradient_0")
			.attr("cx").string("50%")
			.attr("fx").string("75%")
			.attr("cy").string("20%")
			.attr("r").string(Math.round(75) + "%")
		;
		stops.append("svg:stop")
			.attr("offset").string("0%")
			.attr("stop-color").string(RGColors.applyLightness(Hsl.toHsl(color), gradientLightness).toRgbString())
		;

		stops.append("svg:stop")
			.attr("offset").string("100%")
			.attr("stop-color").string(RGColors.applyLightness(Hsl.toHsl(color), -gradientLightness).toRgbString())
		;

		d.attr("style").string("fill:url(#rg_funnel_int_gradient_0)");
	}

	function externalGradient(n, i : Int)
	{
		var g = Dom.selectNode(n),
			d = g.select("path"),
			color = Hsl.toHsl(RGColors.parse(d.style("fill").get(), "#cccccc")),
			vn = next(i),
			vc = dpvalue(dps[i]),
			ratio = Math.round(vn / vc * 100) / 100,
			id = "rg_funnel_ext_gradient_" + color.toCss() + "-" + ratio;

		var stops = defs
			.append("svg:radialGradient")
			.attr("gradientUnits").string("objectBoundingBox")
			.attr("id").string(id)
			.attr("cx").string("50%")
			.attr("cy").string("0%")
			.attr("r").string("110%")
		;

		var top = color.toCss();

		stops.append("svg:stop")
			.attr("offset").string("10%")
			.attr("stop-color").string(top)
		;

//		var middlecolor = RGColors.applyLightness(color, 1 + Math.log(ratio) / (2.5 * gradientLightness)).toCss();
		var ratio = 1 - (vc < vn ? vc / vn : vn / vc),
			middlecolor = RGColors.applyLightness(color, ratio, gradientLightness * (vc >= vn ? 1 : -1)).toCss();

		stops.append("svg:stop")
			.attr("offset").string("50%")
			.attr("stop-color").string(middlecolor)
		;

		stops.append("svg:stop")
			.attr("offset").string("90%")
			.attr("stop-color").string(top)
		;

		d.attr("style").string("fill:url(#" + id + ")");
	}
}