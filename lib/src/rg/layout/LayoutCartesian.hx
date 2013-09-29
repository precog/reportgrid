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

package rg.layout;

import rg.info.InfoLayout;
import rg.info.InfoPadding;
import rg.svg.panel.Panel;
import rg.svg.panel.Container;
import dhx.Selection;
import rg.frame.FrameLayout;
import rg.layout.Anchor;
import rg.frame.Orientation;

@:keep class LayoutCartesian extends Layout
{

	static inline var ALT_RIGHT  = 20;
	static inline var ALT_LEFT   = 20;
	static inline var ALT_TOP    = 8;
	static inline var ALT_BOTTOM = 8;

	var main : Panel;
	var titleOnTop : Bool;

	var leftcontainer : Container;
	var rightcontainer : Container;
	var bottomcontainer : Container;
	var bottommiddlecontainer : Container;
	var maincontainer : Container;
	var middlecontainer : Container;

	var bottomleft : Panel;
	var bottomright : Panel;
	var xtickmarks : PanelContext;
	var title : PanelContext;

	var right : Bool;
	var alternating : Bool;
	var yitems : Array<{
		container : Container,
		context : PanelContext,
		title : PanelContext,
		anchor : Anchor
	}>;
	var xtitle : PanelContext;

	public function new(width : Int, height : Int, container : Selection)
	{
		super(width, height, container);
		titleOnTop = true;
		right = false;
		alternating = true;
		yitems = [];
	}

	override public function getContext(name : String) : PanelContext
	{
		if (isY(name))
		{
			return getYContext(getYIndex(name));
		} else if (isYTitle(name)) {
			return getYTitle(getYIndex(name));
		}
		switch(name)
		{
			case "title":
				if (null == title)
					title = new PanelContext(space.createPanelAt(titleOnTop ? 0 : 1, FrameLayout.Fixed(0, 0, 0)), titleOnTop ? Bottom : Top);
				return title;
			case "x":
				return getXTickmarks();
			case "xtitle":
				return getXTitle();
			default:
				return null;
		}
	}

	override public function getPanel(name : String) : Panel
	{
		switch(name)
		{
			case "main":
				return getMain();
			case "xtickmarks":
				return getBottomContainer();
			case "left":
				return getLeftContainer();
			case "right":
				return getRightContainer();
			case "bottomleft":
				return bottomleft;
			case "bottomright":
				return bottomright;
			default:
				var ctx = getContext(name);
				if (null == ctx)
					return null;
				return ctx.panel;
		}
	}

	function getYItem(index : Int)
	{
		if (null == yitems[index])
		{
			yitems[index] = {
				container : null,
				context : null,
				title : null,
				anchor : (right || (alternating && (index % 2 != 0))) ? Left : Right
			};
		}
		return yitems[index];
	}

	function getYContainer(index : Int)
	{
		var item = getYItem(index);
		if (null == item.container)
		{
			if (right || (alternating && (index % 2 != 0)))
			{
				item.container = getRightContainer().createContainer(FrameLayout.Fixed(0, 0, 0), Horizontal);
			} else {
				item.container = getLeftContainer().createContainerAt(0, FrameLayout.Fixed(0, 0, 0), Horizontal);
			}
			item.container.g.classed().add("group-" + index);
		}
		return item.container;
	}

	function getYContext(index : Int)
	{
		var item = getYItem(index);
		if (null == item.context)
		{
			var panel = switch(item.anchor)
			{
				case Left:  getYContainer(index).createPanelAt(0, Fixed(0, 0, 0));
				case Right: getYContainer(index).createPanel(Fixed(0, 0, 0));
				default: null;
			}
			item.context = new PanelContext(panel, item.anchor);
		}
		return item.context;
	}

	function getYTitle(index : Int)
	{
		var item = getYItem(index);
		if (null == item.title)
		{
			var panel = switch(item.anchor)
			{
				case Left:  getYContainer(index).createPanel(Fixed(0, 0, 0));
				case Right: getYContainer(index).createPanelAt(0, Fixed(0, 0, 0));
				default: null;
			}
			item.title = new PanelContext(panel, item.anchor);
		}
		return item.title;
	}
/*
	function getYTitle(index : Int)
	{
		var item = getYItem(index);
		if (null == item.title)
		{
			item.title = if (alternating && index % 2 == 0)
			{
				new PanelContext(getLeftContainer().createPanelAt(0, FrameLayout.Fixed(0, 0, 0)), Right);
			} else {
				new PanelContext(getRightContainer().createPanel(FrameLayout.Fixed(0, 0, 0)), Left);
			}
			item.title.panel.g.classed().add("group-" + index);
		}
		return item.title;
	}
*/
	function getYIndex(s : String)
	{
		if (!REYINDEX.match(s))
			return -1;
		else
			return Std.parseInt(REYINDEX.matched(1));
	}

	function isY(s : String)
	{
		return REYAXIS.match(s);
	}

	function isYTitle(s : String)
	{
		return REYTITLE.match(s);
	}

	static var REYAXIS = ~/^y(\d+)$/;
	static var REYINDEX = ~/^y(\d+)/;
	static var REYTITLE = ~/^y(\d+)title$/;
	override public function suggestSize(name : String, size : Int)
	{
		if (isY(name) || isYTitle(name))
		{
			var index = getYIndex(name),
				item = getYItem(index);
			if (null == item.container)
				return;

			var ysize = 0.0;
			if (null != item.context)
			{
				if (isY(name))
					suggestPanelSize(item.context.panel, size);
				ysize += item.context.panel.frame.width;
			}
			if (null != item.title)
			{
				if (isYTitle(name))
					suggestPanelSize(item.title.panel, size);
				ysize += item.title.panel.frame.width;
			}
			suggestPanelSize(item.container, Math.round(ysize));
			suggestLateralSize(item.anchor);
			return;
		}
		super.suggestSize(name, size);
		switch(name)
		{
			case "x", "xtitle":
				var size = 0,
					c = getPanel("x");
				if (null != c)
					size += c.frame.height;
				c = getPanel("xtitle");
				if (null != c)
					size += c.frame.height;
				super.suggestSize("xtickmarks", size);
		}
	}

	function suggestLateralSize(anchor : Anchor)
	{
		var size = 0;
		var i = 0;
		for (item in yitems)
		{
			i++;
			if (null == item.container || !Type.enumEq(item.anchor, anchor))
				continue;
			size += item.container.frame.width;
		}
		switch(anchor)
		{
			case Right:
				suggestSize("left", size);
				suggestSize("bottomleft", size);
			case Left:
				suggestSize("right", size);
				suggestSize("bottomright", size);
			default: //
		}
	}

	function getXTitle()
	{
		if (null == xtitle)
			xtitle = new PanelContext(getBottomMiddleContainer().createPanel(FrameLayout.Fixed(0, 0, 0)), Top);
		return xtitle;
	}

	function getMainContainer()
	{
		if (null == maincontainer)
			maincontainer = space.createContainerAt(titleOnTop ? 1 : 0, FrameLayout.Fill(0, 0), Vertical);
		return maincontainer;
	}

	function getMiddleContainer()
	{
		if (null == middlecontainer)
			middlecontainer = getMainContainer().createContainerAt(0, FrameLayout.Fill(0, 0), Horizontal);
		return middlecontainer;
	}

	function getLeftContainer()
	{
		if (null == leftcontainer)
			leftcontainer = getMiddleContainer().createContainerAt(0, FrameLayout.Fixed(0, 0, 0), Horizontal);
		return leftcontainer;
	}

	function getRightContainer()
	{
		if (null == rightcontainer)
		{
			getMain();
			rightcontainer = getMiddleContainer().createContainer(FrameLayout.Fixed(0, 0, 0), Horizontal);
		}
		return rightcontainer;
	}

	function getBottomContainer()
	{
		if (null == bottomcontainer)
			bottomcontainer = getMainContainer().createContainerAt(1, FrameLayout.Fixed(0, 0, 0), Horizontal);
		return bottomcontainer;
	}

	function getBottomMiddleContainer()
	{
		if (null == bottommiddlecontainer)
		{
			var container = getBottomContainer();
			bottomleft = container.createPanel(FrameLayout.Fixed(0, 0, 0));
			bottommiddlecontainer = container.createContainer(FrameLayout.Fill(0, 0), Vertical);
			bottommiddlecontainer.g.classed().add("axis-x");
			bottomright = container.createPanel(FrameLayout.Fixed(0, 0, 0));
		}
		return bottommiddlecontainer;
	}

	function getXTickmarks()
	{
		if (null == xtickmarks)
		{
			var container = getBottomMiddleContainer();
			xtickmarks = new PanelContext(container.createPanelAt(0, FrameLayout.Fixed(0, 0, 0)), Top);
		}
		return xtickmarks;
	}

	function getMain()
	{
		if (null == main)
			main = getMiddleContainer().createPanelAt(1, FrameLayout.Fill(0, 0));
		return main;
	}

	override function feedOptions(info : InfoLayout)
	{
		super.feedOptions(info);
		titleOnTop = info.titleOnTop;
		switch(info.scalePattern)
		{
			case ScalesBefore:
				right = false;
				alternating = false;
			case ScalesAfter:
				right = true;
				alternating = false;
			case ScalesAlternating:
				right = false;
				alternating = true;
		}
	}

	override function adjustPadding()
	{
		var top    = (null == title && null == paddings.top) ? ALT_TOP : paddings.top,
			bottom = ((null == xtickmarks || !titleOnTop && null == title) && null == paddings.bottom) ? ALT_BOTTOM : paddings.bottom,
			left   = (null == leftcontainer && null == paddings.left) ? ALT_LEFT : paddings.left,
			right  = (null == rightcontainer && null == paddings.right) ? ALT_RIGHT : paddings.right;

		if (null != left || null != right)
		{
			suggestPanelPadding(getMain(), left, right);
			suggestPanelPadding(bottommiddlecontainer, left, right);
		}

		if (null != top || null != bottom)
		{
			suggestPanelPadding(middlecontainer, top, bottom);
		}
	}
}