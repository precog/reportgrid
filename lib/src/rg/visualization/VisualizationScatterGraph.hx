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
import rg.info.InfoScatterGraph;
import rg.svg.chart.ScatterGraph;
import rg.data.Segmenter;
import rg.util.DataPoints;
using Arrays;
import rg.data.Variable;
import rg.axis.IAxis;
import rg.axis.ScaleDistribution;

class VisualizationScatterGraph extends VisualizationCartesian<Array<Array<Dynamic>>>
{
	public var infoScatter : InfoScatterGraph;

	override function initAxes()
	{
		xvariable = cast independentVariables[0];
		yvariables = cast dependentVariables.map(function(d) : Variable<Dynamic, IAxis<Dynamic>> return d);
	}

	override function initChart()
	{
		var chart = new ScatterGraph(layout.getPanel(layout.mainPanelName));
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());

		chart.symbol = infoScatter.symbol;
		chart.symbolStyle = infoScatter.symbolStyle;

		if(null == independentVariables[0].scaleDistribution)
			independentVariables[0].scaleDistribution = ScaleFill;

		this.chart = chart;
	}

	override function transformData(dps : Array<Dynamic>) : Array<Array<Dynamic>>
	{
		var results = [],
			segmenter = new Segmenter(infoScatter.segment.on, infoScatter.segment.transform, infoScatter.segment.scale, infoScatter.segment.values);
		for (variable in dependentVariables)
			results.push(DataPoints.filterByDependents(dps, [variable]));
		return results;
	}
}