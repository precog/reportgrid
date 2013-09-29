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

package rg.html.widget;
import js.Browser;
import dhx.Dom;
import dhx.Selection;

class DownloaderMenu
{
	static var DEFAULT_FORMATS = ["png", "jpg", "pdf"];
	static var DEFAULT_TITLE = "Download";
	var handler : String -> Null<String> -> (String -> Bool) -> (String -> Void) -> Void;
	var formats : Array<String>;
	var title : String;
	var backgroundColor : String;
	var menu : Selection;
	public function new(handler : String -> Null<String> -> (String -> Bool) -> (String -> Void) -> Void, position : DownloaderPosition, formats : Array<String>, container : Selection)
	{
		this.handler = handler;
		this.formats = null == formats ? DEFAULT_FORMATS : formats;
		this.title = DEFAULT_TITLE;
		build(position, container);
	}

	function build(position : DownloaderPosition, container : Selection)
	{
		createMenu(container);
		var el = menu.node();
		switch(position)
		{
			case After:
				container.node().parentNode.insertBefore(el, container.node().nextSibling);
			case Before:
				container.node().parentNode.insertBefore(el, container.node());
			case BottomLeft:
				menu.classed().add("bottom").classed().add("left");
			case BottomRight:
				menu.classed().add("bottom").classed().add("right");
			case ElementSelector(selector):
				Dom.select(selector).node().appendChild(el);
			case TopLeft:
				menu.classed().add("top").classed().add("left");
			case TopRight:
				menu.classed().add("top").classed().add("right");
		}
	}

	function createMenu(container : Selection)
	{
		menu = container.append("div")
			.attr("class").string("rg menu")
//			.attr("style").string("border:1px solid red;width:20px;height:20px")
		;

		var options = menu.append("div")
			.attr("class").string("options");

		var title = options.append("div")
			.attr("class").string("title")
			.html().string(title)
//			.attr("style").string("border:1px solid green;width:20px;height:20px")
			;
		var list = options.append("ul").selectAll("li").data(formats);
		list.enter()
			.append("li")
			.on("click.download", click)
			.html().stringf(function(d, i) return d);
	}

	function click(format, _)
	{
		menu.classed().add("downloading");
//		haxe.Timer.delay(function() menu.classed().remove("downloading"), 3000);
		handler(
			format,
			backgroundColor,
			function(_) {
				menu.classed().remove("downloading");
				return true;
			},
			function(e) {
				menu.classed().remove("downloading");
				js.Browser.window.alert("ERROR: " + e);
			}
		);
	}
}