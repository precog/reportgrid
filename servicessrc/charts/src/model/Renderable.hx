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
package model;

using Arrays;

class Renderable
{
	static inline var SEED = "][4p5.,vsd";
	public var html(default, null) : String;
	public var config(default, null) : ConfigRendering;
	public var createdOn(default, null) : Date;
	public var lastUsage(default, null) : Date;
	public var usages(default, null) : Int;
	public function new(html : String, config : ConfigRendering, ?createdOn : Date, ?lastUsage : Date, ?usages : Int)
	{
		this.html      = html;
		this.config    = config;
		this.createdOn = null == createdOn ? Date.now() : createdOn;
		this.lastUsage = null == lastUsage ? Date.now() : lastUsage;
		this.usages    = null == usages ? 0 : usages;
	}

	public var uid(get, null) : String;
	function get_uid()
	{
		if(null == uid)
		{
			var s = html + "::" + haxe.Serializer.run(config);
			s = SEED + (~/\s+/mg).replace(s, '');
			uid = Map (s);
		}
		return uid;
	}

	public function canRenderTo(format : String)
	{
		return config.allowedFormats.exists(format);
	}

	static function Map (s : String) : String
	{
		s = untyped __call__('md5', s);
		s = untyped __call__('base_convert', s, 16, 36);
		return s.substr(0, 12);
	}

	public function toString()
	{
		return Std.format("CONFIG\n$config\n\nHTML\n$html");
	}
}