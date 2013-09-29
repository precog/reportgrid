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
import rg.data.Variable;
import rg.axis.Stats;
import rg.axis.IAxis;
using rg.info.filter.FilterDescription;

@:keep class InfoLabel
{
	public var title : Array<Variable<Dynamic, IAxis<Dynamic>>> -> Array<Dynamic> -> Array<String> -> String;
	public var datapoint : Dynamic -> Stats<Dynamic> -> String;
	public var datapointover : Dynamic -> Stats<Dynamic> -> String;

	public var datapointverticaloffset : Float;
	public var datapointoutline : Bool;
	public var datapointshadow : Bool;

	public function new()
	{
		datapointverticaloffset = 5;
		datapointoutline = false;
		datapointshadow = false;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"title".toTemplateFunctionOrString(["axes", "values", "types"]),
			"datapoint".toTemplateFunction([null, "stats"]),
			"datapointover".toTemplateFunction([null, "stats"]),
			"datapointverticaloffset".toFloat(),
			"datapointoutline".toBool(),
			"datapointshadow".toBool(),
		];
	}
}