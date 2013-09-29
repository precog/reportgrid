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

package rg.svg.widget;
import dhx.Selection;
import rg.svg.widget.LabelOrientation;
import rg.svg.widget.GridAnchor;
using Arrays;

class Label
{
	public var text(default, set) : String;
	public var orientation(default, set) : LabelOrientation;
	public var anchor(default, set) : GridAnchor;
	public var x(default, null) : Float;
	public var y(default, null) : Float;
	public var angle(default, null) : Float;
	public var dontFlip(default, null) : Bool;
	public var shadowOffsetX(default, null) : Float;
	public var shadowOffsetY(default, null) : Float;
	public var shadow(default, null) : Bool;
	public var outline(default, null) : Bool;
	public var visible(default, null) : Bool;

	var g : Selection;
	var gshadow : Selection;
	var gtext : Selection;
	var gshadowrot : Selection;
	var ttext : Selection;
	var toutline : Selection;
	var tshadow : Selection;
//	var b : Selection;

	public function new(container : Selection, dontflip = true, shadow : Bool, outline : Bool)
	{
		this.shadow = shadow;
		this.outline = outline;

		g = container.append("svg:g").attr("class").string("label");
		if (shadow)
		{
			gshadow = g.append("svg:g").attr("transform").string("translate(0,0)");
			gshadowrot = gshadow.append("svg:g");
			tshadow = gshadowrot.append("svg:text").attr("class").string("shadow" + (outline ? "" : " nooutline"));
		}

//		b = gtext.append("svg:rect").style("fill").string("none");
//		b.style("stroke").string("#333");

		gtext = g.append("svg:g");
		if(outline)
			toutline = gtext.append("svg:text").attr("class").string("outline" + (shadow ? "" : " noshadow"));
		var cls = ["text"].addIf(!outline, "nooutline").addIf(!shadow, "noshadow");
		ttext = gtext.append("svg:text").attr("class").string(cls.join(" "));

		this.dontFlip = dontflip;
		if (outline)
		{
			setShadowOffset(1, 1.25);
		} else {
			setShadowOffset(0.5, 0.5);
		}
		x = 0;
		y = 0;
		angle = 0;
		orientation = FixedAngle(0);
		anchor = Center;
		visible = true;
	}

	public function show()
	{
		if(visible) return;
		visible = true;
		_toggleVisibility();
	}

	public function hide()
	{
		if(!visible) return;
		visible = false;
		_toggleVisibility();
	}

	function _toggleVisibility()
	{
		g.style("opacity").float(visible ? 1 : 0);
	}

	public function addClass(name : String)
	{
		g.classed().add(name);
	}

	public function removeClass(name : String)
	{
		g.classed().remove(name);
	}

	public function getSize() : { width : Float, height : Float }
	{
		try {
			return untyped g.node().getBBox();
		} catch (e : Dynamic) {
			return { width : 0.0, height : 0.0 };
		}
	}

	public function place(x : Float, y : Float, angle : Float)
	{
		this.x = Math.isNaN(x) ? 0.0 : x;
		this.y = Math.isNaN(y) ? 0.0 : y;
		this.angle = angle % 360;
		if (this.angle < 0)
			this.angle += 360;
		g.attr("transform").string("translate(" + this.x + "," + this.y + ")");
		switch(orientation)
		{
			case FixedAngle(a):
				gtext.attr("transform").string("rotate(" + a + ")");
			case Aligned:
				if (dontFlip && this.angle > 90 && this.angle < 270)
					angle += 180;
				gtext.attr("transform").string("rotate(" + angle + ")");
			case Orthogonal:
				if (dontFlip && this.angle > 180)
					angle -= 180;
				gtext.attr("transform").string("rotate(" + (-90 + angle) + ")");
		}
		if (shadow)
			gshadowrot.attr("transform").string(gtext.attr("transform").get());
		reanchor();
	}

	function setShadowOffset(x : Float, y : Float)
	{
		shadowOffsetX = x;
		shadowOffsetY = y;
		if (shadow)
		{
			gshadow.attr("transform").string("translate("+shadowOffsetX+","+shadowOffsetY+")");
		}
	}

	function set_text(v : String)
	{
		this.text = v;
		if (outline)
			toutline.text().string(v);
		ttext.text().string(v);
		if (shadow)
			tshadow.text().string(v);
		reanchor();
		return v;
	}

	function set_orientation(v : LabelOrientation)
	{
		this.orientation = v;
		place(x, y, angle);
		return v;
	}

	function set_anchor(v : GridAnchor)
	{
		this.anchor = v;
		reanchor();
		return v;
	}

	function getBB() : { width : Float, height : Float }
	{
		var n = ttext.node(),
			h = ttext.style("font-size").getFloat();
		if (null == h || 0 >= h)
		{
			try {
				h = untyped n.getExtentOfChar("A").height;
			} catch(e : Dynamic)
			{
				h = dhx.Dom.selectNode(n).style("height").getFloat();
			}
		}
		var w;
		try {
			w = untyped n.getComputedTextLength();
		} catch(e : Dynamic)
		{
			w = dhx.Dom.selectNode(n).style("width").getFloat();
		}
		return {
			width : w,
			height : h
		}
	}

	function reanchor()
	{
		if (null == anchor)
			return;
		var bb = getBB(),
			x : Float, y : Float;
//		b.attr("width").float(bb.width).attr("height").float(bb.height);
		var a = anchor;
		if (dontFlip)
		{
			switch(orientation)
			{
				case Aligned:
					if (angle > 90 && angle < 270)
					{
						a = switch(a)
						{
							case TopLeft:  BottomRight;
							case Top: Bottom;
							case TopRight: BottomLeft;
							case Left: Right;
							case Center: Center;
							case Right: Left;
							case BottomLeft: TopRight;
							case Bottom: Top;
							case BottomRight: TopLeft;
						}
					}
				case Orthogonal:
					if (angle > 180)
					{
						a = switch(a)
						{
							case TopLeft:  BottomRight;
							case Top: Bottom;
							case TopRight: BottomLeft;
							case Left: Right;
							case Center: Center;
							case Right: Left;
							case BottomLeft: TopRight;
							case Bottom: Top;
							case BottomRight: TopLeft;
						}
					}
				default:
					// do nothing
			}
		}

		switch(a)
		{
			case TopLeft:
				x = 0;
				y = bb.height;
			case Top:
				x = -bb.width / 2;
				y = bb.height;
			case TopRight:
				x = -bb.width;
				y = bb.height;
			case Left:
				x = 0;
				y = bb.height / 2;
			case Center:
				x = -bb.width / 2;
				y = bb.height / 2;
			case Right:
				x = -bb.width;
				y = bb.height / 2;
			case BottomLeft:
				x = 0;
				y = 0;
			case Bottom:
				x = -bb.width / 2;
				y = 0;
			case BottomRight:
				x = -bb.width;
				y = 0;
		}
		if (outline)
			toutline.attr("x").float(x+0.5).attr("y").float(y-1.5);
		ttext.attr("x").float(x + 0.5).attr("y").float(y - 1.5);
		if (shadow)
			tshadow.attr("x").float(x+0.5).attr("y").float(y-1.5);
//		b.attr("x").float(x).attr("y").float(y-bb.height);
	}

	public function destroy()
	{
		g.remove();
	}
}