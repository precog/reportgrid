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
import rg.frame.StackItem;
import dhx.Selection;
import rg.frame.FrameLayout;
import rg.frame.Orientation;
import rg.frame.Frame;

class Space extends Container
{
	var panel : StackItem;
	var svg : Selection;

	public function new(width : Int, height : Int, domcontainer : Selection)
	{
		panel = new StackItem(Fill(0, 0));
		super(panel, Vertical);
		init(svg = domcontainer.append("svg:svg").attr("xmlns").string("http://www.w3.org/2000/svg"));
		resize(width, height);
	}

	public function resize(width : Int, height : Int)
	{
		if (panel.width == width && panel.height == height)
			return;
		svg
			.attr("width").float(width)
			.attr("height").float(height);
		var sf : FrameFriend = panel;
		sf.set_layout(0, 0, width, height);
	}
}