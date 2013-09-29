(function () { "use strict";
var $estr = function() { return js.Boot.__string_rec(this,''); };
function $extend(from, fields) {
	function inherit() {}; inherit.prototype = from; var proto = new inherit();
	for (var name in fields) proto[name] = fields[name];
	return proto;
}
var Arrays = function() { }
Arrays.__name__ = ["Arrays"];
Arrays.flatten = function(arr) {
	var r = [];
	var _g = 0;
	while(_g < arr.length) {
		var v = arr[_g];
		++_g;
		r = r.concat(v);
	}
	return r;
}
Arrays.string = function(arr) {
	return "[" + Iterators.map(HxOverrides.iter(arr),function(v,_) {
		return Dynamics.string(v);
	}).join(", ") + "]";
}
Arrays.last = function(arr) {
	return arr[arr.length - 1];
}
Arrays.compare = function(a,b) {
	var v;
	if((v = a.length - b.length) != 0) return v;
	var _g1 = 0, _g = a.length;
	while(_g1 < _g) {
		var i = _g1++;
		if((v = Dynamics.compare(a[i],b[i])) != 0) return v;
	}
	return 0;
}
var Bools = function() { }
Bools.__name__ = ["Bools"];
Bools.format = function(v,param,params,culture) {
	return (Bools.formatf(param,params,culture))(v);
}
Bools.formatf = function(param,params,culture) {
	params = thx.culture.FormatParams.params(param,params,"B");
	var format = params.shift();
	switch(format) {
	case "B":
		return function(v) {
			return v?"true":"false";
		};
	case "N":
		return function(v) {
			return v?"1":"0";
		};
	case "R":
		if(params.length != 2) throw "bool format R requires 2 parameters";
		return function(v) {
			return v?params[0]:params[1];
		};
	default:
		throw "Unsupported bool format: " + format;
	}
}
Bools.canParse = function(s) {
	s = s.toLowerCase();
	return s == "true" || s == "false";
}
Bools.parse = function(s) {
	return s.toLowerCase() == "true";
}
Bools.compare = function(a,b) {
	return a == b?0:a?-1:1;
}
var DateTools = function() { }
DateTools.__name__ = ["DateTools"];
DateTools.getMonthDays = function(d) {
	var month = d.getMonth();
	var year = d.getFullYear();
	if(month != 1) return DateTools.DAYS_OF_MONTH[month];
	var isB = year % 4 == 0 && year % 100 != 0 || year % 400 == 0;
	return isB?29:28;
}
var EReg = function(r,opt) {
	opt = opt.split("u").join("");
	this.r = new RegExp(r,opt);
};
EReg.__name__ = ["EReg"];
EReg.prototype = {
	customReplace: function(s,f) {
		var old = this.r.global;
		this.r.global = true;
		var ret = this.map(s,f);
		this.r.global = old;
		return ret;
	}
	,map: function(s,f) {
		var offset = 0;
		var buf = new StringBuf();
		do {
			if(offset >= s.length) break; else if(!this.matchSub(s,offset)) {
				buf.b += Std.string(HxOverrides.substr(s,offset,null));
				break;
			}
			var p = this.matchedPos();
			buf.b += Std.string(HxOverrides.substr(s,offset,p.pos - offset));
			buf.b += Std.string(f(this));
			if(p.len == 0) {
				buf.b += Std.string(HxOverrides.substr(s,p.pos,1));
				offset = p.pos + 1;
			} else offset = p.pos + p.len;
		} while(this.r.global);
		if(!this.r.global && offset < s.length) buf.b += Std.string(HxOverrides.substr(s,offset,null));
		return buf.b;
	}
	,replace: function(s,by) {
		return s.replace(this.r,by);
	}
	,matchSub: function(s,pos,len) {
		if(len == null) len = -1;
		return this.r.global?(function($this) {
			var $r;
			$this.r.lastIndex = pos;
			$this.r.m = $this.r.exec(len < 0?s:HxOverrides.substr(s,0,pos + len));
			var b = $this.r.m != null;
			if(b) $this.r.s = s;
			$r = b;
			return $r;
		}(this)):(function($this) {
			var $r;
			var b = $this.match(len < 0?HxOverrides.substr(s,pos,null):HxOverrides.substr(s,pos,len));
			if(b) {
				$this.r.s = s;
				$this.r.m.index += pos;
			}
			$r = b;
			return $r;
		}(this));
	}
	,matchedPos: function() {
		if(this.r.m == null) throw "No string matched";
		return { pos : this.r.m.index, len : this.r.m[0].length};
	}
	,matchedRight: function() {
		if(this.r.m == null) throw "No string matched";
		var sz = this.r.m.index + this.r.m[0].length;
		return this.r.s.substr(sz,this.r.s.length - sz);
	}
	,matchedLeft: function() {
		if(this.r.m == null) throw "No string matched";
		return this.r.s.substr(0,this.r.m.index);
	}
	,matched: function(n) {
		return this.r.m != null && n >= 0 && n < this.r.m.length?this.r.m[n]:(function($this) {
			var $r;
			throw "EReg::matched";
			return $r;
		}(this));
	}
	,match: function(s) {
		if(this.r.global) this.r.lastIndex = 0;
		this.r.m = this.r.exec(s);
		this.r.s = s;
		return this.r.m != null;
	}
	,r: null
	,__class__: EReg
}
var Dates = function() { }
Dates.__name__ = ["Dates"];
Dates.format = function(d,param,params,culture) {
	return (Dates.formatf(param,params,culture))(d);
}
Dates.formatf = function(param,params,culture) {
	params = thx.culture.FormatParams.params(param,params,"D");
	var format = params.shift();
	switch(format) {
	case "D":
		return function(d) {
			return thx.culture.FormatDate.date(d,culture);
		};
	case "DS":
		return function(d) {
			return thx.culture.FormatDate.dateShort(d,culture);
		};
	case "DST":
		return function(d) {
			return thx.culture.FormatDate.dateShort(d,culture) + " " + thx.culture.FormatDate.time(d,culture);
		};
	case "DSTS":
		return function(d) {
			return thx.culture.FormatDate.dateShort(d,culture) + " " + thx.culture.FormatDate.timeShort(d,culture);
		};
	case "DTS":
		return function(d) {
			return thx.culture.FormatDate.date(d,culture) + " " + thx.culture.FormatDate.timeShort(d,culture);
		};
	case "Y":
		return function(d) {
			return thx.culture.FormatDate.year(d,culture);
		};
	case "YM":
		return function(d) {
			return thx.culture.FormatDate.yearMonth(d,culture);
		};
	case "M":
		return function(d) {
			return thx.culture.FormatDate.month(d,culture);
		};
	case "MN":
		return function(d) {
			return thx.culture.FormatDate.monthName(d,culture);
		};
	case "MS":
		return function(d) {
			return thx.culture.FormatDate.monthNameShort(d,culture);
		};
	case "MD":
		return function(d) {
			return thx.culture.FormatDate.monthDay(d,culture);
		};
	case "WD":
		return function(d) {
			return thx.culture.FormatDate.weekDay(d,culture);
		};
	case "WDN":
		return function(d) {
			return thx.culture.FormatDate.weekDayName(d,culture);
		};
	case "WDS":
		return function(d) {
			return thx.culture.FormatDate.weekDayNameShort(d,culture);
		};
	case "R":
		return function(d) {
			return thx.culture.FormatDate.dateRfc(d,culture);
		};
	case "DT":
		return function(d) {
			return thx.culture.FormatDate.dateTime(d,culture);
		};
	case "U":
		return function(d) {
			return thx.culture.FormatDate.universal(d,culture);
		};
	case "S":
		return function(d) {
			return thx.culture.FormatDate.sortable(d,culture);
		};
	case "T":
		return function(d) {
			return thx.culture.FormatDate.time(d,culture);
		};
	case "TS":
		return function(d) {
			return thx.culture.FormatDate.timeShort(d,culture);
		};
	case "C":
		var f = params[0];
		if(null == f) return function(d) {
			return thx.culture.FormatDate.date(d,culture);
		}; else return function(d) {
			return thx.culture.FormatDate.format(f,d,culture,params[1] != null?params[1] == "true":true);
		};
		break;
	default:
		throw new thx.error.Error("Unsupported date format: {0}",null,format,{ fileName : "Dates.hx", lineNumber : 71, className : "Dates", methodName : "formatf"});
	}
}
Dates.snap = function(time,period,mode) {
	if(mode == null) mode = 0;
	if(mode < 0) switch(period) {
	case "second":
		return Math.floor(time / 1000.0) * 1000.0;
	case "minute":
		return Math.floor(time / 60000.0) * 60000.0;
	case "hour":
		return Math.floor(time / 3600000.0) * 3600000.0;
	case "day":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this));
		return new Date(d.getFullYear(),d.getMonth(),d.getDate(),0,0,0).getTime();
	case "week":
		return Math.floor(time / 604800000.) * 604800000.;
	case "month":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this));
		return new Date(d.getFullYear(),d.getMonth(),1,0,0,0).getTime();
	case "year":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this));
		return new Date(d.getFullYear(),0,1,0,0,0).getTime();
	default:
		return 0;
	} else if(mode > 0) switch(period) {
	case "second":
		return Math.ceil(time / 1000.0) * 1000.0;
	case "minute":
		return Math.ceil(time / 60000.0) * 60000.0;
	case "hour":
		return Math.ceil(time / 3600000.0) * 3600000.0;
	case "day":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this));
		return new Date(d.getFullYear(),d.getMonth(),d.getDate() + 1,0,0,0).getTime();
	case "week":
		return Math.ceil(time / 604800000.) * 604800000.;
	case "month":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this));
		return new Date(d.getFullYear(),d.getMonth() + 1,1,0,0,0).getTime();
	case "year":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this));
		return new Date(d.getFullYear() + 1,0,1,0,0,0).getTime();
	default:
		return 0;
	} else switch(period) {
	case "second":
		return Math.round(time / 1000.0) * 1000.0;
	case "minute":
		return Math.round(time / 60000.0) * 60000.0;
	case "hour":
		return Math.round(time / 3600000.0) * 3600000.0;
	case "day":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this)), mod = d.getHours() >= 12?1:0;
		return new Date(d.getFullYear(),d.getMonth(),d.getDate() + mod,0,0,0).getTime();
	case "week":
		return Math.round(time / 604800000.) * 604800000.;
	case "month":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this)), mod = d.getDate() > Math.round(DateTools.getMonthDays(d) / 2)?1:0;
		return new Date(d.getFullYear(),d.getMonth() + mod,1,0,0,0).getTime();
	case "year":
		var d = (function($this) {
			var $r;
			var d1 = new Date();
			d1.setTime(time);
			$r = d1;
			return $r;
		}(this)), mod = time > new Date(d.getFullYear(),6,2,0,0,0).getTime()?1:0;
		return new Date(d.getFullYear() + mod,0,1,0,0,0).getTime();
	default:
		return 0;
	}
}
Dates.canParse = function(s) {
	return Dates._reparse.match(s);
}
Dates.parse = function(s) {
	var parts = s.split(".");
	var date = HxOverrides.strDate(StringTools.replace(parts[0],"T"," "));
	if(parts.length > 1) date = (function($this) {
		var $r;
		var d = new Date();
		d.setTime(date.getTime() + Std.parseInt(parts[1]));
		$r = d;
		return $r;
	}(this));
	return date;
}
Dates.compare = function(a,b) {
	return Floats.compare(a.getTime(),b.getTime());
}
var Dynamics = function() { }
Dynamics.__name__ = ["Dynamics"];
Dynamics.string = function(v) {
	var _g = Type["typeof"](v);
	var $e = (_g);
	switch( $e[1] ) {
	case 0:
		return "null";
	case 1:
		return Ints.format(v);
	case 2:
		return Floats.format(v);
	case 3:
		return Bools.format(v);
	case 4:
		var keys = Objects.keys(v);
		var result = [];
		var _g1 = 0;
		while(_g1 < keys.length) {
			var key = keys[_g1];
			++_g1;
			result.push(key + " : " + Dynamics.string(Reflect.field(v,key)));
		}
		return "{" + result.join(", ") + "}";
	case 6:
		var _g_eTClass_0 = $e[2];
		var name = Type.getClassName(_g_eTClass_0);
		switch(name) {
		case "Array":
			return Arrays.string(v);
		case "String":
			var s = v;
			if(s.indexOf("\"") < 0) return "\"" + s + "\""; else if(s.indexOf("'") < 0) return "'" + s + "'"; else return "\"" + StringTools.replace(s,"\"","\\\"") + "\"";
			break;
		case "Date":
			return Dates.format(v);
		default:
			return Std.string(v);
		}
		break;
	case 7:
		return Enums.string(v);
	case 8:
		return "<unknown>";
	case 5:
		return "<function>";
	}
}
Dynamics.compare = function(a,b) {
	if(null == a && null == b) return 0;
	if(null == a) return -1;
	if(null == b) return 1;
	var _g = Type["typeof"](a);
	var $e = (_g);
	switch( $e[1] ) {
	case 1:
	case 2:
		return Floats.compare(a,b);
	case 3:
		return Bools.compare(a,b);
	case 4:
		return Objects.compare(a,b);
	case 6:
		var _g_eTClass_0 = $e[2];
		var name = Type.getClassName(_g_eTClass_0);
		switch(name) {
		case "Array":
			return Arrays.compare(a,b);
		case "String":
			return Strings.compare(a,b);
		case "Date":
			return Dates.compare(a,b);
		default:
			return Strings.compare(Std.string(a),Std.string(b));
		}
		break;
	case 7:
		return Enums.compare(a,b);
	default:
		return 0;
	}
}
Dynamics.clone = function(v,cloneInstances) {
	if(cloneInstances == null) cloneInstances = false;
	var _g = Type["typeof"](v);
	var $e = (_g);
	switch( $e[1] ) {
	case 0:
		return null;
	case 1:
	case 2:
	case 3:
	case 7:
	case 8:
	case 5:
		return v;
	case 4:
		var o = { };
		Objects.copyTo(v,o);
		return o;
	case 6:
		var _g_eTClass_0 = $e[2];
		var name = Type.getClassName(_g_eTClass_0);
		switch(name) {
		case "Array":
			var src = v, a = [];
			var _g1 = 0;
			while(_g1 < src.length) {
				var i = src[_g1];
				++_g1;
				a.push(Dynamics.clone(i));
			}
			return a;
		case "String":case "Date":
			return v;
		default:
			if(cloneInstances) {
				var o = Type.createEmptyInstance(_g_eTClass_0);
				var _g1 = 0, _g2 = Reflect.fields(v);
				while(_g1 < _g2.length) {
					var field = _g2[_g1];
					++_g1;
					o[field] = Dynamics.clone(Reflect.field(v,field));
				}
				return o;
			} else return v;
		}
		break;
	}
}
Dynamics.same = function(a,b) {
	var ta = Types.typeName(a), tb = Types.typeName(b);
	if(ta != tb) return false;
	var _g = Type["typeof"](a);
	var $e = (_g);
	switch( $e[1] ) {
	case 2:
		return Floats.equals(a,b);
	case 0:
	case 1:
	case 3:
		return a == b;
	case 5:
		return Reflect.compareMethods(a,b);
	case 6:
		var _g_eTClass_0 = $e[2];
		var ca = Type.getClassName(_g_eTClass_0), cb = Type.getClassName(Type.getClass(b));
		if(ca != cb) return false;
		if(js.Boot.__instanceof(a,String) && a != b) return false;
		if(js.Boot.__instanceof(a,Array)) {
			var aa = a, ab = b;
			if(aa.length != ab.length) return false;
			var _g2 = 0, _g1 = aa.length;
			while(_g2 < _g1) {
				var i = _g2++;
				if(!Dynamics.same(aa[i],ab[i])) return false;
			}
			return true;
		}
		if(js.Boot.__instanceof(a,Date)) return a.getTime() == b.getTime();
		if(js.Boot.__instanceof(a,Hash) || js.Boot.__instanceof(a,IntHash)) {
			var ha = a, hb = b;
			var ka = Iterators.array(ha.keys()), kb = Iterators.array(hb.keys());
			if(ka.length != kb.length) return false;
			var _g1 = 0;
			while(_g1 < ka.length) {
				var key = ka[_g1];
				++_g1;
				if(!hb.exists(key) || !Dynamics.same(ha.get(key),hb.get(key))) return false;
			}
			return true;
		}
		var t = false;
		if((t = Iterators.isIterator(a)) || Iterables.isIterable(a)) {
			var va = t?Iterators.array(a):Iterators.array($iterator(a)()), vb = t?Iterators.array(b):Iterators.array($iterator(b)());
			if(va.length != vb.length) return false;
			var _g2 = 0, _g1 = va.length;
			while(_g2 < _g1) {
				var i = _g2++;
				if(!Dynamics.same(va[i],vb[i])) return false;
			}
			return true;
		}
		var fields = Type.getInstanceFields(Type.getClass(a));
		var _g1 = 0;
		while(_g1 < fields.length) {
			var field = fields[_g1];
			++_g1;
			var va = Reflect.field(a,field);
			if(Reflect.isFunction(va)) continue;
			var vb = Reflect.field(b,field);
			if(!Dynamics.same(va,vb)) return false;
		}
		return true;
	case 7:
		var _g_eTEnum_0 = $e[2];
		var ea = Type.getEnumName(_g_eTEnum_0), teb = Type.getEnum(b), eb = Type.getEnumName(teb);
		if(ea != eb) return false;
		if(a[1] != b[1]) return false;
		var pa = a.slice(2), pb = b.slice(2);
		var _g2 = 0, _g1 = pa.length;
		while(_g2 < _g1) {
			var i = _g2++;
			if(!Dynamics.same(pa[i],pb[i])) return false;
		}
		return true;
	case 4:
		var fa = Reflect.fields(a), fb = Reflect.fields(b);
		var _g1 = 0;
		while(_g1 < fa.length) {
			var field = fa[_g1];
			++_g1;
			HxOverrides.remove(fb,field);
			if(!Reflect.hasField(b,field)) return false;
			var va = Reflect.field(a,field);
			if(Reflect.isFunction(va)) continue;
			var vb = Reflect.field(b,field);
			if(!Dynamics.same(va,vb)) return false;
		}
		if(fb.length > 0) return false;
		var t = false;
		if((t = Iterators.isIterator(a)) || Iterables.isIterable(a)) {
			if(t && !Iterators.isIterator(b)) return false;
			if(!t && !Iterables.isIterable(b)) return false;
			var aa = t?Iterators.array(a):Iterators.array($iterator(a)());
			var ab = t?Iterators.array(b):Iterators.array($iterator(b)());
			if(aa.length != ab.length) return false;
			var _g2 = 0, _g1 = aa.length;
			while(_g2 < _g1) {
				var i = _g2++;
				if(!Dynamics.same(aa[i],ab[i])) return false;
			}
			return true;
		}
		return true;
	case 8:
		return (function($this) {
			var $r;
			throw "Unable to compare two unknown types";
			return $r;
		}(this));
	}
	return (function($this) {
		var $r;
		throw new thx.error.Error("Unable to compare values: {0} and {1}",[a,b],null,{ fileName : "Dynamics.hx", lineNumber : 368, className : "Dynamics", methodName : "same"});
		return $r;
	}(this));
}
var Enums = function() { }
Enums.__name__ = ["Enums"];
Enums.string = function(e) {
	var cons = Type.enumConstructor(e);
	var params = [];
	var _g = 0, _g1 = Type.enumParameters(e);
	while(_g < _g1.length) {
		var param = _g1[_g];
		++_g;
		params.push(Dynamics.string(param));
	}
	return cons + (params.length == 0?"":"(" + params.join(", ") + ")");
}
Enums.compare = function(a,b) {
	var v;
	if((v = Type.enumIndex(a) - Type.enumIndex(b)) != 0) return v;
	return Arrays.compare(Type.enumParameters(a),Type.enumParameters(b));
}
var Floats = function() { }
Floats.__name__ = ["Floats"];
Floats.range = function(start,stop,step,inclusive) {
	if(inclusive == null) inclusive = false;
	if(step == null) step = 1.0;
	if(null == stop) {
		stop = start;
		start = 0.0;
	}
	if((stop - start) / step == Math.POSITIVE_INFINITY) throw new thx.error.Error("infinite range",null,null,{ fileName : "Floats.hx", lineNumber : 50, className : "Floats", methodName : "range"});
	var range = [], i = -1.0, j;
	if(inclusive) {
		if(step < 0) while((j = start + step * ++i) >= stop) range.push(j); else while((j = start + step * ++i) <= stop) range.push(j);
	} else if(step < 0) while((j = start + step * ++i) > stop) range.push(j); else while((j = start + step * ++i) < stop) range.push(j);
	return range;
}
Floats.format = function(v,param,params,culture) {
	return (Floats.formatf(param,params,culture))(v);
}
Floats.formatf = function(param,params,culture) {
	params = thx.culture.FormatParams.params(param,params,"D");
	var format = params.shift();
	var decimals = params.length > 0?Std.parseInt(params[0]):null;
	switch(format) {
	case "D":
		return function(v) {
			return thx.culture.FormatNumber.decimal(v,decimals,culture);
		};
	case "I":
		return function(v) {
			return thx.culture.FormatNumber["int"](v,culture);
		};
	case "C":
		var s = params.length > 1?params[1]:null;
		return function(v) {
			return thx.culture.FormatNumber.currency(v,s,decimals,culture);
		};
	case "P":
		return function(v) {
			return thx.culture.FormatNumber.percent(v,decimals,culture);
		};
	case "M":
		return function(v) {
			return thx.culture.FormatNumber.permille(v,decimals,culture);
		};
	default:
		return (function($this) {
			var $r;
			throw new thx.error.Error("Unsupported number format: {0}",null,format,{ fileName : "Floats.hx", lineNumber : 152, className : "Floats", methodName : "formatf"});
			return $r;
		}(this));
	}
}
Floats.canParse = function(s,strict) {
	if(strict == null) strict = false;
	if(strict) return Floats._reparseStrict.match(s); else return Floats._reparse.match(s);
}
Floats.parse = function(s) {
	if(HxOverrides.substr(s,0,1) == "+") s = HxOverrides.substr(s,1,null);
	return Std.parseFloat(s);
}
Floats.compare = function(a,b) {
	return a < b?-1:a > b?1:0;
}
Floats.equals = function(a,b,approx) {
	if(approx == null) approx = 1e-5;
	if(Math.isNaN(a)) return Math.isNaN(b); else if(Math.isNaN(b)) return false; else if(!Math.isFinite(a) && !Math.isFinite(b)) return a > 0 == b > 0;
	return Math.abs(b - a) < approx;
}
var Hash = function() {
	this.h = { };
};
Hash.__name__ = ["Hash"];
Hash.prototype = {
	keys: function() {
		var a = [];
		for( var key in this.h ) {
		if(this.h.hasOwnProperty(key)) a.push(key.substr(1));
		}
		return HxOverrides.iter(a);
	}
	,remove: function(key) {
		key = "$" + key;
		if(!this.h.hasOwnProperty(key)) return false;
		delete(this.h[key]);
		return true;
	}
	,exists: function(key) {
		return this.h.hasOwnProperty("$" + key);
	}
	,get: function(key) {
		return this.h["$" + key];
	}
	,set: function(key,value) {
		this.h["$" + key] = value;
	}
	,h: null
	,__class__: Hash
}
var HxOverrides = function() { }
HxOverrides.__name__ = ["HxOverrides"];
HxOverrides.strDate = function(s) {
	switch(s.length) {
	case 8:
		var k = s.split(":");
		var d = new Date();
		d.setTime(0);
		d.setUTCHours(k[0]);
		d.setUTCMinutes(k[1]);
		d.setUTCSeconds(k[2]);
		return d;
	case 10:
		var k = s.split("-");
		return new Date(k[0],k[1] - 1,k[2],0,0,0);
	case 19:
		var k = s.split(" ");
		var y = k[0].split("-");
		var t = k[1].split(":");
		return new Date(y[0],y[1] - 1,y[2],t[0],t[1],t[2]);
	default:
		throw "Invalid date format : " + s;
	}
}
HxOverrides.cca = function(s,index) {
	var x = s.charCodeAt(index);
	if(x != x) return undefined;
	return x;
}
HxOverrides.substr = function(s,pos,len) {
	if(pos != null && pos != 0 && len != null && len < 0) return "";
	if(len == null) len = s.length;
	if(pos < 0) {
		pos = s.length + pos;
		if(pos < 0) pos = 0;
	} else if(len < 0) len = s.length + len - pos;
	return s.substr(pos,len);
}
HxOverrides.remove = function(a,obj) {
	var i = 0;
	var l = a.length;
	while(i < l) {
		if(a[i] == obj) {
			a.splice(i,1);
			return true;
		}
		i++;
	}
	return false;
}
HxOverrides.iter = function(a) {
	return { cur : 0, arr : a, hasNext : function() {
		return this.cur < this.arr.length;
	}, next : function() {
		return this.arr[this.cur++];
	}};
}
var IntHash = function() { }
IntHash.__name__ = ["IntHash"];
var Ints = function() { }
Ints.__name__ = ["Ints"];
Ints.range = function(start,stop,step) {
	if(step == null) step = 1;
	if(null == stop) {
		stop = start;
		start = 0;
	}
	if((stop - start) / step == Math.POSITIVE_INFINITY) throw new thx.error.Error("infinite range",null,null,{ fileName : "Ints.hx", lineNumber : 19, className : "Ints", methodName : "range"});
	var range = [], i = -1, j;
	if(step < 0) while((j = start + step * ++i) > stop) range.push(j); else while((j = start + step * ++i) < stop) range.push(j);
	return range;
}
Ints.max = function(a,b) {
	return a > b?a:b;
}
Ints.format = function(v,param,params,culture) {
	return (Ints.formatf(param,params,culture))(v);
}
Ints.formatf = function(param,params,culture) {
	return Floats.formatf(null,thx.culture.FormatParams.params(param,params,"I"),culture);
}
Ints.canParse = function(s) {
	return Ints._reparse.match(s);
}
Ints.parse = function(s) {
	if(HxOverrides.substr(s,0,1) == "+") s = HxOverrides.substr(s,1,null);
	return Std.parseInt(s);
}
var Iterables = function() { }
Iterables.__name__ = ["Iterables"];
Iterables.isIterable = function(v) {
	var fields = Reflect.isObject(v) && null == Type.getClass(v)?Reflect.fields(v):Type.getInstanceFields(Type.getClass(v));
	if(!Lambda.has(fields,"iterator")) return false;
	return Reflect.isFunction(Reflect.field(v,"iterator"));
}
var Iterators = function() { }
Iterators.__name__ = ["Iterators"];
Iterators.array = function(it) {
	var result = [];
	while( it.hasNext() ) {
		var v = it.next();
		result.push(v);
	}
	return result;
}
Iterators.map = function(it,f) {
	var result = [], i = 0;
	while( it.hasNext() ) {
		var v = it.next();
		result.push(f(v,i++));
	}
	return result;
}
Iterators.filter = function(it,f) {
	var result = [];
	while( it.hasNext() ) {
		var i = it.next();
		if(f(i)) result.push(i);
	}
	return result;
}
Iterators.isIterator = function(v) {
	var fields = Reflect.isObject(v) && null == Type.getClass(v)?Reflect.fields(v):Type.getInstanceFields(Type.getClass(v));
	if(!Lambda.has(fields,"next") || !Lambda.has(fields,"hasNext")) return false;
	return Reflect.isFunction(Reflect.field(v,"next")) && Reflect.isFunction(Reflect.field(v,"hasNext"));
}
var Lambda = function() { }
Lambda.__name__ = ["Lambda"];
Lambda.has = function(it,elt,cmp) {
	if(cmp == null) {
		var $it0 = $iterator(it)();
		while( $it0.hasNext() ) {
			var x = $it0.next();
			if(x == elt) return true;
		}
	} else {
		var $it1 = $iterator(it)();
		while( $it1.hasNext() ) {
			var x = $it1.next();
			if(cmp(x,elt)) return true;
		}
	}
	return false;
}
var List = function() { }
List.__name__ = ["List"];
List.prototype = {
	iterator: function() {
		return { h : this.h, hasNext : function() {
			return this.h != null;
		}, next : function() {
			if(this.h == null) return null;
			var x = this.h[0];
			this.h = this.h[1];
			return x;
		}};
	}
	,h: null
	,__class__: List
}
var Objects = function() { }
Objects.__name__ = ["Objects"];
Objects.keys = function(o) {
	return Reflect.fields(o);
}
Objects.entries = function(o) {
	var arr = [];
	var _g = 0, _g1 = Reflect.fields(o);
	while(_g < _g1.length) {
		var key = _g1[_g];
		++_g;
		arr.push({ key : key, value : Reflect.field(o,key)});
	}
	return arr;
}
Objects.each = function(o,handler) {
	var _g = 0, _g1 = Reflect.fields(o);
	while(_g < _g1.length) {
		var key = _g1[_g];
		++_g;
		handler(key,Reflect.field(o,key));
	}
}
Objects.map = function(o,handler) {
	var results = [];
	var _g = 0, _g1 = Reflect.fields(o);
	while(_g < _g1.length) {
		var key = _g1[_g];
		++_g;
		results.push(handler(key,Reflect.field(o,key)));
	}
	return results;
}
Objects.copyTo = function(src,dst) {
	var _g = 0, _g1 = Reflect.fields(src);
	while(_g < _g1.length) {
		var field = _g1[_g];
		++_g;
		var sv = Dynamics.clone(Reflect.field(src,field));
		var dv = Reflect.field(dst,field);
		if(Reflect.isObject(sv) && null == Type.getClass(sv) && (Reflect.isObject(dv) && null == Type.getClass(dv))) Objects.copyTo(sv,dv); else dst[field] = sv;
	}
	return dst;
}
Objects.clone = function(src) {
	var dst = { };
	return Objects.copyTo(src,dst);
}
Objects._flatten = function(src,cum,arr,levels,level) {
	var _g = 0, _g1 = Reflect.fields(src);
	while(_g < _g1.length) {
		var field = _g1[_g];
		++_g;
		var clone = Objects.clone(cum);
		var v = Reflect.field(src,field);
		clone.fields.push(field);
		if(Reflect.isObject(v) && null == Type.getClass(v) && (levels == 0 || level + 1 < levels)) Objects._flatten(v,clone,arr,levels,level + 1); else {
			clone.value = v;
			arr.push(clone);
		}
	}
}
Objects.flatten = function(src,levels) {
	if(levels == null) levels = 0;
	var arr = [];
	var _g = 0, _g1 = Reflect.fields(src);
	while(_g < _g1.length) {
		var field = _g1[_g];
		++_g;
		var v = Reflect.field(src,field);
		if(Reflect.isObject(v) && null == Type.getClass(v) && levels != 1) {
			var item = { fields : [field], value : null};
			Objects._flatten(v,item,arr,levels,1);
		} else arr.push({ fields : [field], value : v});
	}
	return arr;
}
Objects.compare = function(a,b) {
	var v, fields;
	if((v = Arrays.compare(fields = Reflect.fields(a),Reflect.fields(b))) != 0) return v;
	var _g = 0;
	while(_g < fields.length) {
		var field = fields[_g];
		++_g;
		if((v = Dynamics.compare(Reflect.field(a,field),Reflect.field(b,field))) != 0) return v;
	}
	return 0;
}
var Reflect = function() { }
Reflect.__name__ = ["Reflect"];
Reflect.hasField = function(o,field) {
	return Object.prototype.hasOwnProperty.call(o,field);
}
Reflect.field = function(o,field) {
	var v = null;
	try {
		v = o[field];
	} catch( e ) {
	}
	return v;
}
Reflect.setField = function(o,field,value) {
	o[field] = value;
}
Reflect.fields = function(o) {
	var a = [];
	if(o != null) {
		var hasOwnProperty = Object.prototype.hasOwnProperty;
		for( var f in o ) {
		if(hasOwnProperty.call(o,f)) a.push(f);
		}
	}
	return a;
}
Reflect.isFunction = function(f) {
	return typeof(f) == "function" && !(f.__name__ || f.__ename__);
}
Reflect.compareMethods = function(f1,f2) {
	if(f1 == f2) return true;
	if(!Reflect.isFunction(f1) || !Reflect.isFunction(f2)) return false;
	return f1.scope == f2.scope && f1.method == f2.method && f1.method != null;
}
Reflect.isObject = function(v) {
	if(v == null) return false;
	var t = typeof(v);
	return t == "string" || t == "object" && !v.__enum__ || t == "function" && (v.__name__ || v.__ename__);
}
var Std = function() { }
Std.__name__ = ["Std"];
Std.string = function(s) {
	return js.Boot.__string_rec(s,"");
}
Std.parseInt = function(x) {
	var v = parseInt(x,10);
	if(v == 0 && (HxOverrides.cca(x,1) == 120 || HxOverrides.cca(x,1) == 88)) v = parseInt(x);
	if(isNaN(v)) return null;
	return v;
}
Std.parseFloat = function(x) {
	return parseFloat(x);
}
var StringBuf = function() {
	this.b = "";
};
StringBuf.__name__ = ["StringBuf"];
StringBuf.prototype = {
	b: null
	,__class__: StringBuf
}
var StringTools = function() { }
StringTools.__name__ = ["StringTools"];
StringTools.urlEncode = function(s) {
	return encodeURIComponent(s);
}
StringTools.isSpace = function(s,pos) {
	var c = HxOverrides.cca(s,pos);
	return c >= 9 && c <= 13 || c == 32;
}
StringTools.ltrim = function(s) {
	var l = s.length;
	var r = 0;
	while(r < l && StringTools.isSpace(s,r)) r++;
	if(r > 0) return HxOverrides.substr(s,r,l - r); else return s;
}
StringTools.rtrim = function(s) {
	var l = s.length;
	var r = 0;
	while(r < l && StringTools.isSpace(s,l - r - 1)) r++;
	if(r > 0) return HxOverrides.substr(s,0,l - r); else return s;
}
StringTools.trim = function(s) {
	return StringTools.ltrim(StringTools.rtrim(s));
}
StringTools.lpad = function(s,c,l) {
	if(c.length <= 0) return s;
	while(s.length < l) s = c + s;
	return s;
}
StringTools.rpad = function(s,c,l) {
	if(c.length <= 0) return s;
	while(s.length < l) s = s + c;
	return s;
}
StringTools.replace = function(s,sub,by) {
	return s.split(sub).join(by);
}
StringTools.hex = function(n,digits) {
	var s = "";
	var hexChars = "0123456789ABCDEF";
	do {
		s = hexChars.charAt(n & 15) + s;
		n >>>= 4;
	} while(n > 0);
	if(digits != null) while(s.length < digits) s = "0" + s;
	return s;
}
var Strings = function() { }
Strings.__name__ = ["Strings"];
Strings.rtrim = function(value,charlist) {
	var len = value.length;
	while(len > 0) {
		var c = HxOverrides.substr(value,len - 1,1);
		if(charlist.indexOf(c) < 0) break;
		len--;
	}
	return HxOverrides.substr(value,0,len);
}
Strings.ltrim = function(value,charlist) {
	var start = 0;
	while(start < value.length) {
		var c = HxOverrides.substr(value,start,1);
		if(charlist.indexOf(c) < 0) break;
		start++;
	}
	return HxOverrides.substr(value,start,null);
}
Strings.ellipsis = function(s,maxlen,symbol) {
	if(symbol == null) symbol = "...";
	if(maxlen == null) maxlen = 20;
	if(s.length > maxlen) return HxOverrides.substr(s,0,Ints.max(symbol.length,maxlen - symbol.length)) + symbol; else return s;
}
Strings.compare = function(a,b) {
	return a < b?-1:a > b?1:0;
}
var ValueType = { __ename__ : ["ValueType"], __constructs__ : ["TNull","TInt","TFloat","TBool","TObject","TFunction","TClass","TEnum","TUnknown"] }
ValueType.TNull = ["TNull",0];
ValueType.TNull.toString = $estr;
ValueType.TNull.__enum__ = ValueType;
ValueType.TInt = ["TInt",1];
ValueType.TInt.toString = $estr;
ValueType.TInt.__enum__ = ValueType;
ValueType.TFloat = ["TFloat",2];
ValueType.TFloat.toString = $estr;
ValueType.TFloat.__enum__ = ValueType;
ValueType.TBool = ["TBool",3];
ValueType.TBool.toString = $estr;
ValueType.TBool.__enum__ = ValueType;
ValueType.TObject = ["TObject",4];
ValueType.TObject.toString = $estr;
ValueType.TObject.__enum__ = ValueType;
ValueType.TFunction = ["TFunction",5];
ValueType.TFunction.toString = $estr;
ValueType.TFunction.__enum__ = ValueType;
ValueType.TClass = function(c) { var $x = ["TClass",6,c]; $x.__enum__ = ValueType; $x.toString = $estr; return $x; }
ValueType.TEnum = function(e) { var $x = ["TEnum",7,e]; $x.__enum__ = ValueType; $x.toString = $estr; return $x; }
ValueType.TUnknown = ["TUnknown",8];
ValueType.TUnknown.toString = $estr;
ValueType.TUnknown.__enum__ = ValueType;
var Type = function() { }
Type.__name__ = ["Type"];
Type.getClass = function(o) {
	if(o == null) return null;
	return o.__class__;
}
Type.getEnum = function(o) {
	if(o == null) return null;
	return o.__enum__;
}
Type.getClassName = function(c) {
	var a = c.__name__;
	return a.join(".");
}
Type.getEnumName = function(e) {
	var a = e.__ename__;
	return a.join(".");
}
Type.createEmptyInstance = function(cl) {
	function empty() {}; empty.prototype = cl.prototype;
	return new empty();
}
Type.getInstanceFields = function(c) {
	var a = [];
	for(var i in c.prototype) a.push(i);
	HxOverrides.remove(a,"__class__");
	HxOverrides.remove(a,"__properties__");
	return a;
}
Type["typeof"] = function(v) {
	var _g = typeof(v);
	switch(_g) {
	case "boolean":
		return ValueType.TBool;
	case "string":
		return ValueType.TClass(String);
	case "number":
		if(Math.ceil(v) == v % 2147483648.0) return ValueType.TInt;
		return ValueType.TFloat;
	case "object":
		if(v == null) return ValueType.TNull;
		var e = v.__enum__;
		if(e != null) return ValueType.TEnum(e);
		var c = v.__class__;
		if(c != null) return ValueType.TClass(c);
		return ValueType.TObject;
	case "function":
		if(v.__name__ || v.__ename__) return ValueType.TObject;
		return ValueType.TFunction;
	case "undefined":
		return ValueType.TNull;
	default:
		return ValueType.TUnknown;
	}
}
Type.enumConstructor = function(e) {
	return e[0];
}
Type.enumParameters = function(e) {
	return e.slice(2);
}
Type.enumIndex = function(e) {
	return e[1];
}
var Types = function() { }
Types.__name__ = ["Types"];
Types.typeName = function(o) {
	return (function($this) {
		var $r;
		var _g = Type["typeof"](o);
		$r = (function($this) {
			var $r;
			var $e = (_g);
			switch( $e[1] ) {
			case 0:
				$r = "null";
				break;
			case 1:
				$r = "Int";
				break;
			case 2:
				$r = "Float";
				break;
			case 3:
				$r = "Bool";
				break;
			case 5:
				$r = "function";
				break;
			case 6:
				var _g_eTClass_0 = $e[2];
				$r = Type.getClassName(_g_eTClass_0);
				break;
			case 7:
				var _g_eTEnum_0 = $e[2];
				$r = Type.getEnumName(_g_eTEnum_0);
				break;
			case 4:
				$r = "Object";
				break;
			case 8:
				$r = "Unknown";
				break;
			}
			return $r;
		}($this));
		return $r;
	}(this));
}
var haxe = {}
haxe.Http = function(url) {
	this.url = url;
	this.headers = new Hash();
	this.params = new Hash();
	this.async = true;
};
haxe.Http.__name__ = ["haxe","Http"];
haxe.Http.prototype = {
	onStatus: function(status) {
	}
	,onError: function(msg) {
	}
	,onData: function(data) {
	}
	,request: function(post) {
		var me = this;
		var r = js.Browser.createXMLHttpRequest();
		var onreadystatechange = function(_) {
			if(r.readyState != 4) return;
			var s = (function($this) {
				var $r;
				try {
					$r = r.status;
				} catch( e ) {
					$r = null;
				}
				return $r;
			}(this));
			if(s == undefined) s = null;
			if(s != null) me.onStatus(s);
			if(s != null && s >= 200 && s < 400) me.onData(r.responseText); else if(s == null) me.onError("Failed to connect or resolve host"); else switch(s) {
			case 12029:
				me.onError("Failed to connect to host");
				break;
			case 12007:
				me.onError("Unknown host");
				break;
			default:
				me.onError("Http Error #" + r.status);
			}
		};
		if(this.async) r.onreadystatechange = onreadystatechange;
		var uri = this.postData;
		if(uri != null) post = true; else {
			var $it0 = this.params.keys();
			while( $it0.hasNext() ) {
				var p = $it0.next();
				if(uri == null) uri = ""; else uri += "&";
				uri += StringTools.urlEncode(p) + "=" + StringTools.urlEncode(this.params.get(p));
			}
		}
		try {
			if(post) r.open("POST",this.url,this.async); else if(uri != null) {
				var question = this.url.split("?").length <= 1;
				r.open("GET",this.url + (question?"?":"&") + uri,this.async);
				uri = null;
			} else r.open("GET",this.url,this.async);
		} catch( e ) {
			this.onError(e.toString());
			return;
		}
		if(this.headers.get("Content-Type") == null && post && this.postData == null) r.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		var $it1 = this.headers.keys();
		while( $it1.hasNext() ) {
			var h = $it1.next();
			r.setRequestHeader(h,this.headers.get(h));
		}
		r.send(uri);
		if(!this.async) onreadystatechange(null);
	}
	,params: null
	,headers: null
	,postData: null
	,async: null
	,url: null
	,__class__: haxe.Http
}
haxe.Md5 = function() {
};
haxe.Md5.__name__ = ["haxe","Md5"];
haxe.Md5.encode = function(s) {
	return new haxe.Md5().doEncode(s);
}
haxe.Md5.prototype = {
	doEncode: function(str) {
		var x = this.str2blks(str);
		var a = 1732584193;
		var b = -271733879;
		var c = -1732584194;
		var d = 271733878;
		var step;
		var i = 0;
		while(i < x.length) {
			var olda = a;
			var oldb = b;
			var oldc = c;
			var oldd = d;
			step = 0;
			a = this.ff(a,b,c,d,x[i],7,-680876936);
			d = this.ff(d,a,b,c,x[i + 1],12,-389564586);
			c = this.ff(c,d,a,b,x[i + 2],17,606105819);
			b = this.ff(b,c,d,a,x[i + 3],22,-1044525330);
			a = this.ff(a,b,c,d,x[i + 4],7,-176418897);
			d = this.ff(d,a,b,c,x[i + 5],12,1200080426);
			c = this.ff(c,d,a,b,x[i + 6],17,-1473231341);
			b = this.ff(b,c,d,a,x[i + 7],22,-45705983);
			a = this.ff(a,b,c,d,x[i + 8],7,1770035416);
			d = this.ff(d,a,b,c,x[i + 9],12,-1958414417);
			c = this.ff(c,d,a,b,x[i + 10],17,-42063);
			b = this.ff(b,c,d,a,x[i + 11],22,-1990404162);
			a = this.ff(a,b,c,d,x[i + 12],7,1804603682);
			d = this.ff(d,a,b,c,x[i + 13],12,-40341101);
			c = this.ff(c,d,a,b,x[i + 14],17,-1502002290);
			b = this.ff(b,c,d,a,x[i + 15],22,1236535329);
			a = this.gg(a,b,c,d,x[i + 1],5,-165796510);
			d = this.gg(d,a,b,c,x[i + 6],9,-1069501632);
			c = this.gg(c,d,a,b,x[i + 11],14,643717713);
			b = this.gg(b,c,d,a,x[i],20,-373897302);
			a = this.gg(a,b,c,d,x[i + 5],5,-701558691);
			d = this.gg(d,a,b,c,x[i + 10],9,38016083);
			c = this.gg(c,d,a,b,x[i + 15],14,-660478335);
			b = this.gg(b,c,d,a,x[i + 4],20,-405537848);
			a = this.gg(a,b,c,d,x[i + 9],5,568446438);
			d = this.gg(d,a,b,c,x[i + 14],9,-1019803690);
			c = this.gg(c,d,a,b,x[i + 3],14,-187363961);
			b = this.gg(b,c,d,a,x[i + 8],20,1163531501);
			a = this.gg(a,b,c,d,x[i + 13],5,-1444681467);
			d = this.gg(d,a,b,c,x[i + 2],9,-51403784);
			c = this.gg(c,d,a,b,x[i + 7],14,1735328473);
			b = this.gg(b,c,d,a,x[i + 12],20,-1926607734);
			a = this.hh(a,b,c,d,x[i + 5],4,-378558);
			d = this.hh(d,a,b,c,x[i + 8],11,-2022574463);
			c = this.hh(c,d,a,b,x[i + 11],16,1839030562);
			b = this.hh(b,c,d,a,x[i + 14],23,-35309556);
			a = this.hh(a,b,c,d,x[i + 1],4,-1530992060);
			d = this.hh(d,a,b,c,x[i + 4],11,1272893353);
			c = this.hh(c,d,a,b,x[i + 7],16,-155497632);
			b = this.hh(b,c,d,a,x[i + 10],23,-1094730640);
			a = this.hh(a,b,c,d,x[i + 13],4,681279174);
			d = this.hh(d,a,b,c,x[i],11,-358537222);
			c = this.hh(c,d,a,b,x[i + 3],16,-722521979);
			b = this.hh(b,c,d,a,x[i + 6],23,76029189);
			a = this.hh(a,b,c,d,x[i + 9],4,-640364487);
			d = this.hh(d,a,b,c,x[i + 12],11,-421815835);
			c = this.hh(c,d,a,b,x[i + 15],16,530742520);
			b = this.hh(b,c,d,a,x[i + 2],23,-995338651);
			a = this.ii(a,b,c,d,x[i],6,-198630844);
			d = this.ii(d,a,b,c,x[i + 7],10,1126891415);
			c = this.ii(c,d,a,b,x[i + 14],15,-1416354905);
			b = this.ii(b,c,d,a,x[i + 5],21,-57434055);
			a = this.ii(a,b,c,d,x[i + 12],6,1700485571);
			d = this.ii(d,a,b,c,x[i + 3],10,-1894986606);
			c = this.ii(c,d,a,b,x[i + 10],15,-1051523);
			b = this.ii(b,c,d,a,x[i + 1],21,-2054922799);
			a = this.ii(a,b,c,d,x[i + 8],6,1873313359);
			d = this.ii(d,a,b,c,x[i + 15],10,-30611744);
			c = this.ii(c,d,a,b,x[i + 6],15,-1560198380);
			b = this.ii(b,c,d,a,x[i + 13],21,1309151649);
			a = this.ii(a,b,c,d,x[i + 4],6,-145523070);
			d = this.ii(d,a,b,c,x[i + 11],10,-1120210379);
			c = this.ii(c,d,a,b,x[i + 2],15,718787259);
			b = this.ii(b,c,d,a,x[i + 9],21,-343485551);
			a = this.addme(a,olda);
			b = this.addme(b,oldb);
			c = this.addme(c,oldc);
			d = this.addme(d,oldd);
			i += 16;
		}
		return this.rhex(a) + this.rhex(b) + this.rhex(c) + this.rhex(d);
	}
	,ii: function(a,b,c,d,x,s,t) {
		return this.cmn(this.bitXOR(c,this.bitOR(b,~d)),a,b,x,s,t);
	}
	,hh: function(a,b,c,d,x,s,t) {
		return this.cmn(this.bitXOR(this.bitXOR(b,c),d),a,b,x,s,t);
	}
	,gg: function(a,b,c,d,x,s,t) {
		return this.cmn(this.bitOR(this.bitAND(b,d),this.bitAND(c,~d)),a,b,x,s,t);
	}
	,ff: function(a,b,c,d,x,s,t) {
		return this.cmn(this.bitOR(this.bitAND(b,c),this.bitAND(~b,d)),a,b,x,s,t);
	}
	,cmn: function(q,a,b,x,s,t) {
		return this.addme(this.rol(this.addme(this.addme(a,q),this.addme(x,t)),s),b);
	}
	,rol: function(num,cnt) {
		return num << cnt | num >>> 32 - cnt;
	}
	,str2blks: function(str) {
		var nblk = (str.length + 8 >> 6) + 1;
		var blks = new Array();
		var blksSize = nblk * 16;
		var _g = 0;
		while(_g < blksSize) {
			var i = _g++;
			blks[i] = 0;
		}
		var i = 0;
		while(i < str.length) {
			blks[i >> 2] |= HxOverrides.cca(str,i) << (str.length * 8 + i) % 4 * 8;
			i++;
		}
		blks[i >> 2] |= 128 << (str.length * 8 + i) % 4 * 8;
		var l = str.length * 8;
		var k = nblk * 16 - 2;
		blks[k] = l & 255;
		blks[k] |= (l >>> 8 & 255) << 8;
		blks[k] |= (l >>> 16 & 255) << 16;
		blks[k] |= (l >>> 24 & 255) << 24;
		return blks;
	}
	,rhex: function(num) {
		var str = "";
		var hex_chr = "0123456789abcdef";
		var _g = 0;
		while(_g < 4) {
			var j = _g++;
			str += hex_chr.charAt(num >> j * 8 + 4 & 15) + hex_chr.charAt(num >> j * 8 & 15);
		}
		return str;
	}
	,addme: function(x,y) {
		var lsw = (x & 65535) + (y & 65535);
		var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
		return msw << 16 | lsw & 65535;
	}
	,bitAND: function(a,b) {
		var lsb = a & 1 & (b & 1);
		var msb31 = a >>> 1 & b >>> 1;
		return msb31 << 1 | lsb;
	}
	,bitXOR: function(a,b) {
		var lsb = a & 1 ^ b & 1;
		var msb31 = a >>> 1 ^ b >>> 1;
		return msb31 << 1 | lsb;
	}
	,bitOR: function(a,b) {
		var lsb = a & 1 | b & 1;
		var msb31 = a >>> 1 | b >>> 1;
		return msb31 << 1 | lsb;
	}
	,__class__: haxe.Md5
}
haxe.Timer = function(time_ms) {
	var me = this;
	this.id = setInterval(function() {
		me.run();
	},time_ms);
};
haxe.Timer.__name__ = ["haxe","Timer"];
haxe.Timer.delay = function(f,time_ms) {
	var t = new haxe.Timer(time_ms);
	t.run = function() {
		t.stop();
		f();
	};
	return t;
}
haxe.Timer.prototype = {
	run: function() {
	}
	,stop: function() {
		if(this.id == null) return;
		clearInterval(this.id);
		this.id = null;
	}
	,id: null
	,__class__: haxe.Timer
}
var js = {}
js.Boot = function() { }
js.Boot.__name__ = ["js","Boot"];
js.Boot.__string_rec = function(o,s) {
	if(o == null) return "null";
	if(s.length >= 5) return "<...>";
	var t = typeof(o);
	if(t == "function" && (o.__name__ || o.__ename__)) t = "object";
	switch(t) {
	case "object":
		if(o instanceof Array) {
			if(o.__enum__) {
				if(o.length == 2) return o[0];
				var str = o[0] + "(";
				s += "\t";
				var _g1 = 2, _g = o.length;
				while(_g1 < _g) {
					var i = _g1++;
					if(i != 2) str += "," + js.Boot.__string_rec(o[i],s); else str += js.Boot.__string_rec(o[i],s);
				}
				return str + ")";
			}
			var l = o.length;
			var i;
			var str = "[";
			s += "\t";
			var _g = 0;
			while(_g < l) {
				var i1 = _g++;
				str += (i1 > 0?",":"") + js.Boot.__string_rec(o[i1],s);
			}
			str += "]";
			return str;
		}
		var tostr;
		try {
			tostr = o.toString;
		} catch( e ) {
			return "???";
		}
		if(tostr != null && tostr != Object.toString) {
			var s2 = o.toString();
			if(s2 != "[object Object]") return s2;
		}
		var k = null;
		var str = "{\n";
		s += "\t";
		var hasp = o.hasOwnProperty != null;
		for( var k in o ) { ;
		if(hasp && !o.hasOwnProperty(k)) {
			continue;
		}
		if(k == "prototype" || k == "__class__" || k == "__super__" || k == "__interfaces__" || k == "__properties__") {
			continue;
		}
		if(str.length != 2) str += ", \n";
		str += s + k + " : " + js.Boot.__string_rec(o[k],s);
		}
		s = s.substring(1);
		str += "\n" + s + "}";
		return str;
	case "function":
		return "<function>";
	case "string":
		return o;
	default:
		return String(o);
	}
}
js.Boot.__interfLoop = function(cc,cl) {
	if(cc == null) return false;
	if(cc == cl) return true;
	var intf = cc.__interfaces__;
	if(intf != null) {
		var _g1 = 0, _g = intf.length;
		while(_g1 < _g) {
			var i = _g1++;
			var i1 = intf[i];
			if(i1 == cl || js.Boot.__interfLoop(i1,cl)) return true;
		}
	}
	return js.Boot.__interfLoop(cc.__super__,cl);
}
js.Boot.__instanceof = function(o,cl) {
	try {
		if(o instanceof cl) {
			if(cl == Array) return o.__enum__ == null;
			return true;
		}
		if(js.Boot.__interfLoop(o.__class__,cl)) return true;
	} catch( e ) {
		if(cl == null) return false;
	}
	switch(cl) {
	case Int:
		return Math.ceil(o%2147483648.0) === o;
	case Float:
		return typeof(o) == "number";
	case Bool:
		return o === true || o === false;
	case String:
		return typeof(o) == "string";
	case Dynamic:
		return true;
	default:
		if(o == null) return false;
		if(cl == Class && o.__name__ != null) return true; else null;
		if(cl == Enum && o.__ename__ != null) return true; else null;
		return o.__enum__ == cl;
	}
}
js.Browser = function() { }
js.Browser.__name__ = ["js","Browser"];
js.Browser.createXMLHttpRequest = function() {
	if(typeof XMLHttpRequest != "undefined") return new XMLHttpRequest();
	if(typeof ActiveXObject != "undefined") return new ActiveXObject("Microsoft.XMLHTTP");
	throw "Unable to create XMLHttpRequest object.";
}
var rg = {}
rg.app = {}
rg.app.query = {}
rg.app.query.JSBridge = function() { }
rg.app.query.JSBridge.__name__ = ["rg","app","query","JSBridge"];
rg.app.query.JSBridge.createQuery = function(executor) {
	var inst = rg.query.ReportGridQuery.create(executor);
	var query = { };
	var _g = 0, _g1 = Type.getInstanceFields(Type.getClass(inst));
	while(_g < _g1.length) {
		var field = [_g1[_g]];
		++_g;
		if(HxOverrides.substr(field[0],0,1) == "_" || !Reflect.isFunction(Reflect.field(inst,field[0]))) continue;
		query[field[0]] = (function(field) {
			return function() {
				var ob = rg.query.ReportGridQuery.create(executor), f = Reflect.field(ob,field[0]);
				return f.apply(ob,arguments);
			};
		})(field);
	}
	return query;
}
rg.app.query.JSBridge.main = function() {
	var storage;
	if(rg.storage.BrowserStorage.hasSessionStorage()) storage = rg.storage.BrowserStorage.sessionStorage(); else storage = new rg.storage.MemoryStorage();
	var r = (typeof ReportGrid == 'undefined') ? (window['ReportGrid'] = {}) : ReportGrid, timeout = 120, executor = new rg.data.ReportGridExecutorCache(r,storage,timeout);
	r.query = rg.app.query.JSBridge.createQuery(executor);
	r.date = { range : function(a,b,p) {
		if(js.Boot.__instanceof(a,String)) a = thx.date.DateParser.parse(a);
		if(null == a) a = rg.util.Periodicity.defaultRange(p)[0];
		if(js.Boot.__instanceof(a,Date)) a = a.getTime();
		if(js.Boot.__instanceof(b,String)) b = thx.date.DateParser.parse(b);
		if(null == b) b = rg.util.Periodicity.defaultRange(p)[1];
		if(js.Boot.__instanceof(b,Date)) b = b.getTime();
		return rg.util.Periodicity.range(a,b,p);
	}, formatPeriodicity : function(date,periodicity) {
		var d = js.Boot.__instanceof(date,Date)?date.getTime():js.Boot.__instanceof(date,Float)?date:thx.date.DateParser.parse(date).getTime();
		return rg.util.Periodicity.format(periodicity,d);
	}, parse : thx.date.DateParser.parse, snap : Dates.snap};
	r.info = null != r.info?r.info:{ };
	r.info.query = { version : "1.3.20.1690"};
	var rand = new thx.math.Random(666);
	r.math = { setRandomSeed : function(s) {
		rand = new thx.math.Random(s);
	}, random : function() {
		return ((rand.seed = rand.seed * 16807 % 2147483647) & 1073741823) / 1073741823.0;
	}};
	r.cache = { executor : executor, disable : function() {
		if(null == executor || js.Boot.__instanceof(executor,rg.data.ReportGridExecutorCache)) {
			r.cache.executor = executor = r;
			r.query = rg.app.query.JSBridge.createQuery(executor);
		}
	}, enable : function() {
		if(null == executor || !js.Boot.__instanceof(executor,rg.data.ReportGridExecutorCache)) {
			r.cache.executor = executor = new rg.data.ReportGridExecutorCache(r,storage,timeout);
			r.query = rg.app.query.JSBridge.createQuery(executor);
		}
	}, setTimeout : function(t) {
		executor = null;
		timeout = t;
		r.cache.enable();
	}, memoryStorage : function() {
		executor = null;
		storage = new rg.storage.MemoryStorage();
		r.cache.enable();
	}, sessionStorage : function() {
		executor = null;
		if(rg.storage.BrowserStorage.hasSessionStorage()) storage = rg.storage.BrowserStorage.sessionStorage(); else storage = new rg.storage.MemoryStorage();
		r.cache.enable();
	}, localStorage : function() {
		executor = null;
		if(rg.storage.BrowserStorage.hasLocalStorage()) storage = rg.storage.BrowserStorage.localStorage(); else if(rg.storage.BrowserStorage.hasSessionStorage()) storage = rg.storage.BrowserStorage.sessionStorage(); else storage = new rg.storage.MemoryStorage();
		r.cache.enable();
	}};
}
rg.data = {}
rg.data.IExecutorReportGrid = function() { }
rg.data.IExecutorReportGrid.__name__ = ["rg","data","IExecutorReportGrid"];
rg.data.IExecutorReportGrid.prototype = {
	events: null
	,propertiesHistogram: null
	,histogram: null
	,intersect: null
	,searchSeries: null
	,searchCount: null
	,propertyValueSeries: null
	,propertyValueCount: null
	,propertyValues: null
	,propertySums: null
	,propertyStandardDeviations: null
	,propertyMeans: null
	,propertySeries: null
	,propertyCount: null
	,children: null
	,__class__: rg.data.IExecutorReportGrid
}
rg.data.ReportGridExecutorCache = function(executor,storage,timeout) {
	this.executor = executor;
	this.storage = storage;
	this.queue = new Hash();
	this.timeout = timeout;
	this.cleanOld();
};
rg.data.ReportGridExecutorCache.__name__ = ["rg","data","ReportGridExecutorCache"];
rg.data.ReportGridExecutorCache.__interfaces__ = [rg.data.IExecutorReportGrid];
rg.data.ReportGridExecutorCache.prototype = {
	uidquery: function(method,path,options) {
		var s = method + ":" + path + ":" + thx.json.Json.encode(options);
		return haxe.Md5.encode(s);
	}
	,getQueue: function(id) {
		if(this.timeout < 0) return null;
		return this.queue.get(id);
	}
	,cleanOld: function() {
		var _g = 0, _g1 = this.ids();
		while(_g < _g1.length) {
			var id = _g1[_g];
			++_g;
			this.clearValueIfOld(id);
		}
	}
	,ids: function() {
		var len = rg.data.ReportGridExecutorCache.VALUE_PREFIX.length;
		return Iterators.filter(this.storage.keys(),function(cid) {
			return HxOverrides.substr(cid,0,len) == rg.data.ReportGridExecutorCache.VALUE_PREFIX;
		}).map(function(cid) {
			return HxOverrides.substr(cid,len,null);
		});
	}
	,cacheRemove: function(id) {
		this.storage.remove(rg.data.ReportGridExecutorCache.DATE_PREFIX + id);
		this.storage.remove(rg.data.ReportGridExecutorCache.VALUE_PREFIX + id);
	}
	,cacheGet: function(id) {
		this.clearValueIfOld(id);
		var v = this.storage.get(rg.data.ReportGridExecutorCache.VALUE_PREFIX + id);
		if(null != v) this.delayedCleanup(id);
		return v;
	}
	,cacheSet: function(id,value) {
		this.storage.set(rg.data.ReportGridExecutorCache.DATE_PREFIX + id,new Date().getTime());
		this.storage.set(rg.data.ReportGridExecutorCache.VALUE_PREFIX + id,value);
	}
	,delayedCleanup: function(id) {
		var _g = this;
		haxe.Timer.delay(function() {
			_g.cacheRemove(id);
		},this.timeout * 1000);
	}
	,clearValueIfOld: function(id) {
		var idd = rg.data.ReportGridExecutorCache.DATE_PREFIX + id;
		var v = this.storage.get(idd);
		if(null == v) return;
		if(v < new Date().getTime() - this.timeout * 1000) {
			this.storage.remove(idd);
			this.storage.remove(rg.data.ReportGridExecutorCache.VALUE_PREFIX + id);
		}
	}
	,storageSuccess: function(id,success) {
		var _g = this;
		this.queue.set(id,[]);
		return function(r) {
			if(_g.timeout > 0) {
				_g.cacheSet(id,r);
				_g.delayedCleanup(id);
			}
			success(r);
			var q = _g.queue.get(id);
			if(null != q) {
				var _g1 = 0;
				while(_g1 < q.length) {
					var item = q[_g1];
					++_g1;
					item(r);
				}
			}
			_g.queue.remove(id);
		};
	}
	,normalizePeriod: function(options) {
		var periodicity = options.periodicity;
		if(null == periodicity && options.start != null && options.end != null) periodicity = rg.util.Periodicity.defaultPeriodicity(options.end - options.start);
		if(null == periodicity) return;
		if(null != options.start && periodicity != "single") options.start = Dates.snap(options.start,periodicity,-1);
		if(null != options.end && periodicity != "single") options.end = Dates.snap(options.end,periodicity,-1);
	}
	,execute: function(name,path,options,success,error) {
		this.normalizePeriod(options);
		var id = this.uidquery(name,path,options), val = this.cacheGet(id);
		if(null != val) {
			success(val);
			return;
		}
		var q = this.getQueue(id);
		if(null != q) q.push(success); else (Reflect.field(this.executor,name))(path,options,this.storageSuccess(id,success),error);
	}
	,events: function(path,options,success,error) {
		this.execute("events",path,options,success,error);
	}
	,propertiesHistogram: function(path,options,success,error) {
		this.execute("propertiesHistogram",path,options,success,error);
	}
	,histogram: function(path,options,success,error) {
		this.execute("histogram",path,options,success,error);
	}
	,intersect: function(path,options,success,error) {
		this.execute("intersect",path,options,success,error);
	}
	,searchSeries: function(path,options,success,error) {
		this.execute("searchSeries",path,options,success,error);
	}
	,searchCount: function(path,options,success,error) {
		this.execute("searchCount",path,options,success,error);
	}
	,propertyValueSeries: function(path,options,success,error) {
		this.execute("propertyValueSeries",path,options,success,error);
	}
	,propertyValueCount: function(path,options,success,error) {
		this.execute("propertyValueCount",path,options,success,error);
	}
	,propertyValues: function(path,options,success,error) {
		this.execute("propertyValues",path,options,success,error);
	}
	,propertySums: function(path,options,success,error) {
		this.execute("propertySums",path,options,success,error);
	}
	,propertyStandardDeviations: function(path,options,success,error) {
		this.execute("propertyStandardDeviations",path,options,success,error);
	}
	,propertyMeans: function(path,options,success,error) {
		this.execute("propertyMeans",path,options,success,error);
	}
	,propertySeries: function(path,options,success,error) {
		this.execute("propertySeries",path,options,success,error);
	}
	,propertyCount: function(path,options,success,error) {
		this.execute("propertyCount",path,options,success,error);
	}
	,children: function(path,options,success,error) {
		this.execute("children",path,options,success,error);
	}
	,queue: null
	,storage: null
	,executor: null
	,timeout: null
	,__class__: rg.data.ReportGridExecutorCache
}
rg.query = {}
rg.query.BaseQuery = function(async,first) {
	this._async = async;
	this._first = first;
	this._store = new Hash();
};
rg.query.BaseQuery.__name__ = ["rg","query","BaseQuery"];
rg.query.BaseQuery.asyncTransform = function(t) {
	return function(data,handler) {
		var _g1 = 0, _g = data.length;
		while(_g1 < _g) {
			var i = _g1++;
			data[i] = t(data[i]);
		}
		handler(data);
	};
}
rg.query.BaseQuery.stackAsyncTransform = function(t) {
	return function(data,handler) {
		handler(t(data));
	};
}
rg.query.BaseQuery.prototype = {
	_this: function(q) {
		return q;
	}
	,toString: function() {
		return Type.getClassName(Type.getClass(this)).split(".").pop() + (" [next: " + Std.string(null != this._next) + ", async: " + Std.string(null != this._async) + "]");
	}
	,_createQuery: function(async,first) {
		return new rg.query.BaseQuery(async,first);
	}
	,_query: function(t) {
		return t;
	}
	,execute: function(handler) {
		this._first.execute(handler);
	}
	,stackClear: function() {
		return this.stackTransform(function(_) {
			return [];
		});
	}
	,stackRetrieve: function(name) {
		var _g = this;
		if(null == name) name = "";
		return this.stackTransform(function(arr) {
			return arr.concat(_g._first._store.get(name));
		});
	}
	,stackSortValue: function(fieldName,ascending) {
		if(null == ascending) ascending = true;
		var sum = function(arr) {
			return arr.reduce(function(value,item,_) {
				return value + Reflect.field(item,fieldName);
			},0);
		};
		return this.stackSort(function(a,b) {
			return (ascending?1:-1) * (sum(a) - sum(b));
		});
	}
	,stackSort: function(f) {
		return this.stackTransform(function(arr) {
			arr.sort(f);
			return arr;
		});
	}
	,stackStore: function(name) {
		var _g = this;
		if(null == name) name = "";
		return this.stackTransform(function(arr) {
			_g._first._store.set(name,arr.slice());
			return arr;
		});
	}
	,stackReverse: function() {
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(function(data) {
			data.reverse();
			return data;
		}));
	}
	,stackRotate: function(matchingf) {
		var t = rg.query.Transformers.rotate(matchingf);
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(function(data) {
			return t(data);
		}));
	}
	,split: function(f) {
		if(js.Boot.__instanceof(f,String)) {
			var name = f;
			f = function(o) {
				return Reflect.field(o,name);
			};
		}
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(function(data) {
			var result = [];
			var _g = 0;
			while(_g < data.length) {
				var arr = data[_g];
				++_g;
				result = result.concat(rg.query.Transformers.split(arr,f));
			}
			return result;
		}));
	}
	,stackKeep: function(howmany) {
		if(null == howmany) howmany = 1;
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(function(data) {
			return data.slice(0,howmany);
		}));
	}
	,stackDiscard: function(howmany) {
		if(null == howmany) howmany = 1;
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(function(data) {
			var _g = 0;
			while(_g < howmany) {
				var i = _g++;
				data.pop();
			}
			return data;
		}));
	}
	,stackMerge: function() {
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(function(data) {
			return [Arrays.flatten(data)];
		}));
	}
	,fold: function(startf,reducef) {
		return this.transform(function(data) {
			var result = [], acc = Reflect.isFunction(startf)?startf(data,result):startf;
			data.forEach(function(dp,_) {
				acc = reducef(acc,dp,result);
			});
			return result;
		});
	}
	,unique: function(f) {
		if(null == f) f = Dynamics.same;
		return this.transform(rg.query.Transformers.uniquef(f));
	}
	,reverse: function() {
		return this.transform(rg.query.Transformers.reverse);
	}
	,limit: function(offset,count) {
		if(null == count) {
			count = offset;
			offset = 0;
		}
		return this.transform(rg.query.Transformers.limit(offset,count));
	}
	,sortValues: function(o) {
		var fields = [], orders = [];
		var _g = 0, _g1 = Reflect.fields(o);
		while(_g < _g1.length) {
			var key = _g1[_g];
			++_g;
			fields.push(key);
			orders.push(Reflect.field(o,key) != false);
		}
		return this.sort(function(a,b) {
			var r, field;
			var _g1 = 0, _g = fields.length;
			while(_g1 < _g) {
				var i = _g1++;
				field = fields[i];
				r = (orders[i]?1:-1) * Dynamics.compare(Reflect.field(a,field),Reflect.field(b,field));
				if(r != 0) return r;
			}
			return 0;
		});
	}
	,sortValue: function(field,ascending) {
		var o = { };
		o[field] = null == ascending?true:ascending;
		return this.sortValues(o);
	}
	,sort: function(f) {
		return this.transform(rg.query.Transformers.sort(f));
	}
	,filterValue: function(name,f) {
		return this.transform(rg.query.Transformers.filterValue(name,f));
	}
	,filterValues: function(f) {
		return this.transform(rg.query.Transformers.filterValues(f));
	}
	,filter: function(f) {
		return this.transform(rg.query.Transformers.filter(f));
	}
	,addIndex: function(name,start) {
		if(null == name) name = "index";
		if(null == start) start = 0;
		return this.fold(function(_,_1) {
			return start;
		},function(index,dp,result) {
			dp[name] = index;
			result.push(dp);
			return ++index;
		});
	}
	,mapValues: function(o) {
		return this.transform(rg.query.Transformers.mapFields(o));
	}
	,mapValue: function(name,f) {
		return this.transform(rg.query.Transformers.mapField(name,f));
	}
	,setValues: function(o) {
		return this.transform(rg.query.Transformers.setFields(o));
	}
	,setValue: function(name,f) {
		return this.transform(rg.query.Transformers.setField(name,f));
	}
	,asyncEach: function(f) {
		return this.asyncAll(function(data,handler) {
			var tot = data.length, pos = 0, result = [];
			var complete = function(i,r) {
				result[i] = r;
				if(++pos == tot) handler(Arrays.flatten(result));
			};
			var _g1 = 0, _g = data.length;
			while(_g1 < _g) {
				var i = _g1++;
				f(data[i],(function(f1,i1) {
					return function(r) {
						return f1(i1,r);
					};
				})(complete,i));
			}
		});
	}
	,asyncAll: function(f) {
		return this.stackAsync(function(data,handler) {
			var tot = data.length, pos = 0, result = [];
			var complete = function(i,r) {
				result[i] = r;
				if(++pos == tot) handler(result);
			};
			var _g1 = 0, _g = data.length;
			while(_g1 < _g) {
				var i = _g1++;
				f(data[i],(function(f1,i1) {
					return function(r) {
						return f1(i1,r);
					};
				})(complete,i));
			}
		});
	}
	,stackAsync: function(f) {
		var query = this._createQuery(f,this._first);
		this._next = query;
		return query;
	}
	,stackTransform: function(t) {
		return this.stackAsync(rg.query.BaseQuery.stackAsyncTransform(t));
	}
	,stackCross: function() {
		return this.stackTransform(rg.query.Transformers.crossStack);
	}
	,firstElement: function() {
		return this.transform(function(data) {
			return data[0];
		});
	}
	,explode: function(f) {
		return this.transform(function(d) {
			var results = [];
			var _g = 0;
			while(_g < d.length) {
				var dp = d[_g];
				++_g;
				var ndp = results.concat(f(dp));
				if(js.Boot.__instanceof(ndp,Array)) results = results.concat(ndp); else results.push(ndp);
			}
			return results;
		});
	}
	,transform: function(t) {
		return this.stackAsync(rg.query.BaseQuery.asyncTransform(t));
	}
	,toObject: function(field) {
		return this.transform(rg.query.Transformers.toObject(field));
	}
	,renameFields: function(o) {
		var pairs = Reflect.fields(o).map(function(d) {
			return { src : d, dst : Reflect.field(o,d)};
		});
		return this.map(function(src,_) {
			var out = { };
			var _g = 0;
			while(_g < pairs.length) {
				var pair = pairs[_g];
				++_g;
				Reflect.setField(out,pair.dst,Reflect.field(src,pair.src));
			}
			return out;
		});
	}
	,console: function(label) {
		return this.stackTransform(function(data) {
			var API = console;
			if(null != API) API.log((null == label?"":label + ": ") + Dynamics.string(data));
			return data;
		});
	}
	,auditItem: function(f) {
		return this.transform(function(d) {
			var _g = 0;
			while(_g < d.length) {
				var dp = d[_g];
				++_g;
				f(dp);
			}
			return d;
		});
	}
	,audit: function(f) {
		return this.transform(function(d) {
			f(d);
			return d;
		});
	}
	,map: function(handler) {
		return this.transform(rg.query.Transformers.map(handler));
	}
	,data: function(values) {
		if(!js.Boot.__instanceof(values,Array)) values = [values];
		return this.stackAsync(function(stack,h) {
			stack.push(values);
			h(stack);
		});
	}
	,request: function(url,options) {
		if(null == options) options = { type : "application/json", useJsonp : false}; else {
			if(null == options.type) options.type = "application/json";
			if(null == options.useJsonp) options.useJsonp = false;
		}
		var dataHandler = null;
		var _g = options.type.toLowerCase();
		switch(_g) {
		case "json":
			switch(options.useJsonp) {
			case true:
				dataHandler = function(data) {
					return data;
				};
				break;
			case false:
				dataHandler = function(data) {
					return thx.json.Json.decode(data);
				};
				break;
			}
			break;
		case "application/json":
			switch(options.useJsonp) {
			case true:
				dataHandler = function(data) {
					return data;
				};
				break;
			case false:
				dataHandler = function(data) {
					return thx.json.Json.decode(data);
				};
				break;
			}
			break;
		case "csv":case "text/csv":
			dataHandler = function(data) {
				return thx.csv.Csv.decode(data);
			};
			break;
		default:
			throw "invalid type format \"" + options.type + "\"";
		}
		var stackHandler = function(stack,h) {
			return function(data) {
				stack.push(dataHandler(data));
				h(stack);
			};
		}, async = true == options.useJsonp?function(stack,h) {
			rg.util.Jsonp.get(url,stackHandler(stack,h),function(i,e) {
			},{ },{ });
		}:function(stack,h) {
			var http = new haxe.Http(url);
			http.async = true;
			http.onData = stackHandler(stack,h);
			http.request(false);
		};
		return this.stackAsync(async);
	}
	,load: function(loader) {
		return this.stackAsync(function(stack,h) {
			loader(function(data) {
				stack.push(data);
				h(stack);
			});
		});
	}
	,_store: null
	,_async: null
	,_next: null
	,_first: null
	,__class__: rg.query.BaseQuery
}
rg.query.Query = function() {
	rg.query.BaseQuery.call(this,null,this);
};
rg.query.Query.__name__ = ["rg","query","Query"];
rg.query.Query.create = function() {
	var start = new rg.query.Query(), query = start._createQuery(function(data,handler) {
		handler(data);
	},start);
	start._next = query;
	return query;
}
rg.query.Query.executeHandler = function(instance,handler) {
	var current = instance._next;
	var execute = (function($this) {
		var $r;
		var execute1 = null;
		execute1 = function(result) {
			if(null == current._next) {
				handler(Arrays.flatten(result));
				return;
			}
			current = current._next;
			current._async(result,execute1);
		};
		$r = execute1;
		return $r;
	}(this));
	execute([]);
}
rg.query.Query.__super__ = rg.query.BaseQuery;
rg.query.Query.prototype = $extend(rg.query.BaseQuery.prototype,{
	execute: function(handler) {
		rg.query.Query.executeHandler(this,handler);
	}
	,__class__: rg.query.Query
});
rg.query.ReportGridBaseQuery = function(async,first) {
	rg.query.BaseQuery.call(this,async,first);
};
rg.query.ReportGridBaseQuery.__name__ = ["rg","query","ReportGridBaseQuery"];
rg.query.ReportGridBaseQuery._defaultOptions = function(params,options) {
	if(null == options) options = { };
	if(null != params.tag) {
		options.tag = params.tag;
		options[params.tag] = Reflect.field(params,params.tag);
	}
	if(null != params.disablecache) options.disablecache = params.disablecache;
	if(null == params.start) return options;
	options.start = params.start;
	options.end = params.end;
	if(null != params.tzoffset) options.tzoffset = params.tzoffset;
	return options;
}
rg.query.ReportGridBaseQuery._defaultSeriesOptions = function(params,options) {
	options = rg.query.ReportGridBaseQuery._defaultOptions(params,options);
	options.periodicity = params.periodicity;
	if(null != params.timezone) options.timeZone = params.timezone;
	if(null != params.groupby) options.groupBy = params.groupby;
	return options;
}
rg.query.ReportGridBaseQuery._ensureOptionalTimeParams = function(params) {
	if(null == params.start && null == params.end) return;
	if(null == params.start) {
		params.end = rg.query.ReportGridBaseQuery._date(params.end);
		params.start = params.end - 86400000;
	} else if(null == params.end) {
		params.start = rg.query.ReportGridBaseQuery._date(params.start);
		params.end = rg.query.ReportGridBaseQuery._date("now");
	} else {
		params.start = rg.query.ReportGridBaseQuery._date(params.start);
		params.end = rg.query.ReportGridBaseQuery._date(params.end);
	}
	if(params.start > params.end) {
		var t = params.end;
		params.end = params.start;
		params.start = t;
	}
}
rg.query.ReportGridBaseQuery._ensureTimeParams = function(params) {
	params.start = rg.query.ReportGridBaseQuery._date(null == params.start?"24 hours ago":params.start);
	params.end = rg.query.ReportGridBaseQuery._date(null == params.end?"now":params.end);
	if(params.start > params.end) {
		var t = params.end;
		params.end = params.start;
		params.start = t;
	}
	params.periodicity = params.periodicity == null?rg.util.Periodicity.defaultPeriodicity(params.end - params.start):params.periodicity;
}
rg.query.ReportGridBaseQuery._date = function(v) {
	if(js.Boot.__instanceof(v,Date)) return v.getTime(); else if(js.Boot.__instanceof(v,String)) return thx.date.DateParser.parse(v).getTime(); else if(js.Boot.__instanceof(v,Float)) return v; else {
		rg.query.ReportGridBaseQuery._error("invalid date format for " + Std.string(v));
		return null;
	}
}
rg.query.ReportGridBaseQuery._where = function(event,where) {
	var ob = { };
	Objects.each(where,function(key,value) {
		ob[event + ((HxOverrides.substr(key,0,1) == "."?"":".") + key)] = value;
	});
	return ob;
}
rg.query.ReportGridBaseQuery._error = function(s) {
	throw new thx.error.Error(s,null,null,{ fileName : "ReportGridQuery.hx", lineNumber : 512, className : "rg.query.ReportGridBaseQuery", methodName : "_error"});
}
rg.query.ReportGridBaseQuery._complete = function(transformer,params,keep,handler) {
	return function(data) {
		var result = transformer(data,params,keep);
		handler(result);
	};
}
rg.query.ReportGridBaseQuery._prefixProperty = function(p) {
	return (HxOverrides.substr(p,0,1) == "."?"":".") + p;
}
rg.query.ReportGridBaseQuery.__super__ = rg.query.BaseQuery;
rg.query.ReportGridBaseQuery.prototype = $extend(rg.query.BaseQuery.prototype,{
	_normalizeKeep: function(k) {
		return null == k?[]:js.Boot.__instanceof(k,String)?[k]:k;
	}
	,_createQuery: function(async,first) {
		var query = new rg.query.ReportGridBaseQuery(async,first);
		query.executor = this.executor;
		return query;
	}
	,_params: function(p) {
		return null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p];
	}
	,_crossp: function(p) {
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross();
	}
	,rawEvents: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params,{ event : params.event});
			if(null != params.properties) {
				if(js.Boot.__instanceof(params.properties,Arrays)) {
					var arr = params.properties;
					options.properties = arr.join(",");
				} else options.properties = params.properties;
			}
			if(null != params.limit) options.limit = params.limit;
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			_g.executor.events(params.path,options,rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.events,params,keep,handler));
		});
	}
	,series: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultSeriesOptions(params);
			if(null != params.where) {
				if(null != params.property) rg.query.ReportGridBaseQuery._error("the 'where' and the 'property' fields cannot be used together in a count query"); else if(null != params.value) rg.query.ReportGridBaseQuery._error("the 'where' and the 'value' fields cannot be used together in a count query");
				options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
				_g.executor.searchSeries(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.eventSeriesTagGroupedBy:rg.query.ReportGridTransformers.eventSeries,params,keep,handler));
			} else if(null != params.property) {
				if(null == params.value) rg.query.ReportGridBaseQuery._error("can't count on a property");
				options.property = params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property);
				options.value = params.value;
				_g.executor.propertyValueSeries(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.propertyValueSeriesTagGroupedBy:rg.query.ReportGridTransformers.propertyValueSeries,params,keep,handler));
			} else {
				options.property = params.event;
				_g.executor.propertySeries(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.eventSeriesTagGroupedBy:rg.query.ReportGridTransformers.eventSeries,params,keep,handler));
			}
		});
	}
	,propertiesHistogram: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params,{ property : params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property)});
			_g.executor.propertiesHistogram(params.path,options,rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.propertiesHistogram,params,keep,handler));
		});
	}
	,histogram: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params,{ property : params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property)});
			if(null != params.top) {
				if(null != params.bottom) rg.query.ReportGridBaseQuery._error("you can't specify both 'top' and 'bottom' in the same query");
				options.top = params.top;
			} else if(null != params.bottom) options.bottom = params.bottom;
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			_g.executor.histogram(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.histogramTag:rg.query.ReportGridTransformers.histogram,params,keep,handler));
		});
	}
	,intersectSeries: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultSeriesOptions(params), properties = [];
			options.properties = properties;
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			var _g1 = 0, _g2 = params.properties.length;
			while(_g1 < _g2) {
				var i = _g1++;
				var item = params.properties[i];
				if(js.Boot.__instanceof(item,String)) item = params.properties[i] = { property : item};
				var o = { property : params.event + rg.query.ReportGridBaseQuery._prefixProperty(item.property)};
				if(null != item.top) {
					if(null != item.bottom) rg.query.ReportGridBaseQuery._error("you can't specify both 'top' and 'bottom' for the same property");
					o.order = "descending";
					o.limit = item.top;
				} else if(null != item.bottom) {
					o.order = "ascending";
					o.limit = item.bottom;
				}
				properties.push(o);
			}
			_g.executor.intersect(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.intersectSeriesTag:rg.query.ReportGridTransformers.intersectSeries,params,keep,handler));
		});
	}
	,intersect: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params,{ periodicity : "eternity"}), properties = [];
			options.properties = properties;
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			var _g1 = 0, _g2 = params.properties.length;
			while(_g1 < _g2) {
				var i = _g1++;
				var item = params.properties[i];
				if(js.Boot.__instanceof(item,String)) item = params.properties[i] = { property : item};
				var o = { property : params.event + rg.query.ReportGridBaseQuery._prefixProperty(item.property)};
				if(null != item.top) {
					if(null != item.bottom) rg.query.ReportGridBaseQuery._error("you can't specify both 'top' and 'bottom' for the same property");
					o.order = "descending";
					o.limit = item.top;
				} else if(null != item.bottom) {
					o.order = "ascending";
					o.limit = item.bottom;
				}
				properties.push(o);
			}
			_g.executor.intersect(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.intersectTag:rg.query.ReportGridTransformers.intersect,params,keep,handler));
		});
	}
	,summarySeries: function(p,keep) {
		var _g1 = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			if(null == params.type) params.type = "mean";
			rg.query.ReportGridBaseQuery._ensureTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultSeriesOptions(params);
			options.property = params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property);
			var tranform = null != params.tag?rg.query.ReportGridTransformers.propertySummarySeriesTagGroupedBy:rg.query.ReportGridTransformers.propertySummarySeries;
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			var _g = params.type.toLowerCase();
			switch(_g) {
			case "mean":
				_g1.executor.propertyMeans(params.path,options,rg.query.ReportGridBaseQuery._complete(tranform,params,keep,handler));
				break;
			case "standarddeviation":
				_g1.executor.propertyStandardDeviations(params.path,options,rg.query.ReportGridBaseQuery._complete(tranform,params,keep,handler));
				break;
			case "sum":
				_g1.executor.propertySums(params.path,options,rg.query.ReportGridBaseQuery._complete(tranform,params,keep,handler));
				break;
			default:
				rg.query.ReportGridBaseQuery._error("invalid summary type: '" + params.type + "'");
			}
		});
	}
	,summary: function(p,keep) {
		var _g1 = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			if(null == params.type) params.type = "mean";
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params);
			options.property = params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property);
			options.periodicity = "single";
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			var _g = params.type.toLowerCase();
			switch(_g) {
			case "mean":
				_g1.executor.propertyMeans(params.path,options,rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.propertySummary,params,keep,handler));
				break;
			case "standarddeviation":
				_g1.executor.propertyStandardDeviations(params.path,options,rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.propertySummary,params,keep,handler));
				break;
			case "sum":
				_g1.executor.propertySums(params.path,options,rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.propertySummary,params,keep,handler));
				break;
			default:
				rg.query.ReportGridBaseQuery._error("invalid summary type: '" + params.type + "'");
			}
		});
	}
	,count: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params);
			if(null != params.where) {
				if(null != params.property) rg.query.ReportGridBaseQuery._error("the 'where' and the 'property' fields cannot be used together in a count query"); else if(null != params.value) rg.query.ReportGridBaseQuery._error("the 'where' and the 'value' fields cannot be used together in a count query");
				options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
				_g.executor.searchCount(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.eventCountTag:rg.query.ReportGridTransformers.eventCount,params,keep,handler));
			} else if(null != params.property) {
				if(null == params.value) rg.query.ReportGridBaseQuery._error("can't count on a property");
				options.property = params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property);
				options.value = params.value;
				_g.executor.propertyValueCount(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.propertyValueCountTag:rg.query.ReportGridTransformers.propertyValueCount,params,keep,handler));
			} else {
				options.property = params.event;
				_g.executor.propertyCount(params.path,options,rg.query.ReportGridBaseQuery._complete(null != params.tag?rg.query.ReportGridTransformers.eventCountTag:rg.query.ReportGridTransformers.eventCount,params,keep,handler));
			}
		});
	}
	,values: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			rg.query.ReportGridBaseQuery._ensureOptionalTimeParams(params);
			var options = rg.query.ReportGridBaseQuery._defaultOptions(params,{ property : params.event + rg.query.ReportGridBaseQuery._prefixProperty(params.property)});
			if(null != params.where) options.where = rg.query.ReportGridBaseQuery._where(params.event,params.where);
			_g.executor.propertyValues(params.path,options,rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.propertyValues,params,keep,handler));
		});
	}
	,properties: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			_g.executor.children(params.path,{ property : params.event},rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.childrenProperty,params,keep,handler));
		});
	}
	,events: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			_g.executor.children(params.path,{ type : "property"},rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.childrenEvent,params,keep,handler));
		});
	}
	,paths: function(p,keep) {
		var _g = this;
		keep = null == keep?[]:js.Boot.__instanceof(keep,String)?[keep]:keep;
		return this.data(null == p?[{ }]:js.Boot.__instanceof(p,Array)?p:[p]).stackCross().asyncEach(function(params,handler) {
			_g.executor.children(params.parent,{ type : "path"},rg.query.ReportGridBaseQuery._complete(rg.query.ReportGridTransformers.childrenPath,params,keep,handler));
		});
	}
	,executor: null
	,__class__: rg.query.ReportGridBaseQuery
});
rg.query.ReportGridQuery = function(executor) {
	rg.query.ReportGridBaseQuery.call(this,null,this);
	this.executor = executor;
};
rg.query.ReportGridQuery.__name__ = ["rg","query","ReportGridQuery"];
rg.query.ReportGridQuery.create = function(executor) {
	var start = new rg.query.ReportGridQuery(executor), query = start._createQuery(null,start);
	start._next = query;
	return query;
}
rg.query.ReportGridQuery.__super__ = rg.query.ReportGridBaseQuery;
rg.query.ReportGridQuery.prototype = $extend(rg.query.ReportGridBaseQuery.prototype,{
	execute: function(handler) {
		rg.query.Query.executeHandler(this,handler);
	}
	,__class__: rg.query.ReportGridQuery
});
rg.query.ReportGridTransformers = function() { }
rg.query.ReportGridTransformers.__name__ = ["rg","query","ReportGridTransformers"];
rg.query.ReportGridTransformers.childrenPath = function(arr,params,keep) {
	var parent = params.parent, prefix = parent == "/"?"":parent;
	return arr.map(function(path) {
		var o = { parent : parent, path : prefix + "/" + path};
		rg.query.ReportGridTransformers._keep(params,o,keep);
		return o;
	});
}
rg.query.ReportGridTransformers.childrenEvent = function(arr,params,keep) {
	var path = params.path;
	return arr.map(function(event) {
		var o = { path : path, event : HxOverrides.substr(event,1,null)};
		rg.query.ReportGridTransformers._keep(params,o,keep);
		return o;
	});
}
rg.query.ReportGridTransformers.childrenProperty = function(arr,params,keep) {
	var path = params.path, event = params.event;
	return arr.map(function(property) {
		var o = { path : path, event : event, property : HxOverrides.substr(property,1,null)};
		rg.query.ReportGridTransformers._keep(params,o,keep);
		return o;
	});
}
rg.query.ReportGridTransformers.propertyValues = function(arr,params,keep) {
	var path = params.path, event = params.event, property = params.property;
	return arr.map(function(value) {
		var o = { path : path, event : event, property : property, value : value};
		rg.query.ReportGridTransformers._keep(params,o,keep);
		if(null != params.where) Objects.copyTo(params.where,o);
		return o;
	});
}
rg.query.ReportGridTransformers.histogram = function(arr,params,keep) {
	var property = params.property;
	return arr.map(function(value) {
		var o = { count : value[1]};
		rg.query.ReportGridTransformers._keep(params,o,keep);
		if(null != params.where) Objects.copyTo(params.where,o);
		o[property] = value[0];
		return o;
	});
}
rg.query.ReportGridTransformers.events = function(arr,params,keep) {
	if(keep.length == 0) return arr; else return arr.map(function(o) {
		rg.query.ReportGridTransformers._keep(params,o,keep);
		return o;
	});
}
rg.query.ReportGridTransformers.histogramTag = function(counts,params,keep) {
	var tag = params.tag, property = params.property;
	return Arrays.flatten(Objects.map(counts,function(key,value) {
		return value.map(function(item) {
			var o = { count : item[1]};
			rg.query.ReportGridTransformers._keep(params,o,keep);
			if(null != params.where) Objects.copyTo(params.where,o);
			o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
			o[property] = item[0];
			return o;
		});
	}));
}
rg.query.ReportGridTransformers.propertiesHistogram = function(arr,params,keep) {
	var property = params.property;
	return arr.map(function(value) {
		var o = { count : value[1]};
		rg.query.ReportGridTransformers._keep(params,o,keep);
		if(null != params.where) Objects.copyTo(params.where,o);
		o[property] = Strings.ltrim(value[0],".");
		return o;
	});
}
rg.query.ReportGridTransformers.intersect = function(ob,params,keep) {
	var properties = params.properties, result = [];
	var _g = 0, _g1 = Objects.flatten(ob);
	while(_g < _g1.length) {
		var pair = _g1[_g];
		++_g;
		var o = { count : pair.value};
		if(null != params.where) Objects.copyTo(params.where,o);
		rg.query.ReportGridTransformers._keep(params,o,keep);
		var _g3 = 0, _g2 = properties.length;
		while(_g3 < _g2) {
			var i = _g3++;
			o[properties[i].property] = thx.json.Json.decode(pair.fields[i]);
		}
		result.push(o);
	}
	return result;
}
rg.query.ReportGridTransformers.intersectTag = function(ob,params,keep) {
	var tag = params.tag, properties = params.properties, result = [];
	Objects.each(ob,function(key,value) {
		var _g = 0, _g1 = Objects.flatten(value);
		while(_g < _g1.length) {
			var pair = _g1[_g];
			++_g;
			var o = { count : pair.value};
			if(null != params.where) Objects.copyTo(params.where,o);
			rg.query.ReportGridTransformers._keep(params,o,keep);
			o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
			var _g3 = 0, _g2 = properties.length;
			while(_g3 < _g2) {
				var i = _g3++;
				o[properties[i].property] = thx.json.Json.decode(pair.fields[i]);
			}
			result.push(o);
		}
	});
	return result;
}
rg.query.ReportGridTransformers.intersectSeries = function(ob,params,keep) {
	var properties = params.properties, periodicity = params.periodicity, timezone = params.timezone, groupby = params.groupby, result = [];
	var _g = 0, _g1 = Objects.flatten(ob);
	while(_g < _g1.length) {
		var pair = _g1[_g];
		++_g;
		var values = pair.value;
		var _g2 = 0;
		while(_g2 < values.length) {
			var item = values[_g2];
			++_g2;
			var o = { count : item[1]};
			if(null != params.where) Objects.copyTo(params.where,o);
			rg.query.ReportGridTransformers._keep(params,o,keep);
			rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,timezone,groupby);
			var _g4 = 0, _g3 = properties.length;
			while(_g4 < _g3) {
				var i = _g4++;
				o[properties[i].property] = thx.json.Json.decode(pair.fields[i]);
			}
			result.push(o);
		}
	}
	return result;
}
rg.query.ReportGridTransformers.intersectSeriesTag = function(ob,params,keep) {
	var properties = params.properties, periodicity = params.periodicity, tag = params.tag, timezone = params.timezone, groupby = params.groupby, result = [];
	Objects.each(ob,function(key,value) {
		var _g = 0, _g1 = Objects.flatten(value);
		while(_g < _g1.length) {
			var pair = _g1[_g];
			++_g;
			var values = pair.value;
			var _g2 = 0;
			while(_g2 < values.length) {
				var item = values[_g2];
				++_g2;
				var o = { count : item[1]};
				if(null != params.where) Objects.copyTo(params.where,o);
				rg.query.ReportGridTransformers._keep(params,o,keep);
				rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,timezone,groupby);
				o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
				var _g4 = 0, _g3 = properties.length;
				while(_g4 < _g3) {
					var i = _g4++;
					o[properties[i].property] = thx.json.Json.decode(pair.fields[i]);
				}
				result.push(o);
			}
		}
	});
	return result;
}
rg.query.ReportGridTransformers.eventCount = function(count,params,keep) {
	var o = { event : params.event, count : count};
	if(null != params.where) Objects.copyTo(params.where,o);
	rg.query.ReportGridTransformers._keep(params,o,keep);
	if(null != params.where) Objects.copyTo(params.where,o);
	return [o];
}
rg.query.ReportGridTransformers.eventCountTag = function(counts,params,keep) {
	var event = params.event, tag = params.tag;
	return Objects.map(counts,function(key,count) {
		var o = { event : event, count : count};
		if(null != params.where) Objects.copyTo(params.where,o);
		rg.query.ReportGridTransformers._keep(params,o,keep);
		o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
		if(null != params.where) Objects.copyTo(params.where,o);
		return o;
	});
}
rg.query.ReportGridTransformers.eventSeriesTagGroupedBy = function(ob,params,keep) {
	var event = params.event, periodicity = params.periodicity, where = params.where, groupby = params.groupby, tag = params.tag;
	return Arrays.flatten(Objects.map(ob,function(key,values) {
		var result = [];
		var _g = 0;
		while(_g < values.length) {
			var item = values[_g];
			++_g;
			var o = { event : event, count : item[1]};
			if(null != params.where) Objects.copyTo(params.where,o);
			rg.query.ReportGridTransformers._keep(params,o,keep);
			o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
			rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,null,groupby);
			if(null != where) Objects.copyTo(where,o);
			result.push(o);
		}
		return result;
	}));
}
rg.query.ReportGridTransformers.eventSeries = function(values,params,keep) {
	var event = params.event, periodicity = params.periodicity, where = params.where, timezone = params.timezone, groupby = params.groupby, result = [];
	var _g = 0;
	while(_g < values.length) {
		var item = values[_g];
		++_g;
		var o = { event : event, count : item[1]};
		if(null != params.where) Objects.copyTo(params.where,o);
		rg.query.ReportGridTransformers._keep(params,o,keep);
		rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,timezone,groupby);
		if(null != where) Objects.copyTo(where,o);
		result.push(o);
	}
	return result;
}
rg.query.ReportGridTransformers.propertySummary = function(value,params,keep) {
	var o = { };
	if(null != params.where) Objects.copyTo(params.where,o);
	rg.query.ReportGridTransformers._keep(params,o,keep);
	o[params.type] = value[0][1];
	return [o];
}
rg.query.ReportGridTransformers.propertySummarySeries = function(values,params,keep) {
	var periodicity = params.periodicity, type = params.type, timezone = params.timezone, groupby = params.groupby, result = [];
	var _g = 0;
	while(_g < values.length) {
		var item = values[_g];
		++_g;
		var o = { };
		if(null != params.where) Objects.copyTo(params.where,o);
		rg.query.ReportGridTransformers._keep(params,o,keep);
		rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,timezone,groupby);
		o[type] = item[1];
		result.push(o);
	}
	return result;
}
rg.query.ReportGridTransformers.propertySummarySeriesTagGroupedBy = function(ob,params,keep) {
	var periodicity = params.periodicity, type = params.type, groupby = params.groupby, tag = params.tag;
	return Arrays.flatten(Objects.map(ob,function(key,values) {
		var result = [];
		var _g = 0;
		while(_g < values.length) {
			var item = values[_g];
			++_g;
			var o = { };
			rg.query.ReportGridTransformers._keep(params,o,keep);
			if(null != params.where) Objects.copyTo(params.where,o);
			o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
			o[type] = item[1];
			rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,null,groupby);
			result.push(o);
		}
		return result;
	}));
}
rg.query.ReportGridTransformers.propertyValueCount = function(count,params,keep) {
	var o = { count : count};
	rg.query.ReportGridTransformers._keep(params,o,keep);
	o[params.property] = params.value;
	return [o];
}
rg.query.ReportGridTransformers.propertyValueCountTag = function(counts,params,keep) {
	var property = params.property, value = params.value, tag = params.tag;
	return Objects.map(counts,function(key,count) {
		var o = { count : count};
		if(null != params.where) Objects.copyTo(params.where,o);
		rg.query.ReportGridTransformers._keep(params,o,keep);
		o[property] = value;
		o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
		return o;
	});
}
rg.query.ReportGridTransformers.propertyValueSeries = function(values,params,keep) {
	var property = params.property, periodicity = params.periodicity, value = params.value, timezone = params.timezone, groupby = params.groupby, result = [];
	var _g = 0;
	while(_g < values.length) {
		var item = values[_g];
		++_g;
		var o = { count : item[1]};
		if(null != params.where) Objects.copyTo(params.where,o);
		rg.query.ReportGridTransformers._keep(params,o,keep);
		o[property] = value;
		rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,timezone,groupby);
		result.push(o);
	}
	return result;
}
rg.query.ReportGridTransformers.propertyValueSeriesTagGroupedBy = function(ob,params,keep) {
	var property = params.property, value = params.value, periodicity = params.periodicity, groupby = params.groupby, tag = params.tag;
	return Arrays.flatten(Objects.map(ob,function(key,values) {
		var result = [];
		var _g = 0;
		while(_g < values.length) {
			var item = values[_g];
			++_g;
			var o = { count : item[1]};
			if(null != params.where) Objects.copyTo(params.where,o);
			rg.query.ReportGridTransformers._keep(params,o,keep);
			ob[property] = value;
			o[tag] = Strings.rtrim(Strings.ltrim(key,"/"),"/");
			rg.query.ReportGridTransformers._injectTime(o,item[0],periodicity,null,groupby);
			result.push(o);
		}
		return result;
	}));
}
rg.query.ReportGridTransformers._keep = function(src,dst,tokeep) {
	var _g = 0;
	while(_g < tokeep.length) {
		var k = tokeep[_g];
		++_g;
		if(Reflect.hasField(dst,k)) continue;
		dst[k] = Reflect.field(src,k);
	}
}
rg.query.ReportGridTransformers._injectTime = function(o,value,periodicity,timezone,groupby) {
	if(null != groupby) {
		o[periodicity] = Reflect.field(value,periodicity);
		o.groupby = groupby;
	} else if(null != timezone) {
		if(timezone == 0) o["time:" + periodicity] = value.timestamp; else o["time:" + periodicity] = rg.query.ReportGridTransformers._parseTimeTZ(value.datetime);
		o.timezone = timezone;
	} else o["time:" + periodicity] = rg.query.ReportGridTransformers._fixDay(value.timestamp,periodicity);
}
rg.query.ReportGridTransformers._fixDay = function(timestamp,periodicity) {
	switch(periodicity) {
	case "day":
		return Dates.snap(timestamp,periodicity,0);
	default:
		return timestamp;
	}
}
rg.query.ReportGridTransformers._parseTimeTZ = function(s) {
	var sign = 1, pos = s.lastIndexOf("+");
	if(pos < 0) {
		sign = -1;
		pos = s.lastIndexOf("-");
	}
	var d = HxOverrides.strDate(StringTools.replace(StringTools.replace(HxOverrides.substr(s,0,pos),"T"," "),".000","")), t = thx.date.DateParser.parseTime(HxOverrides.substr(s,pos + 1,null));
	return d.getTime() + sign * (t.hour * 60 * 60 * 1000 + t.minute * 60 * 1000 + t.second * 1000 + t.millis);
}
rg.query.Transformers = function() { }
rg.query.Transformers.__name__ = ["rg","query","Transformers"];
rg.query.Transformers.crossStack = function(data) {
	if(data.length <= 1) return data;
	var src = data.shift();
	while(data.length > 0) {
		var values = data.shift(), results = [];
		var _g = 0;
		while(_g < src.length) {
			var item = src[_g];
			++_g;
			var _g1 = 0;
			while(_g1 < values.length) {
				var value = values[_g1];
				++_g1;
				results.push(Objects.copyTo(value,Objects.copyTo(item,{ })));
			}
		}
		src = results;
	}
	return [src];
}
rg.query.Transformers.split = function(data,f) {
	var map = new Hash(), result = [];
	data.forEach(function(dp,_) {
		var name = "" + f(dp), pos = map.get(name);
		if(null == pos) {
			pos = result.length;
			map.set(name,pos);
			result.push([]);
		}
		result[pos].push(dp);
	});
	return result;
}
rg.query.Transformers.map = function(handler) {
	return function(data) {
		return Iterators.map(HxOverrides.iter(data),handler);
	};
}
rg.query.Transformers.toObject = function(field) {
	return function(data) {
		return data.map(function(dp) {
			var ob = { };
			ob[field] = dp;
			return ob;
		});
	};
}
rg.query.Transformers.filter = function(handler) {
	return function(data) {
		return data.filter(handler);
	};
}
rg.query.Transformers.filterValues = function(o) {
	var entries = Objects.entries(o);
	entries.forEach(function(entry,_) {
		if(!Reflect.isFunction(entry.value)) {
			var test = entry.value;
			entry.value = function(v) {
				return v == test;
			};
		}
	});
	var handler = function(d) {
		var _g = 0;
		while(_g < entries.length) {
			var entry = entries[_g];
			++_g;
			if(!entry.value(Reflect.field(d,entry.key))) return false;
		}
		return true;
	};
	return function(data) {
		return data.filter(handler);
	};
}
rg.query.Transformers.filterValue = function(name,o) {
	if(!Reflect.isFunction(o)) {
		var test = o;
		o = function(v) {
			return v == test;
		};
	}
	var handler = function(d) {
		if(!o(Reflect.field(d,name))) return false;
		return true;
	};
	return function(data) {
		return data.filter(handler);
	};
}
rg.query.Transformers.setField = function(name,o) {
	if(!Reflect.isFunction(o)) {
		var value = o;
		o = function(obj) {
			return value;
		};
	}
	var handler = function(obj) {
		obj[name] = o(obj);
	};
	return function(data) {
		data.forEach(function(d,_) {
			handler(d);
		});
		return data;
	};
}
rg.query.Transformers.mapField = function(name,o) {
	if(!Reflect.isFunction(o)) {
		var value = o;
		o = function(obj) {
			return value;
		};
	}
	var handler = function(obj) {
		obj[name] = o(Reflect.field(obj,name));
	};
	return function(data) {
		data.forEach(function(d,_) {
			handler(d);
		});
		return data;
	};
}
rg.query.Transformers.setFields = function(o) {
	var fields = Reflect.fields(o), fs = [];
	var _g = 0;
	while(_g < fields.length) {
		var field = fields[_g];
		++_g;
		var f = Reflect.field(o,field);
		if(!Reflect.isFunction(f)) fs.push((function(f1,v) {
			return function(a1) {
				return f1(v,a1);
			};
		})(function(v,obj) {
			return v;
		},f)); else fs.push(f);
	}
	var handler = function(obj) {
		var _g1 = 0, _g = fields.length;
		while(_g1 < _g) {
			var j = _g1++;
			obj[fields[j]] = fs[j](obj);
		}
	};
	return function(data) {
		data.forEach(function(d,_) {
			handler(d);
		});
		return data;
	};
}
rg.query.Transformers.mapFields = function(o) {
	var fields = Reflect.fields(o), fs = [];
	var _g = 0;
	while(_g < fields.length) {
		var field = fields[_g];
		++_g;
		var f = Reflect.field(o,field);
		if(!Reflect.isFunction(f)) fs.push((function(f1,v) {
			return function(a1) {
				return f1(v,a1);
			};
		})(function(v,obj) {
			return v;
		},f)); else fs.push(f);
	}
	var handler = function(obj) {
		var _g1 = 0, _g = fields.length;
		while(_g1 < _g) {
			var j = _g1++;
			obj[fields[j]] = fs[j](Reflect.field(obj,fields[j]));
		}
	};
	return function(data) {
		data.forEach(function(d,_) {
			handler(d);
		});
		return data;
	};
}
rg.query.Transformers.sort = function(handler) {
	return function(data) {
		return (function($this) {
			var $r;
			data.sort(null == handler?Dynamics.compare:handler);
			$r = data;
			return $r;
		}(this));
	};
}
rg.query.Transformers.limit = function(offset,count) {
	return function(data) {
		if(offset >= data.length) return [];
		var end = offset + count > data.length?data.length:offset + count;
		return data.slice(offset,end);
	};
}
rg.query.Transformers.reverse = function(arr) {
	arr.reverse();
	return arr;
}
rg.query.Transformers.uniquef = function(fun) {
	return function(arr) {
		var i = 0, j;
		while(i < arr.length - 1) {
			var cur = arr[i];
			j = arr.length - 1;
			while(j > i) {
				if(fun(cur,arr[j])) arr.splice(j,1);
				j--;
			}
			i++;
		}
		return arr;
	};
}
rg.query.Transformers.rotate = function(matchingf) {
	if(js.Boot.__instanceof(matchingf,String)) {
		var field = matchingf;
		matchingf = function(a,b) {
			return Reflect.field(a,field) == Reflect.field(b,field);
		};
	}
	var m = null == matchingf?function(_,_1,i,k) {
		return i == k;
	}:function(a,b,_,_1) {
		return matchingf(a,b);
	};
	return function(data) {
		var traversed = [], da = data[0];
		var _g1 = 0, _g = da.length;
		while(_g1 < _g) {
			var i = _g1++;
			var a = da[i], traversal = [a];
			var _g3 = 1, _g2 = data.length;
			while(_g3 < _g2) {
				var j = _g3++;
				var db = data[j];
				var _g5 = 0, _g4 = db.length;
				while(_g5 < _g4) {
					var k = _g5++;
					var b = db[k];
					if(m(a,b,i,k)) {
						traversal.push(b);
						break;
					}
				}
			}
			traversed.push(traversal);
		}
		return traversed;
	};
}
rg.storage = {}
rg.storage.IStorage = function() { }
rg.storage.IStorage.__name__ = ["rg","storage","IStorage"];
rg.storage.IStorage.prototype = {
	remove: null
	,get: null
	,set: null
	,keys: null
	,__class__: rg.storage.IStorage
}
rg.storage.BrowserStorage = function(api,kind) {
	this.storage = api;
	this.kind = kind;
};
rg.storage.BrowserStorage.__name__ = ["rg","storage","BrowserStorage"];
rg.storage.BrowserStorage.__interfaces__ = [rg.storage.IStorage];
rg.storage.BrowserStorage.hasSessionStorage = function() {
	try {
		return 'undefined' != typeof window.sessionStorage;
	} catch( e ) {
		return false;
	}
}
rg.storage.BrowserStorage.sessionStorage = function() {
	return new rg.storage.BrowserStorage(sessionStorage,"sessionStorage");
}
rg.storage.BrowserStorage.hasLocalStorage = function() {
	try {
		return 'undefined' != typeof window.localStorage;
	} catch( e ) {
		return false;
	}
}
rg.storage.BrowserStorage.localStorage = function() {
	return new rg.storage.BrowserStorage(localStorage,"localStorage");
}
rg.storage.BrowserStorage.prototype = {
	keys: function() {
		var keys = [];
		var _g1 = 0, _g = this.storage.length;
		while(_g1 < _g) {
			var i = _g1++;
			keys.push(this.storage.key(i));
		}
		return HxOverrides.iter(keys);
	}
	,remove: function(name) {
		this.storage.removeItem(name);
	}
	,get: function(name) {
		var v = this.storage.getItem(name);
		if(null == v) return v; else return thx.json.Json.decode(v);
	}
	,set: function(name,value) {
		this.storage.setItem(name,thx.json.Json.encode(value));
	}
	,kind: null
	,storage: null
	,__class__: rg.storage.BrowserStorage
}
rg.storage.MemoryStorage = function() {
	this.storage = new Hash();
};
rg.storage.MemoryStorage.__name__ = ["rg","storage","MemoryStorage"];
rg.storage.MemoryStorage.__interfaces__ = [rg.storage.IStorage];
rg.storage.MemoryStorage.prototype = {
	keys: function() {
		return this.storage.keys();
	}
	,remove: function(name) {
		this.storage.remove(name);
	}
	,get: function(name) {
		return this.storage.get(name);
	}
	,set: function(name,value) {
		this.storage.set(name,value);
	}
	,storage: null
	,__class__: rg.storage.MemoryStorage
}
rg.util = {}
rg.util.Jsonp = function() { }
rg.util.Jsonp.__name__ = ["rg","util","Jsonp"];
rg.util.Jsonp.get = function(path,success,failure,query,headers) {
	var api = rg.util.Jsonp.get_api;
	api(path,{ success : success, failure : failure},query,headers);
}
rg.util.Jsonp.request_api = function(method,path,content,actions,query,headers) {
	if(null == query) query = { };
	path = rg.util.Urls.addQueryParameters(path,query);
	if(null == headers) headers = { };
	var success = actions.success, failure = null == actions.failure?function(_,_1) {
	}:actions.failure;
	var random = Math.random() * 214748363 | 0, funcName = "ReportGridChartsJsonpCallback" + random, head = js.Browser.document.head;
	if(null == head) head = js.Browser.document.getElementsByTagName("head")[0];
	js.Browser.window[funcName] = function(content1,meta) {
		if(meta.status.code == 200 || meta.status.code == "OK") success(content1); else failure(meta.status.code,meta.status.reason);
		head.removeChild(js.Browser.document.getElementById(funcName));
		js.Browser.window[funcName] = undefined;
		try{ delete window[funcName]; }catch(e){}
	};
	var extraQuery = { };
	extraQuery.method = method;
	if(Reflect.fields(headers).length > 0) extraQuery.headers = thx.json.Json.encode(headers);
	extraQuery.callback = funcName;
	if(content != null) extraQuery.content = thx.json.Json.encode(content);
	var fullUrl = rg.util.Urls.addQueryParameters(path,extraQuery);
	var script = js.Browser.document.createElement("SCRIPT");
	script.setAttribute("type","text/javascript");
	script.setAttribute("src",fullUrl);
	script.setAttribute("id",funcName);
	head.appendChild(script);
}
rg.util.Jsonp.get_api = function(path,actions,query,headers) {
	rg.util.Jsonp.request_api("GET",path,null,actions,query,headers);
}
rg.util.Periodicity = function() { }
rg.util.Periodicity.__name__ = ["rg","util","Periodicity"];
rg.util.Periodicity.defaultPeriodicity = function(span) {
	if(null == span || 0 == span) return "eternity";
	if(span <= 21600000) return "minute"; else if(span <= 172800000) return "hour"; else if(span <= 5184000 * 1000) return "day"; else if(span <= 62208000 * 1000) return "month"; else return "year";
}
rg.util.Periodicity.defaultRange = function(periodicity) {
	return (function($this) {
		var $r;
		switch(periodicity) {
		case "eternity":case "single":
			$r = [0.0,0.0];
			break;
		case "minute":
			$r = rg.util.Periodicity.parsePair("6 hours ago","now");
			break;
		case "hour":
			$r = rg.util.Periodicity.parsePair("2 days ago","now");
			break;
		case "day":
			$r = rg.util.Periodicity.parsePair("14 days ago","today");
			break;
		case "month":
			$r = rg.util.Periodicity.parsePair("6 months ago","today");
			break;
		case "year":
			$r = rg.util.Periodicity.parsePair("6 years ago","today");
			break;
		default:
			$r = (function($this) {
				var $r;
				throw "invalid periodicity: " + periodicity;
				return $r;
			}($this));
		}
		return $r;
	}(this));
}
rg.util.Periodicity.range = function(start,end,periodicity) {
	var step = 1000;
	switch(periodicity) {
	case "eternity":case "single":
		return [0.0];
	case "minute":
		step = 60000;
		break;
	case "hour":
		step = 3600000;
		break;
	case "day":
		var s = Dates.snap(start,"day"), e = Dates.snap(end,"day");
		var result = [];
		while(s <= e) {
			result.push(s);
			s = Dates.snap(s + 86400000,"day");
		}
		return result;
	case "week":
		step = 604800000;
		break;
	case "month":
		var s = rg.util.Periodicity.dateUtc(start), e = rg.util.Periodicity.dateUtc(end), sy = s.getFullYear(), ey = e.getFullYear(), sm = s.getMonth(), em = e.getMonth();
		var result = [];
		while(sy < ey || sy == ey && sm <= em) {
			result.push(new Date(sy,sm,1,0,0,0).getTime());
			sm++;
			if(sm > 11) {
				sm = 0;
				sy++;
			}
		}
		return result;
	case "year":
		var result = Ints.range(rg.util.Periodicity.dateUtc(start).getFullYear(),rg.util.Periodicity.dateUtc(end).getFullYear() + 1,1).map(function(d) {
			return new Date(d,0,1,0,0,0).getTime();
		});
		return result;
	}
	return Floats.range(start,end + step,step);
}
rg.util.Periodicity.format = function(periodicity,v) {
	switch(periodicity) {
	case "eternity":
		return "all time";
	case "single":
		return "period";
	case "minute":
		return thx.culture.FormatDate.timeShort((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
	case "hour":
		return thx.culture.FormatDate.hourShort((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
	case "day":case "week":
		return thx.culture.FormatDate.dateShort((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
	case "month":
		return thx.culture.FormatDate.yearMonth((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
	case "year":
		return thx.culture.FormatDate.year((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
	default:
		return periodicity + ": " + v;
	}
}
rg.util.Periodicity.parsePair = function(start,end) {
	return [thx.date.DateParser.parse(start).getTime(),thx.date.DateParser.parse(end).getTime()];
}
rg.util.Periodicity.dateUtc = function(v) {
	var d = (function($this) {
		var $r;
		var d1 = new Date();
		d1.setTime(v);
		$r = d1;
		return $r;
	}(this)), offset = d.getTimezoneOffset();
	if(offset < 0) offset = 0;
	return (function($this) {
		var $r;
		var d1 = new Date();
		d1.setTime(v + 60000 * offset);
		$r = d1;
		return $r;
	}(this));
}
rg.util.Urls = function() { }
rg.util.Urls.__name__ = ["rg","util","Urls"];
rg.util.Urls.addQueryParameters = function(url,query) {
	var suffix = url.indexOf("?") < 0?"?":"&", queries = [];
	var _g = 0, _g1 = Reflect.fields(query);
	while(_g < _g1.length) {
		var key = _g1[_g];
		++_g;
		var value = Std.string(Reflect.field(query,key));
		queries.push(key + "=" + StringTools.urlEncode(value));
	}
	if(queries.length == 0) return url; else return url + suffix + queries.join("&");
}
var thx = {}
thx.csv = {}
thx.csv.Csv = function() { }
thx.csv.Csv.__name__ = ["thx","csv","Csv"];
thx.csv.Csv.decode = function(value,check_type,delimiter,emptytonull,newline,quote,doublequotations,skipwhitespace) {
	var handler = new thx.data.ValueHandler();
	new thx.csv.CsvDecoder(handler,check_type,delimiter,emptytonull,newline,quote,doublequotations,skipwhitespace).decode(value);
	return handler.value;
}
thx.csv.CsvDecoder = function(handler,check_type,delimiter,emptytonull,newline,quote,doublequotations,trim_whitespace) {
	if(trim_whitespace == null) trim_whitespace = true;
	if(doublequotations == null) doublequotations = true;
	if(quote == null) quote = "\"";
	if(newline == null) newline = "\r\n|\n|\r";
	if(emptytonull == null) emptytonull = false;
	if(delimiter == null) delimiter = ",";
	if(check_type == null) check_type = true;
	this.handler = handler;
	this.delimiter = delimiter;
	this.emptytonull = emptytonull;
	this.quote = quote;
	this.doublequotations = doublequotations;
	this.trim_whitespace = trim_whitespace;
	this.check_type = check_type;
	if(newline != "\r\n|\n|\r") newline = thx.text.ERegs.escapeERegChars(newline);
	this.newline = newline;
	this._end = new EReg("(" + thx.text.ERegs.escapeERegChars(delimiter) + "|" + newline + "|$)","");
};
thx.csv.CsvDecoder.__name__ = ["thx","csv","CsvDecoder"];
thx.csv.CsvDecoder.prototype = {
	typeString: function(s) {
		this.handler.arrayItemStart();
		if(s == "" && this.emptytonull) this.handler.valueNull(); else this.handler.valueString(s);
		this.handler.arrayItemEnd();
	}
	,typeDate: function(s) {
		this.handler.arrayItemStart();
		this.handler.valueDate(Dates.parse(s));
		this.handler.arrayItemEnd();
	}
	,typeBool: function(s) {
		this.handler.arrayItemStart();
		this.handler.valueBool(Bools.parse(s));
		this.handler.arrayItemEnd();
	}
	,typeFloat: function(s) {
		this.handler.arrayItemStart();
		this.handler.valueFloat(Floats.parse(s));
		this.handler.arrayItemEnd();
	}
	,typeCultureFloat: function(s) {
		this.handler.arrayItemStart();
		this.handler.valueFloat(thx.number.NumberParser.parse(s,thx.culture.Culture.get_defaultCulture()));
		this.handler.arrayItemEnd();
	}
	,typeInt: function(s) {
		this.handler.arrayItemStart();
		this.handler.valueInt(Ints.parse(s));
		this.handler.arrayItemEnd();
	}
	,typeToken: function(s) {
		if(!this.check_type) this.typeString(s); else if(Ints.canParse(s)) this.typeInt(s); else if(Floats.canParse(s)) this.typeFloat(s); else if(Bools.canParse(s)) this.typeBool(s); else if(Dates.canParse(s)) this.typeDate(s); else this.typeString(s);
	}
	,getTyper: function(s) {
		var typer = this._typers[this.column];
		if(null == typer) {
			if(s == "") return $bind(this,this.typeToken);
			if(!this.check_type) typer = this._typers[this.column] = $bind(this,this.typeString); else if(Ints.canParse(s)) typer = this._typers[this.column] = $bind(this,this.typeInt); else if(thx.number.NumberParser.canParse(s,thx.culture.Culture.get_defaultCulture())) typer = this._typers[this.column] = $bind(this,this.typeCultureFloat); else if(Floats.canParse(s)) typer = this._typers[this.column] = $bind(this,this.typeFloat); else if(Bools.canParse(s)) typer = this._typers[this.column] = $bind(this,this.typeBool); else if(Dates.canParse(s)) typer = this._typers[this.column] = $bind(this,this.typeDate); else typer = this._typers[this.column] = $bind(this,this.typeString);
		}
		return typer;
	}
	,error: function(e) {
		return (function($this) {
			var $r;
			throw new thx.error.Error("invalid string value '{0}' at line {1}, column {2}",[Strings.ellipsis(e,50),$this.line,$this.column],null,{ fileName : "CsvDecoder.hx", lineNumber : 128, className : "thx.csv.CsvDecoder", methodName : "error"});
			return $r;
		}(this));
	}
	,parseValue: function() {
		if(HxOverrides.substr(this._s,0,1) == this.quote) {
			var pos = this._s.indexOf(this.quote,1);
			if(pos != -1) {
				if(this.doublequotations) while(HxOverrides.substr(this._s,pos + 1,1) == this.quote) {
					pos = this._s.indexOf(this.quote,pos + 2);
					if(pos == -1) {
						pos = this._s.length;
						break;
					}
				}
			} else pos = this._s.length;
			var v = HxOverrides.substr(this._s,1,pos - 1);
			this._s = HxOverrides.substr(this._s,pos + 1,null);
			this.typeString(StringTools.replace(v,this.quote + this.quote,this.quote));
			if(!this._end.match(this._s)) this.error(this._s);
			this._s = this._end.matchedRight();
			return this._end.matched(0) == this.delimiter;
		}
		if(!this._end.match(this._s)) this.error(this._s);
		this._s = this._end.matchedRight();
		if(this.line == 1) {
			var v = this._end.matchedLeft();
			if(this.trim_whitespace) v = StringTools.trim(v);
			this.typeToken(v);
		} else {
			var v = this._end.matchedLeft();
			if(this.trim_whitespace) v = StringTools.trim(v);
			(this.getTyper(v))(v);
		}
		if(this._end.matched(0) == this.delimiter) return true; else {
			this._s = StringTools.ltrim(this._s);
			return false;
		}
	}
	,parseLine: function() {
		this.handler.arrayItemStart();
		this.column = 1;
		this.handler.arrayStart();
		while(this.parseValue()) this.column++;
		this.handler.arrayEnd();
		this.line++;
		this.handler.arrayItemEnd();
	}
	,decode: function(s) {
		this._s = s;
		this._typers = [];
		this.line = 1;
		this.handler.start();
		this.handler.arrayStart();
		while(this._s.length > 0) this.parseLine();
		this.handler.arrayEnd();
		this.handler.end();
	}
	,_typers: null
	,_end: null
	,_s: null
	,handler: null
	,check_type: null
	,column: null
	,line: null
	,trim_whitespace: null
	,doublequotations: null
	,quote: null
	,newline: null
	,emptytonull: null
	,delimiter: null
	,__class__: thx.csv.CsvDecoder
}
thx.data = {}
thx.data.IDataHandler = function() { }
thx.data.IDataHandler.__name__ = ["thx","data","IDataHandler"];
thx.data.IDataHandler.prototype = {
	valueBool: null
	,valueNull: null
	,valueFloat: null
	,valueInt: null
	,valueString: null
	,valueDate: null
	,arrayEnd: null
	,arrayItemEnd: null
	,arrayItemStart: null
	,arrayStart: null
	,objectEnd: null
	,objectFieldEnd: null
	,objectFieldStart: null
	,objectStart: null
	,end: null
	,start: null
	,__class__: thx.data.IDataHandler
}
thx.culture = {}
thx.culture.Info = function() { }
thx.culture.Info.__name__ = ["thx","culture","Info"];
thx.culture.Info.prototype = {
	pluralRule: null
	,iso3: null
	,iso2: null
	,english: null
	,'native': null
	,name: null
	,__class__: thx.culture.Info
}
thx.culture.Culture = function() { }
thx.culture.Culture.__name__ = ["thx","culture","Culture"];
thx.culture.Culture.__properties__ = {get_cultures:"get_cultures"}
thx.culture.Culture.get_cultures = function() {
	if(null == thx.culture.Culture.cultures) thx.culture.Culture.cultures = new Hash();
	return thx.culture.Culture.cultures;
}
thx.culture.Culture.get_defaultCulture = function() {
	if(null == thx.culture.Culture._defaultCulture) return thx.cultures.EnUS.get_culture(); else return thx.culture.Culture._defaultCulture;
}
thx.culture.Culture.add = function(culture) {
	if(null == thx.culture.Culture._defaultCulture) thx.culture.Culture._defaultCulture = culture;
	var name = culture.name.toLowerCase();
	if(!thx.culture.Culture.get_cultures().exists(name)) thx.culture.Culture.get_cultures().set(name,culture);
}
thx.culture.Culture.__super__ = thx.culture.Info;
thx.culture.Culture.prototype = $extend(thx.culture.Info.prototype,{
	percent: null
	,currency: null
	,number: null
	,symbolPosInf: null
	,symbolNegInf: null
	,symbolPermille: null
	,symbolPercent: null
	,symbolNaN: null
	,signPos: null
	,signNeg: null
	,digits: null
	,isMetric: null
	,nativeRegion: null
	,englishRegion: null
	,currencyIso: null
	,currencySymbol: null
	,nativeCurrency: null
	,englishCurrency: null
	,date: null
	,language: null
	,__class__: thx.culture.Culture
});
thx.culture.FormatDate = function() { }
thx.culture.FormatDate.__name__ = ["thx","culture","FormatDate"];
thx.culture.FormatDate.format = function(pattern,date,culture,leadingspace) {
	if(leadingspace == null) leadingspace = true;
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	var pos = 0;
	var len = pattern.length;
	var buf = new StringBuf();
	var info = culture.date;
	while(pos < len) {
		var c = pattern.charAt(pos);
		if(c != "%") {
			buf.b += Std.string(c);
			pos++;
			continue;
		}
		pos++;
		c = pattern.charAt(pos);
		switch(c) {
		case "a":
			buf.b += Std.string(info.abbrDays[date.getDay()]);
			break;
		case "A":
			buf.b += Std.string(info.days[date.getDay()]);
			break;
		case "b":case "h":
			buf.b += Std.string(info.abbrMonths[date.getMonth()]);
			break;
		case "B":
			buf.b += Std.string(info.months[date.getMonth()]);
			break;
		case "c":
			buf.b += Std.string(thx.culture.FormatDate.dateTime(date,culture));
			break;
		case "C":
			buf.b += Std.string(thx.culture.FormatNumber.digits("" + Math.floor(date.getFullYear() / 100),culture));
			break;
		case "d":
			buf.b += Std.string(thx.culture.FormatNumber.digits(StringTools.lpad("" + date.getDate(),"0",2),culture));
			break;
		case "D":
			buf.b += Std.string(thx.culture.FormatDate.format("%m/%d/%y",date,culture));
			break;
		case "e":
			buf.b += Std.string(thx.culture.FormatNumber.digits(leadingspace?StringTools.lpad("" + date.getDate()," ",2):"" + date.getDate(),culture));
			break;
		case "f":
			buf.b += Std.string(thx.culture.FormatNumber.digits(leadingspace?StringTools.lpad("" + (date.getMonth() + 1)," ",2):"" + (date.getMonth() + 1),culture));
			break;
		case "G":
			throw "Not Implemented Yet";
			break;
		case "g":
			throw "Not Implemented Yet";
			break;
		case "H":
			buf.b += Std.string(thx.culture.FormatNumber.digits(StringTools.lpad("" + date.getHours(),"0",2),culture));
			break;
		case "i":
			buf.b += Std.string(thx.culture.FormatNumber.digits(leadingspace?StringTools.lpad("" + date.getMinutes()," ",2):"" + date.getMinutes(),culture));
			break;
		case "I":
			buf.b += Std.string(thx.culture.FormatNumber.digits(StringTools.lpad("" + thx.culture.FormatDate.getMHours(date),"0",2),culture));
			break;
		case "j":
			throw "Not Implemented Yet";
			break;
		case "k":
			buf.b += Std.string(thx.culture.FormatNumber.digits(leadingspace?StringTools.lpad("" + date.getHours()," ",2):"" + date.getHours(),culture));
			break;
		case "l":
			buf.b += Std.string(thx.culture.FormatNumber.digits(leadingspace?StringTools.lpad("" + thx.culture.FormatDate.getMHours(date)," ",2):"" + thx.culture.FormatDate.getMHours(date),culture));
			break;
		case "m":
			buf.b += Std.string(thx.culture.FormatNumber.digits(StringTools.lpad("" + (date.getMonth() + 1),"0",2),culture));
			break;
		case "M":
			buf.b += Std.string(thx.culture.FormatNumber.digits(StringTools.lpad("" + date.getMinutes(),"0",2),culture));
			break;
		case "n":
			buf.b += "\n";
			break;
		case "p":
			buf.b += Std.string(date.getHours() > 11?info.pm:info.am);
			break;
		case "P":
			buf.b += Std.string((date.getHours() > 11?info.pm:info.am).toLowerCase());
			break;
		case "q":
			buf.b += Std.string(thx.culture.FormatNumber.digits(leadingspace?StringTools.lpad("" + date.getSeconds()," ",2):"" + date.getSeconds(),culture));
			break;
		case "r":
			buf.b += Std.string(thx.culture.FormatDate.format("%I:%M:%S %p",date,culture));
			break;
		case "R":
			buf.b += Std.string(thx.culture.FormatDate.format("%H:%M",date,culture));
			break;
		case "s":
			buf.b += Std.string("" + (date.getTime() / 1000 | 0));
			break;
		case "S":
			buf.b += Std.string(thx.culture.FormatNumber.digits(StringTools.lpad("" + date.getSeconds(),"0",2),culture));
			break;
		case "t":
			buf.b += "\t";
			break;
		case "T":
			buf.b += Std.string(thx.culture.FormatDate.format("%H:%M:%S",date,culture));
			break;
		case "u":
			var d = date.getDay();
			buf.b += Std.string(thx.culture.FormatNumber.digits(d == 0?"7":"" + d,culture));
			break;
		case "U":
			throw "Not Implemented Yet";
			break;
		case "V":
			throw "Not Implemented Yet";
			break;
		case "w":
			buf.b += Std.string(thx.culture.FormatNumber.digits("" + date.getDay(),culture));
			break;
		case "W":
			throw "Not Implemented Yet";
			break;
		case "x":
			buf.b += Std.string(thx.culture.FormatDate.date(date,culture));
			break;
		case "X":
			buf.b += Std.string(thx.culture.FormatDate.time(date,culture));
			break;
		case "y":
			buf.b += Std.string(thx.culture.FormatNumber.digits(HxOverrides.substr("" + date.getFullYear(),-2,null),culture));
			break;
		case "Y":
			buf.b += Std.string(thx.culture.FormatNumber.digits("" + date.getFullYear(),culture));
			break;
		case "z":
			buf.b += "+0000";
			break;
		case "Z":
			buf.b += "GMT";
			break;
		case "%":
			buf.b += "%";
			break;
		default:
			buf.b += Std.string("%" + c);
		}
		pos++;
	}
	return buf.b;
}
thx.culture.FormatDate.getMHours = function(date) {
	var v = date.getHours();
	return v > 12?v - 12:v;
}
thx.culture.FormatDate.yearMonth = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternYearMonth,date,culture,false);
}
thx.culture.FormatDate.monthDay = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternMonthDay,date,culture,false);
}
thx.culture.FormatDate.date = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternDate,date,culture,false);
}
thx.culture.FormatDate.dateShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternDateShort,date,culture,false);
}
thx.culture.FormatDate.dateRfc = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternDateRfc,date,culture,false);
}
thx.culture.FormatDate.dateTime = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternDateTime,date,culture,false);
}
thx.culture.FormatDate.universal = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternUniversal,date,culture,false);
}
thx.culture.FormatDate.sortable = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternSortable,date,culture,false);
}
thx.culture.FormatDate.time = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternTime,date,culture,false);
}
thx.culture.FormatDate.timeShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(culture.date.patternTimeShort,date,culture,false);
}
thx.culture.FormatDate.hourShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	if(null == culture.date.am) return thx.culture.FormatDate.format("%H",date,culture,false); else return thx.culture.FormatDate.format("%l %p",date,culture,false);
}
thx.culture.FormatDate.year = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.digits("" + date.getFullYear(),culture);
}
thx.culture.FormatDate.month = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.digits("" + (date.getMonth() + 1),culture);
}
thx.culture.FormatDate.monthName = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.abbrMonths[date.getMonth()];
}
thx.culture.FormatDate.monthNameShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.months[date.getMonth()];
}
thx.culture.FormatDate.weekDay = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.digits("" + (date.getDay() + culture.date.firstWeekDay),culture);
}
thx.culture.FormatDate.weekDayName = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.abbrDays[date.getDay()];
}
thx.culture.FormatDate.weekDayNameShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.days[date.getDay()];
}
thx.culture.FormatNumber = function() { }
thx.culture.FormatNumber.__name__ = ["thx","culture","FormatNumber"];
thx.culture.FormatNumber.decimal = function(v,decimals,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.crunch(v,decimals,culture.percent,culture.number.patternNegative,culture.number.patternPositive,culture,null,null);
}
thx.culture.FormatNumber.percent = function(v,decimals,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.crunch(v,decimals,culture.percent,culture.percent.patternNegative,culture.percent.patternPositive,culture,"%",culture.symbolPercent);
}
thx.culture.FormatNumber.permille = function(v,decimals,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.crunch(v,decimals,culture.percent,culture.percent.patternNegative,culture.percent.patternPositive,culture,"%",culture.symbolPermille);
}
thx.culture.FormatNumber.currency = function(v,symbol,decimals,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.crunch(v,decimals,culture.currency,culture.currency.patternNegative,culture.currency.patternPositive,culture,"$",symbol == null?culture.currencySymbol:symbol);
}
thx.culture.FormatNumber["int"] = function(v,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.decimal(v,0,culture);
}
thx.culture.FormatNumber.digits = function(v,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.processDigits(v,culture.digits);
}
thx.culture.FormatNumber.crunch = function(v,decimals,info,negative,positive,culture,symbol,replace) {
	if(Math.isNaN(v)) return culture.symbolNaN; else if(!Math.isFinite(v)) return v == Math.NEGATIVE_INFINITY?culture.symbolNegInf:culture.symbolPosInf;
	var fv = thx.culture.FormatNumber.value(v,info,decimals == null?info.decimals:decimals < 0?0:decimals,culture.digits);
	if(symbol != null) return StringTools.replace(StringTools.replace(v < 0?negative:positive,"n",fv),symbol,replace); else return StringTools.replace(v < 0?negative:positive,"n",fv);
}
thx.culture.FormatNumber.processDigits = function(s,digits) {
	if(digits == null) return s;
	var o = [];
	var _g1 = 0, _g = s.length;
	while(_g1 < _g) {
		var i = _g1++;
		o.push(digits[Std.parseInt(HxOverrides.substr(s,i,1))]);
	}
	return o.join("");
}
thx.culture.FormatNumber.value = function(v,info,decimals,digits) {
	var fv = "" + Math.abs(v);
	var pos = fv.indexOf("E");
	if(pos > 0) {
		var e = Std.parseInt(HxOverrides.substr(fv,pos + 1,null));
		var ispos = true;
		if(e < 0) {
			ispos = false;
			e = -e;
		}
		var s = StringTools.replace(HxOverrides.substr(fv,0,pos),".","");
		if(ispos) fv = StringTools.rpad(s,"0",e + 1); else fv = "0" + StringTools.rpad(".","0",e) + s;
	}
	var parts = fv.split(".");
	var temp = parts[0];
	var intparts = [];
	var group = 0;
	while(true) {
		if(temp.length == 0) break;
		var len = info.groups[group];
		if(temp.length <= len) {
			intparts.unshift(thx.culture.FormatNumber.processDigits(temp,digits));
			break;
		}
		intparts.unshift(thx.culture.FormatNumber.processDigits(HxOverrides.substr(temp,-len,null),digits));
		temp = HxOverrides.substr(temp,0,-len);
		if(group < info.groups.length - 1) group++;
	}
	var intpart = intparts.join(info.groupsSeparator);
	if(decimals > 0) {
		var decpart = parts.length == 1?StringTools.lpad("","0",decimals):parts[1].length > decimals?HxOverrides.substr(parts[1],0,decimals):StringTools.rpad(parts[1],"0",decimals);
		return intpart + info.decimalsSeparator + thx.culture.FormatNumber.processDigits(decpart,digits);
	} else return intpart;
}
thx.culture.FormatParams = function() { }
thx.culture.FormatParams.__name__ = ["thx","culture","FormatParams"];
thx.culture.FormatParams.cleanQuotes = function(p) {
	if(p.length <= 1) return p;
	var f = HxOverrides.substr(p,0,1);
	if(("\"" == f || "'" == f) && HxOverrides.substr(p,-1,null) == f) return HxOverrides.substr(p,1,p.length - 2); else return p;
}
thx.culture.FormatParams.params = function(p,ps,alt) {
	if(null != ps && null != p) return [p].concat(ps);
	if((null == ps || ps.length == 0) && null == p) return [alt];
	if(null == ps || ps.length == 0) {
		var parts = p.split(":");
		return [parts[0]].concat(parts.length == 1?[]:Iterators.map(HxOverrides.iter(parts[1].split(",")),function(s,i) {
			if(0 == i) return s; else return thx.culture.FormatParams.cleanQuotes(s);
		}));
	}
	return ps;
}
thx.culture.Language = function() { }
thx.culture.Language.__name__ = ["thx","culture","Language"];
thx.culture.Language.__properties__ = {get_languages:"get_languages"}
thx.culture.Language.get_languages = function() {
	if(null == thx.culture.Language.languages) thx.culture.Language.languages = new Hash();
	return thx.culture.Language.languages;
}
thx.culture.Language.add = function(language) {
	if(!thx.culture.Language.get_languages().exists(language.iso2)) thx.culture.Language.get_languages().set(language.iso2,language);
}
thx.culture.Language.__super__ = thx.culture.Info;
thx.culture.Language.prototype = $extend(thx.culture.Info.prototype,{
	__class__: thx.culture.Language
});
thx.culture.core = {}
thx.culture.core.DateTimeInfo = function(months,abbrMonths,days,abbrDays,shortDays,am,pm,separatorDate,separatorTime,firstWeekDay,patternYearMonth,patternMonthDay,patternDate,patternDateShort,patternDateRfc,patternDateTime,patternUniversal,patternSortable,patternTime,patternTimeShort) {
	this.months = months;
	this.abbrMonths = abbrMonths;
	this.days = days;
	this.abbrDays = abbrDays;
	this.shortDays = shortDays;
	this.am = am;
	this.pm = pm;
	this.separatorDate = separatorDate;
	this.separatorTime = separatorTime;
	this.firstWeekDay = firstWeekDay;
	this.patternYearMonth = patternYearMonth;
	this.patternMonthDay = patternMonthDay;
	this.patternDate = patternDate;
	this.patternDateShort = patternDateShort;
	this.patternDateRfc = patternDateRfc;
	this.patternDateTime = patternDateTime;
	this.patternUniversal = patternUniversal;
	this.patternSortable = patternSortable;
	this.patternTime = patternTime;
	this.patternTimeShort = patternTimeShort;
};
thx.culture.core.DateTimeInfo.__name__ = ["thx","culture","core","DateTimeInfo"];
thx.culture.core.DateTimeInfo.prototype = {
	patternTimeShort: null
	,patternTime: null
	,patternSortable: null
	,patternUniversal: null
	,patternDateTime: null
	,patternDateRfc: null
	,patternDateShort: null
	,patternDate: null
	,patternMonthDay: null
	,patternYearMonth: null
	,firstWeekDay: null
	,separatorTime: null
	,separatorDate: null
	,pm: null
	,am: null
	,shortDays: null
	,abbrDays: null
	,days: null
	,abbrMonths: null
	,months: null
	,__class__: thx.culture.core.DateTimeInfo
}
thx.culture.core.NumberInfo = function(decimals,decimalsSeparator,groups,groupsSeparator,patternNegative,patternPositive) {
	this.decimals = decimals;
	this.decimalsSeparator = decimalsSeparator;
	this.groups = groups;
	this.groupsSeparator = groupsSeparator;
	this.patternNegative = patternNegative;
	this.patternPositive = patternPositive;
};
thx.culture.core.NumberInfo.__name__ = ["thx","culture","core","NumberInfo"];
thx.culture.core.NumberInfo.prototype = {
	patternPositive: null
	,patternNegative: null
	,groupsSeparator: null
	,groups: null
	,decimalsSeparator: null
	,decimals: null
	,__class__: thx.culture.core.NumberInfo
}
thx.languages = {}
thx.languages.En = function() {
	this.name = "en";
	this.english = "English";
	this["native"] = "English";
	this.iso2 = "en";
	this.iso3 = "eng";
	this.pluralRule = 1;
	thx.culture.Language.add(this);
};
thx.languages.En.__name__ = ["thx","languages","En"];
thx.languages.En.__properties__ = {get_language:"get_language"}
thx.languages.En.get_language = function() {
	if(null == thx.languages.En.language) thx.languages.En.language = new thx.languages.En();
	return thx.languages.En.language;
}
thx.languages.En.__super__ = thx.culture.Language;
thx.languages.En.prototype = $extend(thx.culture.Language.prototype,{
	__class__: thx.languages.En
});
thx.cultures = {}
thx.cultures.EnUS = function() {
	this.language = thx.languages.En.get_language();
	this.name = "en-US";
	this.english = "English (United States)";
	this["native"] = "English (United States)";
	this.date = new thx.culture.core.DateTimeInfo(["January","February","March","April","May","June","July","August","September","October","November","December",""],["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",""],["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],["Su","Mo","Tu","We","Th","Fr","Sa"],"AM","PM","/",":",0,"%B, %Y","%B %d","%A, %B %d, %Y","%f/%e/%Y","%a, %d %b %Y %H:%M:%S GMT","%A, %B %d, %Y %l:%M:%S %p","%Y-%m-%d %H:%M:%SZ","%Y-%m-%dT%H:%M:%S","%l:%M:%S %p","%l:%M %p");
	this.symbolNaN = "NaN";
	this.symbolPercent = "%";
	this.symbolPermille = "‰";
	this.signNeg = "-";
	this.signPos = "+";
	this.symbolNegInf = "-Infinity";
	this.symbolPosInf = "Infinity";
	this.number = new thx.culture.core.NumberInfo(2,".",[3],",","-n","n");
	this.currency = new thx.culture.core.NumberInfo(2,".",[3],",","($n)","$n");
	this.percent = new thx.culture.core.NumberInfo(2,".",[3],",","-n %","n %");
	this.pluralRule = 1;
	this.englishCurrency = "US Dollar";
	this.nativeCurrency = "US Dollar";
	this.currencySymbol = "$";
	this.currencyIso = "USD";
	this.englishRegion = "United States";
	this.nativeRegion = "United States";
	this.iso2 = "US";
	this.iso3 = "USA";
	this.isMetric = false;
	thx.culture.Culture.add(this);
};
thx.cultures.EnUS.__name__ = ["thx","cultures","EnUS"];
thx.cultures.EnUS.__properties__ = {get_culture:"get_culture"}
thx.cultures.EnUS.get_culture = function() {
	if(null == thx.cultures.EnUS.culture) thx.cultures.EnUS.culture = new thx.cultures.EnUS();
	return thx.cultures.EnUS.culture;
}
thx.cultures.EnUS.__super__ = thx.culture.Culture;
thx.cultures.EnUS.prototype = $extend(thx.culture.Culture.prototype,{
	__class__: thx.cultures.EnUS
});
thx.data.ValueEncoder = function(handler) {
	this.handler = handler;
};
thx.data.ValueEncoder.__name__ = ["thx","data","ValueEncoder"];
thx.data.ValueEncoder.prototype = {
	encodeArray: function(a) {
		this.handler.arrayStart();
		var _g = 0;
		while(_g < a.length) {
			var item = a[_g];
			++_g;
			this.handler.arrayItemStart();
			this.encodeValue(item);
			this.handler.arrayItemEnd();
		}
		this.handler.arrayEnd();
	}
	,encodeList: function(list) {
		this.handler.arrayStart();
		var $it0 = list.iterator();
		while( $it0.hasNext() ) {
			var item = $it0.next();
			this.handler.arrayItemStart();
			this.encodeValue(item);
			this.handler.arrayItemEnd();
		}
		this.handler.arrayEnd();
	}
	,encodeHash: function(o) {
		this.handler.objectStart();
		var $it0 = o.keys();
		while( $it0.hasNext() ) {
			var key = $it0.next();
			this.handler.objectFieldStart(key);
			this.encodeValue(o.get(key));
			this.handler.objectFieldEnd();
		}
		this.handler.objectEnd();
	}
	,encodeObject: function(o) {
		this.handler.objectStart();
		var _g = 0, _g1 = Reflect.fields(o);
		while(_g < _g1.length) {
			var key = _g1[_g];
			++_g;
			this.handler.objectFieldStart(key);
			this.encodeValue(Reflect.field(o,key));
			this.handler.objectFieldEnd();
		}
		this.handler.objectEnd();
	}
	,encodeValue: function(o) {
		var _g = Type["typeof"](o);
		var $e = (_g);
		switch( $e[1] ) {
		case 0:
			this.handler.valueNull();
			break;
		case 1:
			this.handler.valueInt(o);
			break;
		case 2:
			this.handler.valueFloat(o);
			break;
		case 3:
			this.handler.valueBool(o);
			break;
		case 4:
			this.encodeObject(o);
			break;
		case 5:
			throw new thx.error.Error("unable to encode TFunction type",null,null,{ fileName : "ValueEncoder.hx", lineNumber : 39, className : "thx.data.ValueEncoder", methodName : "encodeValue"});
			break;
		case 6:
			var _g_eTClass_0 = $e[2];
			if(js.Boot.__instanceof(o,String)) this.handler.valueString(o); else if(js.Boot.__instanceof(o,Array)) this.encodeArray(o); else if(js.Boot.__instanceof(o,Date)) this.handler.valueDate(o); else if(js.Boot.__instanceof(o,Hash)) this.encodeHash(o); else if(js.Boot.__instanceof(o,List)) this.encodeList(o); else throw new thx.error.Error("unable to encode class '{0}'",null,Type.getClassName(_g_eTClass_0),{ fileName : "ValueEncoder.hx", lineNumber : 53, className : "thx.data.ValueEncoder", methodName : "encodeValue"});
			break;
		case 7:
			var _g_eTEnum_0 = $e[2];
			throw new thx.error.Error("unable to encode TEnum type '{0}'",null,Type.getEnumName(_g_eTEnum_0),{ fileName : "ValueEncoder.hx", lineNumber : 55, className : "thx.data.ValueEncoder", methodName : "encodeValue"});
			break;
		case 8:
			throw new thx.error.Error("unable to encode TUnknown type",null,null,{ fileName : "ValueEncoder.hx", lineNumber : 57, className : "thx.data.ValueEncoder", methodName : "encodeValue"});
			break;
		}
	}
	,encode: function(o) {
		this.handler.start();
		this.encodeValue(o);
		this.handler.end();
	}
	,handler: null
	,__class__: thx.data.ValueEncoder
}
thx.data.ValueHandler = function() {
};
thx.data.ValueHandler.__name__ = ["thx","data","ValueHandler"];
thx.data.ValueHandler.__interfaces__ = [thx.data.IDataHandler];
thx.data.ValueHandler.prototype = {
	valueBool: function(b) {
		this._stack.push(b);
	}
	,valueNull: function() {
		this._stack.push(null);
	}
	,valueFloat: function(f) {
		this._stack.push(f);
	}
	,valueInt: function(i) {
		this._stack.push(i);
	}
	,valueString: function(s) {
		this._stack.push(s);
	}
	,valueDate: function(d) {
		this._stack.push(d);
	}
	,arrayItemEnd: function() {
		var value = this._stack.pop();
		var last = Arrays.last(this._stack);
		last.push(value);
	}
	,arrayItemStart: function() {
	}
	,arrayEnd: function() {
	}
	,arrayStart: function() {
		this._stack.push([]);
	}
	,objectFieldEnd: function() {
		var value = this._stack.pop();
		var last = Arrays.last(this._stack);
		last[this._names.pop()] = value;
	}
	,objectFieldStart: function(name) {
		this._names.push(name);
	}
	,objectEnd: function() {
	}
	,objectStart: function() {
		this._stack.push({ });
	}
	,end: function() {
		this.value = this._stack.pop();
	}
	,start: function() {
		this._stack = [];
		this._names = [];
	}
	,_names: null
	,_stack: null
	,value: null
	,__class__: thx.data.ValueHandler
}
thx.date = {}
thx.date.DateParser = function() { }
thx.date.DateParser.__name__ = ["thx","date","DateParser"];
thx.date.DateParser.parse = function(s,d) {
	var time = thx.date.DateParser.parseTime(s), v;
	if(null == d) d = new Date();
	if(null != time.matched) s = StringTools.replace(s,time.matched,"");
	var year = 0, month = 0, day = 0, found = null != time.matched;
	if(thx.date.DateParser.dateexp.match(s)) {
		found = true;
		s = StringTools.replace(s,thx.date.DateParser.dateexp.matched(0),"");
		if(null != (v = thx.date.DateParser.dateexp.matched(1))) {
			day = Std.parseInt(thx.date.DateParser.dateexp.matched(2));
			month = thx.date.DateParser.months.indexOf(v.toLowerCase());
			year = null != (v = thx.date.DateParser.dateexp.matched(3))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(4))) {
			day = Std.parseInt(thx.date.DateParser.dateexp.matched(5));
			month = thx.date.DateParser.shortmonths.indexOf(v.toLowerCase());
			year = null != (v = thx.date.DateParser.dateexp.matched(6))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(8))) {
			month = thx.date.DateParser.months.indexOf(v.toLowerCase());
			day = null != (v = thx.date.DateParser.dateexp.matched(7))?Std.parseInt(v):1;
			year = null != (v = thx.date.DateParser.dateexp.matched(9))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(11))) {
			month = thx.date.DateParser.shortmonths.indexOf(v.toLowerCase());
			day = null != (v = thx.date.DateParser.dateexp.matched(10))?Std.parseInt(v):1;
			year = null != (v = thx.date.DateParser.dateexp.matched(12))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(14))) {
			month = thx.date.DateParser.months.indexOf(v.toLowerCase());
			day = null != (v = thx.date.DateParser.dateexp.matched(13))?Std.parseInt(v):1;
			year = null != (v = thx.date.DateParser.dateexp.matched(15))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(17))) {
			month = thx.date.DateParser.shortmonths.indexOf(v.toLowerCase());
			day = null != (v = thx.date.DateParser.dateexp.matched(16))?Std.parseInt(v):1;
			year = null != (v = thx.date.DateParser.dateexp.matched(18))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(19))) {
			day = Std.parseInt(thx.date.DateParser.dateexp.matched(20));
			month = Std.parseInt(v) - 1;
			year = null != (v = thx.date.DateParser.dateexp.matched(21))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(23))) {
			day = Std.parseInt(thx.date.DateParser.dateexp.matched(22));
			month = Std.parseInt(v) - 1;
			year = null != (v = thx.date.DateParser.dateexp.matched(24))?thx.date.DateParser.fixyear(Std.parseInt(v)):d.getFullYear();
		} else if(null != (v = thx.date.DateParser.dateexp.matched(25))) {
			year = thx.date.DateParser.fixyear(Std.parseInt(v));
			day = Std.parseInt(thx.date.DateParser.dateexp.matched(27));
			month = Std.parseInt(thx.date.DateParser.dateexp.matched(26)) - 1;
		} else if(null != (v = thx.date.DateParser.dateexp.matched(28))) {
			year = d.getFullYear();
			day = Std.parseInt(v);
			month = d.getMonth();
		}
	} else if(thx.date.DateParser.absdateexp.match(s)) {
		found = true;
		s = StringTools.replace(s,thx.date.DateParser.absdateexp.matched(0),"");
		year = d.getFullYear();
		month = d.getMonth();
		day = d.getDate();
		if(null != (v = thx.date.DateParser.absdateexp.matched(1))) {
			var _g = v.toLowerCase();
			switch(_g) {
			case "now":case "this second":
				if(null == time.matched) {
					time.hour = d.getHours();
					time.minute = d.getMinutes();
					time.second = d.getSeconds();
				}
				break;
			case "tomorrow":
				day += 1;
				break;
			case "yesterday":
				day -= 1;
				break;
			}
		} else if(null != (v = thx.date.DateParser.absdateexp.matched(3))) {
			var t = thx.date.DateParser.absdateexp.matched(2), v1 = thx.date.DateParser.months.indexOf(v.toLowerCase());
			if(v1 == month) year += thx.date.DateParser.last(t)?-1:thx.date.DateParser.next(t)?1:0; else if(v1 > month) year += thx.date.DateParser.last(t)?-1:0; else year += thx.date.DateParser.next(t)?1:0;
			month = v1;
			day = 1;
		} else if(null != (v = thx.date.DateParser.absdateexp.matched(5))) {
			var t = thx.date.DateParser.absdateexp.matched(4), v1 = thx.date.DateParser.days.indexOf(v.toLowerCase());
			var wd = d.getDay();
			if(v1 == wd) day += thx.date.DateParser.last(t)?-7:thx.date.DateParser.next(t)?7:0; else if(v1 > wd) day += v1 - wd + (thx.date.DateParser.last(t)?-7:0); else day += v1 - wd + (thx.date.DateParser.next(t)?7:0);
		} else if(null != (v = thx.date.DateParser.absdateexp.matched(7))) {
			var t = thx.date.DateParser.absdateexp.matched(6), v1 = thx.date.DateParser.shortmonths.indexOf(v.toLowerCase());
			if(v1 == month) year += thx.date.DateParser.last(t)?-1:thx.date.DateParser.next(t)?1:0; else if(v1 > month) year += thx.date.DateParser.last(t)?-1:0; else year += thx.date.DateParser.next(t)?1:0;
			month = v1;
			day = 1;
		} else if(null != (v = thx.date.DateParser.absdateexp.matched(9))) {
			var t = thx.date.DateParser.absdateexp.matched(8), v1 = thx.date.DateParser.shortdays.indexOf(v.toLowerCase());
			var wd = d.getDay();
			if(v1 == wd) day += thx.date.DateParser.last(t)?-7:thx.date.DateParser.next(t)?7:0; else if(v1 > wd) day += v1 - wd + (thx.date.DateParser.last(t)?-7:0); else day += v1 - wd + (thx.date.DateParser.next(t)?7:0);
		}
		if(null == time.matched) time.matched = "x";
	} else {
		year = d.getFullYear();
		month = d.getMonth();
		day = d.getDate();
	}
	while(thx.date.DateParser.relexp.match(s)) {
		found = true;
		s = StringTools.replace(s,thx.date.DateParser.relexp.matched(0),"");
		var dir = thx.date.DateParser.relexp.matched(1), qt, period;
		if(null != dir) {
			qt = null != (v = thx.date.DateParser.relexp.matched(2))?Std.parseInt(v):1;
			period = thx.date.DateParser.relexp.matched(3);
		} else {
			period = thx.date.DateParser.relexp.matched(5);
			if(null == period) break;
			qt = null != (v = thx.date.DateParser.relexp.matched(4))?Std.parseInt(v):1;
			dir = null != (v = thx.date.DateParser.relexp.matched(6))?v:"after";
		}
		dir = dir.toLowerCase();
		switch(dir) {
		case "plus":case "+":case "from":case "hence":case "after":
			break;
		case "minus":case "-":case "before":case "ago":
			qt = -qt;
			break;
		}
		switch(dir) {
		case "ago":case "in":
			if(null == time.matched) {
				time.hour = d.getHours();
				time.minute = d.getMinutes();
				time.second = d.getSeconds();
				time.matched = "x";
			}
			break;
		}
		var _g = period.toLowerCase();
		switch(_g) {
		case "second":case "seconds":
			time.second += qt;
			break;
		case "minute":case "minutes":
			time.minute += qt;
			break;
		case "hour":case "hours":
			time.hour += qt;
			break;
		case "day":case "days":
			day += qt;
			break;
		case "week":case "weeks":
			day += qt * 7;
			break;
		case "month":case "months":
			month += qt;
			break;
		case "year":case "years":
			year += qt;
			break;
		}
	}
	if(!found) throw new thx.error.Error("no date information found in the string '{0}'",null,s,{ fileName : "DateParser.hx", lineNumber : 339, className : "thx.date.DateParser", methodName : "parse"});
	return (function($this) {
		var $r;
		var d1 = new Date();
		d1.setTime(new Date(year,month,day,time.hour,time.minute,time.second).getTime() + time.millis);
		$r = d1;
		return $r;
	}(this));
}
thx.date.DateParser.parseTime = function(s) {
	var result = { hour : 0, minute : 0, second : 0, millis : 0.0, matched : null};
	if(!thx.date.DateParser.timeexp.match(s)) return result;
	result.matched = thx.date.DateParser.timeexp.matched(0);
	var v;
	if(null != (v = thx.date.DateParser.timeexp.matched(1))) {
		result.hour = Std.parseInt(v) + thx.date.DateParser.plusPm(thx.date.DateParser.timeexp.matched(3));
		result.minute = Std.parseInt(thx.date.DateParser.timeexp.matched(2));
	} else if(null != (v = thx.date.DateParser.timeexp.matched(4))) {
		result.hour = Std.parseInt(v);
		result.minute = Std.parseInt(thx.date.DateParser.timeexp.matched(5));
		if(null != (v = thx.date.DateParser.timeexp.matched(6))) result.second = Std.parseInt(v);
		if(null != (v = thx.date.DateParser.timeexp.matched(7))) result.millis = Std.parseFloat(v) / 1000;
	} else if(null != (v = thx.date.DateParser.timeexp.matched(8))) {
		result.hour = Std.parseInt(v) + thx.date.DateParser.plusPm(thx.date.DateParser.timeexp.matched(10));
		result.minute = Std.parseInt(thx.date.DateParser.timeexp.matched(9));
	} else if(null != (v = thx.date.DateParser.timeexp.matched(11))) result.hour = Std.parseInt(v) + thx.date.DateParser.plusPm(thx.date.DateParser.timeexp.matched(12)); else if(null != (v = thx.date.DateParser.timeexp.matched(13))) {
		var _g = v.toLowerCase();
		switch(_g) {
		case "evening":
			result.hour = 17;
			break;
		case "morning":
			result.hour = 8;
			break;
		case "afternoon":
			result.hour = 14;
			break;
		case "sunsrise":case "dawn":
			result.hour = 6;
			break;
		case "sunset":case "dusk":
			result.hour = 19;
			break;
		case "noon":case "midday":case "mid-day":
			result.hour = 12;
			break;
		case "mid-night":case "midnight":
			result.hour = 23;
			result.minute = 59;
			result.second = 59;
			result.millis = 0.999;
			break;
		}
	} else throw new thx.error.Error("failed to parse time for '{0}'",null,s,{ fileName : "DateParser.hx", lineNumber : 406, className : "thx.date.DateParser", methodName : "parseTime"});
	return result;
}
thx.date.DateParser.fixyear = function(y) {
	if(y < 70) return 2000 + y; else if(y < 100) return 1900 + y; else return y;
}
thx.date.DateParser.last = function(s) {
	if(null == s) return false; else return "last" == s.toLowerCase();
}
thx.date.DateParser.next = function(s) {
	if(null == s) return true; else return "next" == s.toLowerCase();
}
thx.date.DateParser.plusPm = function(s) {
	if(null == s) return 0; else return (function($this) {
		var $r;
		var _g = s.toLowerCase();
		$r = (function($this) {
			var $r;
			switch(_g) {
			case "pm":case "evening":case "afternoon":
				$r = 12;
				break;
			default:
				$r = 0;
			}
			return $r;
		}($this));
		return $r;
	}(this));
}
thx.util = {}
thx.util.Message = function(message,params,param) {
	this.message = message;
	if(null == params) this.params = []; else this.params = params;
	if(null != param) this.params.push(param);
};
thx.util.Message.__name__ = ["thx","util","Message"];
thx.util.Message.prototype = {
	params: null
	,message: null
	,__class__: thx.util.Message
}
thx.error = {}
thx.error.Error = function(message,params,param,pos) {
	thx.util.Message.call(this,message,params,param);
	this.pos = pos;
};
thx.error.Error.__name__ = ["thx","error","Error"];
thx.error.Error.__super__ = thx.util.Message;
thx.error.Error.prototype = $extend(thx.util.Message.prototype,{
	pos: null
	,__class__: thx.error.Error
});
thx.json = {}
thx.json.Json = function() { }
thx.json.Json.__name__ = ["thx","json","Json"];
thx.json.Json.encode = function(value) {
	if(null != thx.json.Json.nativeEncoder) return thx.json.Json.nativeEncoder(value);
	var handler = new thx.json.JsonEncoder();
	new thx.data.ValueEncoder(handler).encode(value);
	return handler.encodedString;
}
thx.json.Json.decode = function(value) {
	if(null != thx.json.Json.nativeDecoder) return thx.json.Json.nativeDecoder(value);
	var handler = new thx.data.ValueHandler();
	new thx.json.JsonDecoder(handler).decode(value);
	return handler.value;
}
thx.json.JsonDecoder = function(handler,tabsize) {
	if(tabsize == null) tabsize = 4;
	this.handler = handler;
	this.tabsize = tabsize;
};
thx.json.JsonDecoder.__name__ = ["thx","json","JsonDecoder"];
thx.json.JsonDecoder.prototype = {
	error: function(msg) {
		var context = this.pos == this.src.length?"":"\nrest: " + (null != this["char"]?this["char"]:"") + HxOverrides.substr(this.src,this.pos,null) + "...";
		throw new thx.error.Error("error at L {0} C {1}: {2}{3}",[this.line,this.col,msg,context],null,{ fileName : "JsonDecoder.hx", lineNumber : 357, className : "thx.json.JsonDecoder", methodName : "error"});
	}
	,parseDigits: function(atleast) {
		if(atleast == null) atleast = 0;
		var buf = "";
		while(true) {
			var c = null;
			try {
				c = this.readChar();
			} catch( e ) {
				if( js.Boot.__instanceof(e,thx.json._JsonDecoder.StreamError) ) {
					if(buf.length < atleast) this.error("expected digit");
					return buf;
				} else throw(e);
			}
			var i = HxOverrides.cca(c,0);
			if(i < 48 || i > 57) {
				if(buf.length < atleast) this.error("expected digit");
				this.col += buf.length;
				this["char"] = c;
				return buf;
			} else buf += c;
		}
		return null;
	}
	,parseFloat: function() {
		var v = "";
		if(this.expect("-")) v = "-";
		if(this.expect("0")) v += "0"; else {
			var c = this.readChar();
			var i = HxOverrides.cca(c,0);
			if(i < 49 || i > 57) this.error("expected digit between 1 and 9");
			v += c;
			this.col++;
		}
		try {
			v += this.parseDigits();
		} catch( e ) {
			if( js.Boot.__instanceof(e,thx.json._JsonDecoder.StreamError) ) {
				this.handler.valueInt(Std.parseInt(v));
				return;
			} else throw(e);
		}
		try {
			if(this.expect(".")) v += "." + this.parseDigits(1); else {
				this.handler.valueInt(Std.parseInt(v));
				return;
			}
			if(this.expect("e") || this.expect("E")) {
				v += "e";
				if(this.expect("+")) {
				} else if(this.expect("-")) v += "-";
				v += this.parseDigits(1);
			}
		} catch( e ) {
			if( js.Boot.__instanceof(e,thx.json._JsonDecoder.StreamError) ) {
				this.handler.valueFloat(Std.parseFloat(v));
				return;
			} else throw(e);
		}
		this.handler.valueFloat(Std.parseFloat(v));
	}
	,parseHexa: function() {
		var v = [];
		var _g = 0;
		while(_g < 4) {
			var i = _g++;
			var c = this.readChar();
			var i1 = HxOverrides.cca(c.toLowerCase(),0);
			if(!(i1 >= 48 && i1 <= 57 || i1 >= 97 && i1 <= 102)) this.error("invalid hexadecimal value " + c);
			v.push(c);
		}
		this.handler.valueInt(Std.parseInt("0x" + v.join("")));
		return Std.parseInt("0x" + v.join(""));
	}
	,_parseString: function() {
		if(!this.expect("\"")) this.error("expected double quote");
		var buf = "";
		var esc = false;
		try {
			while(true) {
				var c = this.readChar();
				this.col++;
				if(esc) {
					switch(c) {
					case "\"":
						buf += "\"";
						break;
					case "\\":
						buf += "\\";
						break;
					case "/":
						buf += "/";
						break;
					case "b":
						buf += "";
						break;
					case "f":
						buf += "";
						break;
					case "n":
						buf += "\n";
						break;
					case "r":
						buf += "\r";
						break;
					case "t":
						buf += "\t";
						break;
					case "u":
						buf += String.fromCharCode(this.parseHexa());
						break;
					default:
						this.error("unexpected char " + c);
					}
					esc = false;
				} else switch(c) {
				case "\\":
					esc = true;
					break;
				case "\"":
					throw "__break__";
					break;
				default:
					buf += c;
				}
			}
		} catch( e ) { if( e != "__break__" ) throw e; }
		return buf;
	}
	,parseString: function() {
		this.handler.valueString(this._parseString());
	}
	,parseValue: function() {
		if(this.expect("true")) this.handler.valueBool(true); else if(this.expect("false")) this.handler.valueBool(false); else if(this.expect("null")) this.handler.valueNull(); else this.parseFloat();
	}
	,parseArray: function() {
		this.ignoreWhiteSpace();
		var first = true;
		this.handler.arrayStart();
		while(true) {
			this.ignoreWhiteSpace();
			if(this.expect("]")) break; else if(first) first = false; else if(this.expect(",")) this.ignoreWhiteSpace(); else this.error("expected ','");
			this.handler.arrayItemStart();
			this.parse();
			this.handler.arrayItemEnd();
		}
		this.handler.arrayEnd();
	}
	,parseObject: function() {
		var first = true;
		this.handler.objectStart();
		while(true) {
			this.ignoreWhiteSpace();
			if(this.expect("}")) break; else if(first) first = false; else if(this.expect(",")) this.ignoreWhiteSpace(); else this.error("expected ','");
			var k = this._parseString();
			this.ignoreWhiteSpace();
			if(!this.expect(":")) this.error("expected ':'");
			this.ignoreWhiteSpace();
			this.handler.objectFieldStart(k);
			this.parse();
			this.handler.objectFieldEnd();
		}
		this.handler.objectEnd();
	}
	,expect: function(word) {
		var test = null == this["char"]?HxOverrides.substr(this.src,this.pos,word.length):this["char"] + HxOverrides.substr(this.src,this.pos,word.length - 1);
		if(test == word) {
			if(null == this["char"]) this.pos += word.length; else {
				this.pos += word.length - 1;
				this["char"] = null;
			}
			return true;
		} else return false;
	}
	,readChar: function() {
		if(null == this["char"]) {
			if(this.pos == this.src.length) throw thx.json._JsonDecoder.StreamError.Eof;
			return this.src.charAt(this.pos++);
		} else {
			var c = this["char"];
			this["char"] = null;
			return c;
		}
	}
	,parse: function() {
		var c = this.readChar();
		switch(c) {
		case "{":
			this.col++;
			this.ignoreWhiteSpace();
			this.parseObject();
			break;
		case "[":
			this.col++;
			this.ignoreWhiteSpace();
			this.parseArray();
			break;
		case "\"":
			this["char"] = c;
			this.parseString();
			break;
		default:
			this["char"] = c;
			this.parseValue();
		}
	}
	,ignoreWhiteSpace: function() {
		while(this.pos < this.src.length) {
			var c = this.readChar();
			switch(c) {
			case " ":
				this.col++;
				break;
			case "\n":
				this.col = 0;
				this.line++;
				break;
			case "\r":
				break;
			case "\t":
				this.col += this.tabsize;
				break;
			default:
				this["char"] = c;
				return;
			}
		}
	}
	,decode: function(s) {
		this.col = 0;
		this.line = 0;
		this.src = s;
		this["char"] = null;
		this.pos = 0;
		this.ignoreWhiteSpace();
		this.handler.start();
		try {
			this.parse();
		} catch( e ) {
			if( js.Boot.__instanceof(e,thx.json._JsonDecoder.StreamError) ) {
				this.error("unexpected end of stream");
			} else throw(e);
		}
		this.ignoreWhiteSpace();
		if(this.pos < this.src.length) this.error("the stream contains unrecognized characters at its end");
		this.handler.end();
	}
	,handler: null
	,pos: null
	,'char': null
	,src: null
	,tabsize: null
	,line: null
	,col: null
	,__class__: thx.json.JsonDecoder
}
thx.json._JsonDecoder = {}
thx.json._JsonDecoder.StreamError = { __ename__ : ["thx","json","_JsonDecoder","StreamError"], __constructs__ : ["Eof"] }
thx.json._JsonDecoder.StreamError.Eof = ["Eof",0];
thx.json._JsonDecoder.StreamError.Eof.toString = $estr;
thx.json._JsonDecoder.StreamError.Eof.__enum__ = thx.json._JsonDecoder.StreamError;
thx.json.JsonEncoder = function() {
};
thx.json.JsonEncoder.__name__ = ["thx","json","JsonEncoder"];
thx.json.JsonEncoder.__interfaces__ = [thx.data.IDataHandler];
thx.json.JsonEncoder.prototype = {
	quote: function(s) {
		return "\"" + new EReg(".","").customReplace(new EReg("(\n)","g").replace(new EReg("(\"|\\\\)","g").replace(s,"\\$1"),"\\n"),function(r) {
			var c = HxOverrides.cca(r.matched(0),0);
			return c >= 32 && c <= 127?String.fromCharCode(c):"\\u" + StringTools.hex(c,4);
		}) + "\"";
	}
	,valueBool: function(b) {
		this.buf.b += Std.string(b?"true":"false");
	}
	,valueNull: function() {
		this.buf.b += "null";
	}
	,valueFloat: function(f) {
		this.buf.b += Std.string(f);
	}
	,valueInt: function(i) {
		this.buf.b += Std.string(i);
	}
	,valueString: function(s) {
		this.buf.b += Std.string(this.quote(s));
	}
	,valueDate: function(d) {
		this.buf.b += Std.string(d.getTime());
	}
	,arrayEnd: function() {
		this.buf.b += "]";
		this.count.pop();
	}
	,arrayItemEnd: function() {
	}
	,arrayItemStart: function() {
		if(this.count[this.count.length - 1]++ > 0) this.buf.b += ",";
	}
	,arrayStart: function() {
		this.buf.b += "[";
		this.count.push(0);
	}
	,objectEnd: function() {
		this.buf.b += "}";
		this.count.pop();
	}
	,objectFieldEnd: function() {
	}
	,objectFieldStart: function(name) {
		if(this.count[this.count.length - 1]++ > 0) this.buf.b += ",";
		this.buf.b += Std.string(this.quote(name) + ":");
	}
	,objectStart: function() {
		this.buf.b += "{";
		this.count.push(0);
	}
	,end: function() {
		this.encodedString = this.buf.b;
		this.buf = null;
	}
	,start: function() {
		this.lvl = 0;
		this.buf = new StringBuf();
		this.encodedString = null;
		this.count = [];
	}
	,count: null
	,lvl: null
	,buf: null
	,encodedString: null
	,__class__: thx.json.JsonEncoder
}
thx.math = {}
thx.math.Random = function(seed) {
	if(seed == null) seed = 1;
	this.seed = seed;
};
thx.math.Random.__name__ = ["thx","math","Random"];
thx.math.Random.prototype = {
	seed: null
	,__class__: thx.math.Random
}
thx.number = {}
thx.number.NumberParser = function() { }
thx.number.NumberParser.__name__ = ["thx","number","NumberParser"];
thx.number.NumberParser.parse = function(val,cul) {
	if(cul == null) cul = thx.culture.Culture.get_defaultCulture();
	var reg = thx.number.NumberParser.cultureNumberEReg(cul);
	var fval = val;
	var nval = Math.NaN;
	var ni = cul.number;
	var gsep = thx.text.ERegs.escapeERegChars(ni.groupsSeparator);
	var dsep = thx.text.ERegs.escapeERegChars(ni.decimalsSeparator);
	if(thx.number.NumberParser.canParse(val,cul)) {
		fval = new EReg(gsep,"gi").replace(fval,"");
		fval = new EReg(dsep,"gi").replace(fval,".");
		nval = Std.parseFloat(fval);
		if(new EReg(thx.text.ERegs.escapeERegChars(cul.signNeg),"").match(val)) {
			if(nval > 0) nval *= -1;
		}
	}
	return nval;
}
thx.number.NumberParser.cultureNumberEReg = function(cul) {
	var ni = cul.number;
	var groups = ni.groups.slice();
	var digits = "";
	var gsep = thx.text.ERegs.escapeERegChars(ni.groupsSeparator);
	var dsep = thx.text.ERegs.escapeERegChars(ni.decimalsSeparator);
	if(cul.digits != null) throw "unsupported digit characters"; else digits = "[0-9]";
	var regex = new StringBuf();
	regex.b += "(";
	var group_length = 0;
	if(groups.length > 2) throw "too many groups!";
	if(groups.length == 2) {
		if(groups[1] == 0) regex.b += Std.string("(" + digits + "*" + gsep + ")"); else {
			regex.b += Std.string("((" + digits + "{1," + groups[1] + "}" + gsep + ")");
			regex.b += Std.string("(" + digits + "{" + groups[1] + "}" + gsep + ")*" + digits + "{" + groups[0] + "})|");
		}
		if(groups[0] == 0) regex.b += Std.string("(" + digits + "*" + gsep + ")"); else regex.b += Std.string("(" + digits + "+)");
	}
	if(groups.length == 1) {
		group_length = groups[0];
		regex.b += Std.string("((" + digits + "{1," + groups[0] + "})");
		regex.b += Std.string("(" + gsep + digits + "{" + groups[0] + "}" + ")+)|");
		regex.b += Std.string("(" + digits + "+)");
	}
	regex.b += ")";
	var last_group = 0;
	regex.b += Std.string("(" + dsep + digits + "*)?");
	regex.b += "([eE][+\\-]?\\d+)?";
	var reg_string = regex.b;
	var negative = false;
	if(ni.patternNegative != "-n") {
		var neg_match = new EReg("([^n]+)","g").replace(thx.text.ERegs.escapeERegChars(ni.patternNegative),"($1)?");
		reg_string = new EReg("n","").replace(neg_match,reg_string);
	} else reg_string = "[+-]?" + reg_string;
	reg_string = "^" + reg_string + "$";
	var reg = new EReg(reg_string,"gi");
	return reg;
}
thx.number.NumberParser.canParse = function(val,cul) {
	if(cul == null) cul = thx.culture.Culture.get_defaultCulture();
	var reg = thx.number.NumberParser.cultureNumberEReg(cul);
	if(reg.match(val)) return true; else return false;
}
thx.text = {}
thx.text.ERegs = function() { }
thx.text.ERegs.__name__ = ["thx","text","ERegs"];
thx.text.ERegs.escapeERegChars = function(s) {
	return thx.text.ERegs._escapePattern.customReplace(s,function(e) {
		return "\\" + e.matched(0);
	});
}
function $iterator(o) { if( o instanceof Array ) return function() { return HxOverrides.iter(o); }; return typeof(o.iterator) == 'function' ? $bind(o,o.iterator) : o.iterator; };
var $_;
function $bind(o,m) { var f = function(){ return f.method.apply(f.scope, arguments); }; f.scope = o; f.method = m; return f; };
if (!('indexOf' in Array.prototype)) {
    Array.prototype.indexOf= function(find, i /*opt*/) {
        if (i===undefined) i= 0;
        if (i<0) i+= this.length;
        if (i<0) i= 0;
        for (var n= this.length; i<n; i++)
            if (i in this && this[i]===find)
                return i;
        return -1;
    };
}
if (!('lastIndexOf' in Array.prototype)) {
    Array.prototype.lastIndexOf= function(find, i /*opt*/) {
        if (i===undefined) i= this.length-1;
        if (i<0) i+= this.length;
        if (i>this.length-1) i= this.length-1;
        for (i++; i-->0;) /* i++ because from-argument is sadly inclusive */
            if (i in this && this[i]===find)
                return i;
        return -1;
    };
}
if (!('forEach' in Array.prototype)) {
    Array.prototype.forEach= function(action, that /*opt*/) {
        for (var i= 0, n= this.length; i<n; i++)
            if (i in this)
                action.call(that, this[i], i, this);
    };
}
if (!('map' in Array.prototype)) {
    Array.prototype.map= function(mapper, that /*opt*/) {
        var other= new Array(this.length);
        for (var i= 0, n= this.length; i<n; i++)
            if (i in this)
                other[i]= mapper.call(that, this[i], i, this);
        return other;
    };
}
if (!('filter' in Array.prototype)) {
    Array.prototype.filter= function(filter, that /*opt*/) {
        var other= [], v;
        for (var i=0, n= this.length; i<n; i++)
            if (i in this && filter.call(that, v= this[i], i, this))
                other.push(v);
        return other;
    };
}
if (!('every' in Array.prototype)) {
    Array.prototype.every= function(tester, that /*opt*/) {
        for (var i= 0, n= this.length; i<n; i++)
            if (i in this && !tester.call(that, this[i], i, this))
                return false;
        return true;
    };
}
if(Array.prototype.indexOf) HxOverrides.remove = function(a,o) {
	var i = a.indexOf(o);
	if(i == -1) return false;
	a.splice(i,1);
	return true;
}; else null;
Math.__name__ = ["Math"];
Math.NaN = Number.NaN;
Math.NEGATIVE_INFINITY = Number.NEGATIVE_INFINITY;
Math.POSITIVE_INFINITY = Number.POSITIVE_INFINITY;
Math.isFinite = function(i) {
	return isFinite(i);
};
Math.isNaN = function(i) {
	return isNaN(i);
};
String.prototype.__class__ = String;
String.__name__ = ["String"];
Array.prototype.__class__ = Array;
Array.__name__ = ["Array"];
Date.prototype.__class__ = Date;
Date.__name__ = ["Date"];
var Int = { __name__ : ["Int"]};
var Dynamic = { __name__ : ["Dynamic"]};
var Float = Number;
Float.__name__ = ["Float"];
var Bool = Boolean;
Bool.__ename__ = ["Bool"];
var Class = { __name__ : ["Class"]};
var Enum = { };
if(Array.prototype.map == null) Array.prototype.map = function(f) {
	var a = [];
	var _g1 = 0, _g = this.length;
	while(_g1 < _g) {
		var i = _g1++;
		a[i] = f(this[i]);
	}
	return a;
}; else null;
if(Array.prototype.filter == null) Array.prototype.filter = function(f) {
	var a = [];
	var _g1 = 0, _g = this.length;
	while(_g1 < _g) {
		var i = _g1++;
		var e = this[i];
		if(f(e)) a.push(e);
	}
	return a;
}; else null;
var r = window.ReportGrid?window.ReportGrid:window.ReportGrid = { };
r.$ = r.$ || { };
r.$.pk = r.$.pk || { };
r.$.pk.rg_query_BaseQuery = r.$.pk.rg_query_BaseQuery || rg.query.BaseQuery;
r.$.pk.rg_query_Query = r.$.pk.rg_query_Query || rg.query.Query;
var r = window.ReportGrid?window.ReportGrid:window.ReportGrid = { };
r.$ = r.$ || { };
r.$.pk = r.$.pk || { };
r.$.pk.rg_query_ReportGridBaseQuery = r.$.pk.rg_query_ReportGridBaseQuery || rg.query.ReportGridBaseQuery;
r.$.pk.rg_query_ReportGridQuery = r.$.pk.rg_query_ReportGridQuery || rg.query.ReportGridQuery;
thx.languages.En.get_language();
thx.cultures.EnUS.get_culture();
var j;
if(null != (j = window.JSON)) {
	thx.json.Json.nativeDecoder = j.parse;
	thx.json.Json.nativeEncoder = j.stringify;
}
DateTools.DAYS_OF_MONTH = [31,28,31,30,31,30,31,31,30,31,30,31];
Dates._reparse = new EReg("^\\d{4}-\\d\\d-\\d\\d(( |T)\\d\\d:\\d\\d(:\\d\\d(\\.\\d{1,3})?)?)?Z?$","");
Floats._reparse = new EReg("^[+\\-]?(?:0|[1-9]\\d*)(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?","");
Floats._reparseStrict = new EReg("^[+\\-]?(?:0|[1-9]\\d*)(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?$","");
Ints._reparse = new EReg("^([+-])?\\d+$","");
js.Browser.window = typeof window != "undefined" ? window : null;
js.Browser.document = typeof window != "undefined" ? window.document : null;
rg.data.ReportGridExecutorCache.DATE_PREFIX = "D:";
rg.data.ReportGridExecutorCache.VALUE_PREFIX = "V:";
thx.date.DateParser.months = thx.cultures.EnUS.get_culture().date.months.slice(0,-1).map(function(d) {
	return d.toLowerCase();
});
thx.date.DateParser.shortmonths = thx.cultures.EnUS.get_culture().date.abbrMonths.slice(0,-1).map(function(d) {
	return d.toLowerCase();
});
thx.date.DateParser.days = thx.cultures.EnUS.get_culture().date.days.map(function(d) {
	return d.toLowerCase();
});
thx.date.DateParser.shortdays = thx.cultures.EnUS.get_culture().date.abbrDays.map(function(d) {
	return d.toLowerCase();
});
thx.date.DateParser.sfullmonths = thx.date.DateParser.months.join("|");
thx.date.DateParser.sshortmonths = thx.date.DateParser.shortmonths.join("|");
thx.date.DateParser.sfulldays = thx.date.DateParser.days.join("|");
thx.date.DateParser.sshortdays = thx.date.DateParser.shortdays.join("|");
thx.date.DateParser.day = "(0?[0-9]|[1-2][0-9]|3[0-1])(?:st|nd|rd|th)?";
thx.date.DateParser.month = "(?:0?[1-9]|1[0-2])";
thx.date.DateParser.hour = "(?:0?[0-9]|1[0-9]|2[0-3])";
thx.date.DateParser.hhour = "(?:0[0-9]|1[0-2])";
thx.date.DateParser.hohour = "(?:0?[0-9]|1[0-2])";
thx.date.DateParser.fminsec = "(?:0[0-9]|[1-5][0-9])";
thx.date.DateParser.minsec = "(?:0?[0-9]|[1-5][0-9])";
thx.date.DateParser.ampm = "(?:(?:in\\s+the\\s+)?(am|pm|evening|morning|afternoon))";
thx.date.DateParser.daypart = "(?:(?:in\\s+the\\s+)?(evening|morning|afternoon|sunsrise|sunset|dawn|dusk|noon|mid-day|midday|mid-night|midnight))";
thx.date.DateParser.period = "minute|minutes|hour|hours|day|days|week|weeks|month|months|year|years|second|seconds";
thx.date.DateParser.dateexp = new EReg("(?:(?:" + "\\b(" + thx.date.DateParser.sfullmonths + ")\\s+" + thx.date.DateParser.day + "(?:\\s*,\\s*(\\d{2,4}))?\\b" + ")|(?:" + "\\b(" + thx.date.DateParser.sshortmonths + ")\\s+" + thx.date.DateParser.day + "(?:\\s*,?\\s*(\\d{2,4}))?\\b" + ")|(?:" + "\\b" + thx.date.DateParser.day + "\\s+(" + thx.date.DateParser.sfullmonths + ")(?:\\s+(\\d{2,4}))?\\b" + ")|(?:" + "\\b" + thx.date.DateParser.day + "\\s+(" + thx.date.DateParser.sshortmonths + ")(?:\\s+(\\d{2,4}))?\\b" + ")|(?:" + "\\b(?:" + thx.date.DateParser.day + "\\s+)?(" + thx.date.DateParser.sfullmonths + ")\\s+(\\d{2,4})\\b" + ")|(?:" + "\\b(?:" + thx.date.DateParser.day + "\\s+)?(" + thx.date.DateParser.sshortmonths + ")\\s+(\\d{2,4})\\b" + ")|(?:" + "\\b(" + thx.date.DateParser.month + ")/" + thx.date.DateParser.day + "(?:/(\\d{2,4}))?\\b" + ")|(?:" + "\\b" + thx.date.DateParser.day + "/(" + thx.date.DateParser.month + ")(?:/(\\d{2,4}))?\\b" + ")|(?:" + "\\b(\\d{2,4})-(" + thx.date.DateParser.month + ")-" + thx.date.DateParser.day + "\\b" + ")|(?:" + "^\\s*" + thx.date.DateParser.day + "\\s*$" + "))","i");
thx.date.DateParser.absdateexp = new EReg("(?:(?:" + "\\b(today|now|this\\s+second|tomorrow|yesterday)\\b" + ")|(?:" + "\\b(?:(next|last|this)\\s+)?(" + thx.date.DateParser.sfullmonths + ")\\b" + ")|(?:" + "\\b(?:(next|last|this)\\s+)?(" + thx.date.DateParser.sfulldays + ")\\b" + ")|(?:" + "\\b(?:(next|last|this)\\s+)?(" + thx.date.DateParser.sshortmonths + ")\\b" + ")|(?:" + "\\b(?:(next|last|this)\\s+)?(" + thx.date.DateParser.sshortdays + ")\\b" + "))","i");
thx.date.DateParser.relexp = new EReg("(?:(?:" + "\\b(plus\\s+|minus\\s|\\+|-|in)\\s*(\\d+)?\\s+(" + thx.date.DateParser.period + ")\\b" + ")|(?:" + "\\b(\\d+)?\\s+(" + thx.date.DateParser.period + ")\\s+(from|before|hence|after|ago)?\\b" + "))","i");
thx.date.DateParser.timeexp = new EReg("(?:\\bat\\s+)?" + "(?:(?:" + "\\b(" + thx.date.DateParser.hohour + "):(" + thx.date.DateParser.minsec + ")\\s*" + thx.date.DateParser.ampm + "\\b" + ")|(?:" + "(?:\\b|T)(" + thx.date.DateParser.hour + "):(" + thx.date.DateParser.minsec + ")(?:[:](" + thx.date.DateParser.minsec + ")(?:\\.(\\d+))?)?\\b" + ")|(?:" + "(?:^|\\s+)(" + thx.date.DateParser.hhour + ")(" + thx.date.DateParser.fminsec + ")\\s*" + thx.date.DateParser.ampm + "?(?:\\s+|$)" + ")|(?:" + "\\b(" + thx.date.DateParser.hohour + ")\\s*" + thx.date.DateParser.ampm + "\\b" + ")|(?:" + "\\b" + thx.date.DateParser.daypart + "\\b" + "))","i");
thx.text.ERegs._escapePattern = new EReg("[*+?|{[()^$.# \\\\]","");
rg.app.query.JSBridge.main();
})();
