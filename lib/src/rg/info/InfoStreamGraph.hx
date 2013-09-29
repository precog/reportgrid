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
import rg.svg.chart.StreamEffect;
import rg.svg.chart.StreamEffects;
import thx.svg.LineInterpolator;
import thx.svg.LineInterpolators;
import rg.axis.Stats;
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoStreamGraph extends InfoCartesianChart
{
	public var interpolation : LineInterpolator;
	public var effect : StreamEffect;
	public var segment : InfoSegment;

	public function new()
	{
		super();
		segment = new InfoSegment();
		interpolation = LineInterpolator.Cardinal();
		effect = GradientVertical(1.25);
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"interpolation".toTry(
				function(value : Dynamic) return LineInterpolators.parse(value),
				"value is expected to be a valid interpolation string, it is '{0}'"
			),
			"effect".toTry(
				function(value : Dynamic) return StreamEffects.parse(value),
				"value is expected to be a valid effect string, it is '{0}'"
			),
			"segmenton".simplified(["segment"],
				function(value) return new InfoSegment().feed({ on : value }),
				ReturnMessageIfNot.isString
			),
			"segment".toInfo(InfoSegment)
		].concat(InfoCartesianChart.filters());
	}
}