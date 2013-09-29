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

package rg.svg.widget;
import haxe.Http;
import hxevents.Notifier;
import rg.util.Jsonp;
import rg.svg.chart.ColorScaleMode;
import rg.util.RGColors;
import thx.error.Error;
import thx.geo.Albers;
import thx.geo.IProjection;
import thx.geo.Mercator;
import thx.geo.Azimuthal;
import dhx.Selection;
import thx.json.GeoJson;
import thx.svg.PathGeoJson;
import thx.json.Json;
import rg.info.InfoMap;
import rg.axis.Stats;
import js.html.Element;
using Arrays;

class GeoMap
{
	public var className(null, set) : String;
	public var map(default, null) : Map<String, { svg : Selection, dp : Dynamic }>;
	public var onReady(default, null) : Notifier;

	public var click : Dynamic -> Stats<Dynamic> -> Void;
	public var labelDataPoint : Dynamic -> Stats<Dynamic> -> String;
	public var labelDataPointOver : Dynamic -> Stats<Dynamic> -> String;
	public var radius : Dynamic -> Stats<Dynamic> -> Float;
	public var colorMode : ColorScaleMode;
	public var ready(default, null) : Bool;
	public var mapping : Dynamic;

	var projection : IProjection;
	var g : Selection;
	public function new(container : Selection, projection : IProjection)
	{
		g = container.append("svg:g").attr("class").string("map");
		this.projection = projection;
		map = new Map ();
		ready = false;
		onReady = new Notifier();
		onReady.addOnce(function() ready = true);
	}

	public function load(path : String, type : String, mappingurl : String, usejsonp : Bool)
	{
		switch(type)
		{
			case "geojson":
				loadGeoJson(path, mappingurl, usejsonp);
			default:
				new Error("unsupported geographic format '{0}'", type);
		}
	}

	function loadGeoJson(geourl : String, mappingurl : String, usejsonp : Bool)
	{
		var load = usejsonp ? loadJsonp : loadJsonAjax;
		if(null == mappingurl)
			load(geourl, draw);
		else
		{
			load(mappingurl, function(m) {
				mapping = m;
				load(geourl, draw);
			});
		}
	}

	static function loadJsonp<T>(url : String, handler : T -> Void)
	{
		Jsonp.get(url, handler, null, null, null);
	}

	static function loadJsonAjax<T>(url : String, handler : T -> Void)
	{
		var http = new Http(url);
		http.onData = function(data)
		{
			var json = Json.decode(data);
			handler(json);
		}
		http.onError = function(err) throw new Error("unable to load JSON file '{0}': {1}", [url, err]);
		http.request(false);
	}

	function draw(json : GeoJson)
	{
		var id = null != mapping
				? function(s) return Reflect.hasField(mapping, s) ? Reflect.field(mapping, s) : s
				: function(s) return s;

		var path = new PathGeoJson();
		path.projection = projection;
		switch(json.type)
		{
			case "FeatureCollection":
				for(i in 0...json.features.length)
				{
					var feature = json.features[i],
						centroid = path.centroid(feature.geometry),
						p = feature.geometry.type == "Point"
							? g.append("svg:circle")
								.attr("cx").float(centroid[0])
								.attr("cy").float(centroid[1])
								.attr("r").float(5)
							: g.append("svg:path")
								.attr("d").string(path.path(feature.geometry))
						;
					var dp = { };
					Reflect.setField(dp, "$centroid", centroid);
					Reflect.setField(dp, "$data", feature.properties);
					if (null != feature.id)
					{
						map.set(id(feature.id), { svg : p, dp : dp });
					}
					if (null != labelDataPointOver)
					{
						p.onNode("mouseover", onMouseOver.bind(dp));
					}

					if (null != click)
						p.onNode("click", onClick.bind(dp));
				}
			case "MultiPoint", "MultiLineString", "MultiPolygon", "GeometryCollection":
				throw new Error("the type '{0}' is not implemented yet", [json.type]);
			default:
				g.append("svg:path").attr("d").string(path.path(json));
		}
		onReady.dispatch();
	}

	function onMouseOver(dp : Dynamic, n, i : Int)
	{
		handlerDataPointOver(n, dp, labelDataPointOver);
	}
	function onClick(dp : Dynamic, _, i) handlerClick(dp, click);

	public var handlerDataPointOver : Element -> Dynamic -> (Dynamic -> Stats<Dynamic> -> String) -> Void;
	public var handlerClick : Dynamic -> (Dynamic -> Stats<Dynamic> -> Void) -> Void;

	function set_className(cls : String)
	{
		g.attr("class").string("map" + (null == cls ? "" : " "  + cls));
		return cls;
	}
}