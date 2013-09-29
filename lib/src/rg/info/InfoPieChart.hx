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
import rg.svg.widget.LabelOrientation;
import rg.svg.widget.LabelOrientations;
import thx.error.Error;
using rg.info.filter.FilterDescription;
using rg.info.Info;
using Arrays;

@:keep class InfoPieChart
{
	public var labelradius : Float;
	public var labelorientation : LabelOrientation;

	public var innerradius : Float;
	public var outerradius : Float;
	public var overradius : Float;
	public var tooltipradius : Float;
	public var animation : InfoAnimation;
	public var label : InfoLabel;
	public var effect : GradientEffect;
	public var sortDataPoint : Dynamic -> Dynamic -> Int;
	public var dontfliplabel : Bool;

	public var click : Dynamic -> Void;

	public function new()
	{
		innerradius = 0.0;
		labelradius = 0.45;
		labelorientation = LabelOrientation.Aligned;
		outerradius = 0.9;
		overradius = 0.95;
		tooltipradius = 0.5;
		animation = new InfoAnimation();
		label = new InfoLabel();
		effect = GradientEffect.Gradient(1.2);
		dontfliplabel = true;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"labelradius".toFloat(),
			"dontfliplabel".toBool(),
			"labelorientation".toTry(
					LabelOrientations.parse,
					"invalid orientation value '{0}'"
				),
			"innerradius".toFloat(),
			"outerradius".toFloat(),
			"overradius".toFloat(),
			"tooltipradius".toFloat(),
			"animation".toInfo(InfoAnimation),
			"label".toInfo(InfoLabel),
			"sort".toExpressionFunction(["a", "b"], ["sortDataPoint"]),
			"click".toFunction(),
			"effect".simplified(
				GradientEffects.parse,
				ReturnMessageIfNot.isString.or(GradientEffects.canParse.make("invalid gradient effect: {0}"))
			)
		];
	}
}