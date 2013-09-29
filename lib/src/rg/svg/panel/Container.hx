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

package rg.svg.panel;
import rg.frame.Orientation;
import rg.frame.StackItem;
import rg.frame.Stack;
import rg.frame.FrameLayout;

using Iterators;

class Container extends Panel
{
	var stack : Stack;
	var panels : Array<Panel>;
	public function new(frame : StackItem, orientation : Orientation)
	{
		super(frame);
		stack = new Stack(frame.width, frame.height, orientation);
		panels = [];
	}

	public function insertPanel(pos : Int, panel : Panel)
	{
		if (null == panel)
			return this;

		if (pos >= stack.length)
			return addPanel(panel);
		else if (pos < 0)
			pos = 0;

		if (null != panel.parent)
			panel.parent.removePanel(panel);

		panels.insert(pos, panel);
		var f : PanelFriend = panel;
		f.setParent(this);
		stack.insertItem(pos, cast(panel.frame, StackItem));
		return this;
	}

	public function addPanel(panel : Panel)
	{
		return addPanels([panel]);
	}

	public function addPanels(it : Iterable<Panel>)
	{
		var frames = [];
		for (panel in it)
		{
			if (null == panel)
				continue;

			if (null != panel.parent)
				panel.parent.removePanel(panel);

			panels.push(panel);
			var f : PanelFriend = panel;
			f.setParent(this);
			frames.push(cast(panel.frame, StackItem));
		}
		stack.addItems(frames);
		return this;
	}

	public function removePanel(panel : Panel)
	{
		if (!panels.remove(panel))
			return this;

		stack.removeChild(cast(panel.frame, StackItem));
		var f : PanelFriend = panel;
		f.setParent(null);
		return this;
	}

	public function createPanel(layout : FrameLayout)
	{
		var panel = new Panel(new StackItem(layout));
		addPanel(panel);
		return panel;
	}

	public function createContainer(layout : FrameLayout, orientation : Orientation)
	{
		var panel = new Container(new StackItem(layout), orientation);
		addPanel(panel);
		return panel;
	}

	public function createPanelAt(pos : Int, layout : FrameLayout)
	{
		var panel = new Panel(new StackItem(layout));
		insertPanel(pos, panel);
		return panel;
	}

	public function createContainerAt(pos : Int, layout : FrameLayout, orientation : Orientation)
	{
		var panel = new Container(new StackItem(layout), orientation);
		insertPanel(pos, panel);
		return panel;
	}

	override function reframe()
	{
		super.reframe();
		stack.setSize(frame.width, frame.height);
		stack.reflow();
	}

}

typedef PanelFriend = {
	private function setParent(p : Container) : Void;
}