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

package rg.svg.layer;
import rg.svg.panel.Layer;
import dhx.Selection;
import rg.layout.Anchor;
import rg.svg.panel.Panel;
import rg.svg.widget.Label;
import rg.svg.widget.LabelOrientation;
import rg.svg.widget.GridAnchor;

class Title extends Layer
{
	public var text(get, set) : String;
	public var anchor(default, set) : Anchor;
	public var padding(default, set) : Int;

	var label : Label;
	var group : Selection;
//	var nodeText : Selection;
//	var nodeGroup : Selection;

	public function new(panel : Panel, text : String, anchor : Anchor, padding = 1, className = "title", shadow = false, outline = false)
	{
		super(panel);
		this.addClass(className);
		group = g.append("svg:g");
		label = new Label(group, false, shadow, outline);
		label.orientation = LabelOrientation.Orthogonal;

//		nodeGroup = g.append("svg:g");
//		nodeText = nodeGroup.append("svg:text")
//			.attr("text-anchor").string("middle");
		this.anchor = anchor;
		this.padding = padding;
		this.text = text;

		resize();
	}

	public function idealHeight() : Int
	{
		var size = label.getSize();
		return Math.round(switch(anchor)
		{
			case Left, Right: size.width + padding;
			case Top, Bottom: size.height + padding;
		});
//		if (Strings.empty(text))
//			return 0;
//		var bbox : { height : Float } = untyped nodeText.node().getBBox();
//		return Math.round(bbox.height);
	}

	override function resize()
	{
//		if (null == nodeText || null == anchor || null == width || padding == null)
//			return;
		if (null == anchor || null == width || padding == null)
			return;
		switch(anchor)
		{
			case Top:    group.attr("transform").string("translate(" + (width / 2) + "," + padding + ")");
			case Right:  group.attr("transform").string("translate(" + (width - padding) + "," + (height / 2) + ")");
			case Left:   group.attr("transform").string("translate(" + (padding) + "," + (height / 2) + ")");
			case Bottom: group.attr("transform").string("translate(" + (width / 2) + "," + (height - padding) + ")");
		}

/*
		switch(anchor)
		{
			case Top:
				nodeText.attr("transform").string("rotate(0)")
					.attr("dominant-baseline").string("hanging");
				nodeGroup
					.attr("transform").string("translate(" + (width / 2) + "," + padding + ")")
				;
			case Right:
				nodeText.attr("transform").string("rotate(-90)")
					.attr("dominant-baseline").string("baseline");
				nodeGroup
					.attr("transform").string("translate(" + (width - padding) + "," + (height / 2) + ")")
				;
			case Left:
				nodeText.attr("transform").string("rotate(90)")
					.attr("dominant-baseline").string("baseline");
				nodeGroup
					.attr("transform").string("translate(" + (padding) + "," + (height / 2) + ")")
				;
			case Bottom:
				nodeText.attr("transform").string("rotate(0)")
					.attr("dominant-baseline").string("baseline");
				nodeGroup
					.attr("transform").string("translate(" + (width / 2) + "," + (height - padding) + ")")
				;
		}
*/
	}

	function get_text() return label.text;

	function set_text(v : String)
	{
		return label.text = v;
//		this.text = v;
//		if(null != nodeText)
//			nodeText.text().string(text);
//		return v;
	}

	function set_anchor(v : Anchor)
	{

		switch(this.anchor = v)
		{
			case Top:    label.anchor = GridAnchor.Top;
			case Bottom: label.anchor = GridAnchor.Bottom;
			case Left:   label.anchor = GridAnchor.Bottom;
			case Right:  label.anchor = GridAnchor.Bottom;
		}
		return v;
//		label.anchor
//		this.anchor = v;
//		resize();
//		return v;
	}

	function set_padding(v : Int)
	{
		this.padding = v;
		switch(anchor)
		{
			case Top:    label.place(0, 0, 90);
			case Bottom: label.place(0, 0, 90);
			case Left:   label.place(0, 0, 180);
			case Right:  label.place(0, 0, 0);
		}
//		label.place(
//		resize();
		return v;
	}
}