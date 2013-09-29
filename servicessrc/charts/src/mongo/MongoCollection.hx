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
package mongo;

import mongo._Mongo;
import php.Lib; using php.Lib;

class MongoCollection
{
	var c : _MongoCollection;
	public function new(c : _MongoCollection)
	{
		this.c = c;
	}

	public inline function validate() : {
		ok : Int,
		?errmsg : String,
		?ns : String,
		?firstExtent : String,
		?lastExtent : String,
		?extentCount : Int,
		?datasize : Int,
		?nrecords : Int,
		?lastExtentSize : Int,
		?padding : Int,
		?firstExtentDetails : {
			loc : String,
			xnext : String,
			xprev : String,
			nsdiag : String,
			size : Int,
			firstRecord : String,
			lastRecord : String
		},
		?deletedCount : Int,
		?deletedSize : Int,
		?nIndexes : Int,
		?keysPerIndex : Dynamic,
		?valid : Bool,
		?errors : Dynamic,
		?warning : String
	}
	{
		return c.validate().objectOfAssociativeArray();
	}

	public function ensureIndex(keys : Dynamic<Int>, ?options : { ?unique : Bool, ?dropDups : Bool, ?background : Bool, ?safe : Bool, ?name : String, ?timeout : Int }) : Bool
	{
		if(null != options)
			return c.ensureIndex(Lib.associativeArrayOfObject(keys), Lib.associativeArrayOfObject(options));
		else
			return c.ensureIndex(Lib.associativeArrayOfObject(keys));
	}

	public function ensureIndexOn(key : String, ?options : { ?unique : Bool, ?dropDups : Bool, ?background : Bool, ?safe : Bool, ?name : String, ?timeout : Int }) : Bool
	{
		if(null != options)
			return c.ensureIndex(key, Lib.associativeArrayOfObject(options));
		else
			return c.ensureIndex(key);
	}

	public function insert(data : Dynamic, ?options : { safe : Bool, fsync : Bool, timeout : Int })
	{
		if(null != options)
			return c.insert(Lib.associativeArrayOfObject(data), Lib.associativeArrayOfObject(options));
		else
			return c.insert(Lib.associativeArrayOfObject(data));
	}

	public function remove(criteria : Dynamic, ?options : { justOne : Bool, safe : Bool, fsync : Bool, timeout : Int })
	{
		if(null != options)
			return c.remove(Lib.associativeArrayOfObject(criteria), Lib.associativeArrayOfObject(options));
		else
			return c.remove(Lib.associativeArrayOfObject(criteria));
	}

	public function update(criteria : Dynamic, newob : Dynamic, ?options : { upsert : Bool, multiple : Bool, safe : Bool, fsync : Bool, timeout : Int })
	{
		if(null != options)
			return c.update(
				Lib.associativeArrayOfObject(criteria),
				Lib.associativeArrayOfObject(newob),
				Lib.associativeArrayOfObject(options));
		else
			return c.update(
				Lib.associativeArrayOfObject(criteria),
				Lib.associativeArrayOfObject(newob));
	}

	public function findOne(criteria : Dynamic, ?fields : Dynamic<Bool>) : Dynamic
	{
		var r;
		if(null == fields)
			r = c.findOne(Lib.associativeArrayOfObject(criteria));
		else
			r = c.findOne(Lib.associativeArrayOfObject(criteria), Lib.associativeArrayOfObject(fields));
		if(null == r)
			return null;
		else
			return r.objectOfAssociativeArray();
	}

	public function find(criteria : Dynamic, ?fields : Dynamic<Bool>)
	{
		var r;
		if(null == fields)
			r = c.find(Lib.associativeArrayOfObject(criteria));
		else
			r = c.find(Lib.associativeArrayOfObject(criteria), Lib.associativeArrayOfObject(fields));
		return new MongoCursor(r);
	}

	public inline function drop()
	{
		c.drop();
	}

	public inline function count()
	{
		return c.count();
	}
}