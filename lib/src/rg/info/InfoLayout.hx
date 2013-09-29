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
import rg.layout.ScalePattern;
import rg.visualization.Visualizations;
import thx.util.Message;
using rg.info.filter.FilterDescription;
using rg.info.filter.TransformResult;
using rg.info.Info;

@:keep class InfoLayout
{
	public var layout : Null<String>;
	public var width  : Null<Int>;
	public var height : Null<Int>;
	public var type : Null<String>;
	public var main : String;
	public var titleOnTop : Bool;
	public var scalePattern : ScalePattern;
	public var padding : InfoPadding;

	public function new()
	{
		main = "main";
		titleOnTop = true;
		scalePattern = ScalesAlternating;
		padding = new InfoPadding();
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"layout".custom(function(value : Dynamic) {
				var v = null == value ? null : (""+value).toLowerCase();
				if(!Arrays.exists(Visualizations.layouts, v))
					return TransformResult.Failure(new Message("value '{0}' is not a valid visualization layout", [value]));
				else
					return TransformResult.Success(v);
			}),
			"width".toFloat(),
			"height".toFloat(),
			"visualization".custom(["type"], function(value : Dynamic) {
				var v = null == value ? null : (""+value).toLowerCase();
				if(!Arrays.exists(Visualizations.svg, v))
					return TransformResult.Failure(new Message("value '{0}' is not a valid visualization type", [value]));
				else
					return TransformResult.Success(v);
			}),
			"main".toStr(),
			"titleontop".toBool(["titleOnTop"]),
			"yscaleposition".custom(['scalePattern'], function(value : Dynamic) {
				if(!Std.is(value, String))
					return TransformResult.Failure(new Message("value '{0}' must be a string", [value]));
				return TransformResult.Success(switch(value) {
					case "alt", "alternate", "alternating": ScalePattern.ScalesAlternating;
					case "right": ScalePattern.ScalesAfter;
					default: ScalePattern.ScalesBefore;
				});
			}),
			"padding".toInfo(InfoPadding)
		];
	}
}