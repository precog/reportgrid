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

@:native('Mongo') extern class _Mongo
{
//	static function getPoolSize() : Int;
//	static function setPoolSize(size : Int) : Bool;

	var connected : Bool;
	var status : String;

	@:overload(function():Void{})
	@:overload(function(server:String):Void{})
	function new(server : String, options : php.NativeArray) : Void;
	function close() : Bool;
	function connect() : Bool;

//	@:overload(function(db:String):php.NativeArray)
//	function dropDB(db : MongodDB) : php.NativeArray;
	function getHosts() : php.NativeArray;
	function getSlave() : String;
	function getSlaveOkay() : Bool;
	function listDBs() : php.NativeArray;
//	function poolDebug() : php.NativeArray;
	function selectCollection(db : String, collection : String) : _MongoCollection;
	function selectDB(name : String) : _MongoDB;
	@:overload(function():Bool{})
	function setSlaveOkay() : Bool;
	function switchSlave() : String;
}

@:native('MongoDB') extern class _MongoDB
{
	static var PROFILING_OFF : Int;
	static var PROFILING_SLOW : Int;
	static var PROFILING_ON : Int;

	var w : Int;
	var wtimeout : Int;

	function new(conn : Mongo, name : String) : Void;
	function authenticate(username : String, password : String) : php.NativeArray;
	@:overload(function(command : php.NativeArray) : php.NativeArray{})
	function command(command : php.NativeArray, options : php.NativeArray) : php.NativeArray;
	@:overload(function(name : String) : _MongoCollection{})
	@:overload(function(name : String, capped : Bool) : _MongoCollection{})
	@:overload(function(name : String, capped : Bool, size : Int) : _MongoCollection{})
	function createCollection(name : String, capped : Bool, size : Int, max : Int) : _MongoCollection;
	@:overload(function(collection : String, ob : php.NativeArray) : php.NativeArray{})
	function createDBRef(collection : String, id : _MongoId) : php.NativeArray;
	function drop() : php.NativeArray;
	@:overload(function(code : _MongoCode) : php.NativeArray{})
	@:overload(function(code : _MongoCode, args : php.NativeArray) : php.NativeArray{})
	@:overload(function(code : String) : php.NativeArray{})
	function execute(code : String, args : php.NativeArray) : php.NativeArray;
	function forceError() : Bool;
	function getDBRef(ref : php.NativeArray) : php.NativeArray;
	@:overload(function() : _MongoGridFS{})
	function getGridFs(prefix : String) : _MongoGridFS;
	function getProfilingLevel() : Int;
	function getSlaveOkay() : Bool;
	function lastError() : php.NativeArray;
	function prevError() : php.NativeArray;
	@:overload(function() : php.NativeArray{})
	@:overload(function(preserve_cloned_files : Bool) : php.NativeArray{})
	function listCollections(preserve_cloned_files : Bool, backup_original_files : Bool) : php.NativeArray;
	function resetError() : php.NativeArray;
	function selectCollection(name : String) : _MongoCollection;
	function setProfilingLevel(level : Int) : Int;
	@:overload(function() : Bool{})
	function setSlaveOkay(ok : Bool) : Bool;
}

@:native('MongoCollection') extern class _MongoCollection
{
	var db : _MongoDB;
	var w : Int;
	var wtimeout : Int;

	function new(db : _MongoDB, name : String) : Void;

	@:overload(function(a : php.NativeArray) : Bool{})
	function batchInsert(a : php.NativeArray, options : php.NativeArray) : Dynamic;
	@:overload(function() : Int{})
	@:overload(function(query : php.NativeArray) : Int{})
	@:overload(function(query : php.NativeArray, limit : Int) : Int{})
	function count(query : php.NativeArray, limit : Int, skip : Int) : Int;
	function createDBRef(a : php.NativeArray) : php.NativeArray;
	@:overload(function(keys : php.NativeArray) : php.NativeArray{})
	function deleteIndex(keys : String) : php.NativeArray;
	function deleteIndexes() : php.NativeArray;
	function drop() : php.NativeArray;
	@:overload(function(keys : String) : Bool{})
	@:overload(function(keys : php.NativeArray) : Bool{})
	@:overload(function(keys : php.NativeArray, options : php.NativeArray) : Bool{})
	function ensureIndex(keys : String, options : php.NativeArray) : Bool;
	@:overload(function() : _MongoCursor{})
	@:overload(function(query : php.NativeArray) : _MongoCursor{})
	function find(query : php.NativeArray, fields : php.NativeArray) : _MongoCursor;
	@:overload(function() : php.NativeArray{})
	@:overload(function(query : php.NativeArray) : php.NativeArray{})
	function findOne(query : php.NativeArray, fields : php.NativeArray) : php.NativeArray;
	function getDBRef(arr : php.NativeArray) : php.NativeArray;
	function getIndexInfo() : php.NativeArray;
	function getName() : String;
	function getSlaveOkay() : Bool;
	@:overload(function(keys : php.NativeArray, initial : php.NativeArray, reduce : _MongoCode) : php.NativeArray{})
	@:overload(function(keys : _MongoCode, initial : php.NativeArray, reduce : _MongoCode) : php.NativeArray{})
	@:overload(function(keys : _MongoCode, initial : php.NativeArray, reduce : _MongoCode, options : php.NativeArray) : php.NativeArray{})
	function group(keys : php.NativeArray, initial : php.NativeArray, reduce : _MongoCode, options : php.NativeArray) : php.NativeArray;
	@:overload(function(a : php.NativeArray, options : php.NativeArray) : Dynamic{})
	function insert(a : php.NativeArray) : Bool;
	@:overload(function(criteria : php.NativeArray) : Bool{})
	function remove(criteria : php.NativeArray, options : php.NativeArray) : Dynamic;
	@:overload(function() : Bool{})
	function setSlaveOkay(ok : Bool) : Bool;
	@:overload(function(criteria : php.NativeArray, new_object : php.NativeArray) : Bool{})
	function update(criteria : php.NativeArray, new_object : php.NativeArray, options : php.NativeArray) : Dynamic;
	@:overload(function(scan_data : Bool) : php.NativeArray{})
	function validate() : php.NativeArray;
}

@:native('MongoCursor') extern class _MongoCursor
{
//	static var slaveOkay : Bool;
//	static var timeout : Int;

	@:overload(function(connection : Mongo, ns : String) : Void{})
	@:overload(function(connection : Mongo, ns : String, query : php.NativeArray) : Void{})
	function new(connection : Mongo, ns : String, query : php.NativeArray, fields : php.NativeArray) : Void;
	function addOption(key : String, value : Dynamic) : _MongoCursor;
	function batchSize(num : Int) : _MongoCursor;
	@:overload(function() : Int{})
	function count(foundOnly : Bool) : Int;
	function current() : php.NativeArray;
	function dead() : Bool;
	function doQuery() : Void;
	function explain() : php.NativeArray;
	function fields(f : php.NativeArray) : _MongoCursor;
	function getNext() : php.NativeArray;
	function hasNext() : Bool;
	function hint(key_pattern : php.NativeArray) : _MongoCursor;
	@:overload(function() : _MongoCursor{})
	function immortal(liveForever : Bool) : _MongoCursor;
	function info() : php.NativeArray;
	function key() : String;
	function limit(num : Int) : _MongoCursor;
	function next() : Void;
	@:overload(function() : _MongoCursor{})
	function partial(okay : Bool) : _MongoCursor;
	function reset() : Void;
	function rewind() : Void;
	function skip(num : Int) : _MongoCursor;
	@:overload(function() : _MongoCursor{})
	function slaveOkay(okay : Bool) : _MongoCursor;
	function snapshot() : _MongoCursor;
	function sort(fields : php.NativeArray) : _MongoCursor;
	@:overload(function() : _MongoCursor{})
	function tailable(tail : Bool) : _MongoCursor;
	function timeout(ms : Int) : _MongoCursor;
	function valid() : Bool;
}

@:native('MongoId') extern class _MongoId
{
	
}

@:native('MongoCode') extern class _MongoCode
{
	
}

@:native('MongoGridFS') extern class _MongoGridFS
{
	
}

@:native('MongoBinData') extern class _MongoBinData
{
	@:overload(function(data : String) : Void{})
	function new(data : String, type : Int) : Void;
	var type : Int;
	var bin : String;
}