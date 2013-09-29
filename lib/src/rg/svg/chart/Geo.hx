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
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.axis.Stats;
import rg.svg.widget.GeoMap;
import rg.svg.panel.Panel;
import rg.util.DataPoints;
import rg.svg.widget.Label;
import rg.util.RGColors;
import thx.color.Colors;
import thx.color.NamedColors;
import thx.color.Rgb;
import thx.color.Hsl;
import dhx.Selection;
import rg.html.widget.Tooltip;
import rg.svg.chart.ColorScaleMode;
import rg.svg.util.RGCss;
import rg.data.Variable;
import rg.axis.IAxis;
import rg.svg.panel.Panels;
import js.html.Element;
using Arrays;

class Geo extends Chart
{
	public var mapcontainer(default, null) : Selection;
	@:isVar public var colorMode(get, set) : ColorScaleMode;
	public var labelOutline : Bool = false;
	public var labelShadow : Bool = false;
	var variableDependent : VariableDependent<Dynamic>;
	var dps : Array<Dynamic>;
	var queue : Array<Void->Void>;

	public function new(panel : Panel)
	{
		super(panel);
		mapcontainer = g.append("svg:g").attr("class").string("mapcontainer");
		queue = [];

		colorMode = FromCss();
		resize();
	}

	public function setVariables(variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, data : Array<Dynamic>)
	{
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
		if(null != mapcontainer)
			mapcontainer.attr("transform").string("translate(" + (width / 2) + "," + (height / 2) + ")");
	}

	function dpvalue(dp : Dynamic) return DataPoints.value(dp, variableDependent.type);

	function drawmap(map : GeoMap, field : String)
	{
		if (null == dps || 0 == dps.length)
		{
			queue.push(drawmap.bind(map, field));
			return;
		}
		colorMode = map.colorMode;
		var text = null;
		for (dp in dps)
		{
			var id = Reflect.field(dp, field),
				feature = map.map.get(id);
			if (null == feature)
				continue;
			stylefeature(feature.svg, Objects.copyTo(dp, feature.dp));
			if (null != map.radius && feature.svg.node().nodeName == "circle")
				feature.svg.attr("r").float(map.radius(feature.dp, variableDependent.stats));
			if (null != map.labelDataPoint && null != (text = map.labelDataPoint(feature.dp, variableDependent.stats)))
			{
				var c = Reflect.field(feature.dp, "$centroid");
				var label = new Label(mapcontainer, true, labelShadow, labelOutline);
				label.text = text;
				label.place(c[0], c[1], 0);
			}
		}
		if (queue.length == 0)
		{
			ready.dispatch();
		}
	}

	public function handlerDataPointOver(n : Element, dp : Dynamic, f)
	{
		var text = f(dp, variableDependent.stats);
		if (null == text)
			tooltip.hide()
		else
		{
			tooltip.html(text.split("\n").join("<br>"));
			var centroid = Reflect.field(dp, "$centroid");
			moveTooltip(centroid[0] + width / 2, centroid[1] + height / 2, RGColors.extractColor(n));
		}
	}

	public function handlerClick(dp : Dynamic, f)
	{
		f(dp, variableDependent.stats);
	}

	dynamic function stylefeature(svg : Selection, dp : Dynamic)
	{

	}

	function redraw()
	{
		while (queue.length > 0)
			queue.shift()();
	}

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
					RGColors.storeColorForSelection(svg);
				}
			case Sequence(c):
				var colors = Arrays.map(c, function(d, _) return d.toCss());
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					var t = variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), DataPoints.value(dp, variableDependent.type)),
						index = Math.floor(colors.length * t);
					svg.style("fill").string(colors[index]);
					RGColors.storeColorForSelection(svg);
				}
			case Interpolation(colors):
				var interpolator = Rgb.interpolateStepsf(colors);
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					var t = variableDependent.axis.scale(variableDependent.min(), variableDependent.max(), DataPoints.value(dp, variableDependent.type));
					svg.style("fill").string(interpolator(t).toCss());
					RGColors.storeColorForSelection(svg);
				}
			case Fixed(c):
				var color = c.toCss();
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					svg.style("fill").string(color);
					RGColors.storeColorForSelection(svg);
				}
			case Fun(f):
				stylefeature = function(svg : Selection, dp : Dynamic)
				{
					svg.style("fill").string(f(dp, variableDependent.stats));
					RGColors.storeColorForSelection(svg);
				}
		}
		return v;
	}
/*
	function set_colorMode(v : ColorScaleMode)
	{
		stylefeature = colorStyleFunction(this.colorMode = v, variableDependent);
		return v;
	}

	static function colorStyleFunction(mode : ColorScaleMode, variable : Variable<Dynamic, IAxis<Dynamic>>)
	{
		switch(mode)
		{
			case FromCss(g):
				if (null == g)
					g = RGCss.colorsInCss();
				return function(svg : Selection, dp : Dynamic)
				{
					var t = variable.axis.scale(variable.min(), variable.max(), DataPoints.value(dp, variable.type)),
						index = Math.floor(g * t);
					svg.attr("class").string("fill-" + index);
				}
			case Sequence(c):
				var colors = Arrays.map(c, function(d, _) return d.toCss());
				return function(svg : Selection, dp : Dynamic)
				{
					var t = variable.axis.scale(variable.min(), variable.max(), DataPoints.value(dp, variable.type)),
						index = Math.floor(colors.length * t);
					svg.style("fill").string(colors[index]);
				}
			case Interpolation(colors):
				var interpolator = Rgb.interpolateStepsf(colors);
				return function(svg : Selection, dp : Dynamic)
				{
					var t = variable.axis.scale(variable.min(), variable.max(), DataPoints.value(dp, variable.type));
					svg.style("fill").string(interpolator(t).toCss());
				}
			case Fixed(c):
				var color = c.toCss();
				return function(svg : Selection, dp : Dynamic)
				{
					svg.style("fill").string(color);
				}
			case Fun(f):
				return function(svg : Selection, dp : Dynamic)
				{
					svg.style("fill").string(f(dp, variable.stats));
				}
		}
	}
*/
	override public function init()
	{
		super.init();
		Tooltip.instance.hide();
		if (null == tooltip)
		{
			tooltip = Tooltip.instance;
		}

		g.classed().add("geo");
	}

	public function addMap(map : GeoMap, field : String)
	{
		if (null != field)
			map.onReady.add(drawmap.bind(map, field));
	}
}