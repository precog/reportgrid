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

package rg.visualization;

import thx.error.Error;
import dhx.Selection;
import rg.layout.Layout;

class Visualizations
{
	public static var html = ["pivottable", "leaderboard"];
	public static var svg = ["barchart", "geo", "funnelchart", "heatgrid", "linechart", "piechart", "scattergraph", "streamgraph", "sankey"];
	public static var visualizations = svg.concat(html);
	public static var layouts = ["simple", "cartesian", "x"];
	public static var layoutDefault : Map<String, String>;
	public static var layoutType : Map<String, Class<Dynamic>>;
	public static var layoutArgs : Map<String, Array<Dynamic>>;

	public static function instantiateLayout(name : String, width : Int, height : Int, container : Selection) : Layout
	{
		return Type.createInstance(layoutType.get(name), [width, height, container]);
	}

	static function __init__()
	{
		layoutDefault = new Map ();
		layoutType = new Map ();
		layoutArgs = new Map ();

		layoutDefault.set("barchart",	  "cartesian");
		layoutDefault.set("funnelchart",  "simple");
		layoutDefault.set("geo",		  "simple");
		layoutDefault.set("heatgrid",	  "cartesian");
		layoutDefault.set("linechart",	  "cartesian");
		layoutDefault.set("piechart",	  "simple");
		layoutDefault.set("sankey",	  "simple");
		layoutDefault.set("scattergraph", "cartesian");
		layoutDefault.set("streamgraph",  "x");

		layoutType.set("cartesian", rg.layout.LayoutCartesian);
		layoutType.set("simple",    rg.layout.LayoutSimple);
		layoutType.set("x",         rg.layout.LayoutX);
	}
}