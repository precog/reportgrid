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
package rg.data;

import hxevents.Dispatcher;
import thx.error.NullArgument;

class DataLoader
{
	var loader : (Array<Dynamic> -> Void) -> Void;
	public function new(loader : (Array<Dynamic> -> Void) -> Void)
	{
		NullArgument.throwIfNull(loader);
		this.loader = loader;
		onLoad = new Dispatcher();
	}

	public var onLoad(default, null) : Dispatcher<Array<Dynamic>>;
	public function load()
	{
		loader(function(datapoints) {
			onLoad.dispatch(datapoints);
		});
	}
}