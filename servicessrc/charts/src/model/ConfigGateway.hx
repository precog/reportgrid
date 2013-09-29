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

import mongo.MongoCollection;

class ConfigGateway
{
	static var SAMPLE_UID = "sample_uid";
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	public function setSampleUID(id : String)
	{
		coll.insert({
			name  : SAMPLE_UID,
			value : id
		});
	}

	public function getSampleUID() : Null<String>
	{
		var o = coll.findOne({ name : SAMPLE_UID });
		if(null == o)
			return null;
		else
			return o.value;
	}
}