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
package rg.info.filter;

using Arrays;

class PairTransformer implements ITransformer<Dynamic, Pairs>
{
	var names : Array<String>;
	var valueTransformer : ITransformer<Dynamic, Dynamic>;
	public function new(names : Array<String>, valueTransformer : ITransformer<Dynamic, Dynamic>)
	{
		this.names = names;
		this.valueTransformer = valueTransformer;
	}

	public function transform(value : Dynamic) : TransformResult<Pairs>
	{
		switch(valueTransformer.transform(value))
		{
			case Success(v):
				return TransformResult.Success(new Pairs(names, names.map(function(_) return v)));
			case Failure(reason):
				return TransformResult.Failure(reason);
		}
	}
}