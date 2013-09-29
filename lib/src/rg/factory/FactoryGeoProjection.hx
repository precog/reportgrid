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
import rg.info.InfoMap;
import thx.error.Error;
import thx.geo.Albers;
import thx.geo.AlbersUsa;
import thx.geo.Azimuthal;
import thx.geo.IProjection;
import thx.geo.Mercator;

class FactoryGeoProjection
{
	public function new() { }

	public function create(info : InfoMap) : IProjection
	{
		switch(info.projection.toLowerCase())
		{
			case "mercator":
				var projection = new Mercator();
				if (null != info.scale)
					projection.scale = info.scale;
				if (null != info.translate)
					projection.translate = info.translate;
				else
					projection.translate = [0.0, 0];
				return projection;
			case "albers":
				var projection = new Albers();
				if (null != info.scale)
					projection.scale = info.scale;
				if (null != info.translate)
					projection.translate = info.translate;
				else
					projection.translate = [0.0, 0];
				if (null != info.origin)
					projection.origin = info.origin;
				if (null != info.parallels)
					projection.parallels = info.parallels;
				return projection;
			case "albersusa":
				var projection = new AlbersUsa();
				if (null != info.scale)
					projection.scale = info.scale;
				if (null != info.translate)
					projection.translate = info.translate;
				else
					projection.translate = [0.0, 0];
				return projection;
			case "azimuthal":
				var projection = new Azimuthal();
				if (null != info.scale)
					projection.scale = info.scale;
				if (null != info.translate)
					projection.translate = info.translate;
				else
					projection.translate = [0.0, 0];
				if (null != info.mode)
					projection.mode = info.mode;
				if (null != info.origin)
					projection.origin = info.origin;
				return projection;
			default:
				return throw new Error("the projection '{0}' does not exist or is not implemented", [info.projection]);
		}
	}
}