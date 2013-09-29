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
import rg.svg.panel.Panel;
import thx.color.Colors;
import thx.color.Hsl;
import dhx.Selection;
import rg.util.DataPoints;
import thx.svg.Line;
import rg.axis.Stats;
import thx.svg.LineInterpolator;
import dhx.Access;
import thx.svg.Area;
import rg.svg.util.PointLabel;
import rg.svg.util.SVGSymbolBuilder;
using Arrays;

// TODO transition animation
// TODO expose options: label.orientation
// TODO expose options: label.place (distance, angle)
// TODO expose options: label.anchor

class ScatterGraph extends CartesianChart<Array<Array<Dynamic>>>
{
	public var symbol : Dynamic -> Stats<Dynamic> -> String;
	public var symbolStyle : Dynamic -> Stats<Dynamic> -> String;

	var chart : Selection;
	var dps : Array<Array<Dynamic>>;

	public function new(panel : Panel)
	{
		super(panel);

		addClass("scatter-graph");
		chart = g.append("svg:g");
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
		var h = height,
			v = yVariables[pos];
		return function(d : Dynamic, i : Int)
		{
			var value   = DataPoints.value(d, v.type),
				scaled  = v.axis.scale(v.min(), v.max(), value),
				scaledh = scaled * h;
			return h - scaledh;
		}
	}

	public function classf(pos : Int, cls : String)
	{
		return function(_, i : Int) return cls + " stroke-" + pos + " fill-" + pos;
	}

	override function data(dps : Array<Array<Dynamic>>)
	{
		this.dps = dps;
		redraw();
	}

	override function resize()
	{
		super.resize();
		redraw();
	}

	function redraw()
	{
		if (null == dps || null == dps[0] || null == dps[0][0])
			return;

		var axisgroup = chart.selectAll("g.group").data(dps);
		// axis enter
		var axisenter = axisgroup.enter()
			.append("svg:g")
			.attr("class").stringf(function(_, i) return "group group-" + i);

		// axis exit
		axisgroup.exit().remove();
		for (i in 0...dps.length)
		{
			var data = dps[i],
				gi = chart.select("g.group-" + i),
				stats = yVariables[i].stats;
			var gsymbol = gi.selectAll("g.symbol").data(data),
				vars = this.yVariables,
				onclick = onclick.bind(stats),
				onmouseover = onmouseover.bind(stats);

			var enter = gsymbol.enter()
				.append("svg:g")
				.attr("class").stringf(classf(i, "symbol"))
				.attr("transform").stringf(getTranslatePointf(i))
				;
			if (null != click)
				enter.on("click", onclick);

			if (null != labelDataPointOver)
				enter.onNode("mouseover", onmouseover);

			SVGSymbolBuilder.generate(enter, stats, symbol, symbolStyle);

			if (null != labelDataPoint)
			{
				var label_group = chart.append("svg:g").attr("class").string("datapoint-labels");
				enter.eachNode(function(n, j) {
					var dp = Access.getData(n);
					PointLabel.label(
						label_group,
						labelDataPoint(dp, stats),
						x(dp),
						getY1(i)(dp, j) - labelDataPointVerticalOffset,
						labelDataPointShadow,
						labelDataPointOutline
					);
				});
			}
			gsymbol.update()
				.selectAll("g.symbol")
				.dataf(function(d, i) return d)
				.update()
				.attr("transform").stringf(cast getTranslatePointf(i))
			;
			gsymbol.exit().remove();
		}
		ready.dispatch();
	}

	function getTranslatePointf(pos : Int)
	{
		var x = this.x,
			y = getY1(pos);
		return function(dp, i)
		{
			return "translate("+Math.round(x(dp))+","+Math.round(y(dp,i))+")";
		};
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
				coords = Coords.fromTransform(sel.attr("transform").get());
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(coords[0], coords[1], null /* COLOR */);
		}
	}

	function onclick(stats : Stats<Dynamic>, dp : Dynamic, i : Int)
	{
		click(dp, stats);
	}
}