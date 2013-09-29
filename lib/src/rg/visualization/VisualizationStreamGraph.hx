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
import rg.data.Segmenter;
import rg.svg.chart.StreamGraph;
import rg.info.InfoStreamGraph;
import rg.axis.IAxis;
import rg.data.Variable;
using Arrays;

class VisualizationStreamGraph extends VisualizationCartesian<Array<Array<Dynamic>>>
{
	public var infoStream : InfoStreamGraph;

	override function initAxes()
	{
		xvariable = cast independentVariables[0];
		yvariables = cast dependentVariables.map(function(d) : Variable<Dynamic, IAxis<Dynamic>> return d);
	}

	override function initChart()
	{
		var chart = new StreamGraph(layout.getPanel(layout.mainPanelName));
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());

		chart.interpolator = infoStream.interpolation;
		switch(infoStream.effect)
		{
			case NoEffect:
				chart.gradientStyle = 0;
			case GradientVertical(lightness):
				chart.gradientStyle = 1;
				chart.gradientLightness = lightness;
			case GradientHorizontal(lightness):
				chart.gradientStyle = 2;
				chart.gradientLightness = lightness;
		}

		this.chart = chart;
	}

	override function transformData(dps : Array<Dynamic>) : Array<Array<Dynamic>>
	{
		var segmenter = new Segmenter(infoStream.segment.on, infoStream.segment.transform, infoStream.segment.scale, infoStream.segment.values);
		return segmenter.segment(dps);
	}
}