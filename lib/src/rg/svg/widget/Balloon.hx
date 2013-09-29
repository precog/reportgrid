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
import js.html.Element;
import dhx.Selection;
import dhx.Timer;
import thx.math.Equations;
import thx.math.Ease;
import thx.math.EaseMode;
import thx.svg.Diagonal;
import thx.svg.Symbol;

class Balloon
{
	public var text(default, set) : Array<String>;
	public var x(default, null) : Float;
	public var y(default, null) : Float;
	public var boxWidth(default, null) : Float;
	public var boxHeight(default, null) : Float;
	public var visible(default, null) : Bool;
	public var lineHeight(default, set) : Float;
	public var roundedCorner(default, set) : Float;
	public var paddingHorizontal(default, null) : Float;
	public var paddingVertical(default, null) : Float;
	public var preferredSide(default, set) : Int;
	public var minwidth : Float;
	var labels : Array<Label>;
	var container : Selection;
	var balloon : Selection;
	var frame : Selection;
	var labelsContainer : Selection;
	var connector : Selection;
	var duration : Int;
	var ease : Float -> Float;
	var connectorShapeV : Diagonal<{ x0 : Float, y0 : Float, x1 : Float, y1 : Float }>;
	var connectorShapeH : Diagonal<{ x0 : Float, y0 : Float, x1 : Float, y1 : Float }>;
	@:isVar public var boundingBox(get, set) : { x : Float, y : Float, width : Float, height : Float };
	public function new(container : Selection, bindOnTop = true)
	{
		if (bindOnTop)
		{
			var parent = container.node();
			while (null != parent && parent.nodeName != "svg")
				parent = cast parent.parentNode;
			this.container = null == parent ? container : dhx.Dom.selectNode(parent);
		} else
			this.container = container;
		visible = true;
		duration = 350;
		minwidth = 30;
		preferredSide = 2;
		ease = Ease.mode(EaseMode.EaseOut, Equations.cubic);
		roundedCorner = 5;
		paddingHorizontal = 3.5;
		paddingVertical = 1.5;
		transition_id = 0;

		this.balloon = this.container
			.append("svg:g")
			.attr("pointer-events").string("none")
			.attr("class").string("balloon")
			.attr("transform").string("translate(" + (this.x = 0) + ", " + (this.y = 0) + ")");
		frame = balloon.append("svg:g")
			.attr("transform").string("translate(0, 0)")
			.attr("class").string("frame");
		frame.append("svg:path")
			.attr("class").string("shadow")
			.attr("transform").string("translate(1, 1)")
		;

		connectorShapeV = Diagonal.forObject();
		connectorShapeH = Diagonal.forObject().projection(function(d,i) return [d[1], d[0]]);
		connector = balloon.append("svg:path")
			.attr("class").string("balloon-connector")
			.style("fill").string("none")
			.style("display").string("none")
			.attr("transform").string("translate(0, 0)")
		;
		frame.append("svg:path")
			.attr("class").string("bg")
		;

		labelsContainer = frame.append("svg:g").attr("class").string("labels");
		labels = [];

		var temp = createLabel(0);
		temp.text = "HELLO";
		lineHeight = temp.getSize().height;
		temp.destroy();
	}

	public function addClass(name : String)
	{
		frame.select("path.bg").classed().add(name);
	}

	public function removeClass(name : String)
	{
		frame.select("path.bg").classed().remove(name);
	}

	function createLabel(i : Int)
	{
		var label = new Label(labelsContainer, true, false, false);
		label.addClass("line-" + i);
		label.anchor = GridAnchor.Top;
		label.orientation = LabelOrientation.Orthogonal;
		label.place(0, i * lineHeight, 90);
		return label;
	}

	function set_preferredSide(v : Int)
	{
		preferredSide = Ints.clamp(v, 0, 3);
		redraw();
		return v;
	}

	function set_text(v : Array<String>)
	{
		while (labels.length > v.length)
		{
			var label = labels.pop();
			label.destroy();
		}

		for (i in labels.length ... v.length)
		{
			labels[i] = createLabel(i);
		}

		for (i in 0...v.length)
		{
			labels[i].text = v[i];
		}
		text = v;
		redraw();
		return v;
	}

	function set_lineHeight(v : Float)
	{
		lineHeight = v;
		redraw();
		return v;
	}

	public function setPadding(h : Float, v : Float)
	{
		paddingHorizontal = h;
		paddingVertical = v;
		redraw();
	}

	function set_roundedCorner(v : Float)
	{
		roundedCorner = v;
		redraw();
		return v;
	}

	// TODO when null is passed remove the onresize event listener
	function set_boundingBox(v : { x : Float, y : Float, width : Float, height : Float })
	{
		boundingBox = v;
		redraw();
		return v;
	}

	// TODO add onresize event on container to rescale bounds dinamically
	function get_boundingBox()
	{
		if (null == boundingBox)
		{
			try
			{
				boundingBox = untyped container.node().getBBox();
			} catch (e : Dynamic) {
				return { width : 0.0, height : 0.0, x : 0.0, y : 0.0 };
			}
		}
		return boundingBox;
	}

	var transition_id : Int;
	public function moveTo(x : Float, y : Float, animate = true)
	{
		if (animate)
		{
			var int = Equations.elasticf(),
				tid = ++transition_id,
				ix = Floats.interpolatef(this.x, x, ease),
				iy = Floats.interpolatef(this.y, y, ease);

			Timer.timer(function(t) {
				if (tid != transition_id)
					return true;
				if (t > duration)
				{
					_moveTo(x, y);
					return true;
				}
				_moveTo(ix(t / duration), iy(t / duration) );
				return false;
			}, 0);
		} else {
			if(0 == boxWidth)
				haxe.Timer.delay(_moveTo.bind(x, y), 15);
			else
				_moveTo(x, y);
		}
	}

	function _moveTo(x : Float, y : Float)
	{
		var bb = get_boundingBox(),
			left = bb.x,
			right = bb.x + bb.width,
			top = bb.y,
			bottom = bb.y + bb.height,
			limit = roundedCorner * 2,
			offset = 0.0,
			diagonal = 0; // 0: don't show, 1: vertical, 2: horizontal

		var	tx = 0.0, ty = 0.0, side = preferredSide, found = 1;

		while (found > 0 && found < 5)
		{
			if (x >= right - limit)
			{
				if (y <= top + limit)
				{
					if (x - right < top - y)
					{
						tx = - boxWidth + right - x;
						ty = top - y + roundedCorner;
						side = 0;
						offset = boxWidth - 4 * roundedCorner;
					} else {
						tx = - boxWidth + right - x - roundedCorner;
						ty = top - y;
						side = 1;
						offset = roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				} else if (y >= bottom - limit)
				{
					if (x - right < y - bottom)
					{
						tx = - boxWidth + right - x;
						ty = bottom - y - boxHeight - roundedCorner;
						side = 2;
						offset = boxWidth - 4 * roundedCorner;
					} else {
						tx = - boxWidth + right - x - roundedCorner;
						ty = bottom - y - boxHeight;
						side = 1;
						offset = boxHeight - 3 * roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				}
			} else if (x <= left + limit)
			{
				if (y <= top + limit)
				{
					if (left - x < top - y)
					{
						tx = left - x;
						ty = top - y + roundedCorner;
						side = 0;
						offset = 0;
					} else {
						tx = left - x + roundedCorner;
						ty = top - y;
						side = 3;
						offset = roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				} else if (y >= bottom - limit)
				{
					if (left - x < y - bottom)
					{
						tx = left - x;
						ty = bottom - y - boxHeight - roundedCorner;
						side = 2;
						offset = 0;
					} else {
						tx = left - x + roundedCorner;
						ty = bottom - y - boxHeight;
						side = 3;
						offset = boxHeight - 3 * roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				}
			}
			switch(side)
			{
				case 0:
					if (y + boxHeight + roundedCorner >= bottom)
					{
						side = 2;
						found++;
						continue;
					} else if (x <= left + limit)
					{
						side = 3;
						found++;
						continue;
					} else if (x >= right - limit)
					{
						side = 1;
						found++;
						continue;
					}
					tx = - boxWidth / 2;
					ty = roundedCorner;
					offset = boxWidth / 2 - roundedCorner * 2;
					if (x - boxWidth / 2 <= left)
					{
						var d = left - x + boxWidth / 2;
						offset = Math.max(0, offset - d);
						tx += d;
					} else if (x + boxWidth / 2 >= right)
					{
						var d = right - x - boxWidth / 2;
						offset = Math.min(boxWidth - roundedCorner * 3, offset - d);
						tx += d;
					}
					if (y < top)
					{
						diagonal = 1;
						ty = top - y + roundedCorner;
					}
				case 1:
					if (x - boxWidth - roundedCorner <= left)
					{
						side = 3;
						found++;
						continue;
					} else if (y <= top + limit)
					{
						side = 2;
						found++;
						continue;
					} else if (y >= bottom - limit)
					{
						side = 0;
						found++;
						continue;
					}
					tx = - boxWidth - roundedCorner;
					ty = - boxHeight / 2;
					offset = (boxHeight - roundedCorner * 2) / 2;
					if (y - boxHeight / 2 <= top)
					{
						var d = top - y + boxHeight / 2;
						offset = Math.max(0, offset - d);
						ty += d;
					} else if (y + boxHeight / 2 >= bottom)
					{
						var d = bottom - y - boxHeight / 2;
						offset = Math.min(boxHeight - roundedCorner * 3, offset - d);
						ty += d;
					}
					if (x > right)
					{
						diagonal = 2;
						tx = right - x - boxWidth - roundedCorner;
					}
				case 2:
					if (y - boxHeight - roundedCorner <= top)
					{
						side = 0;
						found++;
						continue;
					} else if (x <= left + limit)
					{
						side = 3;
						found++;
						continue;
					} else if (x >= right - limit)
					{
						side = 1;
						found++;
						continue;
					}
					tx = - boxWidth / 2;
					ty = - boxHeight - roundedCorner;
					offset = boxWidth / 2 - roundedCorner * 2;
					if (x - boxWidth / 2 <= left)
					{
						var d = left - x + boxWidth / 2;
						offset = Math.max(roundedCorner, offset - d);
						tx += d;
					} else if (x + boxWidth / 2 >= right)
					{
						var d = right - x - boxWidth / 2;
						offset = Math.min(boxWidth - roundedCorner * 3, offset - d);
						tx += d;
					}
					if (y > bottom)
					{
						diagonal = 1;
						ty = bottom - y - boxHeight - roundedCorner;
					}
				case 3:
					if (x + boxWidth + roundedCorner >= right)
					{
						side = 1;
						found++;
						continue;
					} else if (y <= top + limit)
					{
						side = 2;
						found++;
						continue;
					} else if (y >= bottom - limit)
					{
						side = 0;
						found++;
						continue;
					}
					tx = roundedCorner;
					ty = - boxHeight / 2;
					offset = (boxHeight - roundedCorner * 2) / 2;
					if (y - boxHeight / 2 <= top)
					{
						var d = top - y + boxHeight / 2;
						offset = Math.max(roundedCorner, offset - d);
						ty += d;
					} else if (y + boxHeight / 2 >= bottom)
					{
						var d = bottom - y - boxHeight / 2;
						offset = Math.min(boxHeight - roundedCorner * 3, offset - d);
						ty += d;
					}
					if (x < left)
					{
						diagonal = 2;
						tx = left - x + roundedCorner;
					}
			}
			found = 0;
		}

		var coords = null, off = 1.0;
		if (0 == diagonal)
		{
			connector.style("display").string("none");
		} else {
			connector.style("display").string("block");
			coords = {
				x0 : off, y0 : off, x1 : off, y1 : off
			};
			switch(side)
			{
				case 0:
					coords.x1 = tx + off + offset + 2 * roundedCorner;
					coords.y1 = ty + off - roundedCorner;
				case 1:
					coords.y1 = tx + off + boxWidth + roundedCorner;
					coords.x1 = ty + off + offset + roundedCorner;
				case 2:
					coords.x1 = tx + off + offset + 2 * roundedCorner;
					coords.y1 = ty + off + boxHeight + roundedCorner;
				case 3:
					coords.y1 = tx + off + - roundedCorner;
					coords.x1 = ty + off + offset + roundedCorner;
			}
		}

		balloon
			.attr("transform").string("translate(" + (this.x = x) + ", " + (this.y = y) + ")");
		frame.attr("transform").string("translate(" + tx + ", " + ty + ")")
			.selectAll("path").attr("d").string(BalloonShape.shape(boxWidth, boxHeight, roundedCorner, roundedCorner, side, offset));

		if (0 != diagonal)
			connector.attr("d").string(side % 2 == 0 ? connectorShapeV.diagonal(coords) : connectorShapeH.diagonal(coords));
	}

	public function show(animate : Bool)
	{
		if (visible)
			return;
		visible = true;
		balloon.style("display").string("block");
		if(animate)
		{
			balloon.transition().attr("opacity").float(1);
		} else {
			balloon.attr("opacity").float(1);
		}
	}

	public function hide(animate=false)
	{
		if (!visible)
			return;
		visible = false;
		if(animate)
		{
			balloon.transition().attr("opacity").float(0).endNode(function(_,_) {
				balloon.style("display").string("none");
			});
		} else {
			balloon.attr("opacity").float(0);
			balloon.style("display").string("none");
		}
	}

	function redraw()
	{
		if (null == text || text.length == 0)
			return;
/*
		function key(d : String, i : Int)
		{
			return d + ":" + i;
		}

		var //choice = frame
			//.selectAll("text")
			//.data(text, key),
			th = textHeight,
			linewidth = minwidth,
			pad = padding;
*/
/*
		function calculateLineWidth(n : Element, i : Int)
		{
			var v : Float = untyped n.getBBox().width;
			if (v > linewidth)
				linewidth = v;
		}

		choice.enter()
			.append("svg:text")
			.style("font-size").string(th + "px")
			.style("font-weight").string("bold")
			.style("fill").string("#000")
			.text().stringf(function(d, i) return d)
			.eachNode(calculateLineWidth)
			.attr("x").float(pad)
			.attr("y").floatf(function(_, i) return Math.round((0.6+i) * 1.2 * th + pad))
			.attr("opacity").float(0)
			.transition()
				.duration(duration).ease(ease)
				.delay(duration / 3)
				.attr("opacity").float(1)
		;

		choice.update()
			.text().stringf(function(d, i) return d)
			.eachNode(calculateLineWidth)
			.transition()
				.duration(duration).ease(ease)
				.attr("opacity").float(1)
				.attr("x").float(pad)
				.attr("y").floatf(function(_, i) return Math.round((0.6+i) * 1.2 * th + pad))
				.style("font-size").string(th + "px")
				.style("font-weight").string("bold")
		;

		choice.exit()
			.transition().ease(ease)
			.duration(duration / 3)
			.attr("opacity").float(0)
			.remove()
		;
*/
		boxWidth = 0.0;
		//linewidth + padding * 2;
		var w = 0;
		for (label in labels)
		{
			if ((w = Math.ceil(label.getSize().width)) > boxWidth)
				boxWidth = w;
		}
		if(w == 0) // fix for firefox
		{
			var t = text;
			haxe.Timer.delay(function() set_text(t), 15);
			return;
		}
		boxWidth += paddingHorizontal * 2;
		boxHeight = lineHeight * labels.length + paddingVertical * 2;

		var bg = frame.selectAll(".bg"),
			sw = bg.style("stroke-width").getFloat();
		if (Math.isNaN(sw))
			sw = 0;
		labelsContainer.attr("transform").string("translate(" + (boxWidth / 2) + "," + (sw + paddingVertical) + ")");

		bg.transition().ease(ease)
			.delay(duration)
		;
	}
}