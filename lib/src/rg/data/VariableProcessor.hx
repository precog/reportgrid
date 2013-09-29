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

package rg.data;
import hxevents.Dispatcher;
import rg.factory.FactoryAxis;
import rg.util.DataPoints;
import rg.axis.Stats;
using Arrays;

class VariableProcessor
{
	public var source(default, null) : IDataSource;

	public var onData(default, null) : Dispatcher<Array<Dynamic>>;
	public var independentVariables : Array<VariableIndependent<Dynamic>>;
	public var dependentVariables : Array<VariableDependent<Dynamic>>;

	public function new(source : IDataSource)
	{
		this.source = source;
//		source.onLoading.add(preprocess);
		source.onLoad.add(process);
		onData = new Dispatcher();
	}

	public function load()
	{
		source.load();
	}

	function process(data : Array<Dynamic>)
	{
		trace(data);
		fillIndependentVariables(data);
		fillDependentVariables(data);
		onData.dispatch(data);
	}

	function fillDependentVariables(data : Array<Dynamic>)
	{
		for (variable in dependentVariables)
		{
			var values = DataPoints.values(data, variable.type);
			if (values.length == 0)
				continue;
			if (null == variable.axis)
			{
				variable.setAxis(new FactoryAxis().create(
					variable.type,
					Std.is(values[0], Float),
					variable,
					null
				));
			}
			variable.stats.addMany(values);

			var discrete : IAxisDiscrete;
			if (null != variable.scaleDistribution && null != (discrete = Types.as(variable.axis, IAxisDiscrete)))
			{
				discrete.scaleDistribution = variable.scaleDistribution;
				variable.scaleDistribution = null; // reset to avoid multiple assign
			}
		}
	}

	function fillIndependentVariables(flatten : Array<Dynamic>)
	{
		for (variable in independentVariables)
		{
			variable.stats.addMany(DataPoints.values(flatten, variable.type));
			var discrete : IAxisDiscrete;
			if (null != variable.scaleDistribution && null != (discrete = Types.as(variable.axis, IAxisDiscrete)))
			{
				discrete.scaleDistribution = variable.scaleDistribution;
				variable.scaleDistribution = null; // reset to avoid multiple assign
			}
		}
	}
}