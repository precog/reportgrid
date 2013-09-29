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
import erazor.Template;
import thx.error.Error;
import thx.ini.Ini;
import thx.sys.FileSystem;
import thx.sys.io.File;
import thx.sys.Lib;
using Arrays;
/**
 * ...
 * @author Franco Ponticelli
 */

class Main
{
	static var patternColorCapture = ~/background-color\s*:\s*(#?[0-9a-f]+)/i;
	static function main()
	{
		var config = Ini.decode(File.getContent("config.ini")),
			src : String = config.src,
			pattern = new EReg(config.pattern, "i");

		if (!FileSystem.exists(config.template))
			throw new Error("template file not found at '{0}'", config.template);

		var temp = new Template(File.getContent(config.template));

		var items = FileSystem.readDirectory(config.src)
			.filter(function(d) return pattern.match(d))
			.filter(function(d) return !FileSystem.isDirectory(config.src + "/" + d))
			.map(function(d, i) return {
				name : d,
				path : config.src + "/" + d,
				colors : []
			});
		items.sort(function(a, b) return Strings.compare(a.name, b.name));
		items.each(addColors);

		Lib.print(temp.execute({
			items : items
		}));
	}

	static function addColors(item : { name : String, path : String, colors : Array<String> }, _)
	{
		var content = File.getContent(item.path);
		while (patternColorCapture.match(content))
		{
			item.colors.push(patternColorCapture.matched(1));
			content = patternColorCapture.matchedRight();
		}
	}
}