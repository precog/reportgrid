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
import thx.text.Paths;
import thx.color.Rgb;
using Arrays;
/**
 * ...
 * @author Franco Ponticelli
 */

class Main
{
	static var inputFile : String;
	static function main()
	{
		var args = Sys.args().map(function(arg, _) return StringTools.trim(arg));
		var input = args.shift();
		if ("-help" == input)
			help();
		if (null == input)
			error("invalid input argument");
		if (!FileSystem.exists(input))
			error(Strings.format("input does not exist: {0}", [input]));
		var isdir = FileSystem.isDirectory(input);
		var inputs = if (isdir)
		{
			FileSystem.readDirectory(input).filter(function (file){
				return file.substr(0,1) != '.';
			}).map(function(file,i) return input + "/" + file);
		} else {
			if (!FileSystem.exists(input))
				error(Strings.format("input file '{0}' does not exist", [input]));
			[input];
		}
		var output = args.shift();
		if (null == output)
			output = "{0}.css";

		var border = args.shift();
		if (null == border)
			border = ".rg .stroke-{0}";

		var fill = args.shift();
		if (null == fill)
			fill = ".rg .fill-{0}";

		var color = args.shift();
		if (null == color)
			color = ".rg .color-{0}";

		var t = args.shift();
		var count = null == t ? 32 : Std.parseInt(t);

		var items = inputs.map(function(file, i) {
			var base = Paths.removeExt(Paths.base(file));
			return {
				output : Strings.format(output, [base]),
				input : file
			}
		});

		processItems(
			items,
			Strings.formatf(border),
			Strings.formatf(fill),
			Strings.formatf(color),
			count);
	}

	static function processItems(items : Array<{ input : String, output : String }>, borderf : Array<Dynamic> -> String, fillf : Array<Dynamic> -> String, colorf : Array<Dynamic> -> String, count : Int)
	{
		for (item in items)
		{
			var result = extractValues(inputFile = item.input),
				values = result.values,
				len = result.numcolors,
				repetitions = Math.ceil(Ints.max(len, count) / len),
				rules = [];

			try
			{
				var file = File.write(item.output, false),
					pos = 0;
				for (i in 0...values.length)
				{
					switch(values[i])
					{
						case Comment(msg):
							file.writeString("/* " + msg + " */\n");
						case Color(rgb, src):
							var range = Ints.range(pos, count, len),
								color = rgb.toCss(),
								borders = range.map(function(i, _) return borderf([i])),
								fills   = range.map(function(i, _) return fillf([i])),
								colors  = range.map(function(i, _) return colorf([i]));
							if (src.toUpperCase() == color)
								src = "";
							else
								src = " /* " + src + " */";
								file.writeString(buildRule(borders, Strings.format("border-color: {0}; stroke: {0};{1}", [color, src])));
								file.writeString(buildRule(fills,   Strings.format("background-color: {0}; fill: {0};{1}", [color, src])));
								file.writeString(buildRule(colors,  Strings.format("color: {0}; fill: {0};{1}", [color, src])));
							pos++;
					}

				}
				file.close();
			} catch (e : Dynamic)
			{
				error(Strings.format("unable to write to file '{0}': {1}", [item.output, Std.string(e)]));
			}
		}
	}

	static function buildRule(selectors : Array<String>, rule : String)
	{
		var buf = new StringBuf();
		buf.add(selectors.join(", "));
		buf.add("\n{\n");
		buf.add(rule);
		buf.add("\n}\n\n");
		return buf.toString();
	}

	static function extractValues(input : String)
	{
		var numcolors = 0;
		return {
			values : (~/(\r\n|\n|\r)/g)
				.split(File.getContent(input))
					.map(function(d, i) return StringTools.trim(d))
					.filter(function(d) return d != "")
					.map(function(c, _) {
						if (c.substr(0, 2) == "//")
							return Comment(StringTools.trim(c.substr(2)));
						else
						{
							numcolors++;
							return Color(parseColor(c), c);
						}
					}),
			numcolors : numcolors
		}
	}

	static function parseColor(s : String)
	{
		var c = Colors.parse(s);
		if (null == c)
			error(Strings.format("unable to parse in '{0}' color '{1}'", [inputFile, s]));
		return c;
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
('Palette Generator For ReportGrid CSS Styles by Franco Ponticelli.

USAGE:
  palette [input] [?output] [?border] [?fill]
    where
    - input: input file or directory. The file must contain one color per
      line in parsable format
    - output (optional): output file. It can be a pattern where the first
      element is the input filename without an extension
    - border (optional): a css selector as a pattern with one {0} placeholder
      for the index
    - fill (optional): a css selector as a pattern with one {0} placeholder
      for the index
  palette -help
    show this help
EXAMPLE:
  palette palettes "css/{0}.css"
');
		Sys.exit(cleanExit ? 0 : 1);
	}
}

enum LineType
{
	Color(rgb : Rgb, src : String);
	Comment(msg : String);
}