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
import rg.axis.AxisGroupByTime;
import rg.axis.AxisOrdinalFixedValues;
import rg.axis.AxisOrdinalStats;
import rg.axis.AxisNumeric;
import rg.axis.AxisTime;
import rg.axis.IAxis;
import rg.axis.IAxisDiscrete;
import rg.util.Properties;
import rg.data.Variable;
import thx.error.Error;

class FactoryAxis
{
	public function new() { }

	public function create(type : String, isnumeric : Null<Bool>, variable : Variable<Dynamic, IAxis<Dynamic>>, samples : Null<Array<Dynamic>>) : IAxis<Dynamic>
	{
		if (null != samples && samples.length > 0)
		{
			return new AxisOrdinalFixedValues(samples);
		} else if(true == isnumeric) {
			return new AxisNumeric();
		} else if(false == isnumeric) {
			return new AxisOrdinalStats(variable);
		} else {
			return null;
		}
	}

	public function createDiscrete(type : String, variable : Variable<Dynamic, IAxis<Dynamic>>, samples : Array<Dynamic>, groupBy : Null<String>) : IAxisDiscrete<Dynamic>
	{
		if (Properties.isTime(type))
		{
			if (null != groupBy)
				return new AxisGroupByTime(Properties.periodicity(type));
			else
				return new AxisTime(Properties.periodicity(type));
		} else if (null != samples && samples.length > 0)
		{
			return new AxisOrdinalFixedValues(samples);
		}
			return new AxisOrdinalStats(variable);
	}
}