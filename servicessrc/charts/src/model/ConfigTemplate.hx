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
package model;

import thx.collection.Set;
using Arrays;

class ConfigTemplate
{
	var params : Set<String>;
	var allowedValues : Map<String, Array<Dynamic>>;
	var defaults : Map<String, Dynamic>;
	public function new()
	{
		params = new Set();
		allowedValues = new Map ();
		defaults = new Map ();
	}

	public function addParameter(name : String, ?values : Array<Dynamic>)
	{
		params.add(name);
		if(null != values)
			allowedValues.set(name, values);
	}

	public function isValid(name : String, value : Dynamic)
	{
		var values = allowedValues.get(name);
		if(null == values)
			return true;
		return values.exists(value);
	}

	public function setDefault(name : String, value : Dynamic)
	{
		defaults.set(name, value);
	}

	public function getDefault(name : String)
	{
		return defaults.get(name);
	}

	public function replaceables()
	{
		var list = params.array();
		list.sort(function(a, b) {
			var c = b.length - a.length;
			if(c != 0)
				return c;
			return Strings.compare(a, b);
		});
		return list;
	}

	public function toString()
	{
		return "ConfigTample: " + ConfigObjects.fieldsToString(this);
	}
}