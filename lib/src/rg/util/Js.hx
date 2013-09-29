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
package rg.util;

import js.html.Element;

class Js
{
	/**
	* fragment can be both a String or a JS regular expression
	*/
	public static function findScript(fragment : Dynamic)
	{
#if reportgridapi
		return untyped __js__("ReportGrid.$.Util.findScript")(fragment);
#else
		var scripts = js.Browser.document.getElementsByTagName('SCRIPT');
		if(untyped __js__('typeof fragment == "string"'))
		{
			for (i in 0...scripts.length)
			{
				var script : js.html.ScriptElement = cast scripts[i],
					src : String = script.getAttribute('src');
				if (null != src && src.indexOf(fragment) >= 0)
					return script;
			}
		} else {
			for (i in 0...scripts.length)
			{
				var script : js.html.ScriptElement = cast scripts[i],
					src : String = script.getAttribute('src');
				if (null != src && untyped src.match(fragment))
					return script;
			}
		}

		return null;
#end
	}

	public static function findPosition(el : Element)
	{
		var x = 0, y = 0, obj = el;
		do {
			x += obj.offsetLeft;
			y += obj.offsetTop;
		} while(null != (obj = obj.offsetParent));
		return {
			x : x,
			y : y
		}
	}
}