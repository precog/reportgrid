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
import neko.FileSystem;
import neko.io.File;
import neko.Lib;
import neko.Sys;
import thx.color.Colors;
import thx.color.Rgb;
import thx.csv.Csv;
import thx.csv.CsvDecoder;
import thx.text.Paths;
using Arrays;
/**
 * ...
 * @author Franco Ponticelli
 */

class Main 
{
	static function main() 
	{
		var args = Sys.args();
		var input = args.shift();
		if ("-help" == input)
			help();
		if (null == input)
			error("invalid input argument");
		if (!FileSystem.exists(input) || FileSystem.isDirectory(input))
		{
			error(Strings.format("invalid input file '{0}'", [input]));
		}
		var output = args.shift();
		if (null == output)
			output = "palettes";
		if (!FileSystem.exists(output) || !FileSystem.isDirectory(output))
			error(Strings.format("output '{0}' is not a directory or doesn't exist", [input]));

		var lines = Csv.decode(File.getContent(input));
		lines.shift(); // remove the header row
		
		var schemes = processLines(lines);
		for (scheme in schemes)
			saveScheme(scheme.colors, output + "/" + scheme.name);
	}
	
	static function processLines(lines : Array<Array<Dynamic>>)
	{
		var schemes = [],
			i = 0;
		
		while (i < lines.length)
		{
			var name : String = lines[i][0],
				numcolors : Int = lines[i][1],
				type = lines[i][2],
				colors = [];
			for (j in 0...numcolors)
			{
				colors.push(new Rgb(lines[i + j][6], lines[i + j][7], lines[i + j][8]));
			}
			
			schemes.push({
				name : (name + "-" + numcolors + "-" + type).toLowerCase(),
				colors : colors
			});
			
			var reverse = colors.copy();
			reverse.reverse();
			
			schemes.push({
				name : (name + "-" + numcolors + "-" + type + "r").toLowerCase(),
				colors : reverse
			});
			
			i += numcolors;
		}
		return schemes;
	}
	
	static function saveScheme(colors : Array<Rgb>, output : String)
	{
		try
		{
			var file = File.write(output);
			file.writeString("// Colors from www.ColorBrewer.org by Cynthia A. Brewer, Geography, Pennsylvania State University.\n");
			file.writeString(colors.map(function(d, _) return d.toCss()).join("\n"));
			file.close();
		} catch (e : Dynamic)
		{
			error(Strings.format("unable to write file '{0}': {1}", [output, Std.string(e)]));
		}
	}
	
	
	static function error(msg : String)
	{
		Lib.println("==========================================================================");
		Lib.println("ERROR: " + msg);
		Lib.println("==========================================================================");
		Lib.println("");
		help(false);
	}
	
	static function help(cleanExit = true)
	{
		Lib.print
('Color Brewer Generator For ReportGrid Color File by Franco Ponticelli.

USAGE:
  colorbrewer [input] [?output]
    where
    - input: input file
    - output (optional, default is "palettes"): output directory
  colorbrewer -help
    show this help
EXAMPLE:
  colorbrewer colorbrewer_csv.txt
');
		Sys.exit(cleanExit ? 0 : 1);
	}
}