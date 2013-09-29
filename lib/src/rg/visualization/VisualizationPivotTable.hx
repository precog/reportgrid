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
import rg.info.InfoPivotTable;
import rg.html.chart.PivotTable;
import thx.error.NotImplemented;
import dhx.Selection;

// TODO wire color paramaters
// TODO wire label functions

class VisualizationPivotTable extends VisualizationHtml
{
	public var info : InfoPivotTable;
	var chart : PivotTable;

	public function new(container : Selection)
	{
		super(container);
	}

	override function _init()
	{
		chart = new PivotTable(container);
		chart.ready.add(function() ready.dispatch());

		chart.displayColumnTotal = info.displayColumnTotal;
		chart.displayHeatMap = info.displayHeatmap;
		chart.displayRowTotal = info.displayRowTotal;

		chart.colorStart = info.heatmapColorStart;
		chart.colorEnd = info.heatmapColorEnd;

		chart.cellclass = info.cellclass;
		chart.valueclass = info.valueclass;
		chart.headerclass = info.headerclass;
		chart.totalclass = info.totalclass;

		if (null != info.click)
			chart.click = info.click;

		if (null != info.label.datapoint)
			chart.labelDataPoint = info.label.datapoint;

		if (null != info.label.datapointover)
			chart.labelDataPointOver = info.label.datapointover;

		if (null != info.label.axis)
			chart.labelAxis = info.label.axis;

		if (null != info.label.axisvalue)
			chart.labelAxisValue = info.label.axisvalue;


		if (null != info.label.total)
			chart.labelTotal = info.label.total;

		if (null != info.label.totalover)
			chart.labelTotalOver = info.label.totalover;
		chart.incolumns = Ints.min(info.columnAxes, independentVariables.length);
		chart.init();
	}

	override function _feedData(data : Array<Dynamic>)
	{
		chart.setVariables(independentVariables, dependentVariables);
		chart.data(data);
	}

	override public function _destroy()
	{
		chart.destroy();
	}
}