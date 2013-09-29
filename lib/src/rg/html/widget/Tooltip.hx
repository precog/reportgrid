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
package rg.html.widget;

import js.html.Element;
import dhx.Selection;

class Tooltip
{
	@:isVar public static var instance(get, null) : Tooltip;
	static function get_instance()
	{
		if(null == instance)
		{
			instance = new Tooltip();
			(untyped __js__("ReportGrid")).tooltip = instance;
		}
		return instance;
	}
	static inline var DEFAULT_DISTANCE = 0;
	static inline var DEFAULT_ANCHOR = "bottomright";
	var tooltip : Selection;
	var _anchor : Selection;
	var container : Selection;
	var background : Selection;
	var content : Selection;

	var anchortype : String;
	var anchordistance : Int;

	public var visible(default, null) : Bool;
	public function new(?el : Element)
	{
		visible = false;
		el = null == el ? js.Browser.document.body : el;
		tooltip = dhx.Dom.selectNode(el).append("div")
			.style("display").string("none")
			.style("position").string("absolute")
			.style("opacity").float(0)
			.style("left").string("0px")
			.style("top").string("0px")
			.attr("class").string("rg tooltip")
			.style("z-index").string("1000000")
		;

		_anchor = tooltip.append("div")
			.style("display").string("block")
			.style("position").string("absolute");
		setAnchorClass("");

		container = tooltip.append("div")
			.style("position").string("relative")
			.attr("class").string("rg_container")
		;

		background = container.append("div")
			.style("display").string("block")
			.style("position").string("static")
			.append("div")
				.style("z-index").string("-1")
				.attr("class").string("rg_background")
				.style("position").string("absolute")
				.style("left").string("0")
				.style("right").string("0")
				.style("top").string("0")
				.style("bottom").string("0");
		content = container.append("div")
			.attr("class").string("rg_content");
		content
			.onNode("DOMSubtreeModified", resize);

		anchortype     = DEFAULT_ANCHOR;
		anchordistance = DEFAULT_DISTANCE;
	}

	public function html(value : String)
	{
		content.node().innerHTML = value;
		reanchor();
	}

	public function show()
	{
		if(visible)
			return;
		tooltip.style("display").string("block");
		visible = true;
		reanchor();
		tooltip.style("opacity").float(1);
	}

	public function hide()
	{
		if(!visible)
			return;
		visible = false;
		tooltip
			.style("opacity").float(0)
			.style("display").string("none");
	}

	public function showAt(x : Int, y : Int)
	{
		moveAt(x, y);
		show();
	}

	public function moveAt(x : Int, y : Int)
	{
		tooltip
			.style("left").string(x+"px")
			.style("top").string(y+"px");
	}

	public function anchor(type : String, ?distance : Int)
	{
		if(null == distance)
			distance = DEFAULT_DISTANCE;
		if(anchortype == type && anchordistance == distance)
			return;
		anchortype = type;
		anchordistance = distance;
		reanchor();
	}

	public function setAnchorClass(value : String)
	{
		_anchor.attr("class").string("rg_anchor "+value);
	}

	public function setAnchorColor(color : Null<String>)
	{
		_anchor.style("background-color").string(color);
	}

	function resize(_, _)
	{
		reanchor();
	}

	function reanchor()
	{
		if(!visible)
			return;
		var width  = container.style("width").getFloat(),
			height = container.style("height").getFloat();

		var type = anchortype;
		// x
		switch (type)
		{
			case 'top', 'bottom', 'center':
				container.style("left").string((-width/2) +"px");
			case 'left', 'topleft', 'bottomleft':
				container.style("left").string((anchordistance) +"px");
			case 'right', 'topright', 'bottomright':
				container.style("left").string((-anchordistance-width) +"px");
			default:
				throw new thx.error.Error('invalid anchor point: $anchortype');
		}

		// y
		switch (type)
		{
			case 'top', 'topleft', 'topright':
				container.style("top").string((anchordistance) +"px");
			case 'left', 'center', 'right':
				container.style("top").string((-height/2) +"px");
			case 'bottom', 'bottomleft', 'bottomright':
				container.style("top").string((-anchordistance-height) +"px");
		}
	}
}