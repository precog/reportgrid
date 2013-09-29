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
import rg.data.VariableDependent;
import thx.error.Error;

class FactoryVariableDependent
{
	public function new() { }

	public function create(info : InfoVariable, isnumeric : Bool) : VariableDependent<Dynamic>
	{
		if (null == info.type)
			throw new Error("cannot create an axis if type is not specified");
		var axiscreator = new FactoryAxis(),
			variable = new VariableDependent(info.type, info.scaleDistribution),
			axis = axiscreator.create(info.type, isnumeric, variable, info.values);
		variable.setAxis(axis);
		variable.minf = FactoryVariableIndependent.convertBound(axis, info.min);
		variable.maxf = FactoryVariableIndependent.convertBound(axis, info.max);
		return variable;
	}
}