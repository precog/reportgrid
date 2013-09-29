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
import rg.info.InfoHeatGrid;
import rg.svg.chart.HeatGrid;
import rg.svg.layer.TickmarksOrtho;
import rg.svg.widget.GridAnchor;

class VisualizationHeatGrid extends VisualizationCartesian<Array<Dynamic>>
{
	public var infoHeatGrid : InfoHeatGrid;

	override function initAxes()
	{
		xvariable = cast independentVariables[0];
		yvariables = [cast independentVariables[1]];
	}

	override function initChart()
	{
		var chart = new HeatGrid(layout.getPanel(layout.mainPanelName));
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());

		chart.useContour = infoHeatGrid.contour;
		chart.colorMode = infoHeatGrid.colorScaleMode;

		this.chart = chart;
	}

	override function transformData(dps : Array<Dynamic>) : Array<Dynamic>
	{
		return dps;
	}

	override function setTickmarksDefaults(tickmarks : TickmarksOrtho, i : Int, type : String, pname : String)
	{
		if (i != 0)
			return;

		tickmarks.labelAnchor = GridAnchor.Left;
		tickmarks.labelAngle = 180;
	}
}