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

package rg.app.charts;
import rg.util.ChainedExecutor;
import rg.util.Jsonp;
import rg.util.Properties;
import rg.util.DataPoints;
import rg.util.RGStrings;
import rg.util.Urls;
import thx.date.DateParser;
import rg.util.Periodicity;
import thx.error.Error;
import rg.util.RG;
using Arrays;

class MVPOptions
{
	public static function complete(parameters : Dynamic, handler : Dynamic -> Void)
	{
		var chain = new ChainedExecutor(handler);

		if (null == parameters.options)
			parameters.options = { };
		var options : Dynamic = parameters.options;
		// capture defaults

		// misc options
		if (null != options.download && !Types.isAnonymous(options.download))
		{
			var v : Dynamic = options.download;
			Reflect.deleteField(options, "download");
			if (v == true)
				options.download = { position : "auto" };
			else if (Std.is(v, String))
				options.download = { position : v };
			else
				throw new Error("invalid value for download '{0}'", [v]);
		}

		// ensure map is array
		if(null != options.map && Types.isAnonymous(options.map))
		{
			options.map = [options.map];
		}

		// ensure axes
		chain.addAction(function(params : Dynamic, handler : Dynamic -> Void)
		{
			var axes : Array<Dynamic> = params.axes,
				hasdependent = false;
			if(null == axes)
				axes = [];
			params.axes = axes = axes.map(function(v : Dynamic) return Std.is(v, String) ? { type : v } : v);
			for (i in 0...axes.length)
			{
				var variable = axes[i].variable;
				if(null == variable)
					axes[i].variable = !hasdependent && i == axes.length - 1 ? "dependent" : "independent";
				else if("dependent" == variable)
					hasdependent = true;
			}
			for(axis in axes)
			{
				if(axis.variable == "dependent")
				{

				} else {
					switch(params.options.visualization)
					{
						case "barchart", "pivottable":
							if(null == axis.scalemode)
								axis.scalemode = "fit";
					}
				}
			}
			handler(params);
		});


		// ensure labels
		chain.addAction(function(params : Dynamic, handler : Dynamic -> Void)
		{
			if (null == params.options.label)
			{
				params.options.label = {};
			}
			switch(params.options.visualization)
			{
				case "linechart", "barchart", "streamgraph":
					var type = params.axes[0].type;
					if(null == params.options.label.datapointover)
						params.options.label.datapointover = function(dp, stats) {
							return
								(null != params.options.segmenton
									? Properties.formatValue(params.options.segmenton, dp) + ", "
									: "")
								+
								Properties.formatValue(type, dp)
								+ ": " +
								Properties.formatValue(stats.type, dp)
							;
						};
				case "scattergraph", "heatgrid":
					var type = params.axes[0].type;
					if(null == params.options.label.datapointover)
						params.options.label.datapointover = function(dp, stats) {
							return
								Properties.formatValue(type, dp)
								+ ": " +
								Properties.formatValue(stats.type, dp)
							;
						};
				case "geo":
					var type = params.axes[0].type,
						maps : Array<Dynamic> = params.options.map;
					if(null == maps[maps.length-1].label)
						maps[maps.length-1].label = {};
					if(null == maps[maps.length-1].label.datapointover)
						maps[maps.length-1].label.datapointover = function(dp, stats) {
							var v = Properties.formatValue(type, dp);
							if(null == v)
								return null;
							return
								v
								+ ": " +
								Properties.formatValue(stats.type, dp)
							;
						};
				case "piechart":
					if(null == params.options.label.datapoint)
						params.options.label.datapoint = function(dp, stats) {
							var v = DataPoints.value(dp, stats.type);
							return
								params.axes.length > 1
								? Properties.formatValue(params.axes[0].type, dp)
								: (stats.tot != 0.0
									? Floats.format(Math.round(1000 * v / stats.tot)/10, "P:1")
									: RGStrings.humanize(v))
							;
						};

					if(null == params.options.label.datapointover)
						params.options.label.datapointover = function(dp, stats) {
							var v = DataPoints.value(dp, stats.type);
							return
								Properties.humanize(stats.type) + ": " +
								RGStrings.humanize(v) + (
									params.axes.length > 1 && stats.tot != 0.0
									? " ("+Floats.format(Math.round(1000 * v / stats.tot)/10, "P:1")+")"
									: "")
							;
						};
				case "funnelchart":
					if(null == params.options.label.datapointover)
						params.options.label.datapointover = function(dp, stats) {
							var v = DataPoints.value(dp, stats.type);
							return
								Properties.humanize(stats.type) + ": " +
								RGStrings.humanize(v) + (
									params.axes.length > 1 && stats.tot != 0.0
									? " ("+Floats.format(Math.round(1000 * v / stats.tot)/10, "P:1")+")"
									: "")
							;
						};
				case "sankey":
					var axes : Array<Dynamic> = params.axes,
						type = axes[axes.length - 1].type;

					if(null == params.options.label.datapointover)
						params.options.label.datapointover = function(dp, stats) {
							var v = DataPoints.value(dp, type);
							return
								Properties.humanize(type) + ": " +
								Properties.formatValue(type, dp)
								+ "\n" + (
									stats.tot != 0.0
									? Floats.format(Math.round(1000 * v / stats.tot)/10, "P:1")
									: RGStrings.humanize(v)
								)
							;
						};
					if(null == params.options.label.node)
						params.options.label.node = function(dp, stats) {
							return null != dp ? dp.id : "";
						};
					if(null == params.options.label.datapoint)
						params.options.label.datapoint = function(dp, stats) {
							return
								Properties.formatValue(type, dp)
								+ "\n"
								+ Properties.humanize(type)
							;
						};
					if(null == params.options.label.edge)
						params.options.label.edge = function(dp : Dynamic, stats)
						{
							return Floats.format(100 * dp.edgeweight / dp.nodeweight, "D:0")+"%";
						};
					if(null == params.options.label.edgeover)
						params.options.label.edgeover = function(dp : Dynamic, stats)
						{
							return Floats.format(dp.edgeweight, "D:0") + "\n" + Floats.format(100 * dp.edgeweight / dp.nodeweight, "D:0")+"%";
						};
			}
			handler(params);
		});

		chain.execute(parameters);
	}
}