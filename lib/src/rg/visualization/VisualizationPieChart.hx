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
import rg.info.InfoAnimation;
import rg.info.InfoPieChart;
import rg.svg.panel.Panel;
import rg.svg.chart.PieChart;
import rg.layout.PanelContext;
import rg.svg.layer.Title;
import rg.data.Variable;
import rg.data.VariableIndependent;
import rg.util.Properties;
using Arrays;

class VisualizationPieChart extends VisualizationSvg
{
	var chart : PieChart;
	var title : Null<Title>;
	public var info : InfoPieChart;
	override function _init()
	{
		// CHART
		var panelChart = layout.getPanel(layout.mainPanelName);
		chart = new PieChart(panelChart);
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());

		// aesthetic
		chart.innerRadius = info.innerradius;
		chart.outerRadius = info.outerradius;
		chart.overRadius  = info.overradius;
		chart.tooltipRadius = info.tooltipradius;
		switch(info.effect)
		{
			case Gradient(v):
				chart.displayGradient = true;
				chart.gradientLightness = v;
			case NoEffect:
				chart.displayGradient = false;
		}

		// labels
		chart.labelDataPoint = info.label.datapoint;
		chart.labelDataPointOver = info.label.datapointover;

		chart.labelRadius = info.labelradius;
		chart.labelOrientation = info.labelorientation;
		chart.labelDontFlip = info.dontfliplabel;

		// animation
		chart.animated = info.animation.animated;
		chart.animationDuration = info.animation.duration;
		chart.animationEase = info.animation.ease;
		chart.animationDelay = info.animation.delay;

		// events
		if(null != info.click)
			chart.mouseClick = info.click;

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