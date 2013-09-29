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
import rg.svg.chart.GradientEffect;
import rg.svg.chart.GradientEffects;
import rg.axis.Stats;

using rg.info.filter.FilterDescription;

using rg.info.Info;

@:keep class InfoBarChart extends InfoCartesianChart
{
	public var stacked : Bool;
	public var effect : GradientEffect;
	public var barPaddingDataPoint : Float;
	public var barPaddingAxis: Float;
	public var barPadding : Float;
	public var horizontal : Bool;
	public var segment : InfoSegment;
	public var startat : Null<String>;
	public var barclass : Null<Dynamic -> Stats<Dynamic> -> String>;

	public function new()
	{
		super();
		segment = new InfoSegment();
		stacked = true;
		effect = GradientEffect.Gradient(1.25);
		barPadding = 12;
		barPaddingAxis = 4;
		barPaddingDataPoint = 2;
		horizontal = false;
		startat = null;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"stacked".toBool(),
			"horizontal".toBool(),
			"effect".simplified(
				GradientEffects.parse,
				ReturnMessageIfNot.isString.or(GradientEffects.canParse.make("invalid gradient effect: {0}"))
			),
			"barclass".toExpressionFunctionOrString([null, "stats"]),
			"barpadding".toFloat(["barPadding"]),
			"barpaddingaxis".toFloat(["barPaddingAxis"]),
			"barpaddingdatapoint".toFloat(["barPaddingDataPoint"]),
			"segmenton".simplified(["segment"],
				function(value) return new InfoSegment().feed({ on : value }),
				ReturnMessageIfNot.isString
			),
			"segment".toInfo(InfoSegment),
			"startat".toStr()
		].concat(InfoCartesianChart.filters());
	}
}