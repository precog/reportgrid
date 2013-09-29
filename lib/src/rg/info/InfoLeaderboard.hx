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
import thx.math.Equations;
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoLeaderboard
{
	public var animation : InfoAnimation;
	public var label : InfoLabelLeaderboard;
	public var click : Dynamic -> Void;
	public var sortDataPoint : Dynamic -> Dynamic -> Int;
	public var usemax : Bool;
	public var displaybar : Bool;
	public var colorscale : Bool;

	public function new()
	{
		animation = new InfoAnimation();
		label = new InfoLabelLeaderboard();
		usemax = false;
		displaybar = true;
		colorscale = false;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"animation".toInfo(InfoAnimation, function(info) { info.ease = Equations.linear; }),
			"label".toInfo(InfoLabelLeaderboard),
			"click".toFunction(),
			"sort".toExpressionFunction(["a", "b"], ["sortDataPoint"]),
			"displaybar".toBool(),
			"usemax".toBool(),
			"colorscale".toBool(),
		];
	}
}