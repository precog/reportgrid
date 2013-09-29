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

import model.Renderable;
import mongo._Mongo;
import mongo.MongoBinData;
import mongo.MongoCollection;

class RenderableGateway
{
	public static var DELETE_IF_NOT_USED_FOR = thx.date.Milli.parse("366 days");
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	public function exists(uid : String)
	{
		return null != coll.findOne({ uid : uid }, {});
	}

	public function insert(r : Renderable)
	{
		var ob = {
			uid       : r.uid,
			config    : serialize(r.config),
			createdOn : r.createdOn.getTime(),
			html      : r.html,
			lastUsage : r.lastUsage.getTime(),
			usages    : r.usages,
			expiresOn : null == r.config.duration ? null : Date.now().getTime() + r.config.duration
		};
		// store in mongo
		coll.insert(ob);
	}

	public function load(uid : String)
	{
		// load from mongo
		var o : {
			uid       : String,
			html      : String,
			config    : _MongoBinData,
			createdOn : Float,
			lastUsage : Float,
			usages    : Int,
			expiresOn : Null<Float>
		} = coll.findOne({ uid : uid });
		if(null == o)
			return null;
		return new model.Renderable(
			o.html,
			unserialize(o.config),
			Date.fromTime(o.createdOn),
			Date.fromTime(o.lastUsage),
			o.usages
		);
	}

	public function topByUsage(limit : Int)
	{
		return coll
			.find({}, { uid : true, createdOn : true, lastUsage : true, usages : true })
			.sort({ usages : -1 })
			.limit(limit)
			.toArray();
	}

	public function use(uid : String)
	{
		coll.update({ uid : uid }, {
			'$set' : { lastUsage : Date.now().getTime() },
			'$inc' : { usages : 1 }
		});
	}

	public function removeExpired()
	{
		return coll.remove({ expiresOn : { "$lt" : Date.now().getTime() }});
	}

	public function removeOldAndUnused(?age : Float)
	{
		if(null == age)
			age = DELETE_IF_NOT_USED_FOR;
		var exp = Date.now().getTime() - age;
		return coll.remove({ lastUsage : { "$lt" : exp }});
	}

	static function serialize(o : Dynamic)
	{
		return MongoBinData.createByteArray(php.Lib.serialize(o));
	}

	static function unserialize(s : _MongoBinData) : Dynamic
	{
		return php.Lib.unserialize(s.bin);
	}
}