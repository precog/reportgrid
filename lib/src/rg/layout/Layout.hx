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
import rg.svg.panel.Space;
import dhx.Selection;
import rg.frame.StackItem;
import rg.frame.FrameLayout;

class Layout
{
	public var mainPanelName : String;
	public var width(default, null) : Int;
	public var height(default, null) : Int;

	var space : Space;
	public var container(default, null) : Selection;
	public function new(width : Int, height : Int, container : Selection)
	{
		this.container = container;
		container.classed().add("rg");
		space = new Space(this.width = width, this.height = height, container.append("div"));
	}

	public function getContext(name : String) : PanelContext
	{
		return null;
	}

	public function getPanel(name : String) : Panel
	{
		return null;
	}

	public function suggestSize(name : String, size : Int)
	{
		var panel = getPanel(name);
		if (null == panel)
			return;
		suggestPanelSize(panel, size);
	}

	public function destroy()
	{
		container.selectAll("*").remove();
	}

	function suggestPanelSize(panel : Panel, size : Int)
	{
		var stackitem : StackItem = Types.as(panel.frame, StackItem);
		if (null == stackitem)
			return;
		switch(stackitem.disposition)
		{
			case Fixed(b, a, _):
				stackitem.disposition = Fixed(b, a, size);
			default:
				// do nothing
		}
	}

	function suggestPanelPadding(panel : Panel, before : Null<Int>, after : Null<Int>)
	{
		if (null == panel)
			return;
		var stackitem : StackItem = Types.as(panel.frame, StackItem);
		if (null == stackitem)
			return;
		switch(stackitem.disposition)
		{
			case Fill(b, a, min, max):
				stackitem.disposition = Fill(null == before ? b : before, null == after ? a : after, min, max);
			case FillPercent(b, a, percent, min, max):
				stackitem.disposition = FillPercent(null == before ? b : before, null == after ? a : after, percent, min, max);
			case FillRatio(b, a, ratio):
				stackitem.disposition = FillRatio(null == before ? b : before, null == after ? a : after, ratio);
			case Fixed(b, a, size):
				stackitem.disposition = Fixed(null == before ? b : before, null == after ? a : after, size);
			default:
				// do nothing
		}
	}

	var paddings : InfoPadding;

	public function feedOptions(info : InfoLayout)
	{
		this.mainPanelName = info.main;
		this.paddings = info.padding;
	}

	public function adjustPadding()
	{

	}
}