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

import thx.date.DateParser;

using Arrays;

class ReportGridTransformers
{
	public static function childrenPath(arr : Array<String>, params : { parent : String }, keep : Array<String>) : Array<{ parent : String, path : String }>
	{
		var parent = params.parent,
			prefix = parent == '/' ? '' : parent;
		return arr.map(function(path) {
			var o = {
				parent : parent,
				path :   prefix + "/" + path
			};
			_keep(params, o, keep);
			return o;
		});
	}

	public static function childrenEvent(arr : Array<String>, params : { path : String }, keep : Array<String>) : Array<{ event : String, path : String }>
	{
		var path = params.path;
		return arr.map(function(event) {
			var o = {
				path :  path,
				event : _trimPrefix(event)
			};
			_keep(params, o, keep);
			return o;
		});
	}

	public static function childrenProperty(arr : Array<String>, params : { path : String, event : String }, keep : Array<String>) : Array<{ event : String, path : String, property : String }>
	{
		var path  = params.path,
			event = params.event;
		return arr.map(function(property) {
			var o = {
				path :  path,
				event : event,
				property : _trimPrefix(property),
			};
			_keep(params, o, keep);
			return o;
		});
	}

	public static function propertyValues(arr : Array<String>, params : { path : String, event : String, property : String, ?where : Dynamic }, keep : Array<String>) : Array<{ event : String, path : String, property : String, value : Dynamic }>
	{
		var path     = params.path,
			event    = params.event,
			property = params.property;
		return arr.map(function(value) {
			var o = {
				path :     path,
				event :    event,
				property : property,
				value :    value
			};
			_keep(params, o, keep);
			if(null != params.where)
				Objects.copyTo(params.where, o);
			return o;
		});
	}

	public static function histogram(arr : Array<Array<Dynamic>>, params : { property : String, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var property = params.property;
		return arr.map(function(value : Array<Dynamic>) {
			var o = {
				count : value[1]
			};
			_keep(params, o, keep);
			if(null != params.where)
				Objects.copyTo(params.where, o);
			Reflect.setField(o, property, value[0]);
			return o;
		});
	}

	public static function events(arr : Array<Dynamic>, params : { event : String }, keep : Array<String>) : Array<Dynamic>
	{
		if(keep.length == 0)
			return arr;
		else
			return arr.map(function(o) {
				_keep(params, o, keep);
				return o;
			});
	}

	public static function histogramTag(counts : Dynamic, params : { property : String, tag : String, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var tag      = params.tag,
			property = params.property;
		return Objects.map(counts, function(key : String, value : Array<Array<Dynamic>>) {
			return value.map(function(item) {
				var o = {
					count : item[1]
				};
				_keep(params, o, keep);
				if(null != params.where)
					Objects.copyTo(params.where, o);
				Reflect.setField(o, tag, Strings.trim(key, "/"));
				Reflect.setField(o, property, item[0]);
				return o;
			});
		}).flatten();
	}

	public static function propertiesHistogram(arr : Array<Array<Dynamic>>, params : { property : String, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var property = params.property;
		return arr.map(function(value : Array<Dynamic>) {
			var o = {
				count :    value[1]
			};
			_keep(params, o, keep);
			if(null != params.where)
				Objects.copyTo(params.where, o);
			Reflect.setField(o, property, Strings.ltrim(value[0], '.'));
			return o;
		});
	}

	public static function intersect(ob : Dynamic, params : { ?properties : Array<{ property : String }>, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var properties = params.properties,
			result     = [];

		for(pair in Objects.flatten(ob))
		{
			var o : Dynamic = {
				count : pair.value
			};
			if(null != params.where)
				Objects.copyTo(params.where, o);
			_keep(params, o, keep);
			for(i in 0...properties.length)
			{
				Reflect.setField(o, properties[i].property, thx.json.Json.decode(pair.fields[i]));
			}
			result.push(o);
		}
		return result;
	}

	public static function intersectTag(ob : Dynamic, params : { tag : String, ?properties : Array<{ property : String }>, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var tag        = params.tag,
			properties = params.properties,
			result     = [];
		Objects.each(ob, function(key, value) {
			for(pair in Objects.flatten(value))
			{
				var o : Dynamic = {
					count : pair.value
				};
				if(null != params.where)
					Objects.copyTo(params.where, o);
				_keep(params, o, keep);
				Reflect.setField(o, tag, Strings.trim(key, '/'));
				for(i in 0...properties.length)
				{
					Reflect.setField(o, properties[i].property, thx.json.Json.decode(pair.fields[i]));
				}
				result.push(o);
			}
		});
		return result;
	}

	public static function intersectSeries(ob : Dynamic, params : { periodicity : String, ?timezone : Dynamic, ?groupby : String, ?properties : Array<{ property : String }>, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var properties  = params.properties,
			periodicity = params.periodicity,
			timezone    = params.timezone,
			groupby     = params.groupby,
			result      = [];

		for(pair in Objects.flatten(ob))
		{
			var values : Array<Array<Dynamic>> = pair.value;
			for(item in values)
			{
				var o : Dynamic = {
					count : item[1]
				};
				if(null != params.where)
					Objects.copyTo(params.where, o);
				_keep(params, o, keep);
				_injectTime(o, item[0], periodicity, timezone, groupby);
				for(i in 0...properties.length)
				{
					Reflect.setField(o, properties[i].property, thx.json.Json.decode(pair.fields[i]));
				}
				result.push(o);
			}
		}
		return result;
	}

	public static function intersectSeriesTag(ob : Dynamic, params : { periodicity : String, tag : String, ?timezone : Dynamic, ?groupby : String, ?properties : Array<{ property : String }>, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var properties  = params.properties,
			periodicity = params.periodicity,
			tag         = params.tag,
			timezone    = params.timezone,
			groupby     = params.groupby,
			result      = [];
		Objects.each(ob, function(key, value) {
			for(pair in Objects.flatten(value))
			{
				var values : Array<Array<Dynamic>> = pair.value;
				for(item in values)
				{
					var o : Dynamic = {
						count : item[1]
					};
					if(null != params.where)
						Objects.copyTo(params.where, o);
					_keep(params, o, keep);
					_injectTime(o, item[0], periodicity, timezone, groupby);
					Reflect.setField(o, tag, Strings.trim(key, '/'));
					for(i in 0...properties.length)
					{
						Reflect.setField(o, properties[i].property, thx.json.Json.decode(pair.fields[i]));
					}
					result.push(o);
				}
			}
		});
		return result;
	}

	public static function eventCount(count : Int, params : { event : String, ?where : Dynamic }, keep : Array<String>) : Array<{ event : String, count : Int }>
	{
		var o = {
			event : params.event,
			count : count
		};
		if(null != params.where)
			Objects.copyTo(params.where, o);
		_keep(params, o, keep);
		if(null != params.where)
			Objects.copyTo(params.where, o);
		return [o];
	}

	public static function eventCountTag(counts : Dynamic, params : { event : String, tag : String, ?where : Dynamic }, keep : Array<String>) : Array<{ event : String, count : Int }>
	{
		var event = params.event,
			tag   = params.tag;
		return Objects.map(counts, function(key, count) {
			var o = {
				event : event,
				count : count
			};
			if(null != params.where)
				Objects.copyTo(params.where, o);
			_keep(params, o, keep);
			Reflect.setField(o, tag, Strings.trim(key, "/"));
			if(null != params.where)
				Objects.copyTo(params.where, o);
			return o;
		});
	}

	public static function eventSeriesTagGroupedBy(ob : Dynamic, params : { event : String, periodicity : String, ?where : Dynamic, tag : String, groupby : String }, keep : Array<String>) : Array<{ event : String, count : Int }>
	{
		var event       = params.event,
			periodicity = params.periodicity,
			where       = params.where,
			groupby     = params.groupby,
			tag         = params.tag;
		return Arrays.flatten(Objects.map(ob, function(key, values : Array<Array<Dynamic>>) {
			var result = [];
			for(item in values)
			{
				var o = {
					event : event,
					count : item[1]
				};
				if(null != params.where)
					Objects.copyTo(params.where, o);
				_keep(params, o, keep);
				Reflect.setField(o, tag, Strings.trim(key, "/"));
				_injectTime(o, item[0], periodicity, null, groupby);
				if(null != where)
					Objects.copyTo(where, o);
				result.push(o);
			}
			return result;
		}));
	}

	public static function eventSeries(values : Array<Array<Dynamic>>, params : { event : String, periodicity : String, ?where : Dynamic, ?timezone : Dynamic, ?groupby : String }, keep : Array<String>) : Array<{ event : String, count : Int }>
	{
		var event       = params.event,
			periodicity = params.periodicity,
			where       = params.where,
			timezone    = params.timezone,
			groupby     = params.groupby,
			result      = [];
		for(item in values)
		{
			var o = {
				event : event,
				count : item[1]
			};
			if(null != params.where)
				Objects.copyTo(params.where, o);
			_keep(params, o, keep);
			_injectTime(o, item[0], periodicity, timezone, groupby);
			if(null != where)
				Objects.copyTo(where, o);
			result.push(o);
		}
		return result;
	}

	public static function propertySummary(value : Array<Dynamic>, params : { type : String, ?where : Dynamic }, keep : Array<String>) : Array<{ }>
	{
		var o = { };
		if(null != params.where)
			Objects.copyTo(params.where, o);
		_keep(params, o, keep);
		Reflect.setField(o, params.type, value[0][1]);
		return [o];
	}

	public static function propertySummarySeries(values : Array<Array<Dynamic>>, params : { periodicity : String, type : String, ?timezone : String, ?groupby : String, ?where : Dynamic }, keep : Array<String>) : Array<{  }>
	{
		var periodicity = params.periodicity,
			type		= params.type,
			timezone    = params.timezone,
			groupby     = params.groupby,
			result      = [];
		for(item in values)
		{
			var o = { };
			if(null != params.where)
				Objects.copyTo(params.where, o);
			_keep(params, o, keep);
			_injectTime(o, item[0], periodicity, timezone, groupby);
			Reflect.setField(o, type, item[1]);
			result.push(o);
		}
		return result;
	}

	public static function propertySummarySeriesTagGroupedBy(ob : Dynamic, params : { periodicity : String, type : String, tag : String, groupby : String, ?where : Dynamic }, keep : Array<String>) : Array<{ }>
	{
		var periodicity = params.periodicity,
			type		= params.type,
			groupby     = params.groupby,
			tag         = params.tag;
		return Arrays.flatten(Objects.map(ob, function(key, values : Array<Array<Dynamic>>) {
			var result = [];
			for(item in values)
			{
				var o = { };
				_keep(params, o, keep);
				if(null != params.where)
					Objects.copyTo(params.where, o);
				Reflect.setField(o, tag, Strings.trim(key, "/"));
				Reflect.setField(o, type, item[1]);
				_injectTime(o, item[0], periodicity, null, groupby);
				result.push(o);
			}
			return result;
		}));
	}

	public static function propertyValueCount(count : Int, params : { property : String, value : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var o = {
			count : count
		};
		_keep(params, o, keep);
		Reflect.setField(o, params.property, params.value);
		return [o];
	}

	public static function propertyValueCountTag(counts : Dynamic, params : { property : String, value : Dynamic, tag : String, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var property = params.property,
			value    = params.value,
			tag      = params.tag;
		return Objects.map(counts, function(key, count) {
			var o = {
				count : count
			};
			if(null != params.where)
				Objects.copyTo(params.where, o);
			_keep(params, o, keep);
			Reflect.setField(o, property, value);
			Reflect.setField(o, tag, Strings.trim(key, "/"));
			return o;
		});
	}

	public static function propertyValueSeries(values : Array<Array<Dynamic>>, params : { property : String, value : Dynamic, periodicity : String, ?timezone : Dynamic, ?groupby : String, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var property    = params.property,
			periodicity = params.periodicity,
			value       = params.value,
			timezone    = params.timezone,
			groupby     = params.groupby,
			result      = [];
		for(item in values)
		{
			var o = {
				count : item[1]
			};
			if(null != params.where)
				Objects.copyTo(params.where, o);
			_keep(params, o, keep);
			Reflect.setField(o, property, value);
			_injectTime(o, item[0], periodicity, timezone, groupby);
			result.push(o);
		}
		return result;
	}

	public static function propertyValueSeriesTagGroupedBy(ob : Dynamic, params : { property : String, value : Dynamic, periodicity : String, tag : String, groupby : String, ?where : Dynamic }, keep : Array<String>) : Array<{ count : Int }>
	{
		var property    = params.property,
			value       = params.value,
			periodicity = params.periodicity,
			groupby     = params.groupby,
			tag         = params.tag;
		return Arrays.flatten(Objects.map(ob, function(key, values : Array<Array<Dynamic>>) {
			var result = [];
			for(item in values)
			{
				var o = {
					count : item[1]
				};
				if(null != params.where)
					Objects.copyTo(params.where, o);
				_keep(params, o, keep);
				Reflect.setField(ob, property, value);
				Reflect.setField(o, tag, Strings.trim(key, "/"));
				_injectTime(o, item[0], periodicity, null, groupby);
				result.push(o);
			}
			return result;
		}));
	}

	static function _keep(src : Dynamic, dst : Dynamic, tokeep : Array<String>)
	{
		for(k in tokeep)
		{
			if(Reflect.hasField(dst, k))
				continue;
			Reflect.setField(dst, k, Reflect.field(src, k));
		}
	}

	static function _injectTime(o : Dynamic, value : Dynamic, periodicity : String, timezone : Dynamic, groupby : String)
	{
		if(null != groupby)
		{
			Reflect.setField(o, periodicity, Reflect.field(value, periodicity));
			Reflect.setField(o, "groupby", groupby);
		} else if(null != timezone)
		{
			if(timezone == 0)
			{
				Reflect.setField(o, "time:" + periodicity, value.timestamp);
			} else {
				Reflect.setField(o, "time:" + periodicity, _parseTimeTZ(value.datetime));
			}
			Reflect.setField(o, "timezone", timezone);
		} else {
			Reflect.setField(o, "time:" + periodicity, _fixDay(value.timestamp, periodicity));
		}
	}

	static function _fixDay(timestamp : Float, periodicity : String)
	{
		switch(periodicity) {
			case "day":
				return Dates.snap(timestamp, periodicity, 0);
			default:
				return timestamp;
		}
	}

	static function _parseTimeTZ(s : String)
	{
		var sign = 1,
			pos = s.lastIndexOf("+");
		if(pos < 0)
		{
			sign = -1;
			pos = s.lastIndexOf("-");
		}
		var d = Date.fromString(StringTools.replace(StringTools.replace(s.substr(0, pos), "T", " "), ".000", "")),
			t = DateParser.parseTime(s.substr(pos+1));
		return d.getTime() + sign * (t.hour * 60 * 60 * 1000 + t.minute * 60 * 1000 + t.second * 1000 + t.millis);
	}

	static inline function _trimPrefix(v : String) return v.substr(1)
}