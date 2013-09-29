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
import thx.svg.LineInterpolator;
import thx.svg.LineInterpolators;
import rg.svg.chart.LineEffect;
import rg.svg.chart.LineEffects;
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoLineChart extends InfoCartesianChart
{
	public var effect : LineEffect;
	public var interpolation : LineInterpolator;
	public var symbol : Dynamic -> Stats<Dynamic> -> String;
	public var symbolStyle : Dynamic -> Stats<Dynamic> -> String;
	public var displayarea : Bool;
	public var y0property : String;
	public var segment : InfoSegment;
	public var sensibleradius : Int;

	public function new()
	{
		super();
		segment = new InfoSegment();
		effect = LineEffect.Gradient(-1.2, 2);
		interpolation = LineInterpolator.Linear;
		displayarea = false;
		sensibleradius = 100;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"symbol".toExpressionFunctionOrString([null, "stats"]),
			"symbolstyle".toExpressionFunctionOrString([null, "stats"], ["symbolStyle"]),
			"segmenton".simplified(["segment"],
				function(value) return new InfoSegment().feed({ on : value }),
				ReturnMessageIfNot.isString
			),
			"segment".toInfo(InfoSegment),
			"y0property".toStr(),
			"displayarea".toBool(),
			"sensibleradius".toInt(),
			"effect".toTry(
				LineEffects.parse,
				"invalid effect string value '{0}'"
			),
			"interpolation".toTry(
				function(v) return LineInterpolators.parse(v),
				"invalid line interpolation string value '{0}'"
			)
		].concat(InfoCartesianChart.filters());
	}
}