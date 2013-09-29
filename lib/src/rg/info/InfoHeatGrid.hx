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
import rg.svg.chart.ColorScaleMode;
import rg.svg.chart.ColorScaleModes;
import thx.color.Rgb;
import thx.color.NamedColors;
import rg.util.RGColors;
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoHeatGrid extends InfoCartesianChart
{
	public var contour : Bool;
	public var colorScaleMode : ColorScaleMode;
	public function new()
	{
		super();
		colorScaleMode = ColorScaleMode.FromCssInterpolation();
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"contour".toBool(),
			"color".simplified(["colorScaleMode"],
				ColorScaleModes.createFromDynamic,
				function(v : Dynamic) return (ColorScaleModes.canParse(v) ? null : "value must be a a string or a function returning a string expressing a valid color scale mode")
			)
		].concat(cast InfoCartesianChart.filters());
	}
}