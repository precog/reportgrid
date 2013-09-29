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
import thx.util.Message;

using rg.info.filter.FilterDescription;
using rg.info.filter.TransformResult;

using rg.info.Info;

@:keep class InfoCartesianChart
{
	public var animation : InfoAnimation;
	public var click : Dynamic -> Stats<Dynamic> -> Void;
	public var label : InfoLabelAxis;

	public var displayMinorTick : String -> Bool;
	public var displayMajorTick : String -> Bool;
	public var displayLabelTick : String -> Bool;
	public var displayAnchorLineTick : String -> Bool;

	public var displayMinorRule : String -> Bool;
	public var displayMajorRule : String -> Bool;
	public var displayAnchorLineRule : String -> Bool;

	public var labelOrientation : String -> Null<String>;
	public var labelAnchor : String -> Null<String>;
	public var labelAngle : String -> Null<Float>;

	public var lengthTickMinor : Float;
	public var lengthTickMajor : Float;
	public var paddingTickMinor : Float;
	public var paddingTickMajor : Float;
	public var paddingLabel : Float;

	public function new()
	{
		animation = new InfoAnimation();
		label = new InfoLabelAxis();
		displayMinorTick = function(_) return true;
		displayMajorTick = function(_) return true;
		displayLabelTick = function(_) return true;
		displayAnchorLineTick = function(_) return false;

		displayMinorRule = function(_) return false;
		displayMajorRule = function(_) return false;
		displayAnchorLineRule = function(_) return false;

		labelOrientation = function(_) return null;
		labelAnchor = function(_) return null;
		labelAngle = function(_) return null;

		lengthTickMinor = 2;
		lengthTickMajor = 5;
		paddingTickMinor = 1;
		paddingTickMajor = 1;
		paddingLabel = 10;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"animation".toInfo(InfoAnimation),
			"click".toFunction(),
			"label".toInfo(InfoLabelAxis),

			"displaytickmarks".toExpressionFunctionOrBool(["type"], ["displayMinorTick", "displayMajorTick", "displayLabelTick"]),
			"displaytickminor".toExpressionFunctionOrBool(["type"], ["displayMinorTick"]),
			"displaytickmajor".toExpressionFunctionOrBool(["type"], ["displayMajorTick"]),
			"displayticklabel".toExpressionFunctionOrBool(["type"], ["displayLabelTick"]),
			"displayanchorlinetick".toExpressionFunctionOrBool(["type"], ["displayAnchorLineTick"]),
			"displayrules".toExpressionFunctionOrBool(["type"], ["displayMinorRule", "displayMajorRule"]),
			"displayruleminor".toExpressionFunctionOrBool(["type"], ["displayMinorRule"]),
			"displayrulemajor".toExpressionFunctionOrBool(["type"], ["displayMajorRule"]),
			"displayanchorlinerule".toExpressionFunctionOrBool(["type"], ["displayAnchorLineRule"]),

			"lengthtick".toFloat(["lengthTickMajor", "lengthTickMinor"]),
			"lengthtickminor".toFloat(["lengthTickMinor"]),
			"lengthtickmajor".toFloat(["lengthTickMajor"]),
			"paddingtick".toFloat(["paddingTickMajor", "paddingTickMinor"]),
			"paddingtickminor".toFloat(["paddingTickMinor"]),
			"paddingtickmajor".toFloat(["paddingTickMajor"]),
			"paddingticklabel".toFloat(["paddingLabel"]),

			"labelorientation".toExpressionFunctionOrString(["type"], ["labelOrientation"]),
			"labelanchor".toExpressionFunctionOrString(["type"], ["labelAnchor"]),
			"labelangle".toExpressionFunctionOrFloat(["type"], ["labelAngle"]),
			"labelhorizontal".simplified(["labelAnchor"], function(v) return v == false ? function(v) return "right" : function(v) return null, ReturnMessageIfNot.isBool),
			"labelhorizontal".simplified(["labelAngle"], function(v) return v == false ? function(v) return 0 : function(v) return null, ReturnMessageIfNot.isBool)
		];
	}
}