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
import dhx.Selection;
import rg.frame.FrameLayout;
import rg.layout.Anchor;
import rg.info.InfoLayout;
import rg.svg.panel.Panel;

@:keep class LayoutSimple extends Layout
{
	var main : Panel;
	var titleOnTop : Bool;

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
				if (null != title)
					return null;
				return getTitle();
			default:
				return null;
		}
	}

	override public function getPanel(name : String) : Panel
	{
		switch(name)
		{
			case "main":
				if (null == main)
					main = space.createPanelAt(titleOnTop ? 1 : 0, FrameLayout.Fill(0, 0));
				return main;
			case "title":
				return getTitle().panel;
			default:
				return null;
		}
	}

	var title : PanelContext;
	function getTitle()
	{
		if (null == title)
			title = new PanelContext(space.createPanelAt(titleOnTop ? 0 : 1, FrameLayout.Fixed(0, 0, 20)), titleOnTop ? Bottom : Top);
		return title;
	}

	override function feedOptions(info : InfoLayout)
	{
		super.feedOptions(info);
		titleOnTop = info.titleOnTop;
	}
}