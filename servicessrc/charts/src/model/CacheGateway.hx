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
import mongo.MongoBinData;
import mongo.MongoCollection;
import thx.collection.HashList;

class CacheGateway
{
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	function key(id : String, format : String, params : HashList<String>)
	{
		var ps = [];
		for(field in params.keys())
		{
			ps.push(
				StringTools.urlEncode(field)
				+ "="
				+ StringTools.urlEncode(params.get(field)));
		}
		return Std.format("$id.$format${ps.length == 0 ? '' : '?' + ps.join('&') }");
	}

	public function exists(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		return null != coll.findOne({ uid : uid }, {});
	}

	public function insert(id : String, format : String, params : HashList<String>, content : String, expiresOn : Float)
	{
		var uid = key(id, format, params);
		var ob = {
			uid       : uid,
			content   : MongoBinData.createByteArray(content),
			expiresOn : expiresOn
		};
		// store in mongo
		var r = coll.insert(ob);
		return ob;
	}

	public function load(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		// load from mongo
		var o : {
			uid       : String,
			content   : mongo._Mongo._MongoBinData,
			expiresOn : Float
		} = coll.findOne({ uid : uid });
		if(null == o)
			return null;
		return o;
	}

	public function remove(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		return coll.remove({ uid : uid });
	}

	public function removeAll()
	{
		return coll.remove({ });
	}

	public function expired()
	{
		var now = Date.now().getTime();
		return coll.find({ expiresOn : { "$lt" : now }}, { uid : true });
	}

	public function removeExpired()
	{
		var now = Date.now().getTime();
		return coll.remove({ expiresOn : { "$lt" : now }});
	}

	public function loadContent(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		// load from mongo
		var o : {
			content : String
		} = coll.findOne({ uid : uid }, { content : true });
		if(null == o)
			return null;
		return o.content;
	}
}