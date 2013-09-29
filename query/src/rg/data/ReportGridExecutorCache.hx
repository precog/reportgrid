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
package rg.data;

import rg.data.IExecutorReportGrid;
import rg.storage.IStorage;
using Iterators;
using Arrays;

class ReportGridExecutorCache implements IExecutorReportGrid
{
	static var DATE_PREFIX = "D:";
	static var VALUE_PREFIX = "V:";
	public var timeout(default, null) : Int;
	var executor : IExecutorReportGrid;
	var storage : IStorage;
	var queue : Map<String, Array<Dynamic -> Void>>;
	public function new(executor : IExecutorReportGrid, storage : IStorage, timeout : Int)
	{
		this.executor = executor;
		this.storage = storage;
		queue = new Map ();
		this.timeout = timeout;
		cleanOld();
	}

	public function children(path : String, options : { ?type : String, ?property : String}, success : Array<String> -> Void, ?error : String -> Void) : Void
	{
		execute("children", path, options, success, error);
	}

	public function propertyCount(path : String, options : { property : String }, success : Int -> Void, ?error : String -> Void) : Void
	{
		execute("propertyCount", path, options, success, error);
	}

	public function propertySeries(path : String, options : { property : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void
	{
		execute("propertySeries", path, options, success, error);
	}

	public function propertyMeans(path : String, options : { property : String, periodicity : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void
	{
		execute("propertyMeans", path, options, success, error);
	}

	public function propertyStandardDeviations(path : String, options : { property : String, periodicity : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void
	{
		execute("propertyStandardDeviations", path, options, success, error);
	}

	public function propertySums(path : String, options : { property : String, periodicity : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void
	{
		execute("propertySums", path, options, success, error);
	}

	public function propertyValues(path : String, options : { property : String }, success : Array<Dynamic> -> Void, ?error : String -> Void) : Void
	{
		execute("propertyValues", path, options, success, error);
	}

	public function propertyValueCount(path : String, options : { property : String, value : Dynamic }, success : Int -> Void, ?error : String -> Void) : Void
	{
		execute("propertyValueCount", path, options, success, error);
	}

	public function propertyValueSeries(path : String, options : { property : String, value : Dynamic }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void
	{
		execute("propertyValueSeries", path, options, success, error);
	}

	public function searchCount(path : String, options : { }, success : Int -> Void, ?error : String -> Void) : Void
	{
		execute("searchCount", path, options, success, error);
	}

	public function searchSeries(path : String, options : { }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void
	{
		execute("searchSeries", path, options, success, error);
	}

	public function intersect(path : String, options : { }, success : Dynamic<Dynamic> -> Void, ?error : String -> Void) : Void
	{
		execute("intersect", path, options, success, error);
	}

	public function histogram(path : String, options : { property : String, ?top : Int, ?bottom : Int }, success : Int -> Void, ?error : String -> Void) : Void
	{
		execute("histogram", path, options, success, error);
	}

	public function propertiesHistogram(path : String, options : { property : String, ?top : Int, ?bottom : Int }, success : Int -> Void, ?error : String -> Void) : Void
	{
		execute("propertiesHistogram", path, options, success, error);
	}

	public function events(path : String, options : { event : String }, success : Array<Dynamic> -> Void, ?error : String -> Void) : Void
	{
		execute("events", path, options, success, error);
	}

	public function setCacheTimeout(t : Int)
	{
		timeout = t;
	}

	function execute(name : String, path : String, options : Dynamic, success : Dynamic -> Void, ?error : String -> Void)
	{
		normalizePeriod(options);
		var id = uidquery(name, path, options),
			val = cacheGet(id);
		if(null != val)
		{
			success(val);
			return;
		}
		var q = getQueue(id);
		if(null != q)
		{
			q.push(success);
		}
		else
		{
			Reflect.field(executor, name)(path, options, storageSuccess(id, success), error);
		}
	}

	function normalizePeriod(options : { ?periodicity : String, ?start : Float, ?end : Float })
	{
		var periodicity = options.periodicity;
		if(null == periodicity && options.start != null && options.end != null)
			periodicity = rg.util.Periodicity.defaultPeriodicity(options.end-options.start);
		if(null == periodicity)
			return;
		if(null != options.start && periodicity != "single")
			options.start = Dates.snap(options.start, periodicity, -1);
		if(null != options.end && periodicity != "single")
			options.end = Dates.snap(options.end, periodicity, -1);
	}

	function storageSuccess(id : String, success : Dynamic)
	{
		queue.set(id, []);
		return function(r : Dynamic)
		{
			if(timeout > 0)
			{
				cacheSet(id, r);
				delayedCleanup(id);
			}
			success(r);
			var q = queue.get(id);
			if(null != q)
				for(item in q)
					item(r);
			queue.remove(id);
		}
	}

	function clearValueIfOld(id : String)
	{
		var idd = idDate(id);
		var v = storage.get(idd);
		if(null == v)
			return;
		if(v < Date.now().getTime() - timeout * 1000)
		{
			storage.remove(idd);
			storage.remove(idValue(id));
		}
	}

	function delayedCleanup(id : String)
	{
		haxe.Timer.delay(function() {
			cacheRemove(id);
		}, timeout * 1000);
	}

	function cacheSet(id : String, value : Dynamic)
	{
		storage.set(idDate(id), Date.now().getTime());
		storage.set(idValue(id), value);
	}

	function cacheGet(id : String)
	{
		clearValueIfOld(id);
		var v = storage.get(idValue(id));
		if(null != v) delayedCleanup(id);
		return v;
	}

	function cacheRemove(id : String)
	{
		storage.remove(idDate(id));
		storage.remove(idValue(id));
	}

	function ids()
	{
		var len = VALUE_PREFIX.length;
		return storage.keys().filter(function(cid) {
			return cid.substr(0, len) == VALUE_PREFIX;
		}).map(function(cid) {
			return cid.substr(len);
		});
	}

	function cleanOld()
	{
		for(id in ids())
		{
			clearValueIfOld(id);
		}
	}

	function getQueue(id : String)
	{
		if(timeout < 0)
			return null;
		return queue.get(id);
	}


	inline function idDate(id : String) return DATE_PREFIX + id
	inline function idValue(id : String) return VALUE_PREFIX + id

	function uidquery(method : String, path : String, options : Dynamic)
	{
		var s = method + ":" + path + ":" + thx.json.Json.encode(options);
		return haxe.Md5.encode(s);
	}
}