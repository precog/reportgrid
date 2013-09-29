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

package rg.factory;
import rg.info.InfoVariable;
import rg.axis.AxisTime;
import rg.axis.AxisGroupByTime;
import rg.axis.IAxis;
import rg.axis.Stats;
import rg.data.VariableIndependent;
import thx.date.DateParser;
import thx.error.Error;
import rg.util.Periodicity;

class FactoryVariableIndependent
{
	public function new() { }

	public function create(info : InfoVariable) : VariableIndependent<Dynamic>
	{
		if (null == info.type)
			return null;
		var axiscreateer = new FactoryAxis(),
			variable = new VariableIndependent(info.type, info.scaleDistribution),
			axis = axiscreateer.createDiscrete(info.type, cast variable, info.values, info.groupBy);
		variable.setAxis(axis);
		variable.minf = convertBound(axis, info.min);
		variable.maxf = convertBound(axis, info.max);
		return variable;
	}

	public static function convertBound(axis : IAxis<Dynamic>, value : Dynamic) : Stats<Dynamic> -> Dynamic -> Dynamic
	{
		if (null == value || Reflect.isFunction(value))
			return value;
		if (Std.is(axis, AxisTime))
		{
			if (Std.is(value, Date))
				value = cast(value, Date).getTime();
			if (Std.is(value, Float))
				return function(_, _) return value;
			if (Std.is(value, String))
				return function(_, _) return DateParser.parse(value).getTime();
			throw new Error("invalid value '{0}' for time bound", [value]);
		}
		return function(_, _) return value;
	}
}