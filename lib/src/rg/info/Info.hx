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

package rg.info;
import thx.error.AbstractMethod;
import thx.error.Error;
import thx.util.Message;
using rg.info.filter.FilterDescription;

@:keep class Info
{
	public static function feed<T>(info : T, ob : { }) : T
	{
		if(null == ob)
			return info;
		var cl = Type.getClass(info),
			method = Reflect.field(cl, "filters");
		if (null == method)
			return info;
		var descriptions : Array<FilterDescription> = Reflect.callMethod(cl, method, []),
			value;
		for(description in descriptions) {
			if(Reflect.hasField(ob, description.name))
			{
				value = Reflect.field(ob, description.name);
				switch (description.transformer.transform(value)) {
					case Success(pairs):
						for(pair in pairs)
						{
							Reflect.setField(info, pair.name, pair.value);
						}
					case Failure(reasons): // Array<thx.util.Message>
						warn(description.name, reasons);
				}
			}
		}
		return info;
	}

	static function warn(name : String, message : Message) {
		warner('the parameter $name has not been applied because: $message');
	}

	static var warner =
#if debug
		function(m : Dynamic) {
			haxe.Log.trace("WARN: " + m);
		}
#else
		{
			if(untyped __js__("window.console && window.console.warn"))
			{
				function(m : Dynamic)
				{
					untyped console.warn("" + m);
				}
			} else {
				function(m : Dynamic) { }
			}
		};
#end
}