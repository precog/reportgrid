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
package rg.app.query;
import rg.data.ReportGridExecutorCache;
import rg.data.IExecutorReportGrid;
import rg.storage.IStorage;
import rg.storage.MemoryStorage;
import rg.storage.BrowserStorage;
import rg.query.ReportGridQuery;
import thx.math.Random;
import thx.date.DateParser;
import rg.util.Periodicity;
import thx.util.MacroVersion;

class JSBridge
{
	static function createQuery(executor : IExecutorReportGrid)
	{
		var inst = ReportGridQuery.create(executor);
		var query = {};
		for(field in Type.getInstanceFields(Type.getClass(inst)))
		{
			if(field.substr(0,1) == '_' || !Reflect.isFunction(Reflect.field(inst, field)))
				continue;
			Reflect.setField(query, field, function() {
				var ob = ReportGridQuery.create(executor),
					f  = Reflect.field(ob, field);
				return Reflect.callMethod(ob, f, untyped __js__('arguments'));
			});
		}
		return query;
	}

	static function main()
	{
		var storage : IStorage;
		if(BrowserStorage.hasSessionStorage())
			storage = BrowserStorage.sessionStorage()
		else
			storage = new MemoryStorage();

		var r : Dynamic = untyped __js__("(typeof ReportGrid == 'undefined') ? (window['ReportGrid'] = {}) : ReportGrid"),
			timeout = 120,
			executor : IExecutorReportGrid = new ReportGridExecutorCache(r, storage, timeout);
		r.query = createQuery(executor);
		r.date                 = {
			range : function(a : Dynamic, b : Dynamic, p : String) {
				if (Std.is(a, String))
					a = DateParser.parse(a);
				if (null == a)
					a = Periodicity.defaultRange(p)[0];
				if (Std.is(a, Date))
					a = a.getTime();

				if (Std.is(b, String))
					b = DateParser.parse(b);
				if (null == b)
					b = Periodicity.defaultRange(p)[1];
				if (Std.is(b, Date))
					b = b.getTime();
				return Periodicity.range(a, b, p);
			},
			formatPeriodicity : function(date, periodicity)
			{
				var d : Float = Std.is(cast date, Date) ? date.getTime() : (Std.is(cast date, Float) ? cast date : thx.date.DateParser.parse(cast date).getTime() );
				return Periodicity.format(periodicity, d);
			},
			parse : DateParser.parse,
			snap : Dates.snap
		};
		r.info = null != r.info ? r.info : { };
		r.info.query = {
			version : MacroVersion.next()
		};

		var rand = new Random(666);
		r.math = {
			setRandomSeed : function(s) rand = new Random(s),
			random : function() return rand.float()
		}
		r.cache = {
			executor : executor,
			disable : function() {
				if(null == executor || Std.is(executor, ReportGridExecutorCache))
				{
					r.cache.executor = executor = r;
					r.query = createQuery(executor);
				}
			},
			enable : function() {
				if(null == executor || !Std.is(executor, ReportGridExecutorCache))
				{
					r.cache.executor = executor = new ReportGridExecutorCache(r, storage, timeout);
					r.query = createQuery(executor);
				}
			},
			setTimeout : function(t : Int) {
				executor = null;
				timeout = t;
				r.cache.enable();
			},
			memoryStorage : function() {
				executor = null;
				storage = new MemoryStorage();
				r.cache.enable();
			},
			sessionStorage : function() {
				executor = null;
				if(BrowserStorage.hasSessionStorage())
					storage = BrowserStorage.sessionStorage()
				else
					storage = new MemoryStorage();
				r.cache.enable();
			},
			localStorage : function() {
				executor = null;
				if(BrowserStorage.hasLocalStorage())
					storage = BrowserStorage.localStorage()
				else if(BrowserStorage.hasSessionStorage())
					storage = BrowserStorage.sessionStorage()
				else
					storage = new MemoryStorage();
				r.cache.enable();
			}
		};
	}

	static inline function opt(ob : Dynamic) return null == ob ? { } : Objects.clone(ob)
}