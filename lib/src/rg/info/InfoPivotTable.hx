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
import thx.color.Hsl;
import thx.color.NamedColors;
import rg.util.RGColors;
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoPivotTable
{
	static var defaultStartColor = new Hsl(210, 1, 1);
	static var defaultEndColor = new Hsl(210, 1, 0.5);
	public var label : InfoLabelPivotTable;

	public var heatmapColorStart : Hsl;
	public var heatmapColorEnd : Hsl;

	public var displayHeatmap : Bool;
	public var displayColumnTotal : Bool;
	public var displayRowTotal : Bool;

	public var columnAxes : Int;

	public var click : Dynamic -> Void;
	public var cellclass : Null<Dynamic -> Stats<Dynamic> -> String>;
	public var valueclass : Null<Dynamic -> String -> String>;
	public var headerclass : Null<String -> String>;
	public var totalclass : Null<Dynamic -> Array<Dynamic> -> String>;

	public function new()
	{
		label = new InfoLabelPivotTable();

		heatmapColorStart = defaultStartColor;
		heatmapColorEnd = defaultEndColor;

		displayHeatmap = true;
		displayColumnTotal = true;
		displayRowTotal = true;

		columnAxes = 1;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"columnaxes".toInt(["columnAxes"]),
			"displayheatmap".toBool(["displayHeatmap"]),
			"displaycolumntotal".toBool(["displayColumnTotal"]),
			"displayrowtotal".toBool(["displayRowTotal"]),
			"startcolor".toTry(["heatmapColorStart"],
				function(value : Dynamic) return Hsl.toHsl(RGColors.parse(value, defaultStartColor.toCss())),
				"value is not a parsable color '{0}'"
			),
			"endcolor".toTry(["heatmapColorEnd"],
				function(value : Dynamic) return Hsl.toHsl(RGColors.parse(value, defaultEndColor.toCss())),
				"value is not a parsable color '{0}'"
			),
			"label".toInfo(InfoLabelPivotTable),
			"click".toFunction(),
			"cellclass".toExpressionFunction([null, "stats"]),
			"valueclass".toExpressionFunction(["value", "header"]),
			"headerclass".toExpressionFunction(["header"]),
			"totalclass".toExpressionFunction(["value", "values"])
		];
	}
}