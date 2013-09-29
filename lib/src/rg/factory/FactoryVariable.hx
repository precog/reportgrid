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
import rg.util.Properties;
import rg.data.VariableIndependent;
import rg.data.VariableDependent;
import rg.data.Variable;
import rg.axis.IAxis;
import rg.axis.AxisTime;
using Arrays;

class FactoryVariable
{
	var independentFactory : FactoryVariableIndependent;
	var dependentFactory : FactoryVariableDependent;
	public function new()
	{
		independentFactory = new FactoryVariableIndependent();
		dependentFactory = new FactoryVariableDependent();
	}

	public function createVariables(arr : Array<InfoVariable>) : Array<Variable<Dynamic, IAxis<Dynamic>>>
	{
		return arr.map(function(info : InfoVariable) : Variable<Dynamic, IAxis<Dynamic>> {
			switch(info.variableType)
			{
				case Independent:
					return cast independentFactory.create(info);
				case Dependent:
					return dependentFactory.create(info, null);
				case Unknown:
					return dependentFactory.create(info, null);
			}
		});
	}

	public function createIndependents(info : Array<InfoVariable>) : Array<VariableIndependent<Dynamic>>
	{
		var result = [], ordinal, discrete, ctx;
		for (i in info)
		{
			var moveon = switch(i.variableType)
			{
				case Independent: false;
				case Unknown: true;
				default: true;
			}
			if (moveon)
				continue;
			result.push(independentFactory.create(i));
		}
		return result;
	}

	public function createDependents(info : Array<InfoVariable>) : Array<VariableDependent<Dynamic>>
	{
		var result = [], ordinal;
		for (i in info)
		{
			var moveon = switch(i.variableType)
			{
				case Dependent: false;
				case Unknown: false;
				default: true;
			}
			if (moveon)
				continue;
			result.push(dependentFactory.create(i, null/*isnumeric*/));
		}
		return result;
	}
}