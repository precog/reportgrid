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
package controller;

import erazor.macro.Template;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ActionResult;
import ufront.web.mvc.ContentResult;
import ufront.web.mvc.JsonPResult;
import ufront.web.mvc.view.UrlHelper;

class BaseController extends Controller
{
	public var urlHelper(get, null) : UrlHelperInst;
	function get_urlHelper()
	{
		if(null == urlHelper)
		{
			urlHelper = new UrlHelperInst(controllerContext.requestContext);
		}
		return urlHelper;
	}

	function error(message : String, format : String)
	{
		return output({ error : message }, format, template.Error);
	}

	function output<T>(data : T, format : String, templateClass : Class<Dynamic>) : ActionResult
	{
		format = normalizeFormat(format);
		switch (format) {
			case "html":
				var template : Template<{ url : ufront.web.mvc.view.UrlHelperInst, data : T, baseurl : String, milliToString : Float -> String, reflectField : Dynamic -> Dynamic -> Dynamic }> = Type.createInstance(templateClass, []);
				var content = {
					baseurl : App.baseUrl(),
					url : urlHelper,
					data : data,
					milliToString : thx.date.Milli.toString,
					reflectField : Reflect.field
				};
				return new ContentResult(untyped template.execute(content));
			case "json":
				return JsonPResult.auto(data, controllerContext.request.query.get("callback"));
			default:
				return throw new thx.error.Error("invalid format '{0}'", [format]);
		}
	}

	function normalizeFormat(f : String)
	{
		f = f.toLowerCase();
		return switch(f) {
			case 'html', 'json': f;
			default : 'html';
		}
	}
}