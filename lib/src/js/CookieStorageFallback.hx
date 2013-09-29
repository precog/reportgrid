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

package js;
import js.Cookie;
using Iterators;

class CookieStorageFallback implements Storage
{
	static var DEFAULT_PATH = "/";
	static var DEFAULT_EXPIRATION = 10 * 365 * 24 * 60 * 60;

	public function new()
	{
		length = Cookie.all().keys().array().length;
	}

	public var length(default, null) : Int;

	public function key(index : Int) : Null<String>
	{
		var keys = Cookie.all().keys().array();
		return keys[index];
	}

	public function getItem(key : String) : Null<String>
	{
		return Cookie.get(key);
	}

	public function setItem(key : String, value : String) : Void
	{
		if (!Cookie.exists(key))
			length++;
		Cookie.set(key, value, DEFAULT_EXPIRATION, DEFAULT_PATH);
	}

	public function removeItem(key : String) : Void
	{
		length--;
		Cookie.remove(key, DEFAULT_PATH);
	}

	public function clear() : Void
	{
		var keys = Cookie.all().keys().array();
		for (key in keys)
			removeItem(key);
	}
}