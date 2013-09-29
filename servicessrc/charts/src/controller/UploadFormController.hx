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
import ufront.web.mvc.ContentResult;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ActionResult;

class UploadForm extends Controller
{
	public function display(?html : String, ?config : String, displayFormat : String = null) : Dynamic
	{
		var ob = {
        	baseurl : App.baseUrl(),
			url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
			html : html,
			config : config,
			errors : new Map (),
			displayFormat : displayFormat
		};
		if(this.controllerContext.request.httpMethod == "POST")
		{
			var haserrors = false;
			if(null == html || '' == (html = StringTools.trim(html)))
			{
				haserrors = true;
				ob.errors.set("html", "html cannot be left empty");
			} else if(html.toLowerCase().indexOf("reportgrid") < 0) {
				haserrors = true;
				ob.errors.set("html", "html does not contain any reference to reportgrid");
			}
			if(null != config && config != '')
			{
				config = StringTools.trim(config);
				try {
					thx.ini.Ini.decode(config);
				} catch(e : Dynamic)
				{
					haserrors = true;
					ob.errors.set("config", "the config file is not well formed: " + e);
				}
			}
			if(!haserrors)
			{
				var controller = ufront.web.mvc.DependencyResolver.current.getService(controller.RenderableAPIController);
				controller.controllerContext = this.controllerContext;
				if(null != displayFormat)
				{
					return controller.uploadAndDisplay(html, config, displayFormat);
				} else {
					return controller.upload(html, config, 'html');
				}
			}
		} else {
			if(null == html && null == config)
			{
				ob.html   = model.Sample.html;
				ob.config = model.Sample.config;
			}
		}
		return new ContentResult(new template.FormUpload().execute(ob));
	}

	var lastError : String;
	public function gist(?gistid : String)
	{
		var id = validateGist(gistid);
		if(null != id)
		{
			var controller = ufront.web.mvc.DependencyResolver.current.getService(controller.GistUploadController);
			controller.controllerContext = this.controllerContext;
			return controller.importGist(id, "html");
		} else {
			var ob = {
	        	baseurl : App.baseUrl(),
	        	error : lastError,
				url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
				gistid : gistid
			};
			return new ContentResult(new template.GistUpload().execute(ob));
		}
	}

	function validateGist(id : String)
	{
		if(null == id || id == '')
			return null;
		if(id.substr(0, 8) == 'https://' || id.substr(0, 7) == 'http://')
			id = id.split("/").pop();
		var des = controller.GistUploadController.getGistDescription(id);
		if(null != des.error)
		{
			lastError = des.error;
			return null;
		}
		else
			return id;
	}
}