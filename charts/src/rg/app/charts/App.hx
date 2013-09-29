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
import rg.factory.FactoryLayout;
import rg.factory.FactoryVariable;
import rg.factory.FactoryHtmlVisualization;
import rg.factory.FactorySvgVisualization;
import rg.info.InfoDataSource;
import rg.info.InfoDomType;
import rg.info.InfoDownload;
import rg.info.InfoGeneral;
import rg.info.InfoLayout;
import rg.info.InfoVisualizationOption;
import rg.info.InfoVisualizationType;
import rg.interactive.RGLegacyRenderer;
import rg.interactive.RGDownloader;
import rg.visualization.Visualization;
import rg.data.DataLoader;
import rg.data.DependentVariableProcessor;
import rg.data.IndependentVariableProcessor;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.html.widget.DownloaderMenu;
import rg.layout.Layout;
import thx.error.Error;
import dhx.Selection;
import haxe.ds.StringMap;
using rg.info.Info;
using Arrays;

class App
{
	static var lastid = 0;
	static var chartsCounter = 0;
	static var chartsLoaded = 0;
	static function nextid()
	{
		return ":RGVIZ-" + (++lastid);
	}

	var layouts : StringMap<Layout>;
	var globalNotifier : hxevents.Notifier;
	public function new(notifier : hxevents.Notifier)
	{
		this.layouts = new StringMap();
		this.globalNotifier = notifier;
	}

	public function visualization(el : Selection, jsoptions : Dynamic)
	{
		chartsCounter++;

		var node = el.node(),
			id = node.id;
		if (null == id)
			node.id = id = nextid();

		var params    = new InfoVisualizationOption().feed(jsoptions),
			loader    = new DataLoader(new InfoDataSource().feed(jsoptions).loader),
			variables = new FactoryVariable().createVariables(params.variables),
			general   = new InfoGeneral().feed(params.options),
			infoviz   = new InfoVisualizationType().feed(params.options),
			uselegacy = !supportsSvg() || general.forcelegacy;

		var visualization : Visualization = null;
//		params.options.marginheight = 29;
		var ivariables : Array<rg.data.VariableIndependent<Dynamic>> = cast variables.filter(function(v) return Std.is(v, VariableIndependent));
		var dvariables : Array<rg.data.VariableDependent<Dynamic>> = cast variables.filter(function(v) return Std.is(v, VariableDependent));

		loader.onLoad.addOnce(function(data) {
			new IndependentVariableProcessor().process(data, ivariables);
			new DependentVariableProcessor().process(data, dvariables);
		});

		if(!uselegacy)
		{
			switch(new InfoDomType().feed(params.options).kind)
			{
				case Svg:
					var layout = getLayout(id, params.options, el, infoviz.replace);
					visualization = new FactorySvgVisualization().create(infoviz.type, layout, params.options);
				case Html:
					if (infoviz.replace)
						el.selectAll("*").remove();
					visualization = new FactoryHtmlVisualization().create(infoviz.type, el, params.options);
			}

			visualization.setVariables(variables, ivariables, dvariables);
			visualization.init();

			if (null != general.ready)
				visualization.addReady(general.ready);

			loader.onLoad.addOnce(function(datapoints : Array<Dynamic>) {
				visualization.feedData(datapoints);
			});
		}


		var brandPadding = 0;
		// download
		var download = new InfoDownload().feed(jsoptions.options.download);
		if(uselegacy)
		{
			var legacy = new RGLegacyRenderer(el, download.legacyservice);
			loader.onLoad.addOnce(function(data) {
				jsoptions.datapoints = data;
				legacy.display(jsoptions);
				if (null != general.ready)
					legacy.onReady(general.ready);
			});
		}

		if(!uselegacy && (null != download.position || null != download.handler))
		{
			var downloader = new RGDownloader(visualization.container, download.service);

			if (null != download.handler)
				visualization.addReadyOnce(function() {
					download.handler(downloader.download);
				});
			else
			{
				visualization.addReadyOnce(function()
				{
					var widget = new DownloaderMenu(downloader.download, download.position, download.formats, visualization.container);
					brandPadding = 24;
				});

			}
		}
		if(!uselegacy)
		{
			visualization.addReadyOnce(function()
			{
				chartsLoaded++;
				if(chartsLoaded == chartsCounter)
				{
					globalNotifier.dispatch();
				}
			});
		}

		if(null != jsoptions.options.error) {
			visualization.addError(jsoptions.options.error);
		}

		haxe.Timer.delay(loader.load, 0);

		return visualization;
	}

	public function getLayout(id : String, options : Dynamic, container : Selection, replace : Bool)
	{
		var old = layouts.get(id);
		if (null != old)
		{
			if (replace)
				old.destroy();
			else
				return old;
		}
		var info = new InfoLayout().feed(options),
			layout = new FactoryLayout().create(info, (null == options.marginheight) ? 0 : options.marginheight, container);
		layouts.set(id, layout);
		return layout;
	}

	public static function supportsSvg() : Bool
	{
		return untyped __js__("!!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect");
	}
}