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

import rg.util.Periodicity;
import rg.axis.ScaleDistribution;
import rg.axis.Stats;
using rg.info.filter.FilterDescription;
import rg.info.filter.TransformResult;
import thx.util.Message;
using Arrays;

@:keep class InfoVariable extends Info
{
	public var type : Null<String>;
	public var min : Null<Dynamic>;
	public var max : Null<Dynamic>;
	public var values : Null<Array<Dynamic>>;
	public var groupBy : Null<String>;
	public var variableType : VariableType;
	public var scaleDistribution : Null<ScaleDistribution>;

	public function new()
	{
		variableType = Unknown;
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"type".toStr(),
			"view".custom(["min"], function(value : Dynamic) {
				if(!Std.is(value, Array) || !testViewValue(value[0]))
					return TransformResult.Failure(new Message("value is expected to be an array of two items but is '{0}'", [value]));
				else
					return TransformResult.Success(value[0]);
			}),
			"view".custom(["max"], function(value : Dynamic) {
				if(!Std.is(value, Array) || !testViewValue(value[1]))
					return TransformResult.Failure(new Message("value is expected to be an array of two items but is '{0}'", [value]));
				else
					return TransformResult.Success(value[1]);
			}),
			"values".toArray(),
			"values".custom(["min"], function(value : Dynamic) {
				if(!Std.is(value, Array))
					return TransformResult.Failure(new Message("values is expected to be an array"));
				else
					return TransformResult.Success(value[0]);
			}),
			"values".custom(["max"], function(value : Dynamic) {
				if(!Std.is(value, Array))
					return TransformResult.Failure(new Message("values is expected to be an array"));
				else {
					var arr = cast(value, Array<Dynamic>);
					return TransformResult.Success(arr[arr.length - 1]);
				}
			}),
			"groupby".custom(["groupBy"], function(value : Dynamic) {
				if(!Std.is(value, String) || !Periodicity.isValidGroupBy(value))
					return TransformResult.Failure(new Message("value is expected to be a valid string periodicity but is '{0}'", [value]));
				else
					return TransformResult.Success(value);
			}),
			"variable".custom(["variableType"], function(value : Dynamic) {
				var v = null == value ? null : (""+value).toLowerCase();
				if(!["independent", "dependent"].exists(v))
					return TransformResult.Failure(new Message("value is expected to be an 'independent' or 'dependent' but is '{0}'", [value]));
				else
					return TransformResult.Success(Type.createEnum(VariableType, Strings.ucfirst(v.toLowerCase()), []));
			}),
			"scalemode".toTry(["scaleDistribution"], function(value : Dynamic) {
				return Type.createEnum(ScaleDistribution, "Scale" + Strings.ucfirst(("" + value).toLowerCase()), []);
			}, "value is expected to be a valid scale distribution value but is '{0}'")
		];
	}

	static function testViewValue(v : Dynamic)
	{
		return v == null || Types.isPrimitive(v) || Std.is(v, Date) || Reflect.isFunction(v);
	}
}

enum VariableType
{
	Unknown;
	Independent;
	Dependent;
}