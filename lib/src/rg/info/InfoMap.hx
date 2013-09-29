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

package rg.info;
import rg.axis.Stats;
import rg.svg.chart.ColorScaleMode;
import rg.svg.chart.ColorScaleModes;
import thx.color.Colors;
import thx.error.Error;
import thx.geo.Azimuthal;
import rg.RGConst;
import rg.info.filter.TransformResult;
import rg.info.filter.ITransformer;
import rg.info.filter.Pairs;
import thx.util.Message;
using rg.info.filter.FilterDescription;
using rg.info.Info;
using Arrays;

@:keep class InfoMap
{
	public var url : String;
	public var type : String;
	public var scale : Float;
	public var projection : String;
	public var classname : String;
	public var translate : Array<Float>;
	public var origin : Array<Float>;
	public var parallels : Array<Float>;
	public var mode : ProjectionMode;
	public var property : Null<String>;
	public var label : InfoLabel;
	public var click : Dynamic -> Stats<Dynamic> -> Void;
	public var radius : Null<Dynamic -> Stats<Dynamic> -> Float>;
	public var colorScaleMode : ColorScaleMode;
	public var usejsonp : Bool;
	public var mapping : Dynamic;
	public var mappingurl : String;

	public function new()
	{
		property = "location";
		type = "geojson";
		colorScaleMode = ColorScaleMode.FromCssInterpolation();
		usejsonp = true;
		radius = function(_, _) return 10;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			new FilterDescription("template", new TemplateTransformer()),
			"url".toStr(),
			"type".toStr(),
			"scale".toFloat(),
			"projection".toStr(),
			"classname".toStr(),
			"translate".toArray(),
			"origin".toArray(),
			"parallels".toArray(),
			"mode".toTry(
				function(v) return Type.createEnum(ProjectionMode, Strings.ucfirst(v.toLowerCase()), []),
				"value is not a valid projection mode '{0}'"
			),
			"property".toStrOrNull(),
			"usejsonp".toBool(),
			"label".toInfo(InfoLabel),
			"click".toFunction(),
			"color".simplified(["colorScaleMode"],
				ColorScaleModes.createFromDynamic,
				(function(v) return Std.is(v, String) || Reflect.isFunction(v)).make("invalid color mode value '{0}'")
			),
			"radius".toExpressionFunctionOrFloat([null, "stats"]),
			new FilterDescription("mapping", new MapTransformer())
		];
	}
}

class MapTransformer implements ITransformer<Dynamic, Pairs>
{
	public function new() { }

	public function transform(value : Dynamic) : TransformResult<Pairs>
	{
		return if(Std.is(value, String)) {
			TransformResult.Success(new Pairs(["mappingurl"], [value]));
		} else if(Types.isAnonymous(value)) {
			TransformResult.Success(new Pairs(["mapping"], [value]));
		} else {
			TransformResult.Failure(new Message("value should be url string or an object", [value]));
		};
	}
}

class TemplateTransformer implements ITransformer<Dynamic, Pairs>
{
	public function new() { }

	public function transform(value : Dynamic) : TransformResult<Pairs>
	{
		value = null == value ? "" : "" + value;
		return switch(value.toLowerCase())
		{
			case "world", "world-countries":
				TransformResult.Success(new Pairs(
					["projection", "url"],
					["mercator", RGConst.BASE_URL_GEOJSON + "world-countries.json.js"]));
			case "usa-states":
				TransformResult.Success(new Pairs(
					["projection", "url"],
					["albersusa", RGConst.BASE_URL_GEOJSON + "usa-states.json.js"]));
			case "usa-states-name":
				TransformResult.Success(new Pairs(
					["projection", "url"],
					["albersusa", RGConst.BASE_URL_GEOJSON + "usa-states-name.json.js"]));
			case "usa-states-code":
				TransformResult.Success(new Pairs(
					["projection", "url"],
					["albersusa", RGConst.BASE_URL_GEOJSON + "usa-states-code.json.js"]));
			case "usa-state-centroids":
				TransformResult.Success(new Pairs(
					["projection", "url"],
					["albersusa", RGConst.BASE_URL_GEOJSON + "usa-state-centroids.json.js"]));
			case "usa-counties":
				TransformResult.Success(new Pairs(
					["projection", "url"],
					["albersusa", RGConst.BASE_URL_GEOJSON + "usa-counties.json.js"]));
			default:
				TransformResult.Failure(new Message("{0} is not a valid map template", [value]));
		}
	}
}