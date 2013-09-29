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
import rg.info.InfoLeaderboard;
import rg.html.chart.Leadeboard;
import dhx.Selection;

class VisualizationLeaderboard extends VisualizationHtml
{
	public var info : InfoLeaderboard;
	var chart : Leadeboard;
	public function new(container : Selection)
	{
		super(container);
	}

	override function _init()
	{
		chart = new Leadeboard(container);
		chart.ready.add(function() ready.dispatch());

		if (null != info.label.datapoint)
			chart.labelDataPoint = info.label.datapoint;
		if (null != info.label.datapointover)
			chart.labelDataPointOver = info.label.datapointover;
		if (null != info.label.rank)
			chart.labelRank = info.label.rank;
		if (null != info.label.value)
			chart.labelValue = info.label.value;

		chart.animated = info.animation.animated;
		chart.animationDuration = info.animation.duration;
		chart.animationDelay = info.animation.delay;
		chart.animationEase = info.animation.ease;
		chart.useMax = info.usemax;
		chart.displayBar = info.displaybar;
		chart.colorScale = info.colorscale;

		if (null != info.click)
			chart.click = info.click;
		if (null != info.sortDataPoint)
			chart.sortDataPoint = info.sortDataPoint;

		chart.init();
	}

	override function _feedData(data : Array<Dynamic>)
	{

		chart.setVariables(independentVariables, dependentVariables);
		chart.data(data);
	}
}