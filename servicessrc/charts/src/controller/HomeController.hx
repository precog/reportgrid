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
import model.ConfigGateway;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ContentResult;

class HomeController extends Controller
{
    var config : ConfigGateway;
	public function new(config : ConfigGateway)
	{
		super();
        this.config = config;
	}
    public function index(?auth : String)
    {
        return new ContentResult(new template.Home().execute({
        	baseurl : App.baseUrl(),
        	url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
            sampleuid : config.getSampleUID(),
            version : App.version,
            authorized : App.AUTH == auth,
            auth : auth
        }));
    }
}