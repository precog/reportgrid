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

package rg.svg.util;
import thx.svg.Symbol;

class SymbolCache
{
	static inline var DEFAULT_SYMBOL = "circle";
	public static var cache(default, null) : SymbolCache;

	var c : Map<String, String>;
	var r : Int;
	public function new()
	{
		c = new Map ();
		r = 0;
	}

	public function get(type : String, size = 100)
	{
#if debug
		r++;
#end
		var k = type + ":" + size,
			s = c.get(k);
		if (null == s)
		{
			s = Reflect.field(Symbol, type)(size);
			c.set(k, s);
		}
		return s;
	}

	public function stats()
	{
		return {
			cachedSymbols : Iterators.array(c.iterator()).length
#if debug
			, requests : r
#end
		};
	}

	static function __init__()
	{
		cache = new SymbolCache();
	}
}