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
import rg.svg.panel.Panel;
import rg.svg.panel.Container;
import dhx.Selection;
import rg.frame.FrameLayout;
import rg.layout.Anchor;
import rg.frame.Orientation;

@:keep class LayoutX extends Layout
{

	static inline var ALT_RIGHT  = 20;
	static inline var ALT_LEFT   = 20;
	static inline var ALT_TOP    = 8;
	static inline var ALT_BOTTOM = 8;

	var main : Panel;
	var titleOnTop : Bool;

	var bottomcontainer : Container;
	var bottommiddlecontainer : Container;
	var maincontainer : Container;
	var middlecontainer : Container;

	var xtickmarks : PanelContext;
	var title : PanelContext;

	var xtitle : PanelContext;

	public function new(width : Int, height : Int, container : Selection)
	{
		super(width, height, container);
		titleOnTop = true;
	}

	override public function getContext(name : String) : PanelContext
	{
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
			default:
				var ctx = getContext(name);
				if (null == ctx)
					return null;
				return ctx.panel;
		}
	}

	override public function suggestSize(name : String, size : Int)
	{
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
			bottommiddlecontainer = container.createContainer(FrameLayout.Fill(0, 0), Vertical);
			bottommiddlecontainer.g.classed().add("axis-x");
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
	}

	override function adjustPadding()
	{
		var top    = (null == title && null == paddings.top) ? ALT_TOP : paddings.top,
			bottom = ((null == xtickmarks || !titleOnTop && null == title) && null == paddings.bottom) ? ALT_BOTTOM : paddings.bottom,
			left   = null == paddings.left ? ALT_LEFT : paddings.left,
			right  = null == paddings.right ? ALT_RIGHT : paddings.right
		;

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