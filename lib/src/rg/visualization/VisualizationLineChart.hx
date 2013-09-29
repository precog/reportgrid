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

package rg.visualization;
import rg.info.InfoLineChart;
import rg.data.Variable;
import rg.svg.chart.LineChart;
import rg.data.Segmenter;
import rg.util.DataPoints;
import rg.axis.IAxis;
using Arrays;
import rg.axis.ScaleDistribution;

class VisualizationLineChart extends VisualizationCartesian<Array<Array<Array<Dynamic>>>>
{
	public var infoLine : InfoLineChart;

	override function initAxes()
	{
		xvariable = cast variables[0];
		yvariables = cast variables.slice(1);
	}

	override function initChart()
	{
		var chart = new LineChart(layout.getPanel(layout.mainPanelName));
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());

		chart.symbol = infoLine.symbol;
		chart.symbolStyle = infoLine.symbolStyle;

		chart.lineInterpolator = infoLine.interpolation;
		chart.lineEffect = infoLine.effect;
		chart.sensibleRadius = infoLine.sensibleradius;

		if(null == independentVariables[0].scaleDistribution)
			independentVariables[0].scaleDistribution = ScaleFill;

		if (null != infoLine.y0property)
			chart.y0property = infoLine.y0property;
		else if (infoLine.displayarea)
			chart.y0property = "";

		this.chart = chart;
	}

	override function transformData(dps : Array<Dynamic>) : Array<Array<Array<Dynamic>>>
	{
		var results = [],
			segmenter = new Segmenter(infoLine.segment.on, infoLine.segment.transform, infoLine.segment.scale, infoLine.segment.values);
		for (i in 0...dependentVariables.length)
		{
			var variable = dependentVariables[i];
			var values = DataPoints.filterByDependents(dps, [variable]);
			results.push(segmenter.segment(values));
		}
		return results;
	}
}