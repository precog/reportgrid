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

import rg.query.Query;
import rg.data.IExecutorReportGrid;
import rg.util.Periodicity;
using Arrays;

class ReportGridQuery extends ReportGridBaseQuery<ReportGridQuery>
{
	public static function create(executor : IExecutorReportGrid)
	{
		var start = new ReportGridQuery(executor),
			query = start._createQuery(null, start);
		start._next = query;
		return query;
	}

	function new(executor : IExecutorReportGrid)
	{
		super(null, this);
		this.executor = executor;
	}

	override public function execute(handler : Array<Dynamic> -> Void)
	{
		Query.executeHandler(this, handler);
	}
}

class ReportGridBaseQuery<This : ReportGridBaseQuery<Dynamic>> extends BaseQuery<This>
{
	public var executor : IExecutorReportGrid;
	public function new(async : AsyncStack, first : BaseQuery<This>)
	{
		super(async, first);
	}

	public function paths(?p : { ?parent : String }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { parent : String }, handler) {
			executor.children(
				params.parent,
				{ type : "path" },
				_complete(ReportGridTransformers.childrenPath, params, keep, handler)
			);
		});
	}

	public function events(?p : { ?path : String }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String }, handler) {
			executor.children(
				params.path,
				{ type : "property" },
				_complete(ReportGridTransformers.childrenEvent, params, keep, handler)
			);
		});
	}

	public function properties(?p : { ?path : String, ?event : String }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String }, handler) {
			executor.children(
				params.path,
				{ property : params.event },
				_complete(ReportGridTransformers.childrenProperty, params, keep, handler)
			);
		});
	}

	public function values(?p : { ?path : String, ?event : String, ?property : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?where : Dynamic, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, property : String, ?tag : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?where : Dynamic, ?disablecache : Bool }, handler) {
			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params, { property : params.event + _prefixProperty(params.property) });
			if(null != params.where)
				options.where = _where(params.event, params.where);
			executor.propertyValues(
				params.path,
				options,
				_complete(ReportGridTransformers.propertyValues, params, keep, handler)
			);
		});
	}

	public function count(?p : { ?path : String, ?event : String, ?property : String, ?value : Dynamic, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?where : Dynamic, ?disablecache : Bool, ?tag : String }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, ?property : String, ?value : Dynamic, ?where : Dynamic, ?disablecache : Bool, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String }, handler) {
// TODO tag?
			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params);
			if(null != params.where)
			{
				if(null != params.property) _error("the 'where' and the 'property' fields cannot be used together in a count query");
				else if(null != params.value) _error("the 'where' and the 'value' fields cannot be used together in a count query");
// TODO tag?
				options.where = _where(params.event, params.where);
				executor.searchCount(
					params.path,
					options,
					_complete(null != params.tag ? ReportGridTransformers.eventCountTag : ReportGridTransformers.eventCount, params, keep, handler)
				);
			} else if(null != params.property)
			{
				if(null == params.value) _error("can't count on a property");
// TODO tag?
				options.property = params.event + _prefixProperty(params.property);
				options.value = params.value;
				executor.propertyValueCount(
					params.path,
					options,
					_complete(null != params.tag ? ReportGridTransformers.propertyValueCountTag : ReportGridTransformers.propertyValueCount, params, keep, handler)
				);
			} else {
				options.property = params.event;
				executor.propertyCount(
					params.path,
					options,
					_complete(null != params.tag ? ReportGridTransformers.eventCountTag : ReportGridTransformers.eventCount, params, keep, handler)
				);
			}
		});
	}

	public function summary(?p : { ?path : String, ?event : String, ?property : String, ?type : String, ?where : Dynamic, ?disablecache : Bool, ?tag : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, property : String, ?type : String, ?where : Dynamic, ?disablecache : Bool, ?tag : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float }, handler) {
// TODO tag?
// TODO time range?
			if(null == params.type)
				params.type = "mean";
			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params);
			options.property = params.event + _prefixProperty(params.property);
			options.periodicity = "single";
			if(null != params.where)
				options.where = _where(params.event, params.where);
			switch(params.type.toLowerCase())
			{
				case "mean":
					executor.propertyMeans(
						params.path,
						options,
						_complete(ReportGridTransformers.propertySummary, params, keep, handler)
					);
				case "standarddeviation":
					executor.propertyStandardDeviations(
						params.path,
						options,
						_complete(ReportGridTransformers.propertySummary, params, keep, handler)
					);
				case "sum":
					executor.propertySums(
						params.path,
						options,
						_complete(ReportGridTransformers.propertySummary, params, keep, handler)
					);
				default:
					_error(Std.format("invalid summary type: '${params.type}'"));
			}
		});
	}

	public function summarySeries(?p : { ?path : String, ?event : String, ?property : String, ?type : String, ?tag : String, ?timezone : Dynamic, ?groupby : String, ?where : Dynamic, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, property : String, ?type : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?periodicity : String, ?tag : String, ?timezone : Dynamic, ?groupby : String, ?where : Dynamic, ?disablecache : Bool }, handler) {
// TODO tag?
// TODO groupBy
			if(null == params.type)
				params.type = "mean";
			_ensureTimeParams(params);
			var options = _defaultSeriesOptions(params);
			options.property = params.event + _prefixProperty(params.property);
			var tranform  : Dynamic -> Dynamic -> Array<String> -> Array<Dynamic> = ((null != params.tag)
				? cast ReportGridTransformers.propertySummarySeriesTagGroupedBy
				: cast ReportGridTransformers.propertySummarySeries);
			if(null != params.where)
				options.where = _where(params.event, params.where);
			switch(params.type.toLowerCase())
			{
				case "mean":
					executor.propertyMeans(
						params.path,
						options,
						_complete(tranform, params, keep, handler)
					);
				case "standarddeviation":
					executor.propertyStandardDeviations(
						params.path,
						options,
						_complete(tranform, params, keep, handler)
					);
				case "sum":
					executor.propertySums(
						params.path,
						options,
						_complete(tranform, params, keep, handler)
					);
				default:
					_error(Std.format("invalid summary type: '${params.type}'"));
			}
		});
	}

// TODO tag?
	public function intersect(?p : { ?path : String, ?event : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?properties : Array<{ property : String, ?top : Int, ?bottom : Int }>, ?tag : String, ?where : Dynamic, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, properties : Array<{ property : String, ?top : Int, ?bottom : Int }>, ?tag : String, ?where : Dynamic, ?disablecache : Bool }, handler) {

			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params, { periodicity : "eternity" }),
				properties = [];
				options.properties = properties;
			if(null != params.where)
				options.where = _where(params.event, params.where);
			for(i in 0...params.properties.length)
			{
				var item = params.properties[i];
				if(Std.is(item, String))
				{
					item = params.properties[i] = { property : cast item };
				}
				var o : Dynamic = { property : params.event + _prefixProperty(item.property) };
				if(null != item.top)
				{
					if(null != item.bottom)
						_error("you can't specify both 'top' and 'bottom' for the same property");
					o.order = "descending";
					o.limit = item.top;
				} else if(null != item.bottom)
				{
					o.order = "ascending";
					o.limit = item.bottom;
				}
				properties.push(o);
			}

			executor.intersect(
				params.path,
				options,
				_complete(null != params.tag ? ReportGridTransformers.intersectTag : ReportGridTransformers.intersect, params, keep, handler)
			);
		});
	}

// TODO tag?
// TODO groupBy?
	public function intersectSeries(?p : { ?path : String, ?event : String, ?periodicity : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?properties : Array<{ property : String, ?top : Int, ?bottom : Int }>, ?tag : String, ?timezone : Dynamic, ?groupby : String, ?where : Dynamic, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, ?periodicity : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, properties : Array<{ property : String, ?top : Int, ?bottom : Int }>, ?tag : String, ?timezone : Dynamic, ?groupby : String, ?where : Dynamic, ?disablecache : Bool }, handler) {
			_ensureTimeParams(params);
			var options = _defaultSeriesOptions(params),
				properties = [];

			options.properties = properties;
			if(null != params.where)
				options.where = _where(params.event, params.where);
			for(i in 0...params.properties.length)
			{
				var item = params.properties[i];
				if(Std.is(item, String))
				{
					item = params.properties[i] = { property : cast item };
				}
				var o : Dynamic = { property : params.event + _prefixProperty(item.property) };
				if(null != item.top)
				{
					if(null != item.bottom)
						_error("you can't specify both 'top' and 'bottom' for the same property");
					o.order = "descending";
					o.limit = item.top;
				} else if(null != item.bottom)
				{
					o.order = "ascending";
					o.limit = item.bottom;
				}
				properties.push(o);
			}

			executor.intersect(
				params.path,
				options,
				_complete(null != params.tag ? ReportGridTransformers.intersectSeriesTag : ReportGridTransformers.intersectSeries, params, keep, handler)
			);
		});
	}


// TODO timerange?
// TODO tag?
	public function histogram(?p : { ?path : String, ?event : String, ?property : String, ?top : Int, ?bottom : Int, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String, ?where : Dynamic, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, property : String, ?top : Int, ?bottom : Int, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String, ?where : Dynamic, ?disablecache : Bool }, handler) {
			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params, { property : params.event + _prefixProperty(params.property) });
			if(null != params.top)
			{
				if(null != params.bottom)
					_error("you can't specify both 'top' and 'bottom' in the same query");
				options.top = params.top;
			} else if(null != params.bottom)
			{
				options.bottom = params.bottom;
			}
			if(null != params.where)
				options.where = _where(params.event, params.where);
			executor.histogram(
				params.path,
				options,
				_complete(null != params.tag ? ReportGridTransformers.histogramTag : ReportGridTransformers.histogram, params, keep, handler)
			);
		});
	}

	public function propertiesHistogram(?p : { ?path : String, ?event : String, ?property : String, ?top : Int, ?bottom : Int, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, property : String, ?top : Int, ?bottom : Int, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String, ?disablecache : Bool }, handler) {
		// TODO tag?
			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params, { property : params.event + _prefixProperty(params.property) });
			executor.propertiesHistogram(
				params.path,
				options,
				_complete(ReportGridTransformers.propertiesHistogram, params, keep, handler)
			);
		});
	}

	public function series(?p : { ?path : String, ?event : String, ?property : String, ?value : Dynamic, ?periodicity : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?where : Dynamic, ?disablecache : Bool, ?tag : String, ?timezone : Dynamic, ?groupby : String }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, ?property : String, ?value : Dynamic, ?periodicity : String, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?where : Dynamic, ?disablecache : Bool, ?tag : String, ?timezone : Dynamic, ?groupby : String }, handler) {
			_ensureTimeParams(params);
			var options : Dynamic = _defaultSeriesOptions(params);
			if(null != params.where)
			{
				if(null != params.property) _error("the 'where' and the 'property' fields cannot be used together in a count query");
				else if(null != params.value) _error("the 'where' and the 'value' fields cannot be used together in a count query");
// TODO tag?
				options.where = _where(params.event, params.where);
				executor.searchSeries(
					params.path,
					options,
					_complete((null != params.tag)
						? cast ReportGridTransformers.eventSeriesTagGroupedBy
						: ReportGridTransformers.eventSeries, params, keep, handler)
				);
			} else if(null != params.property)
			{
				if(null == params.value) _error("can't count on a property");
// TODO tag?
// TODO groupBy?
				options.property = params.event + _prefixProperty(params.property);
				options.value = params.value;
				executor.propertyValueSeries(
					params.path,
					options,
					_complete((null != params.tag)
						? cast ReportGridTransformers.propertyValueSeriesTagGroupedBy
						: ReportGridTransformers.propertyValueSeries, params, keep, handler)
				);
			} else {
// TODO tag?
// TODO groupBy?
				options.property = params.event;
				executor.propertySeries(
					params.path,
					options,
					_complete((null != params.tag)
						? cast ReportGridTransformers.eventSeriesTagGroupedBy
						: ReportGridTransformers.eventSeries, params, keep, handler)
				);
			}
		});
	}

	public function rawEvents(?p : { ?path : String, ?event : String, ?limit : Int, ?properties : Dynamic, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String, ?where : Dynamic, ?disablecache : Bool }, ?keep : Array<String>)
	{
		keep = _normalizeKeep(keep);
		return _crossp(p).asyncEach(function(params : { path : String, event : String, ?limit : Int, ?properties : Dynamic, ?start : Dynamic, ?end : Dynamic, ?tzoffset : Float, ?tag : String, ?where : Dynamic, ?disablecache : Bool }, handler) {
			_ensureOptionalTimeParams(params);
			var options : Dynamic = _defaultOptions(params, { event : params.event });
			if(null != params.properties)
			{
				if(Std.is(params.properties, Arrays))
				{
					var arr : Array<String> = params.properties;
					options.properties = arr.join(",");
				} else {
					options.properties = params.properties;
				}
			}
			if(null != params.limit)
			{
				options.limit = params.limit;
			}
			if(null != params.where)
				options.where = _where(params.event, params.where);
			executor.events(
				params.path,
				options,
				_complete(ReportGridTransformers.events, params, keep, handler)
			);
		});
	}

	static function _defaultOptions(params : { ?start : Dynamic, ?end : Dynamic, ?tag : String, ?tzoffset : Float, ?disablecache : Bool }, ?options : Dynamic) : Dynamic
	{
		if(null == options)
			options = {};
		if(null != params.tag)
		{
			options.tag = params.tag;
			Reflect.setField(options, params.tag, Reflect.field(params, params.tag));
		}
		if(null != params.disablecache)
		{
			options.disablecache = params.disablecache;
		}
		if(null == params.start)
			return options;
		options.start = params.start;
		options.end   = params.end;
		if(null != params.tzoffset)
			options.tzoffset = params.tzoffset;
		return options;
	}

	static function _defaultSeriesOptions(params : { start : Dynamic, end : Dynamic, ?tzoffset : Float, periodicity : String, ?tag : String, ?timezone : Dynamic, ?groupby : String, ?disablecache : Bool }, ?options : Dynamic) : Dynamic
	{
		options = _defaultOptions(params, options);
		options.periodicity = params.periodicity;
		if(null != params.timezone)
			options.timeZone = params.timezone;
		if(null != params.groupby)
			options.groupBy = params.groupby;
		return options;
	}

	static function _ensureOptionalTimeParams(params : { ?start : Dynamic, ?end : Dynamic })
	{
		if(null == params.start && null == params.end)
			return;
		if(null == params.start)
		{
			params.end   = _date(params.end);
			params.start = params.end - 24 * 60 * 60 * 1000;
		} else if(null == params.end) {
			params.start = _date(params.start);
			params.end   = _date("now");
		} else {
			params.start = _date(params.start);
			params.end = _date(params.end);
		}
		if(params.start > params.end)
		{
			var t = params.end;
			params.end   = params.start;
			params.start = t;
		}
	}

	static function _ensureTimeParams(params : { ?start : Dynamic, ?end : Dynamic, ?periodicity : String })
	{
		params.start = _date(null == params.start ? "24 hours ago" : params.start);
		params.end   = _date(null == params.end ? "now" : params.end);
		if(params.start > params.end)
		{
			var t = params.end;
			params.end   = params.start;
			params.start = t;
		}
		params.periodicity = params.periodicity == null ? Periodicity.defaultPeriodicity(params.end - params.start) : params.periodicity;
	}

	static function _date(v : Dynamic) : Float
	{
		if(Std.is(v, Date))
			return v.getTime();
		else if(Std.is(v, String))
			return thx.date.DateParser.parse(v).getTime();
		else if(Std.is(v, Float))
			return v;
		else {
			_error(Std.format("invalid date format for $v"));
			return null;
		}
	}

	static function _where(event : String, where : Dynamic)
	{
		var ob : Dynamic = {};
		Objects.each(where, function(key, value) {
			Reflect.setField(ob, event + _prefixProperty(key), value);
		});
		return ob;
	}

	static function _error(s : String)
	{
		throw new thx.error.Error(s);
	}

	static function _complete(transformer : Dynamic -> Dynamic -> Array<String> -> Array<Dynamic>, params : Dynamic, ?keep : Array<String>, handler : Array<Dynamic> -> Void)
	{
		return function(data : Dynamic)
		{
			var result = transformer(data, params, keep);
			handler(result);
		};
	}

	inline static function _prefixProperty(p : String) return (p.substr(0, 1) == '.' ? '' : '.') + p

	inline function _crossp(p : Dynamic) : This
	{

		return data(_params(p)).stackCross();
//		return cross(_params(p));
	}

	inline function _params(p : Dynamic) : Array<Dynamic> return null == p ? [{}] : (Std.is(p, Array) ? p : [p])

	override function _createQuery(async : AsyncStack, first : BaseQuery<This>) : BaseQuery<This>
	{
		var query = new ReportGridBaseQuery(async, first);
		query.executor = executor;
		return query;
	}

	inline function _normalizeKeep(k : Array<String>) : Array<String>
	{
		return null == k ? [] : (Std.is(k, String) ? cast [k] : k);
	}

	static function __init__() untyped
	{
		var r = window.ReportGrid ? window.ReportGrid : (window["ReportGrid"] = {});
		r['$'] = r['$'] || {};
		r['$']['pk'] = r['$']['pk'] || {};
		r['$']['pk']['rg_query_ReportGridBaseQuery'] = r['$']['pk']['rg_query_ReportGridBaseQuery'] || __js__("rg.query.ReportGridBaseQuery");
		r['$']['pk']['rg_query_ReportGridQuery'] = r['$']['pk']['rg_query_ReportGridQuery'] || __js__("rg.query.ReportGridQuery");
	}
}