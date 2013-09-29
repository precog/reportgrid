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
import rg.svg.chart.GradientEffect;
import rg.svg.chart.GradientEffects;
import rg.info.filter.TransformResult;
import thx.util.Message;
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoFunnelChart
{
	public var animation : InfoAnimation;
	public var label : InfoLabelFunnel;
	public var sortDataPoint : Dynamic -> Dynamic -> Int;
	public var click : Dynamic -> Stats<Dynamic> -> Void;
	public var padding : Float;
	public var flatness : Float;
	public var effect : GradientEffect;
	public var arrowSize : Float;

	public function new()
	{
		animation = new InfoAnimation();
		label = new InfoLabelFunnel();
		padding = 2.5;
		flatness = 1.0;
		effect = GradientEffect.Gradient(1.25);
		arrowSize = 30;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"animation".toInfo(InfoAnimation),
			"label".toInfo(InfoLabelFunnel),
			"sort".toExpressionFunction(["a", "b"], ["sortDataPoint"]),
			"click".toFunction(),
			"segmentpadding".toFloat(["padding"]),
			"flatness".toFloat(),
			"effect".custom(function(value : Dynamic) {
				if(GradientEffects.canParse(value))
					return TransformResult.Success(GradientEffects.parse(value));
				else
					return TransformResult.Failure(new Message("'{0}' is not a valid effect", value));
			}),
			"arrowsize".toFloat(["arrowSize"])
		];
	}
}