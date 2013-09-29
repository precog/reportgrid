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
package rg.storage;

import thx.json.Json;

class BrowserStorage implements IStorage
{
	var storage : API;
	public var kind(default, null) : String;
	private function new(api : API, kind : String)
	{
		storage = api;
		this.kind = kind;
	}
	public function set(name : String, value : Dynamic) : Void
	{
		storage.setItem(name, Json.encode(value));
	}
	public function get(name : String) : Dynamic
	{
		var v = storage.getItem(name);
		if(null == v)
			return v;
		else
			return Json.decode(v);
	}
	public function clear() : Void
	{
		storage.clear();
	}
	public function remove(name : String) : Void
	{
		storage.removeItem(name);
	}
	public function keys()
	{
		var keys = [];
		for(i in 0...storage.length)
			keys.push(storage.key(i));
		return keys.iterator();
	}

	public static function hasSessionStorage() : Bool
	{
		try
		{
			return untyped __js__("'undefined' != typeof window.sessionStorage");
		} catch(e : Dynamic) {
			return false;
		}
	}

	public static function sessionStorage()
	{
		return new BrowserStorage(untyped __js__("sessionStorage"), "sessionStorage");
	}

	public static function hasLocalStorage() : Bool
	{
		try
		{
			return untyped __js__("'undefined' != typeof window.localStorage");
		} catch(e : Dynamic) {
			return false;
		}
	}

	public static function localStorage()
	{
		return new BrowserStorage(untyped __js__("localStorage"), "localStorage");
	}

	public function toString() return Std.format("BrowserStorage[$kind]")
}

typedef API = {
	public var length(default, null) : Int;
	public function key(index : Int) : String;
	public function getItem(key : String) : String;
	public function setItem(key : String, data : String) : Void;
	public function removeItem(key : String) : Void;
	public function clear() : Void;
}