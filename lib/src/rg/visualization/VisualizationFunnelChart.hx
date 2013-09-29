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
import rg.info.InfoFunnelChart;
import rg.layout.Layout;
import rg.svg.chart.FunnelChart;
import rg.svg.chart.GradientEffect;
import rg.svg.layer.Title;
import rg.util.DataPoints;
using Arrays;

// TODO make super class common to piechart
class VisualizationFunnelChart extends VisualizationSvg
{
	public var info : InfoFunnelChart;
	var title : Null<Title>;
	var chart : FunnelChart;

	override function _init()
	{
		// CHART
		var panelChart = layout.getPanel(layout.mainPanelName);
		chart = new FunnelChart(panelChart);
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());

		// labels
		if(null != info.label.datapoint)
			chart.labelDataPoint = info.label.datapoint;
		if(null != info.label.datapoint)
			chart.labelDataPointOver = info.label.datapointover;
		if (null != info.label.arrow)
			chart.labelArrow = info.label.arrow;

		// events
		if(null != info.click)
			chart.click = info.click;

		chart.padding = info.padding;
		chart.flatness = info.flatness;
		switch(info.effect)
		{
			case Gradient(v):
				chart.displayGradient = true;
				chart.gradientLightness = v;
			case NoEffect:
				chart.displayGradient = false;
		}

		chart.arrowSize = info.arrowSize;

		// TITLE
		if (null != info.label.title)
		{
			var panelContextTitle = layout.getContext("title");
			if (null == panelContextTitle)
				return;
			title = new Title(panelContextTitle.panel, null, panelContextTitle.anchor);
		}
	}

	// TODO move sort to axis
	override function _feedData(data : Array<Dynamic>)
	{
		chart.setVariables(independentVariables, dependentVariables);
		var data = DataPoints.filterByIndependents(DataPoints.filterByDependents(data, dependentVariables), independentVariables);
		if (null != info.sortDataPoint)
			data.sort(info.sortDataPoint);
		if (null != title)
		{
			if (null != info.label.title)
			{
				title.text = info.label.title(variables, data, variables.map(function(variable) return variable.type));
				layout.suggestSize("title", title.idealHeight());
			} else
				layout.suggestSize("title", 0);
		}
		if (null != info.sortDataPoint)
		{
			data.sort(info.sortDataPoint);
		}
		chart.init();
		chart.data(data);
	}

	override public function _destroy()
	{
		chart.destroy();
		if (null != title)
			title.destroy();
		super._destroy();
	}
}