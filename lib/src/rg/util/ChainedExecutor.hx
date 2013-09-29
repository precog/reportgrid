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

package rg.util;

class ChainedExecutor<T>
{
	var handler : Dynamic -> Void;
	var actions : Array< T -> (T -> Void) -> Void > ;
	var pos : Int;

	public function new(handler : T -> Void)
	{
		this.handler = handler;
		actions = [];
		pos = 0;
		executor = execute;// Reflect.field(this, 'execute');
	}

	public function addAction(handler : T -> (T -> Void) -> Void )
	{
		actions.push(handler);
	}

	public function execute(ob : T)
	{
		if (pos == actions.length)
		{
			pos = 0;
			handler(ob);
		}
		else
			actions[pos++](ob, execute);
	}

	var executor : T -> Void;
}