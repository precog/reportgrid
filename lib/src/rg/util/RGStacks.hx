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

package rg.util;
using Arrays;

class RGStacks 
{
	static var PATTERN_IS_CONSTRUCTOR = ~/^new@(\d+)/;
	static var PATTERN_CONTAINS_AT = ~/^([^@]+)@(\d+)/;
	public static function exceptionStack(skip = 1) : Array<String>
	{
		var stack = haxe.Stack.exceptionStack();
		for(i in 0...skip)
			stack.pop();
		var skip = null;
		return stack.map(function(item, _) {
			switch(item)
			{
				case CFunction:
					return "#cfunction";
				case Module( m ):
					return "#module " + m;
				case FilePos( s, file, line ):
					return "#filepos " + file + " at " + line;
				case Method(classname, method):
					if (null != skip)
					{
						if (skip == classname + "." + method)
							return skip = null;
						else
							skip = null;
					}
					if (classname == "js.Boot" && StringTools.startsWith(method, "__closure"))
						return "in [closure]";
					var line = "";
					if (PATTERN_IS_CONSTRUCTOR.match(method))
					{
						method = "new";
						line = PATTERN_IS_CONSTRUCTOR.matched(1);
					} else if (PATTERN_CONTAINS_AT.match(method))
					{
						method = PATTERN_CONTAINS_AT.matched(1);
						line = PATTERN_CONTAINS_AT.matched(2);
						skip = classname + "." + method;
					}
					return "in " + classname + "." + method + "("+line+")";
				case Lambda( v ):
					return "#lambda #" + v;
			}
		}).filter(function(d) return null != d);
	}
}