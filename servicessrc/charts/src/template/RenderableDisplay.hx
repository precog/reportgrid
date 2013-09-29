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
package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("renderabledisplay.html")
class RenderableDisplay extends Template<{
	baseurl : String,
	url : UrlHelperInst,
	data : RenderableInfo,
	milliToString : Float -> Bool -> String,
	reflectField : Dynamic -> Dynamic -> Dynamic
}>
{ }

typedef RenderableInfo = {
	uid   : String,
	createdOn : Date,
	expiresOn : Null<Date>,
	cacheExpirationTime : Float,
	formats : Array<String>,
	preserveTimeAfterLastUsage : Float,
	service : {
		?pdf  : String,
		?ps   : String,
		?png  : String,
		?jpg  : String,
		?html : String,
		?svg  : String,
		?bmp  : String,
		?tif  : String
	}
}