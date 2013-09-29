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

package rg.factory;
import rg.info.InfoLayout;
import rg.visualization.Visualizations;
import thx.error.Error;
import dhx.Selection;

class FactoryLayout
{
	public inline static var LIMIT_WIDTH = 10;
	public inline static var LIMIT_HEIGHT = 10;
	public inline static var DEFAULT_WIDTH = 400;
	public inline static var DEFAULT_HEIGHT = 300;

	public function new() { }

	public function create(info : InfoLayout, heightmargin : Int, container : Selection)
	{
		var size = size(container, info, heightmargin);
		var layoutName = info.layout;
		if (null == layoutName)
			layoutName = Visualizations.layoutDefault.get(info.type);
		if (null == layoutName)
			throw new Error("unable to find a suitable layout for '{0}'", info.type);
		var layout = Visualizations.instantiateLayout(layoutName, size.width, size.height, container);
		layout.feedOptions(info);
		return layout;
	}

	public static function size(container : Selection, info : InfoLayout, heightmargin : Int)
	{
		var v,
			width = null == info.width
				? ((v = container.node().clientWidth) > LIMIT_WIDTH ? v : DEFAULT_WIDTH)
				: info.width,
			height = (null == info.height
				? ((v = container.node().clientHeight) > LIMIT_HEIGHT ? v : DEFAULT_HEIGHT)
				: info.height) - heightmargin;
		return {
			width  : width,
			height : height
		}
	}
}