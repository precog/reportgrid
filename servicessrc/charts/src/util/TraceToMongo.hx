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
package util;

import ufront.web.HttpApplication;
import haxe.PosInfos;
import mongo.Mongo;
import mongo.MongoDB;
import mongo.MongoCollection;
import ufront.web.module.ITraceModule;

class TraceToMongo implements ITraceModule
{
	var coll(get, null) : MongoCollection;
	var dbname : String;
	var collname : String;
	var servername : String;
	public function new(dbname : String, collname : String, servername : String)
	{
		this.dbname = dbname;
		this.collname = collname;
		this.servername = servername;
	}
	public function init(application : HttpApplication)
	{

	}
	public function trace(msg : Dynamic, ?pos : PosInfos) : Void
	{
		var p ={
			fileName   : pos.fileName,
			className  : pos.className,
			methodName : pos.methodName,
			lineNumber : pos.lineNumber,
		}
		coll.insert({
			msg : Dynamics.string(msg),
			pos : p,
			time : Date.now().getTime(),
			server : servername
		});
	}
	public function dispose()
	{

	}
	function get_coll()
	{
		if(null == coll)
		{
			var m = new Mongo(),
				db = m.selectDB(dbname);
			coll = db.selectCollection(collname);
		}
		return coll;
	}
}