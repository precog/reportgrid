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

package rg.svg.widget;

import thx.error.Error;
using Arrays;

class LabelOrientations
{
	static public function canParse(s : String)
	{
		var name = s.split(":")[0].toLowerCase();
		return ["angle", "fixed", "ortho", "orthogonal", "align", "aligned", "horizontal"].exists(name);
	}

	static public function parse(s : String)
	{
		var name = s.split(":")[0].toLowerCase();
		switch(name)
		{
			case "fixed", "angle":
				var v = Std.parseFloat(s.split(":")[1]);
				if (null == v || !Math.isFinite(v))
					throw new Error("when 'fixed' is used a number should follow the 'dash' character");
				return LabelOrientation.FixedAngle(v);
			case "ortho", "orthogonal":
				return LabelOrientation.Orthogonal;
			case "align", "aligned":
				return LabelOrientation.Aligned;
			case "horiz", "horizontal":
				return LabelOrientation.FixedAngle(0);
			default:
				throw new Error("invalid filter orientation '{0}'", s);
		}
	}
}