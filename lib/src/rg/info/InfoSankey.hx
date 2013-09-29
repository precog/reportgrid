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
using rg.info.filter.FilterDescription;
using rg.info.Info;

@:keep class InfoSankey
{
	public var label : InfoLabelSankey;
	public var layerWidth : Null<Float>;
	public var nodeSpacing : Null<Float>;
	public var dummySpacing : Null<Float>;
	public var extraWidth : Null<Float>;
	public var backEdgeSpacing : Null<Float>;
	public var extraHeight : Null<Float>;
	public var extraRadius : Null<Float>;
	public var imageWidth : Null<Float>;
	public var imageHeight : Null<Float>;
	public var imageSpacing : Null<Float>;
	public var chunkWidth : Null<Float>;
	public var labelNodeSpacing : Null<Float>;
	public var imagePath : Dynamic -> String;
	public var layoutmap : { layers : Array<Array<String>>, dummies : Array<Array<String>> };
	public var click : Dynamic -> Stats<Dynamic> -> Void;
	public var clickEdge : { head : Dynamic, tail : Dynamic, edgeweight : Float, nodeweight : Float } -> Stats<Dynamic> -> Void;
	public var layoutmethod : String;

	public var nodeclass : Null<Dynamic -> Stats<Dynamic> -> String>;
	public var edgeclass : Null<Dynamic -> Stats<Dynamic> -> String>;
	public var displayentry : Null<Dynamic -> Stats<Dynamic> -> Bool>;
	public var displayexit : Null<Dynamic -> Stats<Dynamic> -> Bool>;

	public var stackbackedges : Bool;
	public var thinbackedges : Bool;

	public function new()
	{
		label = new InfoLabelSankey();
		stackbackedges = true;
		thinbackedges = false;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"label".toInfo(InfoLabelSankey),
			"layerwidth".toFloat(["layerWidth"]),
			"chunkwidth".toFloat(["chunkWidth"]),
			"nodespacing".toFloat(["nodeSpacing"]),
			"dummyspacing".toFloat(["dummySpacing"]),
			"extrawidth".toFloat(["extraWidth"]),
			"backedgespacing".toFloat(["backEdgeSpacing"]),
			"extraheight".toFloat(["extraHeight"]),
			"extraradius".toFloat(["extraRadius"]),
			"imagewidth".toFloat(["imageWidth"]),
			"imageheight".toFloat(["imageHeight"]),
			"imagespacing".toFloat(["imageSpacing"]),
			"labelnodespacing".toFloat(["labelNodeSpacing"]),
			"imagepath".toExpressionFunction([null], ["imagePath"]),
			"click".toFunction(["click"]),
			"clickedge".toFunction(["clickEdge"]),
			"layoutmap".toObject(),
			"layoutmethod".toStr(),
			"nodeclass".toExpressionFunctionOrString([null, "stats"]),
			"edgeclass".toExpressionFunctionOrString([null, "stats"]),
			"displayentry".toExpressionFunctionOrBool([null, "stats"]),
			"displayexit".toExpressionFunctionOrBool([null, "stats"]),
			"stackbackedges".toBool(),
			"thinbackedges".toBool()
		];
	}
}