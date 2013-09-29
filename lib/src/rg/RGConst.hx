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

package rg;

class RGConst
{
//	public static var SERVICE_VISTRACK_HASH = "http://devapp01.reportgrid.com:30050/auditPath?tokenId={$token}";
#if release
	// TODO: add HTTPS!
	public static var BASE_URL_GEOJSON = "https://api.reportgrid.com/geo/json/";
	public static var SERVICE_RENDERING_STATIC = "https://api.reportgrid.com/services/viz/charts/up.json";
	public static var LEGACY_RENDERING_STATIC  = "https://api.reportgrid.com/services/viz/charts/upandsee.{ext}";
#else
	static var HOST = "" == js.Browser.window.location.host ? "localhost" : js.Browser.window.location.host;
	public static var BASE_URL_GEOJSON = "http://"+HOST+"/rg/charts/geo/json/";
	public static var SERVICE_RENDERING_STATIC = "http://"+HOST+"/rg/services/viz/charts/up.json";
//	public static var LEGACY_RENDERING_STATIC  = "http://"+HOST+"/rg/services/viz/charts/upandsee.{ext}";
	public static var LEGACY_RENDERING_STATIC  = "https://api.reportgrid.com/services/viz/charts/upandsee.{ext}";
#end
}