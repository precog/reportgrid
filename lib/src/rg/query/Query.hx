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
package rg.query;

import rg.util.Jsonp;
import haxe.Http;
using Arrays;

@:keep class Query extends BaseQuery<Query>
{
	public static function create()
	{
		var start = new Query(),
			query = start._createQuery(function(data : Array<Array<Dynamic>>, handler : Array<Array<Dynamic>> -> Void) { handler(data); }, start);
		start._next = query;
		return query;
	}

	function new()
	{
		super(null, this);
	}

	override public function execute(handler : Array<Dynamic> -> Void) : Void
	{
		executeHandler(this, handler);
	}

	public static function executeHandler(instance : BaseQuery<Dynamic>, handler : Array<Dynamic> -> Void)
	{
		var current : BaseQuery<Dynamic> = instance._next;
		function execute(result : Array<Array<Dynamic>>)
		{
			if(null == current._next)
			{
				handler(result.flatten());
				return;
			}
			current = current._next;
			current._async(result, execute);
		}
		execute([]);
	}
/*
	static function __init__()
	{
		Reflect.setField(untyped __js__("rg.query.Query"), "execute", untyped __js__("rg.query.Query.prototype.execute"));
	}
*/
}

@:keep class BaseQuery<This>
{
	var _first : BaseQuery<This>;
	var _next : BaseQuery<This>;
	var _async : AsyncStack;
	var _store : Map<String, Array<Array<Dynamic>>>;

	public function new(async : AsyncStack, first : BaseQuery<This>)
	{
		this._async = async;
		this._first = first;
		this._store = new Map ();
	}

	public function load(loader : (Array<Dynamic> -> Void) -> Void)
	{
		return stackAsync(function(stack, h) {
			loader(function(data) {
				stack.push(data);
				h(stack);
			});
		});
	}

	public function request(url : String, ?options : { ?type : String, ?useJsonp : Bool })
	{
		if(null == options)
			options = {
				type : "application/json",
				useJsonp : false
			};
		else {
			if(null == options.type) options.type = "application/json";
			if(null == options.useJsonp) options.useJsonp = false;
		}


		var dataHandler : Dynamic -> Array<Dynamic> = null;
		switch [options.type.toLowerCase(), options.useJsonp] {
			case ["json" | "application/json", true]:
				dataHandler = function(data) return data;
			case ["json" | "application/json", false]:
				dataHandler = function(data) return thx.json.Json.decode(data);
			case ["csv" | "text/csv", _]:
				dataHandler = function(data) return thx.csv.Csv.decode(data);
			default:
				throw 'invalid type format "${options.type}"';
		}

		var stackHandler = function(stack : Array<Array<Dynamic>>, h) {
				return function(data) {
					stack.push(dataHandler(data));
					h(stack);
				};
			},
			async = if(true == options.useJsonp) {
					function(stack : Array<Array<Dynamic>>, h) {
						Jsonp.get(url, stackHandler(stack, h), function(i, e) {}, {}, {});
					}
				} else {
					function(stack : Array<Array<Dynamic>>, h) {
						var http = new Http(url);
						http.async = true;
						http.onData = stackHandler(stack, h);
						http.request(false);
					}
				};

		return stackAsync(async);
	}

	public function data(values : Array<Dynamic>)
	{
		if(!Std.is(values, Array))
			values = [values];
		return stackAsync(function(stack, h) {
			stack.push(values);
			h(stack);
		});
	}

	public function map(handler : Dynamic -> ?Int -> Dynamic)
	{
		return transform(Transformers.map(handler));
	}

	public function audit(f : Array<Dynamic> -> Void)
	{
		return transform(function(d : Array<Dynamic>) : Array<Dynamic> {
			f(d);
			return d;
		});
	}

	public function auditItem(f : Dynamic -> Void)
	{
		return transform(function(d : Array<Dynamic>) : Array<Dynamic> {
			for(dp in d)
				f(dp);
			return d;
		});
	}

	public function console(?label : String)
	{
		return stackTransform(function(data) {
			var API : { public function log(value : Dynamic) : Void; } = untyped __js__("console");
			if(null != API)
				API.log((null == label ? "" : label + ": ") + Dynamics.string(data));
			return data;
		});
	}

	public function renameFields(o : Dynamic)
	{
		var pairs = Reflect.fields(o).map(function(d) {
			return {
				src : d,
				dst : Reflect.field(o, d)
			};
		});
		return map(function(src : Dynamic, ?_) : Dynamic {
			var out = {};
			for(pair in pairs)
			{
				Reflect.setField(out, pair.dst, Reflect.field(src, pair.src));
			}
			return out;
		});
	}

	public function toObject(field : String)
	{
		return transform(Transformers.toObject(field));
	}

	public function transform(t : Transformer)
	{
		return stackAsync(asyncTransform(t));
	}

	public function explode(f : Dynamic -> Array<Dynamic>)
	{
		return transform(function(d : Array<Dynamic>) : Array<Dynamic> {
			var results = [];
			for(dp in d) {
				var ndp = results.concat(f(dp));
				if(Std.is(ndp, Array))
					results = results.concat(ndp);
				else
					results.push(cast ndp);
			}
			return results;
		});
	}

	public function firstElement() {
		return transform(function(data) {
			return data[0];
		});
	}

	public function stackCross()
	{
		return stackTransform(Transformers.crossStack);
	}

	public function stackTransform(t : StackTransformer)
	{
		return stackAsync(stackAsyncTransform(t));
	}

	public function stackAsync(f : AsyncStack)
	{
		var query = _createQuery(f, this._first);
		this._next = query;
		return _this(query);
	}

	public function asyncAll(f : Async)
	{
		return stackAsync(function(data : Array<Array<Dynamic>>, handler : Array<Array<Dynamic>> -> Void) {
			var tot    = data.length,
				pos    = 0,
				result = [];
			function complete(i : Int, r : Array<Dynamic>)
			{
				result[i] = r;
				if(++pos == tot)
				{
					handler(result);
				}
			}
			for(i in 0...data.length)
			{
				f(data[i], complete.bind(i));
			}
		});
	}

	public function asyncEach(f : Dynamic -> (Array<Dynamic> -> Void) -> Void)
	{
		return asyncAll(function(data : Array<Dynamic>, handler : Array<Dynamic> -> Void) {
			var tot    = data.length,
				pos    = 0,
				result = [];
			function complete(i : Int, r : Array<Dynamic>)
			{
				// preserve the order of the operations
				result[i] = r;
				if(++pos == tot)
				{
					handler(result.flatten());
				}
			}
			for(i in 0...data.length)
			{
				f(data[i], complete.bind(i));
			}
		});
	}

	public function setValue(name : String, f : Dynamic)
	{
		return transform(Transformers.setField(name, f));
	}

	public function setValues(o : Dynamic)
	{
		return transform(Transformers.setFields(o));
	}

	public function mapValue(name : String, f : Dynamic)
	{
		return transform(Transformers.mapField(name, f));
	}

	public function mapValues(o : Dynamic)
	{
		return transform(Transformers.mapFields(o));
	}

	public function addIndex(?name : String, ?start : Int)
	{
		if(null == name) name = "index";
		if(null == start) start = 0;
		return fold(
			function(_, _) return start,
			function(index, dp, result)
			{
				Reflect.setField(dp, name, index);
				result.push(dp);
				return ++index;
			});
	}

	public function filter(f : Dynamic -> Bool)
	{
		return transform(Transformers.filter(f));
	}

	public function filterValues(f : Dynamic)
	{
		return transform(Transformers.filterValues(f));
	}


	public function filterValue(name : String, f : Dynamic)
	{
		return transform(Transformers.filterValue(name, f));
	}

	public function sort(f : Dynamic -> Dynamic -> Int)
	{
		return transform(Transformers.sort(f));
	}

	public function sortValue(field : String, ?ascending : Bool)
	{
		var o = {};
		Reflect.setField(o, field, null == ascending ? true : ascending);
		return sortValues(o);
	}

	public function sortValues(o : Dynamic)
	{
		var fields = [],
			orders = [];
		for(key in Reflect.fields(o))
		{
			fields.push(key);
			orders.push(Reflect.field(o, key) != false);
		}
		return sort(function(a, b) {
			var r, field;
			for(i in 0...fields.length)
			{
				field = fields[i];
				r = (orders[i] ? 1 : -1) * Dynamics.compare(Reflect.field(a, field), Reflect.field(b, field));
				if(r != 0)
					return r;
			}
			return 0;
		});
	}

	public function limit(?offset : Int, count : Int)
	{
		if(null == count)
		{
			count = offset;
			offset = 0;
		}
		return transform(Transformers.limit(offset, count));
	}

	public function reverse()
	{
		return transform(Transformers.reverse);
	}

	public function unique(?f : Dynamic -> Dynamic -> Bool)
	{
		if(null == f)
			f = Dynamics.same;
		return transform(Transformers.uniquef(f));
	}

	public function fold(startf : Array<Dynamic> -> Array<Dynamic> -> Dynamic, reducef : Dynamic -> Dynamic -> Array<Dynamic> -> Dynamic)
	{
		return transform(function(data : Array<Dynamic>) {
			var result = [],
				acc    = Reflect.isFunction(startf) ? startf(data, result) : startf;
			Arrays.each(data, function(dp, _) {
				acc = reducef(acc, dp, result);
			});
			return result;
		});
	}

	// stack operations

	public function stackMerge()
	{
		return stackAsync(stackAsyncTransform(function(data : Array<Array<Dynamic>>){
			return [data.flatten()];
		}));
	}

	public function stackDiscard(?howmany : Int)
	{
		if(null == howmany) howmany = 1;
		return stackAsync(stackAsyncTransform(function(data : Array<Array<Dynamic>>){
			for(i in 0...howmany)
				data.pop();
			return data;
		}));
	}

	public function stackKeep(?howmany : Int)
	{
		if(null == howmany) howmany = 1;
		return stackAsync(stackAsyncTransform(function(data : Array<Array<Dynamic>>){
			return data.slice(0, howmany);
		}));
	}

	public function split(f : Dynamic -> String)
	{
		if(Std.is(f, String))
		{
			var name : String = cast f;
			f = function(o) {
				return Reflect.field(o, name);
			}
		}
		return stackAsync(stackAsyncTransform(function(data : Array<Array<Dynamic>>){
			var result = [];
			for(arr in data)
			{
				result = result.concat(Transformers.split(arr, f));
			}
			return result;
		}));
	}

	public function stackRotate(?matchingf : Dynamic -> Dynamic -> Bool)
	{
		var t = Transformers.rotate(matchingf);
		return stackAsync(stackAsyncTransform(function(data : Array<Array<Dynamic>>){
			return t(data);
		}));
	}

	public function stackReverse()
	{
		return stackAsync(stackAsyncTransform(function(data : Array<Array<Dynamic>>){
			data.reverse();
			return data;
		}));
	}

	public function stackStore(?name : String)
	{
		if(null == name)
			name = "";
		return stackTransform(function(arr : Array<Array<Dynamic>>) {
			_first._store.set(name, arr.copy());
			return arr;
		});
	}

	public function stackSort(f : Array<Dynamic> -> Array<Dynamic> -> Int)
	{
		return stackTransform(function(arr : Array<Array<Dynamic>>) {
			arr.sort(f);
			return arr;
		});
	}

	public function stackSortValue(fieldName : String, ?ascending : Bool)
	{
		if(null == ascending)
			ascending = true;
		function sum(arr : Array<Dynamic>)
		{
			return Arrays.reduce(arr, function(value, item, _) {
				return value + Reflect.field(item, fieldName);
			}, 0);
		}
		return stackSort(function(a, b) {
			return (ascending ? 1 : -1) * (sum(a) - sum(b));
		});
	}

	public function stackRetrieve(?name : String)
	{
		if(null == name)
			name = "";
		return stackTransform(function(arr : Array<Array<Dynamic>>) {
			return arr.concat(_first._store.get(name));
		});
	}

	public function stackClear()
	{
		return stackTransform(function(_) {
			return [];
		});
	}

	public function execute(handler : Array<Dynamic> -> Void)
	{
		_first.execute(handler);
	}

	inline function _query(t : This) : BaseQuery<This> return cast t;

	function _createQuery(async : AsyncStack, first : BaseQuery<This>) : BaseQuery<This>
	{
		return new BaseQuery(async, first);
	}

	static function asyncTransform(t : Transformer) : AsyncStack
	{
		return function(data : Array<Array<Dynamic>>, handler : Array<Array<Dynamic>> -> Void)
		{
			for(i in 0...data.length)
				data[i] = t(data[i]);
			handler(data);
		}
	}

	static function stackAsyncTransform(t : StackTransformer) : AsyncStack
	{
		return function(data : Array<Array<Dynamic>>, handler : Array<Array<Dynamic>> -> Void)
		{
			handler(t(data));
		}
	}

	public function toString() return Type.getClassName(Type.getClass(this)).split(".").pop() + ' [next: ${null != _next}, async: ${null != _async}]';

	inline function _this(q) : This return cast q;

	static function __init__() untyped
	{
		var r = window.ReportGrid ? window.ReportGrid : (window["ReportGrid"] = {});
		r['$'] = r['$'] || {};
		r['$']['pk'] = r['$']['pk'] || {};
		r['$']['pk']['rg_query_BaseQuery'] = r['$']['pk']['rg_query_BaseQuery'] || __js__("rg.query.BaseQuery");
		r['$']['pk']['rg_query_Query'] = r['$']['pk']['rg_query_Query'] || __js__("rg.query.Query");
	}
}

typedef StackTransformer = Array<Array<Dynamic>> -> Array<Array<Dynamic>>;
typedef Transformer = Array<Dynamic> -> Array<Dynamic>;

typedef AsyncStack = Array<Array<Dynamic>> -> (Array<Array<Dynamic>> -> Void) -> Void;
typedef Async = Array<Dynamic> -> (Array<Dynamic> -> Void) -> Void;