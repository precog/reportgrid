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
import rg.factory.FactoryGeoProjection;
import rg.info.InfoGeo;
import rg.svg.chart.Geo;
import rg.svg.widget.GeoMap;
import rg.svg.layer.Title;
import rg.svg.chart.ColorScaleMode;
using Arrays;

class VisualizationGeo extends VisualizationSvg
{
	public var info : InfoGeo;
	var title : Null<Title>;
	var chart : Geo;

	override function _init()
	{
		// TITLE
		if (null != info.label.title)
		{
			var panelContextTitle = layout.getContext("title");
			if (null == panelContextTitle)
				return;
			title = new Title(panelContextTitle.panel, null, panelContextTitle.anchor);
		}

		// CHART
		var panelChart = layout.getPanel(layout.mainPanelName);
		chart = new Geo(panelChart);
		chart.labelOutline = info.labelOutline;
		chart.labelShadow = info.labelShadow;
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());
/*
		// labels
		chart.labelDataPoint = info.label.datapoint;
		chart.labelDataPointOver = info.label.datapointover;

		// events
		chart.click = info.click;
*/

		var pfactory = new FactoryGeoProjection();

		for (imap in info.map)
		{
			var projection = pfactory.create(imap),
				map = new GeoMap(chart.mapcontainer, projection);
			map.className = imap.classname;
			// labels
			if (null == imap.label)
				map.labelDataPoint = info.label.datapoint;
			else
				map.labelDataPoint = imap.label.datapoint;

			if (null == imap.label)
				map.labelDataPointOver = info.label.datapointover;
			else
				map.labelDataPointOver = imap.label.datapointover;

			// events
			map.click = imap.click;

			map.radius = imap.radius;
			map.colorMode = imap.colorScaleMode;

			map.handlerClick = chart.handlerClick;
			map.handlerDataPointOver = chart.handlerDataPointOver;
			map.mapping = imap.mapping;
			var mappingurl = imap.mappingurl;
			if(null != mappingurl && (!StringTools.startsWith(mappingurl, "http://") || !StringTools.startsWith(mappingurl, "https://")))
				mappingurl = RGConst.BASE_URL_GEOJSON + mappingurl + ".json" + (imap.usejsonp ? ".js" : "" );
			map.load(imap.url, imap.type, mappingurl, imap.usejsonp);
			chart.addMap(map, imap.property);
		}
	}

	override function _feedData(data : Array<Dynamic>)
	{
		chart.setVariables(independentVariables, dependentVariables, data);

		if (null != title)
		{
			if (null != info.label.title)
			{
				title.text = info.label.title(variables, data, variables.map(function(variable) return variable.type));
				layout.suggestSize("title", title.idealHeight());
			} else
				layout.suggestSize("title", 0);
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