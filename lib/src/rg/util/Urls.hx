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

class Urls 
{
	public static function addQueryParameters(url : String, query : {}) : String
	{
#if reportgridapi
		return untyped __js__("ReportGrid.$.Util.addQueryParameters")(url,query);
#else
		var suffix  = url.indexOf('?') < 0 ? '?' : '&',
			queries = [];
		for(key in Reflect.fields(query))
		{
			var value = Std.string(Reflect.field(query, key));
			queries.push(key + "=" + StringTools.urlEncode(value));
		}
		if(queries.length == 0)
			return url;
		else
			return url + suffix + queries.join("&");
#end
	}

	public static function parseQueryParameters(url : String) : Dynamic
	{
#if reportgridapi
		return untyped __js__("ReportGrid.$.Util.parseQueryParameters")(url);
#else
		var index = url.indexOf('?');

		if (index < 0)
			return {};

		var query = url.substr(index + 1),
			keyValuePairs = query.split('&'),
			parameters : Dynamic = {};

		for(pair in keyValuePairs)
		{
			var split = pair.split("="),
				key = split[0],
				value = null == split[1] ? null : StringTools.urlDecode(split[1]);
			Reflect.setField(parameters, key, value);
		}
		return parameters;
#end
	}
}