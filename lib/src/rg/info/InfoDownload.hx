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

package rg.info;

using rg.info.Info;
import rg.html.widget.DownloaderPosition;
import rg.html.widget.DownloaderPositions;
import rg.RGConst;
import thx.util.Message;
using rg.info.filter.FilterDescription;
using rg.info.filter.TransformResult;

@:keep class InfoDownload
{
	public var handler : (String -> String -> (Dynamic -> Bool) -> (String -> Void) -> Void) -> Void;
	public var service : String;
	public var legacyservice : String;
	public var position : Null<DownloaderPosition>;
	public var formats : Array<String>;

	public function new()
	{
		service = RGConst.SERVICE_RENDERING_STATIC;
		legacyservice = RGConst.LEGACY_RENDERING_STATIC;
		formats = ['pdf', 'png', 'jpg', 'svg'];
	}

	public static function filters() : Array<FilterDescription>
	{
		return [
			"handler".toFunction(),
			"service".toStr(),
			"legacyservice".toStr(),
			"formats".toArray(),
			"position".custom(
				function(value : Dynamic) {
					if(Std.is(value, String) || value.nodeName)
						return TransformResult.Success(DownloaderPositions.parse(value));
					else
						return TransformResult.Failure(new Message("invalid downloader position: {0}", value));
				})
		];
	}
}