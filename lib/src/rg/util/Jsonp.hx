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

import thx.json.Json;

class Jsonp
{
	public static function get<T>(path, success : T -> Void, failure : Null<Int -> String -> Void>, query : {}, headers : {})
	{
		var api : String -> { success : T -> Void, failure : Null<Int -> String -> Void> } -> {} -> {} -> Void =

#if reportgridapi
		untyped __js__("ReportGrid.$.Http.Jsonp.get");
#else
		get_api;
#end
		api(path, { success : success, failure : failure }, query, headers);
	}

	public static function post<T>(path, content : {}, success : T -> Void, failure : Null<Int -> String -> Void>, query : {}, headers : {})
	{
		var api : String -> {} -> { success : T -> Void, failure : Null<Int -> String -> Void> } -> {} -> {} -> Void =
#if reportgridapi
		untyped __js__("ReportGrid.$.Http.Jsonp.post");
#else
		post_api;
#end
		api(path, content, { success : success, failure : failure }, query, headers);
	}

#if !reportgridapi
	static function request_api<T>(method : String, path : String, content : {}, actions : { success : T -> Void, failure : Null<Int -> String -> Void> }, query : {}, headers : {})
	{
		if(null == query) query = {};

		path = Urls.addQueryParameters(path, query);

		if(null == headers) headers = {};
		var success  = actions.success,
			failure  = null == actions.failure ? function(_, _) {} : actions.failure;


		var random = Std.int(Math.random() * 214748363),
			funcName = 'ReportGridChartsJsonpCallback' + random,
			head = untyped js.Browser.document.head;
		if (null == head)
			head = js.Browser.document.getElementsByTagName('head')[0];
		Reflect.setField(js.Browser.window, funcName, function(content, meta) {
			if (untyped meta.status.code == 200 || meta.status.code == "OK") {
				success(content);
			} else {
				failure(meta.status.code, meta.status.reason);
			}
			head.removeChild(js.Browser.document.getElementById(funcName));

			Reflect.setField(js.Browser.window, funcName, untyped __js__("undefined"));
			untyped __js__("try{ delete window[funcName]; }catch(e){}");
		});

		var extraQuery : Dynamic = {};

		extraQuery.method = method;

		if (Reflect.fields(headers).length > 0)
		{
			extraQuery.headers = Json.encode(headers);
		}

		Reflect.setField(extraQuery, "callback", funcName);

		if (content != null)
		{
			extraQuery.content = Json.encode(content);
		}

		var fullUrl = Urls.addQueryParameters(path, extraQuery);

		var script = js.Browser.document.createElement('SCRIPT');

		script.setAttribute('type', 'text/javascript');
		script.setAttribute('src',  fullUrl);
		script.setAttribute('id',   funcName);

		head.appendChild(script);
	}

	static function get_api<T>(path : String, actions : { success : T -> Void, failure : Null<Int -> String -> Void> }, query : {}, headers : {})
	{
		request_api("GET", path, null, actions, query, headers);
	}

	static function post_api<T>(path : String, content : {}, actions : { success : T -> Void, failure : Null<Int -> String -> Void> }, query : {}, headers : {})
	{
		request_api("POST", path, content, actions, query, headers);
	}
#end
}