(function () { "use strict";
var $hxClasses = {},$estr = function() { return js.Boot.__string_rec(this,''); };
function $extend(from, fields) {
	function inherit() {}; inherit.prototype = from; var proto = new inherit();
	for (var name in fields) proto[name] = fields[name];
	if( fields.toString !== Object.prototype.toString ) proto.toString = fields.toString;
	return proto;
}
var Arrays = function() { }
$hxClasses["Arrays"] = Arrays;
Arrays.__name__ = ["Arrays"];
Arrays.addIf = function(arr,condition,value) {
	if(null != condition) {
		if(condition) arr.push(value);
	} else if(null != value) arr.push(value);
	return arr;
}
Arrays.min = function(arr,f) {
	if(arr.length == 0) return null;
	if(null == f) {
		var a = arr[0], p = 0;
		var comp = Dynamics.comparef(a);
		var _g1 = 1, _g = arr.length;
		while(_g1 < _g) {
			var i = _g1++;
			if(comp(a,arr[i]) > 0) a = arr[p = i];
		}
		return arr[p];
	} else {
		var a = f(arr[0]), p = 0, b;
		var _g1 = 1, _g = arr.length;
		while(_g1 < _g) {
			var i = _g1++;
			if(a > (b = f(arr[i]))) {
				a = b;
				p = i;
			}
		}
		return arr[p];
	}
}
Arrays.floatMax = function(arr,f) {
	if(arr.length == 0) return Math.NaN;
	var a = f(arr[0]), b;
	var _g1 = 1, _g = arr.length;
	while(_g1 < _g) {
		var i = _g1++;
		if(a < (b = f(arr[i]))) a = b;
	}
	return a;
}
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
Arrays.order = function(arr,f) {
	arr.sort(null == f?Dynamics.compare:f);
	return arr;
}
Arrays.exists = function(arr,value,f) {
	if(null != f) {
		var _g = 0;
		while(_g < arr.length) {
			var v = arr[_g];
			++_g;
			if(f(v)) return true;
		}
	} else {
		var _g = 0;
		while(_g < arr.length) {
			var v = arr[_g];
			++_g;
			if(v == value) return true;
		}
	}
	return false;
}
Arrays.format = function(v,param,params,culture) {
	params = thx.culture.FormatParams.params(param,params,"J");
	var format = params.shift();
	switch(format) {
	case "J":
		if(v.length == 0) {
			var empty = null == params[1]?"[]":params[1];
			return empty;
		}
		var sep = null == params[2]?", ":params[2];
		var max = params[3] == null?null:"" == params[3]?null:Std.parseInt(params[3]);
		if(null != max && max < v.length) {
			var elipsis = null == params[4]?" ...":params[4];
			return Iterators.map(HxOverrides.iter(v.slice().splice(0,max)),function(d,i) {
				return Dynamics.format(d,params[0],null,null,culture);
			}).join(sep) + elipsis;
		} else return Iterators.map(HxOverrides.iter(v),function(d,i) {
			return Dynamics.format(d,params[0],null,null,culture);
		}).join(sep);
		break;
	case "C":
		return Ints.format(v.length,"I",[],culture);
	default:
		throw "Unsupported array format: " + format;
	}
}
Arrays.indexOf = function(arr,el) {
	return arr.indexOf(el);
}
Arrays.string = function(arr) {
	return "[" + Iterators.map(HxOverrides.iter(arr),function(v,_) {
		return Dynamics.string(v);
	}).join(", ") + "]";
}
Arrays.last = function(arr) {
	return arr[arr.length - 1];
}
Arrays.firstf = function(arr,f) {
	var _g = 0;
	while(_g < arr.length) {
		var v = arr[_g];
		++_g;
		if(f(v)) return v;
	}
	return null;
}
Arrays.nearest = function(a,x,f) {
	var delta = [];
	var _g1 = 0, _g = a.length;
	while(_g1 < _g) {
		var i = _g1++;
		delta.push({ i : i, v : Math.abs(f(a[i]) - x)});
	}
	delta.sort(function(a1,b) {
		return Floats.compare(a1.v,b.v);
	});
	return a[delta[0].i];
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
Arrays.rotate = function(a) {
	if(a.length == 0) return [];
	var result = [];
	var _g1 = 0, _g = a[0].length;
	while(_g1 < _g) {
		var i = _g1++;
		result[i] = [];
	}
	var _g1 = 0, _g = a.length;
	while(_g1 < _g) {
		var j = _g1++;
		var _g3 = 0, _g2 = a[0].length;
		while(_g3 < _g2) {
			var i = _g3++;
			result[i][j] = a[j][i];
		}
	}
	return result;
}
var Bools = function() { }
$hxClasses["Bools"] = Bools;
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
$hxClasses["DateTools"] = DateTools;
DateTools.__name__ = ["DateTools"];
DateTools.delta = function(d,t) {
	return (function($this) {
		var $r;
		var d1 = new Date();
		d1.setTime(d.getTime() + t);
		$r = d1;
		return $r;
	}(this));
}
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
$hxClasses["EReg"] = EReg;
EReg.__name__ = ["EReg"];
EReg.prototype = {
	customReplace: function(s,f) {
		var buf = new StringBuf();
		while(true) {
			if(!this.match(s)) break;
			buf.b += Std.string(this.matchedLeft());
			buf.b += Std.string(f(this));
			s = this.matchedRight();
		}
		buf.b += Std.string(s);
		return buf.b;
	}
	,replace: function(s,by) {
		return s.replace(this.r,by);
	}
	,matchedRight: function() {
		if(this.r.m == null) throw "No string matched";
		if(this.r.r == null) {
			var sz = this.r.m.index + this.r.m[0].length;
			return this.r.s.substr(sz,this.r.s.length - sz);
		}
		return this.r.r;
	}
	,matchedLeft: function() {
		if(this.r.m == null) throw "No string matched";
		if(this.r.l == null) return this.r.s.substr(0,this.r.m.index);
		return this.r.l;
	}
	,matched: function(n) {
		return this.r.m != null && n >= 0 && n < this.r.m.length?this.r.m[n]:(function($this) {
			var $r;
			throw "EReg::matched";
			return $r;
		}(this));
	}
	,match: function(s) {
		this.r.m = this.r.exec(s);
		this.r.s = s;
		this.r.l = RegExp.leftContext;
		this.r.r = RegExp.rightContext;
		return this.r.m != null;
	}
	,r: null
	,__class__: EReg
}
var Dates = function() { }
$hxClasses["Dates"] = Dates;
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
			return thx.culture.FormatDate.format(d,f,culture,params[1] != null?params[1] == "true":true);
		};
		break;
	default:
		return function(d) {
			return thx.culture.FormatDate.format(d,format,culture,params[0] != null?params[0] == "true":true);
		};
	}
}
Dates.interpolate = function(f,a,b,equation) {
	return (Dates.interpolatef(a,b,equation))(f);
}
Dates.interpolatef = function(a,b,equation) {
	var f = Floats.interpolatef(a.getTime(),b.getTime(),equation);
	return function(v) {
		return (function($this) {
			var $r;
			var d = new Date();
			d.setTime(f(v));
			$r = d;
			return $r;
		}(this));
	};
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
Dates.snapToWeekDay = function(time,day,mode,firstDayOfWk) {
	if(firstDayOfWk == null) firstDayOfWk = 0;
	if(mode == null) mode = 0;
	var d = ((function($this) {
		var $r;
		var d1 = new Date();
		d1.setTime(time);
		$r = d1;
		return $r;
	}(this))).getDay();
	var s = (function($this) {
		var $r;
		var _g = day.toLowerCase();
		$r = (function($this) {
			var $r;
			switch(_g) {
			case "sunday":
				$r = 0;
				break;
			case "monday":
				$r = 1;
				break;
			case "tuesday":
				$r = 2;
				break;
			case "wednesday":
				$r = 3;
				break;
			case "thursday":
				$r = 4;
				break;
			case "friday":
				$r = 5;
				break;
			case "saturday":
				$r = 6;
				break;
			default:
				$r = (function($this) {
					var $r;
					throw new thx.error.Error("unknown week day '{0}'",null,day,{ fileName : "Dates.hx", lineNumber : 244, className : "Dates", methodName : "snapToWeekDay"});
					$r = -1;
					return $r;
				}($this));
			}
			return $r;
		}($this));
		return $r;
	}(this));
	if(mode < 0) {
		if(s > d) s = s - 7;
		return time - (d - s) * 24 * 60 * 60 * 1000;
	} else if(mode > 0) {
		if(s < d) s = s + 7;
		return time + (s - d) * 24 * 60 * 60 * 1000;
	} else {
		if(s < firstDayOfWk) s = s + 7;
		if(d < firstDayOfWk) d = d + 7;
		return time + (s - d) * 24 * 60 * 60 * 1000;
	}
}
Dates.isLeapYear = function(year) {
	if(year % 4 != 0) return false;
	if(year % 100 == 0) return year % 400 == 0;
	return true;
}
Dates.isInLeapYear = function(d) {
	return Dates.isLeapYear(d.getFullYear());
}
Dates.numDaysInMonth = function(month,year) {
	return (function($this) {
		var $r;
		switch(month) {
		case 0:case 2:case 4:case 6:case 7:case 9:case 11:
			$r = 31;
			break;
		case 3:case 5:case 8:case 10:
			$r = 30;
			break;
		case 1:
			$r = Dates.isLeapYear(year)?29:28;
			break;
		default:
			$r = (function($this) {
				var $r;
				throw new thx.error.Error("Invalid month '{0}'.  Month should be a number, Jan=0, Dec=11",null,month,{ fileName : "Dates.hx", lineNumber : 311, className : "Dates", methodName : "numDaysInMonth"});
				$r = 0;
				return $r;
			}($this));
		}
		return $r;
	}(this));
}
Dates.numDaysInThisMonth = function(d) {
	return Dates.numDaysInMonth(d.getMonth(),d.getFullYear());
}
Dates.deltaSec = function(d,numSec) {
	return DateTools.delta(d,numSec * 1000);
}
Dates.deltaMin = function(d,numMin) {
	return DateTools.delta(d,numMin * 60 * 1000);
}
Dates.deltaHour = function(d,numHrs) {
	return DateTools.delta(d,numHrs * 60 * 60 * 1000);
}
Dates.deltaDay = function(d,numDays) {
	return DateTools.delta(d,numDays * 24 * 60 * 60 * 1000);
}
Dates.deltaWeek = function(d,numWks) {
	return DateTools.delta(d,numWks * 7 * 24 * 60 * 60 * 1000);
}
Dates.deltaMonth = function(d,numMonths) {
	var newM = d.getMonth() + numMonths;
	var newY = d.getFullYear();
	while(newM > 11) {
		newM = newM - 12;
		newY++;
	}
	while(newM < 0) {
		newM = newM + 12;
		newY--;
	}
	return new Date(newY,newM,d.getDate(),d.getHours(),d.getMinutes(),d.getSeconds());
}
Dates.deltaYear = function(d,numYrs) {
	var newY = d.getFullYear() + numYrs;
	return new Date(newY,d.getMonth(),d.getDate(),d.getHours(),d.getMinutes(),d.getSeconds());
}
Dates.prevYear = function(d) {
	return Dates.deltaYear(d,-1);
}
Dates.nextYear = function(d) {
	return Dates.deltaYear(d,1);
}
Dates.prevMonth = function(d) {
	return Dates.deltaMonth(d,-1);
}
Dates.nextMonth = function(d) {
	return Dates.deltaMonth(d,1);
}
Dates.prevWeek = function(d) {
	return DateTools.delta(d,-604800000);
}
Dates.nextWeek = function(d) {
	return DateTools.delta(d,604800000);
}
Dates.prevDay = function(d) {
	return DateTools.delta(d,-86400000);
}
Dates.nextDay = function(d) {
	return DateTools.delta(d,86400000);
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
$hxClasses["Dynamics"] = Dynamics;
Dynamics.__name__ = ["Dynamics"];
Dynamics.format = function(v,param,params,nullstring,culture) {
	return (Dynamics.formatf(param,params,nullstring,culture))(v);
}
Dynamics.formatf = function(param,params,nullstring,culture) {
	if(nullstring == null) nullstring = "null";
	return function(v) {
		var _g = Type["typeof"](v);
		var $e = (_g);
		switch( $e[1] ) {
		case 0:
			return nullstring;
		case 1:
			return Ints.format(v,param,params,culture);
		case 2:
			return Floats.format(v,param,params,culture);
		case 3:
			return Bools.format(v,param,params,culture);
		case 6:
			var c = $e[2];
			if(c == String) return Strings.formatOne(v,param,params,culture); else if(c == Array) return Arrays.format(v,param,params,culture); else if(c == Date) return Dates.format(v,param,params,culture); else return Objects.format(v,param,params,culture);
			break;
		case 4:
			return Objects.format(v,param,params,culture);
		case 5:
			return "function()";
		default:
			return (function($this) {
				var $r;
				throw new thx.error.Error("Unsupported type format: {0}",null,Type["typeof"](v),{ fileName : "Dynamics.hx", lineNumber : 46, className : "Dynamics", methodName : "formatf"});
				return $r;
			}(this));
		}
	};
}
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
		var c = $e[2];
		var name = Type.getClassName(c);
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
		var c = $e[2];
		var name = Type.getClassName(c);
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
Dynamics.comparef = function(sample) {
	var _g = Type["typeof"](sample);
	var $e = (_g);
	switch( $e[1] ) {
	case 1:
	case 2:
		return Floats.compare;
	case 3:
		return Bools.compare;
	case 4:
		return Objects.compare;
	case 6:
		var c = $e[2];
		var name = Type.getClassName(c);
		switch(name) {
		case "Array":
			return Arrays.compare;
		case "String":
			return Strings.compare;
		case "Date":
			return Dates.compare;
		default:
			return function(a,b) {
				return Strings.compare(Std.string(a),Std.string(b));
			};
		}
		break;
	case 7:
		return Enums.compare;
	default:
		return Dynamics.compare;
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
		var c = $e[2];
		var name = Type.getClassName(c);
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
				var o = Type.createEmptyInstance(c);
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
		var c = $e[2];
		var ca = Type.getClassName(c), cb = Type.getClassName(Type.getClass(b));
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
		if(js.Boot.__instanceof(a,_Map.Map_Impl_) || js.Boot.__instanceof(a,haxe.ds.StringMap) || js.Boot.__instanceof(a,haxe.ds.IntMap)) {
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
		var e = $e[2];
		var ea = Type.getEnumName(e), teb = Type.getEnum(b), eb = Type.getEnumName(teb);
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
		throw new thx.error.Error("Unable to compare values: {0} and {1}",[a,b],null,{ fileName : "Dynamics.hx", lineNumber : 370, className : "Dynamics", methodName : "same"});
		return $r;
	}(this));
}
var Enums = function() { }
$hxClasses["Enums"] = Enums;
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
$hxClasses["Floats"] = Floats;
Floats.__name__ = ["Floats"];
Floats.normalize = function(v) {
	if(v < 0.0) return 0.0; else if(v > 1.0) return 1.0; else return v;
}
Floats.range = function(start,stop,step,inclusive,round) {
	if(round == null) round = false;
	if(inclusive == null) inclusive = false;
	if(step == null) step = 1.0;
	if(null == stop) {
		stop = start;
		start = 0.0;
	}
	if((stop - start) / step == Math.POSITIVE_INFINITY) throw new thx.error.Error("infinite range",null,null,{ fileName : "Floats.hx", lineNumber : 50, className : "Floats", methodName : "range"});
	var range = [], i = -1.0, j, increment;
	increment = round?function() {
		var dec = ("" + step).split(".").pop(), precision = dec == "0"?0:dec.length;
		increment = function() {
			return j = Floats.round(start + step * ++i,precision);
		};
		return increment();
	}:function() {
		return j = start + step * ++i;
	};
	if(inclusive) {
		if(step < 0) while(increment() >= stop) range.push(j); else while(increment() <= stop) range.push(j);
	} else if(step < 0) while(increment() > stop) range.push(j); else while(increment() < stop) range.push(j);
	return range;
}
Floats.min = function(a,b) {
	return a < b?a:b;
}
Floats.max = function(a,b) {
	return a > b?a:b;
}
Floats.circularWrap = function(v,max) {
	v = v % max;
	if(v < 0) v += max;
	return v;
}
Floats.interpolate = function(f,a,b,equation) {
	if(b == null) b = 1.0;
	if(a == null) a = 0.0;
	if(null == equation) equation = thx.math.Equations.linear;
	return a + equation(f) * (b - a);
}
Floats.interpolatef = function(a,b,equation) {
	if(b == null) b = 1.0;
	if(a == null) a = 0.0;
	if(null == equation) equation = thx.math.Equations.linear;
	var d = b - a;
	return function(f) {
		return a + equation(f) * d;
	};
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
			throw new thx.error.Error("Unsupported number format: {0}",null,format,{ fileName : "Floats.hx", lineNumber : 165, className : "Floats", methodName : "formatf"});
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
Floats.uninterpolatef = function(a,b) {
	b = 1 / (b - a);
	return function(x) {
		return (x - a) * b;
	};
}
Floats.round = function(number,precision) {
	if(precision == null) precision = 2;
	number *= Math.pow(10,precision);
	return Math.round(number) / Math.pow(10,precision);
}
var HxOverrides = function() { }
$hxClasses["HxOverrides"] = HxOverrides;
HxOverrides.__name__ = ["HxOverrides"];
HxOverrides.dateStr = function(date) {
	var m = date.getMonth() + 1;
	var d = date.getDate();
	var h = date.getHours();
	var mi = date.getMinutes();
	var s = date.getSeconds();
	return date.getFullYear() + "-" + (m < 10?"0" + m:"" + m) + "-" + (d < 10?"0" + d:"" + d) + " " + (h < 10?"0" + h:"" + h) + ":" + (mi < 10?"0" + mi:"" + mi) + ":" + (s < 10?"0" + s:"" + s);
}
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
var IntIterator = function(min,max) {
	this.min = min;
	this.max = max;
};
$hxClasses["IntIterator"] = IntIterator;
IntIterator.__name__ = ["IntIterator"];
IntIterator.prototype = {
	max: null
	,min: null
	,__class__: IntIterator
}
var Ints = function() { }
$hxClasses["Ints"] = Ints;
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
Ints.abs = function(a) {
	return a < 0?-a:a;
}
Ints.min = function(a,b) {
	return a < b?a:b;
}
Ints.max = function(a,b) {
	return a > b?a:b;
}
Ints.clamp = function(v,min,max) {
	if(v < min) return min; else if(v > max) return max; else return v;
}
Ints.interpolate = function(f,min,max,equation) {
	if(max == null) max = 100.0;
	if(min == null) min = 0.0;
	if(null == equation) equation = thx.math.Equations.linear;
	return Math.round(min + equation(f) * (max - min));
}
Ints.interpolatef = function(min,max,equation) {
	if(max == null) max = 1.0;
	if(min == null) min = 0.0;
	if(null == equation) equation = thx.math.Equations.linear;
	var d = max - min;
	return function(f) {
		return Math.round(min + equation(f) * d);
	};
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
$hxClasses["Iterables"] = Iterables;
Iterables.__name__ = ["Iterables"];
Iterables.isIterable = function(v) {
	var fields = Reflect.isObject(v) && null == Type.getClass(v)?Reflect.fields(v):Type.getInstanceFields(Type.getClass(v));
	if(!Lambda.has(fields,"iterator")) return false;
	return Reflect.isFunction(Reflect.field(v,"iterator"));
}
var Iterators = function() { }
$hxClasses["Iterators"] = Iterators;
Iterators.__name__ = ["Iterators"];
Iterators.count = function(it) {
	var i = 0;
	while( it.hasNext() ) {
		var _ = it.next();
		i++;
	}
	return i;
}
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
Iterators.each = function(it,f) {
	var i = 0;
	while( it.hasNext() ) {
		var o = it.next();
		f(o,i++);
	}
}
Iterators.filter = function(it,f) {
	var result = [];
	while( it.hasNext() ) {
		var i = it.next();
		if(f(i)) result.push(i);
	}
	return result;
}
Iterators.reduce = function(it,f,initialValue) {
	var accumulator = initialValue, i = 0;
	while( it.hasNext() ) {
		var o = it.next();
		accumulator = f(accumulator,o,i++);
	}
	return accumulator;
}
Iterators.firstf = function(it,f) {
	while( it.hasNext() ) {
		var v = it.next();
		if(f(v)) return v;
	}
	return null;
}
Iterators.isIterator = function(v) {
	var fields = Reflect.isObject(v) && null == Type.getClass(v)?Reflect.fields(v):Type.getInstanceFields(Type.getClass(v));
	if(!Lambda.has(fields,"next") || !Lambda.has(fields,"hasNext")) return false;
	return Reflect.isFunction(Reflect.field(v,"next")) && Reflect.isFunction(Reflect.field(v,"hasNext"));
}
var Lambda = function() { }
$hxClasses["Lambda"] = Lambda;
Lambda.__name__ = ["Lambda"];
Lambda.has = function(it,elt) {
	var $it0 = $iterator(it)();
	while( $it0.hasNext() ) {
		var x = $it0.next();
		if(x == elt) return true;
	}
	return false;
}
var List = function() { }
$hxClasses["List"] = List;
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
var _Map = {}
_Map.Map_Impl_ = function() { }
$hxClasses["_Map.Map_Impl_"] = _Map.Map_Impl_;
_Map.Map_Impl_.__name__ = ["_Map","Map_Impl_"];
var IMap = function() { }
$hxClasses["IMap"] = IMap;
IMap.__name__ = ["IMap"];
var Objects = function() { }
$hxClasses["Objects"] = Objects;
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
Objects.format = function(v,param,params,culture) {
	return (Objects.formatf(param,params,culture))(v);
}
Objects.formatf = function(param,params,culture) {
	params = thx.culture.FormatParams.params(param,params,"R");
	var format = params.shift();
	switch(format) {
	case "O":
		return function(v) {
			return Std.string(v);
		};
	case "R":
		return function(v) {
			var buf = [];
			var _g = 0, _g1 = Reflect.fields(v);
			while(_g < _g1.length) {
				var field = _g1[_g];
				++_g;
				buf.push(field + ":" + Dynamics.format(Reflect.field(v,field),null,null,null,culture));
			}
			return "{" + buf.join(",") + "}";
		};
	default:
		return (function($this) {
			var $r;
			throw new thx.error.Error("Unsupported number format: {0}",null,format,{ fileName : "Objects.hx", lineNumber : 242, className : "Objects", methodName : "formatf"});
			return $r;
		}(this));
	}
}
var Reflect = function() { }
$hxClasses["Reflect"] = Reflect;
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
		if(f != "__id__" && f != "hx__closures__" && hasOwnProperty.call(o,f)) a.push(f);
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
	return t == "string" || t == "object" && v.__enum__ == null || t == "function" && (v.__name__ || v.__ename__) != null;
}
Reflect.deleteField = function(o,field) {
	if(!Reflect.hasField(o,field)) return false;
	delete(o[field]);
	return true;
}
Reflect.makeVarArgs = function(f) {
	return function() {
		var a = Array.prototype.slice.call(arguments);
		return f(a);
	};
}
var Std = function() { }
$hxClasses["Std"] = Std;
Std.__name__ = ["Std"];
Std.string = function(s) {
	return js.Boot.__string_rec(s,"");
}
Std["int"] = function(x) {
	return x | 0;
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
$hxClasses["StringBuf"] = StringBuf;
StringBuf.__name__ = ["StringBuf"];
StringBuf.prototype = {
	toString: function() {
		return this.b;
	}
	,addSub: function(s,pos,len) {
		this.b += len == null?HxOverrides.substr(s,pos,null):HxOverrides.substr(s,pos,len);
	}
	,addChar: function(c) {
		this.b += String.fromCharCode(c);
	}
	,add: function(x) {
		this.b += Std.string(x);
	}
	,b: null
	,__class__: StringBuf
}
var StringTools = function() { }
$hxClasses["StringTools"] = StringTools;
StringTools.__name__ = ["StringTools"];
StringTools.urlEncode = function(s) {
	return encodeURIComponent(s);
}
StringTools.urlDecode = function(s) {
	return decodeURIComponent(s.split("+").join(" "));
}
StringTools.startsWith = function(s,start) {
	return s.length >= start.length && HxOverrides.substr(s,0,start.length) == start;
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
StringTools.rpad = function(s,c,l) {
	var sl = s.length;
	var cl = c.length;
	while(sl < l) if(l - sl < cl) {
		s += HxOverrides.substr(c,0,l - sl);
		sl = l;
	} else {
		s += c;
		sl += cl;
	}
	return s;
}
StringTools.lpad = function(s,c,l) {
	var ns = "";
	var sl = s.length;
	if(sl >= l) return s;
	var cl = c.length;
	while(sl < l) if(l - sl < cl) {
		ns += HxOverrides.substr(c,0,l - sl);
		sl = l;
	} else {
		ns += c;
		sl += cl;
	}
	return ns + s;
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
$hxClasses["Strings"] = Strings;
Strings.__name__ = ["Strings"];
Strings.format = function(pattern,values,nullstring,culture) {
	if(nullstring == null) nullstring = "null";
	if(null == values || 0 == values.length) return pattern;
	return (Strings.formatf(pattern,nullstring,culture))(values);
}
Strings.formatf = function(pattern,nullstring,culture) {
	if(nullstring == null) nullstring = "null";
	var buf = [];
	while(true) {
		if(!Strings._reFormat.match(pattern)) {
			buf.push((function() {
				return function(_) {
					return pattern;
				};
			})());
			break;
		}
		var pos = Std.parseInt(Strings._reFormat.matched(1));
		var format = Strings._reFormat.matched(2);
		if(format == "") format = null;
		var p = null;
		var params = [];
		var _g = 3;
		while(_g < 20) {
			var i = _g++;
			p = Strings._reFormat.matched(i);
			if(p == null || p == "") break;
			params.push(thx.culture.FormatParams.cleanQuotes(p));
		}
		var left = [Strings._reFormat.matchedLeft()];
		buf.push((function(left) {
			return function(_) {
				return left[0];
			};
		})(left));
		var df = [Dynamics.formatf(format,params,nullstring,culture)];
		buf.push(((function() {
			return function(f,i1) {
				return (function() {
					return function(v) {
						return f(i1,v);
					};
				})();
			};
		})())((function(df) {
			return function(i,v) {
				return df[0](v[i]);
			};
		})(df),pos));
		pattern = Strings._reFormat.matchedRight();
	}
	return function(values) {
		if(null == values) values = [];
		return buf.map(function(df) {
			return df(values);
		}).join("");
	};
}
Strings.formatOne = function(v,param,params,culture) {
	return (Strings.formatOnef(param,params,culture))(v);
}
Strings.formatOnef = function(param,params,culture) {
	params = thx.culture.FormatParams.params(param,params,"S");
	var format = params.shift();
	switch(format) {
	case "S":
		return function(v) {
			return v;
		};
	case "T":
		var len = params.length < 1?20:Std.parseInt(params[0]);
		var ellipsis = params.length < 2?"...":params[1];
		return Strings.ellipsisf(len,ellipsis);
	case "PR":
		var len1 = params.length < 1?10:Std.parseInt(params[0]);
		var pad = params.length < 2?" ":params[1];
		return function(v) {
			return StringTools.rpad(v,pad,len1);
		};
	case "PL":
		var len2 = params.length < 1?10:Std.parseInt(params[0]);
		var pad1 = params.length < 2?" ":params[1];
		return function(v) {
			return StringTools.lpad(v,pad1,len2);
		};
	default:
		return (function($this) {
			var $r;
			throw "Unsupported string format: " + format;
			return $r;
		}(this));
	}
}
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
Strings.collapse = function(value) {
	return Strings._reCollapse.replace(StringTools.trim(value)," ");
}
Strings.ucfirst = function(value) {
	return value == null?null:value.charAt(0).toUpperCase() + HxOverrides.substr(value,1,null);
}
Strings.lcfirst = function(value) {
	return value == null?null:value.charAt(0).toLowerCase() + HxOverrides.substr(value,1,null);
}
Strings.empty = function(value) {
	return value == null || value == "";
}
Strings.mapEreg = function(e,s,f) {
	var buf = new StringBuf();
	while(true) {
		if(!e.match(s)) break;
		buf.b += Std.string(e.matchedLeft());
		buf.b += Std.string(f(e));
		s = e.matchedRight();
	}
	buf.b += Std.string(s);
	return buf.b;
}
Strings.ucwords = function(value) {
	return Strings.mapEreg(Strings.__ucwordsPattern,value == null?null:value.charAt(0).toUpperCase() + HxOverrides.substr(value,1,null),Strings.__upperMatch);
}
Strings.__upperMatch = function(re) {
	return re.matched(0).toUpperCase();
}
Strings.humanize = function(s) {
	return StringTools.replace(Strings.underscore(s),"_"," ");
}
Strings.underscore = function(s) {
	s = new EReg("::","g").replace(s,"/");
	s = new EReg("([A-Z]+)([A-Z][a-z])","g").replace(s,"$1_$2");
	s = new EReg("([a-z\\d])([A-Z])","g").replace(s,"$1_$2");
	s = new EReg("-","g").replace(s,"_");
	return s.toLowerCase();
}
Strings.dasherize = function(s) {
	return StringTools.replace(s,"_","-");
}
Strings.interpolatef = function(a,b,equation) {
	var extract = function(value,s,f) {
		while(Strings._reInterpolateNumber.match(value)) {
			var left = Strings._reInterpolateNumber.matchedLeft();
			if(!Strings.empty(left)) {
				s.push(left);
				f.push(null);
			}
			s.push(null);
			f.push(Std.parseFloat(Strings._reInterpolateNumber.matched(0)));
			value = Strings._reInterpolateNumber.matchedRight();
		}
		if(!Strings.empty(value)) {
			s.push(value);
			f.push(null);
		}
	};
	var decimals = function(v) {
		var s = "" + v, p = s.indexOf(".");
		if(p < 0) return 0;
		return s.length - p - 1;
	};
	var sa = [], fa = [], sb = [], fb = [];
	extract(a,sa,fa);
	extract(b,sb,fb);
	var functions = [], i = 0;
	var min = Ints.min(sa.length,sb.length);
	while(i < min) {
		if(sa[i] != sb[i]) break;
		if(null == sa[i]) {
			if(fa[i] == fb[i]) {
				var s1 = ["" + fa[i]];
				functions.push((function(s1) {
					return function(_) {
						return s1[0];
					};
				})(s1));
			} else {
				var f1 = [Floats.interpolatef(fa[i],fb[i],equation)];
				var dec = [Math.pow(10,Ints.max(decimals(fa[i]),decimals(fb[i])))];
				functions.push((function(dec,f1) {
					return function(t) {
						return "" + Math.round(f1[0](t) * dec[0]) / dec[0];
					};
				})(dec,f1));
			}
		} else {
			var s2 = [sa[i]];
			functions.push((function(s2) {
				return function(_) {
					return s2[0];
				};
			})(s2));
		}
		i++;
	}
	var rest = "";
	while(i < sb.length) {
		if(null != sb[i]) rest += sb[i]; else rest += fb[i];
		i++;
	}
	if("" != rest) functions.push(function(_) {
		return rest;
	});
	return function(t1) {
		return Iterators.map(HxOverrides.iter(functions),function(f,_) {
			return f(t1);
		}).join("");
	};
}
Strings.ellipsis = function(s,maxlen,symbol) {
	if(symbol == null) symbol = "...";
	if(maxlen == null) maxlen = 20;
	if(s.length > maxlen) return HxOverrides.substr(s,0,Ints.max(symbol.length,maxlen - symbol.length)) + symbol; else return s;
}
Strings.ellipsisf = function(maxlen,symbol) {
	if(symbol == null) symbol = "...";
	if(maxlen == null) maxlen = 20;
	return function(s) {
		if(s.length > maxlen) return HxOverrides.substr(s,0,Ints.max(symbol.length,maxlen - symbol.length)) + symbol; else return s;
	};
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
$hxClasses["Type"] = Type;
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
Type.resolveClass = function(name) {
	var cl = $hxClasses[name];
	if(cl == null || !cl.__name__) return null;
	return cl;
}
Type.createInstance = function(cl,args) {
	switch(args.length) {
	case 0:
		return new cl();
	case 1:
		return new cl(args[0]);
	case 2:
		return new cl(args[0],args[1]);
	case 3:
		return new cl(args[0],args[1],args[2]);
	case 4:
		return new cl(args[0],args[1],args[2],args[3]);
	case 5:
		return new cl(args[0],args[1],args[2],args[3],args[4]);
	case 6:
		return new cl(args[0],args[1],args[2],args[3],args[4],args[5]);
	case 7:
		return new cl(args[0],args[1],args[2],args[3],args[4],args[5],args[6]);
	case 8:
		return new cl(args[0],args[1],args[2],args[3],args[4],args[5],args[6],args[7]);
	default:
		throw "Too many arguments";
	}
	return null;
}
Type.createEmptyInstance = function(cl) {
	function empty() {}; empty.prototype = cl.prototype;
	return new empty();
}
Type.createEnum = function(e,constr,params) {
	var f = Reflect.field(e,constr);
	if(f == null) throw "No such constructor " + constr;
	if(Reflect.isFunction(f)) {
		if(params == null) throw "Constructor " + constr + " need parameters";
		return f.apply(e,params);
	}
	if(params != null && params.length != 0) throw "Constructor " + constr + " does not need parameters";
	return f;
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
Type.enumEq = function(a,b) {
	if(a == b) return true;
	try {
		if(a[0] != b[0]) return false;
		var _g1 = 2, _g = a.length;
		while(_g1 < _g) {
			var i = _g1++;
			if(!Type.enumEq(a[i],b[i])) return false;
		}
		var e = a.__enum__;
		if(e != b.__enum__ || e == null) return false;
	} catch( e ) {
		return false;
	}
	return true;
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
$hxClasses["Types"] = Types;
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
				var c = $e[2];
				$r = Type.getClassName(c);
				break;
			case 7:
				var e = $e[2];
				$r = Type.getEnumName(e);
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
Types.isAnonymous = function(v) {
	return Reflect.isObject(v) && null == Type.getClass(v);
}
Types["as"] = function(value,type) {
	return js.Boot.__instanceof(value,type)?value:null;
}
Types.isPrimitive = function(v) {
	return (function($this) {
		var $r;
		var _g = Type["typeof"](v);
		$r = (function($this) {
			var $r;
			var $e = (_g);
			switch( $e[1] ) {
			case 0:
			case 1:
			case 2:
			case 3:
				$r = true;
				break;
			case 5:
			case 7:
			case 4:
			case 8:
				$r = false;
				break;
			case 6:
				var c = $e[2];
				$r = Type.getClassName(c) == "String";
				break;
			}
			return $r;
		}($this));
		return $r;
	}(this));
}
var dhx = {}
dhx.Access = function(selection) {
	this.selection = selection;
};
$hxClasses["dhx.Access"] = dhx.Access;
dhx.Access.__name__ = ["dhx","Access"];
dhx.Access.prototype = {
	selection: null
	,__class__: dhx.Access
}
dhx.AccessAttribute = function(name,selection) {
	dhx.Access.call(this,selection);
	this.name = name;
	this.qname = dhx.Namespace.qualify(name);
};
$hxClasses["dhx.AccessAttribute"] = dhx.AccessAttribute;
dhx.AccessAttribute.__name__ = ["dhx","AccessAttribute"];
dhx.AccessAttribute.__super__ = dhx.Access;
dhx.AccessAttribute.prototype = $extend(dhx.Access.prototype,{
	'float': function(v) {
		var s = "" + v;
		if(null == this.qname) {
			var n = this.name;
			this.selection.eachNode(function(node,i) {
				node.setAttribute(n,s);
			});
		} else {
			var q = this.qname;
			this.selection.eachNode(function(node,i) {
				node.setAttributeNS(q.space,q.local,s);
			});
		}
		return this.selection;
	}
	,string: function(v) {
		if(null == this.qname) {
			var n = this.name;
			this.selection.eachNode(function(node,i) {
				node.setAttribute(n,v);
			});
		} else {
			var q = this.qname;
			this.selection.eachNode(function(node,i) {
				node.setAttributeNS(q.space,q.local,v);
			});
		}
		return this.selection;
	}
	,getFloat: function() {
		var v = this.get();
		if(dhx.AccessAttribute.refloat.match(v)) return Std.parseFloat(dhx.AccessAttribute.refloat.matched(1)); else return Math.NaN;
	}
	,get: function() {
		var n = this.name, q = this.qname;
		return this.selection.firstNode(function(node) {
			return q == null?node.getAttribute(n):node.getAttributeNS(q.space,q.local);
		});
	}
	,qname: null
	,name: null
	,__class__: dhx.AccessAttribute
});
dhx.AccessDataAttribute = function(name,selection) {
	dhx.AccessAttribute.call(this,name,selection);
};
$hxClasses["dhx.AccessDataAttribute"] = dhx.AccessDataAttribute;
dhx.AccessDataAttribute.__name__ = ["dhx","AccessDataAttribute"];
dhx.AccessDataAttribute.__super__ = dhx.AccessAttribute;
dhx.AccessDataAttribute.prototype = $extend(dhx.AccessAttribute.prototype,{
	floatf: function(v) {
		if(null == this.qname) {
			var n = this.name;
			this.selection.eachNode(function(node,i) {
				var s = v(Reflect.field(node,"__dhx_data__"),i);
				if(null == s) node.removeAttribute(n); else node.setAttribute(n,"" + s);
			});
		} else {
			var q = this.qname;
			this.selection.eachNode(function(node,i) {
				var s = v(Reflect.field(node,"__dhx_data__"),i);
				if(null == s) node.removeAttributeNS(q.space,q.local); else node.setAttributeNS(q.space,q.local,"" + s);
			});
		}
		return this.selection;
	}
	,stringf: function(v) {
		if(null == this.qname) {
			var n = this.name;
			this.selection.eachNode(function(node,i) {
				var s = v(Reflect.field(node,"__dhx_data__"),i);
				if(null == s) node.removeAttribute(n); else node.setAttribute(n,s);
			});
		} else {
			var q = this.qname;
			this.selection.eachNode(function(node,i) {
				var s = v(Reflect.field(node,"__dhx_data__"),i);
				if(null == s) node.removeAttributeNS(q.space,q.local); else node.setAttributeNS(q.space,q.local,s);
			});
		}
		return this.selection;
	}
	,__class__: dhx.AccessDataAttribute
});
dhx.AccessClassed = function(selection) {
	dhx.Access.call(this,selection);
};
$hxClasses["dhx.AccessClassed"] = dhx.AccessClassed;
dhx.AccessClassed.__name__ = ["dhx","AccessClassed"];
dhx.AccessClassed.escapeERegChars = function(s) {
	return dhx.AccessClassed._escapePattern.customReplace(s,function(e) {
		return "\\" + e.matched(0);
	});
}
dhx.AccessClassed.__super__ = dhx.Access;
dhx.AccessClassed.prototype = $extend(dhx.Access.prototype,{
	_add: function(name,node,i) {
		var list = node.classList;
		if(null != list) {
			list.add(name);
			return;
		}
		var cls = node.className, clsb = null != cls.baseVal, clsv = clsb?cls.baseVal:cls;
		var re = new EReg("(^|\\s+)" + dhx.AccessClassed.escapeERegChars(name) + "(\\s+|$)","g");
		if(!re.match(clsv)) {
			clsv = Strings.collapse(clsv + " " + name);
			if(clsb) cls.baseVal = clsv; else node.className = clsv;
		}
	}
	,add: function(name) {
		this.selection.eachNode((function(f,a1) {
			return function(a2,i) {
				return f(a1,a2,i);
			};
		})($bind(this,this._add),name));
		return this.selection;
	}
	,_remove: function(name,node,i) {
		var list = node.classList;
		if(null != list) {
			list.remove(name);
			return;
		}
		var cls = node.className, clsb = null != cls.baseVal, clsv = clsb?cls.baseVal:cls;
		var re = new EReg("(^|\\s+)" + dhx.AccessClassed.escapeERegChars(name) + "(\\s+|$)","g");
		clsv = Strings.collapse(re.replace(clsv," "));
		if(clsb) cls.baseVal = clsv; else node.className = clsv;
	}
	,remove: function(name) {
		this.selection.eachNode((function(f,a1) {
			return function(a2,i) {
				return f(a1,a2,i);
			};
		})($bind(this,this._remove),name));
		return this.selection;
	}
	,__class__: dhx.AccessClassed
});
dhx.AccessDataClassed = function(selection) {
	dhx.AccessClassed.call(this,selection);
};
$hxClasses["dhx.AccessDataClassed"] = dhx.AccessDataClassed;
dhx.AccessDataClassed.__name__ = ["dhx","AccessDataClassed"];
dhx.AccessDataClassed.__super__ = dhx.AccessClassed;
dhx.AccessDataClassed.prototype = $extend(dhx.AccessClassed.prototype,{
	__class__: dhx.AccessDataClassed
});
dhx.AccessHtml = function(selection) {
	dhx.Access.call(this,selection);
};
$hxClasses["dhx.AccessHtml"] = dhx.AccessHtml;
dhx.AccessHtml.__name__ = ["dhx","AccessHtml"];
dhx.AccessHtml.__super__ = dhx.Access;
dhx.AccessHtml.prototype = $extend(dhx.Access.prototype,{
	string: function(v) {
		this.selection.eachNode(function(node,i) {
			node.innerHTML = v;
		});
		return this.selection;
	}
	,get: function() {
		return this.selection.firstNode(function(node) {
			return node.innerHTML;
		});
	}
	,__class__: dhx.AccessHtml
});
dhx.AccessDataHtml = function(selection) {
	dhx.AccessHtml.call(this,selection);
};
$hxClasses["dhx.AccessDataHtml"] = dhx.AccessDataHtml;
dhx.AccessDataHtml.__name__ = ["dhx","AccessDataHtml"];
dhx.AccessDataHtml.__super__ = dhx.AccessHtml;
dhx.AccessDataHtml.prototype = $extend(dhx.AccessHtml.prototype,{
	stringf: function(v) {
		this.selection.eachNode(function(node,i) {
			var s = v(Reflect.field(node,"__dhx_data__"),i);
			if(null == s) s = "";
			node.innerHTML = s;
		});
		return this.selection;
	}
	,__class__: dhx.AccessDataHtml
});
dhx.AccessStyle = function(name,selection) {
	dhx.Access.call(this,selection);
	this.name = name;
};
$hxClasses["dhx.AccessStyle"] = dhx.AccessStyle;
dhx.AccessStyle.__name__ = ["dhx","AccessStyle"];
dhx.AccessStyle._getPropertyName = function(key) {
	if(key == "float" || key == "cssFloat" || key == "styleFloat") return js.Browser.document.body.cssFloat == null?"styleFloat":"cssFloat";
	if(key.indexOf("-") >= 0) key = Strings.ucwords(key);
	return key;
}
dhx.AccessStyle.getComputedStyleValue = function(node,key) {
	if('getComputedStyle' in window) dhx.AccessStyle.getComputedStyleValue = function(node1,key1) {
		return js.Browser.window.getComputedStyle(node1,null).getPropertyValue(key1);
	}; else dhx.AccessStyle.getComputedStyleValue = function(node1,key1) {
		var style = node1.currentStyle;
		if(null == Reflect.field(style,key1)) key1 = dhx.AccessStyle._getPropertyName(key1);
		if(null == Reflect.field(style,key1)) return ""; else return Reflect.field(style,key1);
	};
	return dhx.AccessStyle.getComputedStyleValue(node,key);
}
dhx.AccessStyle.setStyleProperty = function(node,key,value,priority) {
	if('setProperty' in node.style) dhx.AccessStyle.setStyleProperty = function(node1,key1,value1,priority1) {
		node1.style.setProperty(key1,"" + value1,priority1 == null?"":priority1);
	}; else dhx.AccessStyle.setStyleProperty = function(node1,key1,value1,priority1) {
		var style = node1.style;
		if(null == Reflect.field(style,key1)) key1 = dhx.AccessStyle._getPropertyName(key1);
		if(null != priority1 && "" != priority1) style.cssText += ";" + Strings.dasherize(key1) + ":" + value1 + "!important;"; else style[key1] = value1;
	};
	dhx.AccessStyle.setStyleProperty(node,key,value,priority);
}
dhx.AccessStyle.removeStyleProperty = function(node,key) {
	if('removeProperty' in node.style) dhx.AccessStyle.removeStyleProperty = function(node1,key1) {
		node1.style.removeProperty(key1);
	}; else dhx.AccessStyle.removeStyleProperty = function(node1,key1) {
		var style = node1.style;
		if(null == Reflect.field(style,key1)) key1 = dhx.AccessStyle._getPropertyName(key1);
		Reflect.deleteField(style,key1);
	};
}
dhx.AccessStyle.__super__ = dhx.Access;
dhx.AccessStyle.prototype = $extend(dhx.Access.prototype,{
	color: function(v,priority) {
		var _g = this;
		var s = v.toRgbString();
		this.selection.eachNode(function(node,i) {
			dhx.AccessStyle.setStyleProperty(node,_g.name,s,priority);
		});
		return this.selection;
	}
	,'float': function(v,priority) {
		var _g = this;
		this.selection.eachNode(function(node,i) {
			dhx.AccessStyle.setStyleProperty(node,_g.name,v,priority);
		});
		return this.selection;
	}
	,string: function(v,priority) {
		var _g = this;
		this.selection.eachNode(function(node,i) {
			dhx.AccessStyle.setStyleProperty(node,_g.name,v,priority);
		});
		return this.selection;
	}
	,getFloat: function() {
		var v = this.get();
		if(dhx.AccessStyle.refloat.match(v)) return Std.parseFloat(dhx.AccessStyle.refloat.matched(1)); else return Math.NaN;
	}
	,get: function() {
		var _g = this;
		return this.selection.firstNode(function(node) {
			return dhx.AccessStyle.getComputedStyleValue(node,_g.name);
		});
	}
	,name: null
	,__class__: dhx.AccessStyle
});
dhx.AccessDataStyle = function(name,selection) {
	dhx.AccessStyle.call(this,name,selection);
};
$hxClasses["dhx.AccessDataStyle"] = dhx.AccessDataStyle;
dhx.AccessDataStyle.__name__ = ["dhx","AccessDataStyle"];
dhx.AccessDataStyle.__super__ = dhx.AccessStyle;
dhx.AccessDataStyle.prototype = $extend(dhx.AccessStyle.prototype,{
	stringf: function(v,priority) {
		var _g = this;
		this.selection.eachNode(function(node,i) {
			var s = v(Reflect.field(node,"__dhx_data__"),i);
			if(s == null) dhx.AccessStyle.removeStyleProperty(node,_g.name); else dhx.AccessStyle.setStyleProperty(node,_g.name,s,priority);
		});
		return this.selection;
	}
	,__class__: dhx.AccessDataStyle
});
dhx.AccessText = function(selection) {
	dhx.Access.call(this,selection);
};
$hxClasses["dhx.AccessText"] = dhx.AccessText;
dhx.AccessText.__name__ = ["dhx","AccessText"];
dhx.AccessText.__super__ = dhx.Access;
dhx.AccessText.prototype = $extend(dhx.Access.prototype,{
	clear: function() {
		this.selection.eachNode(function(node,i) {
			node.textContent = "";
		});
		return this.selection;
	}
	,string: function(v) {
		this.clear();
		this.selection.eachNode(function(node,_) {
			node.textContent = v;
		});
		return this.selection;
	}
	,__class__: dhx.AccessText
});
dhx.AccessDataText = function(selection) {
	dhx.AccessText.call(this,selection);
};
$hxClasses["dhx.AccessDataText"] = dhx.AccessDataText;
dhx.AccessDataText.__name__ = ["dhx","AccessDataText"];
dhx.AccessDataText.__super__ = dhx.AccessText;
dhx.AccessDataText.prototype = $extend(dhx.AccessText.prototype,{
	stringf: function(v) {
		this.clear();
		this.selection.eachNode(function(node,i) {
			var x = v(Reflect.field(node,"__dhx_data__"),i);
			if(null != x) node.textContent = x;
		});
		return this.selection;
	}
	,__class__: dhx.AccessDataText
});
dhx.AccessTween = function(transition,tweens) {
	this.transition = transition;
	this.tweens = tweens;
};
$hxClasses["dhx.AccessTween"] = dhx.AccessTween;
dhx.AccessTween.__name__ = ["dhx","AccessTween"];
dhx.AccessTween.prototype = {
	transitionFloatTween: function(value) {
		return function(d,i,a) {
			return Floats.interpolatef(a,value);
		};
	}
	,transitionStringTweenf: function(f) {
		return function(d,i,a) {
			return Strings.interpolatef(a,f(d,i));
		};
	}
	,transitionStringTween: function(value) {
		return function(d,i,a) {
			return Strings.interpolatef(a,value);
		};
	}
	,tweens: null
	,transition: null
	,__class__: dhx.AccessTween
}
dhx.AccessTweenAttribute = function(name,transition,tweens) {
	dhx.AccessTween.call(this,transition,tweens);
	this.name = name;
	this.qname = dhx.Namespace.qualify(name);
};
$hxClasses["dhx.AccessTweenAttribute"] = dhx.AccessTweenAttribute;
dhx.AccessTweenAttribute.__name__ = ["dhx","AccessTweenAttribute"];
dhx.AccessTweenAttribute.__super__ = dhx.AccessTween;
dhx.AccessTweenAttribute.prototype = $extend(dhx.AccessTween.prototype,{
	floatTweenNodef: function(tween) {
		var name = this.name;
		var attrTween = function(d,i) {
			var f = tween(d,i,Std.parseFloat(d.getAttribute(name)));
			return function(t) {
				d.setAttribute(name,"" + f(t));
			};
		};
		var attrTweenNS = function(d1,i) {
			var f1 = tween(d1,i,Std.parseFloat(d1.getAttributeNS(name.space,name.local)));
			return function(t) {
				d1.setAttributeNS(name.space,name.local,"" + f1(t));
			};
		};
		this.tweens.set("attr." + name,null == this.qname?attrTween:attrTweenNS);
		return this.transition;
	}
	,'float': function(value) {
		return this.floatTweenNodef(this.transitionFloatTween(value));
	}
	,stringTweenNodef: function(tween) {
		var name = this.name;
		var attrTween = function(d,i) {
			var f = tween(d,i,d.getAttribute(name));
			return function(t) {
				d.setAttribute(name,f(t));
			};
		};
		var attrTweenNS = function(d1,i) {
			var f1 = tween(d1,i,d1.getAttributeNS(name.space,name.local));
			return function(t) {
				d1.setAttributeNS(name.space,name.local,f1(t));
			};
		};
		this.tweens.set("attr." + name,null == this.qname?attrTween:attrTweenNS);
		return this.transition;
	}
	,string: function(value) {
		return this.stringTweenNodef(this.transitionStringTween(value));
	}
	,qname: null
	,name: null
	,__class__: dhx.AccessTweenAttribute
});
dhx.AccessDataTweenAttribute = function(name,transition,tweens) {
	dhx.AccessTweenAttribute.call(this,name,transition,tweens);
};
$hxClasses["dhx.AccessDataTweenAttribute"] = dhx.AccessDataTweenAttribute;
dhx.AccessDataTweenAttribute.__name__ = ["dhx","AccessDataTweenAttribute"];
dhx.AccessDataTweenAttribute.__super__ = dhx.AccessTweenAttribute;
dhx.AccessDataTweenAttribute.prototype = $extend(dhx.AccessTweenAttribute.prototype,{
	stringf: function(f) {
		return this.stringTweenNodef(this.transitionStringTweenf(function(n,i) {
			return f(Reflect.field(n,"__dhx_data__"),i);
		}));
	}
	,__class__: dhx.AccessDataTweenAttribute
});
dhx.AccessTweenStyle = function(name,transition,tweens) {
	dhx.AccessTween.call(this,transition,tweens);
	this.name = name;
};
$hxClasses["dhx.AccessTweenStyle"] = dhx.AccessTweenStyle;
dhx.AccessTweenStyle.__name__ = ["dhx","AccessTweenStyle"];
dhx.AccessTweenStyle.__super__ = dhx.AccessTween;
dhx.AccessTweenStyle.prototype = $extend(dhx.AccessTween.prototype,{
	floatTweenNodef: function(tween,priority) {
		var name = this.name;
		var styleTween = function(d,i) {
			var f = tween(d,i,Std.parseFloat(dhx.AccessStyle.getComputedStyleValue(d,name)));
			return function(t) {
				dhx.AccessStyle.setStyleProperty(d,name,"" + f(t),priority);
			};
		};
		this.tweens.set("style." + name,styleTween);
		return this.transition;
	}
	,'float': function(value,priority) {
		return this.floatTweenNodef(this.transitionFloatTween(value),priority);
	}
	,name: null
	,__class__: dhx.AccessTweenStyle
});
dhx.HostType = { __ename__ : ["dhx","HostType"], __constructs__ : ["UnknownServer","NodeJs","IE","Firefox","Safari","Chrome","Opera","Unknown"] }
dhx.HostType.UnknownServer = ["UnknownServer",0];
dhx.HostType.UnknownServer.toString = $estr;
dhx.HostType.UnknownServer.__enum__ = dhx.HostType;
dhx.HostType.NodeJs = ["NodeJs",1];
dhx.HostType.NodeJs.toString = $estr;
dhx.HostType.NodeJs.__enum__ = dhx.HostType;
dhx.HostType.IE = function(version) { var $x = ["IE",2,version]; $x.__enum__ = dhx.HostType; $x.toString = $estr; return $x; }
dhx.HostType.Firefox = function(version) { var $x = ["Firefox",3,version]; $x.__enum__ = dhx.HostType; $x.toString = $estr; return $x; }
dhx.HostType.Safari = function(version) { var $x = ["Safari",4,version]; $x.__enum__ = dhx.HostType; $x.toString = $estr; return $x; }
dhx.HostType.Chrome = function(version) { var $x = ["Chrome",5,version]; $x.__enum__ = dhx.HostType; $x.toString = $estr; return $x; }
dhx.HostType.Opera = function(version) { var $x = ["Opera",6,version]; $x.__enum__ = dhx.HostType; $x.toString = $estr; return $x; }
dhx.HostType.Unknown = function(what) { var $x = ["Unknown",7,what]; $x.__enum__ = dhx.HostType; $x.toString = $estr; return $x; }
dhx.EnvironmentType = { __ename__ : ["dhx","EnvironmentType"], __constructs__ : ["Mobile","Desktop","Server","UnknownEnvironment"] }
dhx.EnvironmentType.Mobile = ["Mobile",0];
dhx.EnvironmentType.Mobile.toString = $estr;
dhx.EnvironmentType.Mobile.__enum__ = dhx.EnvironmentType;
dhx.EnvironmentType.Desktop = ["Desktop",1];
dhx.EnvironmentType.Desktop.toString = $estr;
dhx.EnvironmentType.Desktop.__enum__ = dhx.EnvironmentType;
dhx.EnvironmentType.Server = ["Server",2];
dhx.EnvironmentType.Server.toString = $estr;
dhx.EnvironmentType.Server.__enum__ = dhx.EnvironmentType;
dhx.EnvironmentType.UnknownEnvironment = ["UnknownEnvironment",3];
dhx.EnvironmentType.UnknownEnvironment.toString = $estr;
dhx.EnvironmentType.UnknownEnvironment.__enum__ = dhx.EnvironmentType;
dhx.OSType = { __ename__ : ["dhx","OSType"], __constructs__ : ["Windows","IOs","Android","Mac","Linux","UnknownOs"] }
dhx.OSType.Windows = function(version) { var $x = ["Windows",0,version]; $x.__enum__ = dhx.OSType; $x.toString = $estr; return $x; }
dhx.OSType.IOs = ["IOs",1];
dhx.OSType.IOs.toString = $estr;
dhx.OSType.IOs.__enum__ = dhx.OSType;
dhx.OSType.Android = ["Android",2];
dhx.OSType.Android.toString = $estr;
dhx.OSType.Android.__enum__ = dhx.OSType;
dhx.OSType.Mac = ["Mac",3];
dhx.OSType.Mac.toString = $estr;
dhx.OSType.Mac.__enum__ = dhx.OSType;
dhx.OSType.Linux = ["Linux",4];
dhx.OSType.Linux.toString = $estr;
dhx.OSType.Linux.__enum__ = dhx.OSType;
dhx.OSType.UnknownOs = ["UnknownOs",5];
dhx.OSType.UnknownOs.toString = $estr;
dhx.OSType.UnknownOs.__enum__ = dhx.OSType;
dhx.ClientHost = function() { }
$hxClasses["dhx.ClientHost"] = dhx.ClientHost;
dhx.ClientHost.__name__ = ["dhx","ClientHost"];
dhx.ClientHost.isIE = function() {
	return (function($this) {
		var $r;
		var _g = dhx.ClientHost;
		$r = (function($this) {
			var $r;
			switch( (_g.host)[1] ) {
			case 2:
				$r = true;
				break;
			default:
				$r = false;
			}
			return $r;
		}($this));
		return $r;
	}(this));
}
dhx.ClientHost.userAgent = function() {
	return "" + navigator.userAgent;
}
dhx.ClientHost.hasNavigator = function() {
	return typeof navigator !== 'undefined';
}
var js = {}
js.Browser = function() { }
$hxClasses["js.Browser"] = js.Browser;
js.Browser.__name__ = ["js","Browser"];
js.Browser.createXMLHttpRequest = function() {
	if(typeof XMLHttpRequest != "undefined") return new XMLHttpRequest();
	if(typeof ActiveXObject != "undefined") return new ActiveXObject("Microsoft.XMLHTTP");
	throw "Unable to create XMLHttpRequest object.";
}
dhx.Group = function(nodes) {
	this.nodes = nodes;
};
$hxClasses["dhx.Group"] = dhx.Group;
dhx.Group.__name__ = ["dhx","Group"];
dhx.Group.merge = function(source,target) {
	if(target.length != source.length) throw "Group length not equal";
	var _g1 = 0, _g = target.length;
	while(_g1 < _g) {
		var i = _g1++;
		var s = source[i];
		var t = target[i];
		if(s.parentNode != t.parentNode) throw "parentNodes not the same!"; else if(s.nodes.length != t.nodes.length) throw "node length mismatch!"; else {
			var _g3 = 0, _g2 = t.nodes.length;
			while(_g3 < _g2) {
				var i1 = _g3++;
				if(null == t.nodes[i1]) t.nodes[i1] = s.nodes[i1];
			}
		}
	}
	return target;
}
dhx.Group.prototype = {
	each: function(f) {
		var _g1 = 0, _g = this.nodes.length;
		while(_g1 < _g) {
			var i = _g1++;
			if(null != this.nodes[i]) f(dhx.Group.current = this.nodes[i],i);
		}
	}
	,nodes: null
	,parentNode: null
	,__class__: dhx.Group
}
dhx.BaseSelection = function(groups) {
	this.groups = groups;
};
$hxClasses["dhx.BaseSelection"] = dhx.BaseSelection;
dhx.BaseSelection.__name__ = ["dhx","BaseSelection"];
dhx.BaseSelection.listenerEnterLeave = function(f,dom,i) {
	var e = dhx.Dom.event, target = e.relatedTarget;
	if(null == target || dhx.BaseSelection.isChild(dom,target)) return;
	f(dom,i);
}
dhx.BaseSelection.isChild = function(parent,child) {
	if(child == parent) return false;
	while(child != null) {
		child = child.parentNode;
		if(child == parent) return true;
	}
	return false;
}
dhx.BaseSelection.addEvent = function(target,typo,handler,capture) {
	if($bind(target,target.addEventListener) != null) dhx.BaseSelection.addEvent = function(target1,typo1,handler1,capture1) {
		target1.addEventListener(typo1,handler1,capture1);
	}; else if(target.attachEvent != null) dhx.BaseSelection.addEvent = function(target1,typo1,handler1,capture1) {
		target1.attachEvent(typo1,handler1);
	};
	dhx.BaseSelection.addEvent(target,typo,handler,capture);
}
dhx.BaseSelection.removeEvent = function(target,typo,type,capture) {
	if($bind(target,target.removeEventListener) != null) dhx.BaseSelection.removeEvent = function(target1,typo1,type1,capture1) {
		target1.removeEventListener(typo1,Reflect.field(target1,"__dhx_on__" + type1),false);
	}; else if(target.attachEvent != null) dhx.BaseSelection.removeEvent = function(target1,typo1,type1,capture1) {
		target1.detachEvent(typo1,Reflect.field(target1,"__dhx_on__" + type1));
	};
	dhx.BaseSelection.removeEvent(target,typo,type,capture);
}
dhx.BaseSelection.bindJoin = function(join,group,groupData,update,enter,exit) {
	var n = group.nodes.length, m = groupData.length, updateElements = [], exitElements = [], enterElements = [], node, nodeData;
	var nodeByKey = new haxe.ds.StringMap(), keys = [], key, j = groupData.length;
	var _g = 0;
	while(_g < n) {
		var i = _g++;
		node = group.nodes[i];
		key = join(Reflect.field(node,"__dhx_data__"),i);
		if(nodeByKey.exists(key)) exitElements[j++] = node; else nodeByKey.set(key,node);
		keys.push(key);
	}
	var _g = 0;
	while(_g < m) {
		var i = _g++;
		node = nodeByKey.get(key = join(nodeData = groupData[i],i));
		if(null != node) {
			node.__dhx_data__ = nodeData;
			updateElements[i] = node;
			enterElements[i] = exitElements[i] = null;
		} else {
			node = { __dhx_data__ : nodeData};
			enterElements[i] = node;
			updateElements[i] = exitElements[i] = null;
		}
		nodeByKey.remove(key);
	}
	var _g = 0;
	while(_g < n) {
		var i = _g++;
		if(nodeByKey.exists(keys[i])) exitElements[i] = group.nodes[i];
	}
	var enterGroup = new dhx.Group(enterElements);
	enterGroup.parentNode = group.parentNode;
	enter.push(enterGroup);
	var updateGroup = new dhx.Group(updateElements);
	updateGroup.parentNode = group.parentNode;
	update.push(updateGroup);
	var exitGroup = new dhx.Group(exitElements);
	exitGroup.parentNode = group.parentNode;
	exit.push(exitGroup);
}
dhx.BaseSelection.bind = function(group,groupData,update,enter,exit) {
	var n0 = group.nodes.length, n1 = group.nodes.length, updateElements = [], exitElements = [], enterElements = [], node, nodeData;
	if(n0 > groupData.length) n0 = groupData.length;
	if(n1 < groupData.length) n1 = groupData.length;
	var _g = 0;
	while(_g < n0) {
		var i = _g++;
		node = group.nodes[i];
		nodeData = groupData[i];
		if(null != node) {
			node.__dhx_data__ = nodeData;
			updateElements[i] = node;
			enterElements[i] = exitElements[i] = null;
		} else {
			enterElements[i] = { __dhx_data__ : nodeData};
			updateElements[i] = exitElements[i] = null;
		}
	}
	var _g1 = n0, _g = groupData.length;
	while(_g1 < _g) {
		var i = _g1++;
		node = { __dhx_data__ : groupData[i]};
		enterElements[i] = node;
		updateElements[i] = exitElements[i] = null;
	}
	var _g = groupData.length;
	while(_g < n1) {
		var i = _g++;
		exitElements[i] = group.nodes[i];
		enterElements[i] = updateElements[i] = null;
	}
	var enterGroup = new dhx.Group(enterElements);
	enterGroup.parentNode = group.parentNode;
	enter.push(enterGroup);
	var updateGroup = new dhx.Group(updateElements);
	updateGroup.parentNode = group.parentNode;
	update.push(updateGroup);
	var exitGroup = new dhx.Group(exitElements);
	exitGroup.parentNode = group.parentNode;
	exit.push(exitGroup);
}
dhx.BaseSelection.prototype = {
	_selectAll: function(selectallf) {
		var subgroups = [], subgroup;
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			var $it0 = HxOverrides.iter(group.nodes);
			while( $it0.hasNext() ) {
				var node = $it0.next();
				if(null != node) {
					subgroups.push(subgroup = new dhx.Group(selectallf(node)));
					subgroup.parentNode = node;
				}
			}
		}
		return this.createSelection(subgroups);
	}
	,_select: function(selectf) {
		var subgroups = [], subgroup, subnode, node;
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			subgroups.push(subgroup = new dhx.Group([]));
			subgroup.parentNode = group.parentNode;
			var $it0 = HxOverrides.iter(group.nodes);
			while( $it0.hasNext() ) {
				var node1 = $it0.next();
				if(null != node1) {
					subgroup.parentNode = node1;
					subgroup.nodes.push(subnode = selectf(node1));
					if(null != subnode) subnode.__dhx_data__ = Reflect.field(node1,"__dhx_data__");
				} else subgroup.nodes.push(null);
			}
		}
		return this.createSelection(subgroups);
	}
	,createSelection: function(groups) {
		return (function($this) {
			var $r;
			throw "abstract method";
			return $r;
		}(this));
	}
	,onNode: function(type,listener,capture) {
		if(capture == null) capture = false;
		var i = type.indexOf("."), typo = i < 0?type:HxOverrides.substr(type,0,i);
		if((typo == "mouseenter" || typo == "mouseleave") && !dhx.ClientHost.isIE()) {
			listener = (function(f1,f) {
				return function(a1,i1) {
					return f1(f,a1,i1);
				};
			})(dhx.BaseSelection.listenerEnterLeave,listener);
			if(typo == "mouseenter") typo = "mouseover"; else typo = "mouseout";
		}
		return this.eachNode(function(n,i2) {
			var l = function(e) {
				var o = dhx.Dom.event;
				dhx.Dom.event = e;
				try {
					listener(n,i2);
				} catch( e1 ) {
				}
				dhx.Dom.event = o;
			};
			if(null != Reflect.field(n,"__dhx_on__" + type)) {
				dhx.BaseSelection.removeEvent(n,typo,type,capture);
				Reflect.deleteField(n,"__dhx_on__" + type);
			}
			if(null != listener) {
				n["__dhx_on__" + type] = l;
				dhx.BaseSelection.addEvent(n,typo,l,capture);
			}
		});
	}
	,mapNode: function(f) {
		var results = [];
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			var i = -1;
			var $it0 = HxOverrides.iter(group.nodes);
			while( $it0.hasNext() ) {
				var node = $it0.next();
				if(null != node) results.push(f(node,++i));
			}
		}
		return results;
	}
	,filterNode: function(f) {
		var subgroups = [], subgroup;
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			var sg = new dhx.Group(subgroup = []);
			sg.parentNode = group.parentNode;
			subgroups.push(sg);
			var i = -1;
			var $it0 = HxOverrides.iter(group.nodes);
			while( $it0.hasNext() ) {
				var node = $it0.next();
				if(null != node && f(node,++i)) subgroup.push(node);
			}
		}
		return this.createSelection(subgroups);
	}
	,empty: function() {
		return null == this.firstNode(function(n) {
			return n;
		});
	}
	,node: function() {
		return this.firstNode(function(n) {
			return n;
		});
	}
	,firstNode: function(f) {
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			var $it0 = HxOverrides.iter(group.nodes);
			while( $it0.hasNext() ) {
				var node = $it0.next();
				if(null != node) return f(node);
			}
		}
		return null;
	}
	,eachNode: function(f) {
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			group.each(f);
		}
		return this;
	}
	,remove: function() {
		return this.eachNode(function(node,i) {
			var parent = node.parentNode;
			if(null != parent) parent.removeChild(node);
		});
	}
	,append: function(name) {
		var qname = dhx.Namespace.qualify(name);
		var append = function(node) {
			var n = js.Browser.document.createElement(name);
			node.appendChild(n);
			return n;
		};
		var appendNS = function(node) {
			var n = js.Browser.document.createElementNS(qname.space,qname.local);
			node.appendChild(n);
			return n;
		};
		return this._select(null == qname?append:appendNS);
	}
	,selectAll: function(selector) {
		return this._selectAll(function(el) {
			return dhx.Dom.selectionEngine.selectAll(selector,el);
		});
	}
	,select: function(selector) {
		return this._select(function(el) {
			return dhx.Dom.selectionEngine.select(selector,el);
		});
	}
	,groups: null
	,parentNode: null
	,__class__: dhx.BaseSelection
}
dhx.UnboundSelection = function(groups) {
	dhx.BaseSelection.call(this,groups);
};
$hxClasses["dhx.UnboundSelection"] = dhx.UnboundSelection;
dhx.UnboundSelection.__name__ = ["dhx","UnboundSelection"];
dhx.UnboundSelection.__super__ = dhx.BaseSelection;
dhx.UnboundSelection.prototype = $extend(dhx.BaseSelection.prototype,{
	data: function(d,join) {
		var update = [], enter = [], exit = [];
		if(null == join) {
			var _g = 0, _g1 = this.groups;
			while(_g < _g1.length) {
				var group = _g1[_g];
				++_g;
				dhx.BaseSelection.bind(group,d,update,enter,exit);
			}
		} else {
			var _g = 0, _g1 = this.groups;
			while(_g < _g1.length) {
				var group = _g1[_g];
				++_g;
				dhx.BaseSelection.bindJoin(join,group,d,update,enter,exit);
			}
		}
		return new dhx.DataChoice(update,enter,exit);
	}
	,transition: function() {
		return new dhx.UnboundTransition(this);
	}
	,style: function(name) {
		return new dhx.AccessStyle(name,this);
	}
	,classed: function() {
		return new dhx.AccessClassed(this);
	}
	,attr: function(name) {
		return new dhx.AccessAttribute(name,this);
	}
	,text: function() {
		return new dhx.AccessText(this);
	}
	,html: function() {
		return new dhx.AccessHtml(this);
	}
	,__class__: dhx.UnboundSelection
});
dhx.Selection = function(groups) {
	dhx.UnboundSelection.call(this,groups);
};
$hxClasses["dhx.Selection"] = dhx.Selection;
dhx.Selection.__name__ = ["dhx","Selection"];
dhx.Selection.create = function(groups) {
	return new dhx.Selection(groups);
}
dhx.Selection.__super__ = dhx.UnboundSelection;
dhx.Selection.prototype = $extend(dhx.UnboundSelection.prototype,{
	createSelection: function(groups) {
		return new dhx.Selection(groups);
	}
	,__class__: dhx.Selection
});
dhx.ISelectorEngine = function() { }
$hxClasses["dhx.ISelectorEngine"] = dhx.ISelectorEngine;
dhx.ISelectorEngine.__name__ = ["dhx","ISelectorEngine"];
dhx.ISelectorEngine.prototype = {
	selectAll: null
	,select: null
	,__class__: dhx.ISelectorEngine
}
dhx.NativeSelectorEngine = function() {
};
$hxClasses["dhx.NativeSelectorEngine"] = dhx.NativeSelectorEngine;
dhx.NativeSelectorEngine.__name__ = ["dhx","NativeSelectorEngine"];
dhx.NativeSelectorEngine.__interfaces__ = [dhx.ISelectorEngine];
dhx.NativeSelectorEngine.supported = function() {
	return 'undefined' != typeof document.querySelector;
}
dhx.NativeSelectorEngine.prototype = {
	selectAll: function(selector,node,doc) {
		var s;
		if(null != node) s = node.querySelectorAll(selector); else {
			if(null == doc) doc = js.Browser.document;
			s = doc.querySelectorAll(selector);
		}
		var r = [];
		var _g1 = 0, _g = s.length;
		while(_g1 < _g) {
			var i = _g1++;
			r.push(s[i]);
		}
		return r;
	}
	,select: function(selector,node,doc) {
		if(null != node) return node.querySelector(selector);
		if(null == doc) doc = js.Browser.document;
		return doc.querySelector(selector);
	}
	,__class__: dhx.NativeSelectorEngine
}
dhx.SizzleEngine = function() {
};
$hxClasses["dhx.SizzleEngine"] = dhx.SizzleEngine;
dhx.SizzleEngine.__name__ = ["dhx","SizzleEngine"];
dhx.SizzleEngine.__interfaces__ = [dhx.ISelectorEngine];
dhx.SizzleEngine.supported = function() {
	return null != dhx.SizzleEngine.getSizzle();
}
dhx.SizzleEngine.getSizzle = function() {
	return (('undefined' != typeof Sizzle && Sizzle) || (('undefined' != typeof jQuery) && jQuery.find) || (('undefined' != typeof $) && $.find));
}
dhx.SizzleEngine.prototype = {
	selectAll: function(selector,node,doc) {
		return dhx.Sizzle.uniqueSort(dhx.Sizzle.select(selector,node || doc));
	}
	,select: function(selector,node,doc) {
		return dhx.Sizzle.select(selector,node || doc)[0];
	}
	,__class__: dhx.SizzleEngine
}
dhx.Dom = function() { }
$hxClasses["dhx.Dom"] = dhx.Dom;
dhx.Dom.__name__ = ["dhx","Dom"];
dhx.Dom.select = function(selector) {
	return dhx.Dom.doc.select(selector);
}
dhx.Dom.selectAll = function(selector) {
	return dhx.Dom.doc.selectAll(selector);
}
dhx.Dom.selectNode = function(node) {
	return dhx.Selection.create([new dhx.Group([node])]);
}
dhx.Dom.selectNodeData = function(node) {
	return dhx.ResumeSelection.create([new dhx.Group([node])]);
}
dhx.Namespace = function() { }
$hxClasses["dhx.Namespace"] = dhx.Namespace;
dhx.Namespace.__name__ = ["dhx","Namespace"];
dhx.Namespace.qualify = function(name) {
	var i = name.indexOf(":");
	if(i < 0) return null; else {
		var space = dhx.Namespace.prefix.get(HxOverrides.substr(name,0,i));
		if(null == space) throw "unable to find a namespace for " + space;
		return new dhx.NSQualifier(space,HxOverrides.substr(name,i + 1,null));
	}
}
dhx.NSQualifier = function(space,local) {
	this.space = space;
	this.local = local;
};
$hxClasses["dhx.NSQualifier"] = dhx.NSQualifier;
dhx.NSQualifier.__name__ = ["dhx","NSQualifier"];
dhx.NSQualifier.prototype = {
	local: null
	,space: null
	,__class__: dhx.NSQualifier
}
dhx.BoundSelection = function(groups) {
	dhx.BaseSelection.call(this,groups);
};
$hxClasses["dhx.BoundSelection"] = dhx.BoundSelection;
dhx.BoundSelection.__name__ = ["dhx","BoundSelection"];
dhx.BoundSelection.__super__ = dhx.BaseSelection;
dhx.BoundSelection.prototype = $extend(dhx.BaseSelection.prototype,{
	on: function(type,listener,capture) {
		if(capture == null) capture = false;
		return this.onNode(type,null == listener?null:function(n,i) {
			listener(Reflect.field(n,"__dhx_data__"),i);
		},capture);
	}
	,filter: function(f) {
		return this.filterNode(function(n,i) {
			return f(Reflect.field(n,"__dhx_data__"),i);
		});
	}
	,each: function(f) {
		return this.eachNode(function(n,i) {
			f(Reflect.field(n,"__dhx_data__"),i);
		});
	}
	,dataf: function(fd,join) {
		if(null == join) {
			var update = [], enter = [], exit = [], i = 0;
			var _g = 0, _g1 = this.groups;
			while(_g < _g1.length) {
				var group = _g1[_g];
				++_g;
				dhx.BaseSelection.bind(group,fd(Reflect.field(group.parentNode,"__dhx_data__"),i++),update,enter,exit);
			}
			return new dhx.DataChoice(update,enter,exit);
		} else {
			var update = [], enter = [], exit = [], i = 0;
			var _g = 0, _g1 = this.groups;
			while(_g < _g1.length) {
				var group = _g1[_g];
				++_g;
				dhx.BaseSelection.bindJoin(join,group,fd(Reflect.field(group.parentNode,"__dhx_data__"),i++),update,enter,exit);
			}
			return new dhx.DataChoice(update,enter,exit);
		}
	}
	,transition: function() {
		return new dhx.BoundTransition(this);
	}
	,style: function(name) {
		return new dhx.AccessDataStyle(name,this);
	}
	,classed: function() {
		return new dhx.AccessDataClassed(this);
	}
	,attr: function(name) {
		return new dhx.AccessDataAttribute(name,this);
	}
	,text: function() {
		return new dhx.AccessDataText(this);
	}
	,html: function() {
		return new dhx.AccessDataHtml(this);
	}
	,__class__: dhx.BoundSelection
});
dhx.UpdateSelection = function(update,choice) {
	dhx.BoundSelection.call(this,update);
	this._choice = choice;
};
$hxClasses["dhx.UpdateSelection"] = dhx.UpdateSelection;
dhx.UpdateSelection.__name__ = ["dhx","UpdateSelection"];
dhx.UpdateSelection.__super__ = dhx.BoundSelection;
dhx.UpdateSelection.prototype = $extend(dhx.BoundSelection.prototype,{
	exit: function() {
		return this._choice.exit();
	}
	,update: function() {
		return this;
	}
	,createSelection: function(groups) {
		return new dhx.UpdateSelection(groups,this._choice);
	}
	,_choice: null
	,__class__: dhx.UpdateSelection
});
dhx.DataChoice = function(update,enter,exit) {
	this._update = update;
	this._enter = enter;
	this._exit = exit;
	dhx.UpdateSelection.call(this,this._update,this);
};
$hxClasses["dhx.DataChoice"] = dhx.DataChoice;
dhx.DataChoice.__name__ = ["dhx","DataChoice"];
dhx.DataChoice.merge = function(groups,dc) {
	dhx.Group.merge(groups,dc._update);
}
dhx.DataChoice.__super__ = dhx.UpdateSelection;
dhx.DataChoice.prototype = $extend(dhx.UpdateSelection.prototype,{
	exit: function() {
		return new dhx.ExitSelection(this._exit,this);
	}
	,enter: function() {
		return new dhx.PreEnterSelection(this._enter,this);
	}
	,_exit: null
	,_enter: null
	,_update: null
	,__class__: dhx.DataChoice
});
dhx.ResumeSelection = function(groups) {
	dhx.BoundSelection.call(this,groups);
};
$hxClasses["dhx.ResumeSelection"] = dhx.ResumeSelection;
dhx.ResumeSelection.__name__ = ["dhx","ResumeSelection"];
dhx.ResumeSelection.create = function(groups) {
	return new dhx.ResumeSelection(groups);
}
dhx.ResumeSelection.__super__ = dhx.BoundSelection;
dhx.ResumeSelection.prototype = $extend(dhx.BoundSelection.prototype,{
	createSelection: function(groups) {
		return new dhx.ResumeSelection(groups);
	}
	,__class__: dhx.ResumeSelection
});
dhx.PreEnterSelection = function(enter,choice) {
	this.groups = enter;
	this._choice = choice;
};
$hxClasses["dhx.PreEnterSelection"] = dhx.PreEnterSelection;
dhx.PreEnterSelection.__name__ = ["dhx","PreEnterSelection"];
dhx.PreEnterSelection.prototype = {
	_select: function(selectf) {
		var subgroups = [], subgroup, subnode, node;
		var _g = 0, _g1 = this.groups;
		while(_g < _g1.length) {
			var group = _g1[_g];
			++_g;
			subgroups.push(subgroup = new dhx.Group([]));
			subgroup.parentNode = group.parentNode;
			var $it0 = HxOverrides.iter(group.nodes);
			while( $it0.hasNext() ) {
				var node1 = $it0.next();
				if(null != node1) {
					subgroup.nodes.push(subnode = selectf(group.parentNode));
					subnode.__dhx_data__ = Reflect.field(node1,"__dhx_data__");
				} else subgroup.nodes.push(null);
			}
		}
		dhx.DataChoice.merge(subgroups,this._choice);
		return this.createSelection(subgroups);
	}
	,createSelection: function(groups) {
		return new dhx.EnterSelection(groups,this._choice);
	}
	,append: function(name) {
		var qname = dhx.Namespace.qualify(name);
		var append = function(node) {
			var n = js.Browser.document.createElement(name);
			node.appendChild(n);
			return n;
		};
		var appendNS = function(node) {
			var n = js.Browser.document.createElementNS(qname.space,qname.local);
			node.appendChild(n);
			return n;
		};
		return this._select(null == qname?append:appendNS);
	}
	,_choice: null
	,groups: null
	,__class__: dhx.PreEnterSelection
}
dhx.EnterSelection = function(enter,choice) {
	dhx.BoundSelection.call(this,enter);
	this._choice = choice;
};
$hxClasses["dhx.EnterSelection"] = dhx.EnterSelection;
dhx.EnterSelection.__name__ = ["dhx","EnterSelection"];
dhx.EnterSelection.__super__ = dhx.BoundSelection;
dhx.EnterSelection.prototype = $extend(dhx.BoundSelection.prototype,{
	update: function() {
		return this._choice.update();
	}
	,createSelection: function(groups) {
		return new dhx.EnterSelection(groups,this._choice);
	}
	,_choice: null
	,__class__: dhx.EnterSelection
});
dhx.ExitSelection = function(exit,choice) {
	dhx.UnboundSelection.call(this,exit);
	this._choice = choice;
};
$hxClasses["dhx.ExitSelection"] = dhx.ExitSelection;
dhx.ExitSelection.__name__ = ["dhx","ExitSelection"];
dhx.ExitSelection.__super__ = dhx.UnboundSelection;
dhx.ExitSelection.prototype = $extend(dhx.UnboundSelection.prototype,{
	update: function() {
		return this._choice.update();
	}
	,createSelection: function(groups) {
		return new dhx.ExitSelection(groups,this._choice);
	}
	,_choice: null
	,__class__: dhx.ExitSelection
});
dhx.Svg = function() { }
$hxClasses["dhx.Svg"] = dhx.Svg;
dhx.Svg.__name__ = ["dhx","Svg"];
dhx.Svg.mouse = function(dom) {
	var point = (null != dom.ownerSVGElement?dom.ownerSVGElement:dom).createSVGPoint();
	if(dhx.Svg._usepage && (js.Browser.window.scrollX || js.Browser.window.scrollY)) {
		var svg = dhx.Dom.selectNode(js.Browser.document.body).append("svg:svg").style("position").string("absolute").style("top")["float"](0).style("left")["float"](0);
		var ctm = svg.node().getScreenCTM();
		dhx.Svg._usepage = !(ctm.f || ctm.e);
		svg.remove();
	}
	if(dhx.Svg._usepage) {
		point.x = dhx.Dom.event.pageX;
		point.y = dhx.Dom.event.pageY;
	} else {
		point.x = dhx.Dom.event.clientX;
		point.y = dhx.Dom.event.clientY;
	}
	point = point.matrixTransform(dom.getScreenCTM().inverse());
	return [point.x,point.y];
}
dhx.Timer = function() { }
$hxClasses["dhx.Timer"] = dhx.Timer;
dhx.Timer.__name__ = ["dhx","Timer"];
dhx.Timer.timer = function(f,delay) {
	if(delay == null) delay = 0.0;
	var now = new Date().getTime(), found = false, t0, t1 = dhx.Timer.queue;
	if(!Math.isFinite(delay)) return;
	while(null != t1) {
		if(Reflect.compareMethods(f,t1.f)) {
			t1.then = now;
			t1.delay = delay;
			found = true;
			break;
		}
		t0 = t1;
		t1 = t1.next;
	}
	if(!found) dhx.Timer.queue = { f : f, then : now, delay : delay, next : dhx.Timer.queue, flush : false};
	if(0 == dhx.Timer.interval) {
		dhx.Timer.timeout = clearTimeout(dhx.Timer.timeout);
		dhx.Timer.interval = 1;
		window.requestAnimationFrame(dhx.Timer._step);
	}
}
dhx.Timer.step = function() {
	var elapsed, now = new Date().getTime(), t1 = dhx.Timer.queue;
	while(null != t1) {
		elapsed = now - t1.then;
		if(elapsed > t1.delay) t1.flush = t1.f(elapsed);
		t1 = t1.next;
	}
	var delay = dhx.Timer._flush() - now;
	if(delay > 24) {
		if(Math.isFinite(delay)) {
			clearTimeout(dhx.Timer.timeout);
			dhx.Timer.timeout = setTimeout(dhx.Timer._step,delay);
		}
		dhx.Timer.interval = 0;
	} else {
		dhx.Timer.interval = 1;
		window.requestAnimationFrame(dhx.Timer._step);
	}
}
dhx.Timer._flush = function() {
	var t0 = null, t1 = dhx.Timer.queue, then = Math.POSITIVE_INFINITY;
	while(null != t1) if(t1.flush) t1 = null != t0?t0.next = t1.next:dhx.Timer.queue = t1.next; else {
		then = Math.min(then,t1.then + t1.delay);
		t1 = (t0 = t1).next;
	}
	return then;
}
dhx.BaseTransition = function(selection) {
	this.selection = selection;
	var tid = this._transitionId = dhx.BaseTransition._inheritid > 0?dhx.BaseTransition._inheritid:++dhx.BaseTransition._id;
	this._tweens = new haxe.ds.StringMap();
	this._interpolators = [];
	this._remove = false;
	this._stage = [];
	this._delay = [];
	this._duration = [];
	this._ease = dhx.BaseTransition.DEFAULT_EASE;
	this._step = $bind(this,this.step);
	selection.eachNode(function(n,_) {
		if(Reflect.hasField(n,"__dhx_transition__")) Reflect.field(n,"__dhx_transition__").owner = tid; else n.__dhx_transition__ = { owner : tid};
	});
	this.delay(null,0);
	this.duration(null,250);
};
$hxClasses["dhx.BaseTransition"] = dhx.BaseTransition;
dhx.BaseTransition.__name__ = ["dhx","BaseTransition"];
dhx.BaseTransition.CUBIC_EQUATION = function(t) {
	return Math.pow(t,3);
}
dhx.BaseTransition.DEFAULT_EASE = function(t) {
	return .5 * (t < .5?dhx.BaseTransition.CUBIC_EQUATION(2 * t):2 - dhx.BaseTransition.CUBIC_EQUATION(2 - 2 * t));
}
dhx.BaseTransition.prototype = {
	_this: function() {
		return this;
	}
	,remove: function(v) {
		if(v == null) v = true;
		this._remove = v;
		return this._this();
	}
	,ease: function(f) {
		this._ease = f;
		return this._this();
	}
	,duration: function(f,v) {
		if(v == null) v = 0.0;
		var k = -1, me = this;
		if(null != f) {
			this._durationMax = 0;
			this.selection.eachNode(function(n,i) {
				var x = me._duration[++k] = f(n,i);
				if(x > me._durationMax) me._durationMax = x;
			});
		} else {
			this._durationMax = v;
			this.selection.eachNode(function(n,i) {
				me._duration[++k] = me._durationMax;
			});
		}
		return this._this();
	}
	,delay: function(f,v) {
		if(v == null) v = 0.0;
		var delayMin = Math.POSITIVE_INFINITY, k = -1, me = this;
		if(null != f) this.selection.eachNode(function(n,i) {
			var x = me._delay[++k] = f(n,i);
			if(x < delayMin) delayMin = x;
		}); else {
			delayMin = v;
			this.selection.eachNode(function(n,i) {
				me._delay[++k] = delayMin;
			});
		}
		dhx.Timer.timer(this._step,delayMin);
		return this._this();
	}
	,endNode: function(f) {
		this._end = f;
		return this._this();
	}
	,step: function(elapsed) {
		var clear = true, k = -1, me = this;
		this.selection.eachNode(function(n,i) {
			if(2 == me._stage[++k]) return;
			var t = (elapsed - me._delay[k]) / me._duration[k], tx = Reflect.field(n,"__dhx_transition__"), te, tk, ik = me._interpolators[k];
			if(t < 1) {
				clear = false;
				if(t < 0) return;
			} else t = 1;
			if(null != me._stage[k]) {
				if(null == tx || tx.active != me._transitionId) {
					me._stage[k] = 2;
					return;
				}
			} else if(null == tx || tx.active > me._transitionId) {
				me._stage[k] = 2;
				return;
			} else {
				me._stage[k] = 1;
				if(null != me._start) me._start(n,i);
				ik = me._interpolators[k] = new haxe.ds.StringMap();
				tx.active = me._transitionId;
				var $it0 = me._tweens.keys();
				while( $it0.hasNext() ) {
					var tk1 = $it0.next();
					var f = me._tweens.get(tk1);
					ik.set(tk1,f(n,i));
				}
			}
			te = me._ease(t);
			var $it1 = me._tweens.keys();
			while( $it1.hasNext() ) {
				var tk1 = $it1.next();
				(ik.get(tk1))(te);
			}
			if(1 == t) {
				me._stage[k] = 2;
				if(tx.active == me._transitionId) {
					var owner = tx.owner;
					if(owner == me._transitionId) {
						Reflect.deleteField(n,"__dhx_transition__");
						if(me._remove) n.parentNode.removeChild(n);
					}
					dhx.BaseTransition._inheritid = me._transitionId;
					if(null != me._end) me._end(n,i);
					dhx.BaseTransition._inheritid = 0;
					tx.owner = owner;
				}
			}
		});
		return clear;
	}
	,selection: null
	,_end: null
	,_start: null
	,_step: null
	,_ease: null
	,_durationMax: null
	,_duration: null
	,_delay: null
	,_stage: null
	,_remove: null
	,_interpolators: null
	,_tweens: null
	,_transitionId: null
	,__class__: dhx.BaseTransition
}
dhx.UnboundTransition = function(selection) {
	dhx.BaseTransition.call(this,selection);
};
$hxClasses["dhx.UnboundTransition"] = dhx.UnboundTransition;
dhx.UnboundTransition.__name__ = ["dhx","UnboundTransition"];
dhx.UnboundTransition.__super__ = dhx.BaseTransition;
dhx.UnboundTransition.prototype = $extend(dhx.BaseTransition.prototype,{
	style: function(name) {
		return new dhx.AccessTweenStyle(name,this,this._tweens);
	}
	,__class__: dhx.UnboundTransition
});
dhx.BoundTransition = function(selection) {
	dhx.BaseTransition.call(this,selection);
};
$hxClasses["dhx.BoundTransition"] = dhx.BoundTransition;
dhx.BoundTransition.__name__ = ["dhx","BoundTransition"];
dhx.BoundTransition.__super__ = dhx.BaseTransition;
dhx.BoundTransition.prototype = $extend(dhx.BaseTransition.prototype,{
	attr: function(name) {
		return new dhx.AccessDataTweenAttribute(name,this,this._tweens);
	}
	,__class__: dhx.BoundTransition
});
var erazor = {}
erazor._Parser = {}
erazor._Parser.ParseContext = { __ename__ : ["erazor","_Parser","ParseContext"], __constructs__ : ["literal","code"] }
erazor._Parser.ParseContext.literal = ["literal",0];
erazor._Parser.ParseContext.literal.toString = $estr;
erazor._Parser.ParseContext.literal.__enum__ = erazor._Parser.ParseContext;
erazor._Parser.ParseContext.code = ["code",1];
erazor._Parser.ParseContext.code.toString = $estr;
erazor._Parser.ParseContext.code.__enum__ = erazor._Parser.ParseContext;
erazor._Parser.ParseResult = { __ename__ : ["erazor","_Parser","ParseResult"], __constructs__ : ["keepGoing","doneIncludeCurrent","doneSkipCurrent"] }
erazor._Parser.ParseResult.keepGoing = ["keepGoing",0];
erazor._Parser.ParseResult.keepGoing.toString = $estr;
erazor._Parser.ParseResult.keepGoing.__enum__ = erazor._Parser.ParseResult;
erazor._Parser.ParseResult.doneIncludeCurrent = ["doneIncludeCurrent",1];
erazor._Parser.ParseResult.doneIncludeCurrent.toString = $estr;
erazor._Parser.ParseResult.doneIncludeCurrent.__enum__ = erazor._Parser.ParseResult;
erazor._Parser.ParseResult.doneSkipCurrent = ["doneSkipCurrent",2];
erazor._Parser.ParseResult.doneSkipCurrent.toString = $estr;
erazor._Parser.ParseResult.doneSkipCurrent.__enum__ = erazor._Parser.ParseResult;
erazor.Parser = function() {
	this.condMatch = new EReg("^@(?:if|for|while)\\b","");
	this.inConditionalMatch = new EReg("^(?:\\}[\\s\r\n]*else if\\b|\\}[\\s\r\n]*else[\\s\r\n]*\\{)","");
	this.variableChar = new EReg("^[_\\w\\.]$","");
};
$hxClasses["erazor.Parser"] = erazor.Parser;
erazor.Parser.__name__ = ["erazor","Parser"];
erazor.Parser.prototype = {
	parse: function(template) {
		this.pos = 0;
		var output = new Array();
		this.bracketStack = [];
		this.conditionalStack = 0;
		while(template != "") {
			this.context = this.parseContext(template);
			var block = this.parseBlock(template);
			if(block.block != null) output.push(block.block);
			template = HxOverrides.substr(template,block.length,null);
			this.pos += block.length;
		}
		if(this.bracketStack.length != 0) throw new erazor.error.ParserError(erazor.Parser.bracketMismatch,this.pos);
		return output;
	}
	,escapeLiteral: function(input) {
		return StringTools.replace(input,erazor.Parser.at + erazor.Parser.at,erazor.Parser.at);
	}
	,parseLiteral: function(template) {
		var len = template.length;
		var i = -1;
		while(++i < len) {
			var $char = template.charAt(i);
			switch($char) {
			case erazor.Parser.at:
				if(len > i + 1 && template.charAt(i + 1) != erazor.Parser.at) return { block : erazor.TBlock.literal(this.escapeLiteral(HxOverrides.substr(template,0,i))), length : i, start : this.pos};
				++i;
				break;
			case "}":
				if(this.bracketStack.length > 0) {
					var _g = this.bracketStack[this.bracketStack.length - 1];
					switch( (_g)[1] ) {
					case 1:
						return { block : erazor.TBlock.literal(this.escapeLiteral(HxOverrides.substr(template,0,i))), length : i, start : this.pos};
					case 0:
						this.bracketStack.pop();
						break;
					}
				} else throw new erazor.error.ParserError(erazor.Parser.bracketMismatch,this.pos);
				break;
			case "{":
				this.bracketStack.push(erazor._Parser.ParseContext.literal);
				break;
			}
		}
		return { block : erazor.TBlock.literal(this.escapeLiteral(template)), length : len, start : this.pos};
	}
	,parseString: function(str,modifier,throwAtEnd) {
		var insideSingleQuote = false;
		var insideDoubleQuote = false;
		var i = -1;
		while(++i < str.length) {
			var $char = str.charAt(i);
			if(!insideDoubleQuote && !insideSingleQuote) {
				var _g = modifier($char);
				switch( (_g)[1] ) {
				case 1:
					return HxOverrides.substr(str,0,i + 1);
				case 2:
					return HxOverrides.substr(str,0,i);
				case 0:
					break;
				}
				if($char == "\"") insideDoubleQuote = true; else if($char == "'") insideSingleQuote = true;
			} else if(insideDoubleQuote && $char == "\"" && str.charAt(i - 1) != "\\") insideDoubleQuote = false; else if(insideSingleQuote && $char == "'" && str.charAt(i - 1) != "\\") insideSingleQuote = false;
		}
		if(throwAtEnd) throw new erazor.error.ParserError("Failed to find a closing delimiter: ",this.pos,HxOverrides.substr(str,0,100));
		return str;
	}
	,parseCodeBlock: function(template) {
		if(this.bracketStack.length > 0 && this.peek(template) == "}") {
			if(this.inConditionalMatch.match(template)) {
				var str = this.parseScriptPart(template,"","{");
				return { block : erazor.TBlock.codeBlock(str), length : str.length, start : this.pos};
			}
			if((function($this) {
				var $r;
				var _g = $this.bracketStack.pop();
				$r = (function($this) {
					var $r;
					switch( (_g)[1] ) {
					case 1:
						$r = --$this.conditionalStack < 0;
						break;
					default:
						$r = true;
					}
					return $r;
				}($this));
				return $r;
			}(this))) throw new erazor.error.ParserError(erazor.Parser.bracketMismatch,this.pos);
			return { block : erazor.TBlock.codeBlock("}"), length : 1, start : this.pos};
		}
		if(this.condMatch.match(template)) {
			this.bracketStack.push(erazor._Parser.ParseContext.code);
			++this.conditionalStack;
			return this.parseConditional(template);
		}
		if(this.peek(template) == "@" && this.isIdentifier(this.peek(template,1))) return this.parseVariable(template);
		var startBrace = this.peek(template,1);
		var endBrace = startBrace == "{"?"}":")";
		var str = this.parseScriptPart(HxOverrides.substr(template,1,null),startBrace,endBrace);
		var noBraces = StringTools.trim(HxOverrides.substr(str,1,str.length - 2));
		if(startBrace == "{") return { block : erazor.TBlock.codeBlock(noBraces), length : str.length + 1, start : this.pos}; else return { block : erazor.TBlock.printBlock(noBraces), length : str.length + 1, start : this.pos};
	}
	,parseVariable: function(template) {
		var output = "";
		var $char = null;
		var part = null;
		template = HxOverrides.substr(template,1,null);
		do {
			part = this.acceptIdentifier(template);
			template = HxOverrides.substr(template,part.length,null);
			output += part;
			$char = this.peek(template);
			while($char == "(" || $char == "[") {
				part = this.acceptBracket(template,$char);
				template = HxOverrides.substr(template,part.length,null);
				output += part;
				$char = this.peek(template);
			}
			if($char == "." && this.isIdentifier(this.peek(template,1))) {
				template = HxOverrides.substr(template,1,null);
				output += ".";
			} else break;
		} while($char != null);
		return { block : erazor.TBlock.printBlock(output), length : output.length + 1, start : this.pos};
	}
	,peek: function(template,offset) {
		if(offset == null) offset = 0;
		return template.length > offset?template.charAt(offset):null;
	}
	,parseConditional: function(template) {
		var str = this.parseScriptPart(template,"","{");
		return { block : erazor.TBlock.codeBlock(HxOverrides.substr(str,1,null)), length : str.length, start : this.pos};
	}
	,parseBlock: function(template) {
		return this.context == erazor._Parser.ParseContext.code?this.parseCodeBlock(template):this.parseLiteral(template);
	}
	,acceptBracket: function(template,bracket) {
		return this.parseScriptPart(template,bracket,bracket == "("?")":"]");
	}
	,acceptIdentifier: function(template) {
		var first = true;
		var self = this;
		return this.accept(template,function(chr) {
			var status = self.isIdentifier(chr,first);
			first = false;
			return status;
		},false);
	}
	,isIdentifier: function($char,first) {
		if(first == null) first = true;
		return first?$char >= "a" && $char <= "z" || $char >= "A" && $char <= "Z" || $char == "_":$char >= "a" && $char <= "z" || $char >= "A" && $char <= "Z" || $char >= "0" && $char <= "9" || $char == "_";
	}
	,accept: function(template,acceptor,throwAtEnd) {
		return this.parseString(template,function(chr) {
			return acceptor(chr)?erazor._Parser.ParseResult.keepGoing:erazor._Parser.ParseResult.doneSkipCurrent;
		},throwAtEnd);
	}
	,parseContext: function(template) {
		if(this.peek(template) == erazor.Parser.at && this.peek(template,1) != erazor.Parser.at) return erazor._Parser.ParseContext.code;
		if(this.conditionalStack > 0 && this.peek(template) == "}") {
			var _g = this.bracketStack[this.bracketStack.length - 1];
			switch( (_g)[1] ) {
			case 1:
				return erazor._Parser.ParseContext.code;
			default:
			}
		}
		return erazor._Parser.ParseContext.literal;
	}
	,parseScriptPart: function(template,startBrace,endBrace) {
		var insideSingleQuote = false;
		var insideDoubleQuote = false;
		var stack = startBrace == ""?1:0;
		var i = -1;
		while(++i < template.length) {
			var $char = template.charAt(i);
			if(!insideDoubleQuote && !insideSingleQuote) {
				if($char == startBrace) ++stack; else if($char == endBrace) {
					--stack;
					if(stack == 0) return HxOverrides.substr(template,0,i + 1);
					if(stack < 0) throw new erazor.error.ParserError("Unbalanced braces for block: ",this.pos,HxOverrides.substr(template,0,100));
				} else if($char == "\"") insideDoubleQuote = true; else if($char == "'") insideSingleQuote = true;
			} else if(insideDoubleQuote && $char == "\"" && template.charAt(i - 1) != "\\") insideDoubleQuote = false; else if(insideSingleQuote && $char == "'" && template.charAt(i - 1) != "\\") insideSingleQuote = false;
		}
		throw new erazor.error.ParserError("Failed to find a closing delimiter for the script block: ",this.pos,HxOverrides.substr(template,0,100));
	}
	,pos: null
	,conditionalStack: null
	,bracketStack: null
	,context: null
	,variableChar: null
	,inConditionalMatch: null
	,condMatch: null
	,__class__: erazor.Parser
}
erazor.ScriptBuilder = function(context) {
	this.context = context;
};
$hxClasses["erazor.ScriptBuilder"] = erazor.ScriptBuilder;
erazor.ScriptBuilder.__name__ = ["erazor","ScriptBuilder"];
erazor.ScriptBuilder.prototype = {
	blockToString: function(block) {
		var $e = (block);
		switch( $e[1] ) {
		case 0:
			var s = $e[2];
			return this.context + ".add('" + StringTools.replace(s,"'","\\'") + "');\n";
		case 1:
			var s = $e[2];
			return s + "\n";
		case 2:
			var s = $e[2];
			return this.context + ".add(" + s + ");\n";
		}
	}
	,build: function(blocks) {
		var buffer = new StringBuf();
		var _g = 0;
		while(_g < blocks.length) {
			var block = blocks[_g];
			++_g;
			buffer.b += Std.string(this.blockToString(block));
		}
		return buffer.b;
	}
	,context: null
	,__class__: erazor.ScriptBuilder
}
erazor.TBlock = { __ename__ : ["erazor","TBlock"], __constructs__ : ["literal","codeBlock","printBlock"] }
erazor.TBlock.literal = function(s) { var $x = ["literal",0,s]; $x.__enum__ = erazor.TBlock; $x.toString = $estr; return $x; }
erazor.TBlock.codeBlock = function(s) { var $x = ["codeBlock",1,s]; $x.__enum__ = erazor.TBlock; $x.toString = $estr; return $x; }
erazor.TBlock.printBlock = function(s) { var $x = ["printBlock",2,s]; $x.__enum__ = erazor.TBlock; $x.toString = $estr; return $x; }
erazor.Template = function(template) {
	this.template = template;
};
$hxClasses["erazor.Template"] = erazor.Template;
erazor.Template.__name__ = ["erazor","Template"];
erazor.Template.prototype = {
	setInterpreterVars: function(interp,content) {
		if(js.Boot.__instanceof(content,haxe.ds.StringMap)) {
			var hash = content;
			var $it0 = hash.keys();
			while( $it0.hasNext() ) {
				var field = $it0.next();
				var value = hash.get(field);
				interp.variables.set(field,value);
			}
		} else {
			var _g = 0, _g1 = Reflect.fields(content);
			while(_g < _g1.length) {
				var field = _g1[_g];
				++_g;
				var value = Reflect.field(content,field);
				interp.variables.set(field,value);
			}
		}
	}
	,execute: function(content) {
		var buffer = new StringBuf();
		var parsedBlocks = new erazor.Parser().parse(this.template);
		var script = new erazor.ScriptBuilder("__b__").build(parsedBlocks);
		var parser = new hscript.Parser();
		var program = parser.parseString(script);
		var interp = new erazor.hscript.EnhancedInterp();
		this.variables = interp.variables;
		var bufferStack = [];
		this.setInterpreterVars(interp,content);
		interp.variables.set("__b__",buffer);
		interp.variables.set("__string_buf__",function(current) {
			bufferStack.push(current);
			return new StringBuf();
		});
		interp.variables.set("__restore_buf__",function() {
			return bufferStack.pop();
		});
		interp.execute(program);
		return buffer.b;
	}
	,variables: null
	,template: null
	,__class__: erazor.Template
}
erazor.error = {}
erazor.error.ParserError = function(msg,pos,excerpt) {
	this.msg = msg;
	this.pos = pos;
	this.excerpt = excerpt;
};
$hxClasses["erazor.error.ParserError"] = erazor.error.ParserError;
erazor.error.ParserError.__name__ = ["erazor","error","ParserError"];
erazor.error.ParserError.prototype = {
	toString: function() {
		var excerpt = this.excerpt;
		if(excerpt != null) {
			var nl = excerpt.indexOf("\n");
			if(nl != -1) excerpt = HxOverrides.substr(excerpt,0,nl);
		}
		return this.msg + " @ " + this.pos + (excerpt != null?" ( \"" + excerpt + "\" )":"");
	}
	,excerpt: null
	,pos: null
	,msg: null
	,__class__: erazor.error.ParserError
}
var hscript = {}
hscript.Interp = function() {
	this.locals = new haxe.ds.StringMap();
	this.variables = new haxe.ds.StringMap();
	this.declared = new Array();
	this.variables.set("null",null);
	this.variables.set("true",true);
	this.variables.set("false",false);
	this.variables.set("trace",function(e) {
		haxe.Log.trace(Std.string(e),{ fileName : "hscript", lineNumber : 0});
	});
	this.initOps();
};
$hxClasses["hscript.Interp"] = hscript.Interp;
hscript.Interp.__name__ = ["hscript","Interp"];
hscript.Interp.prototype = {
	cnew: function(cl,args) {
		var c = Type.resolveClass(cl);
		if(c == null) c = this.resolve(cl);
		return Type.createInstance(c,args);
	}
	,call: function(o,f,args) {
		return f.apply(o,args);
	}
	,set: function(o,f,v) {
		if(o == null) throw hscript.Error.EInvalidAccess(f);
		o[f] = v;
		return v;
	}
	,get: function(o,f) {
		if(o == null) throw hscript.Error.EInvalidAccess(f);
		return Reflect.field(o,f);
	}
	,forLoop: function(n,it,e) {
		var old = this.declared.length;
		this.declared.push({ n : n, old : this.locals.get(n)});
		var it1 = this.makeIterator(this.expr(it));
		try {
			while(it1.hasNext()) {
				this.locals.set(n,{ r : it1.next()});
				try {
					this.expr(e);
				} catch( err ) {
					if( js.Boot.__instanceof(err,hscript._Interp.Stop) ) {
						switch( (err)[1] ) {
						case 1:
							break;
						case 0:
							throw "__break__";
							break;
						case 2:
							throw err;
							break;
						}
					} else throw(err);
				}
			}
		} catch( e ) { if( e != "__break__" ) throw e; }
		this.restore(old);
	}
	,makeIterator: function(v) {
		try {
			v = $iterator(v)();
		} catch( e ) {
		}
		if(v.hasNext == null || v.next == null) throw hscript.Error.EInvalidIterator(v);
		return v;
	}
	,whileLoop: function(econd,e) {
		var old = this.declared.length;
		try {
			while(this.expr(econd) == true) try {
				this.expr(e);
			} catch( err ) {
				if( js.Boot.__instanceof(err,hscript._Interp.Stop) ) {
					switch( (err)[1] ) {
					case 1:
						break;
					case 0:
						throw "__break__";
						break;
					case 2:
						throw err;
						break;
					}
				} else throw(err);
			}
		} catch( e ) { if( e != "__break__" ) throw e; }
		this.restore(old);
	}
	,expr: function(e) {
		var $e = (e);
		switch( $e[1] ) {
		case 0:
			var c = $e[2];
			var $e = (c);
			switch( $e[1] ) {
			case 0:
				var v = $e[2];
				return v;
			case 1:
				var f = $e[2];
				return f;
			case 2:
				var s = $e[2];
				return s;
			}
			break;
		case 1:
			var id = $e[2];
			return this.resolve(id);
		case 2:
			var e1 = $e[4], e_eEVar_1 = $e[3], n = $e[2];
			this.declared.push({ n : n, old : this.locals.get(n)});
			this.locals.set(n,{ r : e1 == null?null:this.expr(e1)});
			return null;
		case 3:
			var e1 = $e[2];
			return this.expr(e1);
		case 4:
			var exprs = $e[2];
			var old = this.declared.length;
			var v = null;
			var _g = 0;
			while(_g < exprs.length) {
				var e1 = exprs[_g];
				++_g;
				v = this.expr(e1);
			}
			this.restore(old);
			return v;
		case 5:
			var f = $e[3], e1 = $e[2];
			return this.get(this.expr(e1),f);
		case 6:
			var e2 = $e[4], e1 = $e[3], op = $e[2];
			var fop = this.binops.get(op);
			if(fop == null) throw hscript.Error.EInvalidOp(op);
			return fop(e1,e2);
		case 7:
			var e1 = $e[4], prefix = $e[3], op = $e[2];
			switch(op) {
			case "!":
				return this.expr(e1) != true;
			case "-":
				return -this.expr(e1);
			case "++":
				return this.increment(e1,prefix,1);
			case "--":
				return this.increment(e1,prefix,-1);
			case "~":
				return ~this.expr(e1);
			default:
				throw hscript.Error.EInvalidOp(op);
			}
			break;
		case 8:
			var params = $e[3], e1 = $e[2];
			var args = new Array();
			var _g = 0;
			while(_g < params.length) {
				var p = params[_g];
				++_g;
				args.push(this.expr(p));
			}
			var $e = (e1);
			switch( $e[1] ) {
			case 5:
				var f = $e[3], e2 = $e[2];
				var obj = this.expr(e2);
				if(obj == null) throw hscript.Error.EInvalidAccess(f);
				return this.call(obj,Reflect.field(obj,f),args);
			default:
				return this.call(null,this.expr(e1),args);
			}
			break;
		case 9:
			var e2 = $e[4], e1 = $e[3], econd = $e[2];
			return this.expr(econd) == true?this.expr(e1):e2 == null?null:this.expr(e2);
		case 10:
			var e1 = $e[3], econd = $e[2];
			this.whileLoop(econd,e1);
			return null;
		case 11:
			var e1 = $e[4], it = $e[3], v = $e[2];
			this.forLoop(v,it,e1);
			return null;
		case 12:
			throw hscript._Interp.Stop.SBreak;
			break;
		case 13:
			throw hscript._Interp.Stop.SContinue;
			break;
		case 15:
			var e1 = $e[2];
			throw hscript._Interp.Stop.SReturn(e1 == null?null:this.expr(e1));
			break;
		case 14:
			var e_eEFunction_3 = $e[5], name = $e[4], fexpr = $e[3], params1 = $e[2];
			var capturedLocals = this.duplicate(this.locals);
			var me = this;
			var f = function(args) {
				if(args.length != params1.length) throw "Invalid number of parameters";
				var old = me.locals;
				me.locals = me.duplicate(capturedLocals);
				var _g1 = 0, _g = params1.length;
				while(_g1 < _g) {
					var i = _g1++;
					me.locals.set(params1[i].name,{ r : args[i]});
				}
				var r = null;
				try {
					r = me.exprReturn(fexpr);
				} catch( e1 ) {
					me.locals = old;
					throw e1;
				}
				me.locals = old;
				return r;
			};
			var f1 = Reflect.makeVarArgs(f);
			if(name != null) this.variables.set(name,f1);
			return f1;
		case 17:
			var arr = $e[2];
			var a = new Array();
			var _g = 0;
			while(_g < arr.length) {
				var e1 = arr[_g];
				++_g;
				a.push(this.expr(e1));
			}
			return a;
		case 16:
			var index = $e[3], e1 = $e[2];
			return this.expr(e1)[this.expr(index)];
		case 18:
			var params = $e[3], cl = $e[2];
			var a = new Array();
			var _g = 0;
			while(_g < params.length) {
				var e1 = params[_g];
				++_g;
				a.push(this.expr(e1));
			}
			return this.cnew(cl,a);
		case 19:
			var e1 = $e[2];
			throw this.expr(e1);
			break;
		case 20:
			var ecatch = $e[5], e_eETry_2 = $e[4], n = $e[3], e1 = $e[2];
			var old = this.declared.length;
			try {
				var v = this.expr(e1);
				this.restore(old);
				return v;
			} catch( $e0 ) {
				if( js.Boot.__instanceof($e0,hscript._Interp.Stop) ) {
					var err = $e0;
					throw err;
				} else {
				var err = $e0;
				this.restore(old);
				this.declared.push({ n : n, old : this.locals.get(n)});
				this.locals.set(n,{ r : err});
				var v = this.expr(ecatch);
				this.restore(old);
				return v;
				}
			}
			break;
		case 21:
			var fl = $e[2];
			var o = { };
			var _g = 0;
			while(_g < fl.length) {
				var f = fl[_g];
				++_g;
				this.set(o,f.name,this.expr(f.e));
			}
			return o;
		case 22:
			var e2 = $e[4], e1 = $e[3], econd = $e[2];
			return this.expr(econd) == true?this.expr(e1):this.expr(e2);
		}
		return null;
	}
	,resolve: function(id) {
		var l = this.locals.get(id);
		if(l != null) return l.r;
		var v = this.variables.get(id);
		if(v == null && !this.variables.exists(id)) throw hscript.Error.EUnknownVariable(id);
		return v;
	}
	,restore: function(old) {
		while(this.declared.length > old) {
			var d = this.declared.pop();
			this.locals.set(d.n,d.old);
		}
	}
	,duplicate: function(h) {
		var h2 = new haxe.ds.StringMap();
		var $it0 = h.keys();
		while( $it0.hasNext() ) {
			var k = $it0.next();
			h2.set(k,h.get(k));
		}
		return h2;
	}
	,exprReturn: function(e) {
		try {
			return this.expr(e);
		} catch( e1 ) {
			if( js.Boot.__instanceof(e1,hscript._Interp.Stop) ) {
				var $e = (e1);
				switch( $e[1] ) {
				case 0:
					throw "Invalid break";
					break;
				case 1:
					throw "Invalid continue";
					break;
				case 2:
					var v = $e[2];
					return v;
				}
			} else throw(e1);
		}
		return null;
	}
	,execute: function(expr) {
		this.locals = new haxe.ds.StringMap();
		return this.exprReturn(expr);
	}
	,increment: function(e,prefix,delta) {
		var $e = (e);
		switch( $e[1] ) {
		case 1:
			var id = $e[2];
			var l = this.locals.get(id);
			var v = l == null?this.variables.get(id):l.r;
			if(prefix) {
				v += delta;
				if(l == null) {
					var value = v;
					this.variables.set(id,value);
				} else l.r = v;
			} else if(l == null) {
				var value = v + delta;
				this.variables.set(id,value);
			} else l.r = v + delta;
			return v;
		case 5:
			var f = $e[3], e1 = $e[2];
			var obj = this.expr(e1);
			var v = this.get(obj,f);
			if(prefix) {
				v += delta;
				this.set(obj,f,v);
			} else this.set(obj,f,v + delta);
			return v;
		case 16:
			var index = $e[3], e1 = $e[2];
			var arr = this.expr(e1);
			var index1 = this.expr(index);
			var v = arr[index1];
			if(prefix) {
				v += delta;
				arr[index1] = v;
			} else arr[index1] = v + delta;
			return v;
		default:
			throw hscript.Error.EInvalidOp(delta > 0?"++":"--");
		}
	}
	,evalAssignOp: function(op,fop,e1,e2) {
		var v;
		var $e = (e1);
		switch( $e[1] ) {
		case 1:
			var id = $e[2];
			var l = this.locals.get(id);
			v = fop(this.expr(e1),this.expr(e2));
			if(l == null) this.variables.set(id,v); else l.r = v;
			break;
		case 5:
			var f = $e[3], e = $e[2];
			var obj = this.expr(e);
			v = fop(this.get(obj,f),this.expr(e2));
			v = this.set(obj,f,v);
			break;
		case 16:
			var index = $e[3], e = $e[2];
			var arr = this.expr(e);
			var index1 = this.expr(index);
			v = fop(arr[index1],this.expr(e2));
			arr[index1] = v;
			break;
		default:
			throw hscript.Error.EInvalidOp(op);
		}
		return v;
	}
	,assignOp: function(op,fop) {
		var me = this;
		this.binops.set(op,function(e1,e2) {
			return me.evalAssignOp(op,fop,e1,e2);
		});
	}
	,assign: function(e1,e2) {
		var v = this.expr(e2);
		var $e = (e1);
		switch( $e[1] ) {
		case 1:
			var id = $e[2];
			var l = this.locals.get(id);
			if(l == null) this.variables.set(id,v); else l.r = v;
			break;
		case 5:
			var f = $e[3], e = $e[2];
			v = this.set(this.expr(e),f,v);
			break;
		case 16:
			var index = $e[3], e = $e[2];
			this.expr(e)[this.expr(index)] = v;
			break;
		default:
			throw hscript.Error.EInvalidOp("=");
		}
		return v;
	}
	,initOps: function() {
		var me = this;
		this.binops = new haxe.ds.StringMap();
		this.binops.set("+",function(e1,e2) {
			return me.expr(e1) + me.expr(e2);
		});
		this.binops.set("-",function(e1,e2) {
			return me.expr(e1) - me.expr(e2);
		});
		this.binops.set("*",function(e1,e2) {
			return me.expr(e1) * me.expr(e2);
		});
		this.binops.set("/",function(e1,e2) {
			return me.expr(e1) / me.expr(e2);
		});
		this.binops.set("%",function(e1,e2) {
			return me.expr(e1) % me.expr(e2);
		});
		this.binops.set("&",function(e1,e2) {
			return me.expr(e1) & me.expr(e2);
		});
		this.binops.set("|",function(e1,e2) {
			return me.expr(e1) | me.expr(e2);
		});
		this.binops.set("^",function(e1,e2) {
			return me.expr(e1) ^ me.expr(e2);
		});
		this.binops.set("<<",function(e1,e2) {
			return me.expr(e1) << me.expr(e2);
		});
		this.binops.set(">>",function(e1,e2) {
			return me.expr(e1) >> me.expr(e2);
		});
		this.binops.set(">>>",function(e1,e2) {
			return me.expr(e1) >>> me.expr(e2);
		});
		this.binops.set("==",function(e1,e2) {
			return me.expr(e1) == me.expr(e2);
		});
		this.binops.set("!=",function(e1,e2) {
			return me.expr(e1) != me.expr(e2);
		});
		this.binops.set(">=",function(e1,e2) {
			return me.expr(e1) >= me.expr(e2);
		});
		this.binops.set("<=",function(e1,e2) {
			return me.expr(e1) <= me.expr(e2);
		});
		this.binops.set(">",function(e1,e2) {
			return me.expr(e1) > me.expr(e2);
		});
		this.binops.set("<",function(e1,e2) {
			return me.expr(e1) < me.expr(e2);
		});
		this.binops.set("||",function(e1,e2) {
			return me.expr(e1) == true || me.expr(e2) == true;
		});
		this.binops.set("&&",function(e1,e2) {
			return me.expr(e1) == true && me.expr(e2) == true;
		});
		this.binops.set("=",$bind(this,this.assign));
		this.binops.set("...",function(e1,e2) {
			return new IntIterator(me.expr(e1),me.expr(e2));
		});
		this.assignOp("+=",function(v1,v2) {
			return v1 + v2;
		});
		this.assignOp("-=",function(v1,v2) {
			return v1 - v2;
		});
		this.assignOp("*=",function(v1,v2) {
			return v1 * v2;
		});
		this.assignOp("/=",function(v1,v2) {
			return v1 / v2;
		});
		this.assignOp("%=",function(v1,v2) {
			return v1 % v2;
		});
		this.assignOp("&=",function(v1,v2) {
			return v1 & v2;
		});
		this.assignOp("|=",function(v1,v2) {
			return v1 | v2;
		});
		this.assignOp("^=",function(v1,v2) {
			return v1 ^ v2;
		});
		this.assignOp("<<=",function(v1,v2) {
			return v1 << v2;
		});
		this.assignOp(">>=",function(v1,v2) {
			return v1 >> v2;
		});
		this.assignOp(">>>=",function(v1,v2) {
			return v1 >>> v2;
		});
	}
	,declared: null
	,binops: null
	,locals: null
	,variables: null
	,__class__: hscript.Interp
}
erazor.hscript = {}
erazor.hscript.EnhancedInterp = function() {
	hscript.Interp.call(this);
	var add = ($_=new StringBuf(),$bind($_,$_.add));
};
$hxClasses["erazor.hscript.EnhancedInterp"] = erazor.hscript.EnhancedInterp;
erazor.hscript.EnhancedInterp.__name__ = ["erazor","hscript","EnhancedInterp"];
erazor.hscript.EnhancedInterp.__super__ = hscript.Interp;
erazor.hscript.EnhancedInterp.prototype = $extend(hscript.Interp.prototype,{
	call: function(o,f,args) {
		args = args.concat([null,null,null,null,null]);
		return f.apply(o,args);
	}
	,get: function(o,f) {
		if(o == null) throw hscript.Error.EInvalidAccess(f);
		return Reflect.field(o,f);
	}
	,__class__: erazor.hscript.EnhancedInterp
});
var haxe = {}
haxe.Http = function(url) {
	this.url = url;
	this.headers = new haxe.ds.StringMap();
	this.params = new haxe.ds.StringMap();
	this.async = true;
};
$hxClasses["haxe.Http"] = haxe.Http;
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
		me.responseData = null;
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
			if(s != null && s >= 200 && s < 400) me.onData(me.responseData = r.responseText); else if(s == null) me.onError("Failed to connect or resolve host"); else switch(s) {
			case 12029:
				me.onError("Failed to connect to host");
				break;
			case 12007:
				me.onError("Unknown host");
				break;
			default:
				me.responseData = r.responseText;
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
	,setParameter: function(param,value) {
		this.params.set(param,value);
		return this;
	}
	,setHeader: function(header,value) {
		this.headers.set(header,value);
		return this;
	}
	,params: null
	,headers: null
	,postData: null
	,async: null
	,responseData: null
	,url: null
	,__class__: haxe.Http
}
haxe.Log = function() { }
$hxClasses["haxe.Log"] = haxe.Log;
haxe.Log.__name__ = ["haxe","Log"];
haxe.Log.trace = function(v,infos) {
	js.Boot.__trace(v,infos);
}
haxe.Timer = function(time_ms) {
	var me = this;
	this.id = setInterval(function() {
		me.run();
	},time_ms);
};
$hxClasses["haxe.Timer"] = haxe.Timer;
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
		null;
	}
	,stop: function() {
		if(this.id == null) return;
		clearInterval(this.id);
		this.id = null;
	}
	,id: null
	,__class__: haxe.Timer
}
haxe.crypto = {}
haxe.crypto.Md5 = function() {
};
$hxClasses["haxe.crypto.Md5"] = haxe.crypto.Md5;
haxe.crypto.Md5.__name__ = ["haxe","crypto","Md5"];
haxe.crypto.Md5.encode = function(s) {
	var m = new haxe.crypto.Md5();
	var h = m.doEncode(haxe.crypto.Md5.str2blks(s));
	return m.hex(h);
}
haxe.crypto.Md5.str2blks = function(str) {
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
haxe.crypto.Md5.prototype = {
	doEncode: function(x) {
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
		return [a,b,c,d];
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
	,hex: function(a) {
		var str = "";
		var hex_chr = "0123456789abcdef";
		var _g = 0;
		while(_g < a.length) {
			var num = a[_g];
			++_g;
			var _g1 = 0;
			while(_g1 < 4) {
				var j = _g1++;
				str += hex_chr.charAt(num >> j * 8 + 4 & 15) + hex_chr.charAt(num >> j * 8 & 15);
			}
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
	,__class__: haxe.crypto.Md5
}
haxe.ds = {}
haxe.ds.GenericCell = function(elt,next) {
	this.elt = elt;
	this.next = next;
};
$hxClasses["haxe.ds.GenericCell"] = haxe.ds.GenericCell;
haxe.ds.GenericCell.__name__ = ["haxe","ds","GenericCell"];
haxe.ds.GenericCell.prototype = {
	next: null
	,elt: null
	,__class__: haxe.ds.GenericCell
}
haxe.ds.GenericStack = function() {
};
$hxClasses["haxe.ds.GenericStack"] = haxe.ds.GenericStack;
haxe.ds.GenericStack.__name__ = ["haxe","ds","GenericStack"];
haxe.ds.GenericStack.prototype = {
	pop: function() {
		var k = this.head;
		if(k == null) return null; else {
			this.head = k.next;
			return k.elt;
		}
	}
	,add: function(item) {
		this.head = new haxe.ds.GenericCell(item,this.head);
	}
	,head: null
	,__class__: haxe.ds.GenericStack
}
haxe.ds.IntMap = function() {
	this.h = { };
};
$hxClasses["haxe.ds.IntMap"] = haxe.ds.IntMap;
haxe.ds.IntMap.__name__ = ["haxe","ds","IntMap"];
haxe.ds.IntMap.__interfaces__ = [IMap];
haxe.ds.IntMap.prototype = {
	iterator: function() {
		return { ref : this.h, it : this.keys(), hasNext : function() {
			return this.it.hasNext();
		}, next : function() {
			var i = this.it.next();
			return this.ref[i];
		}};
	}
	,keys: function() {
		var a = [];
		for( var key in this.h ) {
		if(this.h.hasOwnProperty(key)) a.push(key | 0);
		}
		return HxOverrides.iter(a);
	}
	,remove: function(key) {
		if(!this.h.hasOwnProperty(key)) return false;
		delete(this.h[key]);
		return true;
	}
	,get: function(key) {
		return this.h[key];
	}
	,set: function(key,value) {
		this.h[key] = value;
	}
	,h: null
	,__class__: haxe.ds.IntMap
}
haxe.ds.StringMap = function() {
	this.h = { };
};
$hxClasses["haxe.ds.StringMap"] = haxe.ds.StringMap;
haxe.ds.StringMap.__name__ = ["haxe","ds","StringMap"];
haxe.ds.StringMap.__interfaces__ = [IMap];
haxe.ds.StringMap.prototype = {
	iterator: function() {
		return { ref : this.h, it : this.keys(), hasNext : function() {
			return this.it.hasNext();
		}, next : function() {
			var i = this.it.next();
			return this.ref["$" + i];
		}};
	}
	,keys: function() {
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
	,__class__: haxe.ds.StringMap
}
haxe.io = {}
haxe.io.Bytes = function(length,b) {
	this.length = length;
	this.b = b;
};
$hxClasses["haxe.io.Bytes"] = haxe.io.Bytes;
haxe.io.Bytes.__name__ = ["haxe","io","Bytes"];
haxe.io.Bytes.alloc = function(length) {
	var a = new Array();
	var _g = 0;
	while(_g < length) {
		var i = _g++;
		a.push(0);
	}
	return new haxe.io.Bytes(length,a);
}
haxe.io.Bytes.ofString = function(s) {
	var a = new Array();
	var _g1 = 0, _g = s.length;
	while(_g1 < _g) {
		var i = _g1++;
		var c = HxOverrides.cca(s,i);
		if(c <= 127) a.push(c); else if(c <= 2047) {
			a.push(192 | c >> 6);
			a.push(128 | c & 63);
		} else if(c <= 65535) {
			a.push(224 | c >> 12);
			a.push(128 | c >> 6 & 63);
			a.push(128 | c & 63);
		} else {
			a.push(240 | c >> 18);
			a.push(128 | c >> 12 & 63);
			a.push(128 | c >> 6 & 63);
			a.push(128 | c & 63);
		}
	}
	return new haxe.io.Bytes(a.length,a);
}
haxe.io.Bytes.prototype = {
	toString: function() {
		return this.readString(0,this.length);
	}
	,readString: function(pos,len) {
		if(pos < 0 || len < 0 || pos + len > this.length) throw haxe.io.Error.OutsideBounds;
		var s = "";
		var b = this.b;
		var fcc = String.fromCharCode;
		var i = pos;
		var max = pos + len;
		while(i < max) {
			var c = b[i++];
			if(c < 128) {
				if(c == 0) break;
				s += fcc(c);
			} else if(c < 224) s += fcc((c & 63) << 6 | b[i++] & 127); else if(c < 240) {
				var c2 = b[i++];
				s += fcc((c & 31) << 12 | (c2 & 127) << 6 | b[i++] & 127);
			} else {
				var c2 = b[i++];
				var c3 = b[i++];
				s += fcc((c & 15) << 18 | (c2 & 127) << 12 | c3 << 6 & 127 | b[i++] & 127);
			}
		}
		return s;
	}
	,b: null
	,length: null
	,__class__: haxe.io.Bytes
}
haxe.io.BytesBuffer = function() {
	this.b = new Array();
};
$hxClasses["haxe.io.BytesBuffer"] = haxe.io.BytesBuffer;
haxe.io.BytesBuffer.__name__ = ["haxe","io","BytesBuffer"];
haxe.io.BytesBuffer.prototype = {
	getBytes: function() {
		var bytes = new haxe.io.Bytes(this.b.length,this.b);
		this.b = null;
		return bytes;
	}
	,b: null
	,__class__: haxe.io.BytesBuffer
}
haxe.io.Input = function() { }
$hxClasses["haxe.io.Input"] = haxe.io.Input;
haxe.io.Input.__name__ = ["haxe","io","Input"];
haxe.io.Input.prototype = {
	readString: function(len) {
		var b = haxe.io.Bytes.alloc(len);
		this.readFullBytes(b,0,len);
		return b.toString();
	}
	,readFullBytes: function(s,pos,len) {
		while(len > 0) {
			var k = this.readBytes(s,pos,len);
			pos += k;
			len -= k;
		}
	}
	,readBytes: function(s,pos,len) {
		var k = len;
		var b = s.b;
		if(pos < 0 || len < 0 || pos + len > s.length) throw haxe.io.Error.OutsideBounds;
		while(k > 0) {
			b[pos] = this.readByte();
			pos++;
			k--;
		}
		return len;
	}
	,readByte: function() {
		return (function($this) {
			var $r;
			throw "Not implemented";
			return $r;
		}(this));
	}
	,__class__: haxe.io.Input
}
haxe.io.BytesInput = function(b,pos,len) {
	if(pos == null) pos = 0;
	if(len == null) len = b.length - pos;
	if(pos < 0 || len < 0 || pos + len > b.length) throw haxe.io.Error.OutsideBounds;
	this.b = b.b;
	this.pos = pos;
	this.len = len;
};
$hxClasses["haxe.io.BytesInput"] = haxe.io.BytesInput;
haxe.io.BytesInput.__name__ = ["haxe","io","BytesInput"];
haxe.io.BytesInput.__super__ = haxe.io.Input;
haxe.io.BytesInput.prototype = $extend(haxe.io.Input.prototype,{
	readBytes: function(buf,pos,len) {
		if(pos < 0 || len < 0 || pos + len > buf.length) throw haxe.io.Error.OutsideBounds;
		if(this.len == 0 && len > 0) throw new haxe.io.Eof();
		if(this.len < len) len = this.len;
		var b1 = this.b;
		var b2 = buf.b;
		var _g = 0;
		while(_g < len) {
			var i = _g++;
			b2[pos + i] = b1[this.pos + i];
		}
		this.pos += len;
		this.len -= len;
		return len;
	}
	,readByte: function() {
		if(this.len == 0) throw new haxe.io.Eof();
		this.len--;
		return this.b[this.pos++];
	}
	,len: null
	,pos: null
	,b: null
	,__class__: haxe.io.BytesInput
});
haxe.io.Output = function() { }
$hxClasses["haxe.io.Output"] = haxe.io.Output;
haxe.io.Output.__name__ = ["haxe","io","Output"];
haxe.io.BytesOutput = function() {
	this.b = new haxe.io.BytesBuffer();
};
$hxClasses["haxe.io.BytesOutput"] = haxe.io.BytesOutput;
haxe.io.BytesOutput.__name__ = ["haxe","io","BytesOutput"];
haxe.io.BytesOutput.__super__ = haxe.io.Output;
haxe.io.BytesOutput.prototype = $extend(haxe.io.Output.prototype,{
	getBytes: function() {
		return this.b.getBytes();
	}
	,writeByte: function(c) {
		this.b.b.push(c);
	}
	,b: null
	,__class__: haxe.io.BytesOutput
});
haxe.io.Eof = function() {
};
$hxClasses["haxe.io.Eof"] = haxe.io.Eof;
haxe.io.Eof.__name__ = ["haxe","io","Eof"];
haxe.io.Eof.prototype = {
	toString: function() {
		return "Eof";
	}
	,__class__: haxe.io.Eof
}
haxe.io.Error = { __ename__ : ["haxe","io","Error"], __constructs__ : ["Blocked","Overflow","OutsideBounds","Custom"] }
haxe.io.Error.Blocked = ["Blocked",0];
haxe.io.Error.Blocked.toString = $estr;
haxe.io.Error.Blocked.__enum__ = haxe.io.Error;
haxe.io.Error.Overflow = ["Overflow",1];
haxe.io.Error.Overflow.toString = $estr;
haxe.io.Error.Overflow.__enum__ = haxe.io.Error;
haxe.io.Error.OutsideBounds = ["OutsideBounds",2];
haxe.io.Error.OutsideBounds.toString = $estr;
haxe.io.Error.OutsideBounds.__enum__ = haxe.io.Error;
haxe.io.Error.Custom = function(e) { var $x = ["Custom",3,e]; $x.__enum__ = haxe.io.Error; $x.toString = $estr; return $x; }
haxe.io.StringInput = function(s) {
	haxe.io.BytesInput.call(this,haxe.io.Bytes.ofString(s));
};
$hxClasses["haxe.io.StringInput"] = haxe.io.StringInput;
haxe.io.StringInput.__name__ = ["haxe","io","StringInput"];
haxe.io.StringInput.__super__ = haxe.io.BytesInput;
haxe.io.StringInput.prototype = $extend(haxe.io.BytesInput.prototype,{
	__class__: haxe.io.StringInput
});
hscript.Const = { __ename__ : ["hscript","Const"], __constructs__ : ["CInt","CFloat","CString"] }
hscript.Const.CInt = function(v) { var $x = ["CInt",0,v]; $x.__enum__ = hscript.Const; $x.toString = $estr; return $x; }
hscript.Const.CFloat = function(f) { var $x = ["CFloat",1,f]; $x.__enum__ = hscript.Const; $x.toString = $estr; return $x; }
hscript.Const.CString = function(s) { var $x = ["CString",2,s]; $x.__enum__ = hscript.Const; $x.toString = $estr; return $x; }
hscript.Expr = { __ename__ : ["hscript","Expr"], __constructs__ : ["EConst","EIdent","EVar","EParent","EBlock","EField","EBinop","EUnop","ECall","EIf","EWhile","EFor","EBreak","EContinue","EFunction","EReturn","EArray","EArrayDecl","ENew","EThrow","ETry","EObject","ETernary"] }
hscript.Expr.EConst = function(c) { var $x = ["EConst",0,c]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EIdent = function(v) { var $x = ["EIdent",1,v]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EVar = function(n,t,e) { var $x = ["EVar",2,n,t,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EParent = function(e) { var $x = ["EParent",3,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EBlock = function(e) { var $x = ["EBlock",4,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EField = function(e,f) { var $x = ["EField",5,e,f]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EBinop = function(op,e1,e2) { var $x = ["EBinop",6,op,e1,e2]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EUnop = function(op,prefix,e) { var $x = ["EUnop",7,op,prefix,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.ECall = function(e,params) { var $x = ["ECall",8,e,params]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EIf = function(cond,e1,e2) { var $x = ["EIf",9,cond,e1,e2]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EWhile = function(cond,e) { var $x = ["EWhile",10,cond,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EFor = function(v,it,e) { var $x = ["EFor",11,v,it,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EBreak = ["EBreak",12];
hscript.Expr.EBreak.toString = $estr;
hscript.Expr.EBreak.__enum__ = hscript.Expr;
hscript.Expr.EContinue = ["EContinue",13];
hscript.Expr.EContinue.toString = $estr;
hscript.Expr.EContinue.__enum__ = hscript.Expr;
hscript.Expr.EFunction = function(args,e,name,ret) { var $x = ["EFunction",14,args,e,name,ret]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EReturn = function(e) { var $x = ["EReturn",15,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EArray = function(e,index) { var $x = ["EArray",16,e,index]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EArrayDecl = function(e) { var $x = ["EArrayDecl",17,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.ENew = function(cl,params) { var $x = ["ENew",18,cl,params]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EThrow = function(e) { var $x = ["EThrow",19,e]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.ETry = function(e,v,t,ecatch) { var $x = ["ETry",20,e,v,t,ecatch]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.EObject = function(fl) { var $x = ["EObject",21,fl]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.Expr.ETernary = function(cond,e1,e2) { var $x = ["ETernary",22,cond,e1,e2]; $x.__enum__ = hscript.Expr; $x.toString = $estr; return $x; }
hscript.CType = { __ename__ : ["hscript","CType"], __constructs__ : ["CTPath","CTFun","CTAnon","CTParent"] }
hscript.CType.CTPath = function(path,params) { var $x = ["CTPath",0,path,params]; $x.__enum__ = hscript.CType; $x.toString = $estr; return $x; }
hscript.CType.CTFun = function(args,ret) { var $x = ["CTFun",1,args,ret]; $x.__enum__ = hscript.CType; $x.toString = $estr; return $x; }
hscript.CType.CTAnon = function(fields) { var $x = ["CTAnon",2,fields]; $x.__enum__ = hscript.CType; $x.toString = $estr; return $x; }
hscript.CType.CTParent = function(t) { var $x = ["CTParent",3,t]; $x.__enum__ = hscript.CType; $x.toString = $estr; return $x; }
hscript.Error = { __ename__ : ["hscript","Error"], __constructs__ : ["EInvalidChar","EUnexpected","EUnterminatedString","EUnterminatedComment","EUnknownVariable","EInvalidIterator","EInvalidOp","EInvalidAccess"] }
hscript.Error.EInvalidChar = function(c) { var $x = ["EInvalidChar",0,c]; $x.__enum__ = hscript.Error; $x.toString = $estr; return $x; }
hscript.Error.EUnexpected = function(s) { var $x = ["EUnexpected",1,s]; $x.__enum__ = hscript.Error; $x.toString = $estr; return $x; }
hscript.Error.EUnterminatedString = ["EUnterminatedString",2];
hscript.Error.EUnterminatedString.toString = $estr;
hscript.Error.EUnterminatedString.__enum__ = hscript.Error;
hscript.Error.EUnterminatedComment = ["EUnterminatedComment",3];
hscript.Error.EUnterminatedComment.toString = $estr;
hscript.Error.EUnterminatedComment.__enum__ = hscript.Error;
hscript.Error.EUnknownVariable = function(v) { var $x = ["EUnknownVariable",4,v]; $x.__enum__ = hscript.Error; $x.toString = $estr; return $x; }
hscript.Error.EInvalidIterator = function(v) { var $x = ["EInvalidIterator",5,v]; $x.__enum__ = hscript.Error; $x.toString = $estr; return $x; }
hscript.Error.EInvalidOp = function(op) { var $x = ["EInvalidOp",6,op]; $x.__enum__ = hscript.Error; $x.toString = $estr; return $x; }
hscript.Error.EInvalidAccess = function(f) { var $x = ["EInvalidAccess",7,f]; $x.__enum__ = hscript.Error; $x.toString = $estr; return $x; }
hscript._Interp = {}
hscript._Interp.Stop = { __ename__ : ["hscript","_Interp","Stop"], __constructs__ : ["SBreak","SContinue","SReturn"] }
hscript._Interp.Stop.SBreak = ["SBreak",0];
hscript._Interp.Stop.SBreak.toString = $estr;
hscript._Interp.Stop.SBreak.__enum__ = hscript._Interp.Stop;
hscript._Interp.Stop.SContinue = ["SContinue",1];
hscript._Interp.Stop.SContinue.toString = $estr;
hscript._Interp.Stop.SContinue.__enum__ = hscript._Interp.Stop;
hscript._Interp.Stop.SReturn = function(v) { var $x = ["SReturn",2,v]; $x.__enum__ = hscript._Interp.Stop; $x.toString = $estr; return $x; }
hscript.Token = { __ename__ : ["hscript","Token"], __constructs__ : ["TEof","TConst","TId","TOp","TPOpen","TPClose","TBrOpen","TBrClose","TDot","TComma","TSemicolon","TBkOpen","TBkClose","TQuestion","TDoubleDot"] }
hscript.Token.TEof = ["TEof",0];
hscript.Token.TEof.toString = $estr;
hscript.Token.TEof.__enum__ = hscript.Token;
hscript.Token.TConst = function(c) { var $x = ["TConst",1,c]; $x.__enum__ = hscript.Token; $x.toString = $estr; return $x; }
hscript.Token.TId = function(s) { var $x = ["TId",2,s]; $x.__enum__ = hscript.Token; $x.toString = $estr; return $x; }
hscript.Token.TOp = function(s) { var $x = ["TOp",3,s]; $x.__enum__ = hscript.Token; $x.toString = $estr; return $x; }
hscript.Token.TPOpen = ["TPOpen",4];
hscript.Token.TPOpen.toString = $estr;
hscript.Token.TPOpen.__enum__ = hscript.Token;
hscript.Token.TPClose = ["TPClose",5];
hscript.Token.TPClose.toString = $estr;
hscript.Token.TPClose.__enum__ = hscript.Token;
hscript.Token.TBrOpen = ["TBrOpen",6];
hscript.Token.TBrOpen.toString = $estr;
hscript.Token.TBrOpen.__enum__ = hscript.Token;
hscript.Token.TBrClose = ["TBrClose",7];
hscript.Token.TBrClose.toString = $estr;
hscript.Token.TBrClose.__enum__ = hscript.Token;
hscript.Token.TDot = ["TDot",8];
hscript.Token.TDot.toString = $estr;
hscript.Token.TDot.__enum__ = hscript.Token;
hscript.Token.TComma = ["TComma",9];
hscript.Token.TComma.toString = $estr;
hscript.Token.TComma.__enum__ = hscript.Token;
hscript.Token.TSemicolon = ["TSemicolon",10];
hscript.Token.TSemicolon.toString = $estr;
hscript.Token.TSemicolon.__enum__ = hscript.Token;
hscript.Token.TBkOpen = ["TBkOpen",11];
hscript.Token.TBkOpen.toString = $estr;
hscript.Token.TBkOpen.__enum__ = hscript.Token;
hscript.Token.TBkClose = ["TBkClose",12];
hscript.Token.TBkClose.toString = $estr;
hscript.Token.TBkClose.__enum__ = hscript.Token;
hscript.Token.TQuestion = ["TQuestion",13];
hscript.Token.TQuestion.toString = $estr;
hscript.Token.TQuestion.__enum__ = hscript.Token;
hscript.Token.TDoubleDot = ["TDoubleDot",14];
hscript.Token.TDoubleDot.toString = $estr;
hscript.Token.TDoubleDot.__enum__ = hscript.Token;
hscript.Parser = function() {
	this.line = 1;
	this.opChars = "+*/-=!><&|^%~";
	this.identChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_";
	var priorities = [["%"],["*","/"],["+","-"],["<<",">>",">>>"],["|","&","^"],["==","!=",">","<",">=","<="],["..."],["&&"],["||"],["=","+=","-=","*=","/=","%=","<<=",">>=",">>>=","|=","&=","^="]];
	this.opPriority = new haxe.ds.StringMap();
	this.opRightAssoc = new haxe.ds.StringMap();
	this.unops = new haxe.ds.StringMap();
	var _g1 = 0, _g = priorities.length;
	while(_g1 < _g) {
		var i = _g1++;
		var _g2 = 0, _g3 = priorities[i];
		while(_g2 < _g3.length) {
			var x = _g3[_g2];
			++_g2;
			this.opPriority.set(x,i);
			if(i == 9) this.opRightAssoc.set(x,true);
		}
	}
	var _g = 0, _g1 = ["!","++","--","-","~"];
	while(_g < _g1.length) {
		var x = _g1[_g];
		++_g;
		this.unops.set(x,x == "++" || x == "--");
	}
};
$hxClasses["hscript.Parser"] = hscript.Parser;
hscript.Parser.__name__ = ["hscript","Parser"];
hscript.Parser.prototype = {
	tokenString: function(t) {
		return (function($this) {
			var $r;
			var $e = (t);
			switch( $e[1] ) {
			case 0:
				$r = "<eof>";
				break;
			case 1:
				var c = $e[2];
				$r = $this.constString(c);
				break;
			case 2:
				var s = $e[2];
				$r = s;
				break;
			case 3:
				var s = $e[2];
				$r = s;
				break;
			case 4:
				$r = "(";
				break;
			case 5:
				$r = ")";
				break;
			case 6:
				$r = "{";
				break;
			case 7:
				$r = "}";
				break;
			case 8:
				$r = ".";
				break;
			case 9:
				$r = ",";
				break;
			case 10:
				$r = ";";
				break;
			case 11:
				$r = "[";
				break;
			case 12:
				$r = "]";
				break;
			case 13:
				$r = "?";
				break;
			case 14:
				$r = ":";
				break;
			}
			return $r;
		}(this));
	}
	,constString: function(c) {
		return (function($this) {
			var $r;
			var $e = (c);
			switch( $e[1] ) {
			case 0:
				var v = $e[2];
				$r = Std.string(v);
				break;
			case 1:
				var f = $e[2];
				$r = Std.string(f);
				break;
			case 2:
				var s = $e[2];
				$r = s;
				break;
			}
			return $r;
		}(this));
	}
	,tokenComment: function(op,$char) {
		var c = HxOverrides.cca(op,1);
		var s = this.input;
		if(c == 47) {
			try {
				while($char != 10 && $char != 13) $char = s.readByte();
				this["char"] = $char;
			} catch( e ) {
			}
			return this.token();
		}
		if(c == 42) {
			var old = this.line;
			try {
				while(true) {
					while($char != 42) {
						if($char == 10) this.line++;
						$char = s.readByte();
					}
					$char = s.readByte();
					if($char == 47) break;
				}
			} catch( e ) {
				this.line = old;
				throw hscript.Error.EUnterminatedComment;
			}
			return this.token();
		}
		this["char"] = $char;
		return hscript.Token.TOp(op);
	}
	,token: function() {
		if(!(this.tokens.head == null)) return this.tokens.pop();
		var $char;
		if(this["char"] < 0) $char = this.readChar(); else {
			$char = this["char"];
			this["char"] = -1;
		}
		while(true) {
			switch($char) {
			case 0:
				return hscript.Token.TEof;
			case 32:case 9:case 13:
				break;
			case 10:
				this.line++;
				break;
			case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:
				var n = ($char - 48) * 1.0;
				var exp = 0.;
				while(true) {
					$char = this.readChar();
					exp *= 10;
					switch($char) {
					case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:
						n = n * 10 + ($char - 48);
						break;
					case 46:
						if(exp > 0) {
							if(exp == 10 && this.readChar() == 46) {
								this.tokens.add(hscript.Token.TOp("..."));
								var i = n | 0;
								return hscript.Token.TConst(i == n?hscript.Const.CInt(i):hscript.Const.CFloat(n));
							}
							this.invalidChar($char);
						}
						exp = 1.;
						break;
					case 120:
						if(n > 0 || exp > 0) this.invalidChar($char);
						var n1 = 0;
						while(true) {
							$char = this.readChar();
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:
								n1 = (n1 << 4) + $char - 48;
								break;
							case 65:case 66:case 67:case 68:case 69:case 70:
								n1 = (n1 << 4) + ($char - 55);
								break;
							case 97:case 98:case 99:case 100:case 101:case 102:
								n1 = (n1 << 4) + ($char - 87);
								break;
							default:
								this["char"] = $char;
								return hscript.Token.TConst(hscript.Const.CInt(n1));
							}
						}
						break;
					default:
						this["char"] = $char;
						var i = n | 0;
						return hscript.Token.TConst(exp > 0?hscript.Const.CFloat(n * 10 / exp):i == n?hscript.Const.CInt(i):hscript.Const.CFloat(n));
					}
				}
				break;
			case 59:
				return hscript.Token.TSemicolon;
			case 40:
				return hscript.Token.TPOpen;
			case 41:
				return hscript.Token.TPClose;
			case 44:
				return hscript.Token.TComma;
			case 46:
				$char = this.readChar();
				switch($char) {
				case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:
					var n = $char - 48;
					var exp = 1;
					while(true) {
						$char = this.readChar();
						exp *= 10;
						switch($char) {
						case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:
							n = n * 10 + ($char - 48);
							break;
						default:
							this["char"] = $char;
							return hscript.Token.TConst(hscript.Const.CFloat(n / exp));
						}
					}
					break;
				case 46:
					$char = this.readChar();
					if($char != 46) this.invalidChar($char);
					return hscript.Token.TOp("...");
				default:
					this["char"] = $char;
					return hscript.Token.TDot;
				}
				break;
			case 123:
				return hscript.Token.TBrOpen;
			case 125:
				return hscript.Token.TBrClose;
			case 91:
				return hscript.Token.TBkOpen;
			case 93:
				return hscript.Token.TBkClose;
			case 39:
				return hscript.Token.TConst(hscript.Const.CString(this.readString(39)));
			case 34:
				return hscript.Token.TConst(hscript.Const.CString(this.readString(34)));
			case 63:
				return hscript.Token.TQuestion;
			case 58:
				return hscript.Token.TDoubleDot;
			default:
				if(this.ops[$char]) {
					var op = String.fromCharCode($char);
					while(true) {
						$char = this.readChar();
						if(!this.ops[$char]) {
							if(HxOverrides.cca(op,0) == 47) return this.tokenComment(op,$char);
							this["char"] = $char;
							return hscript.Token.TOp(op);
						}
						op += String.fromCharCode($char);
					}
				}
				if(this.idents[$char]) {
					var id = String.fromCharCode($char);
					while(true) {
						$char = this.readChar();
						if(!this.idents[$char]) {
							this["char"] = $char;
							return hscript.Token.TId(id);
						}
						id += String.fromCharCode($char);
					}
				}
				this.invalidChar($char);
			}
			$char = this.readChar();
		}
		return null;
	}
	,readString: function(until) {
		var c = 0;
		var b = new haxe.io.BytesOutput();
		var esc = false;
		var old = this.line;
		var s = this.input;
		while(true) {
			try {
				c = s.readByte();
			} catch( e ) {
				this.line = old;
				throw hscript.Error.EUnterminatedString;
			}
			if(esc) {
				esc = false;
				switch(c) {
				case 110:
					b.writeByte(10);
					break;
				case 114:
					b.writeByte(13);
					break;
				case 116:
					b.writeByte(9);
					break;
				case 39:case 34:case 92:
					b.writeByte(c);
					break;
				case 47:
					if(this.allowJSON) b.writeByte(c); else this.invalidChar(c);
					break;
				case 117:
					if(!this.allowJSON) throw this.invalidChar(c);
					var code = null;
					try {
						code = s.readString(4);
					} catch( e ) {
						this.line = old;
						throw hscript.Error.EUnterminatedString;
					}
					var k = 0;
					var _g = 0;
					while(_g < 4) {
						var i = _g++;
						k <<= 4;
						var $char = HxOverrides.cca(code,i);
						switch($char) {
						case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:
							k += $char - 48;
							break;
						case 65:case 66:case 67:case 68:case 69:case 70:
							k += $char - 55;
							break;
						case 97:case 98:case 99:case 100:case 101:case 102:
							k += $char - 87;
							break;
						default:
							this.invalidChar($char);
						}
					}
					if(k <= 127) b.writeByte(k); else if(k <= 2047) {
						b.writeByte(192 | k >> 6);
						b.writeByte(128 | k & 63);
					} else {
						b.writeByte(224 | k >> 12);
						b.writeByte(128 | k >> 6 & 63);
						b.writeByte(128 | k & 63);
					}
					break;
				default:
					this.invalidChar(c);
				}
			} else if(c == 92) esc = true; else if(c == until) break; else {
				if(c == 10) this.line++;
				b.writeByte(c);
			}
		}
		return b.getBytes().toString();
	}
	,readChar: function() {
		return (function($this) {
			var $r;
			try {
				$r = $this.input.readByte();
			} catch( e ) {
				$r = 0;
			}
			return $r;
		}(this));
	}
	,parseExprList: function(etk) {
		var args = new Array();
		var tk = this.token();
		if(tk == etk) return args;
		this.tokens.add(tk);
		try {
			while(true) {
				args.push(this.parseExpr());
				tk = this.token();
				switch( (tk)[1] ) {
				case 9:
					break;
				default:
					if(tk == etk) throw "__break__";
					this.unexpected(tk);
				}
			}
		} catch( e ) { if( e != "__break__" ) throw e; }
		return args;
	}
	,parseTypeNext: function(t) {
		var tk = this.token();
		var $e = (tk);
		switch( $e[1] ) {
		case 3:
			var op = $e[2];
			if(op != "->") {
				this.tokens.add(tk);
				return t;
			}
			break;
		default:
			this.tokens.add(tk);
			return t;
		}
		var t2 = this.parseType();
		var $e = (t2);
		switch( $e[1] ) {
		case 1:
			var t2_eCTFun_1 = $e[3], args = $e[2];
			args.unshift(t);
			return t2;
		default:
			return hscript.CType.CTFun([t],t2);
		}
	}
	,parseType: function() {
		var t = this.token();
		var $e = (t);
		switch( $e[1] ) {
		case 2:
			var v = $e[2];
			var path = [v];
			while(true) {
				t = this.token();
				if(t != hscript.Token.TDot) break;
				t = this.token();
				var $e = (t);
				switch( $e[1] ) {
				case 2:
					var v1 = $e[2];
					path.push(v1);
					break;
				default:
					this.unexpected(t);
				}
			}
			var params = null;
			var $e = (t);
			switch( $e[1] ) {
			case 3:
				var op = $e[2];
				if(op == "<") {
					params = [];
					try {
						while(true) {
							params.push(this.parseType());
							t = this.token();
							var $e = (t);
							switch( $e[1] ) {
							case 9:
								continue;
								break;
							case 3:
								var op1 = $e[2];
								if(op1 == ">") throw "__break__";
								break;
							default:
							}
							this.unexpected(t);
						}
					} catch( e ) { if( e != "__break__" ) throw e; }
				}
				break;
			default:
				this.tokens.add(t);
			}
			return this.parseTypeNext(hscript.CType.CTPath(path,params));
		case 4:
			var t1 = this.parseType();
			this.ensure(hscript.Token.TPClose);
			return this.parseTypeNext(hscript.CType.CTParent(t1));
		case 6:
			var fields = [];
			try {
				while(true) {
					t = this.token();
					var $e = (t);
					switch( $e[1] ) {
					case 7:
						throw "__break__";
						break;
					case 2:
						var name = $e[2];
						this.ensure(hscript.Token.TDoubleDot);
						fields.push({ name : name, t : this.parseType()});
						t = this.token();
						switch( (t)[1] ) {
						case 9:
							break;
						case 7:
							throw "__break__";
							break;
						default:
							this.unexpected(t);
						}
						break;
					default:
						this.unexpected(t);
					}
				}
			} catch( e ) { if( e != "__break__" ) throw e; }
			return this.parseTypeNext(hscript.CType.CTAnon(fields));
		default:
			return this.unexpected(t);
		}
	}
	,parseExprNext: function(e1) {
		var tk = this.token();
		var $e = (tk);
		switch( $e[1] ) {
		case 3:
			var op = $e[2];
			if(this.unops.get(op)) {
				if(this.isBlock(e1) || (function($this) {
					var $r;
					switch( (e1)[1] ) {
					case 3:
						$r = true;
						break;
					default:
						$r = false;
					}
					return $r;
				}(this))) {
					this.tokens.add(tk);
					return e1;
				}
				return this.parseExprNext(hscript.Expr.EUnop(op,false,e1));
			}
			return this.makeBinop(op,e1,this.parseExpr());
		case 8:
			tk = this.token();
			var field = null;
			var $e = (tk);
			switch( $e[1] ) {
			case 2:
				var id = $e[2];
				field = id;
				break;
			default:
				this.unexpected(tk);
			}
			return this.parseExprNext(hscript.Expr.EField(e1,field));
		case 4:
			return this.parseExprNext(hscript.Expr.ECall(e1,this.parseExprList(hscript.Token.TPClose)));
		case 11:
			var e2 = this.parseExpr();
			this.ensure(hscript.Token.TBkClose);
			return this.parseExprNext(hscript.Expr.EArray(e1,e2));
		case 13:
			var e2 = this.parseExpr();
			this.ensure(hscript.Token.TDoubleDot);
			var e3 = this.parseExpr();
			return hscript.Expr.ETernary(e1,e2,e3);
		default:
			this.tokens.add(tk);
			return e1;
		}
	}
	,parseStructure: function(id) {
		return (function($this) {
			var $r;
			switch(id) {
			case "if":
				$r = (function($this) {
					var $r;
					var cond = $this.parseExpr();
					var e1 = $this.parseExpr();
					var e2 = null;
					var semic = false;
					var tk = $this.token();
					if(tk == hscript.Token.TSemicolon) {
						semic = true;
						tk = $this.token();
					}
					if(Type.enumEq(tk,hscript.Token.TId("else"))) e2 = $this.parseExpr(); else {
						$this.tokens.add(tk);
						if(semic) $this.tokens.add(hscript.Token.TSemicolon);
					}
					$r = hscript.Expr.EIf(cond,e1,e2);
					return $r;
				}($this));
				break;
			case "var":
				$r = (function($this) {
					var $r;
					var tk = $this.token();
					var ident = null;
					var $e = (tk);
					switch( $e[1] ) {
					case 2:
						var id1 = $e[2];
						ident = id1;
						break;
					default:
						$this.unexpected(tk);
					}
					tk = $this.token();
					var t = null;
					if(tk == hscript.Token.TDoubleDot && $this.allowTypes) {
						t = $this.parseType();
						tk = $this.token();
					}
					var e = null;
					if(Type.enumEq(tk,hscript.Token.TOp("="))) e = $this.parseExpr(); else $this.tokens.add(tk);
					$r = hscript.Expr.EVar(ident,t,e);
					return $r;
				}($this));
				break;
			case "while":
				$r = (function($this) {
					var $r;
					var econd = $this.parseExpr();
					var e = $this.parseExpr();
					$r = hscript.Expr.EWhile(econd,e);
					return $r;
				}($this));
				break;
			case "for":
				$r = (function($this) {
					var $r;
					$this.ensure(hscript.Token.TPOpen);
					var tk = $this.token();
					var vname = null;
					var $e = (tk);
					switch( $e[1] ) {
					case 2:
						var id1 = $e[2];
						vname = id1;
						break;
					default:
						$this.unexpected(tk);
					}
					tk = $this.token();
					if(!Type.enumEq(tk,hscript.Token.TId("in"))) $this.unexpected(tk);
					var eiter = $this.parseExpr();
					$this.ensure(hscript.Token.TPClose);
					var e = $this.parseExpr();
					$r = hscript.Expr.EFor(vname,eiter,e);
					return $r;
				}($this));
				break;
			case "break":
				$r = hscript.Expr.EBreak;
				break;
			case "continue":
				$r = hscript.Expr.EContinue;
				break;
			case "else":
				$r = $this.unexpected(hscript.Token.TId(id));
				break;
			case "function":
				$r = (function($this) {
					var $r;
					var tk = $this.token();
					var name = null;
					var $e = (tk);
					switch( $e[1] ) {
					case 2:
						var id1 = $e[2];
						name = id1;
						break;
					default:
						$this.tokens.add(tk);
					}
					$this.ensure(hscript.Token.TPOpen);
					var args = new Array();
					tk = $this.token();
					if(tk != hscript.Token.TPClose) {
						var arg = true;
						while(arg) {
							var name1 = null;
							var $e = (tk);
							switch( $e[1] ) {
							case 2:
								var id1 = $e[2];
								name1 = id1;
								break;
							default:
								$this.unexpected(tk);
							}
							tk = $this.token();
							var t = null;
							if(tk == hscript.Token.TDoubleDot && $this.allowTypes) {
								t = $this.parseType();
								tk = $this.token();
							}
							args.push({ name : name1, t : t});
							switch( (tk)[1] ) {
							case 9:
								tk = $this.token();
								break;
							case 5:
								arg = false;
								break;
							default:
								$this.unexpected(tk);
							}
						}
					}
					var ret = null;
					if($this.allowTypes) {
						tk = $this.token();
						if(tk != hscript.Token.TDoubleDot) $this.tokens.add(tk); else ret = $this.parseType();
					}
					var body = $this.parseExpr();
					$r = hscript.Expr.EFunction(args,body,name,ret);
					return $r;
				}($this));
				break;
			case "return":
				$r = (function($this) {
					var $r;
					var tk = $this.token();
					$this.tokens.add(tk);
					var e = tk == hscript.Token.TSemicolon?null:$this.parseExpr();
					$r = hscript.Expr.EReturn(e);
					return $r;
				}($this));
				break;
			case "new":
				$r = (function($this) {
					var $r;
					var a = new Array();
					var tk = $this.token();
					var $e = (tk);
					switch( $e[1] ) {
					case 2:
						var id1 = $e[2];
						a.push(id1);
						break;
					default:
						$this.unexpected(tk);
					}
					var next = true;
					while(next) {
						tk = $this.token();
						switch( (tk)[1] ) {
						case 8:
							tk = $this.token();
							var $e = (tk);
							switch( $e[1] ) {
							case 2:
								var id1 = $e[2];
								a.push(id1);
								break;
							default:
								$this.unexpected(tk);
							}
							break;
						case 4:
							next = false;
							break;
						default:
							$this.unexpected(tk);
						}
					}
					var args = $this.parseExprList(hscript.Token.TPClose);
					$r = hscript.Expr.ENew(a.join("."),args);
					return $r;
				}($this));
				break;
			case "throw":
				$r = (function($this) {
					var $r;
					var e = $this.parseExpr();
					$r = hscript.Expr.EThrow(e);
					return $r;
				}($this));
				break;
			case "try":
				$r = (function($this) {
					var $r;
					var e = $this.parseExpr();
					var tk = $this.token();
					if(!Type.enumEq(tk,hscript.Token.TId("catch"))) $this.unexpected(tk);
					$this.ensure(hscript.Token.TPOpen);
					tk = $this.token();
					var vname = (function($this) {
						var $r;
						var $e = (tk);
						switch( $e[1] ) {
						case 2:
							var id1 = $e[2];
							$r = id1;
							break;
						default:
							$r = $this.unexpected(tk);
						}
						return $r;
					}($this));
					$this.ensure(hscript.Token.TDoubleDot);
					var t = null;
					if($this.allowTypes) t = $this.parseType(); else {
						tk = $this.token();
						if(!Type.enumEq(tk,hscript.Token.TId("Dynamic"))) $this.unexpected(tk);
					}
					$this.ensure(hscript.Token.TPClose);
					var ec = $this.parseExpr();
					$r = hscript.Expr.ETry(e,vname,t,ec);
					return $r;
				}($this));
				break;
			default:
				$r = null;
			}
			return $r;
		}(this));
	}
	,makeBinop: function(op,e1,e) {
		return (function($this) {
			var $r;
			var $e = (e);
			switch( $e[1] ) {
			case 6:
				var e3 = $e[4], e2 = $e[3], op2 = $e[2];
				$r = $this.opPriority.get(op) <= $this.opPriority.get(op2) && !$this.opRightAssoc.exists(op)?hscript.Expr.EBinop(op2,$this.makeBinop(op,e1,e2),e3):hscript.Expr.EBinop(op,e1,e);
				break;
			case 22:
				var e4 = $e[4], e3 = $e[3], e2 = $e[2];
				$r = $this.opRightAssoc.exists(op)?hscript.Expr.EBinop(op,e1,e):hscript.Expr.ETernary($this.makeBinop(op,e1,e2),e3,e4);
				break;
			default:
				$r = hscript.Expr.EBinop(op,e1,e);
			}
			return $r;
		}(this));
	}
	,makeUnop: function(op,e) {
		return (function($this) {
			var $r;
			var $e = (e);
			switch( $e[1] ) {
			case 6:
				var e2 = $e[4], e1 = $e[3], bop = $e[2];
				$r = hscript.Expr.EBinop(bop,$this.makeUnop(op,e1),e2);
				break;
			case 22:
				var e3 = $e[4], e2 = $e[3], e1 = $e[2];
				$r = hscript.Expr.ETernary($this.makeUnop(op,e1),e2,e3);
				break;
			default:
				$r = hscript.Expr.EUnop(op,true,e);
			}
			return $r;
		}(this));
	}
	,parseExpr: function() {
		var tk = this.token();
		var $e = (tk);
		switch( $e[1] ) {
		case 2:
			var id = $e[2];
			var e = this.parseStructure(id);
			if(e == null) e = hscript.Expr.EIdent(id);
			return this.parseExprNext(e);
		case 1:
			var c = $e[2];
			return this.parseExprNext(hscript.Expr.EConst(c));
		case 4:
			var e = this.parseExpr();
			this.ensure(hscript.Token.TPClose);
			return this.parseExprNext(hscript.Expr.EParent(e));
		case 6:
			tk = this.token();
			var $e = (tk);
			switch( $e[1] ) {
			case 7:
				return this.parseExprNext(hscript.Expr.EObject([]));
			case 2:
				var tk2 = this.token();
				this.tokens.add(tk2);
				this.tokens.add(tk);
				switch( (tk2)[1] ) {
				case 14:
					return this.parseExprNext(this.parseObject(0));
				default:
				}
				break;
			case 1:
				var c = $e[2];
				if(this.allowJSON) {
					switch( (c)[1] ) {
					case 2:
						var tk2 = this.token();
						this.tokens.add(tk2);
						this.tokens.add(tk);
						switch( (tk2)[1] ) {
						case 14:
							return this.parseExprNext(this.parseObject(0));
						default:
						}
						break;
					default:
						this.tokens.add(tk);
					}
				} else this.tokens.add(tk);
				break;
			default:
				this.tokens.add(tk);
			}
			var a = new Array();
			while(true) {
				a.push(this.parseFullExpr());
				tk = this.token();
				if(tk == hscript.Token.TBrClose) break;
				this.tokens.add(tk);
			}
			return hscript.Expr.EBlock(a);
		case 3:
			var op = $e[2];
			if(this.unops.exists(op)) return this.makeUnop(op,this.parseExpr());
			return this.unexpected(tk);
		case 11:
			var a = new Array();
			tk = this.token();
			while(tk != hscript.Token.TBkClose) {
				this.tokens.add(tk);
				a.push(this.parseExpr());
				tk = this.token();
				if(tk == hscript.Token.TComma) tk = this.token();
			}
			return this.parseExprNext(hscript.Expr.EArrayDecl(a));
		default:
			return this.unexpected(tk);
		}
	}
	,parseObject: function(p1) {
		var fl = new Array();
		try {
			while(true) {
				var tk = this.token();
				var id = null;
				var $e = (tk);
				switch( $e[1] ) {
				case 2:
					var i = $e[2];
					id = i;
					break;
				case 1:
					var c = $e[2];
					if(!this.allowJSON) this.unexpected(tk);
					var $e = (c);
					switch( $e[1] ) {
					case 2:
						var s = $e[2];
						id = s;
						break;
					default:
						this.unexpected(tk);
					}
					break;
				case 7:
					throw "__break__";
					break;
				default:
					this.unexpected(tk);
				}
				this.ensure(hscript.Token.TDoubleDot);
				fl.push({ name : id, e : this.parseExpr()});
				tk = this.token();
				switch( (tk)[1] ) {
				case 7:
					throw "__break__";
					break;
				case 9:
					break;
				default:
					this.unexpected(tk);
				}
			}
		} catch( e ) { if( e != "__break__" ) throw e; }
		return this.parseExprNext(hscript.Expr.EObject(fl));
	}
	,parseFullExpr: function() {
		var e = this.parseExpr();
		var tk = this.token();
		if(tk != hscript.Token.TSemicolon && tk != hscript.Token.TEof) {
			if(this.isBlock(e)) this.tokens.add(tk); else this.unexpected(tk);
		}
		return e;
	}
	,isBlock: function(e) {
		return (function($this) {
			var $r;
			var $e = (e);
			switch( $e[1] ) {
			case 4:
			case 21:
				$r = true;
				break;
			case 14:
				var e_eEFunction_3 = $e[5], e_eEFunction_2 = $e[4], e1 = $e[3], e_eEFunction_0 = $e[2];
				$r = $this.isBlock(e1);
				break;
			case 2:
				var e1 = $e[4], e_eEVar_1 = $e[3], e_eEVar_0 = $e[2];
				$r = e1 != null && $this.isBlock(e1);
				break;
			case 9:
				var e2 = $e[4], e1 = $e[3], e_eEIf_0 = $e[2];
				$r = e2 != null?$this.isBlock(e2):$this.isBlock(e1);
				break;
			case 6:
				var e1 = $e[4], e_eEBinop_1 = $e[3], e_eEBinop_0 = $e[2];
				$r = $this.isBlock(e1);
				break;
			case 7:
				var e1 = $e[4], prefix = $e[3], e_eEUnop_0 = $e[2];
				$r = !prefix && $this.isBlock(e1);
				break;
			case 10:
				var e1 = $e[3], e_eEWhile_0 = $e[2];
				$r = $this.isBlock(e1);
				break;
			case 11:
				var e1 = $e[4], e_eEFor_1 = $e[3], e_eEFor_0 = $e[2];
				$r = $this.isBlock(e1);
				break;
			case 15:
				var e1 = $e[2];
				$r = e1 != null && $this.isBlock(e1);
				break;
			default:
				$r = false;
			}
			return $r;
		}(this));
	}
	,ensure: function(tk) {
		var t = this.token();
		if(t != tk) this.unexpected(t);
	}
	,unexpected: function(tk) {
		throw hscript.Error.EUnexpected(this.tokenString(tk));
		return null;
	}
	,parse: function(s) {
		this.tokens = new haxe.ds.GenericStack();
		this["char"] = -1;
		this.input = s;
		this.ops = new Array();
		this.idents = new Array();
		var _g1 = 0, _g = this.opChars.length;
		while(_g1 < _g) {
			var i = _g1++;
			this.ops[HxOverrides.cca(this.opChars,i)] = true;
		}
		var _g1 = 0, _g = this.identChars.length;
		while(_g1 < _g) {
			var i = _g1++;
			this.idents[HxOverrides.cca(this.identChars,i)] = true;
		}
		var a = new Array();
		while(true) {
			var tk = this.token();
			if(tk == hscript.Token.TEof) break;
			this.tokens.add(tk);
			a.push(this.parseFullExpr());
		}
		return a.length == 1?a[0]:hscript.Expr.EBlock(a);
	}
	,parseString: function(s) {
		this.line = 1;
		return this.parse(new haxe.io.StringInput(s));
	}
	,invalidChar: function(c) {
		throw hscript.Error.EInvalidChar(c);
	}
	,tokens: null
	,idents: null
	,ops: null
	,'char': null
	,input: null
	,allowTypes: null
	,allowJSON: null
	,unops: null
	,opRightAssoc: null
	,opPriority: null
	,identChars: null
	,opChars: null
	,line: null
	,__class__: hscript.Parser
}
var hxevents = {}
hxevents.Dispatcher = function() {
	this.handlers = new Array();
};
$hxClasses["hxevents.Dispatcher"] = hxevents.Dispatcher;
hxevents.Dispatcher.__name__ = ["hxevents","Dispatcher"];
hxevents.Dispatcher.prototype = {
	_stop: null
	,dispatch: function(e) {
		var list = this.handlers.slice();
		var _g = 0;
		while(_g < list.length) {
			var l = list[_g];
			++_g;
			if(this._stop == true) {
				this._stop = false;
				break;
			}
			l(e);
		}
	}
	,remove: function(h) {
		var _g1 = 0, _g = this.handlers.length;
		while(_g1 < _g) {
			var i = _g1++;
			if(Reflect.compareMethods(this.handlers[i],h)) return this.handlers.splice(i,1)[0];
		}
		return null;
	}
	,addOnce: function(h) {
		var me = this;
		var _h = null;
		_h = function(v) {
			me.remove(_h);
			h(v);
		};
		this.add(_h);
		return _h;
	}
	,add: function(h) {
		this.handlers.push(h);
		return h;
	}
	,handlers: null
	,__class__: hxevents.Dispatcher
}
hxevents.Notifier = function() {
	this.handlers = new Array();
};
$hxClasses["hxevents.Notifier"] = hxevents.Notifier;
hxevents.Notifier.__name__ = ["hxevents","Notifier"];
hxevents.Notifier.prototype = {
	_stop: null
	,dispatch: function() {
		var list = this.handlers.slice();
		var _g = 0;
		while(_g < list.length) {
			var l = list[_g];
			++_g;
			if(this._stop == true) {
				this._stop = false;
				break;
			}
			l();
		}
	}
	,remove: function(h) {
		var _g1 = 0, _g = this.handlers.length;
		while(_g1 < _g) {
			var i = _g1++;
			if(Reflect.compareMethods(this.handlers[i],h)) return this.handlers.splice(i,1)[0];
		}
		return null;
	}
	,addOnce: function(h) {
		var me = this;
		var _h = null;
		_h = function() {
			me.remove(_h);
			h();
		};
		this.add(_h);
		return _h;
	}
	,add: function(h) {
		this.handlers.push(h);
		return h;
	}
	,handlers: null
	,__class__: hxevents.Notifier
}
js.Boot = function() { }
$hxClasses["js.Boot"] = js.Boot;
js.Boot.__name__ = ["js","Boot"];
js.Boot.__unhtml = function(s) {
	return s.split("&").join("&amp;").split("<").join("&lt;").split(">").join("&gt;");
}
js.Boot.__trace = function(v,i) {
	var msg = i != null?i.fileName + ":" + i.lineNumber + ": ":"";
	msg += js.Boot.__string_rec(v,"");
	if(i != null && i.customParams != null) {
		var _g = 0, _g1 = i.customParams;
		while(_g < _g1.length) {
			var v1 = _g1[_g];
			++_g;
			msg += "," + js.Boot.__string_rec(v1,"");
		}
	}
	var d;
	if(typeof(document) != "undefined" && (d = document.getElementById("haxe:trace")) != null) d.innerHTML += js.Boot.__unhtml(msg) + "<br/>"; else if(typeof(console) != "undefined" && console.log != null) console.log(msg);
}
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
	if(cl == null) return false;
	switch(cl) {
	case Int:
		return (o|0) === o;
	case Float:
		return typeof(o) == "number";
	case Bool:
		return typeof(o) == "boolean";
	case String:
		return typeof(o) == "string";
	case Dynamic:
		return true;
	default:
		if(o != null) {
			if(typeof(cl) == "function") {
				if(o instanceof cl) {
					if(cl == Array) return o.__enum__ == null;
					return true;
				}
				if(js.Boot.__interfLoop(o.__class__,cl)) return true;
			}
		} else return false;
		if(cl == Class && o.__name__ != null) return true;
		if(cl == Enum && o.__ename__ != null) return true;
		return o.__enum__ == cl;
	}
}
js.Boot.__cast = function(o,t) {
	if(js.Boot.__instanceof(o,t)) return o; else throw "Cannot cast " + Std.string(o) + " to " + Std.string(t);
}
js.Scroll = function() { }
$hxClasses["js.Scroll"] = js.Scroll;
js.Scroll.__name__ = ["js","Scroll"];
js.Scroll.getTop = function() {
	var sy = window.pageYOffset;
	if(typeof(sy) == "number") return sy;
	if(document.body) {
		sy = document.body.scrollTop;
		if(sy) return sy;
	}
	return document.documentElement.scrollTop;
}
js.Scroll.getLeft = function() {
	var sx = window.pageXOffset;
	if(typeof(sx) == "number") return sx;
	if(document.body) {
		sx = document.body.scrollLeft;
		if(sx) return sx;
	}
	return document.documentElement.scrollLeft;
}
var rg = {}
rg.RGConst = function() { }
$hxClasses["rg.RGConst"] = rg.RGConst;
rg.RGConst.__name__ = ["rg","RGConst"];
rg.app = {}
rg.app.charts = {}
rg.app.charts.App = function(notifier) {
	this.layouts = new haxe.ds.StringMap();
	this.globalNotifier = notifier;
};
$hxClasses["rg.app.charts.App"] = rg.app.charts.App;
rg.app.charts.App.__name__ = ["rg","app","charts","App"];
rg.app.charts.App.nextid = function() {
	return ":RGVIZ-" + ++rg.app.charts.App.lastid;
}
rg.app.charts.App.supportsSvg = function() {
	return !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;
}
rg.app.charts.App.prototype = {
	getLayout: function(id,options,container,replace) {
		var old = this.layouts.get(id);
		if(null != old) {
			if(replace) old.destroy(); else return old;
		}
		var info = rg.info.Info.feed(new rg.info.InfoLayout(),options), layout = new rg.factory.FactoryLayout().create(info,null == options.marginheight?0:options.marginheight,container);
		this.layouts.set(id,layout);
		return layout;
	}
	,visualization: function(el,jsoptions) {
		var _g = this;
		rg.app.charts.App.chartsCounter++;
		var node = el.node(), id = node.id;
		if(null == id) node.id = id = rg.app.charts.App.nextid();
		var params = rg.info.Info.feed(new rg.info.InfoVisualizationOption(),jsoptions), loader = new rg.data.DataLoader(rg.info.Info.feed(new rg.info.InfoDataSource(),jsoptions).loader), variables = new rg.factory.FactoryVariable().createVariables(params.variables), general = rg.info.Info.feed(new rg.info.InfoGeneral(),params.options), infoviz = rg.info.Info.feed(new rg.info.InfoVisualizationType(),params.options), uselegacy = !rg.app.charts.App.supportsSvg() || general.forcelegacy;
		var visualization = null;
		var ivariables = variables.filter(function(v) {
			return js.Boot.__instanceof(v,rg.data.VariableIndependent);
		});
		var dvariables = variables.filter(function(v) {
			return js.Boot.__instanceof(v,rg.data.VariableDependent);
		});
		loader.onLoad.addOnce(function(data) {
			new rg.data.IndependentVariableProcessor().process(data,ivariables);
			new rg.data.DependentVariableProcessor().process(data,dvariables);
		});
		if(!uselegacy) {
			var _g1 = rg.info.Info.feed(new rg.info.InfoDomType(),params.options);
			switch( (_g1.kind)[1] ) {
			case 1:
				var layout = this.getLayout(id,params.options,el,infoviz.replace);
				visualization = new rg.factory.FactorySvgVisualization().create(infoviz.type,layout,params.options);
				break;
			case 0:
				if(infoviz.replace) el.selectAll("*").remove();
				visualization = new rg.factory.FactoryHtmlVisualization().create(infoviz.type,el,params.options);
				break;
			}
			visualization.setVariables(variables,ivariables,dvariables);
			visualization.init();
			if(null != general.ready) visualization.addReady(general.ready);
			loader.onLoad.addOnce(function(datapoints) {
				visualization.feedData(datapoints);
			});
		}
		var brandPadding = 0;
		var download = rg.info.Info.feed(new rg.info.InfoDownload(),jsoptions.options.download);
		if(uselegacy) {
			var legacy = new rg.interactive.RGLegacyRenderer(el,download.legacyservice);
			loader.onLoad.addOnce(function(data) {
				jsoptions.datapoints = data;
				legacy.display(jsoptions);
				if(null != general.ready) legacy.onReady(general.ready);
			});
		}
		if(!uselegacy && (null != download.position || null != download.handler)) {
			var downloader = new rg.interactive.RGDownloader(visualization.container,download.service);
			if(null != download.handler) visualization.addReadyOnce(function() {
				download.handler($bind(downloader,downloader.download));
			}); else visualization.addReadyOnce(function() {
				var widget = new rg.html.widget.DownloaderMenu($bind(downloader,downloader.download),download.position,download.formats,visualization.container);
				brandPadding = 24;
			});
		}
		if(!uselegacy) visualization.addReadyOnce(function() {
			rg.app.charts.App.chartsLoaded++;
			if(rg.app.charts.App.chartsLoaded == rg.app.charts.App.chartsCounter) _g.globalNotifier.dispatch();
		});
		if(null != jsoptions.options.error) visualization.addError(jsoptions.options.error);
		haxe.Timer.delay($bind(loader,loader.load),0);
		return visualization;
	}
	,globalNotifier: null
	,layouts: null
	,__class__: rg.app.charts.App
}
rg.app.charts.JSBridge = function() { }
$hxClasses["rg.app.charts.JSBridge"] = rg.app.charts.JSBridge;
rg.app.charts.JSBridge.__name__ = ["rg","app","charts","JSBridge"];
rg.app.charts.JSBridge.log = function(msg) {
	var c = (window.console && window.console.warn) || alert;
	c(msg);
}
rg.app.charts.JSBridge.main = function() {
	var r = (typeof ReportGrid == 'undefined') ? (window['ReportGrid'] = {}) : ReportGrid;
	var globalNotifier = new hxevents.Notifier();
	var globalReady = false;
	globalNotifier.addOnce(function() {
		globalReady = true;
	});
	r.charts = { ready : function(handler) {
		if(globalReady) handler(); else globalNotifier.add(handler);
	}};
	var app = new rg.app.charts.App(globalNotifier);
	r.chart = function(el,options,type) {
		var copt = rg.app.charts.JSBridge.chartopt(options,type);
		copt.options.a = false;
		rg.app.charts.MVPOptions.complete(copt,function(opt) {
			try {
				app.visualization(rg.app.charts.JSBridge.select(el),opt);
			} catch( e ) {
				rg.app.charts.JSBridge.log(Std.string(e));
				if(null != options.error) options.error(e);
			}
		});
	};
	r.barChart = function(el,options) {
		return r.chart(el,options,"barchart");
	};
	r.funnelChart = function(el,options) {
		return r.chart(el,options,"funnelchart");
	};
	r.geo = function(el,options) {
		return r.chart(el,options,"geo");
	};
	r.heatGrid = function(el,options) {
		return r.chart(el,options,"heatgrid");
	};
	r.leaderBoard = function(el,options) {
		return r.chart(el,options,"leaderboard");
	};
	r.lineChart = function(el,options) {
		return r.chart(el,options,"linechart");
	};
	r.pieChart = function(el,options) {
		return r.chart(el,options,"piechart");
	};
	r.pivotTable = function(el,options) {
		return r.chart(el,options,"pivottable");
	};
	r.sankey = function(el,options) {
		return r.chart(el,options,"sankey");
	};
	r.scatterGraph = function(el,options) {
		return r.chart(el,options,"scattergraph");
	};
	r.streamGraph = function(el,options) {
		return r.chart(el,options,"streamgraph");
	};
	r.parseQueryParameters = rg.util.Urls.parseQueryParameters;
	r.findScript = rg.util.Js.findScript;
	r.format = Dynamics.format;
	r.compare = Dynamics.compare;
	r.dump = Dynamics.string;
	var scache = rg.svg.util.SymbolCache.cache;
	r.symbol = function(type,size) {
		return scache.get(type,null == size?100:size);
	};
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
	r.humanize = function(v) {
		if(js.Boot.__instanceof(v,String) && rg.util.Properties.isTime(v)) return rg.util.Properties.periodicity(v);
		return rg.util.RGStrings.humanize(v);
	};
	var rand = new thx.math.Random(666);
	r.math = { setRandomSeed : function(s) {
		rand = new thx.math.Random(s);
	}, random : function() {
		return ((rand.seed = rand.seed * 16807 % 2147483647) & 1073741823) / 1073741823.0;
	}};
	r.query = null != r.query?r.query:rg.app.charts.JSBridge.createQuery();
	r.info = null != r.info?r.info:{ };
	r.info.charts = { version : "1.5.45.9353"};
	r.getTooltip = function() {
		return rg.html.widget.Tooltip.get_instance();
	};
}
rg.app.charts.JSBridge.createQuery = function() {
	var inst = rg.query.Query.create();
	var query = { };
	var _g = 0, _g1 = Type.getInstanceFields(Type.getClass(inst));
	while(_g < _g1.length) {
		var field = [_g1[_g]];
		++_g;
		if(HxOverrides.substr(field[0],0,1) == "_" || !Reflect.isFunction(Reflect.field(inst,field[0]))) continue;
		query[field[0]] = (function(field) {
			return function() {
				var ob = rg.query.Query.create(), f = Reflect.field(ob,field[0]);
				return f.apply(ob,arguments);
			};
		})(field);
	}
	return query;
}
rg.app.charts.JSBridge.select = function(el) {
	var s = js.Boot.__instanceof(el,String)?dhx.Dom.select(el):dhx.Dom.selectNode(el);
	if(s.empty()) throw new thx.error.Error("invalid container '{0}'",el,null,{ fileName : "JSBridge.hx", lineNumber : 194, className : "rg.app.charts.JSBridge", methodName : "select"});
	return s;
}
rg.app.charts.JSBridge.opt = function(ob) {
	return null == ob?{ }:Objects.clone(ob);
}
rg.app.charts.JSBridge.chartopt = function(ob,viz) {
	ob = null == ob?{ }:Objects.clone(ob);
	ob.options = rg.app.charts.JSBridge.opt(ob.options);
	ob.options.visualization = null != viz?viz:ob.options.visualization;
	return ob;
}
rg.app.charts.MVPOptions = function() { }
$hxClasses["rg.app.charts.MVPOptions"] = rg.app.charts.MVPOptions;
rg.app.charts.MVPOptions.__name__ = ["rg","app","charts","MVPOptions"];
rg.app.charts.MVPOptions.complete = function(parameters,handler) {
	var chain = new rg.util.ChainedExecutor(handler);
	if(null == parameters.options) parameters.options = { };
	var options = parameters.options;
	if(null != options.download && !Types.isAnonymous(options.download)) {
		var v = options.download;
		Reflect.deleteField(options,"download");
		if(v == true) options.download = { position : "auto"}; else if(js.Boot.__instanceof(v,String)) options.download = { position : v}; else throw new thx.error.Error("invalid value for download '{0}'",[v],null,{ fileName : "MVPOptions.hx", lineNumber : 40, className : "rg.app.charts.MVPOptions", methodName : "complete"});
	}
	if(null != options.map && Types.isAnonymous(options.map)) options.map = [options.map];
	chain.addAction(function(params,handler1) {
		var axes = params.axes, hasdependent = false;
		if(null == axes) axes = [];
		params.axes = axes = axes.map(function(v) {
			return js.Boot.__instanceof(v,String)?{ type : v}:v;
		});
		var _g1 = 0, _g = axes.length;
		while(_g1 < _g) {
			var i = _g1++;
			var variable = axes[i].variable;
			if(null == variable) axes[i].variable = !hasdependent && i == axes.length - 1?"dependent":"independent"; else if("dependent" == variable) hasdependent = true;
		}
		var _g = 0;
		while(_g < axes.length) {
			var axis = axes[_g];
			++_g;
			if(axis.variable == "dependent") {
			} else switch(params.options.visualization) {
			case "barchart":case "pivottable":
				if(null == axis.scalemode) axis.scalemode = "fit";
				break;
			}
		}
		handler1(params);
	});
	chain.addAction(function(params1,handler1) {
		if(null == params1.options.label) params1.options.label = { };
		switch(params1.options.visualization) {
		case "linechart":case "barchart":case "streamgraph":
			var type = params1.axes[0].type;
			if(null == params1.options.label.datapointover) params1.options.label.datapointover = function(dp,stats) {
				return (null != params1.options.segmenton?rg.util.Properties.formatValue(params1.options.segmenton,dp) + ", ":"") + rg.util.Properties.formatValue(type,dp) + ": " + rg.util.Properties.formatValue(stats.type,dp);
			};
			break;
		case "scattergraph":case "heatgrid":
			var type1 = params1.axes[0].type;
			if(null == params1.options.label.datapointover) params1.options.label.datapointover = function(dp,stats) {
				return rg.util.Properties.formatValue(type1,dp) + ": " + rg.util.Properties.formatValue(stats.type,dp);
			};
			break;
		case "geo":
			var type2 = params1.axes[0].type, maps = params1.options.map;
			if(null == maps[maps.length - 1].label) maps[maps.length - 1].label = { };
			if(null == maps[maps.length - 1].label.datapointover) maps[maps.length - 1].label.datapointover = function(dp,stats) {
				var v = rg.util.Properties.formatValue(type2,dp);
				if(null == v) return null;
				return v + ": " + rg.util.Properties.formatValue(stats.type,dp);
			};
			break;
		case "piechart":
			if(null == params1.options.label.datapoint) params1.options.label.datapoint = function(dp,stats) {
				var v = Reflect.field(dp,stats.type);
				return params1.axes.length > 1?rg.util.Properties.formatValue(params1.axes[0].type,dp):stats.tot != 0.0?Floats.format(Math.round(1000 * v / stats.tot) / 10,"P:1"):rg.util.RGStrings.humanize(v);
			};
			if(null == params1.options.label.datapointover) params1.options.label.datapointover = function(dp,stats) {
				var v = Reflect.field(dp,stats.type);
				return rg.util.RGStrings.humanize(stats.type) + ": " + rg.util.RGStrings.humanize(v) + (params1.axes.length > 1 && stats.tot != 0.0?" (" + Floats.format(Math.round(1000 * v / stats.tot) / 10,"P:1") + ")":"");
			};
			break;
		case "funnelchart":
			if(null == params1.options.label.datapointover) params1.options.label.datapointover = function(dp,stats) {
				var v = Reflect.field(dp,stats.type);
				return rg.util.RGStrings.humanize(stats.type) + ": " + rg.util.RGStrings.humanize(v) + (params1.axes.length > 1 && stats.tot != 0.0?" (" + Floats.format(Math.round(1000 * v / stats.tot) / 10,"P:1") + ")":"");
			};
			break;
		case "sankey":
			var axes = params1.axes, type3 = axes[axes.length - 1].type;
			if(null == params1.options.label.datapointover) params1.options.label.datapointover = function(dp,stats) {
				var v = Reflect.field(dp,type3);
				return rg.util.RGStrings.humanize(type3) + ": " + rg.util.Properties.formatValue(type3,dp) + "\n" + (stats.tot != 0.0?Floats.format(Math.round(1000 * v / stats.tot) / 10,"P:1"):rg.util.RGStrings.humanize(v));
			};
			if(null == params1.options.label.node) params1.options.label.node = function(dp,stats) {
				return null != dp?dp.id:"";
			};
			if(null == params1.options.label.datapoint) params1.options.label.datapoint = function(dp,stats) {
				return rg.util.Properties.formatValue(type3,dp) + "\n" + rg.util.RGStrings.humanize(type3);
			};
			if(null == params1.options.label.edge) params1.options.label.edge = function(dp,stats) {
				return Floats.format(100 * dp.edgeweight / dp.nodeweight,"D:0") + "%";
			};
			if(null == params1.options.label.edgeover) params1.options.label.edgeover = function(dp,stats) {
				return Floats.format(dp.edgeweight,"D:0") + "\n" + Floats.format(100 * dp.edgeweight / dp.nodeweight,"D:0") + "%";
			};
			break;
		}
		handler1(params1);
	});
	chain.execute(parameters);
}
rg.axis = {}
rg.axis.IAxis = function() { }
$hxClasses["rg.axis.IAxis"] = rg.axis.IAxis;
rg.axis.IAxis.__name__ = ["rg","axis","IAxis"];
rg.axis.IAxis.prototype = {
	createStats: null
	,min: null
	,max: null
	,ticks: null
	,scale: null
	,__class__: rg.axis.IAxis
}
rg.axis.IAxisDiscrete = function() { }
$hxClasses["rg.axis.IAxisDiscrete"] = rg.axis.IAxisDiscrete;
rg.axis.IAxisDiscrete.__name__ = ["rg","axis","IAxisDiscrete"];
rg.axis.IAxisDiscrete.__interfaces__ = [rg.axis.IAxis];
rg.axis.IAxisDiscrete.prototype = {
	range: null
	,scaleDistribution: null
	,__class__: rg.axis.IAxisDiscrete
}
rg.axis.IAxisOrdinal = function() { }
$hxClasses["rg.axis.IAxisOrdinal"] = rg.axis.IAxisOrdinal;
rg.axis.IAxisOrdinal.__name__ = ["rg","axis","IAxisOrdinal"];
rg.axis.IAxisOrdinal.__interfaces__ = [rg.axis.IAxisDiscrete];
rg.axis.AxisOrdinal = function() {
	this.set_scaleDistribution(rg.axis.ScaleDistribution.ScaleFit);
};
$hxClasses["rg.axis.AxisOrdinal"] = rg.axis.AxisOrdinal;
rg.axis.AxisOrdinal.__name__ = ["rg","axis","AxisOrdinal"];
rg.axis.AxisOrdinal.__interfaces__ = [rg.axis.IAxisOrdinal];
rg.axis.AxisOrdinal.prototype = {
	createStats: function(type) {
		return new rg.axis.Stats(type);
	}
	,max: function(stats,meta) {
		return Arrays.last(this.values());
	}
	,min: function(stats,meta) {
		return this.values()[0];
	}
	,set_scaleDistribution: function(v) {
		return this.scaleDistribution = v;
	}
	,values: function() {
		return (function($this) {
			var $r;
			throw new thx.error.AbstractMethod({ fileName : "AxisOrdinal.hx", lineNumber : 64, className : "rg.axis.AxisOrdinal", methodName : "values"});
			return $r;
		}(this));
	}
	,scale: function(start,end,v) {
		var values = this.values(), s = values.indexOf(start), e = values.indexOf(end), p = values.indexOf(v);
		if(s < 0) throw new thx.error.Error("the start bound '{0}' is not part of the values {1}",[start,values],null,{ fileName : "AxisOrdinal.hx", lineNumber : 54, className : "rg.axis.AxisOrdinal", methodName : "scale"});
		if(e < 0) throw new thx.error.Error("the end bound '{0}' is not part of the values {1}",[end,values],null,{ fileName : "AxisOrdinal.hx", lineNumber : 56, className : "rg.axis.AxisOrdinal", methodName : "scale"});
		if(p < 0) throw new thx.error.Error("the value '{0}' is not part of the values {1}",[v,values],null,{ fileName : "AxisOrdinal.hx", lineNumber : 58, className : "rg.axis.AxisOrdinal", methodName : "scale"});
		return rg.axis.ScaleDistributions.distribute(this.scaleDistribution,p - s,e - s + 1);
	}
	,range: function(start,end) {
		var values = this.values(), s = values.indexOf(start), e = values.indexOf(end);
		if(s < 0) throw new thx.error.Error("the start bound '{0}' is not part of the acceptable values {1}",[start,values],null,{ fileName : "AxisOrdinal.hx", lineNumber : 41, className : "rg.axis.AxisOrdinal", methodName : "range"});
		if(e < 0) throw new thx.error.Error("the end bound '{0}' is not part of the acceptable values {1}",[end,values],null,{ fileName : "AxisOrdinal.hx", lineNumber : 43, className : "rg.axis.AxisOrdinal", methodName : "range"});
		return values.slice(s,e + 1);
	}
	,ticks: function(start,end,upperBound) {
		if(0 == upperBound) return [];
		var ticks = rg.axis.TickmarkOrdinal.fromArray(this.range(start,end),this.scaleDistribution);
		return rg.axis.Tickmarks.bound(ticks,upperBound);
	}
	,scaleDistribution: null
	,__class__: rg.axis.AxisOrdinal
}
rg.axis.AxisOrdinalFixedValues = function(arr) {
	rg.axis.AxisOrdinal.call(this);
	this._values = arr;
};
$hxClasses["rg.axis.AxisOrdinalFixedValues"] = rg.axis.AxisOrdinalFixedValues;
rg.axis.AxisOrdinalFixedValues.__name__ = ["rg","axis","AxisOrdinalFixedValues"];
rg.axis.AxisOrdinalFixedValues.__super__ = rg.axis.AxisOrdinal;
rg.axis.AxisOrdinalFixedValues.prototype = $extend(rg.axis.AxisOrdinal.prototype,{
	values: function() {
		return this._values;
	}
	,_values: null
	,__class__: rg.axis.AxisOrdinalFixedValues
});
rg.axis.AxisGroupByTime = function(groupby) {
	rg.axis.AxisOrdinalFixedValues.call(this,rg.axis.AxisGroupByTime.valuesByGroup(groupby));
	this.groupBy = groupby;
};
$hxClasses["rg.axis.AxisGroupByTime"] = rg.axis.AxisGroupByTime;
rg.axis.AxisGroupByTime.__name__ = ["rg","axis","AxisGroupByTime"];
rg.axis.AxisGroupByTime.valuesByGroup = function(groupby) {
	return Ints.range(rg.axis.AxisGroupByTime.defaultMin(groupby),rg.axis.AxisGroupByTime.defaultMax(groupby) + 1);
}
rg.axis.AxisGroupByTime.defaultMin = function(periodicity) {
	switch(periodicity) {
	case "minute":case "hour":case "week":case "month":
		return 0;
	case "day":
		return 1;
	default:
		throw new thx.error.Error("invalid periodicity '{0}' for groupBy min",null,periodicity,{ fileName : "AxisGroupByTime.hx", lineNumber : 34, className : "rg.axis.AxisGroupByTime", methodName : "defaultMin"});
	}
}
rg.axis.AxisGroupByTime.defaultMax = function(periodicity) {
	switch(periodicity) {
	case "minute":
		return 59;
	case "hour":
		return 23;
	case "day":
		return 31;
	case "week":
		return 6;
	case "month":
		return 11;
	default:
		throw new thx.error.Error("invalid periodicity '{0}' for groupBy max",null,periodicity,{ fileName : "AxisGroupByTime.hx", lineNumber : 48, className : "rg.axis.AxisGroupByTime", methodName : "defaultMax"});
	}
}
rg.axis.AxisGroupByTime.__super__ = rg.axis.AxisOrdinalFixedValues;
rg.axis.AxisGroupByTime.prototype = $extend(rg.axis.AxisOrdinalFixedValues.prototype,{
	groupBy: null
	,__class__: rg.axis.AxisGroupByTime
});
rg.axis.AxisNumeric = function() {
};
$hxClasses["rg.axis.AxisNumeric"] = rg.axis.AxisNumeric;
rg.axis.AxisNumeric.__name__ = ["rg","axis","AxisNumeric"];
rg.axis.AxisNumeric.__interfaces__ = [rg.axis.IAxis];
rg.axis.AxisNumeric._step = function(span,m) {
	var step = Math.pow(10,Math.floor(Math.log(span / m) / 2.302585092994046)), err = m / span * step;
	if(err <= .15) step *= 10; else if(err <= .35) step *= 5; else if(err <= .75) step *= 2;
	return step;
}
rg.axis.AxisNumeric.niceMin = function(d,v) {
	var dv = Math.pow(10,Math.round(Math.log(d) / 2.302585092994046) - 1);
	return Math.floor(v / dv) * dv;
}
rg.axis.AxisNumeric.niceMax = function(d,v) {
	var dv = Math.pow(10,Math.round(Math.log(d) / 2.302585092994046) - 1);
	return Math.ceil(v / dv) * dv;
}
rg.axis.AxisNumeric.prototype = {
	createStats: function(type) {
		return new rg.axis.StatsNumeric(type);
	}
	,max: function(stats,meta) {
		if(null != meta.max) return meta.max;
		var max = rg.axis.AxisNumeric.niceMax(stats.max - stats.min,stats.max);
		if(max > 0) return max; else return 0.0;
	}
	,min: function(stats,meta) {
		if(null != meta.min) return meta.min;
		var min = rg.axis.AxisNumeric.niceMin(stats.max - stats.min,stats.min);
		if(min < 0) return min; else return 0.0;
	}
	,ticks: function(start,end,maxTicks) {
		var span = end - start, step = 1.0, minors, majors;
		if(start % step == 0 && end % step == 0 && span < 10 && span >= step) {
			majors = Floats.range(start,end + step,step);
			minors = null;
		} else {
			var mM = 5, mm = 20, stepM = rg.axis.AxisNumeric._step(span,mM), stepm = rg.axis.AxisNumeric._step(span,mm);
			if(stepm == 0) minors = [0.0]; else minors = Floats.range(start,end,stepm,true,true);
			if(stepM == 0) majors = [0.0]; else majors = Floats.range(start,end,stepM,true,true);
		}
		var r = rg.axis.Tickmarks.bound(null == minors?majors.map(function(d) {
			return new rg.axis.Tickmark(d,true,(d - start) / (end - start));
		}):minors.map(function(d) {
			return new rg.axis.Tickmark(d,HxOverrides.remove(majors,d),(d - start) / (end - start));
		}),maxTicks);
		return r;
	}
	,scale: function(start,end,v) {
		if(start == end) return start;
		return (Floats.uninterpolatef(start,end))(v);
	}
	,__class__: rg.axis.AxisNumeric
}
rg.axis.AxisOrdinalStats = function(variable) {
	rg.axis.AxisOrdinal.call(this);
	this.variable = variable;
};
$hxClasses["rg.axis.AxisOrdinalStats"] = rg.axis.AxisOrdinalStats;
rg.axis.AxisOrdinalStats.__name__ = ["rg","axis","AxisOrdinalStats"];
rg.axis.AxisOrdinalStats.__super__ = rg.axis.AxisOrdinal;
rg.axis.AxisOrdinalStats.prototype = $extend(rg.axis.AxisOrdinal.prototype,{
	values: function() {
		return this.variable.stats.values;
	}
	,variable: null
	,__class__: rg.axis.AxisOrdinalStats
});
rg.axis.AxisTime = function(periodicity) {
	this.periodicity = periodicity;
	this.set_scaleDistribution(rg.axis.ScaleDistribution.ScaleFill);
};
$hxClasses["rg.axis.AxisTime"] = rg.axis.AxisTime;
rg.axis.AxisTime.__name__ = ["rg","axis","AxisTime"];
rg.axis.AxisTime.__interfaces__ = [rg.axis.IAxisDiscrete];
rg.axis.AxisTime.prototype = {
	createStats: function(type) {
		return new rg.axis.StatsNumeric(type);
	}
	,max: function(stats,meta) {
		return stats.max;
	}
	,min: function(stats,meta) {
		return stats.min;
	}
	,set_scaleDistribution: function(v) {
		return this.scaleDistribution = v;
	}
	,scale: function(start,end,v) {
		var _g = this;
		switch( (_g.scaleDistribution)[1] ) {
		case 1:
			return (v - start) / (end - start);
		default:
			var values = this.range(start,end);
			return rg.axis.ScaleDistributions.distribute(this.scaleDistribution,values.indexOf(Dates.snap(v,this.periodicity)),values.length);
		}
	}
	,range: function(start,end) {
		return rg.util.Periodicity.range(start,end,this.periodicity);
	}
	,ticks: function(start,end,upperBound) {
		var _g = this;
		var span = end - start, units = rg.util.Periodicity.unitsBetween(start,end,this.periodicity), values = this.range(start,end), range = values.map(function(value) {
			return new rg.axis.TickmarkTime(value,values,_g.isMajor(units,value),_g.periodicity,_g.scaleDistribution);
		});
		return rg.axis.Tickmarks.bound(range,upperBound);
	}
	,isMajor: function(units,value) {
		var _g = this;
		switch(_g.periodicity) {
		case "day":
			if(units <= 31) return true;
			if(units < 121) {
				var d = ((function($this) {
					var $r;
					var d1 = new Date();
					d1.setTime(value);
					$r = d1;
					return $r;
				}(this))).getDate();
				return rg.util.Periodicity.firstInSeries("month",value) || rg.util.Periodicity.firstInSeries("week",value);
			}
			return rg.util.Periodicity.firstInSeries("month",value);
		case "week":
			if(units < 31) return true; else return ((function($this) {
				var $r;
				var d = new Date();
				d.setTime(value);
				$r = d;
				return $r;
			}(this))).getDate() <= 7;
			break;
		default:
			var series = Reflect.field(rg.axis.AxisTime.snapping,this.periodicity), unit = rg.util.Periodicity.units(value,this.periodicity);
			if(null == series) return true;
			var _g1 = 0;
			while(_g1 < series.length) {
				var item = series[_g1];
				++_g1;
				if(units > item.to) continue;
				return 0 == unit % item.s;
			}
			var top = Reflect.field(rg.axis.AxisTime.snapping,this.periodicity + "top");
			if(null == top) top = 1;
			return 0 == unit % top;
		}
	}
	,scaleDistribution: null
	,periodicity: null
	,__class__: rg.axis.AxisTime
}
rg.axis.ITickmark = function() { }
$hxClasses["rg.axis.ITickmark"] = rg.axis.ITickmark;
rg.axis.ITickmark.__name__ = ["rg","axis","ITickmark"];
rg.axis.ITickmark.prototype = {
	label: null
	,value: null
	,major: null
	,delta: null
	,__class__: rg.axis.ITickmark
}
rg.axis.ScaleDistribution = { __ename__ : ["rg","axis","ScaleDistribution"], __constructs__ : ["ScaleFit","ScaleFill","ScaleBefore","ScaleAfter"] }
rg.axis.ScaleDistribution.ScaleFit = ["ScaleFit",0];
rg.axis.ScaleDistribution.ScaleFit.toString = $estr;
rg.axis.ScaleDistribution.ScaleFit.__enum__ = rg.axis.ScaleDistribution;
rg.axis.ScaleDistribution.ScaleFill = ["ScaleFill",1];
rg.axis.ScaleDistribution.ScaleFill.toString = $estr;
rg.axis.ScaleDistribution.ScaleFill.__enum__ = rg.axis.ScaleDistribution;
rg.axis.ScaleDistribution.ScaleBefore = ["ScaleBefore",2];
rg.axis.ScaleDistribution.ScaleBefore.toString = $estr;
rg.axis.ScaleDistribution.ScaleBefore.__enum__ = rg.axis.ScaleDistribution;
rg.axis.ScaleDistribution.ScaleAfter = ["ScaleAfter",3];
rg.axis.ScaleDistribution.ScaleAfter.toString = $estr;
rg.axis.ScaleDistribution.ScaleAfter.__enum__ = rg.axis.ScaleDistribution;
rg.axis.ScaleDistributions = function() { }
$hxClasses["rg.axis.ScaleDistributions"] = rg.axis.ScaleDistributions;
rg.axis.ScaleDistributions.__name__ = ["rg","axis","ScaleDistributions"];
rg.axis.ScaleDistributions.distribute = function(scale,pos,values) {
	switch( (scale)[1] ) {
	case 0:
		return (pos + 0.5) / values;
	case 1:
		return pos / (values - 1);
	case 2:
		return pos / values;
	case 3:
		return (pos + 1) / values;
	}
}
rg.axis.Stats = function(type,sortf) {
	this.type = type;
	this.sortf = sortf;
	this.reset();
};
$hxClasses["rg.axis.Stats"] = rg.axis.Stats;
rg.axis.Stats.__name__ = ["rg","axis","Stats"];
rg.axis.Stats.prototype = {
	addMany: function(it) {
		var $it0 = $iterator(it)();
		while( $it0.hasNext() ) {
			var v = $it0.next();
			this.count++;
			if(Arrays.exists(this.values,v)) continue;
			this.values.push(v);
		}
		if(null != this.sortf) this.values.sort(this.sortf);
		this.min = this.values[0];
		this.max = Arrays.last(this.values);
		return this;
	}
	,add: function(v) {
		this.count++;
		if(Arrays.exists(this.values,v)) return this;
		this.values.push(v);
		if(null != this.sortf) this.values.sort(this.sortf);
		this.min = this.values[0];
		this.max = Arrays.last(this.values);
		return this;
	}
	,reset: function() {
		this.min = null;
		this.max = null;
		this.count = 0;
		this.values = [];
		return this;
	}
	,type: null
	,sortf: null
	,values: null
	,count: null
	,max: null
	,min: null
	,__class__: rg.axis.Stats
}
rg.axis.StatsNumeric = function(type,sortf) {
	if(null == sortf) sortf = Floats.compare;
	rg.axis.Stats.call(this,type,sortf);
};
$hxClasses["rg.axis.StatsNumeric"] = rg.axis.StatsNumeric;
rg.axis.StatsNumeric.__name__ = ["rg","axis","StatsNumeric"];
rg.axis.StatsNumeric.__super__ = rg.axis.Stats;
rg.axis.StatsNumeric.prototype = $extend(rg.axis.Stats.prototype,{
	addMany: function(it) {
		rg.axis.Stats.prototype.addMany.call(this,it);
		var $it0 = $iterator(it)();
		while( $it0.hasNext() ) {
			var v = $it0.next();
			this.tot += v;
		}
		return this;
	}
	,add: function(v) {
		rg.axis.Stats.prototype.add.call(this,v);
		this.tot += v;
		return this;
	}
	,reset: function() {
		rg.axis.Stats.prototype.reset.call(this);
		this.tot = 0.0;
		return this;
	}
	,tot: null
	,__class__: rg.axis.StatsNumeric
});
rg.axis.Tickmark = function(value,major,delta) {
	this.value = value;
	this.major = major;
	this.delta = delta;
};
$hxClasses["rg.axis.Tickmark"] = rg.axis.Tickmark;
rg.axis.Tickmark.__name__ = ["rg","axis","Tickmark"];
rg.axis.Tickmark.__interfaces__ = [rg.axis.ITickmark];
rg.axis.Tickmark.prototype = {
	get_label: function() {
		return rg.util.RGStrings.humanize(this.get_value());
	}
	,get_value: function() {
		return this.value;
	}
	,get_major: function() {
		return this.major;
	}
	,get_delta: function() {
		return this.delta;
	}
	,label: null
	,value: null
	,major: null
	,delta: null
	,__class__: rg.axis.Tickmark
}
rg.axis.TickmarkOrdinal = function(pos,values,major,scaleDistribution) {
	if(major == null) major = true;
	this.pos = pos;
	this.values = values;
	this.scaleDistribution = scaleDistribution;
	this.major = major;
};
$hxClasses["rg.axis.TickmarkOrdinal"] = rg.axis.TickmarkOrdinal;
rg.axis.TickmarkOrdinal.__name__ = ["rg","axis","TickmarkOrdinal"];
rg.axis.TickmarkOrdinal.__interfaces__ = [rg.axis.ITickmark];
rg.axis.TickmarkOrdinal.fromArray = function(values,scaleDistribution) {
	return Iterators.map(HxOverrides.iter(values),function(_,i) {
		return new rg.axis.TickmarkOrdinal(i,values,null,scaleDistribution);
	});
}
rg.axis.TickmarkOrdinal.prototype = {
	get_label: function() {
		return rg.util.RGStrings.humanize(this.values[this.pos]);
	}
	,label: null
	,get_value: function() {
		return this.values[this.pos];
	}
	,value: null
	,get_major: function() {
		return this.major;
	}
	,major: null
	,get_delta: function() {
		return rg.axis.ScaleDistributions.distribute(this.scaleDistribution,this.pos,this.values.length);
	}
	,delta: null
	,scaleDistribution: null
	,values: null
	,pos: null
	,__class__: rg.axis.TickmarkOrdinal
}
rg.axis.TickmarkTime = function(value,values,major,periodicity,scaleDistribution) {
	rg.axis.TickmarkOrdinal.call(this,values.indexOf(value),values,major,scaleDistribution);
	this.periodicity = periodicity;
};
$hxClasses["rg.axis.TickmarkTime"] = rg.axis.TickmarkTime;
rg.axis.TickmarkTime.__name__ = ["rg","axis","TickmarkTime"];
rg.axis.TickmarkTime.__super__ = rg.axis.TickmarkOrdinal;
rg.axis.TickmarkTime.prototype = $extend(rg.axis.TickmarkOrdinal.prototype,{
	get_label: function() {
		return rg.util.Periodicity.smartFormat(this.periodicity,this.values[this.pos]);
	}
	,periodicity: null
	,__class__: rg.axis.TickmarkTime
});
rg.axis.Tickmarks = function() { }
$hxClasses["rg.axis.Tickmarks"] = rg.axis.Tickmarks;
rg.axis.Tickmarks.__name__ = ["rg","axis","Tickmarks"];
rg.axis.Tickmarks.bound = function(tickmarks,max) {
	if(null == max || tickmarks.length <= (2 > max?2:max)) return tickmarks;
	var majors = tickmarks.filter(function(d) {
		return d.get_major();
	});
	if(majors.length > max) return rg.axis.Tickmarks.reduce(majors,max);
	var result = rg.axis.Tickmarks.reduce(tickmarks.filter(function(d) {
		return !d.get_major();
	}),max - majors.length).concat(majors);
	result.sort(function(a,b) {
		return Floats.compare(a.get_delta(),b.get_delta());
	});
	return result;
}
rg.axis.Tickmarks.reduce = function(arr,max) {
	if(max == 1) return [arr[0]];
	if(max == 2) return [arr[arr.length - 1]];
	var keep = arr.length / max, result = [], i = 0;
	do result.push(arr[Math.round(keep * i++)]); while(max > result.length);
	return result;
}
rg.data = {}
rg.data.DataLoader = function(loader) {
	if(null == loader) throw new thx.error.NullArgument("loader","invalid null argument '{0}' for method {1}.{2}()",{ fileName : "DataLoader.hx", lineNumber : 11, className : "rg.data.DataLoader", methodName : "new"});
	this.loader = loader;
	this.onLoad = new hxevents.Dispatcher();
};
$hxClasses["rg.data.DataLoader"] = rg.data.DataLoader;
rg.data.DataLoader.__name__ = ["rg","data","DataLoader"];
rg.data.DataLoader.prototype = {
	load: function() {
		var _g = this;
		this.loader(function(datapoints) {
			_g.onLoad.dispatch(datapoints);
		});
	}
	,onLoad: null
	,loader: null
	,__class__: rg.data.DataLoader
}
rg.data.DependentVariableProcessor = function() {
};
$hxClasses["rg.data.DependentVariableProcessor"] = rg.data.DependentVariableProcessor;
rg.data.DependentVariableProcessor.__name__ = ["rg","data","DependentVariableProcessor"];
rg.data.DependentVariableProcessor.prototype = {
	process: function(data,variables) {
		var _g = 0;
		while(_g < variables.length) {
			var variable = variables[_g];
			++_g;
			var values = rg.util.DataPoints.values(data,variable.type);
			if(values.length == 0) continue;
			if(null == variable.axis) variable.setAxis(new rg.factory.FactoryAxis().create(variable.type,js.Boot.__instanceof(values[0],Float),variable,null));
			variable.stats.addMany(values);
			var discrete;
			if(null != variable.scaleDistribution && null != (discrete = Types["as"](variable.axis,rg.axis.IAxisDiscrete))) {
				discrete.set_scaleDistribution(variable.scaleDistribution);
				variable.scaleDistribution = null;
			}
		}
	}
	,__class__: rg.data.DependentVariableProcessor
}
rg.data.IndependentVariableProcessor = function() {
};
$hxClasses["rg.data.IndependentVariableProcessor"] = rg.data.IndependentVariableProcessor;
rg.data.IndependentVariableProcessor.__name__ = ["rg","data","IndependentVariableProcessor"];
rg.data.IndependentVariableProcessor.prototype = {
	process: function(data,variables) {
		var _g = 0;
		while(_g < variables.length) {
			var variable = variables[_g];
			++_g;
			variable.stats.addMany(rg.util.DataPoints.values(data,variable.type));
			var discrete;
			if(null != variable.scaleDistribution && null != (discrete = Types["as"](variable.axis,rg.axis.IAxisDiscrete))) {
				discrete.set_scaleDistribution(variable.scaleDistribution);
				variable.scaleDistribution = null;
			}
		}
	}
	,__class__: rg.data.IndependentVariableProcessor
}
rg.data.Segmenter = function(on,transform,scale,values) {
	this.on = on;
	this.transform = transform;
	this.scale = scale;
	this.values = values;
};
$hxClasses["rg.data.Segmenter"] = rg.data.Segmenter;
rg.data.Segmenter.__name__ = ["rg","data","Segmenter"];
rg.data.Segmenter.prototype = {
	segment: function(data) {
		var _g2 = this;
		var segmented;
		if(null == this.on) segmented = [data]; else if(this.values.length > 0) {
			segmented = [];
			var _g = 0, _g1 = this.values;
			while(_g < _g1.length) {
				var value = [_g1[_g]];
				++_g;
				segmented.push(data.filter((function(value) {
					return function(dp) {
						return Reflect.field(dp,_g2.on) == value[0];
					};
				})(value)));
			}
		} else segmented = rg.util.DataPoints.partition(data,this.on);
		if(null != this.scale) {
			var _g1 = 0, _g = segmented.length;
			while(_g1 < _g) {
				var i = _g1++;
				segmented[i] = this.scale(segmented[i]);
			}
		}
		if(null != this.transform) {
			var rotated = Arrays.rotate(segmented);
			var _g1 = 0, _g = rotated.length;
			while(_g1 < _g) {
				var i = _g1++;
				rotated[i] = this.transform(rotated[i]);
			}
			segmented = Arrays.rotate(rotated);
		}
		return segmented;
	}
	,values: null
	,scale: null
	,transform: null
	,on: null
	,__class__: rg.data.Segmenter
}
rg.data.Variable = function(type,scaleDistribution) {
	this.type = type;
	this.scaleDistribution = scaleDistribution;
	this.meta = { };
};
$hxClasses["rg.data.Variable"] = rg.data.Variable;
rg.data.Variable.__name__ = ["rg","data","Variable"];
rg.data.Variable.prototype = {
	get_maxf: function() {
		if(null == this.maxf) {
			if(null == this.axis) throw new thx.error.Error("axis is null in '{0}' variable (required by max)",[this.type],null,{ fileName : "Variable.hx", lineNumber : 61, className : "rg.data.Variable", methodName : "get_maxf"});
			this.set_maxf(($_=this.axis,$bind($_,$_.max)));
		}
		return this.maxf;
	}
	,get_minf: function() {
		if(null == this.minf) {
			if(null == this.axis) throw new thx.error.Error("axis is null in '{0}' variable (required by min)",[this.type],null,{ fileName : "Variable.hx", lineNumber : 50, className : "rg.data.Variable", methodName : "get_minf"});
			this.set_minf(($_=this.axis,$bind($_,$_.min)));
		}
		return this.minf;
	}
	,set_maxf: function(f) {
		return this.maxf = f;
	}
	,set_minf: function(f) {
		return this.minf = f;
	}
	,max: function() {
		return (this.get_maxf())(this.stats,this.meta);
	}
	,min: function() {
		return (this.get_minf())(this.stats,this.meta);
	}
	,setAxis: function(axis) {
		this.axis = axis;
		if(null != axis) this.stats = axis.createStats(this.type); else this.stats = null;
	}
	,maxf: null
	,minf: null
	,meta: null
	,stats: null
	,axis: null
	,scaleDistribution: null
	,type: null
	,__class__: rg.data.Variable
}
rg.data.VariableDependent = function(type,scaleDistribution) {
	rg.data.Variable.call(this,type,scaleDistribution);
};
$hxClasses["rg.data.VariableDependent"] = rg.data.VariableDependent;
rg.data.VariableDependent.__name__ = ["rg","data","VariableDependent"];
rg.data.VariableDependent.__super__ = rg.data.Variable;
rg.data.VariableDependent.prototype = $extend(rg.data.Variable.prototype,{
	__class__: rg.data.VariableDependent
});
rg.data.VariableIndependent = function(type,scaleDistribution) {
	rg.data.Variable.call(this,type,scaleDistribution);
};
$hxClasses["rg.data.VariableIndependent"] = rg.data.VariableIndependent;
rg.data.VariableIndependent.__name__ = ["rg","data","VariableIndependent"];
rg.data.VariableIndependent.__super__ = rg.data.Variable;
rg.data.VariableIndependent.prototype = $extend(rg.data.Variable.prototype,{
	__class__: rg.data.VariableIndependent
});
rg.factory = {}
rg.factory.FactoryAxis = function() {
};
$hxClasses["rg.factory.FactoryAxis"] = rg.factory.FactoryAxis;
rg.factory.FactoryAxis.__name__ = ["rg","factory","FactoryAxis"];
rg.factory.FactoryAxis.prototype = {
	createDiscrete: function(type,variable,samples,groupBy) {
		if(type.indexOf("time:") >= 0) {
			if(null != groupBy) return new rg.axis.AxisGroupByTime(HxOverrides.substr(type,type.indexOf("time:") + "time:".length,null)); else return new rg.axis.AxisTime(HxOverrides.substr(type,type.indexOf("time:") + "time:".length,null));
		} else if(null != samples && samples.length > 0) return new rg.axis.AxisOrdinalFixedValues(samples);
		return new rg.axis.AxisOrdinalStats(variable);
	}
	,create: function(type,isnumeric,variable,samples) {
		if(null != samples && samples.length > 0) return new rg.axis.AxisOrdinalFixedValues(samples); else if(true == isnumeric) return new rg.axis.AxisNumeric(); else if(false == isnumeric) return new rg.axis.AxisOrdinalStats(variable); else return null;
	}
	,__class__: rg.factory.FactoryAxis
}
rg.factory.FactoryGeoProjection = function() {
};
$hxClasses["rg.factory.FactoryGeoProjection"] = rg.factory.FactoryGeoProjection;
rg.factory.FactoryGeoProjection.__name__ = ["rg","factory","FactoryGeoProjection"];
rg.factory.FactoryGeoProjection.prototype = {
	create: function(info) {
		var _g = info.projection.toLowerCase();
		switch(_g) {
		case "mercator":
			var projection = new thx.geo.Mercator();
			if(null != info.scale) projection.set_scale(info.scale);
			if(null != info.translate) projection.set_translate(info.translate); else projection.set_translate([0.0,0]);
			return projection;
		case "albers":
			var projection = new thx.geo.Albers();
			if(null != info.scale) projection.set_scale(info.scale);
			if(null != info.translate) projection.set_translate(info.translate); else projection.set_translate([0.0,0]);
			if(null != info.origin) projection.set_origin(info.origin);
			if(null != info.parallels) projection.set_parallels(info.parallels);
			return projection;
		case "albersusa":
			var projection = new thx.geo.AlbersUsa();
			if(null != info.scale) projection.set_scale(info.scale);
			if(null != info.translate) projection.set_translate(info.translate); else projection.set_translate([0.0,0]);
			return projection;
		case "azimuthal":
			var projection = new thx.geo.Azimuthal();
			if(null != info.scale) projection.set_scale(info.scale);
			if(null != info.translate) projection.set_translate(info.translate); else projection.set_translate([0.0,0]);
			if(null != info.mode) projection.set_mode(info.mode);
			if(null != info.origin) projection.set_origin(info.origin);
			return projection;
		default:
			return (function($this) {
				var $r;
				throw new thx.error.Error("the projection '{0}' does not exist or is not implemented",[info.projection],null,{ fileName : "FactoryGeoProjection.hx", lineNumber : 68, className : "rg.factory.FactoryGeoProjection", methodName : "create"});
				return $r;
			}(this));
		}
	}
	,__class__: rg.factory.FactoryGeoProjection
}
rg.factory.FactoryHtmlVisualization = function() {
};
$hxClasses["rg.factory.FactoryHtmlVisualization"] = rg.factory.FactoryHtmlVisualization;
rg.factory.FactoryHtmlVisualization.__name__ = ["rg","factory","FactoryHtmlVisualization"];
rg.factory.FactoryHtmlVisualization.prototype = {
	create: function(type,container,options) {
		switch(type) {
		case "pivottable":
			var chart = new rg.visualization.VisualizationPivotTable(container);
			chart.info = rg.info.Info.feed(new rg.info.InfoPivotTable(),options);
			return chart;
		case "leaderboard":
			var chart = new rg.visualization.VisualizationLeaderboard(container);
			chart.info = rg.info.Info.feed(new rg.info.InfoLeaderboard(),options);
			return chart;
		default:
			throw new thx.error.Error("unsupported visualization '{0}'",null,type,{ fileName : "FactoryHtmlVisualization.hx", lineNumber : 35, className : "rg.factory.FactoryHtmlVisualization", methodName : "create"});
		}
		return null;
	}
	,__class__: rg.factory.FactoryHtmlVisualization
}
rg.factory.FactoryLayout = function() {
};
$hxClasses["rg.factory.FactoryLayout"] = rg.factory.FactoryLayout;
rg.factory.FactoryLayout.__name__ = ["rg","factory","FactoryLayout"];
rg.factory.FactoryLayout.size = function(container,info,heightmargin) {
	var v, width = null == info.width?(v = container.node().clientWidth) > 10?v:400:info.width, height = (null == info.height?(v = container.node().clientHeight) > 10?v:300:info.height) - heightmargin;
	return { width : width, height : height};
}
rg.factory.FactoryLayout.prototype = {
	create: function(info,heightmargin,container) {
		var size = rg.factory.FactoryLayout.size(container,info,heightmargin);
		var layoutName = info.layout;
		if(null == layoutName) layoutName = rg.visualization.Visualizations.layoutDefault.get(info.type);
		if(null == layoutName) throw new thx.error.Error("unable to find a suitable layout for '{0}'",null,info.type,{ fileName : "FactoryLayout.hx", lineNumber : 28, className : "rg.factory.FactoryLayout", methodName : "create"});
		var layout = rg.visualization.Visualizations.instantiateLayout(layoutName,size.width,size.height,container);
		layout.feedOptions(info);
		return layout;
	}
	,__class__: rg.factory.FactoryLayout
}
rg.factory.FactorySvgVisualization = function() {
};
$hxClasses["rg.factory.FactorySvgVisualization"] = rg.factory.FactorySvgVisualization;
rg.factory.FactorySvgVisualization.__name__ = ["rg","factory","FactorySvgVisualization"];
rg.factory.FactorySvgVisualization.prototype = {
	create: function(type,layout,options) {
		switch(type) {
		case "barchart":
			var chart = new rg.visualization.VisualizationBarChart(layout);
			chart.info = chart.infoBar = rg.info.Info.feed(new rg.info.InfoBarChart(),options);
			return chart;
		case "funnelchart":
			var chart = new rg.visualization.VisualizationFunnelChart(layout);
			chart.info = rg.info.Info.feed(new rg.info.InfoFunnelChart(),options);
			return chart;
		case "geo":
			var chart = new rg.visualization.VisualizationGeo(layout);
			chart.info = rg.info.Info.feed(new rg.info.InfoGeo(),options);
			return chart;
		case "heatgrid":
			var chart = new rg.visualization.VisualizationHeatGrid(layout);
			chart.info = chart.infoHeatGrid = rg.info.Info.feed(new rg.info.InfoHeatGrid(),options);
			return chart;
		case "linechart":
			var chart = new rg.visualization.VisualizationLineChart(layout);
			chart.info = chart.infoLine = rg.info.Info.feed(new rg.info.InfoLineChart(),options);
			return chart;
		case "piechart":
			var chart = new rg.visualization.VisualizationPieChart(layout);
			chart.info = rg.info.Info.feed(new rg.info.InfoPieChart(),options);
			return chart;
		case "sankey":
			var chart = new rg.visualization.VisualizationSankey(layout);
			chart.info = rg.info.Info.feed(new rg.info.InfoSankey(),options);
			return chart;
		case "scattergraph":
			var chart = new rg.visualization.VisualizationScatterGraph(layout);
			chart.info = chart.infoScatter = rg.info.Info.feed(new rg.info.InfoScatterGraph(),options);
			return chart;
		case "streamgraph":
			var chart = new rg.visualization.VisualizationStreamGraph(layout);
			chart.info = chart.infoStream = rg.info.Info.feed(new rg.info.InfoStreamGraph(),options);
			return chart;
		default:
			throw new thx.error.Error("unsupported visualization type '{0}'",null,type,{ fileName : "FactorySvgVisualization.hx", lineNumber : 76, className : "rg.factory.FactorySvgVisualization", methodName : "create"});
		}
	}
	,__class__: rg.factory.FactorySvgVisualization
}
rg.factory.FactoryVariable = function() {
	this.independentFactory = new rg.factory.FactoryVariableIndependent();
	this.dependentFactory = new rg.factory.FactoryVariableDependent();
};
$hxClasses["rg.factory.FactoryVariable"] = rg.factory.FactoryVariable;
rg.factory.FactoryVariable.__name__ = ["rg","factory","FactoryVariable"];
rg.factory.FactoryVariable.prototype = {
	createVariables: function(arr) {
		var _g = this;
		return arr.map(function(info) {
			switch( (info.variableType)[1] ) {
			case 1:
				return _g.independentFactory.create(info);
			case 2:
				return _g.dependentFactory.create(info,null);
			case 0:
				return _g.dependentFactory.create(info,null);
			}
		});
	}
	,dependentFactory: null
	,independentFactory: null
	,__class__: rg.factory.FactoryVariable
}
rg.factory.FactoryVariableDependent = function() {
};
$hxClasses["rg.factory.FactoryVariableDependent"] = rg.factory.FactoryVariableDependent;
rg.factory.FactoryVariableDependent.__name__ = ["rg","factory","FactoryVariableDependent"];
rg.factory.FactoryVariableDependent.prototype = {
	create: function(info,isnumeric) {
		if(null == info.type) throw new thx.error.Error("cannot create an axis if type is not specified",null,null,{ fileName : "FactoryVariableDependent.hx", lineNumber : 18, className : "rg.factory.FactoryVariableDependent", methodName : "create"});
		var axiscreator = new rg.factory.FactoryAxis(), variable = new rg.data.VariableDependent(info.type,info.scaleDistribution), axis = axiscreator.create(info.type,isnumeric,variable,info.values);
		variable.setAxis(axis);
		variable.set_minf(rg.factory.FactoryVariableIndependent.convertBound(axis,info.min));
		variable.set_maxf(rg.factory.FactoryVariableIndependent.convertBound(axis,info.max));
		return variable;
	}
	,__class__: rg.factory.FactoryVariableDependent
}
rg.factory.FactoryVariableIndependent = function() {
};
$hxClasses["rg.factory.FactoryVariableIndependent"] = rg.factory.FactoryVariableIndependent;
rg.factory.FactoryVariableIndependent.__name__ = ["rg","factory","FactoryVariableIndependent"];
rg.factory.FactoryVariableIndependent.convertBound = function(axis,value) {
	if(null == value || Reflect.isFunction(value)) return value;
	if(js.Boot.__instanceof(axis,rg.axis.AxisTime)) {
		if(js.Boot.__instanceof(value,Date)) value = (js.Boot.__cast(value , Date)).getTime();
		if(js.Boot.__instanceof(value,Float)) return function(_,_1) {
			return value;
		};
		if(js.Boot.__instanceof(value,String)) return function(_,_1) {
			return thx.date.DateParser.parse(value).getTime();
		};
		throw new thx.error.Error("invalid value '{0}' for time bound",[value],null,{ fileName : "FactoryVariableIndependent.hx", lineNumber : 46, className : "rg.factory.FactoryVariableIndependent", methodName : "convertBound"});
	}
	return function(_,_1) {
		return value;
	};
}
rg.factory.FactoryVariableIndependent.prototype = {
	create: function(info) {
		if(null == info.type) return null;
		var axiscreateer = new rg.factory.FactoryAxis(), variable = new rg.data.VariableIndependent(info.type,info.scaleDistribution), axis = axiscreateer.createDiscrete(info.type,variable,info.values,info.groupBy);
		variable.setAxis(axis);
		variable.set_minf(rg.factory.FactoryVariableIndependent.convertBound(axis,info.min));
		variable.set_maxf(rg.factory.FactoryVariableIndependent.convertBound(axis,info.max));
		return variable;
	}
	,__class__: rg.factory.FactoryVariableIndependent
}
rg.frame = {}
rg.frame.Frame = function() {
	this.x = this.y = this.width = this.height = 0;
};
$hxClasses["rg.frame.Frame"] = rg.frame.Frame;
rg.frame.Frame.__name__ = ["rg","frame","Frame"];
rg.frame.Frame.prototype = {
	set_layout: function(x,y,width,height) {
		if(this.x == x && this.y == y && this.width == width && this.height == height) return;
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
		this.change();
	}
	,change: function() {
	}
	,height: null
	,width: null
	,y: null
	,x: null
	,__class__: rg.frame.Frame
}
rg.frame.FrameLayout = { __ename__ : ["rg","frame","FrameLayout"], __constructs__ : ["Fill","FillPercent","FillRatio","Fixed","Floating"] }
rg.frame.FrameLayout.Fill = function(before,after,min,max) { var $x = ["Fill",0,before,after,min,max]; $x.__enum__ = rg.frame.FrameLayout; $x.toString = $estr; return $x; }
rg.frame.FrameLayout.FillPercent = function(before,after,percent,min,max) { var $x = ["FillPercent",1,before,after,percent,min,max]; $x.__enum__ = rg.frame.FrameLayout; $x.toString = $estr; return $x; }
rg.frame.FrameLayout.FillRatio = function(before,after,ratio) { var $x = ["FillRatio",2,before,after,ratio]; $x.__enum__ = rg.frame.FrameLayout; $x.toString = $estr; return $x; }
rg.frame.FrameLayout.Fixed = function(before,after,size) { var $x = ["Fixed",3,before,after,size]; $x.__enum__ = rg.frame.FrameLayout; $x.toString = $estr; return $x; }
rg.frame.FrameLayout.Floating = function(x,y,width,height) { var $x = ["Floating",4,x,y,width,height]; $x.__enum__ = rg.frame.FrameLayout; $x.toString = $estr; return $x; }
rg.frame.Orientation = { __ename__ : ["rg","frame","Orientation"], __constructs__ : ["Vertical","Horizontal"] }
rg.frame.Orientation.Vertical = ["Vertical",0];
rg.frame.Orientation.Vertical.toString = $estr;
rg.frame.Orientation.Vertical.__enum__ = rg.frame.Orientation;
rg.frame.Orientation.Horizontal = ["Horizontal",1];
rg.frame.Orientation.Horizontal.toString = $estr;
rg.frame.Orientation.Horizontal.__enum__ = rg.frame.Orientation;
rg.frame.Stack = function(width,height,orientation) {
	this.orientation = null == orientation?rg.frame.Orientation.Vertical:orientation;
	this.children = [];
	this.width = width;
	this.height = height;
};
$hxClasses["rg.frame.Stack"] = rg.frame.Stack;
rg.frame.Stack.__name__ = ["rg","frame","Stack"];
rg.frame.Stack.prototype = {
	setSize: function(width,height) {
		if(this.width == width && this.height == height) return this;
		this.width = width;
		this.height = height;
		this.reflow();
		return this;
	}
	,get_length: function() {
		return this.children.length;
	}
	,reflow: function() {
		var available = (function($this) {
			var $r;
			var _g = $this;
			$r = (function($this) {
				var $r;
				switch( (_g.orientation)[1] ) {
				case 0:
					$r = $this.height;
					break;
				case 1:
					$r = $this.width;
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this)), otherdimension = (function($this) {
			var $r;
			var _g1 = $this;
			$r = (function($this) {
				var $r;
				switch( (_g1.orientation)[1] ) {
				case 0:
					$r = $this.width;
					break;
				case 1:
					$r = $this.height;
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this));
		var required = 0, values = [], variables = [], i = 0, variablespace = 0;
		var _g2 = 0, _g3 = this.children;
		while(_g2 < _g3.length) {
			var child = _g3[_g2];
			++_g2;
			var $e = (child.disposition);
			switch( $e[1] ) {
			case 0:
				var max = $e[5], min = $e[4], after = $e[3], before = $e[2];
				if(null == min) min = 0;
				if(null == max) max = available;
				required += min + before + after;
				variablespace += variables[i] = max - min;
				values.push(min + before + after);
				break;
			case 1:
				var max = $e[6], min = $e[5], percent = $e[4], after = $e[3], before = $e[2];
				var size = Math.round(percent * available);
				if(null != min && size < min) size = min;
				if(null != max && size > max) size = max;
				required += size + before + after;
				values.push(size + before + after);
				break;
			case 2:
				var ratio = $e[4], after = $e[3], before = $e[2];
				if(null == ratio) ratio = 1;
				var size = Math.round(otherdimension * ratio);
				required += size + before + after;
				values.push(size + before + after);
				break;
			case 3:
				var size = $e[4], after = $e[3], before = $e[2];
				required += size + before + after;
				values.push(size + before + after);
				break;
			case 4:
				values.push(0);
				break;
			}
			i++;
		}
		available -= required;
		if(available > 0) {
			i = 0;
			var _g2 = 0, _g3 = this.children;
			while(_g2 < _g3.length) {
				var child = _g3[_g2];
				++_g2;
				switch( (child.disposition)[1] ) {
				case 0:
					var size = Math.round(variables[i] / variablespace * available);
					values[i] += size;
					break;
				default:
				}
				i++;
			}
		}
		i = 0;
		var sizeable;
		var pos = 0;
		var _g2 = this;
		switch( (_g2.orientation)[1] ) {
		case 0:
			var _g3 = 0, _g4 = this.children;
			while(_g3 < _g4.length) {
				var child = _g4[_g3];
				++_g3;
				sizeable = child;
				var $e = (child.disposition);
				switch( $e[1] ) {
				case 4:
					var h = $e[5], w = $e[4], y = $e[3], x = $e[2];
					sizeable.set_layout(x,y,w,h);
					break;
				case 3:
					var child_fdisposition_eFixed_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(0,pos + before,this.width,values[i] - after - before);
					break;
				case 0:
					var child_fdisposition_eFill_3 = $e[5], child_fdisposition_eFill_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(0,pos + before,this.width,values[i] - after - before);
					break;
				case 1:
					var child_fdisposition_eFillPercent_4 = $e[6], child_fdisposition_eFillPercent_3 = $e[5], child_fdisposition_eFillPercent_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(0,pos + before,this.width,values[i] - after - before);
					break;
				case 2:
					var child_fdisposition_eFillRatio_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(0,pos + before,this.width,values[i] - after - before);
					break;
				}
				pos += values[i++];
			}
			break;
		case 1:
			var _g3 = 0, _g4 = this.children;
			while(_g3 < _g4.length) {
				var child = _g4[_g3];
				++_g3;
				sizeable = child;
				var $e = (child.disposition);
				switch( $e[1] ) {
				case 4:
					var h = $e[5], w = $e[4], y = $e[3], x = $e[2];
					sizeable.set_layout(x,y,w,h);
					break;
				case 3:
					var child_fdisposition_eFixed_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(pos + before,0,values[i] - after - before,this.height);
					break;
				case 0:
					var child_fdisposition_eFill_3 = $e[5], child_fdisposition_eFill_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(pos + before,0,values[i] - after - before,this.height);
					break;
				case 1:
					var child_fdisposition_eFillPercent_4 = $e[6], child_fdisposition_eFillPercent_3 = $e[5], child_fdisposition_eFillPercent_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(pos + before,0,values[i] - after - before,this.height);
					break;
				case 2:
					var child_fdisposition_eFillRatio_2 = $e[4], after = $e[3], before = $e[2];
					sizeable.set_layout(pos + before,0,values[i] - after - before,this.height);
					break;
				}
				pos += values[i++];
			}
			break;
		}
		if(available < 0) this.moreSpaceRequired(required);
	}
	,removeChild: function(child) {
		if(!HxOverrides.remove(this.children,child)) return false;
		var f = child;
		f.set_parent(null);
		this.reflow();
		return true;
	}
	,addItems: function(it) {
		var added = false;
		var $it0 = $iterator(it)();
		while( $it0.hasNext() ) {
			var child = $it0.next();
			if(null == child) continue;
			added = true;
			this.children.push(child);
			var f = child;
			f.set_parent(this);
		}
		if(added) this.reflow();
		return this;
	}
	,addItem: function(child) {
		if(null == child) return this;
		this.children.push(child);
		var f = child;
		f.set_parent(this);
		this.reflow();
		return this;
	}
	,insertItem: function(pos,child) {
		if(null == child) return this;
		if(pos >= this.children.length) return this.addItem(child);
		if(pos < 0) pos = 0;
		this.children.splice(pos,0,child);
		var f = child;
		f.set_parent(this);
		this.reflow();
		return this;
	}
	,moreSpaceRequired: function(size) {
	}
	,orientation: null
	,height: null
	,width: null
	,children: null
	,__class__: rg.frame.Stack
}
rg.frame.StackItem = function(disposition) {
	rg.frame.Frame.call(this);
	this.set_disposition(disposition);
};
$hxClasses["rg.frame.StackItem"] = rg.frame.StackItem;
rg.frame.StackItem.__name__ = ["rg","frame","StackItem"];
rg.frame.StackItem.__super__ = rg.frame.Frame;
rg.frame.StackItem.prototype = $extend(rg.frame.Frame.prototype,{
	set_disposition: function(v) {
		this.disposition = v;
		if(null != this.parent) this.parent.reflow();
		return v;
	}
	,set_parent: function(v) {
		if(null != this.parent) this.parent.removeChild(this);
		return this.parent = v;
	}
	,parent: null
	,disposition: null
	,__class__: rg.frame.StackItem
});
rg.html = {}
rg.html.chart = {}
rg.html.chart.Leadeboard = function(container) {
	this.ready = new hxevents.Notifier();
	this.container = container;
	this.animated = true;
	this.animationDuration = 1500;
	this.animationEase = thx.math.Equations.elasticf();
	this.animationDelay = 150;
	this._created = 0;
	this.displayGradient = true;
	this.useMax = false;
	this.colorScale = false;
};
$hxClasses["rg.html.chart.Leadeboard"] = rg.html.chart.Leadeboard;
rg.html.chart.Leadeboard.__name__ = ["rg","html","chart","Leadeboard"];
rg.html.chart.Leadeboard.prototype = {
	id: function(dp,_) {
		return rg.util.DataPoints.id(dp,[this.variableDependent.type]);
	}
	,lTitle: function(dp,i) {
		return this.labelDataPointOver(dp,this.stats);
	}
	,lDataPoint: function(dp,i) {
		return this.labelDataPoint(dp,this.stats);
	}
	,lValue: function(dp,i) {
		return this.labelValue(dp,this.stats);
	}
	,lRank: function(dp,i) {
		return this.labelRank(dp,i,this.stats);
	}
	,fadeIn: function(n,i) {
		var me = this;
		dhx.Dom.selectNodeData(n).transition().ease(this.animationEase).duration(null,this.animationDuration).delay(null,this.animationDelay * (i - this._created)).attr("opacity")["float"](1).endNode(function(_,_1) {
			me._created++;
		});
	}
	,onClick: function(dp,_) {
		this.click(dp);
	}
	,data: function(dps) {
		var name = this.variableDependent.type;
		if(null != this.sortDataPoint) dps.sort(this.sortDataPoint);
		if(null == this.variableDependent.stats) return;
		var stats = this.stats = js.Boot.__cast(this.variableDependent.stats , rg.axis.StatsNumeric);
		var choice = this.list.selectAll("li").data(dps,$bind(this,this.id));
		var enterli = choice.enter().append("li");
		enterli.attr("title").stringf($bind(this,this.lTitle));
		enterli.append("div").attr("class").stringf(function(_,i) {
			return i % 2 == 0?"rg_background fill-0":"rg_background";
		});
		var enterlabels = enterli.append("div").attr("class").string("rg_labels");
		if(null != $bind(this,this.labelRank)) {
			var rank = enterlabels.append("div").text().stringf($bind(this,this.lRank));
			if(this.colorScale) rank.attr("class").stringf(function(_,i) {
				return "rg_rank fill fill-" + i;
			}); else rank.attr("class").string("rg_rank");
		}
		if(null != $bind(this,this.labelDataPoint)) enterlabels.append("span").attr("class").string("rg_description color-0").text().stringf($bind(this,this.lDataPoint));
		if(null != $bind(this,this.labelValue)) enterlabels.append("span").attr("class").string("rg_value color-2").text().stringf($bind(this,this.lValue));
		enterli.append("div").attr("class").string("clear");
		if(this.displayBar) {
			var barpadding = enterli.append("div").attr("class").string("rg_barpadding"), enterbar = barpadding.append("div").attr("class").string("rg_barcontainer");
			enterbar.append("div").attr("class").string("rg_barback fill-0");
			enterbar.append("div").attr("class").string("rg_bar fill-0").style("width").stringf($bind(this,this.backgroundSize));
			enterli.append("div").attr("class").string("clear");
		}
		if(null != this.click) enterli.on("click.user",$bind(this,this.onClick));
		if(this.animated) enterli.style("opacity")["float"](0).eachNode($bind(this,this.fadeIn)); else enterli.style("opacity")["float"](1);
		if(this.animated) choice.exit().transition().ease(this.animationEase).duration(null,this.animationDuration).style("opacity")["float"](0).remove(); else choice.exit().remove();
		this.ready.dispatch();
	}
	,backgroundSize: function(dp,i) {
		return 100 * Reflect.field(dp,this.variableDependent.type) / (this.useMax?this.stats.max:this.stats.tot) + "%";
	}
	,setVariables: function(variableIndependents,variableDependents) {
		this.variableDependent = variableDependents[0];
		this.variableIndependent = variableIndependents[0];
	}
	,init: function() {
		var div = this.container.append("div").attr("class").string("leaderboard");
		this.list = div.append("ul");
		div.append("div").attr("class").string("clear");
	}
	,labelValue: function(dp,stats) {
		return rg.util.Properties.formatValue(stats.type,dp);
	}
	,labelRank: function(dp,i,stats) {
		return "" + (i + 1);
	}
	,labelDataPointOver: function(dp,stats) {
		return Floats.format(100 * Reflect.field(dp,stats.type) / (this.useMax?stats.max:stats.tot),"P:1");
	}
	,labelDataPoint: function(dp,stats) {
		return rg.util.Properties.humanize(Reflect.field(dp,this.variableIndependent.type));
	}
	,stats: null
	,_created: null
	,list: null
	,container: null
	,displayBar: null
	,ready: null
	,colorScale: null
	,useMax: null
	,displayGradient: null
	,sortDataPoint: null
	,click: null
	,animationEase: null
	,animationDelay: null
	,animationDuration: null
	,animated: null
	,variableDependent: null
	,variableIndependent: null
	,__class__: rg.html.chart.Leadeboard
}
var thx = {}
thx.color = {}
thx.color.Rgb = function(r,g,b) {
	this.red = Ints.clamp(r,0,255);
	this.green = Ints.clamp(g,0,255);
	this.blue = Ints.clamp(b,0,255);
};
$hxClasses["thx.color.Rgb"] = thx.color.Rgb;
thx.color.Rgb.__name__ = ["thx","color","Rgb"];
thx.color.Rgb.fromInt = function(v) {
	return new thx.color.Rgb(v >> 16 & 255,v >> 8 & 255,v & 255);
}
thx.color.Rgb.interpolatef = function(a,b,equation) {
	var r = Ints.interpolatef(a.red,b.red,equation), g = Ints.interpolatef(a.green,b.green,equation), b1 = Ints.interpolatef(a.blue,b.blue,equation);
	return function(t) {
		return new thx.color.Rgb(r(t),g(t),b1(t));
	};
}
thx.color.Rgb.contrastBW = function(c) {
	var g = thx.color.Grey.toGrey(c);
	var nc = thx.color.Hsl.toHsl(c);
	if(g.grey < .5) return new thx.color.Hsl(nc.hue,nc.saturation,1.0); else return new thx.color.Hsl(nc.hue,nc.saturation,0);
}
thx.color.Rgb.interpolateStepsf = function(steps,equation) {
	if(steps.length <= 0) return (function($this) {
		var $r;
		throw new thx.error.Error("invalid number of steps",null,null,{ fileName : "Rgb.hx", lineNumber : 164, className : "thx.color.Rgb", methodName : "interpolateStepsf"});
		return $r;
	}(this)); else if(steps.length == 1) return function(t) {
		return steps[0];
	}; else if(steps.length == 2) return thx.color.Rgb.interpolatef(steps[0],steps[1],equation);
	var len = steps.length - 1, step = 1 / len, f = [];
	var _g = 0;
	while(_g < len) {
		var i = _g++;
		f[i] = thx.color.Rgb.interpolatef(steps[i],steps[i + 1]);
	}
	return function(t) {
		if(t < 0) t = 0; else if(t > 1) t = 1;
		var pos = t == 1?len - 1:Math.floor(t / step);
		return f[pos](len * (t - pos * step));
	};
}
thx.color.Rgb.prototype = {
	toRgbString: function() {
		return "rgb(" + this.red + "," + this.green + "," + this.blue + ")";
	}
	,hex: function(prefix) {
		if(prefix == null) prefix = "";
		return prefix + StringTools.hex(this.red,2) + StringTools.hex(this.green,2) + StringTools.hex(this.blue,2);
	}
	,red: null
	,green: null
	,blue: null
	,__class__: thx.color.Rgb
}
thx.color.Hsl = function(h,s,l) {
	this.hue = h = Floats.circularWrap(h,360);
	this.saturation = s = Floats.normalize(s);
	this.lightness = l = Floats.normalize(l);
	thx.color.Rgb.call(this,Ints.interpolate(thx.color.Hsl._c(h + 120,s,l),0,255,null),Ints.interpolate(thx.color.Hsl._c(h,s,l),0,255,null),Ints.interpolate(thx.color.Hsl._c(h - 120,s,l),0,255,null));
};
$hxClasses["thx.color.Hsl"] = thx.color.Hsl;
thx.color.Hsl.__name__ = ["thx","color","Hsl"];
thx.color.Hsl._c = function(d,s,l) {
	var m2 = l <= 0.5?l * (1 + s):l + s - l * s;
	var m1 = 2 * l - m2;
	d = Floats.circularWrap(d,360);
	if(d < 60) return m1 + (m2 - m1) * d / 60; else if(d < 180) return m2; else if(d < 240) return m1 + (m2 - m1) * (240 - d) / 60; else return m1;
}
thx.color.Hsl.toHsl = function(c) {
	var r = c.red / 255.0;
	var g = c.green / 255.0, b = c.blue / 255.0, min = Floats.min(r < g?r:g,b), max = Floats.max(r > g?r:g,b), delta = max - min, h, s, l = (max + min) / 2;
	if(delta == 0.0) s = h = 0.0; else {
		s = l < 0.5?delta / (max + min):delta / (2 - max - min);
		if(r == max) h = (g - b) / delta + (g < b?6:0); else if(g == max) h = (b - r) / delta + 2; else h = (r - g) / delta + 4;
		h *= 60;
	}
	return new thx.color.Hsl(h,s,l);
}
thx.color.Hsl.darker = function(color,t,equation) {
	return new thx.color.Hsl(color.hue,color.saturation,Floats.interpolate(t,color.lightness,0,equation));
}
thx.color.Hsl.lighter = function(color,t,equation) {
	return new thx.color.Hsl(color.hue,color.saturation,Floats.interpolate(t,color.lightness,1,equation));
}
thx.color.Hsl.interpolatef = function(a,b,equation) {
	return function(t) {
		return new thx.color.Hsl(Floats.interpolate(t,a.hue,b.hue,equation),Floats.interpolate(t,a.saturation,b.saturation,equation),Floats.interpolate(t,a.lightness,b.lightness,equation));
	};
}
thx.color.Hsl.__super__ = thx.color.Rgb;
thx.color.Hsl.prototype = $extend(thx.color.Rgb.prototype,{
	lightness: null
	,saturation: null
	,hue: null
	,__class__: thx.color.Hsl
});
thx.math = {}
thx.math.Equations = function() { }
$hxClasses["thx.math.Equations"] = thx.math.Equations;
thx.math.Equations.__name__ = ["thx","math","Equations"];
thx.math.Equations.linear = function(v) {
	return v;
}
thx.math.Equations.polynomial = function(t,e) {
	return Math.pow(t,e);
}
thx.math.Equations.cubic = function(t) {
	return thx.math.Equations.polynomial(t,3);
}
thx.math.Equations.elasticf = function(a,p) {
	var s;
	if(null == p) p = 0.45;
	if(null == a) {
		a = 1;
		s = p / 4;
	} else s = p / (2 * Math.PI) / Math.asin(1 / a);
	return function(t) {
		return 1 + a * Math.pow(2,10 * -t) * Math.sin((t - s) * 2 * Math.PI / p);
	};
}
rg.html.chart.PivotTable = function(container) {
	this.ready = new hxevents.Notifier();
	this.container = container;
	this.displayColumnTotal = true;
	this.displayRowTotal = true;
	this.displayHeatMap = true;
	this.colorStart = rg.html.chart.PivotTable.defaultColorStart;
	this.colorEnd = rg.html.chart.PivotTable.defaultColorEnd;
	this.incolumns = 1;
};
$hxClasses["rg.html.chart.PivotTable"] = rg.html.chart.PivotTable;
rg.html.chart.PivotTable.__name__ = ["rg","html","chart","PivotTable"];
rg.html.chart.PivotTable.prototype = {
	range: function(variable) {
		return variable.axis.range(variable.min(),variable.max());
	}
	,transformData: function(dps) {
		var column_headers = [], row_headers = [], columns = [], rows = [], tcalc = new rg.axis.StatsNumeric(null);
		var variable;
		var _g1 = 0, _g = Ints.min(1,this.columnVariables.length);
		while(_g1 < _g) {
			var i = _g1++;
			variable = this.columnVariables[i];
			column_headers.push(variable.type);
			var _g2 = 0, _g3 = this.range(variable);
			while(_g2 < _g3.length) {
				var value = _g3[_g2];
				++_g2;
				columns.push({ values : [value], stats : null, type : variable.type});
			}
		}
		var _g1 = 1, _g = this.columnVariables.length;
		while(_g1 < _g) {
			var i = _g1++;
			variable = this.columnVariables[i];
			column_headers.push(variable.type);
			var tmp = columns.slice();
			columns = [];
			var _g2 = 0;
			while(_g2 < tmp.length) {
				var src = tmp[_g2];
				++_g2;
				var _g3 = 0, _g4 = this.range(variable);
				while(_g3 < _g4.length) {
					var value = _g4[_g3];
					++_g3;
					var column = Objects.clone(src);
					column.values.push(value);
					columns.push(column);
				}
			}
		}
		var name, headers = column_headers;
		var _g1 = 0, _g = columns.length;
		while(_g1 < _g) {
			var i = _g1++;
			var column1 = [columns[i]], ccalc = new rg.axis.StatsNumeric(null);
			column1[0].stats = ccalc;
			var _g2 = 0, _g3 = dps.filter((function(column1) {
				return function(dp) {
					var _g31 = 0, _g21 = headers.length;
					while(_g31 < _g21) {
						var j = _g31++;
						name = headers[j];
						if(name.indexOf("time:") >= 0 && Dates.snap(Reflect.field(dp,name),HxOverrides.substr(name,name.indexOf("time:") + "time:".length,null)) == column1[0].values[j] || Reflect.field(dp,name) == column1[0].values[j]) return true;
					}
					return false;
				};
			})(column1));
			while(_g2 < _g3.length) {
				var dp = _g3[_g2];
				++_g2;
				var v = Reflect.field(dp,this.cellVariable.type);
				if(null == v) continue;
				ccalc.add(v);
				tcalc.add(v);
			}
		}
		var _g1 = 0, _g = Ints.min(1,this.rowVariables.length);
		while(_g1 < _g) {
			var i = _g1++;
			variable = this.rowVariables[i];
			row_headers.push(variable.type);
			var _g2 = 0, _g3 = this.range(variable);
			while(_g2 < _g3.length) {
				var value = _g3[_g2];
				++_g2;
				rows.push({ values : [value], stats : null, cells : null});
			}
		}
		var _g1 = 1, _g = this.rowVariables.length;
		while(_g1 < _g) {
			var i = _g1++;
			variable = this.rowVariables[i];
			row_headers.push(variable.type);
			var tmp = rows.slice();
			rows = [];
			var _g2 = 0;
			while(_g2 < tmp.length) {
				var src = tmp[_g2];
				++_g2;
				var _g3 = 0, _g4 = this.range(variable);
				while(_g3 < _g4.length) {
					var value = _g4[_g3];
					++_g3;
					var row = Objects.clone(src);
					row.values.push(value);
					rows.push(row);
				}
			}
		}
		var name1, headers1 = row_headers;
		var _g1 = 0, _g = rows.length;
		while(_g1 < _g) {
			var i = _g1++;
			var row1 = [rows[i]];
			row1[0].stats = new rg.axis.StatsNumeric(null);
			row1[0].cells = [];
			var rdps;
			rdps = dps.filter((function(row1) {
				return function(d) {
					var _g3 = 0, _g2 = headers1.length;
					while(_g3 < _g2) {
						var j = _g3++;
						name1 = headers1[j];
						if(name1.indexOf("time:") >= 0 && Dates.snap(Reflect.field(d,name1),HxOverrides.substr(name1,name1.indexOf("time:") + "time:".length,null)) != row1[0].values[j] || Reflect.field(d,name1) != row1[0].values[j]) return false;
					}
					return true;
				};
			})(row1));
			var _g3 = 0, _g2 = columns.length;
			while(_g3 < _g2) {
				var k = _g3++;
				var column2 = [columns[k]];
				if(column2[0].type.indexOf("time:") >= 0) {
					var periodicity = [rg.util.Properties.periodicity(column2[0].type)];
					var dp = Arrays.firstf(rdps,(function(periodicity,column2) {
						return function(dp1) {
							var _g5 = 0, _g4 = column2[0].values.length;
							while(_g5 < _g4) {
								var i1 = _g5++;
								if(Dates.snap(Reflect.field(dp1,column_headers[i1]),periodicity[0]) != column2[0].values[i1]) return false;
							}
							return true;
						};
					})(periodicity,column2));
					var v = Reflect.field(dp,this.cellVariable.type);
					if(null == v) {
						row1[0].cells.push({ });
						continue;
					}
					row1[0].cells.push(dp);
					row1[0].stats.add(v);
				} else {
					var dp = Arrays.firstf(rdps,(function(column2) {
						return function(dp1) {
							var _g5 = 0, _g4 = column2[0].values.length;
							while(_g5 < _g4) {
								var i1 = _g5++;
								if(Reflect.field(dp1,column_headers[i1]) != column2[0].values[i1]) return false;
							}
							return true;
						};
					})(column2));
					var v = Reflect.field(dp,this.cellVariable.type);
					if(null == v) {
						row1[0].cells.push({ });
						continue;
					}
					row1[0].cells.push(dp);
					row1[0].stats.add(v);
				}
			}
		}
		return { column_headers : column_headers, row_headers : row_headers, columns : columns, rows : rows, stats : tcalc};
	}
	,setVariables: function(variableIndependents,variableDependents) {
		this.cellVariable = variableDependents[0];
		this.columnVariables = [];
		var _g1 = 0, _g = this.incolumns;
		while(_g1 < _g) {
			var i = _g1++;
			this.columnVariables.push(variableIndependents[i]);
		}
		this.rowVariables = [];
		var _g1 = this.incolumns, _g = variableIndependents.length;
		while(_g1 < _g) {
			var i = _g1++;
			this.rowVariables.push(variableIndependents[i]);
		}
	}
	,init: function() {
	}
	,prependSpacer: function(counter,tr) {
		if(counter == 0) return;
		var th = tr.append("th").attr("class").string("spacer");
		if(counter > 1) th.attr("colspan")["float"](counter);
	}
	,buildValue: function(value,header,counter,tr) {
		var th = tr.append("th").text().string(this.labelAxisValue(value,header));
		if(counter > 1) th.attr("colspan")["float"](counter);
		var clsbuf = ["column value"];
		if(null != this.valueclass) {
			var cls = this.valueclass(value,header);
			if(null != cls) clsbuf.push(cls);
		}
		th.attr("class").string(clsbuf.join(" "));
	}
	,formatDataPointOver: function(dp,_) {
		return this.labelDataPointOver(dp,this.stats);
	}
	,formatDataPoint: function(dp,_) {
		return this.labelDataPoint(dp,this.stats);
	}
	,formatTotalOver: function(v,_) {
		return this.labelTotalOver(v,this.stats);
	}
	,formatTotal: function(v,_) {
		return this.labelTotal(v,this.stats);
	}
	,onClick: function(dp,_,_1) {
		this.click(dp);
	}
	,data: function(dps) {
		var d = this.transformData(dps), table = this.container.append("table").classed().add("pivot-table"), thead = table.append("thead"), leftspan = d.rows.length > 0?d.rows[0].values.length:0, color = thx.color.Rgb.interpolatef(this.colorStart,this.colorEnd);
		this.stats = d.stats;
		if(d.columns.length > 0) {
			var _g1 = 0, _g = d.column_headers.length;
			while(_g1 < _g) {
				var i = _g1++;
				var tr = thead.append("tr");
				this.prependSpacer(leftspan,tr);
				var header = tr.append("th").text().string(this.labelAxis(d.column_headers[i]));
				var clsbuf = ["col-header"];
				if(null != this.headerclass) {
					var v = this.headerclass(d.column_headers[i]);
					if(null != v) clsbuf.push(v);
				}
				header.attr("class").string(clsbuf.join(" "));
				if(d.columns.length > 1) header.attr("colspan")["float"](d.columns.length);
				var counter = 1, last = d.columns[0].values[i];
				tr = thead.append("tr");
				if(i == d.column_headers.length - 1) {
					var _g2 = 0, _g3 = d.row_headers;
					while(_g2 < _g3.length) {
						var h = _g3[_g2];
						++_g2;
						var th = tr.append("th").text().string(this.labelAxis(h));
						var clsbuf1 = ["row-header"];
						if(null != this.headerclass) {
							var v = this.headerclass(h);
							if(null != v) clsbuf1.push(v);
						}
						th.attr("class").string(clsbuf1.join(" "));
					}
				} else this.prependSpacer(leftspan,tr);
				var _g3 = 1, _g2 = d.columns.length;
				while(_g3 < _g2) {
					var j = _g3++;
					var value = d.columns[j].values[i];
					if(last == value) counter++; else {
						this.buildValue(last,d.column_headers[i],counter,tr);
						counter = 1;
						last = value;
					}
				}
				if(null != last) this.buildValue(last,d.column_headers[i],counter,tr);
			}
		}
		if(d.column_headers.length == 0) {
			var tr = thead.append("tr");
			var _g = 0, _g1 = d.row_headers;
			while(_g < _g1.length) {
				var h = _g1[_g];
				++_g;
				tr.append("th").attr("class").string("row header").text().string(this.labelAxis(h));
			}
		}
		var tbody = table.append("tbody"), last = [];
		var _g = 0, _g1 = d.rows;
		while(_g < _g1.length) {
			var row = _g1[_g];
			++_g;
			var tr = tbody.append("tr"), len = row.values.length;
			var _g2 = 0;
			while(_g2 < len) {
				var i = _g2++;
				var v = row.values[i], rep = v == last[i];
				if(!rep) {
					last[i] = v;
					var _g3 = i + 1;
					while(_g3 < len) {
						var j = _g3++;
						last[j] = null;
					}
				}
				var th = tr.append("th").text().string(rep?"":this.labelAxisValue(v,d.row_headers[i]));
				var clsbuf = ["row value"];
				if(rep) clsbuf.push("empty");
				if(null != this.valueclass) {
					var cls = this.valueclass(v,d.row_headers[i]);
					if(null != cls) clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}
			var v;
			var _g2 = 0, _g3 = row.cells;
			while(_g2 < _g3.length) {
				var cell = _g3[_g2];
				++_g2;
				var td = tr.append("td").text().string(this.formatDataPoint(cell)).attr("title").string(this.formatDataPointOver(cell));
				if(null != this.click) td.onNode("click",(function(f,dp) {
					return function(_,_1) {
						return f(dp,_,_1);
					};
				})($bind(this,this.onClick),cell));
				if(this.displayHeatMap && !Math.isNaN(v = Reflect.field(cell,this.cellVariable.type) / d.stats.max)) {
					var c = color(v);
					td.style("color").color(thx.color.Rgb.contrastBW(c)).style("background-color").color(c);
				}
				var clsbuf = [];
				if(null != this.cellclass) {
					var cls = this.cellclass(cell,row.stats);
					if(null != cls) clsbuf.push(cls);
				}
				td.attr("class").string(clsbuf.join(" "));
			}
			if(this.displayRowTotal && d.columns.length > 1) {
				var th = tr.append("th").text().string(this.formatTotal(row.stats.tot));
				var title = this.formatTotalOver(row.stats.tot);
				if(null != title) th.attr("title").string(title);
				var clsbuf = ["row total"];
				if(null != this.totalclass) {
					var cls = this.totalclass(row.stats.tot,row.values);
					if(null != cls) clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}
		}
		var tfoot = table.append("tfoot");
		if(this.displayColumnTotal && d.rows.length > 1) {
			var tr = tfoot.append("tr");
			this.prependSpacer(leftspan,tr);
			var _g = 0, _g1 = d.columns;
			while(_g < _g1.length) {
				var col = _g1[_g];
				++_g;
				var title = this.formatTotalOver(col.stats.tot);
				var th = tr.append("th").text().string(this.formatTotal(col.stats.tot));
				if(null != title) th.attr("title").string(title);
				var clsbuf = ["column total"];
				if(null != this.totalclass) {
					var cls = this.totalclass(col.stats.tot,col.values);
					if(null != cls) clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}
			if(this.displayRowTotal && d.columns.length > 1) {
				var th = tr.append("th").text().string(this.formatTotal(d.stats.tot)).attr("title").string(this.formatTotalOver(d.stats.tot));
				var clsbuf = ["table total"];
				if(null != this.totalclass) {
					var cls = this.totalclass(d.stats.tot,[]);
					if(null != cls) clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}
		}
		this.ready.dispatch();
	}
	,labelTotalOver: function(v,stats) {
		return thx.culture.FormatNumber.percent(100 * v / stats.tot,1);
	}
	,labelTotal: function(v,stats) {
		return thx.culture.FormatNumber["int"](v);
	}
	,labelAxisValue: function(v,axis) {
		if(axis.indexOf("time:") >= 0) {
			var p = HxOverrides.substr(axis,axis.indexOf("time:") + "time:".length,null);
			return rg.util.Periodicity.format(p,v);
		} else return rg.util.RGStrings.humanize(v);
	}
	,labelAxis: function(v) {
		return rg.util.RGStrings.humanize(v);
	}
	,labelDataPointOver: function(dp,stats) {
		var v = Reflect.field(dp,this.cellVariable.type);
		if(Math.isNaN(v)) return "0";
		return thx.culture.FormatNumber.percent(100 * v / stats.tot,1);
	}
	,labelDataPoint: function(dp,stats) {
		var v = Reflect.field(dp,this.cellVariable.type);
		if(Math.isNaN(v)) return "0";
		return thx.culture.FormatNumber["int"](v);
	}
	,stats: null
	,container: null
	,totalclass: null
	,headerclass: null
	,valueclass: null
	,cellclass: null
	,click: null
	,incolumns: null
	,cellVariable: null
	,rowVariables: null
	,columnVariables: null
	,ready: null
	,colorEnd: null
	,colorStart: null
	,displayHeatMap: null
	,displayRowTotal: null
	,displayColumnTotal: null
	,__class__: rg.html.chart.PivotTable
}
rg.html.widget = {}
rg.html.widget.DownloaderMenu = function(handler,position,formats,container) {
	this.handler = handler;
	this.formats = null == formats?rg.html.widget.DownloaderMenu.DEFAULT_FORMATS:formats;
	this.title = rg.html.widget.DownloaderMenu.DEFAULT_TITLE;
	this.build(position,container);
};
$hxClasses["rg.html.widget.DownloaderMenu"] = rg.html.widget.DownloaderMenu;
rg.html.widget.DownloaderMenu.__name__ = ["rg","html","widget","DownloaderMenu"];
rg.html.widget.DownloaderMenu.prototype = {
	click: function(format,_) {
		var _g = this;
		this.menu.classed().add("downloading");
		this.handler(format,this.backgroundColor,function(_1) {
			_g.menu.classed().remove("downloading");
			return true;
		},function(e) {
			_g.menu.classed().remove("downloading");
			js.Browser.window.alert("ERROR: " + e);
		});
	}
	,createMenu: function(container) {
		this.menu = container.append("div").attr("class").string("rg menu");
		var options = this.menu.append("div").attr("class").string("options");
		var title = options.append("div").attr("class").string("title").html().string(this.title);
		var list = options.append("ul").selectAll("li").data(this.formats);
		list.enter().append("li").on("click.download",$bind(this,this.click)).html().stringf(function(d,i) {
			return d;
		});
	}
	,build: function(position,container) {
		this.createMenu(container);
		var el = this.menu.node();
		var $e = (position);
		switch( $e[1] ) {
		case 6:
			container.node().parentNode.insertBefore(el,container.node().nextSibling);
			break;
		case 5:
			container.node().parentNode.insertBefore(el,container.node());
			break;
		case 3:
			this.menu.classed().add("bottom").classed().add("left");
			break;
		case 4:
			this.menu.classed().add("bottom").classed().add("right");
			break;
		case 0:
			var selector = $e[2];
			dhx.Dom.select(selector).node().appendChild(el);
			break;
		case 1:
			this.menu.classed().add("top").classed().add("left");
			break;
		case 2:
			this.menu.classed().add("top").classed().add("right");
			break;
		}
	}
	,menu: null
	,backgroundColor: null
	,title: null
	,formats: null
	,handler: null
	,__class__: rg.html.widget.DownloaderMenu
}
rg.html.widget.DownloaderPosition = { __ename__ : ["rg","html","widget","DownloaderPosition"], __constructs__ : ["ElementSelector","TopLeft","TopRight","BottomLeft","BottomRight","Before","After"] }
rg.html.widget.DownloaderPosition.ElementSelector = function(selector) { var $x = ["ElementSelector",0,selector]; $x.__enum__ = rg.html.widget.DownloaderPosition; $x.toString = $estr; return $x; }
rg.html.widget.DownloaderPosition.TopLeft = ["TopLeft",1];
rg.html.widget.DownloaderPosition.TopLeft.toString = $estr;
rg.html.widget.DownloaderPosition.TopLeft.__enum__ = rg.html.widget.DownloaderPosition;
rg.html.widget.DownloaderPosition.TopRight = ["TopRight",2];
rg.html.widget.DownloaderPosition.TopRight.toString = $estr;
rg.html.widget.DownloaderPosition.TopRight.__enum__ = rg.html.widget.DownloaderPosition;
rg.html.widget.DownloaderPosition.BottomLeft = ["BottomLeft",3];
rg.html.widget.DownloaderPosition.BottomLeft.toString = $estr;
rg.html.widget.DownloaderPosition.BottomLeft.__enum__ = rg.html.widget.DownloaderPosition;
rg.html.widget.DownloaderPosition.BottomRight = ["BottomRight",4];
rg.html.widget.DownloaderPosition.BottomRight.toString = $estr;
rg.html.widget.DownloaderPosition.BottomRight.__enum__ = rg.html.widget.DownloaderPosition;
rg.html.widget.DownloaderPosition.Before = ["Before",5];
rg.html.widget.DownloaderPosition.Before.toString = $estr;
rg.html.widget.DownloaderPosition.Before.__enum__ = rg.html.widget.DownloaderPosition;
rg.html.widget.DownloaderPosition.After = ["After",6];
rg.html.widget.DownloaderPosition.After.toString = $estr;
rg.html.widget.DownloaderPosition.After.__enum__ = rg.html.widget.DownloaderPosition;
rg.html.widget.DownloaderPositions = function() { }
$hxClasses["rg.html.widget.DownloaderPositions"] = rg.html.widget.DownloaderPositions;
rg.html.widget.DownloaderPositions.__name__ = ["rg","html","widget","DownloaderPositions"];
rg.html.widget.DownloaderPositions.parse = function(v) {
	var _g = v.toLowerCase();
	switch(_g) {
	case "topleft":
		return rg.html.widget.DownloaderPosition.TopLeft;
	case "topright":case "auto":
		return rg.html.widget.DownloaderPosition.TopRight;
	case "bottomleft":
		return rg.html.widget.DownloaderPosition.BottomLeft;
	case "bottomright":
		return rg.html.widget.DownloaderPosition.BottomRight;
	case "before":
		return rg.html.widget.DownloaderPosition.Before;
	case "after":
		return rg.html.widget.DownloaderPosition.After;
	default:
		return rg.html.widget.DownloaderPosition.ElementSelector(v);
	}
}
rg.html.widget.Tooltip = function(el) {
	this.visible = false;
	el = null == el?js.Browser.document.body:el;
	this.tooltip = dhx.Dom.selectNode(el).append("div").style("display").string("none").style("position").string("absolute").style("opacity")["float"](0).style("left").string("0px").style("top").string("0px").attr("class").string("rg tooltip").style("z-index").string("1000000");
	this._anchor = this.tooltip.append("div").style("display").string("block").style("position").string("absolute");
	this.setAnchorClass("");
	this.container = this.tooltip.append("div").style("position").string("relative").attr("class").string("rg_container");
	this.background = this.container.append("div").style("display").string("block").style("position").string("static").append("div").style("z-index").string("-1").attr("class").string("rg_background").style("position").string("absolute").style("left").string("0").style("right").string("0").style("top").string("0").style("bottom").string("0");
	this.content = this.container.append("div").attr("class").string("rg_content");
	this.content.onNode("DOMSubtreeModified",$bind(this,this.resize));
	this.anchortype = "bottomright";
	this.anchordistance = 0;
};
$hxClasses["rg.html.widget.Tooltip"] = rg.html.widget.Tooltip;
rg.html.widget.Tooltip.__name__ = ["rg","html","widget","Tooltip"];
rg.html.widget.Tooltip.get_instance = function() {
	if(null == rg.html.widget.Tooltip.instance) {
		rg.html.widget.Tooltip.instance = new rg.html.widget.Tooltip();
		ReportGrid.tooltip = rg.html.widget.Tooltip.instance;
	}
	return rg.html.widget.Tooltip.instance;
}
rg.html.widget.Tooltip.prototype = {
	reanchor: function() {
		if(!this.visible) return;
		var width = this.container.style("width").getFloat(), height = this.container.style("height").getFloat();
		var type = this.anchortype;
		switch(type) {
		case "top":case "bottom":case "center":
			this.container.style("left").string(-width / 2 + "px");
			break;
		case "left":case "topleft":case "bottomleft":
			this.container.style("left").string(this.anchordistance + "px");
			break;
		case "right":case "topright":case "bottomright":
			this.container.style("left").string(-this.anchordistance - width + "px");
			break;
		default:
			throw new thx.error.Error("invalid anchor point: " + this.anchortype,null,null,{ fileName : "Tooltip.hx", lineNumber : 157, className : "rg.html.widget.Tooltip", methodName : "reanchor"});
		}
		switch(type) {
		case "top":case "topleft":case "topright":
			this.container.style("top").string(this.anchordistance + "px");
			break;
		case "left":case "center":case "right":
			this.container.style("top").string(-height / 2 + "px");
			break;
		case "bottom":case "bottomleft":case "bottomright":
			this.container.style("top").string(-this.anchordistance - height + "px");
			break;
		}
	}
	,resize: function(_,_1) {
		this.reanchor();
	}
	,setAnchorColor: function(color) {
		this._anchor.style("background-color").string(color);
	}
	,setAnchorClass: function(value) {
		this._anchor.attr("class").string("rg_anchor " + value);
	}
	,anchor: function(type,distance) {
		if(null == distance) distance = 0;
		if(this.anchortype == type && this.anchordistance == distance) return;
		this.anchortype = type;
		this.anchordistance = distance;
		this.reanchor();
	}
	,moveAt: function(x,y) {
		this.tooltip.style("left").string(x + "px").style("top").string(y + "px");
	}
	,showAt: function(x,y) {
		this.moveAt(x,y);
		this.show();
	}
	,hide: function() {
		if(!this.visible) return;
		this.visible = false;
		this.tooltip.style("opacity")["float"](0).style("display").string("none");
	}
	,show: function() {
		if(this.visible) return;
		this.tooltip.style("display").string("block");
		this.visible = true;
		this.reanchor();
		this.tooltip.style("opacity")["float"](1);
	}
	,html: function(value) {
		this.content.node().innerHTML = value;
		this.reanchor();
	}
	,visible: null
	,anchordistance: null
	,anchortype: null
	,content: null
	,background: null
	,container: null
	,_anchor: null
	,tooltip: null
	,__class__: rg.html.widget.Tooltip
}
rg.info = {}
rg.info.Info = function() { }
$hxClasses["rg.info.Info"] = rg.info.Info;
rg.info.Info.__name__ = ["rg","info","Info"];
rg.info.Info.feed = function(info,ob) {
	if(null == ob) return info;
	var cl = Type.getClass(info), method = Reflect.field(cl,"filters");
	if(null == method) return info;
	var descriptions = method.apply(cl,[]), value;
	var _g = 0;
	while(_g < descriptions.length) {
		var description = descriptions[_g];
		++_g;
		if(Reflect.hasField(ob,description.name)) {
			value = Reflect.field(ob,description.name);
			var _g1 = description.transformer.transform(value);
			var $e = (_g1);
			switch( $e[1] ) {
			case 0:
				var pairs = $e[2];
				var $it0 = $iterator(pairs)();
				while( $it0.hasNext() ) {
					var pair = $it0.next();
					info[pair.name] = pair.value;
				}
				break;
			case 1:
				var reasons = $e[2];
				rg.info.Info.warn(description.name,reasons);
				break;
			}
		}
	}
	return info;
}
rg.info.Info.warn = function(name,message) {
	rg.info.Info.warner("the parameter " + name + " has not been applied because: " + Std.string(message));
}
rg.info.InfoAnimation = function() {
	this.animated = false;
	this.duration = 1500;
	this.delay = 150;
	this.ease = thx.math.Equations.elasticf();
};
$hxClasses["rg.info.InfoAnimation"] = rg.info.InfoAnimation;
rg.info.InfoAnimation.__name__ = ["rg","info","InfoAnimation"];
rg.info.InfoAnimation.filters = function() {
	return [rg.info.filter.FilterDescription.toBool("animated"),rg.info.filter.FilterDescription.toInt("duration"),rg.info.filter.FilterDescription.toInt("delay"),rg.info.filter.FilterDescription.toExpressionFunction("ease",["value"])];
}
rg.info.InfoAnimation.prototype = {
	delay: null
	,ease: null
	,duration: null
	,animated: null
	,__class__: rg.info.InfoAnimation
}
rg.info.InfoCartesianChart = function() {
	this.animation = new rg.info.InfoAnimation();
	this.label = new rg.info.InfoLabelAxis();
	this.displayMinorTick = function(_) {
		return true;
	};
	this.displayMajorTick = function(_) {
		return true;
	};
	this.displayLabelTick = function(_) {
		return true;
	};
	this.displayAnchorLineTick = function(_) {
		return false;
	};
	this.displayMinorRule = function(_) {
		return false;
	};
	this.displayMajorRule = function(_) {
		return false;
	};
	this.displayAnchorLineRule = function(_) {
		return false;
	};
	this.labelOrientation = function(_) {
		return null;
	};
	this.labelAnchor = function(_) {
		return null;
	};
	this.labelAngle = function(_) {
		return null;
	};
	this.lengthTickMinor = 2;
	this.lengthTickMajor = 5;
	this.paddingTickMinor = 1;
	this.paddingTickMajor = 1;
	this.paddingLabel = 10;
};
$hxClasses["rg.info.InfoCartesianChart"] = rg.info.InfoCartesianChart;
rg.info.InfoCartesianChart.__name__ = ["rg","info","InfoCartesianChart"];
rg.info.InfoCartesianChart.filters = function() {
	return [rg.info.filter.FilterDescription.toInfo("animation",null,rg.info.InfoAnimation),rg.info.filter.FilterDescription.toFunction("click"),rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabelAxis),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displaytickmarks",["type"],["displayMinorTick","displayMajorTick","displayLabelTick"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displaytickminor",["type"],["displayMinorTick"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displaytickmajor",["type"],["displayMajorTick"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayticklabel",["type"],["displayLabelTick"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayanchorlinetick",["type"],["displayAnchorLineTick"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayrules",["type"],["displayMinorRule","displayMajorRule"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayruleminor",["type"],["displayMinorRule"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayrulemajor",["type"],["displayMajorRule"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayanchorlinerule",["type"],["displayAnchorLineRule"]),rg.info.filter.FilterDescription.toFloat("lengthtick",["lengthTickMajor","lengthTickMinor"]),rg.info.filter.FilterDescription.toFloat("lengthtickminor",["lengthTickMinor"]),rg.info.filter.FilterDescription.toFloat("lengthtickmajor",["lengthTickMajor"]),rg.info.filter.FilterDescription.toFloat("paddingtick",["paddingTickMajor","paddingTickMinor"]),rg.info.filter.FilterDescription.toFloat("paddingtickminor",["paddingTickMinor"]),rg.info.filter.FilterDescription.toFloat("paddingtickmajor",["paddingTickMajor"]),rg.info.filter.FilterDescription.toFloat("paddingticklabel",["paddingLabel"]),rg.info.filter.FilterDescription.toExpressionFunctionOrString("labelorientation",["type"],["labelOrientation"]),rg.info.filter.FilterDescription.toExpressionFunctionOrString("labelanchor",["type"],["labelAnchor"]),rg.info.filter.FilterDescription.toExpressionFunctionOrFloat("labelangle",["type"],["labelAngle"]),rg.info.filter.FilterDescription.simplified("labelhorizontal",["labelAnchor"],function(v) {
		return v == false?function(v1) {
			return "right";
		}:function(v1) {
			return null;
		};
	},rg.info.filter.ReturnMessageIfNot.isBool),rg.info.filter.FilterDescription.simplified("labelhorizontal",["labelAngle"],function(v) {
		return v == false?function(v1) {
			return 0;
		}:function(v1) {
			return null;
		};
	},rg.info.filter.ReturnMessageIfNot.isBool)];
}
rg.info.InfoCartesianChart.prototype = {
	paddingLabel: null
	,paddingTickMajor: null
	,paddingTickMinor: null
	,lengthTickMajor: null
	,lengthTickMinor: null
	,labelAngle: null
	,labelAnchor: null
	,labelOrientation: null
	,displayAnchorLineRule: null
	,displayMajorRule: null
	,displayMinorRule: null
	,displayAnchorLineTick: null
	,displayLabelTick: null
	,displayMajorTick: null
	,displayMinorTick: null
	,label: null
	,click: null
	,animation: null
	,__class__: rg.info.InfoCartesianChart
}
rg.info.InfoBarChart = function() {
	rg.info.InfoCartesianChart.call(this);
	this.segment = new rg.info.InfoSegment();
	this.stacked = true;
	this.effect = rg.svg.chart.GradientEffect.Gradient(1.25);
	this.barPadding = 12;
	this.barPaddingAxis = 4;
	this.barPaddingDataPoint = 2;
	this.horizontal = false;
	this.startat = null;
};
$hxClasses["rg.info.InfoBarChart"] = rg.info.InfoBarChart;
rg.info.InfoBarChart.__name__ = ["rg","info","InfoBarChart"];
rg.info.InfoBarChart.filters = function() {
	return [rg.info.filter.FilterDescription.toBool("stacked"),rg.info.filter.FilterDescription.toBool("horizontal"),rg.info.filter.FilterDescription.simplified("effect",null,rg.svg.chart.GradientEffects.parse,rg.info.filter.ReturnMessageChainer.or(rg.info.filter.ReturnMessageIfNot.isString,rg.info.filter.ReturnMessageChainer.make(rg.svg.chart.GradientEffects.canParse,"invalid gradient effect: {0}"))),rg.info.filter.FilterDescription.toExpressionFunctionOrString("barclass",[null,"stats"]),rg.info.filter.FilterDescription.toFloat("barpadding",["barPadding"]),rg.info.filter.FilterDescription.toFloat("barpaddingaxis",["barPaddingAxis"]),rg.info.filter.FilterDescription.toFloat("barpaddingdatapoint",["barPaddingDataPoint"]),rg.info.filter.FilterDescription.simplified("segmenton",["segment"],function(value) {
		return rg.info.Info.feed(new rg.info.InfoSegment(),{ on : value});
	},rg.info.filter.ReturnMessageIfNot.isString),rg.info.filter.FilterDescription.toInfo("segment",null,rg.info.InfoSegment),rg.info.filter.FilterDescription.toStr("startat")].concat(rg.info.InfoCartesianChart.filters());
}
rg.info.InfoBarChart.__super__ = rg.info.InfoCartesianChart;
rg.info.InfoBarChart.prototype = $extend(rg.info.InfoCartesianChart.prototype,{
	barclass: null
	,startat: null
	,segment: null
	,horizontal: null
	,barPadding: null
	,barPaddingAxis: null
	,barPaddingDataPoint: null
	,effect: null
	,stacked: null
	,__class__: rg.info.InfoBarChart
});
rg.info.InfoDataSource = function() {
};
$hxClasses["rg.info.InfoDataSource"] = rg.info.InfoDataSource;
rg.info.InfoDataSource.__name__ = ["rg","info","InfoDataSource"];
rg.info.InfoDataSource.filters = function() {
	return [rg.info.filter.FilterDescription.toDataFunctionFromArray("data",["loader"]),rg.info.filter.FilterDescription.toDataFunctionFromArray("datapoints",["loader"]),rg.info.filter.FilterDescription.toLoaderFunction("load",["loader"])];
}
rg.info.InfoDataSource.prototype = {
	loader: null
	,__class__: rg.info.InfoDataSource
}
rg.info.InfoDomType = function() {
};
$hxClasses["rg.info.InfoDomType"] = rg.info.InfoDomType;
rg.info.InfoDomType.__name__ = ["rg","info","InfoDomType"];
rg.info.InfoDomType.filters = function() {
	return [rg.info.filter.FilterDescription.custom("visualization",["kind"],function(value) {
		var v = null == value?null:("" + Std.string(value)).toLowerCase();
		if(Arrays.exists(rg.visualization.Visualizations.visualizations,v)) return rg.info.filter.TransformResult.Success(Arrays.exists(rg.visualization.Visualizations.html,v)?rg.info.DomKind.Html:rg.info.DomKind.Svg); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("'{0}' value is not a vailid visualization kind",[value]));
	})];
}
rg.info.InfoDomType.prototype = {
	kind: null
	,__class__: rg.info.InfoDomType
}
rg.info.DomKind = { __ename__ : ["rg","info","DomKind"], __constructs__ : ["Html","Svg"] }
rg.info.DomKind.Html = ["Html",0];
rg.info.DomKind.Html.toString = $estr;
rg.info.DomKind.Html.__enum__ = rg.info.DomKind;
rg.info.DomKind.Svg = ["Svg",1];
rg.info.DomKind.Svg.toString = $estr;
rg.info.DomKind.Svg.__enum__ = rg.info.DomKind;
rg.info.InfoDownload = function() {
	this.service = rg.RGConst.SERVICE_RENDERING_STATIC;
	this.legacyservice = rg.RGConst.LEGACY_RENDERING_STATIC;
	this.formats = ["pdf","png","jpg","svg"];
};
$hxClasses["rg.info.InfoDownload"] = rg.info.InfoDownload;
rg.info.InfoDownload.__name__ = ["rg","info","InfoDownload"];
rg.info.InfoDownload.filters = function() {
	return [rg.info.filter.FilterDescription.toFunction("handler"),rg.info.filter.FilterDescription.toStr("service"),rg.info.filter.FilterDescription.toStr("legacyservice"),rg.info.filter.FilterDescription.toArray("formats"),rg.info.filter.FilterDescription.custom("position",null,function(value) {
		if(js.Boot.__instanceof(value,String) || value.nodeName) return rg.info.filter.TransformResult.Success(rg.html.widget.DownloaderPositions.parse(value)); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("invalid downloader position: {0}",value));
	})];
}
rg.info.InfoDownload.prototype = {
	formats: null
	,position: null
	,legacyservice: null
	,service: null
	,handler: null
	,__class__: rg.info.InfoDownload
}
rg.info.InfoFunnelChart = function() {
	this.animation = new rg.info.InfoAnimation();
	this.label = new rg.info.InfoLabelFunnel();
	this.padding = 2.5;
	this.flatness = 1.0;
	this.effect = rg.svg.chart.GradientEffect.Gradient(1.25);
	this.arrowSize = 30;
};
$hxClasses["rg.info.InfoFunnelChart"] = rg.info.InfoFunnelChart;
rg.info.InfoFunnelChart.__name__ = ["rg","info","InfoFunnelChart"];
rg.info.InfoFunnelChart.filters = function() {
	return [rg.info.filter.FilterDescription.toInfo("animation",null,rg.info.InfoAnimation),rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabelFunnel),rg.info.filter.FilterDescription.toExpressionFunction("sort",["a","b"],["sortDataPoint"]),rg.info.filter.FilterDescription.toFunction("click"),rg.info.filter.FilterDescription.toFloat("segmentpadding",["padding"]),rg.info.filter.FilterDescription.toFloat("flatness"),rg.info.filter.FilterDescription.custom("effect",null,function(value) {
		if(rg.svg.chart.GradientEffects.canParse(value)) return rg.info.filter.TransformResult.Success(rg.svg.chart.GradientEffects.parse(value)); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("'{0}' is not a valid effect",value));
	}),rg.info.filter.FilterDescription.toFloat("arrowsize",["arrowSize"])];
}
rg.info.InfoFunnelChart.prototype = {
	arrowSize: null
	,effect: null
	,flatness: null
	,padding: null
	,click: null
	,sortDataPoint: null
	,label: null
	,animation: null
	,__class__: rg.info.InfoFunnelChart
}
rg.info.InfoGeneral = function() {
	this.forcelegacy = false;
};
$hxClasses["rg.info.InfoGeneral"] = rg.info.InfoGeneral;
rg.info.InfoGeneral.__name__ = ["rg","info","InfoGeneral"];
rg.info.InfoGeneral.filters = function() {
	return [rg.info.filter.FilterDescription.toFunction("ready"),rg.info.filter.FilterDescription.toBool("forcelegacy")];
}
rg.info.InfoGeneral.prototype = {
	forcelegacy: null
	,ready: null
	,__class__: rg.info.InfoGeneral
}
rg.info.InfoGeo = function() {
	this.labelShadow = false;
	this.labelOutline = false;
	this.label = new rg.info.InfoLabel();
	this.map = [rg.info.Info.feed(new rg.info.InfoMap(),{ template : "world"})];
};
$hxClasses["rg.info.InfoGeo"] = rg.info.InfoGeo;
rg.info.InfoGeo.__name__ = ["rg","info","InfoGeo"];
rg.info.InfoGeo.filters = function() {
	return [rg.info.filter.FilterDescription.toInfoArray("map",null,rg.info.InfoMap),rg.info.filter.FilterDescription.toBool("labeloutline",["labelOutline"]),rg.info.filter.FilterDescription.toBool("labelshadow",["labelShadow"])];
}
rg.info.InfoGeo.prototype = {
	labelShadow: null
	,labelOutline: null
	,label: null
	,map: null
	,__class__: rg.info.InfoGeo
}
rg.info.InfoHeatGrid = function() {
	rg.info.InfoCartesianChart.call(this);
	this.colorScaleMode = rg.svg.chart.ColorScaleMode.FromCssInterpolation();
};
$hxClasses["rg.info.InfoHeatGrid"] = rg.info.InfoHeatGrid;
rg.info.InfoHeatGrid.__name__ = ["rg","info","InfoHeatGrid"];
rg.info.InfoHeatGrid.filters = function() {
	return [rg.info.filter.FilterDescription.toBool("contour"),rg.info.filter.FilterDescription.simplified("color",["colorScaleMode"],rg.svg.chart.ColorScaleModes.createFromDynamic,function(v) {
		return rg.svg.chart.ColorScaleModes.canParse(v)?null:"value must be a a string or a function returning a string expressing a valid color scale mode";
	})].concat(rg.info.InfoCartesianChart.filters());
}
rg.info.InfoHeatGrid.__super__ = rg.info.InfoCartesianChart;
rg.info.InfoHeatGrid.prototype = $extend(rg.info.InfoCartesianChart.prototype,{
	colorScaleMode: null
	,contour: null
	,__class__: rg.info.InfoHeatGrid
});
rg.info.InfoLabel = function() {
	this.datapointverticaloffset = 5;
	this.datapointoutline = false;
	this.datapointshadow = false;
};
$hxClasses["rg.info.InfoLabel"] = rg.info.InfoLabel;
rg.info.InfoLabel.__name__ = ["rg","info","InfoLabel"];
rg.info.InfoLabel.filters = function() {
	return [rg.info.filter.FilterDescription.toTemplateFunctionOrString("title",["axes","values","types"]),rg.info.filter.FilterDescription.toTemplateFunction("datapoint",[null,"stats"]),rg.info.filter.FilterDescription.toTemplateFunction("datapointover",[null,"stats"]),rg.info.filter.FilterDescription.toFloat("datapointverticaloffset"),rg.info.filter.FilterDescription.toBool("datapointoutline"),rg.info.filter.FilterDescription.toBool("datapointshadow")];
}
rg.info.InfoLabel.prototype = {
	datapointshadow: null
	,datapointoutline: null
	,datapointverticaloffset: null
	,datapointover: null
	,datapoint: null
	,title: null
	,__class__: rg.info.InfoLabel
}
rg.info.InfoLabelAxis = function() {
	rg.info.InfoLabel.call(this);
};
$hxClasses["rg.info.InfoLabelAxis"] = rg.info.InfoLabelAxis;
rg.info.InfoLabelAxis.__name__ = ["rg","info","InfoLabelAxis"];
rg.info.InfoLabelAxis.filters = function() {
	return [rg.info.filter.FilterDescription.toTemplateFunction("axis",["type"]),rg.info.filter.FilterDescription.toTemplateFunction("tickmark",["value","type"])].concat(rg.info.InfoLabel.filters());
}
rg.info.InfoLabelAxis.__super__ = rg.info.InfoLabel;
rg.info.InfoLabelAxis.prototype = $extend(rg.info.InfoLabel.prototype,{
	tickmark: null
	,axis: null
	,__class__: rg.info.InfoLabelAxis
});
rg.info.InfoLabelFunnel = function() {
	rg.info.InfoLabel.call(this);
};
$hxClasses["rg.info.InfoLabelFunnel"] = rg.info.InfoLabelFunnel;
rg.info.InfoLabelFunnel.__name__ = ["rg","info","InfoLabelFunnel"];
rg.info.InfoLabelFunnel.filters = function() {
	return [rg.info.filter.FilterDescription.toTemplateFunction("arrow",[null,"stats"])].concat(rg.info.InfoLabel.filters());
}
rg.info.InfoLabelFunnel.__super__ = rg.info.InfoLabel;
rg.info.InfoLabelFunnel.prototype = $extend(rg.info.InfoLabel.prototype,{
	arrow: null
	,__class__: rg.info.InfoLabelFunnel
});
rg.info.InfoLabelLeaderboard = function() {
	rg.info.InfoLabel.call(this);
};
$hxClasses["rg.info.InfoLabelLeaderboard"] = rg.info.InfoLabelLeaderboard;
rg.info.InfoLabelLeaderboard.__name__ = ["rg","info","InfoLabelLeaderboard"];
rg.info.InfoLabelLeaderboard.filters = function() {
	return [rg.info.filter.FilterDescription.toTemplateFunctionOrNull("rank",[null,"index","stats"]),rg.info.filter.FilterDescription.toTemplateFunctionOrNull("value",[null,"stats"])].concat(rg.info.InfoLabel.filters());
}
rg.info.InfoLabelLeaderboard.__super__ = rg.info.InfoLabel;
rg.info.InfoLabelLeaderboard.prototype = $extend(rg.info.InfoLabel.prototype,{
	value: null
	,rank: null
	,__class__: rg.info.InfoLabelLeaderboard
});
rg.info.InfoLabelPivotTable = function() {
	rg.info.InfoLabelAxis.call(this);
};
$hxClasses["rg.info.InfoLabelPivotTable"] = rg.info.InfoLabelPivotTable;
rg.info.InfoLabelPivotTable.__name__ = ["rg","info","InfoLabelPivotTable"];
rg.info.InfoLabelPivotTable.filters = function() {
	return [rg.info.filter.FilterDescription.toTemplateFunction("total",["value","stats"]),rg.info.filter.FilterDescription.toTemplateFunction("totalover",["value","stats"]),rg.info.filter.FilterDescription.toTemplateFunction("axisvalue",["value","axis"])].concat(rg.info.InfoLabelAxis.filters());
}
rg.info.InfoLabelPivotTable.__super__ = rg.info.InfoLabelAxis;
rg.info.InfoLabelPivotTable.prototype = $extend(rg.info.InfoLabelAxis.prototype,{
	axisvalue: null
	,totalover: null
	,total: null
	,__class__: rg.info.InfoLabelPivotTable
});
rg.info.InfoLabelSankey = function() {
	rg.info.InfoLabel.call(this);
};
$hxClasses["rg.info.InfoLabelSankey"] = rg.info.InfoLabelSankey;
rg.info.InfoLabelSankey.__name__ = ["rg","info","InfoLabelSankey"];
rg.info.InfoLabelSankey.filters = function() {
	return [rg.info.filter.FilterDescription.toTemplateFunction("edge",[null,"stats"]),rg.info.filter.FilterDescription.toTemplateFunction("edgeover",[null,"stats"]),rg.info.filter.FilterDescription.toTemplateFunction("node",[null,"stats"])].concat(rg.info.InfoLabel.filters());
}
rg.info.InfoLabelSankey.__super__ = rg.info.InfoLabel;
rg.info.InfoLabelSankey.prototype = $extend(rg.info.InfoLabel.prototype,{
	node: null
	,edgeover: null
	,edge: null
	,__class__: rg.info.InfoLabelSankey
});
rg.info.InfoLayout = function() {
	this.main = "main";
	this.titleOnTop = true;
	this.scalePattern = rg.layout.ScalePattern.ScalesAlternating;
	this.padding = new rg.info.InfoPadding();
};
$hxClasses["rg.info.InfoLayout"] = rg.info.InfoLayout;
rg.info.InfoLayout.__name__ = ["rg","info","InfoLayout"];
rg.info.InfoLayout.filters = function() {
	return [rg.info.filter.FilterDescription.custom("layout",null,function(value) {
		var v = null == value?null:("" + Std.string(value)).toLowerCase();
		if(!Arrays.exists(rg.visualization.Visualizations.layouts,v)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value '{0}' is not a valid visualization layout",[value])); else return rg.info.filter.TransformResult.Success(v);
	}),rg.info.filter.FilterDescription.toFloat("width"),rg.info.filter.FilterDescription.toFloat("height"),rg.info.filter.FilterDescription.custom("visualization",["type"],function(value) {
		var v = null == value?null:("" + Std.string(value)).toLowerCase();
		if(!Arrays.exists(rg.visualization.Visualizations.svg,v)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value '{0}' is not a valid visualization type",[value])); else return rg.info.filter.TransformResult.Success(v);
	}),rg.info.filter.FilterDescription.toStr("main"),rg.info.filter.FilterDescription.toBool("titleontop",["titleOnTop"]),rg.info.filter.FilterDescription.custom("yscaleposition",["scalePattern"],function(value) {
		if(!js.Boot.__instanceof(value,String)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value '{0}' must be a string",[value]));
		return rg.info.filter.TransformResult.Success((function($this) {
			var $r;
			switch(value) {
			case "alt":case "alternate":case "alternating":
				$r = rg.layout.ScalePattern.ScalesAlternating;
				break;
			case "right":
				$r = rg.layout.ScalePattern.ScalesAfter;
				break;
			default:
				$r = rg.layout.ScalePattern.ScalesBefore;
			}
			return $r;
		}(this)));
	}),rg.info.filter.FilterDescription.toInfo("padding",null,rg.info.InfoPadding)];
}
rg.info.InfoLayout.prototype = {
	padding: null
	,scalePattern: null
	,titleOnTop: null
	,main: null
	,type: null
	,height: null
	,width: null
	,layout: null
	,__class__: rg.info.InfoLayout
}
rg.info.InfoLeaderboard = function() {
	this.animation = new rg.info.InfoAnimation();
	this.label = new rg.info.InfoLabelLeaderboard();
	this.usemax = false;
	this.displaybar = true;
	this.colorscale = false;
};
$hxClasses["rg.info.InfoLeaderboard"] = rg.info.InfoLeaderboard;
rg.info.InfoLeaderboard.__name__ = ["rg","info","InfoLeaderboard"];
rg.info.InfoLeaderboard.filters = function() {
	return [rg.info.filter.FilterDescription.toInfo("animation",null,rg.info.InfoAnimation,function(info) {
		info.ease = thx.math.Equations.linear;
	}),rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabelLeaderboard),rg.info.filter.FilterDescription.toFunction("click"),rg.info.filter.FilterDescription.toExpressionFunction("sort",["a","b"],["sortDataPoint"]),rg.info.filter.FilterDescription.toBool("displaybar"),rg.info.filter.FilterDescription.toBool("usemax"),rg.info.filter.FilterDescription.toBool("colorscale")];
}
rg.info.InfoLeaderboard.prototype = {
	colorscale: null
	,displaybar: null
	,usemax: null
	,sortDataPoint: null
	,click: null
	,label: null
	,animation: null
	,__class__: rg.info.InfoLeaderboard
}
rg.info.InfoLineChart = function() {
	rg.info.InfoCartesianChart.call(this);
	this.segment = new rg.info.InfoSegment();
	this.effect = rg.svg.chart.LineEffect.Gradient(-1.2,2);
	this.interpolation = thx.svg.LineInterpolator.Linear;
	this.displayarea = false;
	this.sensibleradius = 100;
};
$hxClasses["rg.info.InfoLineChart"] = rg.info.InfoLineChart;
rg.info.InfoLineChart.__name__ = ["rg","info","InfoLineChart"];
rg.info.InfoLineChart.filters = function() {
	return [rg.info.filter.FilterDescription.toExpressionFunctionOrString("symbol",[null,"stats"]),rg.info.filter.FilterDescription.toExpressionFunctionOrString("symbolstyle",[null,"stats"],["symbolStyle"]),rg.info.filter.FilterDescription.simplified("segmenton",["segment"],function(value) {
		return rg.info.Info.feed(new rg.info.InfoSegment(),{ on : value});
	},rg.info.filter.ReturnMessageIfNot.isString),rg.info.filter.FilterDescription.toInfo("segment",null,rg.info.InfoSegment),rg.info.filter.FilterDescription.toStr("y0property"),rg.info.filter.FilterDescription.toBool("displayarea"),rg.info.filter.FilterDescription.toInt("sensibleradius"),rg.info.filter.FilterDescription.toTry("effect",null,rg.svg.chart.LineEffects.parse,"invalid effect string value '{0}'"),rg.info.filter.FilterDescription.toTry("interpolation",null,function(v) {
		return thx.svg.LineInterpolators.parse(v);
	},"invalid line interpolation string value '{0}'")].concat(rg.info.InfoCartesianChart.filters());
}
rg.info.InfoLineChart.__super__ = rg.info.InfoCartesianChart;
rg.info.InfoLineChart.prototype = $extend(rg.info.InfoCartesianChart.prototype,{
	sensibleradius: null
	,segment: null
	,y0property: null
	,displayarea: null
	,symbolStyle: null
	,symbol: null
	,interpolation: null
	,effect: null
	,__class__: rg.info.InfoLineChart
});
rg.info.InfoMap = function() {
	this.property = "location";
	this.type = "geojson";
	this.colorScaleMode = rg.svg.chart.ColorScaleMode.FromCssInterpolation();
	this.usejsonp = true;
	this.radius = function(_,_1) {
		return 10;
	};
};
$hxClasses["rg.info.InfoMap"] = rg.info.InfoMap;
rg.info.InfoMap.__name__ = ["rg","info","InfoMap"];
rg.info.InfoMap.filters = function() {
	return [new rg.info.filter.FilterDescription("template",new rg.info.TemplateTransformer()),rg.info.filter.FilterDescription.toStr("url"),rg.info.filter.FilterDescription.toStr("type"),rg.info.filter.FilterDescription.toFloat("scale"),rg.info.filter.FilterDescription.toStr("projection"),rg.info.filter.FilterDescription.toStr("classname"),rg.info.filter.FilterDescription.toArray("translate"),rg.info.filter.FilterDescription.toArray("origin"),rg.info.filter.FilterDescription.toArray("parallels"),rg.info.filter.FilterDescription.toTry("mode",null,function(v) {
		return Type.createEnum(thx.geo.ProjectionMode,Strings.ucfirst(v.toLowerCase()),[]);
	},"value is not a valid projection mode '{0}'"),rg.info.filter.FilterDescription.toStrOrNull("property"),rg.info.filter.FilterDescription.toBool("usejsonp"),rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabel),rg.info.filter.FilterDescription.toFunction("click"),rg.info.filter.FilterDescription.simplified("color",["colorScaleMode"],rg.svg.chart.ColorScaleModes.createFromDynamic,rg.info.filter.ReturnMessageChainer.make(function(v) {
		return js.Boot.__instanceof(v,String) || Reflect.isFunction(v);
	},"invalid color mode value '{0}'")),rg.info.filter.FilterDescription.toExpressionFunctionOrFloat("radius",[null,"stats"]),new rg.info.filter.FilterDescription("mapping",new rg.info.MapTransformer())];
}
rg.info.InfoMap.prototype = {
	mappingurl: null
	,mapping: null
	,usejsonp: null
	,colorScaleMode: null
	,radius: null
	,click: null
	,label: null
	,property: null
	,mode: null
	,parallels: null
	,origin: null
	,translate: null
	,classname: null
	,projection: null
	,scale: null
	,type: null
	,url: null
	,__class__: rg.info.InfoMap
}
rg.info.filter = {}
rg.info.filter.ITransformer = function() { }
$hxClasses["rg.info.filter.ITransformer"] = rg.info.filter.ITransformer;
rg.info.filter.ITransformer.__name__ = ["rg","info","filter","ITransformer"];
rg.info.filter.ITransformer.prototype = {
	transform: null
	,__class__: rg.info.filter.ITransformer
}
rg.info.MapTransformer = function() {
};
$hxClasses["rg.info.MapTransformer"] = rg.info.MapTransformer;
rg.info.MapTransformer.__name__ = ["rg","info","MapTransformer"];
rg.info.MapTransformer.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.MapTransformer.prototype = {
	transform: function(value) {
		return js.Boot.__instanceof(value,String)?rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["mappingurl"],[value])):Reflect.isObject(value) && null == Type.getClass(value)?rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["mapping"],[value])):rg.info.filter.TransformResult.Failure(new thx.util.Message("value should be url string or an object",[value]));
	}
	,__class__: rg.info.MapTransformer
}
rg.info.TemplateTransformer = function() {
};
$hxClasses["rg.info.TemplateTransformer"] = rg.info.TemplateTransformer;
rg.info.TemplateTransformer.__name__ = ["rg","info","TemplateTransformer"];
rg.info.TemplateTransformer.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.TemplateTransformer.prototype = {
	transform: function(value) {
		value = null == value?"":"" + Std.string(value);
		return (function($this) {
			var $r;
			var _g = value.toLowerCase();
			$r = (function($this) {
				var $r;
				switch(_g) {
				case "world":case "world-countries":
					$r = rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["projection","url"],["mercator",rg.RGConst.BASE_URL_GEOJSON + "world-countries.json.js"]));
					break;
				case "usa-states":
					$r = rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["projection","url"],["albersusa",rg.RGConst.BASE_URL_GEOJSON + "usa-states.json.js"]));
					break;
				case "usa-states-name":
					$r = rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["projection","url"],["albersusa",rg.RGConst.BASE_URL_GEOJSON + "usa-states-name.json.js"]));
					break;
				case "usa-states-code":
					$r = rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["projection","url"],["albersusa",rg.RGConst.BASE_URL_GEOJSON + "usa-states-code.json.js"]));
					break;
				case "usa-state-centroids":
					$r = rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["projection","url"],["albersusa",rg.RGConst.BASE_URL_GEOJSON + "usa-state-centroids.json.js"]));
					break;
				case "usa-counties":
					$r = rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(["projection","url"],["albersusa",rg.RGConst.BASE_URL_GEOJSON + "usa-counties.json.js"]));
					break;
				default:
					$r = rg.info.filter.TransformResult.Failure(new thx.util.Message("{0} is not a valid map template",[value]));
				}
				return $r;
			}($this));
			return $r;
		}(this));
	}
	,__class__: rg.info.TemplateTransformer
}
rg.info.InfoPadding = function() {
};
$hxClasses["rg.info.InfoPadding"] = rg.info.InfoPadding;
rg.info.InfoPadding.__name__ = ["rg","info","InfoPadding"];
rg.info.InfoPadding.filters = function() {
	return [rg.info.filter.FilterDescription.toInt("top"),rg.info.filter.FilterDescription.toInt("bottom"),rg.info.filter.FilterDescription.toInt("left"),rg.info.filter.FilterDescription.toInt("right")];
}
rg.info.InfoPadding.prototype = {
	right: null
	,left: null
	,bottom: null
	,top: null
	,__class__: rg.info.InfoPadding
}
rg.info.InfoPieChart = function() {
	this.innerradius = 0.0;
	this.labelradius = 0.45;
	this.labelorientation = rg.svg.widget.LabelOrientation.Aligned;
	this.outerradius = 0.9;
	this.overradius = 0.95;
	this.tooltipradius = 0.5;
	this.animation = new rg.info.InfoAnimation();
	this.label = new rg.info.InfoLabel();
	this.effect = rg.svg.chart.GradientEffect.Gradient(1.2);
	this.dontfliplabel = true;
};
$hxClasses["rg.info.InfoPieChart"] = rg.info.InfoPieChart;
rg.info.InfoPieChart.__name__ = ["rg","info","InfoPieChart"];
rg.info.InfoPieChart.filters = function() {
	return [rg.info.filter.FilterDescription.toFloat("labelradius"),rg.info.filter.FilterDescription.toBool("dontfliplabel"),rg.info.filter.FilterDescription.toTry("labelorientation",null,rg.svg.widget.LabelOrientations.parse,"invalid orientation value '{0}'"),rg.info.filter.FilterDescription.toFloat("innerradius"),rg.info.filter.FilterDescription.toFloat("outerradius"),rg.info.filter.FilterDescription.toFloat("overradius"),rg.info.filter.FilterDescription.toFloat("tooltipradius"),rg.info.filter.FilterDescription.toInfo("animation",null,rg.info.InfoAnimation),rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabel),rg.info.filter.FilterDescription.toExpressionFunction("sort",["a","b"],["sortDataPoint"]),rg.info.filter.FilterDescription.toFunction("click"),rg.info.filter.FilterDescription.simplified("effect",null,rg.svg.chart.GradientEffects.parse,rg.info.filter.ReturnMessageChainer.or(rg.info.filter.ReturnMessageIfNot.isString,rg.info.filter.ReturnMessageChainer.make(rg.svg.chart.GradientEffects.canParse,"invalid gradient effect: {0}")))];
}
rg.info.InfoPieChart.prototype = {
	click: null
	,dontfliplabel: null
	,sortDataPoint: null
	,effect: null
	,label: null
	,animation: null
	,tooltipradius: null
	,overradius: null
	,outerradius: null
	,innerradius: null
	,labelorientation: null
	,labelradius: null
	,__class__: rg.info.InfoPieChart
}
rg.info.InfoPivotTable = function() {
	this.label = new rg.info.InfoLabelPivotTable();
	this.heatmapColorStart = rg.info.InfoPivotTable.defaultStartColor;
	this.heatmapColorEnd = rg.info.InfoPivotTable.defaultEndColor;
	this.displayHeatmap = true;
	this.displayColumnTotal = true;
	this.displayRowTotal = true;
	this.columnAxes = 1;
};
$hxClasses["rg.info.InfoPivotTable"] = rg.info.InfoPivotTable;
rg.info.InfoPivotTable.__name__ = ["rg","info","InfoPivotTable"];
rg.info.InfoPivotTable.filters = function() {
	return [rg.info.filter.FilterDescription.toInt("columnaxes",["columnAxes"]),rg.info.filter.FilterDescription.toBool("displayheatmap",["displayHeatmap"]),rg.info.filter.FilterDescription.toBool("displaycolumntotal",["displayColumnTotal"]),rg.info.filter.FilterDescription.toBool("displayrowtotal",["displayRowTotal"]),rg.info.filter.FilterDescription.toTry("startcolor",["heatmapColorStart"],function(value) {
		return thx.color.Hsl.toHsl(rg.util.RGColors.parse(value,rg.info.InfoPivotTable.defaultStartColor.hex("#")));
	},"value is not a parsable color '{0}'"),rg.info.filter.FilterDescription.toTry("endcolor",["heatmapColorEnd"],function(value) {
		return thx.color.Hsl.toHsl(rg.util.RGColors.parse(value,rg.info.InfoPivotTable.defaultEndColor.hex("#")));
	},"value is not a parsable color '{0}'"),rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabelPivotTable),rg.info.filter.FilterDescription.toFunction("click"),rg.info.filter.FilterDescription.toExpressionFunction("cellclass",[null,"stats"]),rg.info.filter.FilterDescription.toExpressionFunction("valueclass",["value","header"]),rg.info.filter.FilterDescription.toExpressionFunction("headerclass",["header"]),rg.info.filter.FilterDescription.toExpressionFunction("totalclass",["value","values"])];
}
rg.info.InfoPivotTable.prototype = {
	totalclass: null
	,headerclass: null
	,valueclass: null
	,cellclass: null
	,click: null
	,columnAxes: null
	,displayRowTotal: null
	,displayColumnTotal: null
	,displayHeatmap: null
	,heatmapColorEnd: null
	,heatmapColorStart: null
	,label: null
	,__class__: rg.info.InfoPivotTable
}
rg.info.InfoSankey = function() {
	this.label = new rg.info.InfoLabelSankey();
	this.stackbackedges = true;
	this.thinbackedges = false;
};
$hxClasses["rg.info.InfoSankey"] = rg.info.InfoSankey;
rg.info.InfoSankey.__name__ = ["rg","info","InfoSankey"];
rg.info.InfoSankey.filters = function() {
	return [rg.info.filter.FilterDescription.toInfo("label",null,rg.info.InfoLabelSankey),rg.info.filter.FilterDescription.toFloat("layerwidth",["layerWidth"]),rg.info.filter.FilterDescription.toFloat("chunkwidth",["chunkWidth"]),rg.info.filter.FilterDescription.toFloat("nodespacing",["nodeSpacing"]),rg.info.filter.FilterDescription.toFloat("dummyspacing",["dummySpacing"]),rg.info.filter.FilterDescription.toFloat("extrawidth",["extraWidth"]),rg.info.filter.FilterDescription.toFloat("backedgespacing",["backEdgeSpacing"]),rg.info.filter.FilterDescription.toFloat("extraheight",["extraHeight"]),rg.info.filter.FilterDescription.toFloat("extraradius",["extraRadius"]),rg.info.filter.FilterDescription.toFloat("imagewidth",["imageWidth"]),rg.info.filter.FilterDescription.toFloat("imageheight",["imageHeight"]),rg.info.filter.FilterDescription.toFloat("imagespacing",["imageSpacing"]),rg.info.filter.FilterDescription.toFloat("labelnodespacing",["labelNodeSpacing"]),rg.info.filter.FilterDescription.toExpressionFunction("imagepath",[null],["imagePath"]),rg.info.filter.FilterDescription.toFunction("click",["click"]),rg.info.filter.FilterDescription.toFunction("clickedge",["clickEdge"]),rg.info.filter.FilterDescription.toObject("layoutmap"),rg.info.filter.FilterDescription.toStr("layoutmethod"),rg.info.filter.FilterDescription.toExpressionFunctionOrString("nodeclass",[null,"stats"]),rg.info.filter.FilterDescription.toExpressionFunctionOrString("edgeclass",[null,"stats"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayentry",[null,"stats"]),rg.info.filter.FilterDescription.toExpressionFunctionOrBool("displayexit",[null,"stats"]),rg.info.filter.FilterDescription.toBool("stackbackedges"),rg.info.filter.FilterDescription.toBool("thinbackedges")];
}
rg.info.InfoSankey.prototype = {
	thinbackedges: null
	,stackbackedges: null
	,displayexit: null
	,displayentry: null
	,edgeclass: null
	,nodeclass: null
	,layoutmethod: null
	,clickEdge: null
	,click: null
	,layoutmap: null
	,imagePath: null
	,labelNodeSpacing: null
	,chunkWidth: null
	,imageSpacing: null
	,imageHeight: null
	,imageWidth: null
	,extraRadius: null
	,extraHeight: null
	,backEdgeSpacing: null
	,extraWidth: null
	,dummySpacing: null
	,nodeSpacing: null
	,layerWidth: null
	,label: null
	,__class__: rg.info.InfoSankey
}
rg.info.InfoScatterGraph = function() {
	rg.info.InfoCartesianChart.call(this);
	this.segment = new rg.info.InfoSegment();
	this.symbol = function(dp,s) {
		return rg.svg.util.SymbolCache.cache.get("circle",16);
	};
};
$hxClasses["rg.info.InfoScatterGraph"] = rg.info.InfoScatterGraph;
rg.info.InfoScatterGraph.__name__ = ["rg","info","InfoScatterGraph"];
rg.info.InfoScatterGraph.filters = function() {
	return [rg.info.filter.FilterDescription.toExpressionFunctionOrString("symbol",[null,"stats"]),rg.info.filter.FilterDescription.toTemplateFunction("symbolstyle",[null,"stats"],["symbolStyle"]),rg.info.filter.FilterDescription.simplified("segmenton",["segment"],function(value) {
		return rg.info.Info.feed(new rg.info.InfoSegment(),{ on : value});
	},rg.info.filter.ReturnMessageIfNot.isString),rg.info.filter.FilterDescription.toInfo("segment",null,rg.info.InfoSegment)].concat(rg.info.InfoCartesianChart.filters());
}
rg.info.InfoScatterGraph.__super__ = rg.info.InfoCartesianChart;
rg.info.InfoScatterGraph.prototype = $extend(rg.info.InfoCartesianChart.prototype,{
	segment: null
	,symbolStyle: null
	,symbol: null
	,__class__: rg.info.InfoScatterGraph
});
rg.info.InfoSegment = function() {
	this.values = [];
};
$hxClasses["rg.info.InfoSegment"] = rg.info.InfoSegment;
rg.info.InfoSegment.__name__ = ["rg","info","InfoSegment"];
rg.info.InfoSegment.filters = function() {
	return [rg.info.filter.FilterDescription.toStr("on"),rg.info.filter.FilterDescription.toFunction("transform"),rg.info.filter.FilterDescription.toFunction("scale"),rg.info.filter.FilterDescription.toArray("values")];
}
rg.info.InfoSegment.prototype = {
	values: null
	,scale: null
	,transform: null
	,on: null
	,__class__: rg.info.InfoSegment
}
rg.info.InfoStreamGraph = function() {
	rg.info.InfoCartesianChart.call(this);
	this.segment = new rg.info.InfoSegment();
	this.interpolation = thx.svg.LineInterpolator.Cardinal();
	this.effect = rg.svg.chart.StreamEffect.GradientVertical(1.25);
};
$hxClasses["rg.info.InfoStreamGraph"] = rg.info.InfoStreamGraph;
rg.info.InfoStreamGraph.__name__ = ["rg","info","InfoStreamGraph"];
rg.info.InfoStreamGraph.filters = function() {
	return [rg.info.filter.FilterDescription.toTry("interpolation",null,function(value) {
		return thx.svg.LineInterpolators.parse(value);
	},"value is expected to be a valid interpolation string, it is '{0}'"),rg.info.filter.FilterDescription.toTry("effect",null,function(value) {
		return rg.svg.chart.StreamEffects.parse(value);
	},"value is expected to be a valid effect string, it is '{0}'"),rg.info.filter.FilterDescription.simplified("segmenton",["segment"],function(value) {
		return rg.info.Info.feed(new rg.info.InfoSegment(),{ on : value});
	},rg.info.filter.ReturnMessageIfNot.isString),rg.info.filter.FilterDescription.toInfo("segment",null,rg.info.InfoSegment)].concat(rg.info.InfoCartesianChart.filters());
}
rg.info.InfoStreamGraph.__super__ = rg.info.InfoCartesianChart;
rg.info.InfoStreamGraph.prototype = $extend(rg.info.InfoCartesianChart.prototype,{
	segment: null
	,effect: null
	,interpolation: null
	,__class__: rg.info.InfoStreamGraph
});
rg.info.InfoVariable = function() {
	this.variableType = rg.info.VariableType.Unknown;
};
$hxClasses["rg.info.InfoVariable"] = rg.info.InfoVariable;
rg.info.InfoVariable.__name__ = ["rg","info","InfoVariable"];
rg.info.InfoVariable.filters = function() {
	return [rg.info.filter.FilterDescription.toStr("type"),rg.info.filter.FilterDescription.custom("view",["min"],function(value) {
		if(!js.Boot.__instanceof(value,Array) || !rg.info.InfoVariable.testViewValue(value[0])) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value is expected to be an array of two items but is '{0}'",[value])); else return rg.info.filter.TransformResult.Success(value[0]);
	}),rg.info.filter.FilterDescription.custom("view",["max"],function(value) {
		if(!js.Boot.__instanceof(value,Array) || !rg.info.InfoVariable.testViewValue(value[1])) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value is expected to be an array of two items but is '{0}'",[value])); else return rg.info.filter.TransformResult.Success(value[1]);
	}),rg.info.filter.FilterDescription.toArray("values"),rg.info.filter.FilterDescription.custom("values",["min"],function(value) {
		if(!js.Boot.__instanceof(value,Array)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("values is expected to be an array")); else return rg.info.filter.TransformResult.Success(value[0]);
	}),rg.info.filter.FilterDescription.custom("values",["max"],function(value) {
		if(!js.Boot.__instanceof(value,Array)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("values is expected to be an array")); else {
			var arr = js.Boot.__cast(value , Array);
			return rg.info.filter.TransformResult.Success(arr[arr.length - 1]);
		}
	}),rg.info.filter.FilterDescription.custom("groupby",["groupBy"],function(value) {
		if(!js.Boot.__instanceof(value,String) || !rg.util.Periodicity.isValidGroupBy(value)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value is expected to be a valid string periodicity but is '{0}'",[value])); else return rg.info.filter.TransformResult.Success(value);
	}),rg.info.filter.FilterDescription.custom("variable",["variableType"],function(value) {
		var v = null == value?null:("" + Std.string(value)).toLowerCase();
		if(!Arrays.exists(["independent","dependent"],v)) return rg.info.filter.TransformResult.Failure(new thx.util.Message("value is expected to be an 'independent' or 'dependent' but is '{0}'",[value])); else return rg.info.filter.TransformResult.Success(Type.createEnum(rg.info.VariableType,Strings.ucfirst(v.toLowerCase()),[]));
	}),rg.info.filter.FilterDescription.toTry("scalemode",["scaleDistribution"],function(value) {
		return Type.createEnum(rg.axis.ScaleDistribution,"Scale" + Strings.ucfirst(("" + Std.string(value)).toLowerCase()),[]);
	},"value is expected to be a valid scale distribution value but is '{0}'")];
}
rg.info.InfoVariable.testViewValue = function(v) {
	return v == null || Types.isPrimitive(v) || js.Boot.__instanceof(v,Date) || Reflect.isFunction(v);
}
rg.info.InfoVariable.__super__ = rg.info.Info;
rg.info.InfoVariable.prototype = $extend(rg.info.Info.prototype,{
	scaleDistribution: null
	,variableType: null
	,groupBy: null
	,values: null
	,max: null
	,min: null
	,type: null
	,__class__: rg.info.InfoVariable
});
rg.info.VariableType = { __ename__ : ["rg","info","VariableType"], __constructs__ : ["Unknown","Independent","Dependent"] }
rg.info.VariableType.Unknown = ["Unknown",0];
rg.info.VariableType.Unknown.toString = $estr;
rg.info.VariableType.Unknown.__enum__ = rg.info.VariableType;
rg.info.VariableType.Independent = ["Independent",1];
rg.info.VariableType.Independent.toString = $estr;
rg.info.VariableType.Independent.__enum__ = rg.info.VariableType;
rg.info.VariableType.Dependent = ["Dependent",2];
rg.info.VariableType.Dependent.toString = $estr;
rg.info.VariableType.Dependent.__enum__ = rg.info.VariableType;
rg.info.InfoVisualizationOption = function() {
};
$hxClasses["rg.info.InfoVisualizationOption"] = rg.info.InfoVisualizationOption;
rg.info.InfoVisualizationOption.__name__ = ["rg","info","InfoVisualizationOption"];
rg.info.InfoVisualizationOption.filters = function() {
	return [rg.info.filter.FilterDescription.toInfoArray("axes",["variables"],rg.info.InfoVariable),rg.info.filter.FilterDescription.toObject("options")];
}
rg.info.InfoVisualizationOption.prototype = {
	options: null
	,variables: null
	,__class__: rg.info.InfoVisualizationOption
}
rg.info.InfoVisualizationType = function() {
	this.replace = true;
};
$hxClasses["rg.info.InfoVisualizationType"] = rg.info.InfoVisualizationType;
rg.info.InfoVisualizationType.__name__ = ["rg","info","InfoVisualizationType"];
rg.info.InfoVisualizationType.filters = function() {
	return [rg.info.filter.FilterDescription.custom("visualization",["type"],function(value) {
		var v = null == value?null:("" + Std.string(value)).toLowerCase();
		if(Arrays.exists(rg.visualization.Visualizations.visualizations,v)) return rg.info.filter.TransformResult.Success(v); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("invalid visualization type '{0}'",value));
	}),rg.info.filter.FilterDescription.toBool("replace")];
}
rg.info.InfoVisualizationType.prototype = {
	type: null
	,replace: null
	,__class__: rg.info.InfoVisualizationType
}
rg.info.filter.EmptyTransformer = function(mapto) {
	this.mapto = mapto;
};
$hxClasses["rg.info.filter.EmptyTransformer"] = rg.info.filter.EmptyTransformer;
rg.info.filter.EmptyTransformer.__name__ = ["rg","info","filter","EmptyTransformer"];
rg.info.filter.EmptyTransformer.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.EmptyTransformer.prototype = {
	transform: function(value) {
		return rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs([this.mapto],[value]));
	}
	,mapto: null
	,__class__: rg.info.filter.EmptyTransformer
}
rg.info.filter.FilterDescription = function(name,transformer) {
	this.name = name;
	this.transformer = null == transformer?new rg.info.filter.EmptyTransformer(name):transformer;
};
$hxClasses["rg.info.filter.FilterDescription"] = rg.info.filter.FilterDescription;
rg.info.filter.FilterDescription.__name__ = ["rg","info","filter","FilterDescription"];
rg.info.filter.FilterDescription.toBool = function(name,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.TransformerBool.instance);
}
rg.info.filter.FilterDescription.toInt = function(name,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.TransformerInt.instance);
}
rg.info.filter.FilterDescription.toFloat = function(name,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.TransformerFloat.instance);
}
rg.info.filter.FilterDescription.toStr = function(name,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.TransformerString.instance);
}
rg.info.filter.FilterDescription.toStrOrNull = function(name,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,function(value) {
		if(null == value) return rg.info.filter.TransformResult.Success(null); else return rg.info.filter.TransformerString.instance.transform(value);
	});
}
rg.info.filter.FilterDescription.toArray = function(name,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,function(v) {
		return js.Boot.__instanceof(v,Array)?rg.info.filter.TransformResult.Success(v):rg.info.filter.TransformResult.Failure(new thx.util.Message("expected array but was '{0}'",v));
	});
}
rg.info.filter.FilterDescription.toObject = function(name,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.TransformerObject.instance);
}
rg.info.filter.FilterDescription.toFunction = function(name,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.TransformerFunction.instance);
}
rg.info.filter.FilterDescription.toTemplateFunction = function(name,args,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,new rg.info.filter.TransformerTemplateToFunction(args));
}
rg.info.filter.FilterDescription.toExpressionFunction = function(name,args,maps) {
	return rg.info.filter.FilterDescription.pair(name,maps,new rg.info.filter.TransformerExpressionToFunction(args));
}
rg.info.filter.FilterDescription.toInfo = function(name,maps,cls,fun) {
	return rg.info.filter.FilterDescription.simplified(name,maps,function(value) {
		var inst = Type.createInstance(cls,[]);
		if(null != fun) fun(inst);
		return rg.info.Info.feed(inst,value);
	},rg.info.filter.ReturnMessageIfNot.isObject);
}
rg.info.filter.FilterDescription.toInfoArray = function(name,maps,cls) {
	return rg.info.filter.FilterDescription.custom(name,maps,function(value) {
		var arr;
		if(js.Boot.__instanceof(value,Array)) arr = value; else if(Reflect.isObject(value) && null == Type.getClass(value)) arr = [value]; else return rg.info.filter.TransformResult.Failure(new thx.util.Message("value must be either an array of objects or an object but is {0}",[value]));
		return rg.info.filter.TransformResult.Success(Iterators.map(HxOverrides.iter(arr),function(v,_) {
			var inst = Type.createInstance(cls,[]);
			return rg.info.Info.feed(inst,v);
		}));
	});
}
rg.info.filter.FilterDescription.toTry = function(name,maps,conversion,errorMessage) {
	return rg.info.filter.FilterDescription.custom(name,maps,function(value) {
		try {
			return rg.info.filter.TransformResult.Success(conversion(value));
		} catch( e ) {
			return rg.info.filter.TransformResult.Failure(new thx.util.Message(errorMessage,[value]));
		}
	});
}
rg.info.filter.FilterDescription.toDataFunctionFromArray = function(name,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=rg.info.filter.TransformerArray.instance,$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(function(handler) {
			return handler(value);
		});
	},function(vin,msg) {
		return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter must be an array of values"));
	}));
}
rg.info.filter.FilterDescription.toLoaderFunction = function(name,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=rg.info.filter.TransformerFunction.instance,$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(value);
	},function(vin1,msg) {
		var field = Reflect.field(vin1,"execute");
		if(null != field && Reflect.isFunction(field)) return rg.info.filter.TransformResult.Success(function(handler) {
			field.apply(vin1,[handler]);
		}); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter must be an array of values"));
	}));
}
rg.info.filter.FilterDescription.toExpressionFunctionOrBool = function(name,args,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=new rg.info.filter.TransformerExpressionToFunction(args),$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(value);
	},function(vin,msg) {
		return (rg.info.filter.TransformerChainer.onResult(($_=rg.info.filter.TransformerBool.instance,$bind($_,$_.transform)),function(b,_) {
			return rg.info.filter.TransformResult.Success(function() {
				return b;
			});
		},function(vin1,msg1) {
			return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter should be a boolean value or a function returning a boolean value"));
		}))(vin);
	}));
}
rg.info.filter.FilterDescription.toExpressionFunctionOrFloat = function(name,args,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=new rg.info.filter.TransformerExpressionToFunction(args),$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(value);
	},function(vin,msg) {
		return (rg.info.filter.TransformerChainer.onResult(($_=rg.info.filter.TransformerFloat.instance,$bind($_,$_.transform)),function(b,_) {
			return rg.info.filter.TransformResult.Success(function() {
				return b;
			});
		},function(vin1,msg1) {
			return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter should be a float value or a function returning a float value"));
		}))(vin);
	}));
}
rg.info.filter.FilterDescription.toTemplateFunctionOrNull = function(name,args,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=new rg.info.filter.TransformerTemplateToFunction(args),$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(value);
	},function(vin,msg) {
		if(null == vin) return rg.info.filter.TransformResult.Success(null); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter should be a function or null"));
	}));
}
rg.info.filter.FilterDescription.toExpressionFunctionOrString = function(name,args,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=new rg.info.filter.TransformerExpressionToFunction(args),$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(value);
	},function(vin,msg) {
		return (rg.info.filter.TransformerChainer.onResult(($_=rg.info.filter.TransformerString.instance,$bind($_,$_.transform)),function(s,_) {
			return rg.info.filter.TransformResult.Success(function() {
				return s;
			});
		},function(vin1,msg1) {
			return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter should be a string value or a function returning a string value"));
		}))(vin);
	}));
}
rg.info.filter.FilterDescription.toTemplateFunctionOrString = function(name,args,maps) {
	return rg.info.filter.FilterDescription.custom(name,maps,rg.info.filter.TransformerChainer.onResult(($_=new rg.info.filter.TransformerTemplateToFunction(args),$bind($_,$_.transform)),function(value,vin) {
		return rg.info.filter.TransformResult.Success(value);
	},function(vin,msg) {
		return (rg.info.filter.TransformerChainer.onResult(($_=rg.info.filter.TransformerString.instance,$bind($_,$_.transform)),function(s,_) {
			return rg.info.filter.TransformResult.Success(function() {
				return s;
			});
		},function(vin1,msg1) {
			return rg.info.filter.TransformResult.Failure(new thx.util.Message("parameter should be a string value or a function returning a string value"));
		}))(vin);
	}));
}
rg.info.filter.FilterDescription.custom = function(name,maps,transformer) {
	return rg.info.filter.FilterDescription.pair(name,maps,new rg.info.filter.CustomTransformer(transformer));
}
rg.info.filter.FilterDescription.simplified = function(name,maps,filter,validator) {
	return rg.info.filter.FilterDescription.pair(name,maps,rg.info.filter.CustomTransformer.simplified(filter,validator));
}
rg.info.filter.FilterDescription.pair = function(name,maps,transformer) {
	if(null == maps) maps = [name];
	return new rg.info.filter.FilterDescription(name,new rg.info.filter.PairTransformer(maps,transformer));
}
rg.info.filter.FilterDescription.prototype = {
	transformer: null
	,name: null
	,__class__: rg.info.filter.FilterDescription
}
rg.info.filter.CustomTransformer = function(transformer) {
	this.transformer = transformer;
};
$hxClasses["rg.info.filter.CustomTransformer"] = rg.info.filter.CustomTransformer;
rg.info.filter.CustomTransformer.__name__ = ["rg","info","filter","CustomTransformer"];
rg.info.filter.CustomTransformer.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.CustomTransformer.simplified = function(filter,validate) {
	return new rg.info.filter.CustomTransformer(function(value) {
		var err = validate(value);
		if(null == err) return rg.info.filter.TransformResult.Success(filter(value)); else return rg.info.filter.TransformResult.Failure(new thx.util.Message(err,[value]));
	});
}
rg.info.filter.CustomTransformer.prototype = {
	transform: function(value) {
		return this.transformer(value);
	}
	,transformer: null
	,__class__: rg.info.filter.CustomTransformer
}
rg.info.filter.TransformerChainer = function() { }
$hxClasses["rg.info.filter.TransformerChainer"] = rg.info.filter.TransformerChainer;
rg.info.filter.TransformerChainer.__name__ = ["rg","info","filter","TransformerChainer"];
rg.info.filter.TransformerChainer.onResult = function(src,success,failure) {
	return function(value) {
		var _g = src(value);
		var $e = (_g);
		switch( $e[1] ) {
		case 0:
			var out = $e[2];
			return success(out,value);
		case 1:
			var msg = $e[2];
			return failure(value,msg);
		}
	};
}
rg.info.filter.TransformerArray = function() {
};
$hxClasses["rg.info.filter.TransformerArray"] = rg.info.filter.TransformerArray;
rg.info.filter.TransformerArray.__name__ = ["rg","info","filter","TransformerArray"];
rg.info.filter.TransformerArray.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerArray.prototype = {
	transform: function(value) {
		if(js.Boot.__instanceof(value,Array)) return rg.info.filter.TransformResult.Success(value); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("value {0} is not an array",[value]));
	}
	,__class__: rg.info.filter.TransformerArray
}
rg.info.filter.TransformerObject = function() {
};
$hxClasses["rg.info.filter.TransformerObject"] = rg.info.filter.TransformerObject;
rg.info.filter.TransformerObject.__name__ = ["rg","info","filter","TransformerObject"];
rg.info.filter.TransformerObject.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerObject.prototype = {
	transform: function(value) {
		if(Reflect.isObject(value) && null == Type.getClass(value)) return rg.info.filter.TransformResult.Success(value); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("value {0} is not an object",[value]));
	}
	,__class__: rg.info.filter.TransformerObject
}
rg.info.filter.TransformerString = function() {
};
$hxClasses["rg.info.filter.TransformerString"] = rg.info.filter.TransformerString;
rg.info.filter.TransformerString.__name__ = ["rg","info","filter","TransformerString"];
rg.info.filter.TransformerString.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerString.prototype = {
	transform: function(value) {
		var _g = Type["typeof"](value);
		switch( (_g)[1] ) {
		case 3:
			return rg.info.filter.TransformResult.Success(value?"true":"false");
		case 1:
		case 2:
			return rg.info.filter.TransformResult.Success("" + Std.string(value));
		case 6:
			return rg.info.filter.TransformResult.Success(Std.string(value));
		default:
			return rg.info.filter.TransformResult.Failure(new thx.util.Message("unable to tranform {0} into a string value",[value]));
		}
	}
	,__class__: rg.info.filter.TransformerString
}
rg.info.filter.TransformerBool = function() {
};
$hxClasses["rg.info.filter.TransformerBool"] = rg.info.filter.TransformerBool;
rg.info.filter.TransformerBool.__name__ = ["rg","info","filter","TransformerBool"];
rg.info.filter.TransformerBool.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerBool.prototype = {
	transform: function(value) {
		var _g = Type["typeof"](value);
		var $e = (_g);
		switch( $e[1] ) {
		case 3:
			return rg.info.filter.TransformResult.Success(value);
		case 1:
		case 2:
			return rg.info.filter.TransformResult.Success(value != 0);
		case 6:
			var cls = $e[2];
			if("String" == Type.getClassName(cls)) {
				if(Bools.canParse(value)) return rg.info.filter.TransformResult.Success(Bools.parse(value)); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("unable to tranform the string '{0}'' into a boolean value",[value]));
			} else return rg.info.filter.TransformResult.Failure(new thx.util.Message("unable to tranform the instance of {0} into a boolean value",[value]));
			break;
		default:
			return rg.info.filter.TransformResult.Failure(new thx.util.Message("unable to tranform {0} into a boolean value",[value]));
		}
	}
	,__class__: rg.info.filter.TransformerBool
}
rg.info.filter.TransformerInt = function() {
};
$hxClasses["rg.info.filter.TransformerInt"] = rg.info.filter.TransformerInt;
rg.info.filter.TransformerInt.__name__ = ["rg","info","filter","TransformerInt"];
rg.info.filter.TransformerInt.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerInt.prototype = {
	transform: function(value) {
		var _g = Type["typeof"](value);
		switch( (_g)[1] ) {
		case 3:
			return rg.info.filter.TransformResult.Success(value?1:0);
		case 1:
			return rg.info.filter.TransformResult.Success(value);
		case 2:
			return rg.info.filter.TransformResult.Success(Std["int"](value));
		default:
			if(js.Boot.__instanceof(value,String) && Ints.canParse(value)) return rg.info.filter.TransformResult.Success(Ints.parse(value)); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("unable to tranform {0} into an integer value",[value]));
		}
	}
	,__class__: rg.info.filter.TransformerInt
}
rg.info.filter.TransformerFloat = function() {
};
$hxClasses["rg.info.filter.TransformerFloat"] = rg.info.filter.TransformerFloat;
rg.info.filter.TransformerFloat.__name__ = ["rg","info","filter","TransformerFloat"];
rg.info.filter.TransformerFloat.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerFloat.prototype = {
	transform: function(value) {
		var _g = Type["typeof"](value);
		switch( (_g)[1] ) {
		case 3:
			return rg.info.filter.TransformResult.Success(value?1.0:0.0);
		case 1:
		case 2:
			return rg.info.filter.TransformResult.Success(value);
		default:
			if(js.Boot.__instanceof(value,String) && Floats.canParse(value)) return rg.info.filter.TransformResult.Success(Floats.parse(value)); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("unable to tranform {0} into a float value",[value]));
		}
	}
	,__class__: rg.info.filter.TransformerFloat
}
rg.info.filter.TransformerFunction = function() {
};
$hxClasses["rg.info.filter.TransformerFunction"] = rg.info.filter.TransformerFunction;
rg.info.filter.TransformerFunction.__name__ = ["rg","info","filter","TransformerFunction"];
rg.info.filter.TransformerFunction.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerFunction.prototype = {
	transform: function(value) {
		if(Reflect.isFunction(value)) return rg.info.filter.TransformResult.Success(value); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("not a function"));
	}
	,__class__: rg.info.filter.TransformerFunction
}
rg.info.filter.TransformerTemplateToFunction = function(argumentsMap) {
	this.argumentsMap = argumentsMap;
};
$hxClasses["rg.info.filter.TransformerTemplateToFunction"] = rg.info.filter.TransformerTemplateToFunction;
rg.info.filter.TransformerTemplateToFunction.__name__ = ["rg","info","filter","TransformerTemplateToFunction"];
rg.info.filter.TransformerTemplateToFunction.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerTemplateToFunction.prototype = {
	transform: function(value) {
		var _g = this;
		if(js.Boot.__instanceof(value,String)) {
			var template = new erazor.Template(value);
			return rg.info.filter.TransformResult.Success(function() {
				return template.execute(rg.info.filter.TransformerExpressionToFunction.extractValues(_g.argumentsMap,arguments));
			});
		} else if(Reflect.isFunction(value)) return rg.info.filter.TransformResult.Success(value); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("not a function"));
	}
	,argumentsMap: null
	,__class__: rg.info.filter.TransformerTemplateToFunction
}
rg.info.filter.TransformerExpressionToFunction = function(argumentsMap) {
	this.argumentsMap = argumentsMap;
};
$hxClasses["rg.info.filter.TransformerExpressionToFunction"] = rg.info.filter.TransformerExpressionToFunction;
rg.info.filter.TransformerExpressionToFunction.__name__ = ["rg","info","filter","TransformerExpressionToFunction"];
rg.info.filter.TransformerExpressionToFunction.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.TransformerExpressionToFunction.extractValues = function(map,args) {
	var i = map.length, values = new haxe.ds.StringMap();
	values.set("ReportGrid",ReportGrid);
	values.set("format",ReportGrid.format);
	values.set("symbol",ReportGrid.symbol);
	values.set("humanize",ReportGrid.humanize);
	values.set("compare",ReportGrid.compare);
	values.set("Math",Math);
	values.set("null",null);
	values.set("true",true);
	values.set("false",false);
	while(--i >= 0) {
		var key = map[i];
		if(null == key) {
			var _g = 0, _g1 = Reflect.fields(args[i]);
			while(_g < _g1.length) {
				var key1 = _g1[_g];
				++_g;
				var value = Reflect.field(args[i],key1);
				values.set(key1,value);
			}
		} else values.set(key,args[i]);
	}
	return values;
}
rg.info.filter.TransformerExpressionToFunction.prototype = {
	transform: function(value) {
		var _g = this;
		if(js.Boot.__instanceof(value,String) && rg.info.filter.TransformerExpressionToFunction.pattern.match(value)) {
			value = value.substr(value.indexOf("=") + 1);
			var program = new hscript.Parser().parseString(value);
			return rg.info.filter.TransformResult.Success(function() {
				rg.info.filter.TransformerExpressionToFunction.interp.variables = rg.info.filter.TransformerExpressionToFunction.extractValues(_g.argumentsMap,arguments);
				return rg.info.filter.TransformerExpressionToFunction.interp.execute(program);
			});
		} else if(Reflect.isFunction(value)) return rg.info.filter.TransformResult.Success(value); else return rg.info.filter.TransformResult.Failure(new thx.util.Message("not a function"));
	}
	,argumentsMap: null
	,__class__: rg.info.filter.TransformerExpressionToFunction
}
rg.info.filter.ReturnMessageIfNot = function() { }
$hxClasses["rg.info.filter.ReturnMessageIfNot"] = rg.info.filter.ReturnMessageIfNot;
rg.info.filter.ReturnMessageIfNot.__name__ = ["rg","info","filter","ReturnMessageIfNot"];
rg.info.filter.ReturnMessageIfNot.isBool = function(v) {
	return js.Boot.__instanceof(v,Bool)?null:"not a boolean";
}
rg.info.filter.ReturnMessageIfNot.isString = function(v) {
	return js.Boot.__instanceof(v,String)?null:"not a string";
}
rg.info.filter.ReturnMessageIfNot.isObject = function(v) {
	return Reflect.isObject(v) && null == Type.getClass(v)?null:"not an object";
}
rg.info.filter.ReturnMessageChainer = function() { }
$hxClasses["rg.info.filter.ReturnMessageChainer"] = rg.info.filter.ReturnMessageChainer;
rg.info.filter.ReturnMessageChainer.__name__ = ["rg","info","filter","ReturnMessageChainer"];
rg.info.filter.ReturnMessageChainer.make = function(f,msg) {
	return function(v) {
		if(f(v)) return null; else return msg;
	};
}
rg.info.filter.ReturnMessageChainer.or = function(f1,f2) {
	return function(v) {
		var o = f1(v);
		if(null == o) return f2(v); else return o;
	};
}
rg.info.filter.PairTransformer = function(names,valueTransformer) {
	this.names = names;
	this.valueTransformer = valueTransformer;
};
$hxClasses["rg.info.filter.PairTransformer"] = rg.info.filter.PairTransformer;
rg.info.filter.PairTransformer.__name__ = ["rg","info","filter","PairTransformer"];
rg.info.filter.PairTransformer.__interfaces__ = [rg.info.filter.ITransformer];
rg.info.filter.PairTransformer.prototype = {
	transform: function(value) {
		var _g = this.valueTransformer.transform(value);
		var $e = (_g);
		switch( $e[1] ) {
		case 0:
			var v = $e[2];
			return rg.info.filter.TransformResult.Success(new rg.info.filter.Pairs(this.names,this.names.map(function(_) {
				return v;
			})));
		case 1:
			var reason = $e[2];
			return rg.info.filter.TransformResult.Failure(reason);
		}
	}
	,valueTransformer: null
	,names: null
	,__class__: rg.info.filter.PairTransformer
}
rg.info.filter.Pairs = function(names,values) {
	if(names.length != values.length) throw new thx.error.Error("names and values must have the same length",null,null,{ fileName : "Pairs.hx", lineNumber : 15, className : "rg.info.filter.Pairs", methodName : "new"});
	this.names = names;
	this.values = values;
};
$hxClasses["rg.info.filter.Pairs"] = rg.info.filter.Pairs;
rg.info.filter.Pairs.__name__ = ["rg","info","filter","Pairs"];
rg.info.filter.Pairs.prototype = {
	iterator: function() {
		var result = [];
		var _g1 = 0, _g = this.names.length;
		while(_g1 < _g) {
			var i = _g1++;
			result.push({ name : this.names[i], value : this.values[i]});
		}
		return HxOverrides.iter(result);
	}
	,values: null
	,names: null
	,__class__: rg.info.filter.Pairs
}
rg.info.filter.TransformResult = { __ename__ : ["rg","info","filter","TransformResult"], __constructs__ : ["Success","Failure"] }
rg.info.filter.TransformResult.Success = function(value) { var $x = ["Success",0,value]; $x.__enum__ = rg.info.filter.TransformResult; $x.toString = $estr; return $x; }
rg.info.filter.TransformResult.Failure = function(reason) { var $x = ["Failure",1,reason]; $x.__enum__ = rg.info.filter.TransformResult; $x.toString = $estr; return $x; }
rg.interactive = {}
rg.interactive.RGDownloader = function(container,serviceurl) {
	this.container = container;
	this.serviceUrl = serviceurl;
	this.tokenId = rg.util.RG.getTokenId();
};
$hxClasses["rg.interactive.RGDownloader"] = rg.interactive.RGDownloader;
rg.interactive.RGDownloader.__name__ = ["rg","interactive","RGDownloader"];
rg.interactive.RGDownloader.appendArgument = function(url,name,value) {
	var sep = url.indexOf("?") >= 0?"&":"?";
	return url + sep + name + "=" + StringTools.urlEncode(value);
}
rg.interactive.RGDownloader.prototype = {
	complete: function(success,error,content) {
		var ob = thx.json.Json.decode(content);
		if(null != ob.error) {
			if(null != error) error(ob.error);
		} else if(success(ob)) {
			var url = Reflect.field(ob.service,this.format);
			if(null != this.tokenId) url = rg.interactive.RGDownloader.appendArgument(url,"tokenId",this.tokenId);
			url = rg.interactive.RGDownloader.appendArgument(url,"forceDownload","true");
			js.Browser.window.location.href = url;
		}
	}
	,config: function() {
		var svg = this.container.select("svg"), width = svg.attr("width").getFloat(), height = svg.attr("height").getFloat();
		var config = "\"cache\":\"1d\",\"duration\":\"1d\",\"width\":" + width + ",\"height\":" + height + ",\"formats\":[\"" + rg.interactive.RGDownloader.ALLOWED_FORMATS.join("\",\"") + "\"]";
		if(null != this.tokenId) config += ",\"params\":{\"tokenId\":true}";
		return "{" + config + "}";
	}
	,html: function() {
		var css = this.findCssSources(), classes = this.container.attr("class").get(), svg = this.extractSvg(this.container.html().get());
		if(null == classes) classes = "rg"; else classes += " rg";
		var html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<title></title>\n" + (null == css?"":Iterators.map(HxOverrides.iter(css),function(href,_) {
			return "<link href=\"" + href + "\" rel=\"stylesheet\" type=\"text/css\" />";
		}).join("\n")) + "\n</head>\n<body>\n<div class=\"" + classes + "\">" + svg + "</div>\n</body>\n</html>";
		return html;
	}
	,extractSvg: function(s) {
		var start = new EReg("<svg",""), end = new EReg("</svg>","");
		start.match(s);
		s = start.matchedRight();
		end.match(s);
		return "<svg" + end.matchedLeft() + "</svg>";
	}
	,findCssSources: function() {
		return dhx.Dom.selectAll("link").filterNode(function(n,_) {
			return "stylesheet" == n.rel;
		}).mapNode(function(n,_) {
			return n.href;
		});
	}
	,download: function(format,backgroundcolor,success,error) {
		if(!Arrays.exists(rg.interactive.RGDownloader.ALLOWED_FORMATS,format)) throw new thx.error.Error("The download format '{0}' is not correct",[format],null,{ fileName : "RGDownloader.hx", lineNumber : 32, className : "rg.interactive.RGDownloader", methodName : "download"});
		this.format = format;
		var http = new haxe.Http(this.url(format));
		http.setHeader("Accept","application/json");
		if(null != error) http.onError = error; else http.onError = function(e) {
			null;
		};
		http.onData = (function(f,a1,a2) {
			return function(a3) {
				return f(a1,a2,a3);
			};
		})($bind(this,this.complete),success,error);
		http.setParameter("html",this.html());
		http.setParameter("config",this.config());
		http.request(true);
	}
	,url: function(ext) {
		return StringTools.replace(this.serviceUrl,"{ext}",ext);
	}
	,tokenId: null
	,format: null
	,container: null
	,serviceUrl: null
	,__class__: rg.interactive.RGDownloader
}
rg.interactive.RGLegacyRenderer = function(container,serviceurl) {
	this.container = container;
	this.serviceUrl = serviceurl;
	this.tokenId = rg.util.RG.getTokenId();
};
$hxClasses["rg.interactive.RGLegacyRenderer"] = rg.interactive.RGLegacyRenderer;
rg.interactive.RGLegacyRenderer.__name__ = ["rg","interactive","RGLegacyRenderer"];
rg.interactive.RGLegacyRenderer.getIframeDoc = function(iframe) {
	var iframeDoc = null;
	var attempts = [function() {
		if(iframe.contentDocument) iframeDoc = iframe.contentDocument;
	},function() {
		if(iframe.contentWindow && iframe.contentWindow.document) iframeDoc = iframe.contentWindow.document;
	},function() {
		if(null != js.Browser.window.frames[iframe.name]) iframeDoc = js.Browser.window.frames[iframe.name].document;
	}];
	var _g = 0;
	while(_g < attempts.length) {
		var attempt = attempts[_g];
		++_g;
		try {
			attempt();
		} catch( e ) {
		}
		if(null != iframeDoc) return iframeDoc;
	}
	return null;
}
rg.interactive.RGLegacyRenderer.isIE7orBelow = function() {
	return document.all && !document.querySelector;
}
rg.interactive.RGLegacyRenderer.removeFunctions = function(o) {
	var _g = 0, _g1 = Reflect.fields(o);
	while(_g < _g1.length) {
		var field = _g1[_g];
		++_g;
		var f = Reflect.field(o,field);
		if(Reflect.isFunction(f)) Reflect.deleteField(o,field); else if(Reflect.isObject(o) && null == Type.getClass(o)) rg.interactive.RGLegacyRenderer.removeFunctions(f);
	}
}
rg.interactive.RGLegacyRenderer.removeEmpties = function(o) {
	var _g = 0, _g1 = Reflect.fields(o);
	while(_g < _g1.length) {
		var field = _g1[_g];
		++_g;
		var f = Reflect.field(o,field);
		if(Reflect.isObject(f) && null == Type.getClass(f)) {
			rg.interactive.RGLegacyRenderer.removeEmpties(f);
			if(Reflect.fields(f).length == 0) Reflect.deleteField(o,field);
		} else if(null == f) Reflect.deleteField(o,field);
	}
}
rg.interactive.RGLegacyRenderer.prototype = {
	config: function(size) {
		var c = "\"cache\":\"1d\",\"duration\":\"1d\",\"width\":" + size.width + ",\"height\":" + size.height + ",\"formats\":[\"" + rg.interactive.RGLegacyRenderer.FORMAT + "\"]";
		return "{" + c + "}";
	}
	,html: function(id,params,size) {
		var p = thx.json.Json.encode(params), scripts = this.findJsSources(), css = this.findCssSources(), classes = this.container.attr("class").get();
		if(null == classes) classes = "rg"; else classes += " rg";
		var h = "<!DOCTYPE html>\n<html>\n<head>\n<title></title>\n" + (null == scripts?"":Iterators.map(HxOverrides.iter(scripts),function(src,_) {
			return "<script src=\"" + src + "\" type=\"text/javascript\"></script>";
		}).join("\n")) + (null == css?"":Iterators.map(HxOverrides.iter(css),function(href,_) {
			return "<link href=\"" + href + "\" rel=\"stylesheet\" type=\"text/css\" />";
		}).join("\n")) + "\n<script type=\"text/javascript\">\nfunction __RG__render()\n{\nReportGrid.chart(\"#" + id + "\", " + p + ");\n}\n</script>\n</head>\n<body onload=\"__RG__render()\">\n<div id=\"" + id + "\" class=\"" + classes + "\" style=\"margin:0;width:" + size.width + "px;height:" + size.height + "px;\"></div>\n</body>\n</html>";
		return h;
	}
	,findCssSources: function() {
		return dhx.Dom.selectAll("link").filterNode(function(n,_) {
			return "stylesheet" == n.rel;
		}).mapNode(function(n,_) {
			return n.href;
		});
	}
	,findJsSources: function() {
		var re = new EReg("reportgrid-[^.]+\\.js","");
		return dhx.Dom.selectAll("script").filterNode(function(n,_) {
			return re.match(n.src);
		}).mapNode(function(n,_) {
			return n.src;
		});
	}
	,normalizeParams: function(params) {
		if(null == params.options) params.options = { };
		var size = rg.factory.FactoryLayout.size(this.container,params.options,0);
		params.options.width = size.width;
		params.options.height = size.height;
		rg.interactive.RGLegacyRenderer.removeFunctions(params.options);
		rg.interactive.RGLegacyRenderer.removeEmpties(params);
		Reflect.deleteField(params,"load");
		Reflect.deleteField(params.options,"download");
		params.options.forcelegacy = false;
		return size;
	}
	,writeToIframe: function(iframe,content) {
		var iframeDoc = rg.interactive.RGLegacyRenderer.getIframeDoc(iframe);
		if(null != iframeDoc) {
			iframeDoc.open();
			iframeDoc.write("<html><head><title></title></head><body style=\"visibility:hidden;border:none\" scroll=\"no\">" + content + "</body></html>");
			iframeDoc.close();
		}
	}
	,createIframe: function(width,height) {
		var id = "rgiframe" + ++rg.interactive.RGLegacyRenderer.nextframeid;
		return this.container.append("iframe").attr("name").string(id).attr("id").string(id).attr("frameBorder").string("0").attr("scrolling").string("no").attr("width").string(width + "").attr("height").string(height + "").attr("marginwidth").string("0").attr("marginheight").string("0").attr("hspace").string("0").attr("vspace").string("0").attr("style").string("width:100%; border:0; height:100%; overflow:hidden;").attr("src").string(rg.interactive.RGLegacyRenderer.isIE7orBelow()?"javascript:'<script>window.onload=function(){document.body.scroll=\"no\";document.body.style.overflow=\"hidden\";document.write(\\'<script>document.domain=\\\\\"" + js.Browser.document.domain + "\\\\\";<\\\\\\\\/script>\\');document.close();};<\\/script>'":"about:blank");
	}
	,display: function(params) {
		var _g = this;
		var size = this.normalizeParams(params);
		var id = this.container.attr("id").get(), iframe = this.createIframe(size.width,size.height);
		if(null == id) id = "rgchart";
		var u = this.url();
		var h = this.html(id,params,size);
		var c = this.config(size);
		var content = "<form method=\"post\" action=\"" + u + "\" name=\"VIZ\"><textarea name=\"html\" style=\"width:40em;height:50%\">" + h + "</textarea><textarea name=\"config\" style=\"width:40em;height:50%\">" + c + "</textarea><script type=\"text/javascript\">\nsetTimeout(function() { document.VIZ.submit(); }, 200);\n</script>\n</form>";
		haxe.Timer.delay(function() {
			_g.writeToIframe(iframe.node(),content);
			if(null != _g.readyHandler) _g.readyHandler();
		},100);
		if(rg.interactive.RGLegacyRenderer.isIE7orBelow()) {
			var inode = iframe.node();
			inode.attachEvent("onload",function() {
				var doc = rg.interactive.RGLegacyRenderer.getIframeDoc(inode);
				if(null != doc) {
					doc.body.scroll = "no";
					doc.body.style.overflow = "hidden";
					doc.body.frameBorder = "0";
					doc.body.style.border = 0;
					doc.body.style.margin = 0;
					doc.body.style.padding = 0;
				}
			});
		}
	}
	,onReady: function(handler) {
		this.readyHandler = handler;
	}
	,readyHandler: null
	,url: function() {
		return StringTools.replace(this.serviceUrl,"{ext}",rg.interactive.RGLegacyRenderer.FORMAT);
	}
	,tokenId: null
	,container: null
	,serviceUrl: null
	,__class__: rg.interactive.RGLegacyRenderer
}
rg.layout = {}
rg.layout.Anchor = { __ename__ : ["rg","layout","Anchor"], __constructs__ : ["Top","Bottom","Left","Right"] }
rg.layout.Anchor.Top = ["Top",0];
rg.layout.Anchor.Top.toString = $estr;
rg.layout.Anchor.Top.__enum__ = rg.layout.Anchor;
rg.layout.Anchor.Bottom = ["Bottom",1];
rg.layout.Anchor.Bottom.toString = $estr;
rg.layout.Anchor.Bottom.__enum__ = rg.layout.Anchor;
rg.layout.Anchor.Left = ["Left",2];
rg.layout.Anchor.Left.toString = $estr;
rg.layout.Anchor.Left.__enum__ = rg.layout.Anchor;
rg.layout.Anchor.Right = ["Right",3];
rg.layout.Anchor.Right.toString = $estr;
rg.layout.Anchor.Right.__enum__ = rg.layout.Anchor;
rg.layout.Layout = function(width,height,container) {
	this.container = container;
	container.classed().add("rg");
	this.space = new rg.svg.panel.Space(this.width = width,this.height = height,container.append("div"));
};
$hxClasses["rg.layout.Layout"] = rg.layout.Layout;
rg.layout.Layout.__name__ = ["rg","layout","Layout"];
rg.layout.Layout.prototype = {
	adjustPadding: function() {
	}
	,feedOptions: function(info) {
		this.mainPanelName = info.main;
		this.paddings = info.padding;
	}
	,paddings: null
	,suggestPanelPadding: function(panel,before,after) {
		if(null == panel) return;
		var stackitem = Types["as"](panel.frame,rg.frame.StackItem);
		if(null == stackitem) return;
		var $e = (stackitem.disposition);
		switch( $e[1] ) {
		case 0:
			var max = $e[5], min = $e[4], a = $e[3], b = $e[2];
			stackitem.set_disposition(rg.frame.FrameLayout.Fill(null == before?b:before,null == after?a:after,min,max));
			break;
		case 1:
			var max = $e[6], min = $e[5], percent = $e[4], a = $e[3], b = $e[2];
			stackitem.set_disposition(rg.frame.FrameLayout.FillPercent(null == before?b:before,null == after?a:after,percent,min,max));
			break;
		case 2:
			var ratio = $e[4], a = $e[3], b = $e[2];
			stackitem.set_disposition(rg.frame.FrameLayout.FillRatio(null == before?b:before,null == after?a:after,ratio));
			break;
		case 3:
			var size = $e[4], a = $e[3], b = $e[2];
			stackitem.set_disposition(rg.frame.FrameLayout.Fixed(null == before?b:before,null == after?a:after,size));
			break;
		default:
		}
	}
	,suggestPanelSize: function(panel,size) {
		var stackitem = Types["as"](panel.frame,rg.frame.StackItem);
		if(null == stackitem) return;
		var $e = (stackitem.disposition);
		switch( $e[1] ) {
		case 3:
			var stackitem_fdisposition_eFixed_2 = $e[4], a = $e[3], b = $e[2];
			stackitem.set_disposition(rg.frame.FrameLayout.Fixed(b,a,size));
			break;
		default:
		}
	}
	,destroy: function() {
		this.container.selectAll("*").remove();
	}
	,suggestSize: function(name,size) {
		var panel = this.getPanel(name);
		if(null == panel) return;
		this.suggestPanelSize(panel,size);
	}
	,getPanel: function(name) {
		return null;
	}
	,getContext: function(name) {
		return null;
	}
	,container: null
	,space: null
	,height: null
	,width: null
	,mainPanelName: null
	,__class__: rg.layout.Layout
}
rg.layout.LayoutCartesian = function(width,height,container) {
	rg.layout.Layout.call(this,width,height,container);
	this.titleOnTop = true;
	this.right = false;
	this.alternating = true;
	this.yitems = [];
};
$hxClasses["rg.layout.LayoutCartesian"] = rg.layout.LayoutCartesian;
rg.layout.LayoutCartesian.__name__ = ["rg","layout","LayoutCartesian"];
rg.layout.LayoutCartesian.__super__ = rg.layout.Layout;
rg.layout.LayoutCartesian.prototype = $extend(rg.layout.Layout.prototype,{
	adjustPadding: function() {
		var top = null == this.title && null == this.paddings.top?8:this.paddings.top, bottom = (null == this.xtickmarks || !this.titleOnTop && null == this.title) && null == this.paddings.bottom?8:this.paddings.bottom, left = null == this.leftcontainer && null == this.paddings.left?20:this.paddings.left, right = null == this.rightcontainer && null == this.paddings.right?20:this.paddings.right;
		if(null != left || null != right) {
			this.suggestPanelPadding(this.getMain(),left,right);
			this.suggestPanelPadding(this.bottommiddlecontainer,left,right);
		}
		if(null != top || null != bottom) this.suggestPanelPadding(this.middlecontainer,top,bottom);
	}
	,feedOptions: function(info) {
		rg.layout.Layout.prototype.feedOptions.call(this,info);
		this.titleOnTop = info.titleOnTop;
		switch( (info.scalePattern)[1] ) {
		case 0:
			this.right = false;
			this.alternating = false;
			break;
		case 1:
			this.right = true;
			this.alternating = false;
			break;
		case 2:
			this.right = false;
			this.alternating = true;
			break;
		}
	}
	,getMain: function() {
		if(null == this.main) this.main = this.getMiddleContainer().createPanelAt(1,rg.frame.FrameLayout.Fill(0,0));
		return this.main;
	}
	,getXTickmarks: function() {
		if(null == this.xtickmarks) {
			var container = this.getBottomMiddleContainer();
			this.xtickmarks = new rg.layout.PanelContext(container.createPanelAt(0,rg.frame.FrameLayout.Fixed(0,0,0)),rg.layout.Anchor.Top);
		}
		return this.xtickmarks;
	}
	,getBottomMiddleContainer: function() {
		if(null == this.bottommiddlecontainer) {
			var container = this.getBottomContainer();
			this.bottomleft = container.createPanel(rg.frame.FrameLayout.Fixed(0,0,0));
			this.bottommiddlecontainer = container.createContainer(rg.frame.FrameLayout.Fill(0,0),rg.frame.Orientation.Vertical);
			this.bottommiddlecontainer.g.classed().add("axis-x");
			this.bottomright = container.createPanel(rg.frame.FrameLayout.Fixed(0,0,0));
		}
		return this.bottommiddlecontainer;
	}
	,getBottomContainer: function() {
		if(null == this.bottomcontainer) this.bottomcontainer = this.getMainContainer().createContainerAt(1,rg.frame.FrameLayout.Fixed(0,0,0),rg.frame.Orientation.Horizontal);
		return this.bottomcontainer;
	}
	,getRightContainer: function() {
		if(null == this.rightcontainer) {
			this.getMain();
			this.rightcontainer = this.getMiddleContainer().createContainer(rg.frame.FrameLayout.Fixed(0,0,0),rg.frame.Orientation.Horizontal);
		}
		return this.rightcontainer;
	}
	,getLeftContainer: function() {
		if(null == this.leftcontainer) this.leftcontainer = this.getMiddleContainer().createContainerAt(0,rg.frame.FrameLayout.Fixed(0,0,0),rg.frame.Orientation.Horizontal);
		return this.leftcontainer;
	}
	,getMiddleContainer: function() {
		if(null == this.middlecontainer) this.middlecontainer = this.getMainContainer().createContainerAt(0,rg.frame.FrameLayout.Fill(0,0),rg.frame.Orientation.Horizontal);
		return this.middlecontainer;
	}
	,getMainContainer: function() {
		if(null == this.maincontainer) this.maincontainer = this.space.createContainerAt(this.titleOnTop?1:0,rg.frame.FrameLayout.Fill(0,0),rg.frame.Orientation.Vertical);
		return this.maincontainer;
	}
	,getXTitle: function() {
		if(null == this.xtitle) this.xtitle = new rg.layout.PanelContext(this.getBottomMiddleContainer().createPanel(rg.frame.FrameLayout.Fixed(0,0,0)),rg.layout.Anchor.Top);
		return this.xtitle;
	}
	,suggestLateralSize: function(anchor) {
		var size = 0;
		var i = 0;
		var _g = 0, _g1 = this.yitems;
		while(_g < _g1.length) {
			var item = _g1[_g];
			++_g;
			i++;
			if(null == item.container || !Type.enumEq(item.anchor,anchor)) continue;
			size += item.container.frame.width;
		}
		switch( (anchor)[1] ) {
		case 3:
			this.suggestSize("left",size);
			this.suggestSize("bottomleft",size);
			break;
		case 2:
			this.suggestSize("right",size);
			this.suggestSize("bottomright",size);
			break;
		default:
		}
	}
	,suggestSize: function(name,size) {
		if(this.isY(name) || this.isYTitle(name)) {
			var index = this.getYIndex(name), item = this.getYItem(index);
			if(null == item.container) return;
			var ysize = 0.0;
			if(null != item.context) {
				if(this.isY(name)) this.suggestPanelSize(item.context.panel,size);
				ysize += item.context.panel.frame.width;
			}
			if(null != item.title) {
				if(this.isYTitle(name)) this.suggestPanelSize(item.title.panel,size);
				ysize += item.title.panel.frame.width;
			}
			this.suggestPanelSize(item.container,Math.round(ysize));
			this.suggestLateralSize(item.anchor);
			return;
		}
		rg.layout.Layout.prototype.suggestSize.call(this,name,size);
		switch(name) {
		case "x":case "xtitle":
			var size1 = 0, c = this.getPanel("x");
			if(null != c) size1 += c.frame.height;
			c = this.getPanel("xtitle");
			if(null != c) size1 += c.frame.height;
			rg.layout.Layout.prototype.suggestSize.call(this,"xtickmarks",size1);
			break;
		}
	}
	,isYTitle: function(s) {
		return rg.layout.LayoutCartesian.REYTITLE.match(s);
	}
	,isY: function(s) {
		return rg.layout.LayoutCartesian.REYAXIS.match(s);
	}
	,getYIndex: function(s) {
		if(!rg.layout.LayoutCartesian.REYINDEX.match(s)) return -1; else return Std.parseInt(rg.layout.LayoutCartesian.REYINDEX.matched(1));
	}
	,getYTitle: function(index) {
		var item = this.getYItem(index);
		if(null == item.title) {
			var panel = (function($this) {
				var $r;
				switch( (item.anchor)[1] ) {
				case 2:
					$r = $this.getYContainer(index).createPanel(rg.frame.FrameLayout.Fixed(0,0,0));
					break;
				case 3:
					$r = $this.getYContainer(index).createPanelAt(0,rg.frame.FrameLayout.Fixed(0,0,0));
					break;
				default:
					$r = null;
				}
				return $r;
			}(this));
			item.title = new rg.layout.PanelContext(panel,item.anchor);
		}
		return item.title;
	}
	,getYContext: function(index) {
		var item = this.getYItem(index);
		if(null == item.context) {
			var panel = (function($this) {
				var $r;
				switch( (item.anchor)[1] ) {
				case 2:
					$r = $this.getYContainer(index).createPanelAt(0,rg.frame.FrameLayout.Fixed(0,0,0));
					break;
				case 3:
					$r = $this.getYContainer(index).createPanel(rg.frame.FrameLayout.Fixed(0,0,0));
					break;
				default:
					$r = null;
				}
				return $r;
			}(this));
			item.context = new rg.layout.PanelContext(panel,item.anchor);
		}
		return item.context;
	}
	,getYContainer: function(index) {
		var item = this.getYItem(index);
		if(null == item.container) {
			if(this.right || this.alternating && index % 2 != 0) item.container = this.getRightContainer().createContainer(rg.frame.FrameLayout.Fixed(0,0,0),rg.frame.Orientation.Horizontal); else item.container = this.getLeftContainer().createContainerAt(0,rg.frame.FrameLayout.Fixed(0,0,0),rg.frame.Orientation.Horizontal);
			item.container.g.classed().add("group-" + index);
		}
		return item.container;
	}
	,getYItem: function(index) {
		if(null == this.yitems[index]) this.yitems[index] = { container : null, context : null, title : null, anchor : this.right || this.alternating && index % 2 != 0?rg.layout.Anchor.Left:rg.layout.Anchor.Right};
		return this.yitems[index];
	}
	,getPanel: function(name) {
		switch(name) {
		case "main":
			return this.getMain();
		case "xtickmarks":
			return this.getBottomContainer();
		case "left":
			return this.getLeftContainer();
		case "right":
			return this.getRightContainer();
		case "bottomleft":
			return this.bottomleft;
		case "bottomright":
			return this.bottomright;
		default:
			var ctx = this.getContext(name);
			if(null == ctx) return null;
			return ctx.panel;
		}
	}
	,getContext: function(name) {
		if(this.isY(name)) return this.getYContext(this.getYIndex(name)); else if(this.isYTitle(name)) return this.getYTitle(this.getYIndex(name));
		switch(name) {
		case "title":
			if(null == this.title) this.title = new rg.layout.PanelContext(this.space.createPanelAt(this.titleOnTop?0:1,rg.frame.FrameLayout.Fixed(0,0,0)),this.titleOnTop?rg.layout.Anchor.Bottom:rg.layout.Anchor.Top);
			return this.title;
		case "x":
			return this.getXTickmarks();
		case "xtitle":
			return this.getXTitle();
		default:
			return null;
		}
	}
	,xtitle: null
	,yitems: null
	,alternating: null
	,right: null
	,title: null
	,xtickmarks: null
	,bottomright: null
	,bottomleft: null
	,middlecontainer: null
	,maincontainer: null
	,bottommiddlecontainer: null
	,bottomcontainer: null
	,rightcontainer: null
	,leftcontainer: null
	,titleOnTop: null
	,main: null
	,__class__: rg.layout.LayoutCartesian
});
rg.layout.LayoutSimple = function(width,height,container) {
	rg.layout.Layout.call(this,width,height,container);
	this.titleOnTop = true;
};
$hxClasses["rg.layout.LayoutSimple"] = rg.layout.LayoutSimple;
rg.layout.LayoutSimple.__name__ = ["rg","layout","LayoutSimple"];
rg.layout.LayoutSimple.__super__ = rg.layout.Layout;
rg.layout.LayoutSimple.prototype = $extend(rg.layout.Layout.prototype,{
	feedOptions: function(info) {
		rg.layout.Layout.prototype.feedOptions.call(this,info);
		this.titleOnTop = info.titleOnTop;
	}
	,getTitle: function() {
		if(null == this.title) this.title = new rg.layout.PanelContext(this.space.createPanelAt(this.titleOnTop?0:1,rg.frame.FrameLayout.Fixed(0,0,20)),this.titleOnTop?rg.layout.Anchor.Bottom:rg.layout.Anchor.Top);
		return this.title;
	}
	,title: null
	,getPanel: function(name) {
		switch(name) {
		case "main":
			if(null == this.main) this.main = this.space.createPanelAt(this.titleOnTop?1:0,rg.frame.FrameLayout.Fill(0,0));
			return this.main;
		case "title":
			return this.getTitle().panel;
		default:
			return null;
		}
	}
	,getContext: function(name) {
		switch(name) {
		case "title":
			if(null != this.title) return null;
			return this.getTitle();
		default:
			return null;
		}
	}
	,titleOnTop: null
	,main: null
	,__class__: rg.layout.LayoutSimple
});
rg.layout.LayoutX = function(width,height,container) {
	rg.layout.Layout.call(this,width,height,container);
	this.titleOnTop = true;
};
$hxClasses["rg.layout.LayoutX"] = rg.layout.LayoutX;
rg.layout.LayoutX.__name__ = ["rg","layout","LayoutX"];
rg.layout.LayoutX.__super__ = rg.layout.Layout;
rg.layout.LayoutX.prototype = $extend(rg.layout.Layout.prototype,{
	adjustPadding: function() {
		var top = null == this.title && null == this.paddings.top?8:this.paddings.top, bottom = (null == this.xtickmarks || !this.titleOnTop && null == this.title) && null == this.paddings.bottom?8:this.paddings.bottom, left = null == this.paddings.left?20:this.paddings.left, right = null == this.paddings.right?20:this.paddings.right;
		if(null != left || null != right) {
			this.suggestPanelPadding(this.getMain(),left,right);
			this.suggestPanelPadding(this.bottommiddlecontainer,left,right);
		}
		if(null != top || null != bottom) this.suggestPanelPadding(this.middlecontainer,top,bottom);
	}
	,feedOptions: function(info) {
		rg.layout.Layout.prototype.feedOptions.call(this,info);
		this.titleOnTop = info.titleOnTop;
	}
	,getMain: function() {
		if(null == this.main) this.main = this.getMiddleContainer().createPanelAt(1,rg.frame.FrameLayout.Fill(0,0));
		return this.main;
	}
	,getXTickmarks: function() {
		if(null == this.xtickmarks) {
			var container = this.getBottomMiddleContainer();
			this.xtickmarks = new rg.layout.PanelContext(container.createPanelAt(0,rg.frame.FrameLayout.Fixed(0,0,0)),rg.layout.Anchor.Top);
		}
		return this.xtickmarks;
	}
	,getBottomMiddleContainer: function() {
		if(null == this.bottommiddlecontainer) {
			var container = this.getBottomContainer();
			this.bottommiddlecontainer = container.createContainer(rg.frame.FrameLayout.Fill(0,0),rg.frame.Orientation.Vertical);
			this.bottommiddlecontainer.g.classed().add("axis-x");
		}
		return this.bottommiddlecontainer;
	}
	,getBottomContainer: function() {
		if(null == this.bottomcontainer) this.bottomcontainer = this.getMainContainer().createContainerAt(1,rg.frame.FrameLayout.Fixed(0,0,0),rg.frame.Orientation.Horizontal);
		return this.bottomcontainer;
	}
	,getMiddleContainer: function() {
		if(null == this.middlecontainer) this.middlecontainer = this.getMainContainer().createContainerAt(0,rg.frame.FrameLayout.Fill(0,0),rg.frame.Orientation.Horizontal);
		return this.middlecontainer;
	}
	,getMainContainer: function() {
		if(null == this.maincontainer) this.maincontainer = this.space.createContainerAt(this.titleOnTop?1:0,rg.frame.FrameLayout.Fill(0,0),rg.frame.Orientation.Vertical);
		return this.maincontainer;
	}
	,getXTitle: function() {
		if(null == this.xtitle) this.xtitle = new rg.layout.PanelContext(this.getBottomMiddleContainer().createPanel(rg.frame.FrameLayout.Fixed(0,0,0)),rg.layout.Anchor.Top);
		return this.xtitle;
	}
	,suggestSize: function(name,size) {
		rg.layout.Layout.prototype.suggestSize.call(this,name,size);
		switch(name) {
		case "x":case "xtitle":
			var size1 = 0, c = this.getPanel("x");
			if(null != c) size1 += c.frame.height;
			c = this.getPanel("xtitle");
			if(null != c) size1 += c.frame.height;
			rg.layout.Layout.prototype.suggestSize.call(this,"xtickmarks",size1);
			break;
		}
	}
	,getPanel: function(name) {
		switch(name) {
		case "main":
			return this.getMain();
		case "xtickmarks":
			return this.getBottomContainer();
		default:
			var ctx = this.getContext(name);
			if(null == ctx) return null;
			return ctx.panel;
		}
	}
	,getContext: function(name) {
		switch(name) {
		case "title":
			if(null == this.title) this.title = new rg.layout.PanelContext(this.space.createPanelAt(this.titleOnTop?0:1,rg.frame.FrameLayout.Fixed(0,0,0)),this.titleOnTop?rg.layout.Anchor.Bottom:rg.layout.Anchor.Top);
			return this.title;
		case "x":
			return this.getXTickmarks();
		case "xtitle":
			return this.getXTitle();
		default:
			return null;
		}
	}
	,xtitle: null
	,title: null
	,xtickmarks: null
	,middlecontainer: null
	,maincontainer: null
	,bottommiddlecontainer: null
	,bottomcontainer: null
	,titleOnTop: null
	,main: null
	,__class__: rg.layout.LayoutX
});
rg.layout.PanelContext = function(panel,anchor) {
	this.panel = panel;
	this.anchor = anchor;
};
$hxClasses["rg.layout.PanelContext"] = rg.layout.PanelContext;
rg.layout.PanelContext.__name__ = ["rg","layout","PanelContext"];
rg.layout.PanelContext.prototype = {
	anchor: null
	,panel: null
	,__class__: rg.layout.PanelContext
}
rg.layout.ScalePattern = { __ename__ : ["rg","layout","ScalePattern"], __constructs__ : ["ScalesBefore","ScalesAfter","ScalesAlternating"] }
rg.layout.ScalePattern.ScalesBefore = ["ScalesBefore",0];
rg.layout.ScalePattern.ScalesBefore.toString = $estr;
rg.layout.ScalePattern.ScalesBefore.__enum__ = rg.layout.ScalePattern;
rg.layout.ScalePattern.ScalesAfter = ["ScalesAfter",1];
rg.layout.ScalePattern.ScalesAfter.toString = $estr;
rg.layout.ScalePattern.ScalesAfter.__enum__ = rg.layout.ScalePattern;
rg.layout.ScalePattern.ScalesAlternating = ["ScalesAlternating",2];
rg.layout.ScalePattern.ScalesAlternating.toString = $estr;
rg.layout.ScalePattern.ScalesAlternating.__enum__ = rg.layout.ScalePattern;
rg.query = {}
rg.query.BaseQuery = function(async,first) {
	this._async = async;
	this._first = first;
	this._store = new haxe.ds.StringMap();
};
$hxClasses["rg.query.BaseQuery"] = rg.query.BaseQuery;
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
$hxClasses["rg.query.Query"] = rg.query.Query;
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
rg.query.Transformers = function() { }
$hxClasses["rg.query.Transformers"] = rg.query.Transformers;
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
	var map = new haxe.ds.StringMap(), result = [];
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
rg.svg = {}
rg.svg.panel = {}
rg.svg.panel.Layer = function(panel) {
	this.frame = (this.panel = panel).frame;
	var p = panel;
	p.addLayer(this);
	this.g = panel.g.append("svg:g");
	this.g.attr("class").string("layer");
	this._resize();
};
$hxClasses["rg.svg.panel.Layer"] = rg.svg.panel.Layer;
rg.svg.panel.Layer.__name__ = ["rg","svg","panel","Layer"];
rg.svg.panel.Layer.prototype = {
	resize: function() {
	}
	,_resize: function() {
		this.width = this.frame.width;
		this.height = this.frame.height;
		this.resize();
	}
	,addClass: function(name) {
		var _g = this;
		name.split(" ").forEach(function(d,i) {
			_g.g.classed().add(d);
		});
	}
	,height: null
	,width: null
	,g: null
	,frame: null
	,panel: null
	,__class__: rg.svg.panel.Layer
}
rg.svg.chart = {}
rg.svg.chart.Chart = function(panel) {
	rg.svg.panel.Layer.call(this,panel);
	this.animated = true;
	this.animationDuration = 1500;
	this.animationEase = thx.math.Equations.linear;
	this.ready = new hxevents.Notifier();
};
$hxClasses["rg.svg.chart.Chart"] = rg.svg.chart.Chart;
rg.svg.chart.Chart.__name__ = ["rg","svg","chart","Chart"];
rg.svg.chart.Chart.__super__ = rg.svg.panel.Layer;
rg.svg.chart.Chart.prototype = $extend(rg.svg.panel.Layer.prototype,{
	moveTooltip: function(x,y,color) {
		var coords = rg.svg.panel.Panels.absolutePos(this.panel);
		this.panelx = coords.x;
		this.panely = coords.y;
		this.tooltip.setAnchorColor(color);
		this.tooltip.showAt(this.panelx + x | 0,this.panely + y | 0);
	}
	,init: function() {
		if(null != this.labelDataPointOver) this.tooltip = rg.html.widget.Tooltip.get_instance();
		this.resize();
	}
	,resize: function() {
		var coords = rg.svg.panel.Panels.absolutePos(this.panel);
		this.panelx = coords.x;
		this.panely = coords.y;
	}
	,tooltip: null
	,panely: null
	,panelx: null
	,ready: null
	,labelDataPointOver: null
	,labelDataPoint: null
	,click: null
	,animationEase: null
	,animationDuration: null
	,animated: null
	,__class__: rg.svg.chart.Chart
});
rg.svg.chart.CartesianChart = function(panel) {
	rg.svg.chart.Chart.call(this,panel);
	this.labelDataPointVerticalOffset = 25;
	this.labelDataPointOutline = false;
	this.labelDataPointShadow = false;
};
$hxClasses["rg.svg.chart.CartesianChart"] = rg.svg.chart.CartesianChart;
rg.svg.chart.CartesianChart.__name__ = ["rg","svg","chart","CartesianChart"];
rg.svg.chart.CartesianChart.__super__ = rg.svg.chart.Chart;
rg.svg.chart.CartesianChart.prototype = $extend(rg.svg.chart.Chart.prototype,{
	data: function(dps) {
		throw new thx.error.AbstractMethod({ fileName : "CartesianChart.hx", lineNumber : 43, className : "rg.svg.chart.CartesianChart", methodName : "data"});
	}
	,setVariables: function(variables,variableIndependents,variableDependents,data) {
		this.xVariable = variables[0];
		this.yVariables = variables.slice(1);
	}
	,labelDataPointShadow: null
	,labelDataPointOutline: null
	,labelDataPointVerticalOffset: null
	,xVariable: null
	,yVariables: null
	,__class__: rg.svg.chart.CartesianChart
});
rg.svg.chart.BarChart = function(panel) {
	rg.svg.chart.CartesianChart.call(this,panel);
	this.addClass("bar-chart");
	this.defs = this.g.append("svg:defs");
	this.chart = this.g.append("svg:g");
	this.gradientLightness = 2;
	this.displayGradient = true;
	this.padding = 10;
	this.paddingAxis = 4;
	this.paddingDataPoint = 2;
	this.horizontal = false;
	this.startat = null;
	this.segmentProperty = null;
};
$hxClasses["rg.svg.chart.BarChart"] = rg.svg.chart.BarChart;
rg.svg.chart.BarChart.__name__ = ["rg","svg","chart","BarChart"];
rg.svg.chart.BarChart.__super__ = rg.svg.chart.CartesianChart;
rg.svg.chart.BarChart.prototype = $extend(rg.svg.chart.CartesianChart.prototype,{
	applyGradient: function(n,i) {
		var ng = dhx.Dom.selectNodeData(n), dp = Reflect.field(n,"__dhx_data__"), scolor = ng.style("fill").get(), color = rg.util.RGColors.parse(scolor,"#ccc"), id = "rg_bar_gradient_" + color.hex("");
		if(this.defs.select("#" + id).empty()) {
			var scolor1 = rg.util.RGColors.applyLightness(thx.color.Hsl.toHsl(color),this.gradientLightness).toRgbString();
			var gradient = this.defs.append("svg:linearGradient").attr("gradientUnits").string("objectBoundingBox").attr("id").string(id).attr("x1")["float"](0).attr("x2")["float"](0).attr("y1")["float"](1).attr("y2")["float"](0).attr("spreadMethod").string("pad");
			gradient.append("svg:stop").attr("offset")["float"](0).attr("stop-color").string(scolor1).attr("stop-opacity")["float"](1);
			gradient.append("svg:stop").attr("offset")["float"](1).attr("stop-color").string(color.toRgbString()).attr("stop-opacity")["float"](1);
		}
		ng.attr("style").string("fill:url(#" + id + ")");
	}
	,onmouseover: function(stats,n,i) {
		var dp = Reflect.field(n,"__dhx_data__"), text = this.labelDataPointOver(dp,stats);
		if(null == text) this.tooltip.hide(); else {
			var sel = dhx.Dom.selectNode(n), x = sel.attr("x").getFloat(), y = sel.attr("y").getFloat(), w = sel.attr("width").getFloat();
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(x + w / 2,y,rg.util.RGColors.extractColor(n));
		}
	}
	,onclick: function(stats,dp,_,i) {
		this.click(dp,stats);
	}
	,datav: function(dps,segments) {
		var axisgs = new haxe.ds.StringMap(), span = (this.width - this.padding * (dps.length - 1)) / dps.length;
		var getGroup = function(name,container) {
			var gr = axisgs.get(name);
			if(null == gr) {
				gr = container.append("svg:g").attr("class").string(name);
				axisgs.set(name,gr);
			}
			return gr;
		};
		var label_group = null != this.labelDataPoint?this.g.append("svg:g").attr("class").string("datapoint-labels"):null;
		var _g1 = 0, _g = dps.length;
		while(_g1 < _g) {
			var i = _g1++;
			var valuedps = dps[i], dist = (span - this.paddingAxis * (valuedps.length - 1)) / valuedps.length;
			var _g3 = 0, _g2 = valuedps.length;
			while(_g3 < _g2) {
				var j = _g3++;
				var axisdps = valuedps[j], axisg = getGroup("group-" + j,this.chart), xtype = this.xVariable.type, xaxis = this.xVariable.axis, xmin = this.xVariable.min(), xmax = this.xVariable.max(), ytype = this.yVariables[j].type, yaxis = this.yVariables[j].axis, ymin = this.yVariables[j].min(), ymax = this.yVariables[j].max(), pad = Math.max(1,(dist - this.paddingDataPoint * (axisdps.length - 1)) / axisdps.length), offset = -span / 2 + j * (dist + this.paddingAxis), stats = this.yVariables[j].stats, over = (function(f,a1) {
					return function(n,i1) {
						return f(a1,n,i1);
					};
				})($bind(this,this.onmouseover),stats), click = (function(f1,a11) {
					return function(dp,_,i1) {
						return f1(a11,dp,_,i1);
					};
				})($bind(this,this.onclick),stats);
				var prev = 0.0;
				var _g5 = 0, _g4 = axisdps.length;
				while(_g5 < _g4) {
					var k = _g5++;
					var dp = axisdps[k], seggroup = getGroup("fill-" + (this.segmentProperty == null?k:Arrays.indexOf(segments,Reflect.field(dp,this.segmentProperty))),axisg), x = this.width * xaxis.scale(xmin,xmax,Reflect.field(dp,xtype)), y = this.startat == null?prev:yaxis.scale(ymin,ymax,Reflect.field(dp,this.startat)) * this.height, h = yaxis.scale(ymin,ymax,Reflect.field(dp,ytype)) * this.height - (this.startat == null?0:y);
					if(Math.isNaN(y)) continue;
					if(h < 0) {
						y += h;
						h = -h;
					} else if(Math.isNaN(h)) h = 0;
					var w = Math.max(this.stacked?dist:pad,1), ax = this.stacked?x + offset:x + offset + k * (pad + this.paddingDataPoint), ay = this.height - h - y, bar = seggroup.append("svg:rect").attr("class").string("bar").attr("x")["float"](ax).attr("width")["float"](w).attr("y")["float"](ay).attr("height")["float"](h).onNode("mouseover",over).onNode("click",(function(f2,dp1) {
						return function(_,i1) {
							return f2(dp1,_,i1);
						};
					})(click,dp));
					bar.node().__dhx_data__ = dp;
					if(null != this.barClass) {
						var cls = this.barClass(dp,stats);
						if(null != cls) bar.classed().add(cls);
					}
					rg.util.RGColors.storeColorForSelection(bar);
					if(this.displayGradient) bar.eachNode($bind(this,this.applyGradient));
					if(this.visuallyStacked()) prev = y + h;
					if(null != this.labelDataPoint) rg.svg.util.PointLabel.label(label_group,this.labelDataPoint(dp,stats),(this.stacked?x + offset:x + offset + k * (pad + this.paddingDataPoint)) + w / 2,this.height - h - y - this.labelDataPointVerticalOffset,this.labelDataPointShadow,this.labelDataPointOutline);
				}
			}
		}
		this.ready.dispatch();
	}
	,datah: function(dps,segments) {
		var axisgs = new haxe.ds.StringMap(), span = (this.height - this.padding * (dps.length - 1)) / dps.length;
		var getGroup = function(name,container) {
			var gr = axisgs.get(name);
			if(null == gr) {
				gr = container.append("svg:g").attr("class").string(name);
				axisgs.set(name,gr);
			}
			return gr;
		};
		var _g1 = 0, _g = dps.length;
		while(_g1 < _g) {
			var i = _g1++;
			var valuedps = dps[i], dist = (span - this.paddingAxis * (valuedps.length - 1)) / valuedps.length;
			var _g3 = 0, _g2 = valuedps.length;
			while(_g3 < _g2) {
				var j = _g3++;
				var axisdps = valuedps[j], axisg = getGroup("group-" + j,this.chart), xtype = this.xVariable.type, xaxis = this.xVariable.axis, xmin = this.xVariable.min(), xmax = this.xVariable.max(), ytype = this.yVariables[j].type, yaxis = this.yVariables[j].axis, ymin = this.yVariables[j].min(), ymax = this.yVariables[j].max(), pad = Math.max(1,(dist - this.paddingDataPoint * (axisdps.length - 1)) / axisdps.length), offset = -span / 2 + j * (dist + this.paddingAxis), stats = this.xVariable.stats, over = (function(f,a1) {
					return function(n,i1) {
						return f(a1,n,i1);
					};
				})($bind(this,this.onmouseover),stats), click = (function(f1,a11) {
					return function(dp,_,i1) {
						return f1(a11,dp,_,i1);
					};
				})($bind(this,this.onclick),stats);
				var prev = 0.0;
				var _g5 = 0, _g4 = axisdps.length;
				while(_g5 < _g4) {
					var k = _g5++;
					var dp = axisdps[k], seggroup = getGroup("fill-" + (this.segmentProperty == null?k:Arrays.indexOf(segments,Reflect.field(dp,this.segmentProperty))),axisg), x = this.startat == null?prev:xaxis.scale(xmin,xmax,Reflect.field(dp,this.startat)) * this.width, y = Math.max(this.height * yaxis.scale(ymin,ymax,Reflect.field(dp,ytype)),1), w = xaxis.scale(xmin,xmax,Reflect.field(dp,xtype)) * this.width - (this.startat == null?0:x);
					if(Math.isNaN(x)) continue;
					if(w < 0) {
						x -= w;
						w = -w;
					} else if(Math.isNaN(w)) w = 0;
					var bar = seggroup.append("svg:rect").attr("class").string("bar").attr("x")["float"](x).attr("y")["float"](this.height - (this.stacked?y - offset:y - offset - k * (pad + this.paddingDataPoint))).attr("height")["float"](this.stacked?dist:pad).attr("width")["float"](w).onNode("mouseover",over).onNode("click",(function(f2,dp1) {
						return function(_,i1) {
							return f2(dp1,_,i1);
						};
					})(click,dp));
					bar.node().__dhx_data__ = dp;
					if(null != this.barClass) {
						var cls = this.barClass(dp,stats);
						if(null != cls) bar.classed().add(cls);
					}
					rg.util.RGColors.storeColorForSelection(bar);
					if(this.displayGradient) bar.eachNode($bind(this,this.applyGradient));
					if(this.visuallyStacked()) prev = x + w;
				}
			}
		}
		this.ready.dispatch();
	}
	,data: function(result) {
		if(this.horizontal) this.datah(result.data,result.segments); else this.datav(result.data,result.segments);
	}
	,visuallyStacked: function() {
		return this.stacked && this.startat == null;
	}
	,setVariables: function(variables,variableIndependents,variableDependents,result) {
		if(this.horizontal) {
			this.xVariable = variableDependents[0];
			this.yVariables = variableIndependents;
		} else {
			this.xVariable = variableIndependents[0];
			this.yVariables = variableDependents;
		}
		if(this.visuallyStacked()) {
			var _g = 0;
			while(_g < variableDependents.length) {
				var v = variableDependents[_g];
				++_g;
				v.meta.max = Math.NEGATIVE_INFINITY;
			}
			var data = result.data;
			var _g1 = 0, _g = data.length;
			while(_g1 < _g) {
				var i = _g1++;
				var _g3 = 0, _g2 = data[i].length;
				while(_g3 < _g2) {
					var j = _g3++;
					var v = variableDependents[j], t = 0.0;
					var _g5 = 0, _g4 = data[i][j].length;
					while(_g5 < _g4) {
						var k = _g5++;
						t += rg.util.DataPoints.valueAlt(data[i][j][k],v.type,0.0);
					}
					if(v.meta.max < t) v.meta.max = t;
				}
			}
		}
	}
	,barClass: null
	,segmentProperty: null
	,startat: null
	,horizontal: null
	,paddingDataPoint: null
	,paddingAxis: null
	,padding: null
	,displayGradient: null
	,gradientLightness: null
	,defs: null
	,chart: null
	,stacked: null
	,__class__: rg.svg.chart.BarChart
});
rg.svg.chart.ColorScaleMode = { __ename__ : ["rg","svg","chart","ColorScaleMode"], __constructs__ : ["FromCssInterpolation","FromCss","Interpolation","Sequence","Fixed","Fun"] }
rg.svg.chart.ColorScaleMode.FromCssInterpolation = function(steps) { var $x = ["FromCssInterpolation",0,steps]; $x.__enum__ = rg.svg.chart.ColorScaleMode; $x.toString = $estr; return $x; }
rg.svg.chart.ColorScaleMode.FromCss = function(steps) { var $x = ["FromCss",1,steps]; $x.__enum__ = rg.svg.chart.ColorScaleMode; $x.toString = $estr; return $x; }
rg.svg.chart.ColorScaleMode.Interpolation = function(colors) { var $x = ["Interpolation",2,colors]; $x.__enum__ = rg.svg.chart.ColorScaleMode; $x.toString = $estr; return $x; }
rg.svg.chart.ColorScaleMode.Sequence = function(colors) { var $x = ["Sequence",3,colors]; $x.__enum__ = rg.svg.chart.ColorScaleMode; $x.toString = $estr; return $x; }
rg.svg.chart.ColorScaleMode.Fixed = function(color) { var $x = ["Fixed",4,color]; $x.__enum__ = rg.svg.chart.ColorScaleMode; $x.toString = $estr; return $x; }
rg.svg.chart.ColorScaleMode.Fun = function(f) { var $x = ["Fun",5,f]; $x.__enum__ = rg.svg.chart.ColorScaleMode; $x.toString = $estr; return $x; }
rg.svg.chart.ColorScaleModes = function() { }
$hxClasses["rg.svg.chart.ColorScaleModes"] = rg.svg.chart.ColorScaleModes;
rg.svg.chart.ColorScaleModes.__name__ = ["rg","svg","chart","ColorScaleModes"];
rg.svg.chart.ColorScaleModes.canParse = function(v) {
	try {
		rg.svg.chart.ColorScaleModes.createFromDynamic(v);
		return true;
	} catch( e ) {
		return false;
	}
}
rg.svg.chart.ColorScaleModes.createFromDynamic = function(v) {
	if(Reflect.isFunction(v)) return rg.svg.chart.ColorScaleMode.Fun(v);
	if(!js.Boot.__instanceof(v,String)) return (function($this) {
		var $r;
		throw new thx.error.Error("invalid color mode '{0}'",[v],null,{ fileName : "ColorScaleModes.hx", lineNumber : 28, className : "rg.svg.chart.ColorScaleModes", methodName : "createFromDynamic"});
		return $r;
	}(this));
	var s = (js.Boot.__cast(v , String)).split(":");
	var _g = s[0].toLowerCase();
	switch(_g) {
	case "css":
		return rg.svg.chart.ColorScaleMode.FromCss(null == s[1]?null:Std.parseInt(s[1]));
	case "i":case "interpolated":
		return rg.svg.chart.ColorScaleMode.Interpolation(s[1].split(",").map(function(d) {
			return thx.color.Colors.parse(d);
		}));
	case "s":case "sequence":
		return rg.svg.chart.ColorScaleMode.Sequence(s[1].split(",").map(function(d) {
			return thx.color.Colors.parse(d);
		}));
	case "f":case "fixed":
		return rg.svg.chart.ColorScaleMode.Fixed(thx.color.Colors.parse(s[1]));
	default:
		if(s[0].indexOf(",") >= 0) return rg.svg.chart.ColorScaleMode.Sequence(s[0].split(",").map(function(d) {
			return thx.color.Colors.parse(d);
		})); else return rg.svg.chart.ColorScaleMode.Fixed(thx.color.Colors.parse(s[0]));
	}
}
rg.svg.chart.Coords = function() { }
$hxClasses["rg.svg.chart.Coords"] = rg.svg.chart.Coords;
rg.svg.chart.Coords.__name__ = ["rg","svg","chart","Coords"];
rg.svg.chart.Coords.fromTransform = function(s) {
	if(!rg.svg.chart.Coords.retransform.match(s)) return [0.0,0]; else {
		var y = rg.svg.chart.Coords.retransform.matched(2);
		return [Std.parseFloat(rg.svg.chart.Coords.retransform.matched(1)),null == y?0:Std.parseFloat(y)];
	}
}
rg.svg.chart.FunnelChart = function(panel) {
	rg.svg.chart.Chart.call(this,panel);
	this.padding = 2.5;
	this.flatness = 1.0;
	this.arrowSize = 30;
	this.gradientLightness = 1;
	this.displayGradient = true;
	this.labelArrow = $bind(this,this.defaultLabelArrow);
	this.labelDataPoint = $bind(this,this.defaultLabelDataPoint);
	this.labelDataPointOver = $bind(this,this.defaultLabelDataPointOver);
};
$hxClasses["rg.svg.chart.FunnelChart"] = rg.svg.chart.FunnelChart;
rg.svg.chart.FunnelChart.__name__ = ["rg","svg","chart","FunnelChart"];
rg.svg.chart.FunnelChart.__super__ = rg.svg.chart.Chart;
rg.svg.chart.FunnelChart.prototype = $extend(rg.svg.chart.Chart.prototype,{
	externalGradient: function(n,i) {
		var g = dhx.Dom.selectNode(n), d = g.select("path"), color = thx.color.Hsl.toHsl(rg.util.RGColors.parse(d.style("fill").get(),"#cccccc")), vn = this.next(i), vc = this.dpvalue(this.dps[i]), ratio = Math.round(vn / vc * 100) / 100, id = "rg_funnel_ext_gradient_" + color.hex("#") + "-" + ratio;
		var stops = this.defs.append("svg:radialGradient").attr("gradientUnits").string("objectBoundingBox").attr("id").string(id).attr("cx").string("50%").attr("cy").string("0%").attr("r").string("110%");
		var top = color.hex("#");
		stops.append("svg:stop").attr("offset").string("10%").attr("stop-color").string(top);
		var ratio1 = 1 - (vc < vn?vc / vn:vn / vc), middlecolor = rg.util.RGColors.applyLightness(color,ratio1,this.gradientLightness * (vc >= vn?1:-1)).hex("#");
		stops.append("svg:stop").attr("offset").string("50%").attr("stop-color").string(middlecolor);
		stops.append("svg:stop").attr("offset").string("90%").attr("stop-color").string(top);
		d.attr("style").string("fill:url(#" + id + ")");
	}
	,internalGradient: function(d) {
		var color = rg.util.RGColors.parse(d.style("fill").get(),"#cccccc"), stops = this.defs.append("svg:radialGradient").attr("gradientUnits").string("objectBoundingBox").attr("id").string("rg_funnel_int_gradient_0").attr("cx").string("50%").attr("fx").string("75%").attr("cy").string("20%").attr("r").string(Math.round(75) + "%");
		stops.append("svg:stop").attr("offset").string("0%").attr("stop-color").string(rg.util.RGColors.applyLightness(thx.color.Hsl.toHsl(color),this.gradientLightness).toRgbString());
		stops.append("svg:stop").attr("offset").string("100%").attr("stop-color").string(rg.util.RGColors.applyLightness(thx.color.Hsl.toHsl(color),-this.gradientLightness).toRgbString());
		d.attr("style").string("fill:url(#rg_funnel_int_gradient_0)");
	}
	,init: function() {
		rg.svg.chart.Chart.prototype.init.call(this);
		if(null != this.tooltip) this.tooltip.anchor("bottomright");
		this.defs = this.g.classed().add("funnel-chart").append("svg:defs");
	}
	,mouseOver: function(dp,i,stats) {
		if(null == this.labelDataPointOver) return;
		var text = this.labelDataPointOver(dp,stats);
		if(null == text) this.tooltip.hide(); else {
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(this.width / 2,this.topheight + this.h * .6 + (this.h + this.padding) * i,rg.util.RGColors.extractColor(this.currentNode));
		}
	}
	,redraw: function() {
		var _g = this;
		if(null == this.dps || 0 == this.dps.length) return;
		this.g.selectAll("g").remove();
		this.g.selectAll("radialGradient").remove();
		this.stats = this.variableDependent.stats;
		var max = this.scale(this.stats.max), wscale = function(v) {
			return _g.scale(v) / max * (_g.width - 2) / 2;
		}, fx1 = function(v) {
			return _g.width / 2 - wscale(v);
		}, fx2 = function(v) {
			return _g.width - fx1(v);
		}, diagonal1 = new thx.svg.Diagonal().sourcef(function(o,i) {
			return [fx1(_g.dpvalue(o)),0.0];
		}).targetf(function(o,i) {
			return [fx1(_g.next(i)),_g.h];
		}), diagonal2 = new thx.svg.Diagonal().sourcef(function(o,i) {
			return [fx2(_g.next(i)),_g.h];
		}).targetf(function(o,i) {
			return [fx2(_g.dpvalue(o)),0.0];
		}), conj = function(v,r,dir) {
			var x2 = r?fx1(v) - fx2(v):fx2(v) - fx1(v), a = 5, d = r?dir == 0?1:0:dir;
			return " a " + a + " " + _g.flatness + " 0 0 " + d + " " + x2 + " 0";
		}, conj1 = function(d,i) {
			return conj(_g.dpvalue(d),true,0);
		}, conj2 = function(d,i) {
			return conj(_g.next(i),false,0);
		}, conjr = function(d,i) {
			var v = _g.dpvalue(d);
			return " M " + fx1(v) + " 0 " + conj(v,false,0) + conj(v,true,1);
		};
		var top = this.g.append("svg:g");
		var path = top.append("svg:path").attr("class").string("funnel-inside fill-0").attr("d").string(conjr(this.dps[0]));
		if(null != this.click) top.onNode("click",function(_,_1) {
			_g.click(_g.dps[0],_g.stats);
		});
		if(this.displayGradient) this.internalGradient(path);
		path.onNode("mouseover",function(d,_) {
			_g.currentNode = d;
			_g.mouseOver(_g.dps[0],0,_g.stats);
		});
		rg.util.RGColors.storeColorForSelection(path);
		this.topheight = Math.ceil(path.node().getBBox().height / 2) + 1;
		var index = this.dps.length - 1, bottom = this.g.append("svg:path").attr("class").string("funnel-inside fill-" + index).attr("d").string(conjr(this.dps[index])), bottomheight = Math.ceil(bottom.node().getBBox().height / 2) + 1;
		bottom.remove();
		this.h = (this.height - this.topheight - bottomheight - (this.dps.length - 1) * this.padding) / this.dps.length;
		top.attr("transform").string("translate(0," + (1 + this.topheight) + ")");
		var section = this.g.selectAll("g.section").data(this.dps);
		var enter = section.enter().append("svg:g").attr("class").string("section").attr("transform").stringf(function(d,i) {
			return "translate(0," + (_g.topheight + i * (_g.padding + _g.h)) + ")";
		});
		var funnel = enter.append("svg:path").attr("class").stringf(function(d,i) {
			return "funnel-outside fill-" + i;
		}).attr("d").stringf(function(d,i) {
			var t = diagonal2.diagonal(d,i).split("C");
			t.shift();
			var d2 = "C" + t.join("C");
			return diagonal1.diagonal(d,i) + conj2(d,i) + d2 + conj1(d,i);
		});
		if(null != this.click) funnel.on("click",function(d,_) {
			_g.click(d,_g.stats);
		});
		rg.util.RGColors.storeColorForSelection(funnel);
		funnel.onNode("mouseover",function(d,i) {
			_g.currentNode = d;
			_g.mouseOver(Reflect.field(d,"__dhx_data__"),i,_g.stats);
		});
		if(this.displayGradient) enter.eachNode($bind(this,this.externalGradient));
		var ga = this.g.selectAll("g.arrow").data(this.dps).enter().append("svg:g").attr("class").string("arrow").attr("transform").stringf(function(d,i) {
			return "translate(" + _g.width / 2 + "," + (_g.topheight + _g.h * i + _g.arrowSize / 2) + ")";
		});
		ga.each(function(d,i) {
			if(null == _g.labelArrow) return;
			var text = _g.labelArrow(d,_g.stats);
			if(null == text) return;
			var node = dhx.Dom.selectNode(dhx.Group.current);
			node.append("svg:path").attr("transform").string("scale(1.1,0.85)translate(1,1)").attr("class").string("shadow").style("fill").string("#000").attr("opacity")["float"](.25).attr("d").string(thx.svg.Symbol.arrowDownWide(_g.arrowSize * _g.arrowSize));
			node.append("svg:path").attr("transform").string("scale(1.1,0.8)").attr("d").string(thx.svg.Symbol.arrowDownWide(_g.arrowSize * _g.arrowSize));
			var label = new rg.svg.widget.Label(node,true,false,true);
			label.set_anchor(rg.svg.widget.GridAnchor.Bottom);
			label.set_text(text);
		});
		ga.each(function(d,i) {
			if(null == _g.labelDataPoint) return;
			var text = _g.labelDataPoint(d,_g.stats);
			if(null == text) return;
			var balloon = new rg.svg.widget.Balloon(_g.g);
			balloon.set_boundingBox({ x : _g.width / 2 + _g.arrowSize / 3 * 2, y : 0, width : _g.width, height : _g.height});
			balloon.set_preferredSide(3);
			balloon.set_text(text.split("\n"));
			balloon.moveTo(_g.width / 2,_g.topheight + _g.h * .6 + (_g.h + _g.padding) * i,false);
		});
		this.ready.dispatch();
	}
	,next: function(i) {
		return this.dpvalue(this.dps[i + 1 < this.dps.length?i + 1:i]);
	}
	,scale: function(value) {
		return this.variableDependent.axis.scale(this.variableDependent.min(),this.variableDependent.max(),value);
	}
	,currentNode: null
	,h: null
	,topheight: null
	,stats: null
	,dpvalue: function(dp) {
		return Reflect.field(dp,this.variableDependent.type);
	}
	,resize: function() {
		rg.svg.chart.Chart.prototype.resize.call(this);
		this.redraw();
	}
	,data: function(dps) {
		this.dps = dps;
		this.redraw();
	}
	,setVariables: function(variableIndependents,variableDependents) {
		this.variableIndependent = variableIndependents[0];
		this.variableDependent = variableDependents[0];
	}
	,defaultLabelDataPointOver: function(dp,stats) {
		return Ints.format(Reflect.field(dp,this.variableDependent.type));
	}
	,defaultLabelDataPoint: function(dp,stats) {
		return rg.util.RGStrings.humanize(Reflect.field(dp,this.variableIndependent.type)).split(" ").join("\n");
	}
	,defaultLabelArrow: function(dp,stats) {
		var value = Reflect.field(dp,this.variableDependent.type) / stats.max;
		return thx.culture.FormatNumber.percent(100 * value,0);
	}
	,dps: null
	,defs: null
	,variableDependent: null
	,variableIndependent: null
	,labelArrow: null
	,arrowSize: null
	,gradientLightness: null
	,displayGradient: null
	,flatness: null
	,padding: null
	,__class__: rg.svg.chart.FunnelChart
});
rg.svg.chart.Geo = function(panel) {
	this.labelShadow = false;
	this.labelOutline = false;
	rg.svg.chart.Chart.call(this,panel);
	this.mapcontainer = this.g.append("svg:g").attr("class").string("mapcontainer");
	this.queue = [];
	this.set_colorMode(rg.svg.chart.ColorScaleMode.FromCss());
	this.resize();
};
$hxClasses["rg.svg.chart.Geo"] = rg.svg.chart.Geo;
rg.svg.chart.Geo.__name__ = ["rg","svg","chart","Geo"];
rg.svg.chart.Geo.__super__ = rg.svg.chart.Chart;
rg.svg.chart.Geo.prototype = $extend(rg.svg.chart.Chart.prototype,{
	addMap: function(map,field) {
		if(null != field) map.onReady.add((function(f,a1,a2) {
			return function() {
				return f(a1,a2);
			};
		})($bind(this,this.drawmap),map,field));
	}
	,init: function() {
		rg.svg.chart.Chart.prototype.init.call(this);
		rg.html.widget.Tooltip.get_instance().hide();
		if(null == this.tooltip) this.tooltip = rg.html.widget.Tooltip.get_instance();
		this.g.classed().add("geo");
	}
	,set_colorMode: function(v) {
		var _g1 = this;
		var _g = this.colorMode = v;
		var $e = (_g);
		switch( $e[1] ) {
		case 0:
			var g = $e[2];
			if(null == g) g = 1;
			var colors = rg.svg.util.RGCss.colorsInCss();
			if(colors.length > g) colors = colors.slice(0,g);
			if(colors.length == 1) colors.push(thx.color.Hsl.lighter(thx.color.Hsl.toHsl(thx.color.Colors.parse(colors[0])),0.9).hex("#"));
			colors.reverse();
			this.set_colorMode(rg.svg.chart.ColorScaleMode.Interpolation(colors.map(function(s) {
				return thx.color.Colors.parse(s);
			})));
			break;
		case 1:
			var g1 = $e[2];
			if(null == g1) g1 = rg.svg.util.RGCss.numberOfColorsInCss();
			this.stylefeature = function(svg,dp) {
				var t = _g1.variableDependent.axis.scale(_g1.variableDependent.min(),_g1.variableDependent.max(),Reflect.field(dp,_g1.variableDependent.type)), index = Math.floor(g1 * t);
				svg.attr("class").string("fill-" + index);
				rg.util.RGColors.storeColorForSelection(svg);
			};
			break;
		case 3:
			var c = $e[2];
			var colors1 = Iterators.map(HxOverrides.iter(c),function(d,_) {
				return d.hex("#");
			});
			this.stylefeature = function(svg,dp) {
				var t = _g1.variableDependent.axis.scale(_g1.variableDependent.min(),_g1.variableDependent.max(),Reflect.field(dp,_g1.variableDependent.type)), index = Math.floor(colors1.length * t);
				svg.style("fill").string(colors1[index]);
				rg.util.RGColors.storeColorForSelection(svg);
			};
			break;
		case 2:
			var colors = $e[2];
			var interpolator = thx.color.Rgb.interpolateStepsf(colors);
			this.stylefeature = function(svg,dp) {
				var t = _g1.variableDependent.axis.scale(_g1.variableDependent.min(),_g1.variableDependent.max(),Reflect.field(dp,_g1.variableDependent.type));
				svg.style("fill").string(interpolator(t).hex("#"));
				rg.util.RGColors.storeColorForSelection(svg);
			};
			break;
		case 4:
			var c = $e[2];
			var color = c.hex("#");
			this.stylefeature = function(svg,dp) {
				svg.style("fill").string(color);
				rg.util.RGColors.storeColorForSelection(svg);
			};
			break;
		case 5:
			var f = $e[2];
			this.stylefeature = function(svg,dp) {
				svg.style("fill").string(f(dp,_g1.variableDependent.stats));
				rg.util.RGColors.storeColorForSelection(svg);
			};
			break;
		}
		return v;
	}
	,redraw: function() {
		while(this.queue.length > 0) (this.queue.shift())();
	}
	,stylefeature: function(svg,dp) {
	}
	,handlerClick: function(dp,f) {
		f(dp,this.variableDependent.stats);
	}
	,handlerDataPointOver: function(n,dp,f) {
		var text = f(dp,this.variableDependent.stats);
		if(null == text) this.tooltip.hide(); else {
			this.tooltip.html(text.split("\n").join("<br>"));
			var centroid = Reflect.field(dp,"$centroid");
			this.moveTooltip(centroid[0] + this.width / 2,centroid[1] + this.height / 2,rg.util.RGColors.extractColor(n));
		}
	}
	,drawmap: function(map,field) {
		if(null == this.dps || 0 == this.dps.length) {
			this.queue.push((function(f,a1,a2) {
				return function() {
					return f(a1,a2);
				};
			})($bind(this,this.drawmap),map,field));
			return;
		}
		this.set_colorMode(map.colorMode);
		var text = null;
		var _g = 0, _g1 = this.dps;
		while(_g < _g1.length) {
			var dp = _g1[_g];
			++_g;
			var id = Reflect.field(dp,field), feature = map.map.get(id);
			if(null == feature) continue;
			this.stylefeature(feature.svg,Objects.copyTo(dp,feature.dp));
			if(null != map.radius && feature.svg.node().nodeName == "circle") feature.svg.attr("r")["float"](map.radius(feature.dp,this.variableDependent.stats));
			if(null != map.labelDataPoint && null != (text = map.labelDataPoint(feature.dp,this.variableDependent.stats))) {
				var c = Reflect.field(feature.dp,"$centroid");
				var label = new rg.svg.widget.Label(this.mapcontainer,true,this.labelShadow,this.labelOutline);
				label.set_text(text);
				label.place(c[0],c[1],0);
			}
		}
		if(this.queue.length == 0) this.ready.dispatch();
	}
	,resize: function() {
		rg.svg.chart.Chart.prototype.resize.call(this);
		if(null != this.mapcontainer) this.mapcontainer.attr("transform").string("translate(" + this.width / 2 + "," + this.height / 2 + ")");
	}
	,data: function(dps) {
		this.dps = dps;
		this.redraw();
	}
	,setVariables: function(variableIndependents,variableDependents,data) {
		this.variableDependent = variableDependents[0];
	}
	,queue: null
	,dps: null
	,variableDependent: null
	,labelShadow: null
	,labelOutline: null
	,colorMode: null
	,mapcontainer: null
	,__class__: rg.svg.chart.Geo
});
rg.svg.chart.GradientEffect = { __ename__ : ["rg","svg","chart","GradientEffect"], __constructs__ : ["NoEffect","Gradient"] }
rg.svg.chart.GradientEffect.NoEffect = ["NoEffect",0];
rg.svg.chart.GradientEffect.NoEffect.toString = $estr;
rg.svg.chart.GradientEffect.NoEffect.__enum__ = rg.svg.chart.GradientEffect;
rg.svg.chart.GradientEffect.Gradient = function(lightness) { var $x = ["Gradient",1,lightness]; $x.__enum__ = rg.svg.chart.GradientEffect; $x.toString = $estr; return $x; }
rg.svg.chart.GradientEffects = function() { }
$hxClasses["rg.svg.chart.GradientEffects"] = rg.svg.chart.GradientEffects;
rg.svg.chart.GradientEffects.__name__ = ["rg","svg","chart","GradientEffects"];
rg.svg.chart.GradientEffects.canParse = function(s) {
	var parts = s.toLowerCase().split(":");
	return (function($this) {
		var $r;
		var _g = parts[0];
		$r = (function($this) {
			var $r;
			switch(_g) {
			case "gradient":case "noeffect":case "none":case "flat":
				$r = true;
				break;
			default:
				$r = false;
			}
			return $r;
		}($this));
		return $r;
	}(this));
}
rg.svg.chart.GradientEffects.parse = function(s) {
	var parts = s.toLowerCase().split(":");
	var _g = parts.shift();
	switch(_g) {
	case "gradient":
		var lightness = 0.75, parameters = parts.pop();
		if(null != parameters) lightness = Std.parseFloat(parameters.split(",").shift());
		return rg.svg.chart.GradientEffect.Gradient(lightness);
	default:
		return rg.svg.chart.GradientEffect.NoEffect;
	}
}
rg.svg.chart.HeatGrid = function(panel) {
	rg.svg.chart.CartesianChart.call(this,panel);
	this.useContour = false;
	this.set_colorMode(rg.svg.chart.ColorScaleMode.FromCss());
};
$hxClasses["rg.svg.chart.HeatGrid"] = rg.svg.chart.HeatGrid;
rg.svg.chart.HeatGrid.__name__ = ["rg","svg","chart","HeatGrid"];
rg.svg.chart.HeatGrid.__super__ = rg.svg.chart.CartesianChart;
rg.svg.chart.HeatGrid.prototype = $extend(rg.svg.chart.CartesianChart.prototype,{
	set_colorMode: function(v) {
		var _g1 = this;
		var _g = this.colorMode = v;
		var $e = (_g);
		switch( $e[1] ) {
		case 0:
			var g = $e[2];
			if(null == g) g = 1;
			var colors = rg.svg.util.RGCss.colorsInCss();
			if(colors.length > g) colors = colors.slice(0,g);
			if(colors.length == 1) colors.push(thx.color.Hsl.lighter(thx.color.Hsl.toHsl(thx.color.Colors.parse(colors[0])),0.9).hex("#"));
			colors.reverse();
			this.set_colorMode(rg.svg.chart.ColorScaleMode.Interpolation(colors.map(function(s) {
				return thx.color.Colors.parse(s);
			})));
			break;
		case 1:
			var g1 = $e[2];
			if(null == g1) g1 = rg.svg.util.RGCss.numberOfColorsInCss();
			this.stylefeature = function(svg,dp) {
				var t = _g1.variableDependent.axis.scale(_g1.variableDependent.min(),_g1.variableDependent.max(),Reflect.field(dp,_g1.variableDependent.type)), index = Math.floor(g1 * t);
				svg.attr("class").string("fill-" + index);
			};
			break;
		case 3:
			var c = $e[2];
			var colors1 = Iterators.map(HxOverrides.iter(c),function(d,_) {
				return d.hex("#");
			});
			this.stylefeature = function(svg,dp) {
				var t = _g1.variableDependent.axis.scale(_g1.variableDependent.min(),_g1.variableDependent.max(),Reflect.field(dp,_g1.variableDependent.type)), index = Math.floor(colors1.length * t);
				svg.style("fill").string(colors1[index]);
			};
			break;
		case 2:
			var colors = $e[2];
			var interpolator = thx.color.Rgb.interpolateStepsf(colors);
			this.stylefeature = function(svg,dp) {
				var t = _g1.variableDependent.axis.scale(_g1.variableDependent.min(),_g1.variableDependent.max(),Reflect.field(dp,_g1.variableDependent.type));
				svg.style("fill").string(interpolator(t).hex("#"));
			};
			break;
		case 4:
			var c = $e[2];
			var color = c.hex("#");
			this.stylefeature = function(svg,dp) {
				svg.style("fill").string(color);
			};
			break;
		case 5:
			var f = $e[2];
			this.stylefeature = function(svg,dp) {
				svg.style("fill").string(f(dp,_g1.variableDependent.stats));
			};
			break;
		}
		return v;
	}
	,stylefeature: function(svg,dp) {
	}
	,range: function(variable) {
		var v = js.Boot.__instanceof(variable,rg.data.VariableIndependent)?variable:null;
		if(null != v) return v.axis.range(v.min(),v.max());
		var tickmarks = variable.axis.ticks(variable.min(),variable.max());
		return tickmarks.map(function(d) {
			return d.get_value();
		});
	}
	,onclick: function(dp,i) {
		if(null == this.click) return;
		this.click(dp,this.stats);
	}
	,onmouseover: function(dp,i) {
		if(null == this.labelDataPointOver) return;
		var text = this.labelDataPointOver(dp,this.stats);
		if(null == text) this.tooltip.hide(); else {
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(this.x(dp,i) + this.w / 2,this.y(dp,i) + this.h / 2,rg.util.RGColors.extractColor(this.currentNode));
		}
	}
	,drawSquares: function() {
		var _g = this;
		var choice = this.g.selectAll("rect").data(this.dps);
		var rect = choice.enter().append("svg:rect").attr("x").floatf($bind(this,this.x)).attr("y").floatf($bind(this,this.y)).attr("width")["float"](this.w).attr("height")["float"](this.h).each(function(dp,_) {
			_g.stylefeature(dhx.Dom.selectNode(dhx.Group.current),dp);
		}).on("click",$bind(this,this.onclick)).onNode("mouseover",function(n,i) {
			_g.currentNode = n;
			_g.onmouseover(Reflect.field(n,"__dhx_data__"),i);
		});
		if(null != this.labelDataPoint) {
			var label_group = this.g.append("svg:g").attr("class").string("datapoint-labels");
			this.g.selectAll("rect").data(this.dps).eachNode(function(n,i) {
				var dp = Reflect.field(n,"__dhx_data__");
				rg.svg.util.PointLabel.label(label_group,_g.labelDataPoint(dp,_g.stats),_g.x(dp,i) + _g.w / 2,_g.y(dp,i) - _g.labelDataPointVerticalOffset + _g.h / 2,_g.labelDataPointShadow,_g.labelDataPointOutline);
			});
		}
		rg.util.RGColors.storeColorForSelection(rect);
	}
	,currentNode: null
	,drawContour: function() {
	}
	,redraw: function() {
		if(null == this.dps || 0 == this.dps.length) return;
		this.stats = this.variableDependent.stats;
		this.xrange = this.range(this.xVariable);
		this.yrange = this.range(this.yVariables[0]);
		this.cols = this.xrange.length;
		this.rows = this.yrange.length;
		this.w = this.width / this.cols;
		this.h = this.height / this.rows;
		if(this.useContour) this.drawContour(); else this.drawSquares();
		this.ready.dispatch();
	}
	,y: function(dp,i) {
		return this.height - (1 + Arrays.indexOf(this.yrange,Reflect.field(dp,this.yVariables[0].type))) * this.h;
	}
	,x: function(dp,i) {
		return Arrays.indexOf(this.xrange,Reflect.field(dp,this.xVariable.type)) * this.w;
	}
	,stats: null
	,h: null
	,w: null
	,rows: null
	,cols: null
	,yrange: null
	,xrange: null
	,data: function(dps) {
		this.dps = dps;
		this.redraw();
	}
	,resize: function() {
		rg.svg.chart.CartesianChart.prototype.resize.call(this);
		this.redraw();
	}
	,init: function() {
		rg.svg.chart.CartesianChart.prototype.init.call(this);
		this.g.classed().add("heat-grid");
	}
	,setVariables: function(variables,variableIndependents,variableDependents,data) {
		this.xVariable = variableIndependents[0];
		this.yVariables = [variableIndependents[1]];
		this.variableDependent = variableDependents[0];
	}
	,variableDependent: null
	,dps: null
	,colorMode: null
	,useContour: null
	,__class__: rg.svg.chart.HeatGrid
});
rg.svg.chart.LineChart = function(panel) {
	rg.svg.chart.CartesianChart.call(this,panel);
	this.addClass("line-chart");
	this.chart = this.g.append("svg:g");
	this.sensibleRadius = 100;
};
$hxClasses["rg.svg.chart.LineChart"] = rg.svg.chart.LineChart;
rg.svg.chart.LineChart.__name__ = ["rg","svg","chart","LineChart"];
rg.svg.chart.LineChart.__super__ = rg.svg.chart.CartesianChart;
rg.svg.chart.LineChart.prototype = $extend(rg.svg.chart.CartesianChart.prototype,{
	onclick: function(n) {
		var dp = Reflect.field(n,"__dhx_data__"), stats = this.getStats(dp);
		this.click(dp,stats);
	}
	,onmouseover: function(n) {
		var dp = Reflect.field(n,"__dhx_data__"), stats = this.getStats(dp), text = this.labelDataPointOver(dp,stats);
		if(null == text) this.tooltip.hide(); else {
			var sel = dhx.Dom.selectNode(n.parentNode), coords = rg.svg.chart.Coords.fromTransform(sel.attr("transform").get());
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(coords[0],coords[1],rg.util.RGColors.extractColor(n));
		}
	}
	,getStats: function(dp) {
		var _g = 0, _g1 = this.stats;
		while(_g < _g1.length) {
			var s = _g1[_g];
			++_g;
			if(Reflect.field(dp,s.type) != null) return s;
		}
		return null;
	}
	,getTranslatePointf: function(pos) {
		var x = $bind(this,this.x), y = this.getY1(pos);
		return function(dp,i) {
			return "translate(" + x(dp) + "," + y(dp,i) + ")";
		};
	}
	,data: function(dps) {
		var _g2 = this;
		this.linePathShape = [];
		var _g1 = 0, _g = this.yVariables.length;
		while(_g1 < _g) {
			var i = _g1++;
			var line = [new thx.svg.Line($bind(this,this.x),this.getY1(i))];
			if(null != this.lineInterpolator) line[0].interpolator(this.lineInterpolator);
			this.linePathShape[i] = (function(line) {
				return function(dp,i1) {
					_g2.segment = i1;
					return line[0].shape(dp,i1);
				};
			})(line);
		}
		var axisgroup = this.chart.selectAll("g.group").data(dps);
		var axisenter = axisgroup.enter().append("svg:g").attr("class").stringf(function(_,i) {
			return "group group-" + i;
		});
		axisgroup.exit().remove();
		this.stats = [];
		var _g1 = 0, _g = dps.length;
		while(_g1 < _g) {
			var i2 = [_g1++];
			this.segments = dps[i2[0]];
			var gi = this.chart.select("g.group-" + i2[0]);
			this.stats[i2[0]] = new rg.axis.Stats(this.yVariables[i2[0]].type);
			this.stats[i2[0]].addMany(rg.util.DataPoints.values(Arrays.flatten(this.segments),this.yVariables[i2[0]].type));
			if(null != this.y0property) {
				var area = new thx.svg.Area($bind(this,this.x),this.getY0(i2[0]),this.getY1(i2[0]));
				if(null != this.lineInterpolator) area.interpolator(this.lineInterpolator);
				gi.selectAll("path.area").data(this.segments).enter().append("svg:path").attr("class").stringf(this.classff(i2[0],"area area-" + i2[0])).attr("d").stringf($bind(area,area.shape));
			}
			var segmentgroup = gi.selectAll("path.main").data(this.segments);
			var _g21 = this;
			var $e = (_g21.lineEffect);
			switch( $e[1] ) {
			case 1:
				var levels = $e[3], lightness = $e[2];
				var levels1 = [levels];
				var lightness1 = [lightness];
				var fs = [[]];
				segmentgroup.enter().append("svg:path").attr("class").stringf(this.classsf(i2[0],"line")).eachNode((function(lightness1,fs) {
					return function(n,i) {
						var start = thx.color.Hsl.toHsl(rg.util.RGColors.parse(dhx.Dom.selectNode(n).style("stroke").get(),"#000000")), end = rg.util.RGColors.applyLightness(start,lightness1[0]);
						fs[0][i] = thx.color.Hsl.interpolatef(end,start);
					};
				})(lightness1,fs)).remove();
				var _g3 = 0;
				while(_g3 < levels1[0]) {
					var j = [_g3++];
					segmentgroup.enter().append("svg:path").attr("class").string("line grad-" + (levels1[0] - j[0] - 1)).style("stroke").stringf((function(levels1,j,fs) {
						return function(_,i) {
							return fs[0][i](j[0] / levels1[0]).hex("#");
						};
					})(levels1,j,fs)).attr("d").stringf(this.linePathShape[i2[0]]);
				}
				break;
			case 2:
				var levels = $e[4], oy = $e[3], ox = $e[2];
				var _g3 = 0;
				while(_g3 < levels) {
					var j = _g3++;
					segmentgroup.enter().append("svg:path").attr("transform").string("translate(" + (1 + j) * ox + "," + (1 + j) * oy + ")").attr("class").stringf(this.classsf(i2[0],"line shadow shadow-" + j)).attr("d").stringf(this.linePathShape[i2[0]]);
				}
				break;
			default:
			}
			var path = segmentgroup.enter().append("svg:path").attr("class").stringf(this.classsf(i2[0],"line")).attr("d").stringf(this.linePathShape[i2[0]]);
			var _g3 = this;
			switch( (_g3.lineEffect)[1] ) {
			case 1:
				path.classed().add("gradient");
				break;
			case 2:
				path.classed().add("dropshadow");
				break;
			case 0:
				path.classed().add("noeffect");
				break;
			}
			segmentgroup.update().attr("d").stringf(this.linePathShape[i2[0]]);
			segmentgroup.exit().remove();
			var gsymbols = gi.selectAll("g.symbols").data(this.segments), vars = this.yVariables;
			var enter = gsymbols.enter().append("svg:g").attr("class").stringf(this.classsf(i2[0],"symbols"));
			var gsymbol = enter.selectAll("g.symbol").dataf((function() {
				return function(d,i) {
					return d;
				};
			})()).enter().append("svg:g").attr("transform").stringf(this.getTranslatePointf(i2[0]));
			var circle = gsymbol.append("svg:circle").attr("r")["float"](6).attr("opacity")["float"](0.0).style("fill").string("#000000");
			if(null != this.labelDataPointOver) circle.classed().add("rgdata");
			rg.util.RGColors.storeColorForSelection(circle,"stroke");
			rg.svg.util.SVGSymbolBuilder.generate(gsymbol,this.stats[i2[0]],this.symbol,this.symbolStyle);
			if(null != this.labelDataPoint) {
				var label_group = [this.chart.append("svg:g").attr("class").string("datapoint-labels")];
				gsymbol.eachNode((function(label_group,i2) {
					return function(n,j) {
						var dp = Reflect.field(n,"__dhx_data__");
						rg.svg.util.PointLabel.label(label_group[0],_g2.labelDataPoint(dp,_g2.stats[i2[0]]),_g2.x(dp),(_g2.getY1(i2[0]))(dp,j) - _g2.labelDataPointVerticalOffset,_g2.labelDataPointShadow,_g2.labelDataPointOutline);
					};
				})(label_group,i2));
			}
			gsymbols.update().selectAll("g.symbol").dataf((function() {
				return function(d,i) {
					return d;
				};
			})()).update().attr("transform").stringf(this.getTranslatePointf(i2[0]));
			gsymbols.exit().remove();
		}
		rg.svg.widget.Sensible.sensibleZone(this.g,this.panel,null == this.click?null:$bind(this,this.onclick),null == this.labelDataPointOver?null:$bind(this,this.onmouseover),this.sensibleRadius);
		this.ready.dispatch();
	}
	,classff: function(pos,cls) {
		return function(_,i) {
			return cls + " fill-" + (pos + i);
		};
	}
	,classsf: function(pos,cls) {
		return function(_,i) {
			return cls + " stroke-" + (pos + i);
		};
	}
	,segments: null
	,getY0: function(pos) {
		var _g = this;
		var v = this.yVariables[pos], scale = (function(f,a1,a2) {
			return function(v1) {
				return f(a1,a2,v1);
			};
		})(($_=v.axis,$bind($_,$_.scale)),v.min(),v.max());
		return function(d,i) {
			return _g.height - scale(rg.util.DataPoints.valueAlt(d,_g.y0property,v.min())) * _g.height;
		};
	}
	,getY1: function(pos) {
		var _g = this;
		var v = this.yVariables[pos], scale = (function(f,a1,a2) {
			return function(v1) {
				return f(a1,a2,v1);
			};
		})(($_=v.axis,$bind($_,$_.scale)),v.min(),v.max());
		if(null != this.y0property) {
			var min = scale(v.min()) * this.height;
			return function(d,i) {
				return (_g.getY0(pos))(d,i) - scale(Reflect.field(d,v.type)) * _g.height + min;
			};
		} else return function(d,i) {
			var value = Reflect.field(d,v.type), scaled = scale(value), scaledh = scaled * _g.height;
			return _g.height - scaledh;
		};
	}
	,x: function(d,i) {
		var value = Reflect.field(d,this.xVariable.type), scaled = this.xVariable.axis.scale(this.xVariable.min(),this.xVariable.max(),value), scaledw = scaled * this.width;
		return scaledw;
	}
	,setVariables: function(variables,variableIndependents,variableDependents,data) {
		rg.svg.chart.CartesianChart.prototype.setVariables.call(this,variables,variableIndependents,variableDependents,data);
		if(this.y0property != null && this.y0property != "") {
			var t, dp;
			var _g = 0;
			while(_g < variableDependents.length) {
				var v = variableDependents[_g];
				++_g;
				v.meta.max = Math.NEGATIVE_INFINITY;
			}
			var _g1 = 0, _g = data.length;
			while(_g1 < _g) {
				var i = _g1++;
				var v = variableDependents[i];
				var _g3 = 0, _g2 = data[i].length;
				while(_g3 < _g2) {
					var j = _g3++;
					var _g5 = 0, _g4 = data[i][j].length;
					while(_g5 < _g4) {
						var k = _g5++;
						dp = data[i][j][k];
						t = rg.util.DataPoints.valueAlt(dp,v.type,0.0) + rg.util.DataPoints.valueAlt(dp,this.y0property,0.0);
						if(v.meta.max < t) v.meta.max = t;
					}
				}
			}
		}
	}
	,stats: null
	,segment: null
	,chart: null
	,linePathShape: null
	,sensibleRadius: null
	,y0property: null
	,lineEffect: null
	,lineInterpolator: null
	,symbolStyle: null
	,symbol: null
	,__class__: rg.svg.chart.LineChart
});
rg.svg.chart.LineEffect = { __ename__ : ["rg","svg","chart","LineEffect"], __constructs__ : ["NoEffect","Gradient","DropShadow"] }
rg.svg.chart.LineEffect.NoEffect = ["NoEffect",0];
rg.svg.chart.LineEffect.NoEffect.toString = $estr;
rg.svg.chart.LineEffect.NoEffect.__enum__ = rg.svg.chart.LineEffect;
rg.svg.chart.LineEffect.Gradient = function(lightness,levels) { var $x = ["Gradient",1,lightness,levels]; $x.__enum__ = rg.svg.chart.LineEffect; $x.toString = $estr; return $x; }
rg.svg.chart.LineEffect.DropShadow = function(ox,oy,evels) { var $x = ["DropShadow",2,ox,oy,evels]; $x.__enum__ = rg.svg.chart.LineEffect; $x.toString = $estr; return $x; }
rg.svg.chart.LineEffects = function() { }
$hxClasses["rg.svg.chart.LineEffects"] = rg.svg.chart.LineEffects;
rg.svg.chart.LineEffects.__name__ = ["rg","svg","chart","LineEffects"];
rg.svg.chart.LineEffects.parse = function(s) {
	var parts = s.toLowerCase().split(":");
	var _g = parts.shift();
	switch(_g) {
	case "dropshadow":
		var offsetx = 0.5, offsety = 0.5, levels = 2, parameters = parts.pop();
		if(null != parameters) {
			var parameters1 = parameters.split(",");
			offsetx = Std.parseFloat(parameters1[0]);
			if(parameters1.length > 1) offsety = Std.parseFloat(parameters1[1]); else offsety = offsetx;
			if(parameters1.length > 2) levels = Std.parseInt(parameters1[2]);
		}
		return rg.svg.chart.LineEffect.DropShadow(offsetx,offsety,levels);
	case "gradient":
		var lightness = 0.75, levels = 2, parameters = parts.pop();
		if(null != parameters) {
			lightness = Std.parseFloat(parameters.split(",").shift());
			var nlevels = parameters.split(",").pop();
			if(null != nlevels) levels = Std.parseInt(nlevels);
		}
		return rg.svg.chart.LineEffect.Gradient(lightness,levels);
	default:
		return rg.svg.chart.LineEffect.NoEffect;
	}
}
rg.svg.chart.PieChart = function(panel) {
	rg.svg.chart.Chart.call(this,panel);
	this.addClass("pie-chart");
	this.g.append("svg:defs");
	this.pie = new thx.geom.layout.Pie();
	this.gradientLightness = 0.75;
	this.displayGradient = true;
	this.animationDelay = 0;
	this.innerRadius = 0.0;
	this.outerRadius = 0.9;
	this.overRadius = 0.95;
	this.labelRadius = 0.45;
	this.tooltipRadius = 0.5;
	this.labels = new haxe.ds.StringMap();
	this.labelOrientation = rg.svg.widget.LabelOrientation.Orthogonal;
	this.labelDontFlip = true;
};
$hxClasses["rg.svg.chart.PieChart"] = rg.svg.chart.PieChart;
rg.svg.chart.PieChart.__name__ = ["rg","svg","chart","PieChart"];
rg.svg.chart.PieChart.__super__ = rg.svg.chart.Chart;
rg.svg.chart.PieChart.prototype = $extend(rg.svg.chart.Chart.prototype,{
	pief: function(dp) {
		var name = this.variableDependent.type, temp = dp.map(function(d) {
			return Reflect.field(d,name);
		}), arr = this.pie.pie(temp);
		var _g1 = 0, _g = arr.length;
		while(_g1 < _g) {
			var i = _g1++;
			var id = this.makeid(dp[i]);
			arr[i].id = id;
			arr[i].dp = dp[i];
		}
		return arr;
	}
	,arcShape: function(a) {
		return function(d,i) {
			return a.shape(d);
		};
	}
	,makeid: function(dp) {
		var c = Objects.clone(dp);
		Reflect.deleteField(c,this.variableDependent.type);
		return haxe.crypto.Md5.encode(Dynamics.string(c));
	}
	,id: function(dp,i) {
		return dp.id;
	}
	,backtonormal: function(d,i) {
		var slice = dhx.Dom.selectNodeData(d).selectAll("path");
		slice.transition().ease(this.animationEase).duration(null,this.animationDuration).attr("d").stringf(this.arcShape(this.arcNormal));
	}
	,highlight: function(d,i) {
		var slice = dhx.Dom.selectNodeData(d).selectAll("path");
		slice.transition().ease(this.animationEase).duration(null,this.animationDuration).attr("d").stringf(this.arcShape(this.arcBig));
	}
	,fadein: function(n,i) {
		var gn = dhx.Dom.selectNodeData(n), shape = this.arcNormal.shape(Reflect.field(n,"__dhx_data__"));
		gn.selectAll("path.slice").transition().ease(this.animationEase).duration(null,this.animationDuration).delay(null,this.animationDelay).attr("d").string(shape);
	}
	,applyGradient: function(n,i) {
		var gn = dhx.Dom.selectNodeData(n), dp = Reflect.field(n,"__dhx_data__"), id = dp.id;
		if(this.g.select("defs").select("#rg_pie_gradient_" + id).empty()) {
			var slice = gn.select("path.slice"), shape = this.arcNormal.shape(Reflect.field(n,"__dhx_data__")), t = gn.append("svg:path").attr("d").string(shape), box = (function($this) {
				var $r;
				try {
					$r = t.node().getBBox();
				} catch( e ) {
					$r = { x : 0.0, y : 0.0, width : 0.0, height : 0.0};
				}
				return $r;
			}(this));
			t.remove();
			var color = rg.util.RGColors.parse(slice.style("fill").get(),"#cccccc"), scolor = rg.util.RGColors.applyLightness(thx.color.Hsl.toHsl(color),this.gradientLightness);
			var ratio = box.width / box.height, cx = -box.x * 100 / box.width, cy = -box.y * 100 / box.height / ratio, r = Math.max(cx,cy);
			var stops = this.g.select("defs").append("svg:radialGradient").attr("gradientUnits").string("objectBoundingBox").attr("id").string("rg_pie_gradient_" + id).attr("cx").string(cx + "%").attr("cy").string(cy + "%").attr("gradientTransform").string("scale(1 " + ratio + ")").attr("r").string(r + "%");
			stops.append("svg:stop").attr("offset").string(100 * this.innerRadius + "%").attr("stop-color").string(color.toRgbString()).attr("stop-opacity")["float"](1);
			stops.append("svg:stop").attr("offset").string("100%").attr("stop-color").string(scolor.toRgbString()).attr("stop-opacity")["float"](1);
		}
		gn.select("path.slice").attr("style").string("fill:url(#rg_pie_gradient_" + id + ")");
	}
	,appendLabel: function(dom,i) {
		var n = dhx.Dom.selectNode(dom), label = new rg.svg.widget.Label(n,this.labelDontFlip,true,true), d = Reflect.field(dom,"__dhx_data__"), r = this.radius * this.labelRadius, a = d.startAngle + (d.endAngle - d.startAngle) / 2 - Math.PI / 2;
		label.set_orientation(this.labelOrientation);
		var _g = this;
		switch( (_g.labelOrientation)[1] ) {
		case 0:
			label.set_anchor(rg.svg.widget.GridAnchor.Center);
			break;
		case 1:
			label.set_anchor(rg.svg.widget.GridAnchor.Left);
			break;
		case 2:
			label.set_anchor(rg.svg.widget.GridAnchor.Top);
			break;
		}
		label.set_text(this.labelDataPoint(d.dp,this.stats));
		label.place(-2.5 + Math.cos(a) * r,-2.5 + Math.sin(a) * r,57.29577951308232088 * a);
		this.labels.set(d.id,label);
		if(Reflect.field(d.dp,this.stats.type) <= 0) label.hide();
	}
	,updateLabel: function(dom,i) {
		var n = dhx.Dom.selectNode(dom), d = Reflect.field(dom,"__dhx_data__"), label = this.labels.get(d.id), r = this.radius * this.labelRadius, a = d.startAngle + (d.endAngle - d.startAngle) / 2 - Math.PI / 2;
		label.set_text(this.labelDataPoint(d.dp,this.stats));
		label.place(-2.5 + Math.cos(a) * r,-2.5 + Math.sin(a) * r,57.29577951308232088 * a);
		if(Reflect.field(d.dp,this.stats.type) == 0) label.hide(); else label.show();
	}
	,removeLabel: function(dom,i) {
		var n = dhx.Dom.selectNode(dom), d = Reflect.field(dom,"__dhx_data__");
		var label = this.labels.get(d.id);
		label.destroy();
		this.labels.remove(d.id);
	}
	,onMouseClick: function(dom,i) {
		var d = Reflect.field(dom,"__dhx_data__");
		this.mouseClick(d.dp);
	}
	,onMouseOver: function(dom,i) {
		if(null == this.labelDataPointOver) return;
		var d = Reflect.field(dom,"__dhx_data__"), text = this.labelDataPointOver(d.dp,this.stats);
		if(null == text) this.tooltip.hide(); else {
			var a = d.startAngle + (d.endAngle - d.startAngle) / 2 - Math.PI / 2, r = this.radius * this.tooltipRadius;
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(this.width / 2 + Math.cos(a) * r,this.height / 2 + Math.sin(a) * r,rg.util.RGColors.extractColor(dom));
		}
	}
	,data: function(dp) {
		var pv = this.variableDependent.type;
		this.stats = this.variableDependent.stats;
		var choice = this.g.selectAll("g.group").data(this.pief(dp),$bind(this,this.id));
		var enter = choice.enter();
		var arc = enter.append("svg:g").attr("class").stringf(function(d,i) {
			return "group fill-" + i;
		}).attr("transform").string("translate(" + this.radius + "," + this.radius + ")");
		var path = arc.append("svg:path").attr("class").string("slice");
		rg.util.RGColors.storeColorForSelection(arc);
		if(this.displayGradient) arc.eachNode($bind(this,this.applyGradient));
		if(this.animated) {
			path.attr("d").stringf(this.arcShape(this.arcStart));
			arc.eachNode($bind(this,this.fadein)).onNode("mouseover.animation",$bind(this,this.highlight)).onNode("mouseout.animation",$bind(this,this.backtonormal));
		} else path.attr("d").stringf(this.arcShape(this.arcNormal));
		arc.onNode("mouseover.label",$bind(this,this.onMouseOver));
		if(null != this.mouseClick) arc.onNode("click.user",$bind(this,this.onMouseClick));
		if(null != this.labelDataPoint) choice.enter().append("svg:g").attr("transform").string("translate(" + this.radius + "," + this.radius + ")").eachNode($bind(this,this.appendLabel));
		choice.update().select("path").transition().ease(this.animationEase).duration(null,this.animationDuration).attr("d").stringf(this.arcShape(this.arcNormal));
		if(null != this.labelDataPoint) choice.update().eachNode($bind(this,this.updateLabel));
		choice.exit().eachNode($bind(this,this.removeLabel)).remove();
		this.ready.dispatch();
	}
	,resize: function() {
		rg.svg.chart.Chart.prototype.resize.call(this);
		this.radius = Math.min(this.width,this.height) / 2;
		this.arcStart = thx.svg.Arc.fromAngleObject().innerRadius(this.radius * this.innerRadius).outerRadius(this.radius * this.innerRadius);
		this.arcNormal = thx.svg.Arc.fromAngleObject().innerRadius(this.radius * this.innerRadius).outerRadius(this.radius * this.outerRadius);
		this.arcBig = thx.svg.Arc.fromAngleObject().innerRadius(this.radius * this.innerRadius).outerRadius(this.radius * this.overRadius);
		if(this.width > this.height) this.g.attr("transform").string("translate(" + (this.width / 2 - this.height / 2) + ",0)"); else this.g.attr("transform").string("translate(0," + (this.height / 2 - this.width / 2) + ")");
	}
	,setVariables: function(variableIndependents,variableDependents) {
		this.variableDependent = variableDependents[0];
	}
	,mouseClick: null
	,labels: null
	,labelDontFlip: null
	,labelOrientation: null
	,animationDelay: null
	,displayGradient: null
	,gradientLightness: null
	,variableDependent: null
	,stats: null
	,radius: null
	,pie: null
	,arcBig: null
	,arcStart: null
	,arcNormal: null
	,tooltipRadius: null
	,labelRadius: null
	,overRadius: null
	,outerRadius: null
	,innerRadius: null
	,__class__: rg.svg.chart.PieChart
});
rg.svg.chart.Sankey = function(panel) {
	rg.svg.chart.Chart.call(this,panel);
	this.addClass("sankey");
	this.layerWidth = 61;
	this.nodeSpacing = 28;
	this.dummySpacing = 18;
	this.extraWidth = 28;
	this.backEdgeSpacing = 4.0;
	this.extraHeight = 5;
	this.extraRadius = 5;
	this.chunkWidth = 10;
	this.imageWidth = 60;
	this.imageHeight = 48;
	this.imageSpacing = 0;
	this.labelNodeSpacing = 4;
	this.styleNode = "0";
	this.styleentry = "4";
	this.styleexit = "6";
	this.styleEdgeBackward = "3";
	this.styleEdgeForward = "0";
	this.stackbackedges = true;
	this.thinbackedges = true;
};
$hxClasses["rg.svg.chart.Sankey"] = rg.svg.chart.Sankey;
rg.svg.chart.Sankey.__name__ = ["rg","svg","chart","Sankey"];
rg.svg.chart.Sankey.__super__ = rg.svg.chart.Chart;
rg.svg.chart.Sankey.prototype = $extend(rg.svg.chart.Chart.prototype,{
	hnode: function(node,_) {
		return this.nheight(node.data.weight);
	}
	,isdummy: function(node) {
		return HxOverrides.substr(node.data.id,0,1) == "#";
	}
	,nodepadding: function(node) {
		return this.isdummy(node)?this.dummySpacing:this.nodeSpacing;
	}
	,ynode: function(node,_) {
		var cell = this.layout.cell(node), before = this.layerstarty[cell.layer];
		var _g1 = 0, _g = cell.position;
		while(_g1 < _g) {
			var i = _g1++;
			var prev = this.layout.nodeAt(cell.layer,i);
			before += this.hnode(prev) + this.nodepadding(prev);
		}
		before += this.nodepadding(node);
		return Math.round(before) + 0.5;
	}
	,xlayer: function(pos,_) {
		if(this.layout.length <= 1) return this.width / 2;
		return Math.round((this.width - this.padBefore - this.padAfter - this.layerWidth) / (this.layout.length - 1) * pos + this.layerWidth / 2 + this.padBefore);
	}
	,hafter: function(id,edges) {
		var found = false, pad = this.backEdgeSpacing / this.nheight(1), weight = pad;
		while( edges.hasNext() ) {
			var edge = edges.next();
			if(!found) {
				if(edge.id == id) found = true;
				continue;
			}
			weight += edge.weight + pad;
		}
		return this.nheight(weight);
	}
	,cafter: function(id,edges) {
		var found = false, count = 0;
		while( edges.hasNext() ) {
			var edge = edges.next();
			if(!found) {
				if(edge.id == id) found = true;
				continue;
			}
			count++;
		}
		return count;
	}
	,ydiagonal: function(id,edges) {
		var weight = 0.0;
		while( edges.hasNext() ) {
			var edge = edges.next();
			if(edge.id == id) break;
			weight += edge.weight;
		}
		return this.nheight(weight);
	}
	,nheight: function(v) {
		if(0 == v) return 0;
		return Math.round(v / this.maxweight * this.availableheight);
	}
	,onmouseoverexit: function(x,y,node,el,i) {
		this.highlight(node.id,"node");
		if(null == this.labelEdgeOver) return;
		var text = this.labelEdgeOver(this.edgeDataWithNode(node,true),this.dependentVariable.stats);
		if(null == text) this.tooltip.hide(); else {
			this.tooltip.anchor("topleft");
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(x,y,rg.util.RGColors.extractColor(el));
		}
	}
	,onmouseoverentry: function(x,y,node,el,i) {
		this.highlight(node.id,"node");
		if(null == this.labelEdgeOver) return;
		var text = this.labelEdgeOver(this.edgeDataWithNode(node,false),this.dependentVariable.stats);
		if(null == text) this.tooltip.hide(); else {
			this.tooltip.anchor("bottomright");
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(x,y,rg.util.RGColors.extractColor(el));
		}
	}
	,onmouseoveredge: function(x,y,edge,el,i) {
		this.highlight(edge.id,"edge");
		if(null == this.labelEdgeOver) return;
		var text = this.labelEdgeOver(this.edgeData(edge),this.dependentVariable.stats);
		if(null == text) this.tooltip.hide(); else {
			this.tooltip.anchor("bottomright");
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(x,y,rg.util.RGColors.extractColor(el));
		}
	}
	,onmouseovernode: function(node,el,i) {
		this.highlight(node.id,"node");
		if(this.isdummy(node)) {
			if(null == this.labelEdgeOver) return;
			var text = this.labelEdgeOver(this.edgeData(node.graph.edges.positives(node).next()),this.dependentVariable.stats);
			if(false === text) {
			} else if(null == text) this.tooltip.hide(); else {
				var cell = this.layout.cell(node);
				this.tooltip.anchor("bottomright");
				this.tooltip.html(text.split("\n").join("<br>"));
				this.moveTooltip(this.xlayer(cell.layer),this.ynode(node) + this.hnode(node) / 2,rg.util.RGColors.extractColor(el));
			}
		} else {
			if(null == this.labelDataPointOver) return;
			var text = this.labelDataPointOver(node.data.dp,this.dependentVariable.stats);
			if(false === text) {
			} else if(null == text) this.tooltip.hide(); else {
				var cell = this.layout.cell(node);
				this.tooltip.anchor("bottomright");
				this.tooltip.html(text.split("\n").join("<br>"));
				this.moveTooltip(this.xlayer(cell.layer),this.ynode(node) + this.hnode(node) / 2,rg.util.RGColors.extractColor(el));
			}
		}
	}
	,edgeClickWithNode: function(node,out,el,i) {
		this.edgeclick(this.edgeDataWithNode(node,out),el,i);
	}
	,edgeClickWithEdge: function(edge,el,i) {
		this.edgeclick(this.edgeData(edge),el,i);
	}
	,edgeclick: function(data,el,i) {
		this.clickEdge(data,this.dependentVariable.stats);
	}
	,nodeclick: function(node,el,i) {
		this.click(node.data.dp,this.dependentVariable.stats);
	}
	,edgeDataWithNode: function(node,out) {
		return { tail : out?node.data.dp:null, head : out?null:node.data.dp, edgeweight : out?node.data.exit:node.data.entry, nodeweight : node.data.weight};
	}
	,edgeData: function(edge) {
		var head = edge.head, tail = edge.tail;
		while(this.isdummy(head)) head = head.graph.edges.positives(head).next().head;
		while(this.isdummy(tail)) tail = tail.graph.edges.negatives(tail).next().tail;
		return { head : head.data.dp, tail : tail.data.dp, edgeweight : edge.weight, nodeweight : tail.data.weight};
	}
	,highlight: function(id,type) {
		var _g = this;
		var $it0 = ((function(_e) {
			return function() {
				return _e.iterator();
			};
		})(this.maphi))();
		while( $it0.hasNext() ) {
			var el = $it0.next();
			el.classed().remove("over");
		}
		this.maphi = new haxe.ds.StringMap();
		var hiedgep = null, hinodep = null, hiedgen = null, hinoden = null;
		var hielement = function(id1,type1) {
			var key = type1 + ":" + id1;
			_g.maphi.set(key,_g.mapelements.get(key).classed().add("over"));
		};
		var hientry = function(id1) {
			var key = "entry:" + id1, extra = _g.mapelements.get(key);
			if(null == extra) return;
			_g.maphi.set(key,extra.classed().add("over"));
		};
		var hiexit = function(id1) {
			var key = "exit:" + id1, extra = _g.mapelements.get(key);
			if(null == extra) return;
			_g.maphi.set(key,extra.classed().add("over"));
		};
		var ishi = function(id1,type1) {
			return _g.maphi.exists(type1 + ":" + id1);
		};
		hiedgep = function(edge) {
			if(ishi(edge.id,"edge")) return;
			hielement(edge.id,"edge");
			if(!_g.isbackward(edge)) hinodep(edge.head);
		};
		hinodep = function(node) {
			if(ishi(node.id,"node")) return;
			hielement(node.id,"node");
			hiexit(node.id);
			var $it1 = node.graph.edges.positives(node);
			while( $it1.hasNext() ) {
				var edge = $it1.next();
				hiedgep(edge);
			}
		};
		hiedgen = function(edge) {
			if(!_g.isbackward(edge)) hinoden(edge.tail);
			if(ishi(edge.id,"edge")) return;
			if(!_g.isbackward(edge)) hielement(edge.id,"edge");
		};
		hinoden = function(node) {
			var $it2 = node.graph.edges.negatives(node);
			while( $it2.hasNext() ) {
				var edge = $it2.next();
				hiedgen(edge);
			}
			if(ishi(node.id,"node")) return;
			hielement(node.id,"node");
			hientry(node.id);
		};
		if(type == "edge") {
			hiedgep(this.layout.graph.edges.get(id));
			hiedgen(this.layout.graph.edges.get(id));
		} else if(type == "node") {
			hinodep(this.layout.graph.nodes.get(id));
			hinoden(this.layout.graph.nodes.get(id));
			hientry(id);
		}
	}
	,isbackward: function(edge) {
		return this.layout.cell(edge.head).layer <= this.layout.cell(edge.tail).layer;
	}
	,addToMap: function(id,type,el) {
		this.mapelements.set(type + ":" + id,el);
	}
	,redraw: function() {
		var _g2 = this;
		this.mapelements = new haxe.ds.StringMap();
		this.maphi = new haxe.ds.StringMap();
		this.maxweight = 0;
		this.layerstarty = [];
		var _g1 = 0, _g = this.layout.length;
		while(_g1 < _g) {
			var i = _g1++;
			var v = Iterators.reduce($iterator(this.layout.layer(i))(),function(cum,cur,_) {
				return cum + cur.data.weight;
			},0);
			if(v > this.maxweight) this.maxweight = v;
		}
		var occupiedspace = 0.0;
		var _g1 = 0, _g = this.layout.length;
		while(_g1 < _g) {
			var i = _g1++;
			var v = Iterators.reduce($iterator(this.layout.layer(i))(),function(cum,cur,_) {
				return cum + _g2.nodepadding(cur);
			},0.0);
			if(v > occupiedspace) occupiedspace = v;
		}
		this.availableheight = this.height - occupiedspace;
		if(this.thinbackedges) {
			var count = this.stackbackedges?Iterators.filter(this.layout.graph.edges.collection.iterator(),function(edge) {
				return _g2.layout.cell(edge.tail).layer >= _g2.layout.cell(edge.head).layer;
			}).length:1;
			this.availableheight -= (1 + this.backEdgeSpacing) * count;
		} else if(this.stackbackedges) {
			var $it0 = this.layout.graph.edges.collection.iterator();
			while( $it0.hasNext() ) {
				var edge = $it0.next();
				if(this.layout.cell(edge.tail).layer < this.layout.cell(edge.head).layer) continue;
				this.availableheight -= this.backEdgeSpacing;
				this.maxweight += edge.weight;
			}
		} else {
			this.availableheight -= this.backEdgeSpacing;
			var v = 0.0;
			var $it1 = this.layout.graph.edges.collection.iterator();
			while( $it1.hasNext() ) {
				var edge = $it1.next();
				if(this.layout.cell(edge.tail).layer < this.layout.cell(edge.head).layer) continue;
				if(edge.weight > v) v = edge.weight;
			}
			this.maxweight += v;
		}
		this.availableheight -= this.extraRadius + this.extraHeight;
		var backedgesy = 0.0;
		var _g1 = 0, _g = this.layout.length;
		while(_g1 < _g) {
			var i = _g1++;
			var layer = this.layout.layer(i), t = 0.0;
			var _g21 = 0;
			while(_g21 < layer.length) {
				var node = layer[_g21];
				++_g21;
				t += this.nodepadding(node) + this.nheight(node.data.weight);
			}
			this.layerstarty[i] = t;
			if(t > backedgesy) backedgesy = t;
		}
		var _g1 = 0, _g = this.layerstarty.length;
		while(_g1 < _g) {
			var i = _g1++;
			this.layerstarty[i] = (backedgesy - this.layerstarty[i]) / 2;
		}
		backedgesy += this.extraRadius + this.extraHeight;
		this.padBefore = 0.0;
		if(this.thinbackedges) {
			var _g = 0, _g1 = this.layout.layer(0);
			while(_g < _g1.length) {
				var node = _g1[_g];
				++_g;
				var hasEntry = null != this.displayEntry && this.displayEntry(node.data,this.dependentVariable.stats), first = true, sum = 0.0;
				var $it2 = node.graph.edges.negatives(node);
				while( $it2.hasNext() ) {
					var edge = $it2.next();
					if(first) {
						first = false;
						sum += this.extraRadius + this.chunkWidth;
					} else sum += this.backEdgeSpacing + 2;
				}
				if(sum > this.padBefore) this.padBefore = sum;
				if(hasEntry && this.extraWidth > this.padBefore) this.padBefore = this.extraWidth;
			}
		} else {
			var _g = 0, _g1 = this.layout.layer(0);
			while(_g < _g1.length) {
				var node = _g1[_g];
				++_g;
				var extra = Math.min(this.nheight(node.data.entry),this.extraWidth);
				var $it3 = node.graph.edges.negatives(node);
				while( $it3.hasNext() ) {
					var edge = $it3.next();
					var tail = edge.tail, parentweight = this.hafter(edge.id,node.graph.edges.negatives(node)) + this.nheight(edge.weight);
					if(parentweight > extra) extra = parentweight;
				}
				if(extra > this.padBefore) this.padBefore = extra;
			}
		}
		this.padBefore += 2;
		this.padAfter = 0.0;
		if(this.thinbackedges) {
			var _g = 0, _g1 = this.layout.layer(this.layout.length - 1);
			while(_g < _g1.length) {
				var node = _g1[_g];
				++_g;
				var hasExit = null != this.displayExit && this.displayExit(node.data,this.dependentVariable.stats), first = true, sum = 0.0;
				var $it4 = node.graph.edges.positives(node);
				while( $it4.hasNext() ) {
					var edge = $it4.next();
					if(first) {
						first = false;
						sum += this.extraRadius + this.chunkWidth;
					} else sum += this.backEdgeSpacing + 2;
				}
				if(sum > this.padAfter) this.padAfter = sum;
				if(hasExit && this.extraWidth > this.padAfter) this.padAfter = this.extraWidth;
			}
		} else {
			var _g = 0, _g1 = this.layout.layer(this.layout.length - 1);
			while(_g < _g1.length) {
				var node = _g1[_g];
				++_g;
				var extra = Math.min(this.nheight(node.data.exit),this.extraWidth);
				var $it5 = node.graph.edges.positives(node);
				while( $it5.hasNext() ) {
					var edge = $it5.next();
					var head = edge.head, childweight = this.hafter(edge.id,node.graph.edges.positives(node)) + this.nheight(edge.weight) + Math.min(this.nheight(node.data.exit),this.extraWidth);
					if(childweight > extra) extra = childweight;
				}
				if(extra > this.padAfter) this.padAfter = extra;
			}
		}
		this.padAfter += 2;
		var edgescontainer = this.g.select("g.edges");
		if(edgescontainer.empty()) edgescontainer = this.g.append("svg:g").attr("class").string("edges"); else edgescontainer.selectAll("*").remove();
		var edges = Arrays.order(Iterators.array($iterator(Iterators.array(this.layout.graph.edges.iterator()))()),function(ea,eb) {
			var lena = _g2.layout.cell(ea.tail).layer - _g2.layout.cell(ea.head).layer, lenb = _g2.layout.cell(eb.tail).layer - _g2.layout.cell(eb.head).layer, comp = lenb - lena;
			if(comp != 0) return comp; else return Floats.compare(eb.weight,ea.weight);
		});
		Iterators.each(this.layout.graph.nodes.iterator(),function(node,_) {
			node.graph.edges.sortPositives(node,function(a,b) {
				var ca = _g2.layout.cell(a.head), cb = _g2.layout.cell(b.head);
				var t = cb.layer - ca.layer;
				if(t != 0) return t;
				return ca.position - cb.position;
			});
			node.graph.edges.sortNegatives(node,function(a,b) {
				var ca = _g2.layout.cell(a.tail), cb = _g2.layout.cell(b.tail);
				if(ca.layer > cb.layer) return 1;
				return ca.position - cb.position;
			});
		});
		var cedges = edges.slice();
		cedges.sort(function(a,b) {
			var ca = _g2.layout.cell(a.tail), cb = _g2.layout.cell(b.tail);
			return cb.position - ca.position;
		});
		if(this.thinbackedges) Iterators.each($iterator(cedges)(),function(edge,_) {
			if(edge.weight <= 0) return;
			var cellhead = _g2.layout.cell(edge.head), celltail = _g2.layout.cell(edge.tail);
			if(cellhead.layer > celltail.layer) return;
			var weight = _g2.nheight(edge.weight), before = 5 + _g2.cafter(edge.id,edge.tail.positives()) * (_g2.backEdgeSpacing + 1), after = 5 + _g2.cafter(edge.id,edge.head.negatives()) * (_g2.backEdgeSpacing + 1), x1 = _g2.layerWidth / 2 + _g2.xlayer(celltail.layer), x2 = -_g2.layerWidth / 2 + _g2.xlayer(cellhead.layer), y1 = _g2.ynode(edge.tail) + _g2.ydiagonal(edge.id,edge.tail.positives()), y2 = _g2.nheight(edge.head.data.entry) + _g2.ynode(edge.head) + _g2.ydiagonal(edge.id,edge.head.negatives());
			var g = edgescontainer.append("svg:g");
			var chunkf = g.append("svg:rect").attr("x")["float"](x1).attr("y")["float"](y1).attr("width")["float"](_g2.chunkWidth).attr("height")["float"](weight).attr("class").string("edge fill fill-" + _g2.styleEdgeBackward + " stroke stroke-" + _g2.styleEdgeBackward).onNode("mouseover",(function(f,x,y,a1) {
				return function(el,i) {
					return f(x,y,a1,el,i);
				};
			})($bind(_g2,_g2.onmouseoveredge),(x1 + x2) / 2,backedgesy,edge));
			var chunkf1 = g.append("svg:rect").attr("x")["float"](x2 - _g2.chunkWidth).attr("y")["float"](y2).attr("width")["float"](_g2.chunkWidth).attr("height")["float"](weight).attr("class").string("edge fill fill-" + _g2.styleEdgeBackward + " stroke stroke-" + _g2.styleEdgeBackward).onNode("mouseover",(function(f1,x3,y3,a11) {
				return function(el,i) {
					return f1(x3,y3,a11,el,i);
				};
			})($bind(_g2,_g2.onmouseoveredge),(x1 + x2) / 2,backedgesy,edge));
			var hook = new rg.svg.widget.HookConnector(g,"stroke stroke-" + _g2.styleEdgeBackward);
			_g2.addToMap(edge.id,"edge",g);
			hook.update(x1 + _g2.chunkWidth,y1 + weight / 2,x2 - _g2.chunkWidth,y2 + weight / 2,backedgesy,before,after);
			hook.g.onNode("mouseover",(function(f2,x4,y4,a12) {
				return function(el,i) {
					return f2(x4,y4,a12,el,i);
				};
			})($bind(_g2,_g2.onmouseoveredge),(x1 + x2) / 2,backedgesy,edge));
			if(null != _g2.edgeClass) {
				var cls = _g2.edgeClass({ head : edge.head.data, tail : edge.tail.data, edgeweight : edge.weight},_g2.dependentVariable.stats);
				if(null != cls) hook.addClass(cls);
			}
			rg.util.RGColors.storeColorForSelection(hook.g,"stroke",hook.line.style("stroke").get());
			if(null != _g2.clickEdge) hook.g.onNode("click",(function(f3,a13) {
				return function(el,i) {
					return f3(a13,el,i);
				};
			})($bind(_g2,_g2.edgeClickWithEdge),edge));
			if(_g2.stackbackedges) backedgesy += 1 + _g2.backEdgeSpacing;
		}); else Iterators.each($iterator(cedges)(),function(edge,_) {
			if(edge.weight <= 0) return;
			var cellhead = _g2.layout.cell(edge.head), celltail = _g2.layout.cell(edge.tail);
			if(cellhead.layer > celltail.layer) return;
			var weight = _g2.nheight(edge.weight), hook = new rg.svg.widget.HookConnectorArea(edgescontainer,"fill fill-" + _g2.styleEdgeBackward,"stroke stroke-" + _g2.styleEdgeBackward), before = _g2.hafter(edge.id,edge.tail.positives()) + Math.min(_g2.extraWidth,_g2.nheight(edge.tail.data.exit)), after = _g2.hafter(edge.id,edge.head.negatives()), x1 = _g2.layerWidth / 2 + _g2.xlayer(celltail.layer), x2 = -_g2.layerWidth / 2 + _g2.xlayer(cellhead.layer), y1 = _g2.ynode(edge.tail) + _g2.ydiagonal(edge.id,edge.tail.positives()), y2 = _g2.nheight(edge.head.data.entry) + _g2.ynode(edge.head) + _g2.ydiagonal(edge.id,edge.head.negatives());
			_g2.addToMap(edge.id,"edge",hook.g);
			hook.update(x1,y1,x2,y2,weight,backedgesy,before,after);
			hook.g.onNode("mouseover",(function(f4,x5,y5,a14) {
				return function(el,i) {
					return f4(x5,y5,a14,el,i);
				};
			})($bind(_g2,_g2.onmouseoveredge),(x1 + x2) / 2,backedgesy + weight / 2,edge));
			if(null != _g2.edgeClass) {
				var cls = _g2.edgeClass({ head : edge.head.data, tail : edge.tail.data, edgeweight : edge.weight},_g2.dependentVariable.stats);
				if(null != cls) hook.addClass(cls);
			}
			rg.util.RGColors.storeColorForSelection(hook.g,"fill",hook.area.style("fill").get());
			if(null != _g2.clickEdge) hook.g.onNode("click",(function(f5,a15) {
				return function(el,i) {
					return f5(a15,el,i);
				};
			})($bind(_g2,_g2.edgeClickWithEdge),edge));
			if(_g2.stackbackedges) backedgesy += weight + _g2.backEdgeSpacing;
		});
		Iterators.each($iterator(edges)(),function(edge,_) {
			if(edge.weight <= 0) return;
			var head = edge.head, tail = edge.tail, cellhead = _g2.layout.cell(head), celltail = _g2.layout.cell(tail);
			if(cellhead.layer <= celltail.layer) return;
			var x1 = Math.round(_g2.layerWidth / 2 + _g2.xlayer(celltail.layer)) - .5, x2 = Math.round(-_g2.layerWidth / 2 + _g2.xlayer(cellhead.layer)) - .5, y1 = _g2.ynode(tail) + _g2.ydiagonal(edge.id,tail.graph.edges.positives(tail)), y2 = _g2.ynode(head) + _g2.nheight(head.data.entry) + _g2.ydiagonal(edge.id,head.graph.edges.negatives(head)), weight = _g2.nheight(edge.weight), diagonal = new rg.svg.widget.DiagonalArea(edgescontainer,"fill fill-" + _g2.styleEdgeForward,"stroke stroke-" + _g2.styleEdgeForward);
			diagonal.update(x1,y1,x2,y2,weight,weight);
			if(null != _g2.edgeClass) {
				var cls = _g2.edgeClass({ head : edge.head.data, tail : edge.tail.data, edgeweight : edge.weight},_g2.dependentVariable.stats);
				if(null != cls) diagonal.addClass(cls);
			}
			_g2.addToMap(edge.id,"edge",diagonal.g);
			diagonal.g.onNode("mouseover",(function(f6,x6,y6,a16) {
				return function(el,i) {
					return f6(x6,y6,a16,el,i);
				};
			})($bind(_g2,_g2.onmouseoveredge),(x1 + x2) / 2,(y1 + y2 + weight) / 2,edge));
			rg.util.RGColors.storeColorForSelection(diagonal.g,"fill",diagonal.area.style("fill").get());
			if(null != _g2.clickEdge) diagonal.g.onNode("click",(function(f7,a17) {
				return function(el,i) {
					return f7(a17,el,i);
				};
			})($bind(_g2,_g2.edgeClickWithEdge),edge));
		});
		var normMin = function(v) {
			return Math.max(0,Math.min(v - 3,_g2.extraRadius));
		};
		this.layout.each(function(cell,node) {
			if(node.data.exit <= 0 || _g2.extraWidth <= 0 || null != _g2.displayExit && !_g2.displayExit(node.data,_g2.dependentVariable.stats)) return;
			var elbow = new rg.svg.widget.ElbowArea(edgescontainer,"fill fill-" + _g2.styleexit,"stroke stroke-" + _g2.styleexit), extra = _g2.nheight(node.data.exit), x = _g2.layerWidth / 2 + _g2.xlayer(cell.layer), y = _g2.ynode(node) + _g2.ydiagonal(null,node.graph.edges.positives(node)), minr = normMin(extra);
			elbow.update(rg.svg.widget.Orientation.RightBottom,extra,x,y + extra,minr,_g2.extraWidth,0,_g2.extraHeight);
			if(null != _g2.labelEdge) {
				var label, text = _g2.labelEdge({ tail : node, head : null, nodeweight : node.data.weight, edgeweight : node.data.exit},_g2.dependentVariable.stats), nodeSpacing = 0;
				label = new rg.svg.widget.Label(edgescontainer,true,true,false);
				label.addClass("edge");
				label.place(x,y + extra / 2,0);
				label.set_anchor(rg.svg.widget.GridAnchor.Left);
				label.set_text(text);
				if(label.getSize().height > extra * .75) label.destroy();
			}
			elbow.g.onNode("mouseover",(function(f8,x7,y7,a18) {
				return function(el,i) {
					return f8(x7,y7,a18,el,i);
				};
			})($bind(_g2,_g2.onmouseoverexit),x + minr + (-minr + Math.min(_g2.extraWidth,extra)) / 2,_g2.ynode(node) + _g2.hnode(node) + minr + _g2.extraHeight,node));
			if(null != _g2.edgeClass) {
				var cls = _g2.edgeClass({ head : null, tail : node.data, edgeweight : node.data.exit},_g2.dependentVariable.stats);
				if(null != cls) elbow.addClass(cls);
			}
			rg.util.RGColors.storeColorForSelection(elbow.g,"fill",elbow.area.style("fill").get());
			if(null != _g2.clickEdge) elbow.g.onNode("click",(function(f9,a19,a2) {
				return function(el,i) {
					return f9(a19,a2,el,i);
				};
			})($bind(_g2,_g2.edgeClickWithNode),node,true));
			_g2.addToMap(node.id,"exit",elbow.g);
		});
		this.layout.each(function(cell,node) {
			if(node.data.entry <= 0 || _g2.extraWidth <= 0 || null != _g2.displayEntry && !_g2.displayEntry(node.data,_g2.dependentVariable.stats)) return;
			var elbow = new rg.svg.widget.ElbowArea(edgescontainer,"fill fill-" + _g2.styleentry,"stroke stroke-" + _g2.styleentry), extra = _g2.nheight(node.data.entry), minr = normMin(extra), x = -_g2.layerWidth / 2 + _g2.xlayer(cell.layer);
			elbow.update(rg.svg.widget.Orientation.LeftTop,extra,x,_g2.ynode(node),minr,_g2.extraWidth,0,_g2.extraHeight);
			if(null != _g2.labelEdge) {
				var label, text = _g2.labelEdge({ tail : null, head : node, nodeweight : node.data.weight, edgeweight : node.data.entry},_g2.dependentVariable.stats), nodeSpacing = 0;
				label = new rg.svg.widget.Label(edgescontainer,true,true,false);
				label.addClass("edge");
				label.place(x,_g2.ynode(node) + extra / 2,0);
				label.set_anchor(rg.svg.widget.GridAnchor.Right);
				label.set_text(text);
				if(label.getSize().height > extra * .75) label.destroy();
			}
			elbow.g.onNode("mouseover",(function(f10,x8,y8,a110) {
				return function(el,i) {
					return f10(x8,y8,a110,el,i);
				};
			})($bind(_g2,_g2.onmouseoverentry),x - minr + (minr - Math.min(_g2.extraWidth,extra)) / 2,_g2.ynode(node) - minr - _g2.extraHeight,node));
			if(null != _g2.edgeClass) {
				var cls = _g2.edgeClass({ head : node.data, tail : null, edgeweight : node.data.entry},_g2.dependentVariable.stats);
				if(null != cls) elbow.addClass(cls);
			}
			rg.util.RGColors.storeColorForSelection(elbow.g,"fill",elbow.area.style("fill").get());
			if(null != _g2.clickEdge) elbow.g.onNode("click",(function(f11,a111,a21) {
				return function(el,i) {
					return f11(a111,a21,el,i);
				};
			})($bind(_g2,_g2.edgeClickWithNode),node,false));
			_g2.addToMap(node.id,"entry",elbow.g);
		});
		if(null != this.labelEdge) Iterators.each($iterator(edges)(),function(edge,_) {
			if(edge.weight <= 0) return;
			var tail = edge.tail;
			if(_g2.isdummy(tail)) return;
			var celltail = _g2.layout.cell(tail), weight = _g2.nheight(edge.weight), label, text = _g2.labelEdge(_g2.edgeData(edge),_g2.dependentVariable.stats), nodeSpacing = 2;
			label = new rg.svg.widget.Label(edgescontainer,true,true,false);
			label.addClass("edge");
			label.place(_g2.layerWidth / 2 + _g2.xlayer(celltail.layer) + nodeSpacing,_g2.ynode(tail) + _g2.ydiagonal(edge.id,tail.graph.edges.positives(tail)) + weight / 2,0);
			label.set_anchor(rg.svg.widget.GridAnchor.Left);
			label.set_text(text);
			if(label.getSize().height > weight * .75) label.destroy();
		});
		var rules = this.g.selectAll("g.layer").data(this.layout.layers()).enter().append("svg:g").attr("class").string("layer").append("svg:line").attr("class").stringf(function(_,i) {
			return "rule rule-" + i;
		}).attr("x1")["float"](0).attr("x2")["float"](0).attr("y1")["float"](0).attr("y2")["float"](this.height).update().attr("transform").stringf(function(_,i) {
			return "translate(" + _g2.xlayer(i) + ",0)";
		}).exit().remove();
		var choice = rules.update().selectAll("g.node").dataf(function(d,i) {
			return _g2.layout.layer(i);
		});
		var cont = choice.enter().append("svg:g").attr("class").string("node");
		if(this.layerWidth > 0) {
			var rect = cont.append("svg:rect").attr("class").stringf(function(n,_) {
				return "fill fill-" + (_g2.isdummy(n)?_g2.styleEdgeForward + " nonode":_g2.styleNode + " node");
			}).attr("x")["float"](-this.layerWidth / 2).attr("y")["float"](0).attr("width")["float"](Math.round(this.layerWidth)).attr("height").floatf($bind(this,this.hnode));
			cont.each(function(node,_) {
				_g2.addToMap(node.id,"node",dhx.Dom.selectNode(dhx.Group.current));
				if(null != _g2.nodeClass) {
					var cls = _g2.nodeClass(node.data,_g2.dependentVariable.stats);
					if(null != cls) dhx.Dom.selectNode(dhx.Group.current).classed().add(cls);
				}
			});
			rg.util.RGColors.storeColorForSelection(cont,"fill",rect.style("fill").get());
			cont.append("svg:line").attr("class").stringf(function(n,_) {
				return "node stroke stroke-" + (_g2.isdummy(n)?_g2.styleEdgeForward:_g2.styleNode);
			}).attr("x1")["float"](-this.layerWidth / 2).attr("y1")["float"](0).attr("x2")["float"](this.layerWidth / 2).attr("y2")["float"](0);
			cont.append("svg:line").attr("class").stringf(function(n,_) {
				return "node stroke stroke-" + (_g2.isdummy(n)?_g2.styleEdgeForward:_g2.styleNode);
			}).attr("x1")["float"](-this.layerWidth / 2).attr("y1").floatf($bind(this,this.hnode)).attr("x2")["float"](this.layerWidth / 2).attr("y2").floatf($bind(this,this.hnode));
		}
		choice.update().attr("transform").stringf(function(n,i) {
			return "translate(0," + _g2.ynode(n) + ")";
		});
		cont.each(function(n,i) {
			var node = dhx.Dom.selectNode(dhx.Group.current);
			if(_g2.isdummy(n)) return;
			var nodeheight = _g2.hnode(n), label;
			if(null != _g2.labelDataPoint) {
				var lines = _g2.labelDataPoint(n.data.dp,_g2.dependentVariable.stats).split("\n"), nodeSpacing = 3, prev = null, text, pos = 0.0;
				var _g1 = 0, _g = lines.length;
				while(_g1 < _g) {
					var i1 = _g1++;
					text = lines[i1];
					label = new rg.svg.widget.Label(node,true,true,false);
					label.addClass("node");
					if(i1 == 0) label.addClass("first");
					pos = nodeSpacing;
					if(null != prev) pos += prev.y + prev.getSize().height;
					label.place(-_g2.layerWidth / 2 + nodeSpacing * 2,pos,0);
					label.set_anchor(rg.svg.widget.GridAnchor.TopLeft);
					label.set_text(text);
					if(label.y + label.getSize().height > nodeheight) {
						label.destroy();
						break;
					}
					prev = label;
				}
			}
			var hasimage = false;
			if(null != _g2.imagePath && !_g2.isdummy(n)) {
				var path = _g2.imagePath(n.data.dp);
				if(path != null) {
					hasimage = true;
					var container = node.append("svg:g").attr("transform").string("translate(" + Math.round(-_g2.imageWidth / 2) + "," + Math.round(-_g2.imageHeight - _g2.imageSpacing) + ")");
					container.append("svg:image").attr("preserveAspectRatio").string("xMidYMid slice").attr("width")["float"](_g2.imageWidth).attr("height")["float"](_g2.imageHeight).attr("xlink:href").string(path);
				}
			}
			if(null != _g2.labelNode) {
				if(hasimage) label = new rg.svg.widget.Label(node,true,true,true); else label = new rg.svg.widget.Label(node,true,false,false);
				label.set_anchor(rg.svg.widget.GridAnchor.Bottom);
				label.place(0,-_g2.labelNodeSpacing,0);
				label.set_text(_g2.labelNode(n.data.dp,_g2.dependentVariable.stats));
			}
		});
		cont.each(function(n,i) {
			var node = dhx.Dom.selectNode(dhx.Group.current);
			node.onNode("mouseover",(function(f12,a112) {
				return function(el,i1) {
					return f12(a112,el,i1);
				};
			})($bind(_g2,_g2.onmouseovernode),n));
			if(null != _g2.click) node.onNode("click",(function(f13,a113) {
				return function(el,i1) {
					return f13(a113,el,i1);
				};
			})($bind(_g2,_g2.nodeclick),n));
		});
		this.ready.dispatch();
	}
	,data: function(graphlayout) {
		var _g = this;
		this.layout = graphlayout.clone();
		var nodes = Iterators.filter(this.layout.graph.nodes.iterator(),function(node) {
			return _g.isdummy(node);
		}).filter(function(node) {
			var edge = node.graph.edges.positives(node).next();
			if(null == edge) return false;
			var cellhead = _g.layout.cell(edge.head), celltail = _g.layout.cell(edge.tail);
			return celltail.layer > cellhead.layer;
		});
		var layers = this.layout.layers();
		var _g1 = 0;
		while(_g1 < nodes.length) {
			var node = nodes[_g1];
			++_g1;
			var cell = this.layout.cell(node), ehead = node.graph.edges.positives(node).next(), etail = node.graph.edges.negatives(node).next();
			layers[cell.layer].splice(cell.position,1);
			this.layout.graph.edges.create(etail.tail,ehead.head,ehead.weight,ehead.data);
			node.graph.nodes._remove(node);
		}
		this.redraw();
	}
	,setVariables: function(variableIndependents,variableDependents,data) {
		this.dependentVariable = variableDependents[0];
	}
	,maphi: null
	,mapelements: null
	,dependentVariable: null
	,styleEdgeForward: null
	,styleEdgeBackward: null
	,styleexit: null
	,styleentry: null
	,styleNode: null
	,layerstarty: null
	,padAfter: null
	,padBefore: null
	,availableheight: null
	,maxweight: null
	,layout: null
	,chunkWidth: null
	,displayExit: null
	,displayEntry: null
	,edgeClass: null
	,nodeClass: null
	,clickEdge: null
	,imagePath: null
	,labelNode: null
	,labelEdgeOver: null
	,labelEdge: null
	,thinbackedges: null
	,stackbackedges: null
	,labelNodeSpacing: null
	,imageSpacing: null
	,imageHeight: null
	,imageWidth: null
	,extraRadius: null
	,extraHeight: null
	,backEdgeSpacing: null
	,extraWidth: null
	,dummySpacing: null
	,nodeSpacing: null
	,layerWidth: null
	,__class__: rg.svg.chart.Sankey
});
rg.svg.chart.ScatterGraph = function(panel) {
	rg.svg.chart.CartesianChart.call(this,panel);
	this.addClass("scatter-graph");
	this.chart = this.g.append("svg:g");
};
$hxClasses["rg.svg.chart.ScatterGraph"] = rg.svg.chart.ScatterGraph;
rg.svg.chart.ScatterGraph.__name__ = ["rg","svg","chart","ScatterGraph"];
rg.svg.chart.ScatterGraph.__super__ = rg.svg.chart.CartesianChart;
rg.svg.chart.ScatterGraph.prototype = $extend(rg.svg.chart.CartesianChart.prototype,{
	onclick: function(stats,dp,i) {
		this.click(dp,stats);
	}
	,onmouseover: function(stats,n,i) {
		var dp = Reflect.field(n,"__dhx_data__"), text = this.labelDataPointOver(dp,stats);
		if(null == text) this.tooltip.hide(); else {
			var sel = dhx.Dom.selectNode(n), coords = rg.svg.chart.Coords.fromTransform(sel.attr("transform").get());
			this.tooltip.html(text.split("\n").join("<br>"));
			this.moveTooltip(coords[0],coords[1],null);
		}
	}
	,getTranslatePointf: function(pos) {
		var x = $bind(this,this.x), y = this.getY1(pos);
		return function(dp,i) {
			return "translate(" + Math.round(x(dp)) + "," + Math.round(y(dp,i)) + ")";
		};
	}
	,redraw: function() {
		var _g2 = this;
		if(null == this.dps || null == this.dps[0] || null == this.dps[0][0]) return;
		var axisgroup = this.chart.selectAll("g.group").data(this.dps);
		var axisenter = axisgroup.enter().append("svg:g").attr("class").stringf(function(_,i) {
			return "group group-" + i;
		});
		axisgroup.exit().remove();
		var _g1 = 0, _g = this.dps.length;
		while(_g1 < _g) {
			var i1 = [_g1++];
			var data = this.dps[i1[0]], gi = this.chart.select("g.group-" + i1[0]), stats = [this.yVariables[i1[0]].stats];
			var gsymbol = gi.selectAll("g.symbol").data(data), vars = this.yVariables, onclick = ((function() {
				return function(f,a1) {
					return (function() {
						return function(dp,i) {
							return f(a1,dp,i);
						};
					})();
				};
			})())($bind(this,this.onclick),stats[0]), onmouseover = ((function() {
				return function(f1,a11) {
					return (function() {
						return function(n,i) {
							return f1(a11,n,i);
						};
					})();
				};
			})())($bind(this,this.onmouseover),stats[0]);
			var enter = gsymbol.enter().append("svg:g").attr("class").stringf(this.classf(i1[0],"symbol")).attr("transform").stringf(this.getTranslatePointf(i1[0]));
			if(null != this.click) enter.on("click",onclick);
			if(null != this.labelDataPointOver) enter.onNode("mouseover",onmouseover);
			rg.svg.util.SVGSymbolBuilder.generate(enter,stats[0],this.symbol,this.symbolStyle);
			if(null != this.labelDataPoint) {
				var label_group = [this.chart.append("svg:g").attr("class").string("datapoint-labels")];
				enter.eachNode((function(label_group,stats,i1) {
					return function(n,j) {
						var dp = Reflect.field(n,"__dhx_data__");
						rg.svg.util.PointLabel.label(label_group[0],_g2.labelDataPoint(dp,stats[0]),_g2.x(dp),(_g2.getY1(i1[0]))(dp,j) - _g2.labelDataPointVerticalOffset,_g2.labelDataPointShadow,_g2.labelDataPointOutline);
					};
				})(label_group,stats,i1));
			}
			gsymbol.update().selectAll("g.symbol").dataf((function() {
				return function(d,i) {
					return d;
				};
			})()).update().attr("transform").stringf(this.getTranslatePointf(i1[0]));
			gsymbol.exit().remove();
		}
		this.ready.dispatch();
	}
	,resize: function() {
		rg.svg.chart.CartesianChart.prototype.resize.call(this);
		this.redraw();
	}
	,data: function(dps) {
		this.dps = dps;
		this.redraw();
	}
	,classf: function(pos,cls) {
		return function(_,i) {
			return cls + " stroke-" + pos + " fill-" + pos;
		};
	}
	,getY1: function(pos) {
		var h = this.height, v = this.yVariables[pos];
		return function(d,i) {
			var value = Reflect.field(d,v.type), scaled = v.axis.scale(v.min(),v.max(),value), scaledh = scaled * h;
			return h - scaledh;
		};
	}
	,x: function(d,i) {
		var value = Reflect.field(d,this.xVariable.type), scaled = this.xVariable.axis.scale(this.xVariable.min(),this.xVariable.max(),value), scaledw = scaled * this.width;
		return scaledw;
	}
	,dps: null
	,chart: null
	,symbolStyle: null
	,symbol: null
	,__class__: rg.svg.chart.ScatterGraph
});
rg.svg.chart.StreamEffect = { __ename__ : ["rg","svg","chart","StreamEffect"], __constructs__ : ["NoEffect","GradientHorizontal","GradientVertical"] }
rg.svg.chart.StreamEffect.NoEffect = ["NoEffect",0];
rg.svg.chart.StreamEffect.NoEffect.toString = $estr;
rg.svg.chart.StreamEffect.NoEffect.__enum__ = rg.svg.chart.StreamEffect;
rg.svg.chart.StreamEffect.GradientHorizontal = function(lightness) { var $x = ["GradientHorizontal",1,lightness]; $x.__enum__ = rg.svg.chart.StreamEffect; $x.toString = $estr; return $x; }
rg.svg.chart.StreamEffect.GradientVertical = function(lightness) { var $x = ["GradientVertical",2,lightness]; $x.__enum__ = rg.svg.chart.StreamEffect; $x.toString = $estr; return $x; }
rg.svg.chart.StreamEffects = function() { }
$hxClasses["rg.svg.chart.StreamEffects"] = rg.svg.chart.StreamEffects;
rg.svg.chart.StreamEffects.__name__ = ["rg","svg","chart","StreamEffects"];
rg.svg.chart.StreamEffects.getLightness = function(p,alt) {
	if(null == p) return alt; else return Std.parseFloat(p);
}
rg.svg.chart.StreamEffects.parse = function(s) {
	var parts = s.toLowerCase().split(":");
	var _g = parts.shift();
	switch(_g) {
	case "gradient":case "gradientv":case "gradientvert":case "gradientvertical":
		return rg.svg.chart.StreamEffect.GradientVertical(rg.svg.chart.StreamEffects.getLightness(parts.pop(),0.75));
	case "gradienth":case "gradienthoriz":case "gradienthorizontal":
		return rg.svg.chart.StreamEffect.GradientHorizontal(rg.svg.chart.StreamEffects.getLightness(parts.pop(),0.75));
	default:
		return rg.svg.chart.StreamEffect.NoEffect;
	}
}
rg.svg.chart.StreamGraph = function(panel) {
	rg.svg.chart.CartesianChart.call(this,panel);
	this.interpolator = thx.svg.LineInterpolator.Cardinal(0.6);
	this.gradientLightness = 0.75;
	this.gradientStyle = 1;
};
$hxClasses["rg.svg.chart.StreamGraph"] = rg.svg.chart.StreamGraph;
rg.svg.chart.StreamGraph.__name__ = ["rg","svg","chart","StreamGraph"];
rg.svg.chart.StreamGraph.__super__ = rg.svg.chart.CartesianChart;
rg.svg.chart.StreamGraph.prototype = $extend(rg.svg.chart.CartesianChart.prototype,{
	applyGradientH: function(d,i) {
		var gn = dhx.Dom.selectNode(dhx.Group.current), color = thx.color.Hsl.toHsl(rg.util.RGColors.parse(gn.style("fill").get(),"#cccccc")), id = "rg_stream_gradient_v_" + rg.svg.chart.StreamGraph.vid++;
		var gradient = this.defs.append("svg:linearGradient").attr("gradientUnits").string("objectBoundingBox").attr("class").string("x").attr("id").string(id).attr("x1").string("0%").attr("x2").string("100%").attr("y1").string("0%").attr("y2").string("0%");
		var bx = d[0].coord.x, ax = d[d.length - 1].coord.x, span = ax - bx, percent = function(x) {
			return Math.round((x - bx) / span * 10000) / 100;
		}, max = Arrays.floatMax(d,function(d1) {
			return d1.coord.y;
		});
		var _g1 = 0, _g = d.length;
		while(_g1 < _g) {
			var i1 = _g1++;
			var dp = d[i1], v = dp.coord.y / max;
			var gcolor = rg.util.RGColors.applyLightness(color,this.gradientLightness,v);
			gradient.append("svg:stop").attr("offset").string(percent(dp.coord.x) + "%").attr("stop-color").string(gcolor.hex("#")).attr("stop-opacity")["float"](1);
		}
		gn.attr("style").string("fill:url(#" + id + ")");
	}
	,applyGradientV: function(d,i) {
		var gn = dhx.Dom.selectNode(dhx.Group.current), color = rg.util.RGColors.parse(gn.style("fill").get(),"#cccccc"), id = "rg_stream_gradient_h_" + color.hex("");
		if(this.defs.select("#" + id).empty()) {
			var scolor = rg.util.RGColors.applyLightness(thx.color.Hsl.toHsl(color),this.gradientLightness).toRgbString();
			var gradient = this.defs.append("svg:linearGradient").attr("gradientUnits").string("objectBoundingBox").attr("id").string(id).attr("x1").string("0%").attr("x2").string("0%").attr("y1").string("100%").attr("y2").string("0%").attr("spreadMethod").string("pad");
			gradient.append("svg:stop").attr("offset").string("0%").attr("stop-color").string(scolor).attr("stop-opacity")["float"](1);
			gradient.append("svg:stop").attr("offset").string("100%").attr("stop-color").string(color.toRgbString()).attr("stop-opacity")["float"](1);
		}
		gn.attr("style").string("fill:url(#" + id + ")");
	}
	,prepareData: function() {
		var _g = this;
		this.defs.selectAll("linearGradient.h").remove();
		var xscale = (function(f,a1,a2) {
			return function(v) {
				return f(a1,a2,v);
			};
		})(($_=this.xVariable.axis,$bind($_,$_.scale)),this.xVariable.min(),this.xVariable.max()), xtype = this.xVariable.type, x = function(d) {
			return xscale(Reflect.field(d,xtype));
		}, yscale = (function(f1,a11,a21) {
			return function(v) {
				return f1(a11,a21,v);
			};
		})(($_=this.yVariables[0].axis,$bind($_,$_.scale)),this.yVariables[0].min(),this.yVariables[0].max()), ytype = this.yVariables[0].type, y = function(d) {
			return yscale(Reflect.field(d,ytype));
		}, m = Arrays.floatMax(this.dps,function(d) {
			return d.length;
		}) | 0;
		var altDp = function(pos) {
			var _g2 = 0, _g1 = _g.dps.length;
			while(_g2 < _g1) {
				var i = _g2++;
				if(null != _g.dps[i][pos]) return _g.dps[i][pos];
			}
			return null;
		};
		var coords = Iterators.map(HxOverrides.iter(this.dps),function(d1,j) {
			return Iterators.map(HxOverrides.iter(Ints.range(0,m)),function(_,i) {
				var dp = d1[i];
				if(null == dp) return { x : x(altDp(i)), y : .0};
				return { x : x(dp), y : Math.max(0,y(dp))};
			});
		});
		var data = new thx.geom.layout.Stack().offset(thx.geom.layout.StackOffset.Silhouette).order(thx.geom.layout.StackOrder.DefaultOrder).stack(coords);
		this.transformedData = Iterators.map(HxOverrides.iter(data),function(d,i1) {
			return Iterators.map(HxOverrides.iter(d),function(d1,j) {
				return { coord : d1, dp : _g.dps[i1][j]};
			});
		});
		this.stats = this.yVariables[0].stats;
		this.maxy = Arrays.floatMax(data,function(d) {
			return Arrays.floatMax(d,function(d1) {
				return d1.y0 + d1.y;
			});
		});
		this.area = new thx.svg.Area().interpolator(this.interpolator).x(function(d,i) {
			return d.coord.x * _g.width;
		}).y0(function(d,i) {
			return _g.height - d.coord.y0 * _g.height / _g.maxy;
		}).y1(function(d,i) {
			return _g.height - (d.coord.y + d.coord.y0) * _g.height / _g.maxy;
		});
	}
	,onclick: function(n,i) {
		if(null == this.click) return;
		var dp = this.getDataAtNode(n,i);
		this.click(dp.dp,this.stats);
	}
	,onover: function(n,i) {
		if(null == this.labelDataPointOver) return;
		var dp = this.getDataAtNode(n,i);
		this.tooltip.html(this.labelDataPointOver(dp.dp,this.stats).split("\n").join("<br>"));
		this.moveTooltip(dp.coord.x * this.width,this.height - (dp.coord.y + dp.coord.y0) * this.height / this.maxy,rg.util.RGColors.extractColor(n));
	}
	,getDataAtNode: function(n,i) {
		var px = dhx.Svg.mouse(n)[0], x = (Floats.uninterpolatef(this.transformedData[i][0].coord.x,Arrays.last(this.transformedData[i]).coord.x))(px / this.width);
		var data = Reflect.field(n,"__dhx_data__");
		return Arrays.nearest(this.transformedData[i],x,function(d) {
			return d.coord.x;
		});
	}
	,redraw: function() {
		if(null == this.transformedData) return;
		var layer = this.g.selectAll("g.group").data(this.transformedData);
		layer.update().select("path.line").attr("d").stringf(($_=this.area,$bind($_,$_.shape)));
		var g = layer.enter().append("svg:g").attr("class").string("group");
		var path = g.append("svg:path").attr("class").stringf(function(d,i) {
			return "line fill-" + i + " stroke-" + i;
		}).attr("d").stringf(($_=this.area,$bind($_,$_.shape))).onNode("mousemove",$bind(this,this.onover)).onNode("click",$bind(this,this.onclick));
		rg.util.RGColors.storeColorForSelection(path);
		if(this.gradientStyle != 0) path.each(this.gradientStyle == 1?$bind(this,this.applyGradientV):$bind(this,this.applyGradientH));
		layer.exit().remove();
		this.ready.dispatch();
	}
	,data: function(dps) {
		this.dps = dps;
		this.prepareData();
		this.redraw();
	}
	,setVariables: function(variables,variableIndependents,variableDependents,data) {
		rg.svg.chart.CartesianChart.prototype.setVariables.call(this,variables,variableIndependents,variableDependents,data);
	}
	,init: function() {
		rg.svg.chart.CartesianChart.prototype.init.call(this);
		this.defs = this.g.append("svg:defs");
		this.g.classed().add("stream-chart");
	}
	,maxy: null
	,defs: null
	,stats: null
	,transformedData: null
	,area: null
	,dps: null
	,gradientStyle: null
	,gradientLightness: null
	,interpolator: null
	,__class__: rg.svg.chart.StreamGraph
});
rg.svg.layer = {}
rg.svg.layer.RulesOrtho = function(panel,orientation) {
	rg.svg.panel.Layer.call(this,panel);
	this.orientation = orientation;
	this.displayMinor = true;
	this.displayMajor = true;
	this.displayAnchorLine = true;
	this.g.classed().add("tickmarks");
};
$hxClasses["rg.svg.layer.RulesOrtho"] = rg.svg.layer.RulesOrtho;
rg.svg.layer.RulesOrtho.__name__ = ["rg","svg","layer","RulesOrtho"];
rg.svg.layer.RulesOrtho.__super__ = rg.svg.panel.Layer;
rg.svg.layer.RulesOrtho.prototype = $extend(rg.svg.panel.Layer.prototype,{
	tickClass: function(d,i) {
		return d.get_major()?"major":null;
	}
	,y2Vertical: function(d,i) {
		return this.height;
	}
	,y2Horizontal: function(d,i) {
		return 0;
	}
	,x2Vertical: function(d,i) {
		return 0;
	}
	,x2Horizontal: function(d,i) {
		return this.width;
	}
	,y1Vertical: function(d,i) {
		return 0;
	}
	,y1Horizontal: function(d,i) {
		return 0;
	}
	,x1Vertical: function(d,i) {
		return 0;
	}
	,x1Horizontal: function(d,i) {
		return 0;
	}
	,translateVertical: function(d,i) {
		return "translate(" + d.get_delta() * this.width + "," + 0 + ")";
	}
	,translateHorizontal: function(d,i) {
		return "translate(" + 0 + "," + (this.height - d.get_delta() * this.height) + ")";
	}
	,init: function() {
		this.initf();
		if(this.displayAnchorLine) {
			this.g.append("svg:line").attr("class").string("anchor-line");
			this.updateAnchorLine();
		}
	}
	,initf: function() {
		var _g = this;
		switch( (_g.orientation)[1] ) {
		case 1:
			this.translate = $bind(this,this.translateHorizontal);
			this.x1 = $bind(this,this.x1Horizontal);
			this.y1 = $bind(this,this.y1Horizontal);
			this.x2 = $bind(this,this.x2Horizontal);
			this.y2 = $bind(this,this.y2Horizontal);
			break;
		case 0:
			this.translate = $bind(this,this.translateVertical);
			this.x1 = $bind(this,this.x1Vertical);
			this.y1 = $bind(this,this.y1Vertical);
			this.x2 = $bind(this,this.x2Vertical);
			this.y2 = $bind(this,this.y2Vertical);
			break;
		}
	}
	,redraw: function() {
		var ticks = this.maxTicks(), data = this.axis.ticks(this.min,this.max,ticks);
		var rule = this.g.selectAll("g.rule").data(data,$bind(this,this.id));
		var enter = rule.enter().append("svg:g").attr("class").string("rule").attr("transform").stringf(this.translate);
		if(this.displayMinor) enter.filter(function(d,i) {
			return !d.major;
		}).append("svg:line").attr("x1").floatf(this.x1).attr("y1").floatf(this.y1).attr("x2").floatf(this.x2).attr("y2").floatf(this.y2).attr("class").stringf($bind(this,this.tickClass));
		if(this.displayMajor) enter.filter(function(d,i) {
			return d.major;
		}).append("svg:line").attr("x1").floatf(this.x1).attr("y1").floatf(this.y1).attr("x2").floatf(this.x2).attr("y2").floatf(this.y2).attr("class").stringf($bind(this,this.tickClass));
		rule.update().attr("transform").stringf(this.translate);
		rule.exit().remove();
	}
	,id: function(d,i) {
		return "" + Std.string(d.get_value());
	}
	,maxTicks: function() {
		var size = (function($this) {
			var $r;
			var _g = $this;
			$r = (function($this) {
				var $r;
				switch( (_g.orientation)[1] ) {
				case 1:
					$r = $this.width;
					break;
				case 0:
					$r = $this.height;
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this));
		return Math.round(size / 2.5);
	}
	,updateAnchorLine: function() {
		var line = this.g.select("line.anchor-line");
		var _g = this;
		switch( (_g.orientation)[1] ) {
		case 1:
			line.attr("x1")["float"](0).attr("y1")["float"](0).attr("x2")["float"](0).attr("y2")["float"](this.height);
			break;
		case 0:
			line.attr("x1")["float"](0).attr("y1")["float"](this.height).attr("x2")["float"](this.width).attr("y2")["float"](this.height);
			break;
		}
	}
	,update: function(axis,min,max) {
		this.axis = axis;
		this.min = min;
		this.max = max;
		this.redraw();
	}
	,resize: function() {
		if(null == this.axis) return;
		if(this.displayAnchorLine) this.updateAnchorLine();
		this.redraw();
	}
	,max: null
	,min: null
	,axis: null
	,y2: null
	,x2: null
	,y1: null
	,x1: null
	,translate: null
	,displayAnchorLine: null
	,displayMajor: null
	,displayMinor: null
	,orientation: null
	,__class__: rg.svg.layer.RulesOrtho
});
rg.svg.layer.TickmarksOrtho = function(panel,anchor) {
	rg.svg.panel.Layer.call(this,panel);
	this.anchor = anchor;
	this.displayMinor = true;
	this.displayMajor = true;
	this.displayLabel = true;
	this.displayAnchorLine = false;
	this.lengthMinor = 2;
	this.lengthMajor = 5;
	this.paddingMinor = 1;
	this.paddingMajor = 1;
	this.paddingLabel = 10;
	this.g.classed().add("tickmarks");
};
$hxClasses["rg.svg.layer.TickmarksOrtho"] = rg.svg.layer.TickmarksOrtho;
rg.svg.layer.TickmarksOrtho.__name__ = ["rg","svg","layer","TickmarksOrtho"];
rg.svg.layer.TickmarksOrtho.__super__ = rg.svg.panel.Layer;
rg.svg.layer.TickmarksOrtho.prototype = $extend(rg.svg.panel.Layer.prototype,{
	tickClass: function(d,i) {
		return d.get_major()?"major":null;
	}
	,y2Right: function(d,i) {
		return 0;
	}
	,y2Left: function(d,i) {
		return 0;
	}
	,y2Bottom: function(d,i) {
		return -(d.get_major()?this.lengthMajor + this.paddingMajor:this.lengthMinor + this.paddingMinor);
	}
	,y2Top: function(d,i) {
		return d.get_major()?this.lengthMajor + this.paddingMajor:this.lengthMinor + this.paddingMinor;
	}
	,x2Right: function(d,i) {
		return -(d.get_major()?this.lengthMajor + this.paddingMajor:this.lengthMinor + this.paddingMinor);
	}
	,x2Left: function(d,i) {
		return d.get_major()?this.lengthMajor + this.paddingMajor:this.lengthMinor + this.paddingMinor;
	}
	,x2Bottom: function(d,i) {
		return 0;
	}
	,x2Top: function(d,i) {
		return 0;
	}
	,y1Right: function(d,i) {
		return 0;
	}
	,y1Left: function(d,i) {
		return 0;
	}
	,y1Bottom: function(d,i) {
		return -(d.get_major()?this.paddingMajor:this.paddingMinor);
	}
	,y1Top: function(d,i) {
		return d.get_major()?this.paddingMajor:this.paddingMinor;
	}
	,x1Right: function(d,i) {
		return -(d.get_major()?this.paddingMajor:this.paddingMinor);
	}
	,x1Left: function(d,i) {
		return d.get_major()?this.paddingMajor:this.paddingMinor;
	}
	,x1Bottom: function(d,i) {
		return 0;
	}
	,x1Top: function(d,i) {
		return 0;
	}
	,translateRight: function(d,i) {
		return "translate(" + this.panel.frame.width + "," + (this.panel.frame.height - d.get_delta() * this.panel.frame.height) + ")";
	}
	,translateLeft: function(d,i) {
		return "translate(" + 0 + "," + (this.panel.frame.height - d.get_delta() * this.panel.frame.height) + ")";
	}
	,translateBottom: function(d,i) {
		return "translate(" + d.get_delta() * this.panel.frame.width + "," + this.panel.frame.height + ")";
	}
	,translateTop: function(d,i) {
		return "translate(" + d.get_delta() * this.panel.frame.width + "," + 0 + ")";
	}
	,init: function() {
		this.initf();
		if(this.displayAnchorLine) {
			this.g.append("svg:line").attr("class").string("anchor-line");
			this.updateAnchorLine();
		}
	}
	,initf: function() {
		var _g = this;
		switch( (_g.anchor)[1] ) {
		case 0:
			this.translate = $bind(this,this.translateTop);
			this.x1 = $bind(this,this.x1Top);
			this.y1 = $bind(this,this.y1Top);
			this.x2 = $bind(this,this.x2Top);
			this.y2 = $bind(this,this.y2Top);
			break;
		case 1:
			this.translate = $bind(this,this.translateBottom);
			this.x1 = $bind(this,this.x1Bottom);
			this.y1 = $bind(this,this.y1Bottom);
			this.x2 = $bind(this,this.x2Bottom);
			this.y2 = $bind(this,this.y2Bottom);
			break;
		case 2:
			this.translate = $bind(this,this.translateLeft);
			this.x1 = $bind(this,this.x1Left);
			this.y1 = $bind(this,this.y1Left);
			this.x2 = $bind(this,this.x2Left);
			this.y2 = $bind(this,this.y2Left);
			break;
		case 3:
			this.translate = $bind(this,this.translateRight);
			this.x1 = $bind(this,this.x1Right);
			this.y1 = $bind(this,this.y1Right);
			this.x2 = $bind(this,this.x2Right);
			this.y2 = $bind(this,this.y2Right);
			break;
		}
		if(null == this.labelOrientation) {
			var _g1 = this;
			switch( (_g1.anchor)[1] ) {
			case 0:
			case 1:
				this.labelOrientation = rg.svg.widget.LabelOrientation.Orthogonal;
				break;
			case 2:
			case 3:
				this.labelOrientation = rg.svg.widget.LabelOrientation.Aligned;
				break;
			}
		} else if(null == this.labelAnchor) {
			var _g1 = this;
			switch( (_g1.labelOrientation)[1] ) {
			case 1:
				var _g2 = this;
				switch( (_g2.anchor)[1] ) {
				case 0:
				case 2:
					this.labelAnchor = rg.svg.widget.GridAnchor.Left;
					break;
				case 1:
				case 3:
					this.labelAnchor = rg.svg.widget.GridAnchor.Right;
					break;
				}
				break;
			case 2:
				var _g2 = this;
				switch( (_g2.anchor)[1] ) {
				case 0:
				case 2:
					this.labelAnchor = rg.svg.widget.GridAnchor.Top;
					break;
				case 1:
				case 3:
					this.labelAnchor = rg.svg.widget.GridAnchor.Bottom;
					break;
				}
				break;
			case 0:
				break;
			}
		}
		if(null == this.labelAnchor) {
			var _g1 = this;
			switch( (_g1.anchor)[1] ) {
			case 0:
				this.labelAnchor = rg.svg.widget.GridAnchor.Top;
				break;
			case 1:
				this.labelAnchor = rg.svg.widget.GridAnchor.Bottom;
				break;
			case 2:
				this.labelAnchor = rg.svg.widget.GridAnchor.Left;
				break;
			case 3:
				this.labelAnchor = rg.svg.widget.GridAnchor.Right;
				break;
			}
		}
		if(null == this.labelAngle) {
			var _g1 = this;
			switch( (_g1.anchor)[1] ) {
			case 0:
				this.labelAngle = 90;
				break;
			case 1:
				this.labelAngle = 90;
				break;
			case 2:
				this.labelAngle = 0;
				break;
			case 3:
				this.labelAngle = 0;
				break;
			}
		}
	}
	,createLabel: function(n,i) {
		var d = Reflect.field(n,"__dhx_data__");
		if(!d.get_major()) return;
		var label = new rg.svg.widget.Label(dhx.Dom.selectNode(n),false,false,false);
		label.set_anchor(this.labelAnchor);
		label.set_orientation(this.labelOrientation);
		var padding = this.paddingLabel;
		label.set_text(null == this.tickLabel?d.get_label():this.tickLabel(d.get_value()));
		var _g = this;
		switch( (_g.anchor)[1] ) {
		case 0:
			label.place(0,padding,this.labelAngle);
			break;
		case 1:
			label.place(0,-padding,this.labelAngle);
			break;
		case 2:
			label.place(padding,0,this.labelAngle);
			break;
		case 3:
			label.place(-padding,0,this.labelAngle);
			break;
		}
		var s = (function($this) {
			var $r;
			var _g1 = $this;
			$r = (function($this) {
				var $r;
				switch( (_g1.anchor)[1] ) {
				case 0:
				case 1:
					$r = label.getSize().height + padding;
					break;
				case 2:
				case 3:
					$r = label.getSize().width + padding;
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this));
		if(s > this.desiredSize) this.desiredSize = s;
	}
	,redraw: function() {
		this.desiredSize = Math.max(this.paddingMinor + this.lengthMinor,this.paddingMajor + this.lengthMajor);
		var ticks = this.maxTicks(), data = this.axis.ticks(this.min,this.max,ticks);
		var tick = this.g.selectAll("g.tick").data(data,$bind(this,this.id));
		var enter = tick.enter().append("svg:g").attr("class").string("tick").attr("transform").stringf(this.translate);
		if(this.displayMinor) enter.filter(function(d,i) {
			return !d.major;
		}).append("svg:line").attr("x1").floatf(this.x1).attr("y1").floatf(this.y1).attr("x2").floatf(this.x2).attr("y2").floatf(this.y2).attr("class").stringf($bind(this,this.tickClass));
		if(this.displayMajor) enter.filter(function(d,i) {
			return d.major;
		}).append("svg:line").attr("x1").floatf(this.x1).attr("y1").floatf(this.y1).attr("x2").floatf(this.x2).attr("y2").floatf(this.y2).attr("class").stringf($bind(this,this.tickClass));
		if(this.displayLabel) enter.eachNode($bind(this,this.createLabel));
		tick.update().attr("transform").stringf(this.translate);
		tick.exit().remove();
	}
	,id: function(d,i) {
		return "" + Std.string(d.get_value());
	}
	,maxTicks: function() {
		var size = (function($this) {
			var $r;
			var _g = $this;
			$r = (function($this) {
				var $r;
				switch( (_g.anchor)[1] ) {
				case 2:
				case 3:
					$r = $this.height;
					break;
				case 0:
				case 1:
					$r = $this.width;
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this));
		return Math.round(size / 2.5);
	}
	,updateAnchorLine: function() {
		var line = this.g.select("line.anchor-line");
		var _g = this;
		switch( (_g.anchor)[1] ) {
		case 0:
			line.attr("x1")["float"](0).attr("y1")["float"](0).attr("x2")["float"](this.panel.frame.width).attr("y2")["float"](0);
			break;
		case 1:
			line.attr("x1")["float"](0).attr("y1")["float"](this.panel.frame.height).attr("x2")["float"](this.panel.frame.width).attr("y2")["float"](this.panel.frame.height);
			break;
		case 2:
			line.attr("x1")["float"](0).attr("y1")["float"](0).attr("x2")["float"](0).attr("y2")["float"](this.panel.frame.height);
			break;
		case 3:
			line.attr("x1")["float"](this.panel.frame.width).attr("y1")["float"](0).attr("x2")["float"](this.panel.frame.width).attr("y2")["float"](this.panel.frame.height);
			break;
		}
	}
	,update: function(axis,min,max) {
		this.axis = axis;
		this.min = min;
		this.max = max;
		this.redraw();
	}
	,resize: function() {
		if(null == this.axis) return;
		if(this.displayAnchorLine) this.updateAnchorLine();
		this.redraw();
	}
	,max: null
	,min: null
	,axis: null
	,y2: null
	,x2: null
	,y1: null
	,x1: null
	,translate: null
	,tickLabel: null
	,desiredSize: null
	,labelAngle: null
	,labelAnchor: null
	,labelOrientation: null
	,paddingLabel: null
	,paddingMajor: null
	,paddingMinor: null
	,lengthMajor: null
	,lengthMinor: null
	,displayAnchorLine: null
	,displayLabel: null
	,displayMajor: null
	,displayMinor: null
	,anchor: null
	,__class__: rg.svg.layer.TickmarksOrtho
});
rg.svg.layer.Title = function(panel,text,anchor,padding,className,shadow,outline) {
	if(outline == null) outline = false;
	if(shadow == null) shadow = false;
	if(className == null) className = "title";
	if(padding == null) padding = 1;
	rg.svg.panel.Layer.call(this,panel);
	this.addClass(className);
	this.group = this.g.append("svg:g");
	this.label = new rg.svg.widget.Label(this.group,false,shadow,outline);
	this.label.set_orientation(rg.svg.widget.LabelOrientation.Orthogonal);
	this.set_anchor(anchor);
	this.set_padding(padding);
	this.set_text(text);
	this.resize();
};
$hxClasses["rg.svg.layer.Title"] = rg.svg.layer.Title;
rg.svg.layer.Title.__name__ = ["rg","svg","layer","Title"];
rg.svg.layer.Title.__super__ = rg.svg.panel.Layer;
rg.svg.layer.Title.prototype = $extend(rg.svg.panel.Layer.prototype,{
	set_padding: function(v) {
		this.padding = v;
		var _g = this;
		switch( (_g.anchor)[1] ) {
		case 0:
			this.label.place(0,0,90);
			break;
		case 1:
			this.label.place(0,0,90);
			break;
		case 2:
			this.label.place(0,0,180);
			break;
		case 3:
			this.label.place(0,0,0);
			break;
		}
		return v;
	}
	,set_anchor: function(v) {
		var _g = this.anchor = v;
		switch( (_g)[1] ) {
		case 0:
			this.label.set_anchor(rg.svg.widget.GridAnchor.Top);
			break;
		case 1:
			this.label.set_anchor(rg.svg.widget.GridAnchor.Bottom);
			break;
		case 2:
			this.label.set_anchor(rg.svg.widget.GridAnchor.Bottom);
			break;
		case 3:
			this.label.set_anchor(rg.svg.widget.GridAnchor.Bottom);
			break;
		}
		return v;
	}
	,set_text: function(v) {
		return this.label.set_text(v);
	}
	,resize: function() {
		if(null == this.anchor || null == this.width || this.padding == null) return;
		var _g = this;
		switch( (_g.anchor)[1] ) {
		case 0:
			this.group.attr("transform").string("translate(" + this.width / 2 + "," + this.padding + ")");
			break;
		case 3:
			this.group.attr("transform").string("translate(" + (this.width - this.padding) + "," + this.height / 2 + ")");
			break;
		case 2:
			this.group.attr("transform").string("translate(" + this.padding + "," + this.height / 2 + ")");
			break;
		case 1:
			this.group.attr("transform").string("translate(" + this.width / 2 + "," + (this.height - this.padding) + ")");
			break;
		}
	}
	,idealHeight: function() {
		var size = this.label.getSize();
		return Math.round((function($this) {
			var $r;
			var _g = $this;
			$r = (function($this) {
				var $r;
				switch( (_g.anchor)[1] ) {
				case 2:
				case 3:
					$r = size.width + $this.padding;
					break;
				case 0:
				case 1:
					$r = size.height + $this.padding;
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this)));
	}
	,group: null
	,label: null
	,padding: null
	,anchor: null
	,__class__: rg.svg.layer.Title
});
rg.svg.panel.Panel = function(frame) {
	this.frame = frame;
	frame.change = $bind(this,this.reframe);
	this._layers = [];
};
$hxClasses["rg.svg.panel.Panel"] = rg.svg.panel.Panel;
rg.svg.panel.Panel.__name__ = ["rg","svg","panel","Panel"];
rg.svg.panel.Panel.prototype = {
	reframe: function() {
		this.g.attr("transform").string("translate(" + this.frame.x + "," + this.frame.y + ")");
		var layer;
		var _g1 = 0, _g = this._layers.length;
		while(_g1 < _g) {
			var i = _g1++;
			layer = this._layers[i];
			layer._resize();
		}
	}
	,init: function(container) {
		this.g = container.append("svg:g").attr("class").string("panel").attr("transform").string("translate(" + this.frame.x + "," + this.frame.y + ")");
	}
	,setParent: function(container) {
		if(null != this.g) this.g.remove();
		this.parent = container;
		if(null == container) return;
		this.init(container.g);
	}
	,removeLayer: function(layer) {
		HxOverrides.remove(this._layers,layer);
	}
	,addLayer: function(layer) {
		HxOverrides.remove(this._layers,layer);
		this._layers.push(layer);
	}
	,_layers: null
	,parent: null
	,g: null
	,frame: null
	,__class__: rg.svg.panel.Panel
}
rg.svg.panel.Container = function(frame,orientation) {
	rg.svg.panel.Panel.call(this,frame);
	this.stack = new rg.frame.Stack(frame.width,frame.height,orientation);
	this.panels = [];
};
$hxClasses["rg.svg.panel.Container"] = rg.svg.panel.Container;
rg.svg.panel.Container.__name__ = ["rg","svg","panel","Container"];
rg.svg.panel.Container.__super__ = rg.svg.panel.Panel;
rg.svg.panel.Container.prototype = $extend(rg.svg.panel.Panel.prototype,{
	reframe: function() {
		rg.svg.panel.Panel.prototype.reframe.call(this);
		this.stack.setSize(this.frame.width,this.frame.height);
		this.stack.reflow();
	}
	,createContainerAt: function(pos,layout,orientation) {
		var panel = new rg.svg.panel.Container(new rg.frame.StackItem(layout),orientation);
		this.insertPanel(pos,panel);
		return panel;
	}
	,createPanelAt: function(pos,layout) {
		var panel = new rg.svg.panel.Panel(new rg.frame.StackItem(layout));
		this.insertPanel(pos,panel);
		return panel;
	}
	,createContainer: function(layout,orientation) {
		var panel = new rg.svg.panel.Container(new rg.frame.StackItem(layout),orientation);
		this.addPanel(panel);
		return panel;
	}
	,createPanel: function(layout) {
		var panel = new rg.svg.panel.Panel(new rg.frame.StackItem(layout));
		this.addPanel(panel);
		return panel;
	}
	,removePanel: function(panel) {
		if(!HxOverrides.remove(this.panels,panel)) return this;
		this.stack.removeChild(js.Boot.__cast(panel.frame , rg.frame.StackItem));
		var f = panel;
		f.setParent(null);
		return this;
	}
	,addPanels: function(it) {
		var frames = [];
		var $it0 = $iterator(it)();
		while( $it0.hasNext() ) {
			var panel = $it0.next();
			if(null == panel) continue;
			if(null != panel.parent) panel.parent.removePanel(panel);
			this.panels.push(panel);
			var f = panel;
			f.setParent(this);
			frames.push(js.Boot.__cast(panel.frame , rg.frame.StackItem));
		}
		this.stack.addItems(frames);
		return this;
	}
	,addPanel: function(panel) {
		return this.addPanels([panel]);
	}
	,insertPanel: function(pos,panel) {
		if(null == panel) return this;
		if(pos >= this.stack.get_length()) return this.addPanel(panel); else if(pos < 0) pos = 0;
		if(null != panel.parent) panel.parent.removePanel(panel);
		this.panels.splice(pos,0,panel);
		var f = panel;
		f.setParent(this);
		this.stack.insertItem(pos,js.Boot.__cast(panel.frame , rg.frame.StackItem));
		return this;
	}
	,panels: null
	,stack: null
	,__class__: rg.svg.panel.Container
});
rg.svg.panel.Panels = function() { }
$hxClasses["rg.svg.panel.Panels"] = rg.svg.panel.Panels;
rg.svg.panel.Panels.__name__ = ["rg","svg","panel","Panels"];
rg.svg.panel.Panels.absolutePos = function(panel) {
	var p = panel, x = 0, y = 0;
	while(null != p) {
		panel = p;
		x += p.frame.x;
		y += p.frame.y;
		p = p.parent;
	}
	var node = rg.svg.panel.Panels.htmlContainer(panel), left = js.Scroll.getLeft(), top = js.Scroll.getTop();
	if(null == node) return { x : left, y : top};
	var rect = node.getBoundingClientRect();
	return { x : rect.left + x + left, y : rect.top + y + top};
}
rg.svg.panel.Panels.svgContainer = function(panel) {
	var node = panel.g.node();
	do node = node.ownerSVGElement; while(null != node && null != Reflect.field(node.ownerSVGElement,"ownerSVGElement"));
	return null == node?null:node;
}
rg.svg.panel.Panels.htmlContainer = function(panel) {
	var svg = rg.svg.panel.Panels.svgContainer(panel);
	if(null == svg) return null; else return svg.parentNode;
}
rg.svg.panel.Space = function(width,height,domcontainer) {
	this.panel = new rg.frame.StackItem(rg.frame.FrameLayout.Fill(0,0));
	rg.svg.panel.Container.call(this,this.panel,rg.frame.Orientation.Vertical);
	this.init(this.svg = domcontainer.append("svg:svg").attr("xmlns").string("http://www.w3.org/2000/svg"));
	this.resize(width,height);
};
$hxClasses["rg.svg.panel.Space"] = rg.svg.panel.Space;
rg.svg.panel.Space.__name__ = ["rg","svg","panel","Space"];
rg.svg.panel.Space.__super__ = rg.svg.panel.Container;
rg.svg.panel.Space.prototype = $extend(rg.svg.panel.Container.prototype,{
	resize: function(width,height) {
		if(this.panel.width == width && this.panel.height == height) return;
		this.svg.attr("width")["float"](width).attr("height")["float"](height);
		var sf = this.panel;
		sf.set_layout(0,0,width,height);
	}
	,svg: null
	,panel: null
	,__class__: rg.svg.panel.Space
});
rg.svg.util = {}
rg.svg.util.PointLabel = function() { }
$hxClasses["rg.svg.util.PointLabel"] = rg.svg.util.PointLabel;
rg.svg.util.PointLabel.__name__ = ["rg","svg","util","PointLabel"];
rg.svg.util.PointLabel.label = function(container,text,x,y,shadow,outline) {
	if(null == text) return null;
	var label = new rg.svg.widget.Label(container,true,shadow,outline);
	label.set_text(text);
	label.place(x,y,0);
	return label;
}
rg.svg.util.RGCss = function() { }
$hxClasses["rg.svg.util.RGCss"] = rg.svg.util.RGCss;
rg.svg.util.RGCss.__name__ = ["rg","svg","util","RGCss"];
rg.svg.util.RGCss.colorsInCss = function() {
	if(null != rg.svg.util.RGCss.cache) return rg.svg.util.RGCss.cache;
	var container = dhx.Dom.select("body").append("svg:svg").attr("class").string("rg"), first = rg.svg.util.RGCss.createBlock(container,0).style("fill").get();
	rg.svg.util.RGCss.cache = [first];
	var _g = 1;
	while(_g < 1000) {
		var i = _g++;
		var other = rg.svg.util.RGCss.createBlock(container,i).style("fill").get();
		if(first == other) break; else rg.svg.util.RGCss.cache.push(other);
	}
	container.remove();
	haxe.Timer.delay(function() {
		rg.svg.util.RGCss.cache = null;
	},1000);
	return rg.svg.util.RGCss.cache;
}
rg.svg.util.RGCss.numberOfColorsInCss = function() {
	return rg.svg.util.RGCss.colorsInCss().length;
}
rg.svg.util.RGCss.createBlock = function(container,pos) {
	return container.append("svg:rect").attr("class").string("fill-" + pos);
}
rg.svg.util.SVGSymbolBuilder = function() { }
$hxClasses["rg.svg.util.SVGSymbolBuilder"] = rg.svg.util.SVGSymbolBuilder;
rg.svg.util.SVGSymbolBuilder.__name__ = ["rg","svg","util","SVGSymbolBuilder"];
rg.svg.util.SVGSymbolBuilder.generate = function(container,stats,symbol,style) {
	if(null == symbol) return;
	var element = rg.svg.util.SVGSymbolBuilder.createElement(container,stats,symbol);
	rg.util.RGColors.storeColorForSelection(element,"stroke");
	rg.svg.util.SVGSymbolBuilder.applyStyle(element,stats,style);
}
rg.svg.util.SVGSymbolBuilder.createElement = function(container,stats,symbol) {
	container.each(function(dp,index) {
		var description = symbol(dp,stats);
		rg.svg.util.SVGSymbolBuilder.createNode(dhx.Dom.selectNode(dhx.Group.current),description).classed().add("symbol-item");
	});
	return container.selectAll(".symbol-item");
}
rg.svg.util.SVGSymbolBuilder.createNode = function(container,description) {
	if(StringTools.startsWith(description,"image")) {
		var options = rg.svg.util.SVGSymbolBuilder.parseImageArguments(HxOverrides.substr(description.split(":").shift(),5,null));
		return rg.svg.util.SVGSymbolBuilder.createImage(container,description.split(":").slice(1).join(":"),options);
	} else return rg.svg.util.SVGSymbolBuilder.createPath(container,description);
}
rg.svg.util.SVGSymbolBuilder.createPath = function(container,path) {
	return container.append("svg:path").attr("d").string(path);
}
rg.svg.util.SVGSymbolBuilder.createImage = function(container,url,options) {
	var image = container.append("svg:image").attr("xlink:href").string(url).attr("width")["float"](options.width).attr("height")["float"](options.height).attr("preserveAspectRatio").string(options.aspect);
	image.attr("x")["float"]((function($this) {
		var $r;
		switch(options.horizontal) {
		case "right":
			$r = -options.width;
			break;
		case "center":
			$r = -options.width / 2;
			break;
		default:
			$r = 0;
		}
		return $r;
	}(this)));
	image.attr("y")["float"]((function($this) {
		var $r;
		switch(options.vertical) {
		case "bottom":
			$r = -options.height;
			break;
		case "center":
			$r = -options.height / 2;
			break;
		default:
			$r = 0;
		}
		return $r;
	}(this)));
	return image;
}
rg.svg.util.SVGSymbolBuilder.parseImageArguments = function(description) {
	var options = { width : 50.0, height : 50.0, vertical : "center", horizontal : "center", aspect : "none"};
	description.split(",").map(function(v) {
		return StringTools.trim(v);
	}).filter(function(v) {
		return v != "";
	}).forEach(function(v,_) {
		rg.svg.util.SVGSymbolBuilder.appendOption(options,v);
	});
	return options;
}
rg.svg.util.SVGSymbolBuilder.appendOption = function(options,value) {
	if(rg.svg.util.SVGSymbolBuilder.SIZE_PATTERN.match(value)) {
		options.width = Std.parseInt(rg.svg.util.SVGSymbolBuilder.SIZE_PATTERN.matched(1));
		options.height = Std.parseInt(rg.svg.util.SVGSymbolBuilder.SIZE_PATTERN.matched(2));
	} else if(rg.svg.util.SVGSymbolBuilder.ALIGN_PATTERN.match(value)) {
		options.horizontal = rg.svg.util.SVGSymbolBuilder.ALIGN_PATTERN.matched(1).toLowerCase();
		options.vertical = rg.svg.util.SVGSymbolBuilder.ALIGN_PATTERN.matched(2).toLowerCase();
	} else if(rg.svg.util.SVGSymbolBuilder.HORIZONTAL_PATTERN.match(value)) options.horizontal = rg.svg.util.SVGSymbolBuilder.HORIZONTAL_PATTERN.matched(1).toLowerCase(); else if(rg.svg.util.SVGSymbolBuilder.VERTICAL_PATTERN.match(value)) options.vertical = rg.svg.util.SVGSymbolBuilder.VERTICAL_PATTERN.matched(1).toLowerCase();
}
rg.svg.util.SVGSymbolBuilder.applyStyle = function(element,stats,style) {
	if(null == style) return;
	element.attr("style").stringf(function(dp,_) {
		return style(dp,stats);
	});
}
rg.svg.util.SymbolCache = function() {
	this.c = new haxe.ds.StringMap();
	this.r = 0;
};
$hxClasses["rg.svg.util.SymbolCache"] = rg.svg.util.SymbolCache;
rg.svg.util.SymbolCache.__name__ = ["rg","svg","util","SymbolCache"];
rg.svg.util.SymbolCache.prototype = {
	get: function(type,size) {
		if(size == null) size = 100;
		var k = type + ":" + size, s = this.c.get(k);
		if(null == s) {
			s = (Reflect.field(thx.svg.Symbol,type))(size);
			this.c.set(k,s);
		}
		return s;
	}
	,r: null
	,c: null
	,__class__: rg.svg.util.SymbolCache
}
rg.svg.widget = {}
rg.svg.widget.Balloon = function(container,bindOnTop) {
	if(bindOnTop == null) bindOnTop = true;
	if(bindOnTop) {
		var parent = container.node();
		while(null != parent && parent.nodeName != "svg") parent = parent.parentNode;
		this.container = null == parent?container:dhx.Dom.selectNode(parent);
	} else this.container = container;
	this.visible = true;
	this.duration = 350;
	this.minwidth = 30;
	this.set_preferredSide(2);
	this.ease = thx.math.Ease.mode(thx.math.EaseMode.EaseOut,thx.math.Equations.cubic);
	this.set_roundedCorner(5);
	this.paddingHorizontal = 3.5;
	this.paddingVertical = 1.5;
	this.transition_id = 0;
	this.balloon = this.container.append("svg:g").attr("pointer-events").string("none").attr("class").string("balloon").attr("transform").string("translate(" + (this.x = 0) + ", " + (this.y = 0) + ")");
	this.frame = this.balloon.append("svg:g").attr("transform").string("translate(0, 0)").attr("class").string("frame");
	this.frame.append("svg:path").attr("class").string("shadow").attr("transform").string("translate(1, 1)");
	this.connectorShapeV = thx.svg.Diagonal.forObject();
	this.connectorShapeH = thx.svg.Diagonal.forObject().projection(function(d,i) {
		return [d[1],d[0]];
	});
	this.connector = this.balloon.append("svg:path").attr("class").string("balloon-connector").style("fill").string("none").style("display").string("none").attr("transform").string("translate(0, 0)");
	this.frame.append("svg:path").attr("class").string("bg");
	this.labelsContainer = this.frame.append("svg:g").attr("class").string("labels");
	this.labels = [];
	var temp = this.createLabel(0);
	temp.set_text("HELLO");
	this.set_lineHeight(temp.getSize().height);
	temp.destroy();
};
$hxClasses["rg.svg.widget.Balloon"] = rg.svg.widget.Balloon;
rg.svg.widget.Balloon.__name__ = ["rg","svg","widget","Balloon"];
rg.svg.widget.Balloon.prototype = {
	redraw: function() {
		var _g = this;
		if(null == this.text || this.text.length == 0) return;
		this.boxWidth = 0.0;
		var w = 0;
		var _g1 = 0, _g11 = this.labels;
		while(_g1 < _g11.length) {
			var label = _g11[_g1];
			++_g1;
			if((w = Math.ceil(label.getSize().width)) > this.boxWidth) this.boxWidth = w;
		}
		if(w == 0) {
			var t = this.text;
			haxe.Timer.delay(function() {
				_g.set_text(t);
			},15);
			return;
		}
		this.boxWidth += this.paddingHorizontal * 2;
		this.boxHeight = this.lineHeight * this.labels.length + this.paddingVertical * 2;
		var bg = this.frame.selectAll(".bg"), sw = bg.style("stroke-width").getFloat();
		if(Math.isNaN(sw)) sw = 0;
		this.labelsContainer.attr("transform").string("translate(" + this.boxWidth / 2 + "," + (sw + this.paddingVertical) + ")");
		bg.transition().ease(this.ease).delay(null,this.duration);
	}
	,_moveTo: function(x,y) {
		var bb = this.get_boundingBox(), left = bb.x, right = bb.x + bb.width, top = bb.y, bottom = bb.y + bb.height, limit = this.roundedCorner * 2, offset = 0.0, diagonal = 0;
		var tx = 0.0, ty = 0.0, side = this.preferredSide, found = 1;
		while(found > 0 && found < 5) {
			if(x >= right - limit) {
				if(y <= top + limit) {
					if(x - right < top - y) {
						tx = -this.boxWidth + right - x;
						ty = top - y + this.roundedCorner;
						side = 0;
						offset = this.boxWidth - 4 * this.roundedCorner;
					} else {
						tx = -this.boxWidth + right - x - this.roundedCorner;
						ty = top - y;
						side = 1;
						offset = this.roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				} else if(y >= bottom - limit) {
					if(x - right < y - bottom) {
						tx = -this.boxWidth + right - x;
						ty = bottom - y - this.boxHeight - this.roundedCorner;
						side = 2;
						offset = this.boxWidth - 4 * this.roundedCorner;
					} else {
						tx = -this.boxWidth + right - x - this.roundedCorner;
						ty = bottom - y - this.boxHeight;
						side = 1;
						offset = this.boxHeight - 3 * this.roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				}
			} else if(x <= left + limit) {
				if(y <= top + limit) {
					if(left - x < top - y) {
						tx = left - x;
						ty = top - y + this.roundedCorner;
						side = 0;
						offset = 0;
					} else {
						tx = left - x + this.roundedCorner;
						ty = top - y;
						side = 3;
						offset = this.roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				} else if(y >= bottom - limit) {
					if(left - x < y - bottom) {
						tx = left - x;
						ty = bottom - y - this.boxHeight - this.roundedCorner;
						side = 2;
						offset = 0;
					} else {
						tx = left - x + this.roundedCorner;
						ty = bottom - y - this.boxHeight;
						side = 3;
						offset = this.boxHeight - 3 * this.roundedCorner;
					}
					found = 0;
					diagonal = 1;
					break;
				}
			}
			switch(side) {
			case 0:
				if(y + this.boxHeight + this.roundedCorner >= bottom) {
					side = 2;
					found++;
					continue;
				} else if(x <= left + limit) {
					side = 3;
					found++;
					continue;
				} else if(x >= right - limit) {
					side = 1;
					found++;
					continue;
				}
				tx = -this.boxWidth / 2;
				ty = this.roundedCorner;
				offset = this.boxWidth / 2 - this.roundedCorner * 2;
				if(x - this.boxWidth / 2 <= left) {
					var d = left - x + this.boxWidth / 2;
					offset = Math.max(0,offset - d);
					tx += d;
				} else if(x + this.boxWidth / 2 >= right) {
					var d = right - x - this.boxWidth / 2;
					offset = Math.min(this.boxWidth - this.roundedCorner * 3,offset - d);
					tx += d;
				}
				if(y < top) {
					diagonal = 1;
					ty = top - y + this.roundedCorner;
				}
				break;
			case 1:
				if(x - this.boxWidth - this.roundedCorner <= left) {
					side = 3;
					found++;
					continue;
				} else if(y <= top + limit) {
					side = 2;
					found++;
					continue;
				} else if(y >= bottom - limit) {
					side = 0;
					found++;
					continue;
				}
				tx = -this.boxWidth - this.roundedCorner;
				ty = -this.boxHeight / 2;
				offset = (this.boxHeight - this.roundedCorner * 2) / 2;
				if(y - this.boxHeight / 2 <= top) {
					var d = top - y + this.boxHeight / 2;
					offset = Math.max(0,offset - d);
					ty += d;
				} else if(y + this.boxHeight / 2 >= bottom) {
					var d = bottom - y - this.boxHeight / 2;
					offset = Math.min(this.boxHeight - this.roundedCorner * 3,offset - d);
					ty += d;
				}
				if(x > right) {
					diagonal = 2;
					tx = right - x - this.boxWidth - this.roundedCorner;
				}
				break;
			case 2:
				if(y - this.boxHeight - this.roundedCorner <= top) {
					side = 0;
					found++;
					continue;
				} else if(x <= left + limit) {
					side = 3;
					found++;
					continue;
				} else if(x >= right - limit) {
					side = 1;
					found++;
					continue;
				}
				tx = -this.boxWidth / 2;
				ty = -this.boxHeight - this.roundedCorner;
				offset = this.boxWidth / 2 - this.roundedCorner * 2;
				if(x - this.boxWidth / 2 <= left) {
					var d = left - x + this.boxWidth / 2;
					offset = Math.max(this.roundedCorner,offset - d);
					tx += d;
				} else if(x + this.boxWidth / 2 >= right) {
					var d = right - x - this.boxWidth / 2;
					offset = Math.min(this.boxWidth - this.roundedCorner * 3,offset - d);
					tx += d;
				}
				if(y > bottom) {
					diagonal = 1;
					ty = bottom - y - this.boxHeight - this.roundedCorner;
				}
				break;
			case 3:
				if(x + this.boxWidth + this.roundedCorner >= right) {
					side = 1;
					found++;
					continue;
				} else if(y <= top + limit) {
					side = 2;
					found++;
					continue;
				} else if(y >= bottom - limit) {
					side = 0;
					found++;
					continue;
				}
				tx = this.roundedCorner;
				ty = -this.boxHeight / 2;
				offset = (this.boxHeight - this.roundedCorner * 2) / 2;
				if(y - this.boxHeight / 2 <= top) {
					var d = top - y + this.boxHeight / 2;
					offset = Math.max(this.roundedCorner,offset - d);
					ty += d;
				} else if(y + this.boxHeight / 2 >= bottom) {
					var d = bottom - y - this.boxHeight / 2;
					offset = Math.min(this.boxHeight - this.roundedCorner * 3,offset - d);
					ty += d;
				}
				if(x < left) {
					diagonal = 2;
					tx = left - x + this.roundedCorner;
				}
				break;
			}
			found = 0;
		}
		var coords = null, off = 1.0;
		if(0 == diagonal) this.connector.style("display").string("none"); else {
			this.connector.style("display").string("block");
			coords = { x0 : off, y0 : off, x1 : off, y1 : off};
			switch(side) {
			case 0:
				coords.x1 = tx + off + offset + 2 * this.roundedCorner;
				coords.y1 = ty + off - this.roundedCorner;
				break;
			case 1:
				coords.y1 = tx + off + this.boxWidth + this.roundedCorner;
				coords.x1 = ty + off + offset + this.roundedCorner;
				break;
			case 2:
				coords.x1 = tx + off + offset + 2 * this.roundedCorner;
				coords.y1 = ty + off + this.boxHeight + this.roundedCorner;
				break;
			case 3:
				coords.y1 = tx + off + -this.roundedCorner;
				coords.x1 = ty + off + offset + this.roundedCorner;
				break;
			}
		}
		this.balloon.attr("transform").string("translate(" + (this.x = x) + ", " + (this.y = y) + ")");
		this.frame.attr("transform").string("translate(" + tx + ", " + ty + ")").selectAll("path").attr("d").string(rg.svg.widget.BalloonShape.shape(this.boxWidth,this.boxHeight,this.roundedCorner,this.roundedCorner,side,offset));
		if(0 != diagonal) this.connector.attr("d").string(side % 2 == 0?this.connectorShapeV.diagonal(coords):this.connectorShapeH.diagonal(coords));
	}
	,moveTo: function(x,y,animate) {
		if(animate == null) animate = true;
		var _g = this;
		if(animate) {
			var $int = thx.math.Equations.elasticf(), tid = ++this.transition_id, ix = Floats.interpolatef(this.x,x,this.ease), iy = Floats.interpolatef(this.y,y,this.ease);
			dhx.Timer.timer(function(t) {
				if(tid != _g.transition_id) return true;
				if(t > _g.duration) {
					_g._moveTo(x,y);
					return true;
				}
				_g._moveTo(ix(t / _g.duration),iy(t / _g.duration));
				return false;
			},0);
		} else if(0 == this.boxWidth) haxe.Timer.delay((function(f,x1,y1) {
			return function() {
				return f(x1,y1);
			};
		})($bind(this,this._moveTo),x,y),15); else this._moveTo(x,y);
	}
	,transition_id: null
	,get_boundingBox: function() {
		if(null == this.boundingBox) try {
			this.set_boundingBox(this.container.node().getBBox());
		} catch( e ) {
			return { width : 0.0, height : 0.0, x : 0.0, y : 0.0};
		}
		return this.boundingBox;
	}
	,set_boundingBox: function(v) {
		this.boundingBox = v;
		this.redraw();
		return v;
	}
	,set_roundedCorner: function(v) {
		this.roundedCorner = v;
		this.redraw();
		return v;
	}
	,set_lineHeight: function(v) {
		this.lineHeight = v;
		this.redraw();
		return v;
	}
	,set_text: function(v) {
		while(this.labels.length > v.length) {
			var label = this.labels.pop();
			label.destroy();
		}
		var _g1 = this.labels.length, _g = v.length;
		while(_g1 < _g) {
			var i = _g1++;
			this.labels[i] = this.createLabel(i);
		}
		var _g1 = 0, _g = v.length;
		while(_g1 < _g) {
			var i = _g1++;
			this.labels[i].set_text(v[i]);
		}
		this.text = v;
		this.redraw();
		return v;
	}
	,set_preferredSide: function(v) {
		this.preferredSide = Ints.clamp(v,0,3);
		this.redraw();
		return v;
	}
	,createLabel: function(i) {
		var label = new rg.svg.widget.Label(this.labelsContainer,true,false,false);
		label.addClass("line-" + i);
		label.set_anchor(rg.svg.widget.GridAnchor.Top);
		label.set_orientation(rg.svg.widget.LabelOrientation.Orthogonal);
		label.place(0,i * this.lineHeight,90);
		return label;
	}
	,boundingBox: null
	,connectorShapeH: null
	,connectorShapeV: null
	,ease: null
	,duration: null
	,connector: null
	,labelsContainer: null
	,frame: null
	,balloon: null
	,container: null
	,labels: null
	,minwidth: null
	,preferredSide: null
	,paddingVertical: null
	,paddingHorizontal: null
	,roundedCorner: null
	,lineHeight: null
	,visible: null
	,boxHeight: null
	,boxWidth: null
	,y: null
	,x: null
	,text: null
	,__class__: rg.svg.widget.Balloon
}
rg.svg.widget.BalloonShape = function() { }
$hxClasses["rg.svg.widget.BalloonShape"] = rg.svg.widget.BalloonShape;
rg.svg.widget.BalloonShape.__name__ = ["rg","svg","widget","BalloonShape"];
rg.svg.widget.BalloonShape.shape = function(width,height,rc,rp,side,offset) {
	var w = width - rc * 2, h = height - rc * 2;
	var buf = "M" + rc + ",0";
	if(0 == side) {
		buf += "h" + offset;
		buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + -rc;
		buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + rc;
		buf += "h" + (w - (offset + 2 * rc));
	} else buf += "h" + w;
	buf += "a" + rc + "," + rc + ",0,0,1," + rc + "," + rc;
	if(1 == side) {
		buf += "v" + (offset - rc);
		buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + rc;
		buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + rc;
		buf += "v" + (h - (offset + rc));
	} else buf += "v" + h;
	buf += "a" + rc + "," + rc + ",0,0,1," + -rc + "," + rc;
	if(2 == side) {
		buf += "h" + -(w - (offset + 2 * rc));
		buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + rc;
		buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + -rc;
		buf += "h" + -offset;
	} else buf += "h" + -w;
	buf += "a" + rc + "," + rc + ",0,0,1," + -rc + "," + -rc;
	if(3 == side) {
		buf += "v" + -(h - (offset + rc));
		buf += "a" + rc + "," + rc + ",0,0,0," + -rc + "," + -rc;
		buf += "a" + rc + "," + rc + ",0,0,0," + rc + "," + -rc;
		buf += "v" + -(offset - rc);
	} else buf += "v" + -h;
	buf += "a" + rc + "," + rc + ",0,0,1," + rc + "," + -rc;
	return buf + "Z";
}
rg.svg.widget.DiagonalArea = function(container,classarea,classborder) {
	this.g = container.append("svg:g").attr("class").string("diagonal");
	this.diagonal = thx.svg.Diagonal.forArray().projection(function(a,_) {
		return [a[1],a[0]];
	});
	this.area = this.g.append("svg:path").attr("class").string("diagonal-fill" + (null == classarea?"":" " + classarea));
	this.before = this.g.append("svg:path").attr("class").string("diagonal-stroke before" + (null == classborder?"":" " + classborder));
	this.after = this.g.append("svg:path").attr("class").string("diagonal-stroke after" + (null == classborder?"":" " + classborder));
};
$hxClasses["rg.svg.widget.DiagonalArea"] = rg.svg.widget.DiagonalArea;
rg.svg.widget.DiagonalArea.__name__ = ["rg","svg","widget","DiagonalArea"];
rg.svg.widget.DiagonalArea.prototype = {
	update: function(x1,y1,x2,y2,sw,ew) {
		var top = this.diagonal.diagonal([y1,x1,y2,x2]), bottom = this.diagonal.diagonal([y2 + ew,x2,y1 + sw,x1]);
		var path = top + "L" + HxOverrides.substr(bottom,1,null) + "z";
		this.before.attr("d").string(top);
		this.after.attr("d").string(bottom);
		this.area.attr("d").string(path);
	}
	,addClass: function(cls) {
		this.g.classed().add(cls);
	}
	,after: null
	,before: null
	,area: null
	,diagonal: null
	,g: null
	,__class__: rg.svg.widget.DiagonalArea
}
rg.svg.widget.ElbowArea = function(container,classarea,classborder) {
	this.g = container.append("svg:g").attr("class").string("elbow");
	this.area = this.g.append("svg:path").attr("class").string("elbow-fill" + (null == classarea?"":" " + classarea));
	this.outer = this.g.append("svg:path").attr("class").string("elbow-stroke outer" + (null == classborder?"":" " + classborder));
	this.inner = this.g.append("svg:path").attr("class").string("elbow-stroke inner" + (null == classborder?"":" " + classborder));
};
$hxClasses["rg.svg.widget.ElbowArea"] = rg.svg.widget.ElbowArea;
rg.svg.widget.ElbowArea.__name__ = ["rg","svg","widget","ElbowArea"];
rg.svg.widget.ElbowArea.prototype = {
	update: function(orientation,weight,x,y,minradius,maxradius,before,after) {
		if(after == null) after = 10.0;
		if(before == null) before = 0.0;
		if(maxradius == null) maxradius = 16.0;
		if(minradius == null) minradius = 3.0;
		if(weight == 0) return;
		var dinner = "", douter = "", rad = weight < 0?Math.max(maxradius,weight):Math.min(maxradius,weight);
		switch( (orientation)[1] ) {
		case 0:
			dinner = "M" + (before + x + minradius) + "," + (y + minradius + after) + "L" + (before + x + minradius) + "," + (y + minradius) + "A" + Math.abs(minradius) + "," + Math.abs(minradius) + " 0 0,0 " + (before + x) + "," + y + "L" + x + "," + y;
			douter = "M" + x + "," + (y - weight) + "L" + (before + x) + "," + (y - weight) + "A" + Math.abs(rad) + "," + Math.abs(rad) + " 0 0,1 " + (before + x + rad) + "," + (y - weight + rad) + "L" + (before + x + rad) + "," + (y + after + minradius);
			break;
		case 1:
			break;
		case 2:
			break;
		case 3:
			this.update(rg.svg.widget.Orientation.RightBottom,-weight,x,y,-minradius,-maxradius,-before,-after);
			return;
		case 4:
			break;
		case 5:
			break;
		case 6:
			break;
		case 7:
			break;
		}
		var darea = douter + "L" + HxOverrides.substr(dinner,1,null) + "z";
		this.inner.attr("d").string(dinner);
		this.outer.attr("d").string(douter);
		this.area.attr("d").string(darea);
	}
	,addClass: function(cls) {
		this.g.classed().add(cls);
	}
	,inner: null
	,outer: null
	,area: null
	,g: null
	,__class__: rg.svg.widget.ElbowArea
}
rg.svg.widget.Orientation = { __ename__ : ["rg","svg","widget","Orientation"], __constructs__ : ["RightBottom","LeftBottom","RightTop","LeftTop","BottomRight","BottomLeft","TopRight","TopLeft"] }
rg.svg.widget.Orientation.RightBottom = ["RightBottom",0];
rg.svg.widget.Orientation.RightBottom.toString = $estr;
rg.svg.widget.Orientation.RightBottom.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.LeftBottom = ["LeftBottom",1];
rg.svg.widget.Orientation.LeftBottom.toString = $estr;
rg.svg.widget.Orientation.LeftBottom.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.RightTop = ["RightTop",2];
rg.svg.widget.Orientation.RightTop.toString = $estr;
rg.svg.widget.Orientation.RightTop.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.LeftTop = ["LeftTop",3];
rg.svg.widget.Orientation.LeftTop.toString = $estr;
rg.svg.widget.Orientation.LeftTop.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.BottomRight = ["BottomRight",4];
rg.svg.widget.Orientation.BottomRight.toString = $estr;
rg.svg.widget.Orientation.BottomRight.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.BottomLeft = ["BottomLeft",5];
rg.svg.widget.Orientation.BottomLeft.toString = $estr;
rg.svg.widget.Orientation.BottomLeft.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.TopRight = ["TopRight",6];
rg.svg.widget.Orientation.TopRight.toString = $estr;
rg.svg.widget.Orientation.TopRight.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.Orientation.TopLeft = ["TopLeft",7];
rg.svg.widget.Orientation.TopLeft.toString = $estr;
rg.svg.widget.Orientation.TopLeft.__enum__ = rg.svg.widget.Orientation;
rg.svg.widget.GeoMap = function(container,projection) {
	var _g = this;
	this.g = container.append("svg:g").attr("class").string("map");
	this.projection = projection;
	this.map = new haxe.ds.StringMap();
	this.ready = false;
	this.onReady = new hxevents.Notifier();
	this.onReady.addOnce(function() {
		_g.ready = true;
	});
};
$hxClasses["rg.svg.widget.GeoMap"] = rg.svg.widget.GeoMap;
rg.svg.widget.GeoMap.__name__ = ["rg","svg","widget","GeoMap"];
rg.svg.widget.GeoMap.loadJsonp = function(url,handler) {
	rg.util.Jsonp.get(url,handler,null,null,null);
}
rg.svg.widget.GeoMap.loadJsonAjax = function(url,handler) {
	var http = new haxe.Http(url);
	http.onData = function(data) {
		var json = thx.json.Json.decode(data);
		handler(json);
	};
	http.onError = function(err) {
		throw new thx.error.Error("unable to load JSON file '{0}': {1}",[url,err],null,{ fileName : "GeoMap.hx", lineNumber : 90, className : "rg.svg.widget.GeoMap", methodName : "loadJsonAjax"});
	};
	http.request(false);
}
rg.svg.widget.GeoMap.prototype = {
	set_className: function(cls) {
		this.g.attr("class").string("map" + (null == cls?"":" " + cls));
		return cls;
	}
	,handlerClick: null
	,handlerDataPointOver: null
	,onClick: function(dp,_,i) {
		this.handlerClick(dp,this.click);
	}
	,onMouseOver: function(dp,n,i) {
		this.handlerDataPointOver(n,dp,this.labelDataPointOver);
	}
	,draw: function(json) {
		var _g = this;
		var id = null != this.mapping?function(s) {
			return Reflect.hasField(_g.mapping,s)?Reflect.field(_g.mapping,s):s;
		}:function(s) {
			return s;
		};
		var path = new thx.svg.PathGeoJson();
		path.set_projection(this.projection);
		switch(json.type) {
		case "FeatureCollection":
			var _g1 = 0, _g2 = json.features.length;
			while(_g1 < _g2) {
				var i = _g1++;
				var feature = json.features[i], centroid = path.centroid(feature.geometry), p = feature.geometry.type == "Point"?this.g.append("svg:circle").attr("cx")["float"](centroid[0]).attr("cy")["float"](centroid[1]).attr("r")["float"](5):this.g.append("svg:path").attr("d").string(path.path(feature.geometry));
				var dp = { };
				dp.$centroid = centroid;
				dp.$data = feature.properties;
				if(null != feature.id) this.map.set(id(feature.id),{ svg : p, dp : dp});
				if(null != this.labelDataPointOver) p.onNode("mouseover",(function(f,dp1) {
					return function(n,i1) {
						return f(dp1,n,i1);
					};
				})($bind(this,this.onMouseOver),dp));
				if(null != this.click) p.onNode("click",(function(f1,dp2) {
					return function(_,i1) {
						return f1(dp2,_,i1);
					};
				})($bind(this,this.onClick),dp));
			}
			break;
		case "MultiPoint":case "MultiLineString":case "MultiPolygon":case "GeometryCollection":
			throw new thx.error.Error("the type '{0}' is not implemented yet",[json.type],null,{ fileName : "GeoMap.hx", lineNumber : 133, className : "rg.svg.widget.GeoMap", methodName : "draw"});
			break;
		default:
			this.g.append("svg:path").attr("d").string(path.path(json));
		}
		this.onReady.dispatch();
	}
	,loadGeoJson: function(geourl,mappingurl,usejsonp) {
		var _g = this;
		var load = usejsonp?rg.svg.widget.GeoMap.loadJsonp:rg.svg.widget.GeoMap.loadJsonAjax;
		if(null == mappingurl) load(geourl,$bind(this,this.draw)); else load(mappingurl,function(m) {
			_g.mapping = m;
			load(geourl,$bind(_g,_g.draw));
		});
	}
	,load: function(path,type,mappingurl,usejsonp) {
		switch(type) {
		case "geojson":
			this.loadGeoJson(path,mappingurl,usejsonp);
			break;
		default:
			new thx.error.Error("unsupported geographic format '{0}'",null,type,{ fileName : "GeoMap.hx", lineNumber : 59, className : "rg.svg.widget.GeoMap", methodName : "load"});
		}
	}
	,g: null
	,projection: null
	,mapping: null
	,ready: null
	,colorMode: null
	,radius: null
	,labelDataPointOver: null
	,labelDataPoint: null
	,click: null
	,onReady: null
	,map: null
	,__class__: rg.svg.widget.GeoMap
}
rg.svg.widget.GridAnchor = { __ename__ : ["rg","svg","widget","GridAnchor"], __constructs__ : ["TopLeft","Top","TopRight","Left","Center","Right","BottomLeft","Bottom","BottomRight"] }
rg.svg.widget.GridAnchor.TopLeft = ["TopLeft",0];
rg.svg.widget.GridAnchor.TopLeft.toString = $estr;
rg.svg.widget.GridAnchor.TopLeft.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.Top = ["Top",1];
rg.svg.widget.GridAnchor.Top.toString = $estr;
rg.svg.widget.GridAnchor.Top.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.TopRight = ["TopRight",2];
rg.svg.widget.GridAnchor.TopRight.toString = $estr;
rg.svg.widget.GridAnchor.TopRight.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.Left = ["Left",3];
rg.svg.widget.GridAnchor.Left.toString = $estr;
rg.svg.widget.GridAnchor.Left.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.Center = ["Center",4];
rg.svg.widget.GridAnchor.Center.toString = $estr;
rg.svg.widget.GridAnchor.Center.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.Right = ["Right",5];
rg.svg.widget.GridAnchor.Right.toString = $estr;
rg.svg.widget.GridAnchor.Right.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.BottomLeft = ["BottomLeft",6];
rg.svg.widget.GridAnchor.BottomLeft.toString = $estr;
rg.svg.widget.GridAnchor.BottomLeft.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.Bottom = ["Bottom",7];
rg.svg.widget.GridAnchor.Bottom.toString = $estr;
rg.svg.widget.GridAnchor.Bottom.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchor.BottomRight = ["BottomRight",8];
rg.svg.widget.GridAnchor.BottomRight.toString = $estr;
rg.svg.widget.GridAnchor.BottomRight.__enum__ = rg.svg.widget.GridAnchor;
rg.svg.widget.GridAnchors = function() { }
$hxClasses["rg.svg.widget.GridAnchors"] = rg.svg.widget.GridAnchors;
rg.svg.widget.GridAnchors.__name__ = ["rg","svg","widget","GridAnchors"];
rg.svg.widget.GridAnchors.parse = function(s) {
	return (function($this) {
		var $r;
		var _g = s.toLowerCase();
		$r = (function($this) {
			var $r;
			switch(_g) {
			case "topleft":
				$r = rg.svg.widget.GridAnchor.TopLeft;
				break;
			case "top":
				$r = rg.svg.widget.GridAnchor.Top;
				break;
			case "topright":
				$r = rg.svg.widget.GridAnchor.TopRight;
				break;
			case "left":
				$r = rg.svg.widget.GridAnchor.Left;
				break;
			case "center":
				$r = rg.svg.widget.GridAnchor.Center;
				break;
			case "right":
				$r = rg.svg.widget.GridAnchor.Right;
				break;
			case "bottomleft":
				$r = rg.svg.widget.GridAnchor.BottomLeft;
				break;
			case "bottom":
				$r = rg.svg.widget.GridAnchor.Bottom;
				break;
			case "bottomright":
				$r = rg.svg.widget.GridAnchor.BottomRight;
				break;
			default:
				$r = rg.svg.widget.GridAnchor.Center;
			}
			return $r;
		}($this));
		return $r;
	}(this));
}
rg.svg.widget.HookConnector = function(container,classborder) {
	this.g = container.append("svg:g").attr("class").string("hook");
	this.line = this.g.append("svg:path").attr("class").string("hook-stroke line" + (null == classborder?"":" " + classborder));
};
$hxClasses["rg.svg.widget.HookConnector"] = rg.svg.widget.HookConnector;
rg.svg.widget.HookConnector.__name__ = ["rg","svg","widget","HookConnector"];
rg.svg.widget.HookConnector.lineTo = function(x,y) {
	return "L" + x + "," + y;
}
rg.svg.widget.HookConnector.quarterTo = function(x,y,r) {
	return "A" + Math.abs(r) + "," + Math.abs(r) + " 0 0," + (r < 0?0:1) + " " + x + "," + y;
}
rg.svg.widget.HookConnector.prototype = {
	createPath: function(x1,y1,x2,y2,yref,before,after,r1,r2) {
		var path = "M" + x1 + "," + y1;
		path += rg.svg.widget.HookConnector.lineTo(x1 + before - r1,y1);
		path += rg.svg.widget.HookConnector.quarterTo(x1 + before,y1 + r2,r1);
		path += rg.svg.widget.HookConnector.lineTo(x1 + before,yref - r2);
		path += rg.svg.widget.HookConnector.quarterTo(x1 + before - r1,yref,r1);
		path += rg.svg.widget.HookConnector.lineTo(x2 - after + r1,yref);
		path += rg.svg.widget.HookConnector.quarterTo(x2 - after,yref - r2,r1);
		path += rg.svg.widget.HookConnector.lineTo(x2 - after,y2 + r2);
		path += rg.svg.widget.HookConnector.quarterTo(x2 - after + r1,y2,r1);
		path += rg.svg.widget.HookConnector.lineTo(x2,y2);
		return path;
	}
	,update: function(x1,y1,x2,y2,yreference,before,after) {
		var linep = this.createPath(x1,y1,x2,y2,yreference,before,after,5,5);
		this.line.attr("d").string(linep);
	}
	,addClass: function(cls) {
		this.g.classed().add(cls);
	}
	,line: null
	,g: null
	,__class__: rg.svg.widget.HookConnector
}
rg.svg.widget.HookConnectorArea = function(container,classarea,classborder) {
	this.g = container.append("svg:g").attr("class").string("hook-area");
	this.area = this.g.append("svg:path").attr("class").string("hook-area-fill" + (null == classarea?"":" " + classarea));
	this.upper = this.g.append("svg:path").attr("class").string("hook-area-stroke upper" + (null == classborder?"":" " + classborder));
	this.lower = this.g.append("svg:path").attr("class").string("hook-area-stroke lower" + (null == classborder?"":" " + classborder));
};
$hxClasses["rg.svg.widget.HookConnectorArea"] = rg.svg.widget.HookConnectorArea;
rg.svg.widget.HookConnectorArea.__name__ = ["rg","svg","widget","HookConnectorArea"];
rg.svg.widget.HookConnectorArea.lineTo = function(x,y) {
	return "L" + x + "," + y;
}
rg.svg.widget.HookConnectorArea.quarterTo = function(x,y,r) {
	return "A" + Math.abs(r) + "," + Math.abs(r) + " 0 0," + (r < 0?0:1) + " " + x + "," + y;
}
rg.svg.widget.HookConnectorArea.prototype = {
	createPath: function(x1,y1,x2,y2,yref,before,after,r1,r2) {
		var path = "M" + x1 + "," + y1;
		path += rg.svg.widget.HookConnectorArea.lineTo(x1 + before - r1,y1);
		path += rg.svg.widget.HookConnectorArea.quarterTo(x1 + before,y1 + r2,r1);
		path += rg.svg.widget.HookConnectorArea.lineTo(x1 + before,yref - r2);
		path += rg.svg.widget.HookConnectorArea.quarterTo(x1 + before - r1,yref,r1);
		path += rg.svg.widget.HookConnectorArea.lineTo(x2 - after + r1,yref);
		path += rg.svg.widget.HookConnectorArea.quarterTo(x2 - after,yref - r2,r1);
		path += rg.svg.widget.HookConnectorArea.lineTo(x2 - after,y2 + r2);
		path += rg.svg.widget.HookConnectorArea.quarterTo(x2 - after + r1,y2,r1);
		path += rg.svg.widget.HookConnectorArea.lineTo(x2,y2);
		return path;
	}
	,update: function(x1,y1,x2,y2,weight,yreference,before,after) {
		var min = Math.min(5,weight), upperp = this.createPath(x1,y1,x2,y2,y1 > yreference?yreference:yreference + weight,before + weight,after + weight,weight,weight), lowerp = this.createPath(x2,y2 + weight,x1,y1 + weight,y1 > yreference?yreference - weight:yreference,-after,-before,-min,min);
		this.upper.attr("d").string(upperp);
		this.lower.attr("d").string(lowerp);
		this.area.attr("d").string(upperp + "L" + HxOverrides.substr(lowerp,1,null) + "z");
	}
	,addClass: function(cls) {
		this.g.classed().add(cls);
	}
	,lower: null
	,upper: null
	,area: null
	,g: null
	,__class__: rg.svg.widget.HookConnectorArea
}
rg.svg.widget.Label = function(container,dontflip,shadow,outline) {
	if(dontflip == null) dontflip = true;
	this.shadow = shadow;
	this.outline = outline;
	this.g = container.append("svg:g").attr("class").string("label");
	if(shadow) {
		this.gshadow = this.g.append("svg:g").attr("transform").string("translate(0,0)");
		this.gshadowrot = this.gshadow.append("svg:g");
		this.tshadow = this.gshadowrot.append("svg:text").attr("class").string("shadow" + (outline?"":" nooutline"));
	}
	this.gtext = this.g.append("svg:g");
	if(outline) this.toutline = this.gtext.append("svg:text").attr("class").string("outline" + (shadow?"":" noshadow"));
	var cls = Arrays.addIf(Arrays.addIf(["text"],!outline,"nooutline"),!shadow,"noshadow");
	this.ttext = this.gtext.append("svg:text").attr("class").string(cls.join(" "));
	this.dontFlip = dontflip;
	if(outline) this.setShadowOffset(1,1.25); else this.setShadowOffset(0.5,0.5);
	this.x = 0;
	this.y = 0;
	this.angle = 0;
	this.set_orientation(rg.svg.widget.LabelOrientation.FixedAngle(0));
	this.set_anchor(rg.svg.widget.GridAnchor.Center);
	this.visible = true;
};
$hxClasses["rg.svg.widget.Label"] = rg.svg.widget.Label;
rg.svg.widget.Label.__name__ = ["rg","svg","widget","Label"];
rg.svg.widget.Label.prototype = {
	destroy: function() {
		this.g.remove();
	}
	,reanchor: function() {
		if(null == this.anchor) return;
		var bb = this.getBB(), x, y;
		var a = this.anchor;
		if(this.dontFlip) {
			var _g = this;
			switch( (_g.orientation)[1] ) {
			case 1:
				if(this.angle > 90 && this.angle < 270) a = (function($this) {
					var $r;
					switch( (a)[1] ) {
					case 0:
						$r = rg.svg.widget.GridAnchor.BottomRight;
						break;
					case 1:
						$r = rg.svg.widget.GridAnchor.Bottom;
						break;
					case 2:
						$r = rg.svg.widget.GridAnchor.BottomLeft;
						break;
					case 3:
						$r = rg.svg.widget.GridAnchor.Right;
						break;
					case 4:
						$r = rg.svg.widget.GridAnchor.Center;
						break;
					case 5:
						$r = rg.svg.widget.GridAnchor.Left;
						break;
					case 6:
						$r = rg.svg.widget.GridAnchor.TopRight;
						break;
					case 7:
						$r = rg.svg.widget.GridAnchor.Top;
						break;
					case 8:
						$r = rg.svg.widget.GridAnchor.TopLeft;
						break;
					}
					return $r;
				}(this));
				break;
			case 2:
				if(this.angle > 180) a = (function($this) {
					var $r;
					switch( (a)[1] ) {
					case 0:
						$r = rg.svg.widget.GridAnchor.BottomRight;
						break;
					case 1:
						$r = rg.svg.widget.GridAnchor.Bottom;
						break;
					case 2:
						$r = rg.svg.widget.GridAnchor.BottomLeft;
						break;
					case 3:
						$r = rg.svg.widget.GridAnchor.Right;
						break;
					case 4:
						$r = rg.svg.widget.GridAnchor.Center;
						break;
					case 5:
						$r = rg.svg.widget.GridAnchor.Left;
						break;
					case 6:
						$r = rg.svg.widget.GridAnchor.TopRight;
						break;
					case 7:
						$r = rg.svg.widget.GridAnchor.Top;
						break;
					case 8:
						$r = rg.svg.widget.GridAnchor.TopLeft;
						break;
					}
					return $r;
				}(this));
				break;
			default:
			}
		}
		switch( (a)[1] ) {
		case 0:
			x = 0;
			y = bb.height;
			break;
		case 1:
			x = -bb.width / 2;
			y = bb.height;
			break;
		case 2:
			x = -bb.width;
			y = bb.height;
			break;
		case 3:
			x = 0;
			y = bb.height / 2;
			break;
		case 4:
			x = -bb.width / 2;
			y = bb.height / 2;
			break;
		case 5:
			x = -bb.width;
			y = bb.height / 2;
			break;
		case 6:
			x = 0;
			y = 0;
			break;
		case 7:
			x = -bb.width / 2;
			y = 0;
			break;
		case 8:
			x = -bb.width;
			y = 0;
			break;
		}
		if(this.outline) this.toutline.attr("x")["float"](x + 0.5).attr("y")["float"](y - 1.5);
		this.ttext.attr("x")["float"](x + 0.5).attr("y")["float"](y - 1.5);
		if(this.shadow) this.tshadow.attr("x")["float"](x + 0.5).attr("y")["float"](y - 1.5);
	}
	,getBB: function() {
		var n = this.ttext.node(), h = this.ttext.style("font-size").getFloat();
		if(null == h || 0 >= h) try {
			h = n.getExtentOfChar("A").height;
		} catch( e ) {
			h = dhx.Dom.selectNode(n).style("height").getFloat();
		}
		var w;
		try {
			w = n.getComputedTextLength();
		} catch( e ) {
			w = dhx.Dom.selectNode(n).style("width").getFloat();
		}
		return { width : w, height : h};
	}
	,set_anchor: function(v) {
		this.anchor = v;
		this.reanchor();
		return v;
	}
	,set_orientation: function(v) {
		this.orientation = v;
		this.place(this.x,this.y,this.angle);
		return v;
	}
	,set_text: function(v) {
		this.text = v;
		if(this.outline) this.toutline.text().string(v);
		this.ttext.text().string(v);
		if(this.shadow) this.tshadow.text().string(v);
		this.reanchor();
		return v;
	}
	,setShadowOffset: function(x,y) {
		this.shadowOffsetX = x;
		this.shadowOffsetY = y;
		if(this.shadow) this.gshadow.attr("transform").string("translate(" + this.shadowOffsetX + "," + this.shadowOffsetY + ")");
	}
	,place: function(x,y,angle) {
		this.x = Math.isNaN(x)?0.0:x;
		this.y = Math.isNaN(y)?0.0:y;
		this.angle = angle % 360;
		if(this.angle < 0) this.angle += 360;
		this.g.attr("transform").string("translate(" + this.x + "," + this.y + ")");
		var _g = this;
		var $e = (_g.orientation);
		switch( $e[1] ) {
		case 0:
			var a = $e[2];
			this.gtext.attr("transform").string("rotate(" + a + ")");
			break;
		case 1:
			if(this.dontFlip && this.angle > 90 && this.angle < 270) angle += 180;
			this.gtext.attr("transform").string("rotate(" + angle + ")");
			break;
		case 2:
			if(this.dontFlip && this.angle > 180) angle -= 180;
			this.gtext.attr("transform").string("rotate(" + (-90 + angle) + ")");
			break;
		}
		if(this.shadow) this.gshadowrot.attr("transform").string(this.gtext.attr("transform").get());
		this.reanchor();
	}
	,getSize: function() {
		try {
			return this.g.node().getBBox();
		} catch( e ) {
			return { width : 0.0, height : 0.0};
		}
	}
	,addClass: function(name) {
		this.g.classed().add(name);
	}
	,_toggleVisibility: function() {
		this.g.style("opacity")["float"](this.visible?1:0);
	}
	,hide: function() {
		if(!this.visible) return;
		this.visible = false;
		this._toggleVisibility();
	}
	,show: function() {
		if(this.visible) return;
		this.visible = true;
		this._toggleVisibility();
	}
	,tshadow: null
	,toutline: null
	,ttext: null
	,gshadowrot: null
	,gtext: null
	,gshadow: null
	,g: null
	,visible: null
	,outline: null
	,shadow: null
	,shadowOffsetY: null
	,shadowOffsetX: null
	,dontFlip: null
	,angle: null
	,y: null
	,x: null
	,anchor: null
	,orientation: null
	,text: null
	,__class__: rg.svg.widget.Label
}
rg.svg.widget.LabelOrientation = { __ename__ : ["rg","svg","widget","LabelOrientation"], __constructs__ : ["FixedAngle","Aligned","Orthogonal"] }
rg.svg.widget.LabelOrientation.FixedAngle = function(angle) { var $x = ["FixedAngle",0,angle]; $x.__enum__ = rg.svg.widget.LabelOrientation; $x.toString = $estr; return $x; }
rg.svg.widget.LabelOrientation.Aligned = ["Aligned",1];
rg.svg.widget.LabelOrientation.Aligned.toString = $estr;
rg.svg.widget.LabelOrientation.Aligned.__enum__ = rg.svg.widget.LabelOrientation;
rg.svg.widget.LabelOrientation.Orthogonal = ["Orthogonal",2];
rg.svg.widget.LabelOrientation.Orthogonal.toString = $estr;
rg.svg.widget.LabelOrientation.Orthogonal.__enum__ = rg.svg.widget.LabelOrientation;
rg.svg.widget.LabelOrientations = function() { }
$hxClasses["rg.svg.widget.LabelOrientations"] = rg.svg.widget.LabelOrientations;
rg.svg.widget.LabelOrientations.__name__ = ["rg","svg","widget","LabelOrientations"];
rg.svg.widget.LabelOrientations.parse = function(s) {
	var name = s.split(":")[0].toLowerCase();
	switch(name) {
	case "fixed":case "angle":
		var v = Std.parseFloat(s.split(":")[1]);
		if(null == v || !Math.isFinite(v)) throw new thx.error.Error("when 'fixed' is used a number should follow the 'dash' character",null,null,{ fileName : "LabelOrientations.hx", lineNumber : 27, className : "rg.svg.widget.LabelOrientations", methodName : "parse"});
		return rg.svg.widget.LabelOrientation.FixedAngle(v);
	case "ortho":case "orthogonal":
		return rg.svg.widget.LabelOrientation.Orthogonal;
	case "align":case "aligned":
		return rg.svg.widget.LabelOrientation.Aligned;
	case "horiz":case "horizontal":
		return rg.svg.widget.LabelOrientation.FixedAngle(0);
	default:
		throw new thx.error.Error("invalid filter orientation '{0}'",null,s,{ fileName : "LabelOrientations.hx", lineNumber : 36, className : "rg.svg.widget.LabelOrientations", methodName : "parse"});
	}
}
rg.svg.widget.Sensible = function() { }
$hxClasses["rg.svg.widget.Sensible"] = rg.svg.widget.Sensible;
rg.svg.widget.Sensible.__name__ = ["rg","svg","widget","Sensible"];
rg.svg.widget.Sensible.sensibleZone = function(container,panel,click,datapointover,radius) {
	if(null == click && null == datapointover) return;
	var sensible = container.append("svg:rect").attr("class").string("sensible").attr("x")["float"](0).attr("y")["float"](0).attr("width")["float"](panel.frame.width).attr("height")["float"](panel.frame.height).attr("fill").string("#000").style("fill-opacity")["float"](0.0);
	if(null != datapointover) sensible.onNode("mousemove",function(_,_1) {
		var r = rg.svg.widget.Sensible.findDataNodeNearMouse(container,radius);
		if(r.length > 0) {
			datapointover(r[0]);
			if(null != click) sensible.classed().add("pointer");
		} else if(null != click) sensible.classed().remove("pointer");
	});
	if(null != click) {
		if(null == datapointover) sensible.onNode("mousemove",function(_,_1) {
			var r = rg.svg.widget.Sensible.findDataNodeNearMouse(container,radius);
			if(r.length > 0) sensible.classed().add("pointer"); else sensible.classed().remove("pointer");
		});
		sensible.onNode("click",function(_,_1) {
			var r = rg.svg.widget.Sensible.findDataNodeNearMouse(container,radius);
			if(r.length > 0) click(r[0]);
		});
	}
}
rg.svg.widget.Sensible.findDataNodeNearMouse = function(context,distance) {
	var e = dhx.Dom.event;
	return rg.svg.widget.Sensible.findDataNodesNear({ x : e.clientX, y : e.clientY},context,distance);
}
rg.svg.widget.Sensible.findDataNodesNear = function(coords,context,distance) {
	var nodes = context.selectAll(".rgdata"), result = [], distancep = distance * distance;
	nodes.eachNode(function(n,i) {
		var rect = n.getBoundingClientRect();
		var x = coords.x - (rect.left + rect.width / 2), y = coords.y - (rect.top + rect.height / 2);
		var dist = x * x + y * y;
		if(dist > distancep) return;
		result.push({ node : n, dist : dist});
	});
	result.sort(function(a,b) {
		return Floats.compare(a.dist,b.dist);
	});
	return Iterators.map(HxOverrides.iter(result),function(item,_) {
		return item.node;
	});
}
rg.util = {}
rg.util.ChainedExecutor = function(handler) {
	this.handler = handler;
	this.actions = [];
	this.pos = 0;
	this.executor = $bind(this,this.execute);
};
$hxClasses["rg.util.ChainedExecutor"] = rg.util.ChainedExecutor;
rg.util.ChainedExecutor.__name__ = ["rg","util","ChainedExecutor"];
rg.util.ChainedExecutor.prototype = {
	executor: null
	,execute: function(ob) {
		if(this.pos == this.actions.length) {
			this.pos = 0;
			this.handler(ob);
		} else this.actions[this.pos++](ob,$bind(this,this.execute));
	}
	,addAction: function(handler) {
		this.actions.push(handler);
	}
	,pos: null
	,actions: null
	,handler: null
	,__class__: rg.util.ChainedExecutor
}
rg.util.DataPoints = function() { }
$hxClasses["rg.util.DataPoints"] = rg.util.DataPoints;
rg.util.DataPoints.__name__ = ["rg","util","DataPoints"];
rg.util.DataPoints.partition = function(dps,property,def) {
	if(def == null) def = "default";
	var map = new thx.collection.HashList();
	var getBucket = function(n) {
		var bucket = map.get(n);
		if(null == bucket) {
			bucket = [];
			map.set(n,bucket);
		}
		return bucket;
	};
	var v, name, bucket;
	var _g = 0;
	while(_g < dps.length) {
		var dp = dps[_g];
		++_g;
		v = Reflect.field(dp,property);
		if(null == v) name = def; else name = Dynamics.string(v);
		getBucket(name).push(dp);
	}
	return map.array();
}
rg.util.DataPoints.filterByIndependents = function(dps,variables) {
	var _g = 0;
	while(_g < variables.length) {
		var variable = [variables[_g]];
		++_g;
		var values = [variable[0].axis.range(variable[0].min(),variable[0].max())];
		dps = dps.filter((function(values,variable) {
			return function(dp) {
				var v = Reflect.field(dp,variable[0].type);
				if(null == v) return false;
				return Arrays.exists(values[0],v);
			};
		})(values,variable));
	}
	return dps;
}
rg.util.DataPoints.filterByDependents = function(dps,variables) {
	var _g = 0;
	while(_g < variables.length) {
		var variable = [variables[_g]];
		++_g;
		dps = dps.filter((function(variable) {
			return function(dp) {
				if(null == Reflect.field(dp,variable[0].type)) return false; else return true;
			};
		})(variable));
	}
	return dps;
}
rg.util.DataPoints.valueAlt = function(dp,property,alt) {
	var v;
	return null == (v = Reflect.field(dp,property))?alt:v;
}
rg.util.DataPoints.values = function(dps,property) {
	return dps.map(function(dp) {
		return Reflect.field(dp,property);
	}).filter(function(d) {
		return d != null;
	});
}
rg.util.DataPoints.id = function(dp,dependentProperties) {
	var cdp = Objects.clone(dp);
	var _g = 0;
	while(_g < dependentProperties.length) {
		var p = dependentProperties[_g];
		++_g;
		Reflect.deleteField(cdp,p);
	}
	return haxe.crypto.Md5.encode(Dynamics.string(cdp));
}
rg.util.Js = function() { }
$hxClasses["rg.util.Js"] = rg.util.Js;
rg.util.Js.__name__ = ["rg","util","Js"];
rg.util.Js.findScript = function(fragment) {
	var scripts = js.Browser.document.getElementsByTagName("SCRIPT");
	if(typeof fragment == "string") {
		var _g1 = 0, _g = scripts.length;
		while(_g1 < _g) {
			var i = _g1++;
			var script = scripts[i], src = script.getAttribute("src");
			if(null != src && src.indexOf(fragment) >= 0) return script;
		}
	} else {
		var _g1 = 0, _g = scripts.length;
		while(_g1 < _g) {
			var i = _g1++;
			var script = scripts[i], src = script.getAttribute("src");
			if(null != src && src.match(fragment)) return script;
		}
	}
	return null;
}
rg.util.Jsonp = function() { }
$hxClasses["rg.util.Jsonp"] = rg.util.Jsonp;
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
$hxClasses["rg.util.Periodicity"] = rg.util.Periodicity;
rg.util.Periodicity.__name__ = ["rg","util","Periodicity"];
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
rg.util.Periodicity.unitsBetween = function(start,end,periodicity) {
	return (function($this) {
		var $r;
		switch(periodicity) {
		case "eternity":case "single":
			$r = 1;
			break;
		case "minute":
			$r = Math.floor((end - start) / 60000);
			break;
		case "hour":
			$r = Math.floor((end - start) / 3600000);
			break;
		case "day":
			$r = Math.floor((end - start) / 86400000);
			break;
		case "week":
			$r = Math.floor((end - start) / 604800000);
			break;
		case "month":
			$r = (function($this) {
				var $r;
				var s = (function($this) {
					var $r;
					var d = new Date();
					d.setTime(start);
					$r = d;
					return $r;
				}($this)), e = (function($this) {
					var $r;
					var d = new Date();
					d.setTime(end);
					$r = d;
					return $r;
				}($this)), sy = s.getFullYear(), ey = e.getFullYear(), sm = s.getMonth(), em = e.getMonth();
				$r = (ey - sy) * 12 + (em - sm);
				return $r;
			}($this));
			break;
		case "year":
			$r = Math.floor(rg.util.Periodicity.unitsBetween(start,end,"month") / 12);
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
rg.util.Periodicity.units = function(value,periodicity) {
	return rg.util.Periodicity.unitsBetween(0,value,periodicity) + (function($this) {
		var $r;
		switch(periodicity) {
		case "hour":
			$r = 1;
			break;
		default:
			$r = 0;
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
rg.util.Periodicity.smartFormat = function(periodicity,v) {
	switch(periodicity) {
	case "eternity":case "single":
		return "all time";
	case "minute":
		if(rg.util.Periodicity.firstInSeries("hour",v)) return thx.culture.FormatDate.timeShort((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this))); else return rg.util.Periodicity.formatDate("%i",(function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
		break;
	case "hour":
		if(rg.util.Periodicity.firstInSeries("day",v)) return rg.util.Periodicity.formatDate("%b %e",rg.util.Periodicity.dateUtc(v)); else return thx.culture.FormatDate.hourShort((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
		break;
	case "day":
		if(rg.util.Periodicity.firstInSeries("month",v)) return rg.util.Periodicity.formatDate("%b %e",rg.util.Periodicity.dateUtc(v)); else return rg.util.Periodicity.formatDate("%e",rg.util.Periodicity.dateUtc(v));
		break;
	case "week":
		var d = rg.util.Periodicity.dateUtc(v);
		if(d.getDate() <= 7) return rg.util.Periodicity.formatDate("%b %e",d); else return rg.util.Periodicity.formatDate("%e",d);
		break;
	case "month":
		if(rg.util.Periodicity.firstInSeries("year",v)) return thx.culture.FormatDate.year(rg.util.Periodicity.dateUtc(v)); else return rg.util.Periodicity.formatDate("%b",rg.util.Periodicity.dateUtc(v));
		break;
	case "year":
		return thx.culture.FormatDate.year(rg.util.Periodicity.dateUtc(v));
	default:
		return periodicity + ": " + Std.string((function($this) {
			var $r;
			var d = new Date();
			d.setTime(v);
			$r = d;
			return $r;
		}(this)));
	}
}
rg.util.Periodicity.formatDate = function(pattern,date) {
	return thx.culture.FormatDate.format(date,pattern);
}
rg.util.Periodicity.firstInSeries = function(periodicity,v) {
	return (function($this) {
		var $r;
		switch(periodicity) {
		case "eternity":case "single":
			$r = 0 == v;
			break;
		case "minute":
			$r = 0 == v % 60000;
			break;
		case "hour":
			$r = 0 == v % 3600000;
			break;
		case "day":
			$r = (function($this) {
				var $r;
				var d = (function($this) {
					var $r;
					var d1 = new Date();
					d1.setTime(v);
					$r = d1;
					return $r;
				}($this));
				$r = 0 == d.getHours() && 0 == d.getMinutes() && 0 == d.getSeconds();
				return $r;
			}($this));
			break;
		case "week":
			$r = (function($this) {
				var $r;
				var d = (function($this) {
					var $r;
					var d1 = new Date();
					d1.setTime(v);
					$r = d1;
					return $r;
				}($this));
				$r = 0 == d.getDay();
				return $r;
			}($this));
			break;
		case "month":
			$r = (function($this) {
				var $r;
				var d = (function($this) {
					var $r;
					var d1 = new Date();
					d1.setTime(v);
					$r = d1;
					return $r;
				}($this));
				$r = 1 == d.getDate();
				return $r;
			}($this));
			break;
		case "year":
			$r = (function($this) {
				var $r;
				var d = (function($this) {
					var $r;
					var d1 = new Date();
					d1.setTime(v);
					$r = d1;
					return $r;
				}($this));
				$r = 1 == d.getDate() && 0 == d.getMonth();
				return $r;
			}($this));
			break;
		default:
			$r = false;
		}
		return $r;
	}(this));
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
rg.util.Periodicity.isValidGroupBy = function(value) {
	return Arrays.exists(rg.util.Periodicity.validGroupValues,value);
}
rg.util.Properties = function() { }
$hxClasses["rg.util.Properties"] = rg.util.Properties;
rg.util.Properties.__name__ = ["rg","util","Properties"];
rg.util.Properties.isTime = function(s) {
	return s.indexOf("time:") >= 0;
}
rg.util.Properties.periodicity = function(s) {
	return HxOverrides.substr(s,s.indexOf("time:") + "time:".length,null);
}
rg.util.Properties.humanize = function(s) {
	return rg.util.RGStrings.humanize(s);
}
rg.util.Properties.formatValue = function(type,dp) {
	var value = Reflect.field(dp,type);
	if(null == value) return value;
	if(type.indexOf("time:") >= 0) {
		var periodicity = HxOverrides.substr(type,type.indexOf("time:") + "time:".length,null);
		return rg.util.Periodicity.format(periodicity,Dates.snap(value,periodicity));
	}
	return rg.util.RGStrings.humanize(value);
}
rg.util.RG = function() { }
$hxClasses["rg.util.RG"] = rg.util.RG;
rg.util.RG.__name__ = ["rg","util","RG"];
rg.util.RG.getTokenId = function() {
	try {
		return Strings.rtrim(Strings.ltrim(ReportGrid.$.Config.tokenId,"\""),"\"");
	} catch( e ) {
		return null;
	}
}
rg.util.RGColors = function() { }
$hxClasses["rg.util.RGColors"] = rg.util.RGColors;
rg.util.RGColors.__name__ = ["rg","util","RGColors"];
rg.util.RGColors.parse = function(s,alt) {
	try {
		var c = thx.color.Colors.parse(s);
		if(null != c) return c;
	} catch( _ ) {
	}
	return thx.color.Colors.parse(alt);
}
rg.util.RGColors.applyLightness = function(color,lightness,t) {
	if(null == t) t = 1 / Math.abs(lightness);
	return lightness >= 0?thx.color.Hsl.lighter(color,(1 - t) * (1 + lightness)):thx.color.Hsl.darker(color,(1 - t) * (1 - lightness));
}
rg.util.RGColors.extractColor = function(n) {
	return n.__rgcolor__;
}
rg.util.RGColors.storeColor = function(n,color) {
	n.__rgcolor__ = color;
}
rg.util.RGColors.storeColorForSelection = function(n,style,color) {
	if(style == null) style = "fill";
	n.eachNode(function(n1,_) {
		var c = null == color?dhx.Dom.selectNode(dhx.Group.current).style(style).get():color;
		rg.util.RGColors.storeColor(n1,c);
	});
}
rg.util.RGStrings = function() { }
$hxClasses["rg.util.RGStrings"] = rg.util.RGStrings;
rg.util.RGStrings.__name__ = ["rg","util","RGStrings"];
rg.util.RGStrings.humanize = function(d) {
	if(js.Boot.__instanceof(d,Int)) return Ints.format(d);
	if(js.Boot.__instanceof(d,Float)) return Floats.format(d);
	var s = Std.string(d);
	if(rg.util.RGStrings.range.match(s)) {
		var v1 = rg.util.RGStrings.range.matched(1), v2 = rg.util.RGStrings.range.matched(2);
		if(null != v1) v1 = Ints.canParse(v1)?Ints.format(Ints.parse(v1)):Floats.format(Floats.parse(v1)); else v1 = "";
		if(null != v2) v2 = Ints.canParse(v2)?Ints.format(Ints.parse(v2)):Floats.format(Floats.parse(v2)); else v2 = "";
		return rg.util.RGStrings.hstring(rg.util.RGStrings.range.matchedLeft()) + v1 + "-" + v2 + rg.util.RGStrings.hstring(rg.util.RGStrings.range.matchedRight());
	} else return rg.util.RGStrings.hstring(s);
}
rg.util.RGStrings.hstring = function(s) {
	return Strings.ucwords(Strings.humanize(s));
}
rg.util.Urls = function() { }
$hxClasses["rg.util.Urls"] = rg.util.Urls;
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
rg.util.Urls.parseQueryParameters = function(url) {
	var index = url.indexOf("?");
	if(index < 0) return { };
	var query = HxOverrides.substr(url,index + 1,null), keyValuePairs = query.split("&"), parameters = { };
	var _g = 0;
	while(_g < keyValuePairs.length) {
		var pair = keyValuePairs[_g];
		++_g;
		var split = pair.split("="), key = split[0], value = null == split[1]?null:StringTools.urlDecode(split[1]);
		parameters[key] = value;
	}
	return parameters;
}
rg.visualization = {}
rg.visualization.Visualization = function(container) {
	this.container = container;
};
$hxClasses["rg.visualization.Visualization"] = rg.visualization.Visualization;
rg.visualization.Visualization.__name__ = ["rg","visualization","Visualization"];
rg.visualization.Visualization.prototype = {
	addError: function(handler) {
		this.error.add(handler);
	}
	,addReady: function(handler) {
		this.ready.add(handler);
		if(this.hasRendered) handler();
	}
	,addReadyOnce: function(handler) {
		this.ready.addOnce(handler);
		if(this.hasRendered) handler();
	}
	,_feedData: function(data) {
	}
	,feedData: function(data) {
		try {
			this._feedData(data);
		} catch( e ) {
			this.error.dispatch(e);
		}
	}
	,_init: function() {
		throw new thx.error.AbstractMethod({ fileName : "Visualization.hx", lineNumber : 54, className : "rg.visualization.Visualization", methodName : "_init"});
	}
	,init: function() {
		try {
			this._init();
		} catch( e ) {
			this.error.dispatch(e);
		}
	}
	,setVariables: function(variables,independentVariables,dependentVariables) {
		var _g = this;
		this.variables = variables;
		this.independentVariables = independentVariables;
		this.dependentVariables = dependentVariables;
		this.hasRendered = false;
		this.ready = new hxevents.Notifier();
		this.ready.addOnce(function() {
			_g.hasRendered = true;
		});
		this.error = new hxevents.Dispatcher();
		this.error.addOnce(function(_) {
			_g.ready.dispatch();
		});
	}
	,hasRendered: null
	,error: null
	,ready: null
	,container: null
	,variables: null
	,dependentVariables: null
	,independentVariables: null
	,__class__: rg.visualization.Visualization
}
rg.visualization.VisualizationSvg = function(layout) {
	rg.visualization.Visualization.call(this,layout.container);
	this.layout = layout;
};
$hxClasses["rg.visualization.VisualizationSvg"] = rg.visualization.VisualizationSvg;
rg.visualization.VisualizationSvg.__name__ = ["rg","visualization","VisualizationSvg"];
rg.visualization.VisualizationSvg.__super__ = rg.visualization.Visualization;
rg.visualization.VisualizationSvg.prototype = $extend(rg.visualization.Visualization.prototype,{
	layout: null
	,baseChart: null
	,__class__: rg.visualization.VisualizationSvg
});
rg.visualization.VisualizationCartesian = function(layout) {
	rg.visualization.VisualizationSvg.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationCartesian"] = rg.visualization.VisualizationCartesian;
rg.visualization.VisualizationCartesian.__name__ = ["rg","visualization","VisualizationCartesian"];
rg.visualization.VisualizationCartesian.__super__ = rg.visualization.VisualizationSvg;
rg.visualization.VisualizationCartesian.prototype = $extend(rg.visualization.VisualizationSvg.prototype,{
	createRules: function(i,type,orientation) {
		var displayMinor = this.info.displayMinorRule(type), displayMajor = this.info.displayMajorRule(type), displayAnchorLine = this.info.displayAnchorLineRule(type), title = null != this.info.label.axis?this.info.label.axis(type):null, rules = null, panel;
		if(displayMinor || displayMajor) {
			panel = this.layout.getPanel("main");
			if(null == panel) return null;
			rules = new rg.svg.layer.RulesOrtho(panel,orientation);
			rules.displayMinor = displayMinor;
			rules.displayMajor = displayMajor;
			rules.displayAnchorLine = displayAnchorLine;
			rules.init();
		}
		return rules;
	}
	,createTickmarks: function(i,type,pname) {
		var _g = this;
		var displayMinor = this.info.displayMinorTick(type), displayMajor = this.info.displayMajorTick(type), displayLabel = this.info.displayLabelTick(type), displayAnchorLine = this.info.displayAnchorLineTick(type), title = null != this.info.label.axis?this.info.label.axis(type):null, tickmarks = null, context;
		if(displayMinor || displayMajor || displayLabel || displayAnchorLine) {
			context = this.layout.getContext(pname);
			if(null == context) return null;
			tickmarks = new rg.svg.layer.TickmarksOrtho(context.panel,context.anchor);
			this.setTickmarksDefaults(tickmarks,i,type,pname);
			if(!displayLabel) tickmarks.displayLabel = false; else if(null != this.info.label.tickmark) tickmarks.tickLabel = function(d) {
				return _g.info.label.tickmark(d,type);
			};
			tickmarks.displayMinor = displayMinor;
			tickmarks.displayMajor = displayMajor;
			tickmarks.lengthMinor = this.info.lengthTickMinor;
			tickmarks.lengthMajor = this.info.lengthTickMajor;
			tickmarks.paddingMinor = this.info.paddingTickMinor;
			tickmarks.paddingMajor = this.info.paddingTickMajor;
			tickmarks.paddingLabel = this.info.paddingLabel;
			var s;
			s = this.info.labelAnchor(type);
			if(null != s) tickmarks.labelAnchor = rg.svg.widget.GridAnchors.parse(s);
			s = this.info.labelOrientation(type);
			if(null != s) tickmarks.labelOrientation = rg.svg.widget.LabelOrientations.parse(s);
			var a;
			if(null != (a = this.info.labelAngle(type))) tickmarks.labelAngle = a;
			tickmarks.displayAnchorLine = displayAnchorLine;
		}
		if(null != title && null != (context = this.layout.getContext(pname + "title"))) {
			var t = new rg.svg.layer.Title(context.panel,title,context.anchor,null,"axis-title");
			var h = t.idealHeight();
			this.layout.suggestSize(pname + "title",h);
		}
		if(null != tickmarks) tickmarks.init();
		return tickmarks;
	}
	,setTickmarksDefaults: function(tickmarks,i,type,pname) {
	}
	,transformData: function(dps) {
		return (function($this) {
			var $r;
			throw new thx.error.AbstractMethod({ fileName : "VisualizationCartesian.hx", lineNumber : 167, className : "rg.visualization.VisualizationCartesian", methodName : "transformData"});
			return $r;
		}(this));
	}
	,_feedData: function(data) {
		if(0 == data.length) return;
		if(null != this.title && null != this.info.label.title) {
			this.title.set_text(this.info.label.title(this.variables,data,this.variables.map(function(variable) {
				return variable.type;
			})));
			this.layout.suggestSize("title",this.title.idealHeight());
		}
		var transformed = this.transformData(data);
		this.chart.setVariables(this.variables,this.independentVariables,this.dependentVariables,transformed);
		var _g1 = 0, _g = this.ylabels.length;
		while(_g1 < _g) {
			var i = _g1++;
			var item = this.ylabels[i], variable = this.yvariables[item.id];
			item.tickmarks.update(variable.axis,variable.min(),variable.max());
			var size = Math.round(item.tickmarks.desiredSize);
			this.layout.suggestSize("y" + item.id,size);
		}
		var _g1 = 0, _g = this.yrules.length;
		while(_g1 < _g) {
			var i = _g1++;
			var item = this.yrules[i], variable = this.yvariables[item.id];
			item.rules.update(variable.axis,variable.min(),variable.max());
		}
		if(null != this.xlabel) {
			var variable = this.xvariable;
			this.xlabel.update(variable.axis,variable.min(),variable.max());
			var size = Math.round(this.xlabel.desiredSize);
			this.layout.suggestSize("x",size);
		}
		if(null != this.xrule) {
			var variable = this.xvariable;
			this.xrule.update(variable.axis,variable.min(),variable.max());
		}
		this.chart.data(transformed);
	}
	,initTitle: function() {
		if(null == this.info.label.title) return;
		var panelContextTitle = this.layout.getContext("title");
		if(null == panelContextTitle) return;
		this.title = new rg.svg.layer.Title(panelContextTitle.panel,null,panelContextTitle.anchor);
	}
	,initCartesianChart: function() {
		this.chart.animated = this.info.animation.animated;
		this.chart.animationDuration = this.info.animation.duration;
		this.chart.animationEase = this.info.animation.ease;
		this.chart.click = this.info.click;
		this.chart.labelDataPoint = this.info.label.datapoint;
		this.chart.labelDataPointOver = this.info.label.datapointover;
		this.chart.labelDataPointVerticalOffset = this.info.label.datapointverticaloffset;
		this.chart.labelDataPointOutline = this.info.label.datapointoutline;
		this.chart.labelDataPointShadow = this.info.label.datapointshadow;
		this.chart.init();
	}
	,initChart: function() {
		throw new thx.error.AbstractMethod({ fileName : "VisualizationCartesian.hx", lineNumber : 88, className : "rg.visualization.VisualizationCartesian", methodName : "initChart"});
	}
	,initXAxis: function() {
		this.xlabel = this.createTickmarks(0,this.xvariable.type,"x");
		this.xrule = this.createRules(0,this.xvariable.type,rg.frame.Orientation.Vertical);
	}
	,initYAxes: function() {
		this.ylabels = [];
		this.yrules = [];
		var _g1 = 0, _g = this.yvariables.length;
		while(_g1 < _g) {
			var i = _g1++;
			var tickmarks = this.createTickmarks(i + 1,this.yvariables[i].type,"y" + i), rules = this.createRules(i + 1,this.yvariables[i].type,rg.frame.Orientation.Horizontal);
			if(null != tickmarks) this.ylabels.push({ id : i, tickmarks : tickmarks});
			if(null != rules) this.yrules.push({ id : i, rules : rules});
		}
	}
	,initPadding: function() {
		this.layout.adjustPadding();
	}
	,initAxes: function() {
		throw new thx.error.AbstractMethod({ fileName : "VisualizationCartesian.hx", lineNumber : 46, className : "rg.visualization.VisualizationCartesian", methodName : "initAxes"});
	}
	,_init: function() {
		this.initAxes();
		this.initYAxes();
		this.initXAxis();
		this.initTitle();
		this.initPadding();
		this.initChart();
		this.initCartesianChart();
	}
	,yvariables: null
	,xvariable: null
	,title: null
	,yrules: null
	,ylabels: null
	,xrule: null
	,xlabel: null
	,chart: null
	,info: null
	,__class__: rg.visualization.VisualizationCartesian
});
rg.visualization.VisualizationBarChart = function(layout) {
	rg.visualization.VisualizationCartesian.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationBarChart"] = rg.visualization.VisualizationBarChart;
rg.visualization.VisualizationBarChart.__name__ = ["rg","visualization","VisualizationBarChart"];
rg.visualization.VisualizationBarChart.__super__ = rg.visualization.VisualizationCartesian;
rg.visualization.VisualizationBarChart.prototype = $extend(rg.visualization.VisualizationCartesian.prototype,{
	transformData: function(dps) {
		var results = [], variable = this.independentVariables[0], values = variable.axis.range(variable.min(),variable.max());
		if(variable.type.indexOf("time:") >= 0) {
			var periodicity = rg.util.Properties.periodicity(variable.type);
			var _g = 0;
			while(_g < values.length) {
				var value = [values[_g]];
				++_g;
				var axisresults = [];
				var _g2 = 0, _g1 = this.dependentVariables.length;
				while(_g2 < _g1) {
					var i = _g2++;
					var dps1 = rg.util.DataPoints.filterByDependents(dps,[this.dependentVariables[i]]);
					axisresults.push(dps1.filter((function(value) {
						return function(d) {
							return Dates.snap(Reflect.field(d,variable.type),periodicity) == value[0];
						};
					})(value)));
				}
				results.push(axisresults);
			}
		} else {
			var _g = 0;
			while(_g < values.length) {
				var value1 = [values[_g]];
				++_g;
				var axisresults = [];
				var _g2 = 0, _g1 = this.dependentVariables.length;
				while(_g2 < _g1) {
					var i = _g2++;
					var dps1 = rg.util.DataPoints.filterByDependents(dps,[this.dependentVariables[i]]);
					axisresults.push(dps1.filter((function(value1) {
						return function(d) {
							return Reflect.field(d,variable.type) == value1[0];
						};
					})(value1)));
				}
				results.push(axisresults);
			}
		}
		var svalues = null;
		if(null != this.infoBar.segment.on) {
			var segmenton = this.infoBar.segment.on;
			svalues = new thx.collection.Set();
			if(this.infoBar.segment.values.length != 0) {
				var _g = 0, _g1 = this.infoBar.segment.values;
				while(_g < _g1.length) {
					var value = _g1[_g];
					++_g;
					svalues.add(value);
				}
			} else dps.forEach(function(dp,_) {
				svalues.add(Reflect.field(dp,segmenton));
			});
			var svalues1 = svalues.array();
			var _g1 = 0, _g = values.length;
			while(_g1 < _g) {
				var i = _g1++;
				var _g3 = 0, _g2 = this.dependentVariables.length;
				while(_g3 < _g2) {
					var j = _g3++;
					var segment = results[i][j], replace = [], pos = 0;
					var _g5 = 0, _g4 = svalues1.length;
					while(_g5 < _g4) {
						var k = _g5++;
						var svalue = svalues1[k];
						var _g7 = 0, _g6 = segment.length;
						while(_g7 < _g6) {
							var m = _g7++;
							var seg = Reflect.field(segment[m],segmenton);
							if(svalue == seg) replace.push(segment[m]);
						}
					}
					results[i][j] = replace;
				}
			}
		}
		return { data : results, segments : null == svalues?null:svalues.array()};
	}
	,initChart: function() {
		var _g = this;
		var chart = new rg.svg.chart.BarChart(this.layout.getPanel(this.layout.mainPanelName));
		this.baseChart = chart;
		chart.ready.add(function() {
			_g.ready.dispatch();
		});
		chart.stacked = this.infoBar.stacked;
		var _g1 = this;
		var $e = (_g1.infoBar.effect);
		switch( $e[1] ) {
		case 0:
			chart.displayGradient = false;
			break;
		case 1:
			var lightness = $e[2];
			chart.displayGradient = true;
			chart.gradientLightness = lightness;
			break;
		}
		chart.barClass = this.infoBar.barclass;
		chart.padding = this.infoBar.barPadding;
		chart.paddingAxis = this.infoBar.barPaddingAxis;
		chart.paddingDataPoint = this.infoBar.barPaddingDataPoint;
		chart.horizontal = this.infoBar.horizontal;
		chart.startat = this.infoBar.startat;
		chart.segmentProperty = this.infoBar.segment.on;
		this.chart = chart;
	}
	,initAxes: function() {
		if(this.infoBar.horizontal) {
			this.xvariable = this.dependentVariables.map(function(d) {
				return d;
			})[0];
			this.yvariables = [this.independentVariables[0]];
		} else {
			this.yvariables = this.dependentVariables.map(function(d) {
				return d;
			});
			this.xvariable = this.independentVariables[0];
		}
	}
	,infoBar: null
	,__class__: rg.visualization.VisualizationBarChart
});
rg.visualization.VisualizationFunnelChart = function(layout) {
	rg.visualization.VisualizationSvg.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationFunnelChart"] = rg.visualization.VisualizationFunnelChart;
rg.visualization.VisualizationFunnelChart.__name__ = ["rg","visualization","VisualizationFunnelChart"];
rg.visualization.VisualizationFunnelChart.__super__ = rg.visualization.VisualizationSvg;
rg.visualization.VisualizationFunnelChart.prototype = $extend(rg.visualization.VisualizationSvg.prototype,{
	_feedData: function(data) {
		this.chart.setVariables(this.independentVariables,this.dependentVariables);
		var data1 = rg.util.DataPoints.filterByIndependents(rg.util.DataPoints.filterByDependents(data,this.dependentVariables),this.independentVariables);
		if(null != this.info.sortDataPoint) data1.sort(this.info.sortDataPoint);
		if(null != this.title) {
			if(null != this.info.label.title) {
				this.title.set_text(this.info.label.title(this.variables,data1,this.variables.map(function(variable) {
					return variable.type;
				})));
				this.layout.suggestSize("title",this.title.idealHeight());
			} else this.layout.suggestSize("title",0);
		}
		if(null != this.info.sortDataPoint) data1.sort(this.info.sortDataPoint);
		this.chart.init();
		this.chart.data(data1);
	}
	,_init: function() {
		var _g = this;
		var panelChart = this.layout.getPanel(this.layout.mainPanelName);
		this.chart = new rg.svg.chart.FunnelChart(panelChart);
		this.baseChart = this.chart;
		this.chart.ready.add(function() {
			_g.ready.dispatch();
		});
		if(null != this.info.label.datapoint) this.chart.labelDataPoint = this.info.label.datapoint;
		if(null != this.info.label.datapoint) this.chart.labelDataPointOver = this.info.label.datapointover;
		if(null != this.info.label.arrow) this.chart.labelArrow = this.info.label.arrow;
		if(null != this.info.click) this.chart.click = this.info.click;
		this.chart.padding = this.info.padding;
		this.chart.flatness = this.info.flatness;
		var _g1 = this;
		var $e = (_g1.info.effect);
		switch( $e[1] ) {
		case 1:
			var v = $e[2];
			this.chart.displayGradient = true;
			this.chart.gradientLightness = v;
			break;
		case 0:
			this.chart.displayGradient = false;
			break;
		}
		this.chart.arrowSize = this.info.arrowSize;
		if(null != this.info.label.title) {
			var panelContextTitle = this.layout.getContext("title");
			if(null == panelContextTitle) return;
			this.title = new rg.svg.layer.Title(panelContextTitle.panel,null,panelContextTitle.anchor);
		}
	}
	,chart: null
	,title: null
	,info: null
	,__class__: rg.visualization.VisualizationFunnelChart
});
rg.visualization.VisualizationGeo = function(layout) {
	rg.visualization.VisualizationSvg.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationGeo"] = rg.visualization.VisualizationGeo;
rg.visualization.VisualizationGeo.__name__ = ["rg","visualization","VisualizationGeo"];
rg.visualization.VisualizationGeo.__super__ = rg.visualization.VisualizationSvg;
rg.visualization.VisualizationGeo.prototype = $extend(rg.visualization.VisualizationSvg.prototype,{
	_feedData: function(data) {
		this.chart.setVariables(this.independentVariables,this.dependentVariables,data);
		if(null != this.title) {
			if(null != this.info.label.title) {
				this.title.set_text(this.info.label.title(this.variables,data,this.variables.map(function(variable) {
					return variable.type;
				})));
				this.layout.suggestSize("title",this.title.idealHeight());
			} else this.layout.suggestSize("title",0);
		}
		this.chart.init();
		this.chart.data(data);
	}
	,_init: function() {
		var _g = this;
		if(null != this.info.label.title) {
			var panelContextTitle = this.layout.getContext("title");
			if(null == panelContextTitle) return;
			this.title = new rg.svg.layer.Title(panelContextTitle.panel,null,panelContextTitle.anchor);
		}
		var panelChart = this.layout.getPanel(this.layout.mainPanelName);
		this.chart = new rg.svg.chart.Geo(panelChart);
		this.chart.labelOutline = this.info.labelOutline;
		this.chart.labelShadow = this.info.labelShadow;
		this.baseChart = this.chart;
		this.chart.ready.add(function() {
			_g.ready.dispatch();
		});
		var pfactory = new rg.factory.FactoryGeoProjection();
		var _g1 = 0, _g11 = this.info.map;
		while(_g1 < _g11.length) {
			var imap = _g11[_g1];
			++_g1;
			var projection = pfactory.create(imap), map = new rg.svg.widget.GeoMap(this.chart.mapcontainer,projection);
			map.set_className(imap.classname);
			if(null == imap.label) map.labelDataPoint = this.info.label.datapoint; else map.labelDataPoint = imap.label.datapoint;
			if(null == imap.label) map.labelDataPointOver = this.info.label.datapointover; else map.labelDataPointOver = imap.label.datapointover;
			map.click = imap.click;
			map.radius = imap.radius;
			map.colorMode = imap.colorScaleMode;
			map.handlerClick = ($_=this.chart,$bind($_,$_.handlerClick));
			map.handlerDataPointOver = ($_=this.chart,$bind($_,$_.handlerDataPointOver));
			map.mapping = imap.mapping;
			var mappingurl = imap.mappingurl;
			if(null != mappingurl && (!StringTools.startsWith(mappingurl,"http://") || !StringTools.startsWith(mappingurl,"https://"))) mappingurl = rg.RGConst.BASE_URL_GEOJSON + mappingurl + ".json" + (imap.usejsonp?".js":"");
			map.load(imap.url,imap.type,mappingurl,imap.usejsonp);
			this.chart.addMap(map,imap.property);
		}
	}
	,chart: null
	,title: null
	,info: null
	,__class__: rg.visualization.VisualizationGeo
});
rg.visualization.VisualizationHeatGrid = function(layout) {
	rg.visualization.VisualizationCartesian.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationHeatGrid"] = rg.visualization.VisualizationHeatGrid;
rg.visualization.VisualizationHeatGrid.__name__ = ["rg","visualization","VisualizationHeatGrid"];
rg.visualization.VisualizationHeatGrid.__super__ = rg.visualization.VisualizationCartesian;
rg.visualization.VisualizationHeatGrid.prototype = $extend(rg.visualization.VisualizationCartesian.prototype,{
	setTickmarksDefaults: function(tickmarks,i,type,pname) {
		if(i != 0) return;
		tickmarks.labelAnchor = rg.svg.widget.GridAnchor.Left;
		tickmarks.labelAngle = 180;
	}
	,transformData: function(dps) {
		return dps;
	}
	,initChart: function() {
		var _g = this;
		var chart = new rg.svg.chart.HeatGrid(this.layout.getPanel(this.layout.mainPanelName));
		this.baseChart = chart;
		chart.ready.add(function() {
			_g.ready.dispatch();
		});
		chart.useContour = this.infoHeatGrid.contour;
		chart.set_colorMode(this.infoHeatGrid.colorScaleMode);
		this.chart = chart;
	}
	,initAxes: function() {
		this.xvariable = this.independentVariables[0];
		this.yvariables = [this.independentVariables[1]];
	}
	,infoHeatGrid: null
	,__class__: rg.visualization.VisualizationHeatGrid
});
rg.visualization.VisualizationHtml = function(container) {
	rg.visualization.Visualization.call(this,container);
	container.classed().add("rg");
};
$hxClasses["rg.visualization.VisualizationHtml"] = rg.visualization.VisualizationHtml;
rg.visualization.VisualizationHtml.__name__ = ["rg","visualization","VisualizationHtml"];
rg.visualization.VisualizationHtml.__super__ = rg.visualization.Visualization;
rg.visualization.VisualizationHtml.prototype = $extend(rg.visualization.Visualization.prototype,{
	__class__: rg.visualization.VisualizationHtml
});
rg.visualization.VisualizationLeaderboard = function(container) {
	rg.visualization.VisualizationHtml.call(this,container);
};
$hxClasses["rg.visualization.VisualizationLeaderboard"] = rg.visualization.VisualizationLeaderboard;
rg.visualization.VisualizationLeaderboard.__name__ = ["rg","visualization","VisualizationLeaderboard"];
rg.visualization.VisualizationLeaderboard.__super__ = rg.visualization.VisualizationHtml;
rg.visualization.VisualizationLeaderboard.prototype = $extend(rg.visualization.VisualizationHtml.prototype,{
	_feedData: function(data) {
		this.chart.setVariables(this.independentVariables,this.dependentVariables);
		this.chart.data(data);
	}
	,_init: function() {
		var _g = this;
		this.chart = new rg.html.chart.Leadeboard(this.container);
		this.chart.ready.add(function() {
			_g.ready.dispatch();
		});
		if(null != this.info.label.datapoint) this.chart.labelDataPoint = this.info.label.datapoint;
		if(null != this.info.label.datapointover) this.chart.labelDataPointOver = this.info.label.datapointover;
		if(null != this.info.label.rank) this.chart.labelRank = this.info.label.rank;
		if(null != this.info.label.value) this.chart.labelValue = this.info.label.value;
		this.chart.animated = this.info.animation.animated;
		this.chart.animationDuration = this.info.animation.duration;
		this.chart.animationDelay = this.info.animation.delay;
		this.chart.animationEase = this.info.animation.ease;
		this.chart.useMax = this.info.usemax;
		this.chart.displayBar = this.info.displaybar;
		this.chart.colorScale = this.info.colorscale;
		if(null != this.info.click) this.chart.click = this.info.click;
		if(null != this.info.sortDataPoint) this.chart.sortDataPoint = this.info.sortDataPoint;
		this.chart.init();
	}
	,chart: null
	,info: null
	,__class__: rg.visualization.VisualizationLeaderboard
});
rg.visualization.VisualizationLineChart = function(layout) {
	rg.visualization.VisualizationCartesian.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationLineChart"] = rg.visualization.VisualizationLineChart;
rg.visualization.VisualizationLineChart.__name__ = ["rg","visualization","VisualizationLineChart"];
rg.visualization.VisualizationLineChart.__super__ = rg.visualization.VisualizationCartesian;
rg.visualization.VisualizationLineChart.prototype = $extend(rg.visualization.VisualizationCartesian.prototype,{
	transformData: function(dps) {
		var results = [], segmenter = new rg.data.Segmenter(this.infoLine.segment.on,this.infoLine.segment.transform,this.infoLine.segment.scale,this.infoLine.segment.values);
		var _g1 = 0, _g = this.dependentVariables.length;
		while(_g1 < _g) {
			var i = _g1++;
			var variable = this.dependentVariables[i];
			var values = rg.util.DataPoints.filterByDependents(dps,[variable]);
			results.push(segmenter.segment(values));
		}
		return results;
	}
	,initChart: function() {
		var _g = this;
		var chart = new rg.svg.chart.LineChart(this.layout.getPanel(this.layout.mainPanelName));
		this.baseChart = chart;
		chart.ready.add(function() {
			_g.ready.dispatch();
		});
		chart.symbol = this.infoLine.symbol;
		chart.symbolStyle = this.infoLine.symbolStyle;
		chart.lineInterpolator = this.infoLine.interpolation;
		chart.lineEffect = this.infoLine.effect;
		chart.sensibleRadius = this.infoLine.sensibleradius;
		if(null == this.independentVariables[0].scaleDistribution) this.independentVariables[0].scaleDistribution = rg.axis.ScaleDistribution.ScaleFill;
		if(null != this.infoLine.y0property) chart.y0property = this.infoLine.y0property; else if(this.infoLine.displayarea) chart.y0property = "";
		this.chart = chart;
	}
	,initAxes: function() {
		this.xvariable = this.variables[0];
		this.yvariables = this.variables.slice(1);
	}
	,infoLine: null
	,__class__: rg.visualization.VisualizationLineChart
});
rg.visualization.VisualizationPieChart = function(layout) {
	rg.visualization.VisualizationSvg.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationPieChart"] = rg.visualization.VisualizationPieChart;
rg.visualization.VisualizationPieChart.__name__ = ["rg","visualization","VisualizationPieChart"];
rg.visualization.VisualizationPieChart.__super__ = rg.visualization.VisualizationSvg;
rg.visualization.VisualizationPieChart.prototype = $extend(rg.visualization.VisualizationSvg.prototype,{
	_feedData: function(data) {
		this.chart.setVariables(this.independentVariables,this.dependentVariables);
		if(null != this.title) {
			if(null != this.info.label.title) {
				this.title.set_text(this.info.label.title(this.variables,data,this.variables.map(function(variable) {
					return variable.type;
				})));
				this.layout.suggestSize("title",this.title.idealHeight());
			} else this.layout.suggestSize("title",0);
		}
		if(null != this.info.sortDataPoint) data.sort(this.info.sortDataPoint);
		this.chart.init();
		this.chart.data(data);
	}
	,_init: function() {
		var _g = this;
		var panelChart = this.layout.getPanel(this.layout.mainPanelName);
		this.chart = new rg.svg.chart.PieChart(panelChart);
		this.baseChart = this.chart;
		this.chart.ready.add(function() {
			_g.ready.dispatch();
		});
		this.chart.innerRadius = this.info.innerradius;
		this.chart.outerRadius = this.info.outerradius;
		this.chart.overRadius = this.info.overradius;
		this.chart.tooltipRadius = this.info.tooltipradius;
		var _g1 = this;
		var $e = (_g1.info.effect);
		switch( $e[1] ) {
		case 1:
			var v = $e[2];
			this.chart.displayGradient = true;
			this.chart.gradientLightness = v;
			break;
		case 0:
			this.chart.displayGradient = false;
			break;
		}
		this.chart.labelDataPoint = this.info.label.datapoint;
		this.chart.labelDataPointOver = this.info.label.datapointover;
		this.chart.labelRadius = this.info.labelradius;
		this.chart.labelOrientation = this.info.labelorientation;
		this.chart.labelDontFlip = this.info.dontfliplabel;
		this.chart.animated = this.info.animation.animated;
		this.chart.animationDuration = this.info.animation.duration;
		this.chart.animationEase = this.info.animation.ease;
		this.chart.animationDelay = this.info.animation.delay;
		if(null != this.info.click) this.chart.mouseClick = this.info.click;
		if(null != this.info.label.title) {
			var panelContextTitle = this.layout.getContext("title");
			if(null == panelContextTitle) return;
			this.title = new rg.svg.layer.Title(panelContextTitle.panel,null,panelContextTitle.anchor);
		}
	}
	,info: null
	,title: null
	,chart: null
	,__class__: rg.visualization.VisualizationPieChart
});
rg.visualization.VisualizationPivotTable = function(container) {
	rg.visualization.VisualizationHtml.call(this,container);
};
$hxClasses["rg.visualization.VisualizationPivotTable"] = rg.visualization.VisualizationPivotTable;
rg.visualization.VisualizationPivotTable.__name__ = ["rg","visualization","VisualizationPivotTable"];
rg.visualization.VisualizationPivotTable.__super__ = rg.visualization.VisualizationHtml;
rg.visualization.VisualizationPivotTable.prototype = $extend(rg.visualization.VisualizationHtml.prototype,{
	_feedData: function(data) {
		this.chart.setVariables(this.independentVariables,this.dependentVariables);
		this.chart.data(data);
	}
	,_init: function() {
		var _g = this;
		this.chart = new rg.html.chart.PivotTable(this.container);
		this.chart.ready.add(function() {
			_g.ready.dispatch();
		});
		this.chart.displayColumnTotal = this.info.displayColumnTotal;
		this.chart.displayHeatMap = this.info.displayHeatmap;
		this.chart.displayRowTotal = this.info.displayRowTotal;
		this.chart.colorStart = this.info.heatmapColorStart;
		this.chart.colorEnd = this.info.heatmapColorEnd;
		this.chart.cellclass = this.info.cellclass;
		this.chart.valueclass = this.info.valueclass;
		this.chart.headerclass = this.info.headerclass;
		this.chart.totalclass = this.info.totalclass;
		if(null != this.info.click) this.chart.click = this.info.click;
		if(null != this.info.label.datapoint) this.chart.labelDataPoint = this.info.label.datapoint;
		if(null != this.info.label.datapointover) this.chart.labelDataPointOver = this.info.label.datapointover;
		if(null != this.info.label.axis) this.chart.labelAxis = this.info.label.axis;
		if(null != this.info.label.axisvalue) this.chart.labelAxisValue = this.info.label.axisvalue;
		if(null != this.info.label.total) this.chart.labelTotal = this.info.label.total;
		if(null != this.info.label.totalover) this.chart.labelTotalOver = this.info.label.totalover;
		this.chart.incolumns = Ints.min(this.info.columnAxes,this.independentVariables.length);
		this.chart.init();
	}
	,chart: null
	,info: null
	,__class__: rg.visualization.VisualizationPivotTable
});
rg.visualization.VisualizationSankey = function(layout) {
	rg.visualization.VisualizationSvg.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationSankey"] = rg.visualization.VisualizationSankey;
rg.visualization.VisualizationSankey.__name__ = ["rg","visualization","VisualizationSankey"];
rg.visualization.VisualizationSankey.defaultIdf = function(idf) {
	if(idf == null) return function(data) {
		return data.id;
	}; else return idf;
}
rg.visualization.VisualizationSankey.defaultNodef = function(nodef) {
	if(nodef == null) {
		var dummynodeid = 0;
		return function(edge) {
			return { id : "#" + ++dummynodeid, weight : edge.weight, entry : 0.0, exit : 0.0};
		};
	} else return nodef;
}
rg.visualization.VisualizationSankey.defaultEdgesf = function(idf,edgesf) {
	if(edgesf == null) return function(dp) {
		var r = [], id = idf(dp);
		var _g = 0, _g1 = Reflect.fields(dp.parents);
		while(_g < _g1.length) {
			var parent = _g1[_g];
			++_g;
			r.push({ head : id, tail : parent, weight : Reflect.field(dp.parents,parent)});
		}
		return r;
	}; else return edgesf;
}
rg.visualization.VisualizationSankey.__super__ = rg.visualization.VisualizationSvg;
rg.visualization.VisualizationSankey.prototype = $extend(rg.visualization.VisualizationSvg.prototype,{
	defaultWeightf: function(weightf) {
		if(null == weightf) {
			var type = this.dependentVariables[0].type;
			return function(dp) {
				var v = Reflect.field(dp,type);
				return null != v?v:0.0;
			};
		} else return weightf;
	}
	,sugiyama: function(graph,nodef) {
		return new thx.graph.SugiyamaMethod().resolve(graph,nodef);
	}
	,weightBalance: function(graph,nodef) {
		var layout = new thx.graph.GraphLayout(graph,new thx.graph.HeaviestNodeLayer().lay(graph));
		layout = new thx.graph.EdgeSplitter().split(layout,[],nodef);
		layout = thx.graph.GreedySwitchDecrosser.best().decross(layout);
		return layout;
	}
	,layoutData: function(data,method,idf,nodef,weightf,edgesf) {
		var graph = this.createGraph(data,idf,weightf,edgesf);
		nodef = rg.visualization.VisualizationSankey.defaultNodef(nodef);
		switch(method) {
		case "weightbalance":
			return this.weightBalance(graph,nodef);
		default:
			return this.sugiyama(graph,nodef);
		}
	}
	,extractEdges: function(data) {
		return data.filter(function(dp) {
			return dp.head != null && dp.tail != null;
		});
	}
	,extractNodes: function(data) {
		var nodes = data.filter(function(dp) {
			return dp.id != null;
		});
		if(nodes.length == 0) {
			var type = this.dependentVariables[0].type, map = new haxe.ds.StringMap(), edges = data.filter(function(dp) {
				return Reflect.hasField(dp,"head") || Reflect.hasField(dp,"tail");
			});
			var nodize = function(name,istail,weight) {
				if(null == name) return;
				var n = map.get(name);
				if(null == n) {
					n = { node : { id : name}, positive : 0.0, negative : 0.0};
					map.set(name,n);
				}
				if(istail) n.positive += weight; else n.negative += weight;
			};
			edges.forEach(function(dp,i) {
				var v = Reflect.field(dp,type);
				nodize(dp.tail,true,v);
				nodize(dp.head,false,v);
			});
			nodes = Iterators.array(map.iterator()).map(function(n) {
				var node = n.node;
				node[type] = Math.max(n.positive,n.negative);
				return node;
			});
		}
		return nodes;
	}
	,createGraph: function(data,idf,weightf,edgesf) {
		idf = rg.visualization.VisualizationSankey.defaultIdf(idf);
		edgesf = rg.visualization.VisualizationSankey.defaultEdgesf(idf,edgesf);
		weightf = this.defaultWeightf(weightf);
		var graph = new thx.graph.Graph(idf);
		var nodes = this.extractNodes(data), edges = this.extractEdges(data);
		var _g = 0;
		while(_g < nodes.length) {
			var dp = nodes[_g];
			++_g;
			graph.nodes.create({ dp : dp, id : idf(dp), weight : weightf(dp), entry : 0.0, exit : 0.0});
		}
		var _g = 0;
		while(_g < edges.length) {
			var edge = edges[_g];
			++_g;
			var head = graph.nodes.getById(edge.head), tail = graph.nodes.getById(edge.tail);
			if(head == null) {
				var dp = { id : edge.head}, weight = weightf(edge);
				dp[this.dependentVariables[0].type] = weight;
				head = graph.nodes.create({ dp : dp, id : edge.head, weight : weight, entry : 0.0, exit : 0.0});
			}
			if(tail == null) {
				var dp = { id : edge.tail}, weight = weightf(edge);
				dp[this.dependentVariables[0].type] = weight;
				tail = graph.nodes.create({ dp : dp, id : edge.tail, weight : weight, entry : 0.0, exit : 0.0});
			}
			graph.edges.create(tail,head,weightf(edge));
		}
		var $it0 = graph.nodes.collection.iterator();
		while( $it0.hasNext() ) {
			var node = $it0.next();
			var win = node.negativeWeight(), wout = node.positiveWeight();
			if(node.data.weight == 0) node.data.weight = win;
			node.data.entry = Math.max(0,node.data.weight - win);
			node.data.exit = Math.max(0,node.data.weight - wout);
		}
		return graph;
	}
	,layoutDataWithMap: function(data,map,idf,weightf,edgesf) {
		var graph = this.createGraph(data,idf,weightf,edgesf);
		var layers = map.layers.map(function(layer) {
			return layer.map(function(id) {
				var n = graph.nodes.getById(id);
				if(null == n) n = graph.nodes.create({ id : id, weight : 0.0, entry : 0.0, exit : 0.0, dp : { id : id}});
				return n.id;
			});
		});
		var _g = 0, _g1 = map.dummies;
		while(_g < _g1.length) {
			var path = _g1[_g];
			++_g;
			var tail = graph.nodes.getById(path[0]), head = graph.nodes.getById(path[path.length - 1]), npath = [tail], edge = tail.connectedBy(head), weight = null == edge?0.0:edge.weight;
			var _g3 = 1, _g2 = path.length - 1;
			while(_g3 < _g2) {
				var i = _g3++;
				var id = path[i], d = { id : id, weight : weight, entry : 0.0, exit : 0.0, dp : null};
				npath.push(graph.nodes.create(d));
			}
			npath.push(head);
			var _g3 = 0, _g2 = npath.length - 1;
			while(_g3 < _g2) {
				var i = _g3++;
				graph.edges.create(npath[i],npath[i + 1],weight);
			}
			if(null != edge) edge.graph.edges._remove(edge);
		}
		var layers1 = map.layers.map(function(layer) {
			return layer.map(function(id) {
				var n = graph.nodes.getById(id);
				if(null == n) n = graph.nodes.create({ id : id, weight : 0.0, entry : 0.0, exit : 0.0, dp : { id : id}});
				return n.id;
			});
		});
		return new thx.graph.GraphLayout(graph,layers1);
	}
	,_feedData: function(data) {
		this.chart.setVariables(this.independentVariables,this.dependentVariables,data);
		if(null != this.title) {
			if(null != this.info.label.title) {
				this.title.set_text(this.info.label.title(this.variables,data,this.variables.map(function(variable) {
					return variable.type;
				})));
				this.layout.suggestSize("title",this.title.idealHeight());
			} else this.layout.suggestSize("title",0);
		}
		var layout = null != this.info.layoutmap?this.layoutDataWithMap(data,this.info.layoutmap):this.layoutData(data,this.info.layoutmethod);
		if(null != this.info.layerWidth) this.chart.layerWidth = this.info.layerWidth;
		if(null != this.info.nodeSpacing) this.chart.nodeSpacing = this.info.nodeSpacing;
		if(null != this.info.dummySpacing) this.chart.dummySpacing = this.info.dummySpacing;
		if(null != this.info.extraWidth) this.chart.extraWidth = this.info.extraWidth;
		if(null != this.info.backEdgeSpacing) this.chart.backEdgeSpacing = this.info.backEdgeSpacing;
		if(null != this.info.extraHeight) this.chart.extraHeight = this.info.extraHeight;
		if(null != this.info.extraRadius) this.chart.extraRadius = this.info.extraRadius;
		if(null != this.info.imageWidth) this.chart.imageWidth = this.info.imageWidth;
		if(null != this.info.imageHeight) this.chart.imageHeight = this.info.imageHeight;
		if(null != this.info.imageSpacing) this.chart.imageSpacing = this.info.imageSpacing;
		if(null != this.info.labelNodeSpacing) this.chart.labelNodeSpacing = this.info.labelNodeSpacing;
		if(null != this.info.chunkWidth) this.chart.chunkWidth = this.info.chunkWidth;
		this.chart.stackbackedges = this.info.stackbackedges;
		this.chart.thinbackedges = this.info.thinbackedges;
		this.chart.labelDataPoint = this.info.label.datapoint;
		this.chart.labelDataPointOver = this.info.label.datapointover;
		this.chart.labelNode = this.info.label.node;
		this.chart.labelEdge = this.info.label.edge;
		this.chart.labelEdgeOver = this.info.label.edgeover;
		this.chart.imagePath = this.info.imagePath;
		this.chart.click = this.info.click;
		this.chart.clickEdge = this.info.clickEdge;
		this.chart.nodeClass = this.info.nodeclass;
		this.chart.edgeClass = this.info.edgeclass;
		this.chart.displayEntry = this.info.displayentry;
		this.chart.displayExit = this.info.displayexit;
		this.chart.init();
		this.chart.data(layout);
	}
	,_init: function() {
		var _g = this;
		if(null != this.info.label.title) {
			var panelContextTitle = this.layout.getContext("title");
			if(null == panelContextTitle) return;
			this.title = new rg.svg.layer.Title(panelContextTitle.panel,null,panelContextTitle.anchor);
		}
		var panelChart = this.layout.getPanel(this.layout.mainPanelName);
		this.chart = new rg.svg.chart.Sankey(panelChart);
		this.baseChart = this.chart;
		this.chart.ready.add(function() {
			_g.ready.dispatch();
		});
	}
	,chart: null
	,title: null
	,info: null
	,__class__: rg.visualization.VisualizationSankey
});
rg.visualization.VisualizationScatterGraph = function(layout) {
	rg.visualization.VisualizationCartesian.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationScatterGraph"] = rg.visualization.VisualizationScatterGraph;
rg.visualization.VisualizationScatterGraph.__name__ = ["rg","visualization","VisualizationScatterGraph"];
rg.visualization.VisualizationScatterGraph.__super__ = rg.visualization.VisualizationCartesian;
rg.visualization.VisualizationScatterGraph.prototype = $extend(rg.visualization.VisualizationCartesian.prototype,{
	transformData: function(dps) {
		var results = [], segmenter = new rg.data.Segmenter(this.infoScatter.segment.on,this.infoScatter.segment.transform,this.infoScatter.segment.scale,this.infoScatter.segment.values);
		var _g = 0, _g1 = this.dependentVariables;
		while(_g < _g1.length) {
			var variable = _g1[_g];
			++_g;
			results.push(rg.util.DataPoints.filterByDependents(dps,[variable]));
		}
		return results;
	}
	,initChart: function() {
		var _g = this;
		var chart = new rg.svg.chart.ScatterGraph(this.layout.getPanel(this.layout.mainPanelName));
		this.baseChart = chart;
		chart.ready.add(function() {
			_g.ready.dispatch();
		});
		chart.symbol = this.infoScatter.symbol;
		chart.symbolStyle = this.infoScatter.symbolStyle;
		if(null == this.independentVariables[0].scaleDistribution) this.independentVariables[0].scaleDistribution = rg.axis.ScaleDistribution.ScaleFill;
		this.chart = chart;
	}
	,initAxes: function() {
		this.xvariable = this.independentVariables[0];
		this.yvariables = this.dependentVariables.map(function(d) {
			return d;
		});
	}
	,infoScatter: null
	,__class__: rg.visualization.VisualizationScatterGraph
});
rg.visualization.VisualizationStreamGraph = function(layout) {
	rg.visualization.VisualizationCartesian.call(this,layout);
};
$hxClasses["rg.visualization.VisualizationStreamGraph"] = rg.visualization.VisualizationStreamGraph;
rg.visualization.VisualizationStreamGraph.__name__ = ["rg","visualization","VisualizationStreamGraph"];
rg.visualization.VisualizationStreamGraph.__super__ = rg.visualization.VisualizationCartesian;
rg.visualization.VisualizationStreamGraph.prototype = $extend(rg.visualization.VisualizationCartesian.prototype,{
	transformData: function(dps) {
		var segmenter = new rg.data.Segmenter(this.infoStream.segment.on,this.infoStream.segment.transform,this.infoStream.segment.scale,this.infoStream.segment.values);
		return segmenter.segment(dps);
	}
	,initChart: function() {
		var _g = this;
		var chart = new rg.svg.chart.StreamGraph(this.layout.getPanel(this.layout.mainPanelName));
		this.baseChart = chart;
		chart.ready.add(function() {
			_g.ready.dispatch();
		});
		chart.interpolator = this.infoStream.interpolation;
		var _g1 = this;
		var $e = (_g1.infoStream.effect);
		switch( $e[1] ) {
		case 0:
			chart.gradientStyle = 0;
			break;
		case 2:
			var lightness = $e[2];
			chart.gradientStyle = 1;
			chart.gradientLightness = lightness;
			break;
		case 1:
			var lightness = $e[2];
			chart.gradientStyle = 2;
			chart.gradientLightness = lightness;
			break;
		}
		this.chart = chart;
	}
	,initAxes: function() {
		this.xvariable = this.independentVariables[0];
		this.yvariables = this.dependentVariables.map(function(d) {
			return d;
		});
	}
	,infoStream: null
	,__class__: rg.visualization.VisualizationStreamGraph
});
rg.visualization.Visualizations = function() { }
$hxClasses["rg.visualization.Visualizations"] = rg.visualization.Visualizations;
rg.visualization.Visualizations.__name__ = ["rg","visualization","Visualizations"];
rg.visualization.Visualizations.instantiateLayout = function(name,width,height,container) {
	return Type.createInstance(rg.visualization.Visualizations.layoutType.get(name),[width,height,container]);
}
thx.collection = {}
thx.collection.HashList = function() {
	this.length = 0;
	this.__keys = [];
	this.__hash = new haxe.ds.StringMap();
};
$hxClasses["thx.collection.HashList"] = thx.collection.HashList;
thx.collection.HashList.__name__ = ["thx","collection","HashList"];
thx.collection.HashList.prototype = {
	__hash: null
	,__keys: null
	,array: function() {
		var values = [];
		var _g = 0, _g1 = this.__keys;
		while(_g < _g1.length) {
			var k = _g1[_g];
			++_g;
			values.push(this.__hash.get(k));
		}
		return values;
	}
	,get: function(key) {
		return this.__hash.get(key);
	}
	,set: function(key,value) {
		if(!this.__hash.exists(key)) {
			this.__keys.push(key);
			this.length++;
		}
		this.__hash.set(key,value);
	}
	,length: null
	,__class__: thx.collection.HashList
}
thx.collection.Set = function() {
	this._v = [];
	this.length = 0;
};
$hxClasses["thx.collection.Set"] = thx.collection.Set;
thx.collection.Set.__name__ = ["thx","collection","Set"];
thx.collection.Set.prototype = {
	array: function() {
		return this._v.slice();
	}
	,add: function(v) {
		HxOverrides.remove(this._v,v);
		this._v.push(v);
		this.length = this._v.length;
	}
	,_v: null
	,length: null
	,__class__: thx.collection.Set
}
thx.color.Cmyk = function(cyan,magenta,yellow,black) {
	thx.color.Rgb.call(this,Ints.interpolate(Floats.normalize(1 - cyan - black),0,255,null),Ints.interpolate(Floats.normalize(1 - magenta - black),0,255,null),Ints.interpolate(Floats.normalize(1 - yellow - black),0,255,null));
	this.cyan = Floats.normalize(cyan);
	this.magenta = Floats.normalize(magenta);
	this.yellow = Floats.normalize(yellow);
	this.black = Floats.normalize(black);
};
$hxClasses["thx.color.Cmyk"] = thx.color.Cmyk;
thx.color.Cmyk.__name__ = ["thx","color","Cmyk"];
thx.color.Cmyk.__super__ = thx.color.Rgb;
thx.color.Cmyk.prototype = $extend(thx.color.Rgb.prototype,{
	yellow: null
	,magenta: null
	,cyan: null
	,black: null
	,__class__: thx.color.Cmyk
});
thx.color.Colors = function() { }
$hxClasses["thx.color.Colors"] = thx.color.Colors;
thx.color.Colors.__name__ = ["thx","color","Colors"];
thx.color.Colors.parse = function(s) {
	if(!thx.color.Colors._reParse.match(s = StringTools.trim(s.toLowerCase()))) {
		var v = thx.color.NamedColors.byName.get(s);
		if(null == v) {
			if("transparent" == s) return thx.color.Rgb.fromInt(16777215); else return null;
		} else return v;
	}
	var type = thx.color.Colors._reParse.matched(1);
	if(!Strings.empty(type)) {
		var values = thx.color.Colors._reParse.matched(2).split(",");
		switch(type) {
		case "rgb":case "rgba":
			return new thx.color.Rgb(thx.color.Colors._c(values[0]),thx.color.Colors._c(values[1]),thx.color.Colors._c(values[2]));
		case "hsl":
			return new thx.color.Hsl(thx.color.Colors._d(values[0]),thx.color.Colors._p(values[1]),thx.color.Colors._p(values[2]));
		case "cmyk":
			return new thx.color.Cmyk(thx.color.Colors._p(values[0]),thx.color.Colors._p(values[1]),thx.color.Colors._p(values[2]),thx.color.Colors._p(values[3]));
		}
	}
	var color = thx.color.Colors._reParse.matched(3);
	if(color.length == 3) color = color.split("").map(function(d) {
		return d + d;
	}).join(""); else if(color.length != 6) return null;
	return thx.color.Rgb.fromInt(Std.parseInt("0x" + color));
}
thx.color.Colors._c = function(s) {
	return Std.parseInt(StringTools.trim(s));
}
thx.color.Colors._d = function(s) {
	var s1 = StringTools.trim(s);
	if(HxOverrides.substr(s1,-3,null) == "deg") s1 = HxOverrides.substr(s1,0,-3); else if(HxOverrides.substr(s1,-1,null) == "º") s1 = HxOverrides.substr(s1,0,-1);
	return Std.parseFloat(s1);
}
thx.color.Colors._p = function(s) {
	var s1 = StringTools.trim(s);
	if(HxOverrides.substr(s1,-1,null) == "%") return Std.parseFloat(HxOverrides.substr(s1,0,-1)) / 100; else return Std.parseFloat(s1);
}
thx.color.Grey = function(value) {
	this.grey = Floats.normalize(value);
	var c = Ints.interpolate(this.grey,0,255,null);
	thx.color.Rgb.call(this,c,c,c);
};
$hxClasses["thx.color.Grey"] = thx.color.Grey;
thx.color.Grey.__name__ = ["thx","color","Grey"];
thx.color.Grey.toGrey = function(rgb,luminance) {
	if(null == luminance) luminance = thx.color.PerceivedLuminance.Perceived;
	switch( (luminance)[1] ) {
	case 0:
		return new thx.color.Grey(rgb.red / 255 * .2126 + rgb.green / 255 * .7152 + rgb.blue / 255 * .0722);
	case 1:
		return new thx.color.Grey(rgb.red / 255 * .299 + rgb.green / 255 * .587 + rgb.blue / 255 * .114);
	case 2:
		return new thx.color.Grey(Math.sqrt(0.241 * Math.pow(rgb.red / 255,2) + 0.691 * Math.pow(rgb.green / 255,2) + 0.068 * Math.pow(rgb.blue / 255,2)));
	}
}
thx.color.Grey.__super__ = thx.color.Rgb;
thx.color.Grey.prototype = $extend(thx.color.Rgb.prototype,{
	grey: null
	,__class__: thx.color.Grey
});
thx.color.PerceivedLuminance = { __ename__ : ["thx","color","PerceivedLuminance"], __constructs__ : ["Standard","Perceived","PerceivedAccurate"] }
thx.color.PerceivedLuminance.Standard = ["Standard",0];
thx.color.PerceivedLuminance.Standard.toString = $estr;
thx.color.PerceivedLuminance.Standard.__enum__ = thx.color.PerceivedLuminance;
thx.color.PerceivedLuminance.Perceived = ["Perceived",1];
thx.color.PerceivedLuminance.Perceived.toString = $estr;
thx.color.PerceivedLuminance.Perceived.__enum__ = thx.color.PerceivedLuminance;
thx.color.PerceivedLuminance.PerceivedAccurate = ["PerceivedAccurate",2];
thx.color.PerceivedLuminance.PerceivedAccurate.toString = $estr;
thx.color.PerceivedLuminance.PerceivedAccurate.__enum__ = thx.color.PerceivedLuminance;
thx.color.NamedColors = function() { }
$hxClasses["thx.color.NamedColors"] = thx.color.NamedColors;
thx.color.NamedColors.__name__ = ["thx","color","NamedColors"];
thx.csv = {}
thx.csv.Csv = function() { }
$hxClasses["thx.csv.Csv"] = thx.csv.Csv;
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
$hxClasses["thx.csv.CsvDecoder"] = thx.csv.CsvDecoder;
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
$hxClasses["thx.data.IDataHandler"] = thx.data.IDataHandler;
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
$hxClasses["thx.culture.Info"] = thx.culture.Info;
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
$hxClasses["thx.culture.Culture"] = thx.culture.Culture;
thx.culture.Culture.__name__ = ["thx","culture","Culture"];
thx.culture.Culture.get_cultures = function() {
	if(null == thx.culture.Culture.cultures) thx.culture.Culture.cultures = new haxe.ds.StringMap();
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
$hxClasses["thx.culture.FormatDate"] = thx.culture.FormatDate;
thx.culture.FormatDate.__name__ = ["thx","culture","FormatDate"];
thx.culture.FormatDate.format = function(date,pattern,culture,leadingspace) {
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
			buf.b += Std.string(thx.culture.FormatDate.format(date,"%m/%d/%y",culture));
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
			buf.b += Std.string(thx.culture.FormatDate.format(date,"%I:%M:%S %p",culture));
			break;
		case "R":
			buf.b += Std.string(thx.culture.FormatDate.format(date,"%H:%M",culture));
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
			buf.b += Std.string(thx.culture.FormatDate.format(date,"%H:%M:%S",culture));
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
	return thx.culture.FormatDate.format(date,culture.date.patternYearMonth,culture,false);
}
thx.culture.FormatDate.monthDay = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternMonthDay,culture,false);
}
thx.culture.FormatDate.date = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternDate,culture,false);
}
thx.culture.FormatDate.dateShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternDateShort,culture,false);
}
thx.culture.FormatDate.dateRfc = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternDateRfc,culture,false);
}
thx.culture.FormatDate.dateTime = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternDateTime,culture,false);
}
thx.culture.FormatDate.universal = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternUniversal,culture,false);
}
thx.culture.FormatDate.sortable = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternSortable,culture,false);
}
thx.culture.FormatDate.time = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternTime,culture,false);
}
thx.culture.FormatDate.timeShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatDate.format(date,culture.date.patternTimeShort,culture,false);
}
thx.culture.FormatDate.hourShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	if(null == culture.date.am) return thx.culture.FormatDate.format(date,"%H",culture,false); else return thx.culture.FormatDate.format(date,"%l %p",culture,false);
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
	return culture.date.months[date.getMonth()];
}
thx.culture.FormatDate.monthNameShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.abbrMonths[date.getMonth()];
}
thx.culture.FormatDate.weekDay = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return thx.culture.FormatNumber.digits("" + (date.getDay() + culture.date.firstWeekDay),culture);
}
thx.culture.FormatDate.weekDayName = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.days[date.getDay()];
}
thx.culture.FormatDate.weekDayNameShort = function(date,culture) {
	if(null == culture) culture = thx.culture.Culture.get_defaultCulture();
	return culture.date.abbrDays[date.getDay()];
}
thx.culture.FormatNumber = function() { }
$hxClasses["thx.culture.FormatNumber"] = thx.culture.FormatNumber;
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
$hxClasses["thx.culture.FormatParams"] = thx.culture.FormatParams;
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
$hxClasses["thx.culture.Language"] = thx.culture.Language;
thx.culture.Language.__name__ = ["thx","culture","Language"];
thx.culture.Language.get_languages = function() {
	if(null == thx.culture.Language.languages) thx.culture.Language.languages = new haxe.ds.StringMap();
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
$hxClasses["thx.culture.core.DateTimeInfo"] = thx.culture.core.DateTimeInfo;
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
$hxClasses["thx.culture.core.NumberInfo"] = thx.culture.core.NumberInfo;
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
$hxClasses["thx.languages.En"] = thx.languages.En;
thx.languages.En.__name__ = ["thx","languages","En"];
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
$hxClasses["thx.cultures.EnUS"] = thx.cultures.EnUS;
thx.cultures.EnUS.__name__ = ["thx","cultures","EnUS"];
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
$hxClasses["thx.data.ValueEncoder"] = thx.data.ValueEncoder;
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
			var c = $e[2];
			if(js.Boot.__instanceof(o,String)) this.handler.valueString(o); else if(js.Boot.__instanceof(o,Array)) this.encodeArray(o); else if(js.Boot.__instanceof(o,Date)) this.handler.valueDate(o); else if(js.Boot.__instanceof(o,_Map.Map_Impl_)) this.encodeHash(o); else if(js.Boot.__instanceof(o,List)) this.encodeList(o); else throw new thx.error.Error("unable to encode class '{0}'",null,Type.getClassName(c),{ fileName : "ValueEncoder.hx", lineNumber : 53, className : "thx.data.ValueEncoder", methodName : "encodeValue"});
			break;
		case 7:
			var e = $e[2];
			throw new thx.error.Error("unable to encode TEnum type '{0}'",null,Type.getEnumName(e),{ fileName : "ValueEncoder.hx", lineNumber : 55, className : "thx.data.ValueEncoder", methodName : "encodeValue"});
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
$hxClasses["thx.data.ValueHandler"] = thx.data.ValueHandler;
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
$hxClasses["thx.date.DateParser"] = thx.date.DateParser;
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
$hxClasses["thx.util.Message"] = thx.util.Message;
thx.util.Message.__name__ = ["thx","util","Message"];
thx.util.Message.prototype = {
	toString: function() {
		return Strings.format(this.message,this.params);
	}
	,params: null
	,message: null
	,__class__: thx.util.Message
}
thx.error = {}
thx.error.Error = function(message,params,param,pos) {
	thx.util.Message.call(this,message,params,param);
	this.pos = pos;
};
$hxClasses["thx.error.Error"] = thx.error.Error;
thx.error.Error.__name__ = ["thx","error","Error"];
thx.error.Error.__super__ = thx.util.Message;
thx.error.Error.prototype = $extend(thx.util.Message.prototype,{
	toString: function() {
		try {
			return Strings.format(this.message,this.params);
		} catch( e ) {
			var ps = this.pos.className + "." + this.pos.methodName + "(" + this.pos.lineNumber + ")";
			return "";
		}
	}
	,pos: null
	,__class__: thx.error.Error
});
thx.error.AbstractMethod = function(posInfo) {
	thx.error.Error.call(this,"method {0}.{1}() is abstract",[posInfo.className,posInfo.methodName],posInfo,{ fileName : "AbstractMethod.hx", lineNumber : 14, className : "thx.error.AbstractMethod", methodName : "new"});
};
$hxClasses["thx.error.AbstractMethod"] = thx.error.AbstractMethod;
thx.error.AbstractMethod.__name__ = ["thx","error","AbstractMethod"];
thx.error.AbstractMethod.__super__ = thx.error.Error;
thx.error.AbstractMethod.prototype = $extend(thx.error.Error.prototype,{
	__class__: thx.error.AbstractMethod
});
thx.error.NullArgument = function(argumentName,message,posInfo) {
	if(null == message) message = "invalid null or empty argument '{0}' for method {1}.{2}()";
	thx.error.Error.call(this,message,[argumentName,posInfo.className,posInfo.methodName],posInfo,{ fileName : "NullArgument.hx", lineNumber : 16, className : "thx.error.NullArgument", methodName : "new"});
};
$hxClasses["thx.error.NullArgument"] = thx.error.NullArgument;
thx.error.NullArgument.__name__ = ["thx","error","NullArgument"];
thx.error.NullArgument.__super__ = thx.error.Error;
thx.error.NullArgument.prototype = $extend(thx.error.Error.prototype,{
	__class__: thx.error.NullArgument
});
thx.geo = {}
thx.geo.IProjection = function() { }
$hxClasses["thx.geo.IProjection"] = thx.geo.IProjection;
thx.geo.IProjection.__name__ = ["thx","geo","IProjection"];
thx.geo.IProjection.prototype = {
	project: null
	,__class__: thx.geo.IProjection
}
thx.geo.Albers = function() {
	this._origin = [-98.0,38];
	this._parallels = [29.5,45.5];
	this._scale = 1000;
	this._translate = [480.0,250];
	this.reload();
};
$hxClasses["thx.geo.Albers"] = thx.geo.Albers;
thx.geo.Albers.__name__ = ["thx","geo","Albers"];
thx.geo.Albers.__interfaces__ = [thx.geo.IProjection];
thx.geo.Albers.prototype = {
	get_scale: function() {
		return this._scale;
	}
	,set_scale: function(scale) {
		return this._scale = scale;
	}
	,reload: function() {
		var phi1 = 0.01745329251994329577 * this.get_parallels()[0], phi2 = 0.01745329251994329577 * this.get_parallels()[1], lat0 = 0.01745329251994329577 * this.get_origin()[1], s = Math.sin(phi1), c = Math.cos(phi1);
		this.lng0 = 0.01745329251994329577 * this.get_origin()[0];
		this.n = .5 * (s + Math.sin(phi2));
		this.C = c * c + 2 * this.n * s;
		this.p0 = Math.sqrt(this.C - 2 * this.n * Math.sin(lat0)) / this.n;
		return this;
	}
	,set_translate: function(translate) {
		this._translate = [translate[0],translate[1]];
		return translate;
	}
	,get_translate: function() {
		return this._translate.slice();
	}
	,set_parallels: function(parallels) {
		this._parallels = [parallels[0],parallels[1]];
		this.reload();
		return parallels;
	}
	,get_parallels: function() {
		return this._parallels.slice();
	}
	,set_origin: function(origin) {
		this._origin = [origin[0],origin[1]];
		this.reload();
		return origin;
	}
	,get_origin: function() {
		return this._origin.slice();
	}
	,project: function(coords) {
		var t = this.n * (0.01745329251994329577 * coords[0] - this.lng0), p = Math.sqrt(this.C - 2 * this.n * Math.sin(0.01745329251994329577 * coords[1])) / this.n;
		return [this.get_scale() * p * Math.sin(t) + this.get_translate()[0],this.get_scale() * (p * Math.cos(t) - this.p0) + this.get_translate()[1]];
	}
	,_scale: null
	,_translate: null
	,_parallels: null
	,_origin: null
	,p0: null
	,C: null
	,n: null
	,lng0: null
	,__class__: thx.geo.Albers
}
thx.geo.AlbersUsa = function() {
	this.lower48 = new thx.geo.Albers();
	this.alaska = new thx.geo.Albers();
	this.alaska.set_origin([-160.0,60]);
	this.alaska.set_parallels([55.0,65]);
	this.hawaii = new thx.geo.Albers();
	this.hawaii.set_origin([-160.0,20]);
	this.hawaii.set_parallels([8.0,18]);
	this.puertoRico = new thx.geo.Albers();
	this.puertoRico.set_origin([-60.0,10]);
	this.puertoRico.set_parallels([8.0,18]);
	this.set_scale(this.lower48.get_scale());
};
$hxClasses["thx.geo.AlbersUsa"] = thx.geo.AlbersUsa;
thx.geo.AlbersUsa.__name__ = ["thx","geo","AlbersUsa"];
thx.geo.AlbersUsa.__interfaces__ = [thx.geo.IProjection];
thx.geo.AlbersUsa.prototype = {
	set_translate: function(translate) {
		var dz = this.lower48.get_scale() / 1000, dx = translate[0], dy = translate[1];
		this.lower48.set_translate(translate);
		this.alaska.set_translate([dx - 400 * dz,dy + 170 * dz]);
		this.hawaii.set_translate([dx - 190 * dz,dy + 200 * dz]);
		this.puertoRico.set_translate([dx + 580 * dz,dy + 430 * dz]);
		return translate;
	}
	,set_scale: function(scale) {
		this.lower48.set_scale(scale);
		this.alaska.set_scale(scale * .6);
		this.hawaii.set_scale(scale);
		this.puertoRico.set_scale(scale * 1.5);
		this.set_translate(this.lower48.get_translate());
		return scale;
	}
	,project: function(coords) {
		var lon = coords[0], lat = coords[1];
		return (lat > 50?this.alaska:lon < -140?this.hawaii:lat < 21?this.puertoRico:this.lower48).project(coords);
	}
	,puertoRico: null
	,hawaii: null
	,alaska: null
	,lower48: null
	,__class__: thx.geo.AlbersUsa
}
thx.geo.Azimuthal = function() {
	this.set_mode(thx.geo.ProjectionMode.Orthographic);
	this.set_scale(200);
	this.set_translate([480.0,250]);
	this.set_origin([0.0,0]);
};
$hxClasses["thx.geo.Azimuthal"] = thx.geo.Azimuthal;
thx.geo.Azimuthal.__name__ = ["thx","geo","Azimuthal"];
thx.geo.Azimuthal.__interfaces__ = [thx.geo.IProjection];
thx.geo.Azimuthal.prototype = {
	get_mode: function() {
		return this.mode;
	}
	,set_mode: function(mode) {
		return this.mode = mode;
	}
	,get_scale: function() {
		return this.scale;
	}
	,set_scale: function(scale) {
		return this.scale = scale;
	}
	,set_translate: function(translate) {
		this.translate = [translate[0],translate[1]];
		return translate;
	}
	,get_translate: function() {
		return this.translate.slice();
	}
	,set_origin: function(origin) {
		this.origin = [origin[0],origin[1]];
		this.x0 = origin[0] * 0.01745329251994329577;
		this.y0 = origin[1] * 0.01745329251994329577;
		this.cy0 = Math.cos(this.y0);
		this.sy0 = Math.sin(this.y0);
		return origin;
	}
	,project: function(coords) {
		var x1 = coords[0] * 0.01745329251994329577 - this.x0, y1 = coords[1] * 0.01745329251994329577, cx1 = Math.cos(x1), sx1 = Math.sin(x1), cy1 = Math.cos(y1), sy1 = Math.sin(y1), k = (function($this) {
			var $r;
			var _g = $this.get_mode();
			$r = (function($this) {
				var $r;
				switch( (_g)[1] ) {
				case 0:
					$r = 1;
					break;
				case 1:
					$r = 1 / (1 + $this.sy0 * sy1 + $this.cy0 * cy1 * cx1);
					break;
				}
				return $r;
			}($this));
			return $r;
		}(this)), x = k * cy1 * sx1, y = k * (this.sy0 * cy1 * cx1 - this.cy0 * sy1);
		return [this.get_scale() * x + this.get_translate()[0],this.get_scale() * y + this.get_translate()[1]];
	}
	,sy0: null
	,cy0: null
	,y0: null
	,x0: null
	,translate: null
	,scale: null
	,origin: null
	,mode: null
	,__class__: thx.geo.Azimuthal
}
thx.geo.ProjectionMode = { __ename__ : ["thx","geo","ProjectionMode"], __constructs__ : ["Orthographic","Stereographic"] }
thx.geo.ProjectionMode.Orthographic = ["Orthographic",0];
thx.geo.ProjectionMode.Orthographic.toString = $estr;
thx.geo.ProjectionMode.Orthographic.__enum__ = thx.geo.ProjectionMode;
thx.geo.ProjectionMode.Stereographic = ["Stereographic",1];
thx.geo.ProjectionMode.Stereographic.toString = $estr;
thx.geo.ProjectionMode.Stereographic.__enum__ = thx.geo.ProjectionMode;
thx.geo.Mercator = function() {
	this.set_scale(500);
	this.set_translate([480.0,250]);
};
$hxClasses["thx.geo.Mercator"] = thx.geo.Mercator;
thx.geo.Mercator.__name__ = ["thx","geo","Mercator"];
thx.geo.Mercator.__interfaces__ = [thx.geo.IProjection];
thx.geo.Mercator.prototype = {
	set_translate: function(translate) {
		this.translate = [translate[0],translate[1]];
		return translate;
	}
	,get_translate: function() {
		return this.translate.slice();
	}
	,get_scale: function() {
		return this.scale;
	}
	,set_scale: function(scale) {
		return this.scale = scale;
	}
	,project: function(coords) {
		var x = coords[0] / 360, y = -(Math.log(Math.tan(Math.PI / 4 + coords[1] * 0.01745329251994329577 / 2)) / 0.01745329251994329577) / 360;
		return [this.get_scale() * x + this.get_translate()[0],this.get_scale() * Math.max(-.5,Math.min(.5,y)) + this.get_translate()[1]];
	}
	,translate: null
	,scale: null
	,__class__: thx.geo.Mercator
}
thx.geom = {}
thx.geom.Polygon = function(coordinates) {
	this.coordinates = coordinates;
};
$hxClasses["thx.geom.Polygon"] = thx.geom.Polygon;
thx.geom.Polygon.__name__ = ["thx","geom","Polygon"];
thx.geom.Polygon.prototype = {
	centroid: function(k) {
		var a, b, c, x = 0.0, y = 0.0;
		if(null == k) k = 1 / (6 * this.area());
		var _g1 = 0, _g = this.coordinates.length - 1;
		while(_g1 < _g) {
			var i = _g1++;
			a = this.coordinates[i];
			b = this.coordinates[i + 1];
			c = a[0] * b[1] - b[0] * a[1];
			x += (a[0] + b[0]) * c;
			y += (a[1] + b[1]) * c;
		}
		return [x * k,y * k];
	}
	,area: function() {
		var n = this.coordinates.length, a = this.coordinates[n - 1][0] * this.coordinates[0][1], b = this.coordinates[n - 1][1] * this.coordinates[0][0];
		var _g = 1;
		while(_g < n) {
			var i = _g++;
			a += this.coordinates[i - 1][0] * this.coordinates[i][1];
			b += this.coordinates[i - 1][1] * this.coordinates[i][0];
		}
		return (b - a) * .5;
	}
	,coordinates: null
	,__class__: thx.geom.Polygon
}
thx.geom.layout = {}
thx.geom.layout.Pie = function() {
	this._startAngle = function(_,_1) {
		return 0.0;
	};
	this._endAngle = function(_,_1) {
		return 6.283185307179586477;
	};
	this._sort = null;
	this._value = function(d,_) {
		return Number(d);
	};
};
$hxClasses["thx.geom.layout.Pie"] = thx.geom.layout.Pie;
thx.geom.layout.Pie.__name__ = ["thx","geom","layout","Pie"];
thx.geom.layout.Pie.prototype = {
	pie: function(data,i) {
		var a = this._startAngle(data,i), k = this._endAngle(data,i) - a;
		var index = Ints.range(data.length);
		if(this._sort != null) {
			var s = this._sort;
			index.sort(function(i1,j) {
				return s(data[i1],data[j]);
			});
		}
		var values = Iterators.map(HxOverrides.iter(data),this._value);
		k /= values.reduce(function(p,d,_) {
			return p + d;
		},0.0);
		if(!Math.isFinite(k)) k = 0;
		var d1;
		var arcs = Iterators.map(HxOverrides.iter(index),function(_,i1) {
			d1 = values[i1];
			return { value : d1, startAngle : a, endAngle : a += d1 * k};
		});
		return Iterators.map(HxOverrides.iter(data),function(d,i1) {
			return arcs[index[i1]];
		});
	}
	,_value: null
	,_sort: null
	,_endAngle: null
	,_startAngle: null
	,__class__: thx.geom.layout.Pie
}
thx.geom.layout.Stack = function() {
	this._order = thx.geom.layout.StackOrder.DefaultOrder;
	this._offset = thx.geom.layout.StackOffset.ZeroOffset;
};
$hxClasses["thx.geom.layout.Stack"] = thx.geom.layout.Stack;
thx.geom.layout.Stack.__name__ = ["thx","geom","layout","Stack"];
thx.geom.layout.Stack.getStackOrder = function(order,data) {
	switch( (order)[1] ) {
	case 0:
		return Ints.range(data.length);
	case 1:
		var n = data.length, max = Iterators.map(HxOverrides.iter(data),thx.geom.layout.Stack.stackMaxIndex), sums = Iterators.map(HxOverrides.iter(data),thx.geom.layout.Stack.stackReduceSum), index = Ints.range(n), top = 0.0, bottom = 0.0, tops = [], bottoms = [];
		index.sort(function(a,b) {
			return max[a] - max[b];
		});
		var _g = 0;
		while(_g < n) {
			var i = _g++;
			var j = index[i];
			if(top < bottom) {
				top += sums[j];
				tops.push(j);
			} else {
				bottom += sums[j];
				bottoms.push(j);
			}
		}
		bottoms.reverse();
		return bottoms.concat(tops);
	case 2:
		var index = Ints.range(data.length);
		index.reverse();
		return index;
	}
}
thx.geom.layout.Stack.getStackOffset = function(offset,index,data) {
	switch( (offset)[1] ) {
	case 0:
		var n = data.length, m = data[0].length, sums = [], max = 0.0, o;
		var _g = 0;
		while(_g < m) {
			var j = _g++;
			o = 0.0;
			var _g1 = 0;
			while(_g1 < n) {
				var i = _g1++;
				o += data[i][j].y;
			}
			if(o > max) max = o;
			sums.push(o);
		}
		var i = index[0];
		var _g = 0;
		while(_g < m) {
			var j = _g++;
			data[i][j].y0 = (max - sums[j]) / 2;
		}
		break;
	case 1:
		var n = data.length, x = data[0], m = x.length, max = 0.0, k, ii, ik, i0 = index[0], s1, s2, s3, dx, o, o0;
		data[i0][0].y0 = o = o0 = 0.0;
		var _g = 1;
		while(_g < m) {
			var j = _g++;
			s1 = 0.0;
			var _g1 = 0;
			while(_g1 < n) {
				var i = _g1++;
				s1 += data[i][j].y;
			}
			s2 = 0.0;
			dx = x[j].x - x[j - 1].x;
			var _g1 = 0;
			while(_g1 < n) {
				var i = _g1++;
				ii = index[i];
				s3 = (data[ii][j].y - data[ii][j - 1].y) / (2 * dx);
				var _g2 = 0;
				while(_g2 < i) {
					var k1 = _g2++;
					s3 += (data[ik = index[k1]][j].y - data[ik][j - 1].y) / dx;
				}
				s2 += s3 * data[ii][j].y;
			}
			data[i0][j].y0 = o -= s1 != 0?s2 / s1 * dx:0;
			if(o < o0) o0 = o;
		}
		var _g = 0;
		while(_g < m) {
			var j = _g++;
			data[i0][j].y0 -= o0;
		}
		break;
	case 2:
		var m = data[0].length, i0 = index[0];
		var _g = 0;
		while(_g < m) {
			var j = _g++;
			data[i0][j].y0 = 0.0;
		}
		break;
	}
}
thx.geom.layout.Stack.stackMaxIndex = function(data,_) {
	var j = 0, v = data[0].y, k, n = data.length;
	var _g = 1;
	while(_g < n) {
		var i = _g++;
		if((k = data[i].y) > v) {
			j = i;
			v = k;
		}
	}
	return j;
}
thx.geom.layout.Stack.stackReduceSum = function(data,_) {
	return data.reduce(thx.geom.layout.Stack.stackSum,0.0);
}
thx.geom.layout.Stack.stackSum = function(p,c,i) {
	return p + c.y;
}
thx.geom.layout.Stack.prototype = {
	offset: function(x) {
		this._offset = x;
		return this;
	}
	,order: function(x) {
		this._order = x;
		return this;
	}
	,stack: function(data) {
		var n = data.length, m = data[0].length, i, j, y0, result = [];
		var _g = 0;
		while(_g < n) {
			var i1 = _g++;
			var r = [];
			result.push(r);
			var _g1 = 0;
			while(_g1 < m) {
				var j1 = _g1++;
				var s = data[i1][j1];
				r[j1] = { x : s.x, y : s.y, y0 : 0.0};
			}
		}
		var index = thx.geom.layout.Stack.getStackOrder(this._order,result);
		thx.geom.layout.Stack.getStackOffset(this._offset,index,result);
		var _g = 0;
		while(_g < m) {
			var j1 = _g++;
			y0 = result[index[0]][j1].y0;
			var _g1 = 1;
			while(_g1 < n) {
				var i1 = _g1++;
				result[index[i1]][j1].y0 = y0 += result[index[i1 - 1]][j1].y;
			}
		}
		return result;
	}
	,_offset: null
	,_order: null
	,__class__: thx.geom.layout.Stack
}
thx.geom.layout.StackOrder = { __ename__ : ["thx","geom","layout","StackOrder"], __constructs__ : ["DefaultOrder","InsideOut","ReverseOrder"] }
thx.geom.layout.StackOrder.DefaultOrder = ["DefaultOrder",0];
thx.geom.layout.StackOrder.DefaultOrder.toString = $estr;
thx.geom.layout.StackOrder.DefaultOrder.__enum__ = thx.geom.layout.StackOrder;
thx.geom.layout.StackOrder.InsideOut = ["InsideOut",1];
thx.geom.layout.StackOrder.InsideOut.toString = $estr;
thx.geom.layout.StackOrder.InsideOut.__enum__ = thx.geom.layout.StackOrder;
thx.geom.layout.StackOrder.ReverseOrder = ["ReverseOrder",2];
thx.geom.layout.StackOrder.ReverseOrder.toString = $estr;
thx.geom.layout.StackOrder.ReverseOrder.__enum__ = thx.geom.layout.StackOrder;
thx.geom.layout.StackOffset = { __ename__ : ["thx","geom","layout","StackOffset"], __constructs__ : ["Silhouette","Wiggle","ZeroOffset"] }
thx.geom.layout.StackOffset.Silhouette = ["Silhouette",0];
thx.geom.layout.StackOffset.Silhouette.toString = $estr;
thx.geom.layout.StackOffset.Silhouette.__enum__ = thx.geom.layout.StackOffset;
thx.geom.layout.StackOffset.Wiggle = ["Wiggle",1];
thx.geom.layout.StackOffset.Wiggle.toString = $estr;
thx.geom.layout.StackOffset.Wiggle.__enum__ = thx.geom.layout.StackOffset;
thx.geom.layout.StackOffset.ZeroOffset = ["ZeroOffset",2];
thx.geom.layout.StackOffset.ZeroOffset.toString = $estr;
thx.geom.layout.StackOffset.ZeroOffset.__enum__ = thx.geom.layout.StackOffset;
thx.graph = {}
thx.graph.EdgeSplitter = function() {
};
$hxClasses["thx.graph.EdgeSplitter"] = thx.graph.EdgeSplitter;
thx.graph.EdgeSplitter.__name__ = ["thx","graph","EdgeSplitter"];
thx.graph.EdgeSplitter.prototype = {
	split: function(layout,splitted,dataf,edgef) {
		var layers = layout.layers(), cell, ocell, cur;
		if(null == edgef) edgef = function(_,_1,_2) {
		};
		var $it0 = layout.graph.nodes.collection.iterator();
		while( $it0.hasNext() ) {
			var node = $it0.next();
			cell = layout.cell(node);
			var $it1 = node.graph.edges.positives(node);
			while( $it1.hasNext() ) {
				var edge = $it1.next();
				ocell = layout.cell(edge.head);
				if(cell.layer == ocell.layer) continue;
				if(cell.layer == ocell.layer - 1) continue;
				if(cell.layer == ocell.layer + 1) continue;
				var sign = [cell.layer < ocell.layer?1:-1], diff = Ints.abs(ocell.layer - cell.layer) - 1;
				splitted.push(edge.split(diff,dataf,(function(sign) {
					return function(ea,eb,i) {
						layers[cell.layer + (1 + i) * sign[0]].push(ea.head.id);
						edgef(ea,eb,i);
					};
				})(sign)));
			}
		}
		return new thx.graph.GraphLayout(layout.graph,layers);
	}
	,__class__: thx.graph.EdgeSplitter
}
thx.graph.GraphElement = function(graph,id,data) {
	this.id = id;
	this.data = data;
	this.graph = graph;
};
$hxClasses["thx.graph.GraphElement"] = thx.graph.GraphElement;
thx.graph.GraphElement.__name__ = ["thx","graph","GraphElement"];
thx.graph.GraphElement.prototype = {
	destroy: function() {
		this.graph = null;
		this.id = -1;
	}
	,data: null
	,id: null
	,graph: null
	,__class__: thx.graph.GraphElement
}
thx.graph.GEdge = function(graph,id,tail,head,weight,data) {
	thx.graph.GraphElement.call(this,graph,id,data);
	this.tail = tail;
	this.head = head;
	this.weight = weight;
};
$hxClasses["thx.graph.GEdge"] = thx.graph.GEdge;
thx.graph.GEdge.__name__ = ["thx","graph","GEdge"];
thx.graph.GEdge.create = function(graph,id,tail,head,weight,data) {
	return new thx.graph.GEdge(graph,id,tail,head,weight,data);
}
thx.graph.GEdge.__super__ = thx.graph.GraphElement;
thx.graph.GEdge.prototype = $extend(thx.graph.GraphElement.prototype,{
	invert: function() {
		var inverted = this.graph.edges.create(this.head,this.tail,this.weight,this.data);
		this.graph.edges._remove(this);
		return inverted;
	}
	,split: function(times,dataf,edgef) {
		if(times == null) times = 1;
		if(times < 1) throw new thx.error.Error("the split times parameter must be an integer value greater than zero",null,null,{ fileName : "GEdge.hx", lineNumber : 34, className : "thx.graph.GEdge", methodName : "split"});
		if(null == edgef) edgef = function(_,_1,_2) {
		};
		if(null == dataf) dataf = function(_) {
			return null;
		};
		var last = this, result = [], node, e1, e2, g = last.graph;
		var _g = 0;
		while(_g < times) {
			var i = _g++;
			node = g.nodes.create(dataf(last));
			e1 = g.edges.create(last.tail,node,last.weight,last.data);
			e2 = g.edges.create(node,last.head,last.weight,last.data);
			g.edges.remove(last);
			edgef(e1,e2,i);
			last = e2;
			g = last.graph;
			result.push(e1);
		}
		result.push(last);
		return result;
	}
	,destroy: function() {
		thx.graph.GraphElement.prototype.destroy.call(this);
		this.tail = null;
		this.head = null;
	}
	,weight: null
	,head: null
	,tail: null
	,__class__: thx.graph.GEdge
});
thx.graph.GNode = function(graph,id,data) {
	thx.graph.GraphElement.call(this,graph,id,data);
};
$hxClasses["thx.graph.GNode"] = thx.graph.GNode;
thx.graph.GNode.__name__ = ["thx","graph","GNode"];
thx.graph.GNode.create = function(graph,id,data) {
	return new thx.graph.GNode(graph,id,data);
}
thx.graph.GNode.__super__ = thx.graph.GraphElement;
thx.graph.GNode.prototype = $extend(thx.graph.GraphElement.prototype,{
	negatives: function() {
		return this.graph.edges.negatives(this);
	}
	,positives: function() {
		return this.graph.edges.positives(this);
	}
	,predecessorBy: function(successor) {
		return Iterators.firstf(this.graph.edges.positives(this),function(edge) {
			return edge.head.id == successor.id;
		});
	}
	,isIsolated: function() {
		return !this.graph.edges.edges(this).hasNext();
	}
	,isSink: function() {
		return this.graph.edges.negatives(this).hasNext() && !this.graph.edges.positives(this).hasNext();
	}
	,isSource: function() {
		return this.graph.edges.positives(this).hasNext() && !this.graph.edges.negatives(this).hasNext();
	}
	,_weight: function(it) {
		var weight = 0.0;
		while( it.hasNext() ) {
			var edge = it.next();
			weight += edge.weight;
		}
		return weight;
	}
	,negativeWeight: function() {
		return this._weight(this.graph.edges.negatives(this));
	}
	,positiveWeight: function() {
		return this._weight(this.graph.edges.positives(this));
	}
	,connectedBy: function(other) {
		if(other.graph != this.graph) throw new thx.error.Error("the node is not part of this graph",null,null,{ fileName : "GNode.hx", lineNumber : 41, className : "thx.graph.GNode", methodName : "connectedBy"});
		var edge = Iterators.firstf(this.graph.edges.positives(this),function(edge1) {
			return edge1.head.id == other.id;
		});
		if(null != edge) return edge;
		return Iterators.firstf(this.graph.edges.negatives(this),function(edge1) {
			return edge1.tail.id == other.id;
		});
	}
	,destroy: function() {
		thx.graph.GraphElement.prototype.destroy.call(this);
	}
	,__class__: thx.graph.GNode
});
thx.graph.Graph = function(nodeidf,edgeidf) {
	this.nodes = thx.graph.GraphNodes.newInstance(this,nodeidf);
	this.edges = thx.graph.GraphEdges.newInstance(this,edgeidf);
};
$hxClasses["thx.graph.Graph"] = thx.graph.Graph;
thx.graph.Graph.__name__ = ["thx","graph","Graph"];
thx.graph.Graph.prototype = {
	findIsolateds: function() {
		return Iterators.filter(this.nodes.iterator(),function(n) {
			return n.isIsolated();
		});
	}
	,findSource: function() {
		return Iterators.firstf(this.nodes.iterator(),function(n) {
			return n.isSource();
		});
	}
	,findSink: function() {
		return Iterators.firstf(this.nodes.iterator(),function(n) {
			return n.isSink();
		});
	}
	,findSinks: function() {
		return Iterators.filter(this.nodes.iterator(),function(n) {
			return n.isSink();
		});
	}
	,clone: function() {
		var g = new thx.graph.Graph();
		g.nodes = this.nodes.copyTo(g);
		g.edges = this.edges.copyTo(g);
		return g;
	}
	,edges: null
	,nodes: null
	,__class__: thx.graph.Graph
}
thx.graph.GraphCollection = function(graph,idf) {
	var _g = this;
	this.nextid = 0;
	this.graph = graph;
	this.idf = idf;
	this.collection = new haxe.ds.IntMap();
	this._map = new haxe.ds.StringMap();
	if(null != idf) {
		var add = $bind(this,this.collectionCreate);
		this.collectionCreate = function(item) {
			_g._map.set(idf(item.data),item);
			add(item);
		};
		var rem = $bind(this,this.collectionRemove);
		this.collectionRemove = function(item) {
			_g._map.remove(idf(item.data));
			rem(item);
		};
	}
	this.onRemove = new hxevents.Dispatcher();
	this.onCreate = new hxevents.Dispatcher();
};
$hxClasses["thx.graph.GraphCollection"] = thx.graph.GraphCollection;
thx.graph.GraphCollection.__name__ = ["thx","graph","GraphCollection"];
thx.graph.GraphCollection.prototype = {
	iterator: function() {
		return this.collection.iterator();
	}
	,collectionRemove: function(item) {
		this.collection.remove(item.id);
		this.onRemove.dispatch(item);
	}
	,collectionCreate: function(item) {
		this.onCreate.dispatch(item);
		this.collection.set(item.id,item);
	}
	,get: function(id) {
		return this.collection.get(id);
	}
	,getById: function(id) {
		return this._map.get(id);
	}
	,_map: null
	,idf: null
	,nextid: null
	,collection: null
	,graph: null
	,onCreate: null
	,onRemove: null
	,__class__: thx.graph.GraphCollection
}
thx.graph.GraphEdges = function(graph,edgeidf) {
	thx.graph.GraphCollection.call(this,graph,edgeidf);
	this.edgesp = new haxe.ds.IntMap();
	this.edgesn = new haxe.ds.IntMap();
};
$hxClasses["thx.graph.GraphEdges"] = thx.graph.GraphEdges;
thx.graph.GraphEdges.__name__ = ["thx","graph","GraphEdges"];
thx.graph.GraphEdges.newInstance = function(graph,edgeidf) {
	return new thx.graph.GraphEdges(graph,edgeidf);
}
thx.graph.GraphEdges.__super__ = thx.graph.GraphCollection;
thx.graph.GraphEdges.prototype = $extend(thx.graph.GraphCollection.prototype,{
	removeConnection: function(edgeid,nodeid,connections) {
		var c = connections.get(nodeid);
		if(null == c) return;
		HxOverrides.remove(c,edgeid);
		if(c.length == 0) connections.remove(nodeid);
	}
	,connections: function(id,connections) {
		var c = connections.get(id);
		if(null == c) connections.set(id,c = []);
		return c;
	}
	,_unlink: function(node,connections) {
		var ids = connections.get(node.id);
		if(null == ids) return;
		ids = ids.slice();
		var _g = 0;
		while(_g < ids.length) {
			var id = ids[_g];
			++_g;
			var edge = this.get(id);
			if(null == edge || null == edge.graph) continue;
			this._remove(edge);
		}
		connections.remove(node.id);
	}
	,_edges: function(id,collection) {
		var _g = this;
		return this._edgeids(id,collection).map(function(eid) {
			return _g.get(eid);
		});
	}
	,_edgeids: function(id,collection) {
		var r = collection.get(id);
		if(null == r) r = [];
		return r;
	}
	,edgeCount: function(node) {
		return this._edgeids(node.id,this.edgesp).length + this._edgeids(node.id,this.edgesn).length;
	}
	,negativeCount: function(node) {
		return this._edgeids(node.id,this.edgesn).length;
	}
	,positiveCount: function(node) {
		return this._edgeids(node.id,this.edgesp).length;
	}
	,edges: function(node) {
		return HxOverrides.iter(this._edges(node.id,this.edgesp).concat(this._edges(node.id,this.edgesn)));
	}
	,_sort: function(node,sortf,collection) {
		var _g = this;
		var arr = collection.get(node.id);
		if(null == arr) return;
		arr.sort(function(ida,idb) {
			var ea = _g.graph.edges.get(ida), eb = _g.graph.edges.get(idb);
			return sortf(ea,eb);
		});
	}
	,sortNegatives: function(node,sortf) {
		this._sort(node,sortf,this.edgesn);
	}
	,sortPositives: function(node,sortf) {
		this._sort(node,sortf,this.edgesp);
	}
	,negatives: function(node) {
		return HxOverrides.iter(this._edges(node.id,this.edgesn));
	}
	,positives: function(node) {
		return HxOverrides.iter(this._edges(node.id,this.edgesp));
	}
	,unlink: function(node) {
		if(node.graph != this.graph) throw new thx.error.Error("unlink: the node is not part of this graph",null,null,{ fileName : "GraphEdges.hx", lineNumber : 70, className : "thx.graph.GraphEdges", methodName : "unlink"});
		this._unlink(node,this.edgesp);
		this._unlink(node,this.edgesn);
	}
	,_remove: function(edge) {
		this.collectionRemove(edge);
		this.removeConnection(edge.id,edge.tail.id,this.edgesp);
		this.removeConnection(edge.id,edge.head.id,this.edgesn);
		edge.destroy();
	}
	,remove: function(edge) {
		if(edge.graph != this.graph) throw new thx.error.Error("remove: the edge is not part of this graph",null,null,{ fileName : "GraphEdges.hx", lineNumber : 55, className : "thx.graph.GraphEdges", methodName : "remove"});
		this._remove(edge);
	}
	,_create: function(id,tail,head,weight,data) {
		var e = thx.graph.GEdge.create(this.graph,id,tail,head,weight,data);
		this.collectionCreate(e);
		this.connections(tail.id,this.edgesp).push(id);
		this.connections(head.id,this.edgesn).push(id);
		return e;
	}
	,create: function(tail,head,weight,data) {
		if(weight == null) weight = 1.0;
		if(tail.graph != head.graph || tail.graph != this.graph) throw new thx.error.Error("can't create an edge between nodes on different graphs",null,null,{ fileName : "GraphEdges.hx", lineNumber : 39, className : "thx.graph.GraphEdges", methodName : "create"});
		return this._create(++this.nextid,tail,head,weight,data);
	}
	,copyTo: function(graph) {
		var edges = new thx.graph.GraphEdges(graph), nodes = graph.nodes, tail, head;
		var $it0 = this.collection.iterator();
		while( $it0.hasNext() ) {
			var edge = $it0.next();
			tail = nodes.get(edge.tail.id);
			head = nodes.get(edge.head.id);
			edges._create(edge.id,tail,head,edge.weight,edge.data);
		}
		edges.nextid = this.nextid;
		return edges;
	}
	,edgesn: null
	,edgesp: null
	,__class__: thx.graph.GraphEdges
});
thx.graph.GraphLayout = function(graph,layers) {
	this.graph = graph;
	this._layers = layers.map(function(arr) {
		return arr.slice();
	});
	this.friendCell = this._cell = new thx.graph.LayoutCell();
	this._updateMap();
	this.length = this._layers.length;
	graph.nodes.onRemove.add($bind(this,this._nodeRemove));
};
$hxClasses["thx.graph.GraphLayout"] = thx.graph.GraphLayout;
thx.graph.GraphLayout.__name__ = ["thx","graph","GraphLayout"];
thx.graph.GraphLayout.arrayCrossings = function(graph,a,b) {
	var map = new haxe.ds.IntMap(), c = 0;
	var _g1 = 0, _g = b.length;
	while(_g1 < _g) {
		var i = _g1++;
		map.set(b[i],i);
	}
	if(a.length <= 1 || b.length <= 1) return c;
	var _g1 = 0, _g = a.length;
	while(_g1 < _g) {
		var i = _g1++;
		var n1 = graph.nodes.get(a[i]);
		var $it0 = n1.graph.edges.positives(n1);
		while( $it0.hasNext() ) {
			var edge1 = $it0.next();
			var p1 = map.get(edge1.head.id);
			if(null == p1) continue;
			var _g3 = i + 1, _g2 = a.length;
			while(_g3 < _g2) {
				var j = _g3++;
				var n2 = graph.nodes.get(a[j]);
				var $it1 = n2.graph.edges.positives(n2);
				while( $it1.hasNext() ) {
					var edge2 = $it1.next();
					var p2 = map.get(edge2.head.id);
					if(p2 < p1) c++;
				}
			}
		}
	}
	return c;
}
thx.graph.GraphLayout.prototype = {
	_nodeRemove: function(node) {
		var c = this.cell(node);
		this._layers[c.layer].splice(c.position,1);
		if(this._layers[c.layer].length == 0) this._layers.splice(c.layer,1);
		this._updateMap();
	}
	,crossings: function() {
		var tot = 0;
		var _g1 = 0, _g = this._layers.length - 1;
		while(_g1 < _g) {
			var i = _g1++;
			tot += thx.graph.GraphLayout.arrayCrossings(this.graph,this._layers[i],this._layers[i + 1]);
		}
		return tot;
	}
	,layers: function() {
		var result = [];
		var _g = 0, _g1 = this._layers;
		while(_g < _g1.length) {
			var arr = _g1[_g];
			++_g;
			result.push(arr.slice());
		}
		return result;
	}
	,layer: function(i) {
		var _g = this;
		return this._layers[i].map(function(id) {
			return _g.graph.nodes.get(id);
		});
	}
	,nodeAt: function(layer,position) {
		var arr = this._layers[layer];
		if(null == arr) return null;
		if(position >= arr.length) return null;
		var id = arr[position];
		return this.graph.nodes.get(id);
	}
	,cell: function(node) {
		if(node.graph != this.graph) throw new thx.error.Error("node doesn't belong to this graph",null,null,{ fileName : "GraphLayout.hx", lineNumber : 59, className : "thx.graph.GraphLayout", methodName : "cell"});
		var pos = this._map.get(node.id);
		if(null == pos) return null;
		return new thx.graph.LayoutCell(pos[0],pos[1],this._layers.length,this._layers[pos[0]].length);
	}
	,each: function(f) {
		var layers = this._layers.length, positions;
		var _g = 0;
		while(_g < layers) {
			var layer = _g++;
			positions = this._layers[layer].length;
			var _g1 = 0;
			while(_g1 < positions) {
				var position = _g1++;
				this.friendCell.update(layer,position,layers,positions);
				f(this._cell,this.graph.nodes.get(this._layers[layer][position]));
			}
		}
	}
	,clone: function() {
		return new thx.graph.GraphLayout(this.graph.clone(),this.layers());
	}
	,_updateMap: function() {
		var _g = this;
		this._map = new haxe.ds.IntMap();
		this.each(function(cell,node) {
			_g._map.set(node.id,[cell.layer,cell.position]);
		});
	}
	,friendCell: null
	,_map: null
	,_cell: null
	,_layers: null
	,length: null
	,graph: null
	,__class__: thx.graph.GraphLayout
}
thx.graph.LayoutCell = function(layer,position,layers,positions) {
	if(positions == null) positions = 0;
	if(layers == null) layers = 0;
	if(position == null) position = 0;
	if(layer == null) layer = 0;
	this.layer = layer;
	this.layers = layers;
	this.position = position;
	this.positions = positions;
};
$hxClasses["thx.graph.LayoutCell"] = thx.graph.LayoutCell;
thx.graph.LayoutCell.__name__ = ["thx","graph","LayoutCell"];
thx.graph.LayoutCell.prototype = {
	update: function(layer,position,layers,positions) {
		this.layer = layer;
		this.layers = layers;
		this.position = position;
		this.positions = positions;
	}
	,positions: null
	,layers: null
	,position: null
	,layer: null
	,__class__: thx.graph.LayoutCell
}
thx.graph.GraphNodes = function(graph,nodeidf) {
	thx.graph.GraphCollection.call(this,graph,nodeidf);
};
$hxClasses["thx.graph.GraphNodes"] = thx.graph.GraphNodes;
thx.graph.GraphNodes.__name__ = ["thx","graph","GraphNodes"];
thx.graph.GraphNodes.newInstance = function(graph,nodeidf) {
	return new thx.graph.GraphNodes(graph,nodeidf);
}
thx.graph.GraphNodes.__super__ = thx.graph.GraphCollection;
thx.graph.GraphNodes.prototype = $extend(thx.graph.GraphCollection.prototype,{
	_remove: function(node) {
		this.graph.edges.unlink(node);
		this.collectionRemove(node);
		node.destroy();
	}
	,_create: function(id,data) {
		var n = thx.graph.GNode.create(this.graph,id,data);
		this.collectionCreate(n);
		return n;
	}
	,create: function(data) {
		return this._create(++this.nextid,data);
	}
	,copyTo: function(graph) {
		var nodes = new thx.graph.GraphNodes(graph);
		var $it0 = this.collection.iterator();
		while( $it0.hasNext() ) {
			var node = $it0.next();
			nodes._create(node.id,node.data);
		}
		nodes.nextid = this.nextid;
		return nodes;
	}
	,__class__: thx.graph.GraphNodes
});
thx.graph.GreedyCyclePartitioner = function() {
};
$hxClasses["thx.graph.GreedyCyclePartitioner"] = thx.graph.GreedyCyclePartitioner;
thx.graph.GreedyCyclePartitioner.__name__ = ["thx","graph","GreedyCyclePartitioner"];
thx.graph.GreedyCyclePartitioner.findMaxPositiveOverNegative = function(graph) {
	var n = null, l = 0;
	var $it0 = graph.nodes.collection.iterator();
	while( $it0.hasNext() ) {
		var node = $it0.next();
		var diff = node.graph.edges.positiveCount(node) - node.graph.edges.negativeCount(node);
		if(null == n || l < diff) {
			n = node;
			l = diff;
		}
	}
	return n;
}
thx.graph.GreedyCyclePartitioner.prototype = {
	partition: function(graph) {
		var left = [], right = [], clone = graph.clone(), n;
		while(!(Iterators.count(clone.nodes.iterator()) == 0)) {
			while(null != (n = clone.findSink())) {
				var $it0 = n.graph.edges.negatives(n);
				while( $it0.hasNext() ) {
					var edge = $it0.next();
					right.unshift(graph.edges.get(edge.id));
					edge.graph.edges._remove(edge);
				}
				n.graph.nodes._remove(n);
			}
			var _g = 0, _g1 = clone.findIsolateds();
			while(_g < _g1.length) {
				var isolated = _g1[_g];
				++_g;
				isolated.graph.nodes._remove(isolated);
			}
			while(null != (n = clone.findSource())) {
				var $it1 = n.graph.edges.positives(n);
				while( $it1.hasNext() ) {
					var edge = $it1.next();
					left.push(graph.edges.get(edge.id));
					edge.graph.edges._remove(edge);
				}
				n.graph.nodes._remove(n);
			}
			if(!(Iterators.count(clone.nodes.iterator()) == 0)) {
				n = thx.graph.GreedyCyclePartitioner.findMaxPositiveOverNegative(clone);
				var $it2 = n.graph.edges.negatives(n);
				while( $it2.hasNext() ) {
					var edge = $it2.next();
					right.unshift(graph.edges.get(edge.id));
					edge.graph.edges._remove(edge);
				}
				var $it3 = n.graph.edges.positives(n);
				while( $it3.hasNext() ) {
					var edge = $it3.next();
					left.push(graph.edges.get(edge.id));
					edge.graph.edges._remove(edge);
				}
				n.graph.nodes._remove(n);
			}
		}
		return { left : left, right : right};
	}
	,__class__: thx.graph.GreedyCyclePartitioner
}
thx.graph.GreedySwitchDecrosser = function() {
};
$hxClasses["thx.graph.GreedySwitchDecrosser"] = thx.graph.GreedySwitchDecrosser;
thx.graph.GreedySwitchDecrosser.__name__ = ["thx","graph","GreedySwitchDecrosser"];
thx.graph.GreedySwitchDecrosser.combined = function() {
	var decross = function(layout) {
		layout = new thx.graph.GreedySwitchDecrosser().decross(layout);
		return new thx.graph.GreedySwitch2Decrosser().decross(layout);
	};
	return { decross : decross};
}
thx.graph.GreedySwitchDecrosser.best = function() {
	var decross = function(layout) {
		var attempts = [new thx.graph.GreedySwitchDecrosser().decross(layout),new thx.graph.GreedySwitch2Decrosser().decross(layout),thx.graph.GreedySwitchDecrosser.combined().decross(layout)];
		return Arrays.min(attempts,function(layout1) {
			return layout1.crossings();
		});
	};
	return { decross : decross};
}
thx.graph.GreedySwitchDecrosser.prototype = {
	swap: function(a,pos) {
		var v = a[pos];
		a[pos] = a[pos + 1];
		a[pos + 1] = v;
	}
	,decrossPair: function(graph,a,b) {
		var tot = thx.graph.GraphLayout.arrayCrossings(graph,a,b), ntot = tot, t;
		do {
			tot = ntot;
			var _g1 = 0, _g = b.length - 1;
			while(_g1 < _g) {
				var i = _g1++;
				this.swap(b,i);
				if((t = thx.graph.GraphLayout.arrayCrossings(graph,a,b)) >= ntot) this.swap(b,i); else ntot = t;
			}
		} while(ntot < tot);
	}
	,decross: function(layout) {
		var layers = layout.layers(), graph = layout.graph, newlayers, newlayout = layout;
		if(layers.length <= 1) return new thx.graph.GraphLayout(layout.graph,layers);
		var totbefore, crossings, len = layers.length - 1, a, b;
		do {
			newlayers = layers.map(function(arr) {
				return arr.slice();
			});
			newlayout = new thx.graph.GraphLayout(graph,layers);
			totbefore = newlayout.crossings();
			var _g = 0;
			while(_g < len) {
				var i = _g++;
				a = newlayers[i];
				b = newlayers[i + 1];
				this.decrossPair(graph,a,b);
			}
			crossings = new thx.graph.GraphLayout(graph,newlayers).crossings();
			layers = newlayers;
		} while(totbefore > crossings);
		return newlayout;
	}
	,__class__: thx.graph.GreedySwitchDecrosser
}
thx.graph.GreedySwitch2Decrosser = function() {
	thx.graph.GreedySwitchDecrosser.call(this);
};
$hxClasses["thx.graph.GreedySwitch2Decrosser"] = thx.graph.GreedySwitch2Decrosser;
thx.graph.GreedySwitch2Decrosser.__name__ = ["thx","graph","GreedySwitch2Decrosser"];
thx.graph.GreedySwitch2Decrosser.__super__ = thx.graph.GreedySwitchDecrosser;
thx.graph.GreedySwitch2Decrosser.prototype = $extend(thx.graph.GreedySwitchDecrosser.prototype,{
	decrossTriplet: function(graph,a,b,c) {
		if(null == a) this.decrossPair(graph,b,c); else if(null == c) this.decrossPair(graph,a,b); else {
			var tot = thx.graph.GraphLayout.arrayCrossings(graph,a,b) + thx.graph.GraphLayout.arrayCrossings(graph,b,c), ntot = tot, t;
			do {
				tot = ntot;
				var _g1 = 0, _g = b.length - 1;
				while(_g1 < _g) {
					var i = _g1++;
					this.swap(b,i);
					if((t = thx.graph.GraphLayout.arrayCrossings(graph,a,b) + thx.graph.GraphLayout.arrayCrossings(graph,b,c)) >= ntot) this.swap(b,i); else ntot = t;
				}
			} while(ntot < tot);
		}
	}
	,decross: function(layout) {
		var layers = layout.layers(), graph = layout.graph, newlayers, newlayout = layout;
		if(layers.length <= 1) return new thx.graph.GraphLayout(layout.graph,layers);
		var totbefore, crossings, len = layers.length - 1, a, b, c;
		do {
			newlayers = layers.map(function(arr) {
				return arr.slice();
			});
			newlayout = new thx.graph.GraphLayout(graph,layers);
			totbefore = newlayout.crossings();
			var _g = 0;
			while(_g < len) {
				var i = _g++;
				a = newlayers[i - 1];
				b = newlayers[i];
				c = newlayers[i + 1];
				this.decrossTriplet(graph,a,b,c);
			}
			crossings = new thx.graph.GraphLayout(graph,newlayers).crossings();
			layers = newlayers;
		} while(totbefore > crossings);
		return newlayout;
	}
	,__class__: thx.graph.GreedySwitch2Decrosser
});
thx.graph.HeaviestNodeLayer = function() {
};
$hxClasses["thx.graph.HeaviestNodeLayer"] = thx.graph.HeaviestNodeLayer;
thx.graph.HeaviestNodeLayer.__name__ = ["thx","graph","HeaviestNodeLayer"];
thx.graph.HeaviestNodeLayer.prototype = {
	lay: function(graph) {
		var layers = [], nodes = Arrays.order(Iterators.array(graph.nodes.iterator()),function(a,b) {
			return Floats.compare(b.positiveWeight(),a.positiveWeight());
		});
		var getLayer = function(index) {
			var layer = layers[index];
			if(null == layer) layer = layers[index] = [];
			return layer;
		};
		var addAt = (function($this) {
			var $r;
			var addAt1 = null;
			addAt1 = function(node,lvl) {
				if(!HxOverrides.remove(nodes,node)) return;
				var layer = getLayer(lvl);
				layer.push(node.id);
				var $it0 = node.graph.edges.positives(node);
				while( $it0.hasNext() ) {
					var edge = $it0.next();
					addAt1(edge.head,lvl + 1);
				}
			};
			$r = addAt1;
			return $r;
		}(this));
		while(nodes.length > 0) addAt(nodes[0],0);
		var _g = 0;
		while(_g < layers.length) {
			var layer = layers[_g];
			++_g;
			layer.sort(null == function(ida,idb) {
				return Floats.compare(graph.nodes.get(idb).positiveWeight(),graph.nodes.get(ida).positiveWeight());
			}?Dynamics.compare:function(ida,idb) {
				return Floats.compare(graph.nodes.get(idb).positiveWeight(),graph.nodes.get(ida).positiveWeight());
			});
			layer;
		}
		return layers;
	}
	,__class__: thx.graph.HeaviestNodeLayer
}
thx.graph.LongestPathLayer = function() {
};
$hxClasses["thx.graph.LongestPathLayer"] = thx.graph.LongestPathLayer;
thx.graph.LongestPathLayer.__name__ = ["thx","graph","LongestPathLayer"];
thx.graph.LongestPathLayer.distanceToASink = function(graph,node) {
	var traverse = (function($this) {
		var $r;
		var traverse1 = null;
		traverse1 = function(it,lvl) {
			var max = lvl;
			while( it.hasNext() ) {
				var edge = it.next();
				if(edge.head.isSink()) continue; else max = Ints.max(max,traverse1(edge.head.positives(),lvl + 1));
			}
			return max;
		};
		$r = traverse1;
		return $r;
	}(this));
	return node.isIsolated()?0:traverse(node.graph.edges.positives(node),1);
}
thx.graph.LongestPathLayer.prototype = {
	lay: function(graph) {
		var clone = graph.clone(), layers = [[]];
		var _g = 0, _g1 = clone.findSinks();
		while(_g < _g1.length) {
			var node = _g1[_g];
			++_g;
			layers[0].push(node.id);
		}
		var _g = 0, _g1 = Iterators.filter(clone.nodes.iterator(),function(n) {
			return !n.isSink();
		});
		while(_g < _g1.length) {
			var node = _g1[_g];
			++_g;
			var pos = thx.graph.LongestPathLayer.distanceToASink(clone,node), layer = layers[pos];
			if(null == layer) layer = layers[pos] = [];
			layer.push(node.id);
		}
		layers.reverse();
		return layers;
	}
	,__class__: thx.graph.LongestPathLayer
}
thx.graph.OneCycleRemover = function() {
};
$hxClasses["thx.graph.OneCycleRemover"] = thx.graph.OneCycleRemover;
thx.graph.OneCycleRemover.__name__ = ["thx","graph","OneCycleRemover"];
thx.graph.OneCycleRemover.prototype = {
	remove: function(graph) {
		var edge, result = [];
		var $it0 = graph.nodes.collection.iterator();
		while( $it0.hasNext() ) {
			var node = $it0.next();
			edge = node.predecessorBy(node);
			if(null == edge) continue;
			result.push({ node : node, weight : edge.weight, data : edge.data});
			edge.graph.edges._remove(edge);
		}
		return result;
	}
	,__class__: thx.graph.OneCycleRemover
}
thx.graph.SugiyamaMethod = function(partitioner,layer,splitter,decrosser) {
	var id = 0;
	this.partitioner = null == partitioner?new thx.graph.GreedyCyclePartitioner():partitioner;
	this.layer = null == layer?new thx.graph.LongestPathLayer():layer;
	this.splitter = null == splitter?new thx.graph.EdgeSplitter():splitter;
	this.decrosser = null == decrosser?thx.graph.GreedySwitchDecrosser.best():decrosser;
};
$hxClasses["thx.graph.SugiyamaMethod"] = thx.graph.SugiyamaMethod;
thx.graph.SugiyamaMethod.__name__ = ["thx","graph","SugiyamaMethod"];
thx.graph.SugiyamaMethod.prototype = {
	resolve: function(graph,nodef,edgef) {
		var onecycles = new thx.graph.OneCycleRemover().remove(graph), twocycles = new thx.graph.TwoCycleRemover().remove(graph);
		var partitions = this.partitioner.partition(graph), reversed = new haxe.ds.StringMap();
		(partitions.left.length > partitions.right.length?partitions.right:partitions.left).forEach(function(edge,_) {
			reversed.set(edge.tail.id + "-" + edge.head.id,[edge.invert()]);
		});
		var layers = this.layer.lay(graph);
		var layout = new thx.graph.GraphLayout(graph,layers);
		var splits = [];
		layout = this.splitter.split(layout,splits,nodef,edgef);
		splits.forEach(function(split,_) {
			var key = split[split.length - 1].head.id + "-" + split[0].tail.id;
			if(reversed.exists(key)) reversed.set(key,split);
		});
		layout = this.decrosser.decross(layout);
		var $it0 = ((function(_e) {
			return function() {
				return _e.iterator();
			};
		})(reversed))();
		while( $it0.hasNext() ) {
			var path = $it0.next();
			path.forEach(function(edge,_) {
				var e = edge.invert();
			});
		}
		var _g = 0;
		while(_g < twocycles.length) {
			var item = twocycles[_g];
			++_g;
			layout.graph.edges.create(item.tail,item.head,item.weight,item.data);
		}
		var _g = 0;
		while(_g < onecycles.length) {
			var item = onecycles[_g];
			++_g;
			layout.graph.edges.create(item.node,item.node,item.weight,item.data);
		}
		return layout;
	}
	,decrosser: null
	,splitter: null
	,layer: null
	,partitioner: null
	,__class__: thx.graph.SugiyamaMethod
}
thx.graph.TwoCycleRemover = function() {
};
$hxClasses["thx.graph.TwoCycleRemover"] = thx.graph.TwoCycleRemover;
thx.graph.TwoCycleRemover.__name__ = ["thx","graph","TwoCycleRemover"];
thx.graph.TwoCycleRemover.prototype = {
	remove: function(graph) {
		var result = [];
		var $it0 = graph.nodes.collection.iterator();
		while( $it0.hasNext() ) {
			var node = $it0.next();
			var $it1 = node.graph.edges.positives(node);
			while( $it1.hasNext() ) {
				var edge = $it1.next();
				var reverse = edge.head.predecessorBy(node);
				if(null == reverse) continue;
				result.push({ tail : reverse.tail, head : reverse.head, weight : reverse.weight, data : reverse.data});
				reverse.graph.edges._remove(reverse);
			}
		}
		return result;
	}
	,__class__: thx.graph.TwoCycleRemover
}
thx.json = {}
thx.json.Json = function() { }
$hxClasses["thx.json.Json"] = thx.json.Json;
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
$hxClasses["thx.json.JsonDecoder"] = thx.json.JsonDecoder;
thx.json.JsonDecoder.__name__ = ["thx","json","JsonDecoder"];
thx.json.JsonDecoder.prototype = {
	error: function(msg) {
		var context = this.pos == this.src.length?"":"\nrest: " + (null != this["char"]?this["char"]:"") + HxOverrides.substr(this.src,this.pos,null) + "...";
		throw new thx.error.Error("error at L {0} C {1}: {2}{3}",[this.line,this.col,msg,context],null,{ fileName : "JsonDecoder.hx", lineNumber : 353, className : "thx.json.JsonDecoder", methodName : "error"});
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
$hxClasses["thx.json.JsonEncoder"] = thx.json.JsonEncoder;
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
thx.math.Ease = function() { }
$hxClasses["thx.math.Ease"] = thx.math.Ease;
thx.math.Ease.__name__ = ["thx","math","Ease"];
thx.math.Ease.mode = function(easemode,f) {
	if(null == f) f = thx.math.Equations.cubic;
	if(null == easemode) easemode = thx.math.EaseMode.EaseIn;
	switch( (easemode)[1] ) {
	case 0:
		return f;
	case 1:
		return function(t) {
			return 1 - f(1 - t);
		};
	case 2:
		return function(t) {
			return .5 * (t < .5?f(2 * t):2 - f(2 - 2 * t));
		};
	case 3:
		return thx.math.Ease.mode(thx.math.EaseMode.EaseInEaseOut,thx.math.Ease.mode(thx.math.EaseMode.EaseOut,f));
	}
}
thx.math.EaseMode = { __ename__ : ["thx","math","EaseMode"], __constructs__ : ["EaseIn","EaseOut","EaseInEaseOut","EaseOutEaseIn"] }
thx.math.EaseMode.EaseIn = ["EaseIn",0];
thx.math.EaseMode.EaseIn.toString = $estr;
thx.math.EaseMode.EaseIn.__enum__ = thx.math.EaseMode;
thx.math.EaseMode.EaseOut = ["EaseOut",1];
thx.math.EaseMode.EaseOut.toString = $estr;
thx.math.EaseMode.EaseOut.__enum__ = thx.math.EaseMode;
thx.math.EaseMode.EaseInEaseOut = ["EaseInEaseOut",2];
thx.math.EaseMode.EaseInEaseOut.toString = $estr;
thx.math.EaseMode.EaseInEaseOut.__enum__ = thx.math.EaseMode;
thx.math.EaseMode.EaseOutEaseIn = ["EaseOutEaseIn",3];
thx.math.EaseMode.EaseOutEaseIn.toString = $estr;
thx.math.EaseMode.EaseOutEaseIn.__enum__ = thx.math.EaseMode;
thx.math.Random = function(seed) {
	if(seed == null) seed = 1;
	this.seed = seed;
};
$hxClasses["thx.math.Random"] = thx.math.Random;
thx.math.Random.__name__ = ["thx","math","Random"];
thx.math.Random.prototype = {
	seed: null
	,__class__: thx.math.Random
}
thx.number = {}
thx.number.NumberParser = function() { }
$hxClasses["thx.number.NumberParser"] = thx.number.NumberParser;
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
thx.svg = {}
thx.svg.Arc = function() {
	this._r0 = function(_,_1) {
		return 0;
	};
	this._r1 = function(_,_1) {
		return 1;
	};
	this._a0 = function(_,_1) {
		return 0;
	};
	this._a1 = function(_,_1) {
		return Math.PI;
	};
};
$hxClasses["thx.svg.Arc"] = thx.svg.Arc;
thx.svg.Arc.__name__ = ["thx","svg","Arc"];
thx.svg.Arc.fromAngleObject = function() {
	return new thx.svg.Arc().startAnglef(function(d,_) {
		return d.startAngle;
	}).endAnglef(function(d,_) {
		return d.endAngle;
	});
}
thx.svg.Arc.prototype = {
	shape: function(d,i) {
		var a0 = this._a0(d,i) + thx.svg.LineInternals.arcOffset, a1 = this._a1(d,i) + thx.svg.LineInternals.arcOffset, da = a1 - a0, df = da < Math.PI?"0":"1", c0 = Math.cos(a0), s0 = Math.sin(a0), c1 = Math.cos(a1), s1 = Math.sin(a1), r0 = this._r0(d,i), r1 = this._r1(d,i);
		return da >= thx.svg.LineInternals.arcMax?r0 != 0?"M0," + r1 + "A" + r1 + "," + r1 + " 0 1,1 0," + -r1 + "A" + r1 + "," + r1 + " 0 1,1 0," + r1 + "M0," + r0 + "A" + r0 + "," + r0 + " 0 1,1 0," + -r0 + "A" + r0 + "," + r0 + " 0 1,1 0," + r0 + "Z":"M0," + r1 + "A" + r1 + "," + r1 + " 0 1,1 0," + -r1 + "A" + r1 + "," + r1 + " 0 1,1 0," + r1 + "Z":r0 != 0?"M" + r1 * c0 + "," + r1 * s0 + "A" + r1 + "," + r1 + " 0 " + df + ",1 " + r1 * c1 + "," + r1 * s1 + "L" + r0 * c1 + "," + r0 * s1 + "A" + r0 + "," + r0 + " 0 " + df + ",0 " + r0 * c0 + "," + r0 * s0 + "Z":"M" + r1 * c0 + "," + r1 * s0 + "A" + r1 + "," + r1 + " 0 " + df + ",1 " + r1 * c1 + "," + r1 * s1 + "L0,0" + "Z";
	}
	,endAnglef: function(v) {
		this._a1 = v;
		return this;
	}
	,startAnglef: function(v) {
		this._a0 = v;
		return this;
	}
	,outerRadiusf: function(v) {
		this._r1 = v;
		return this;
	}
	,outerRadius: function(v) {
		return this.outerRadiusf(function(_,_1) {
			return v;
		});
	}
	,innerRadiusf: function(v) {
		this._r0 = v;
		return this;
	}
	,innerRadius: function(v) {
		return this.innerRadiusf(function(_,_1) {
			return v;
		});
	}
	,_a1: null
	,_a0: null
	,_r1: null
	,_r0: null
	,__class__: thx.svg.Arc
}
thx.svg.Area = function(x,y0,y1,interpolator) {
	this._x = x;
	this._y0 = y0;
	this._y1 = y1;
	this._interpolator = interpolator;
};
$hxClasses["thx.svg.Area"] = thx.svg.Area;
thx.svg.Area.__name__ = ["thx","svg","Area"];
thx.svg.Area.prototype = {
	y1: function(v) {
		this._y1 = v;
		return this;
	}
	,y0: function(v) {
		this._y0 = v;
		return this;
	}
	,x: function(v) {
		this._x = v;
		return this;
	}
	,interpolator: function(type) {
		this._interpolator = type;
		return this;
	}
	,shape: function(data,i) {
		var second = thx.svg.LineInternals.linePoints(data,this._x,this._y0);
		second.reverse();
		return data.length < 1?null:"M" + thx.svg.LineInternals.interpolatePoints(thx.svg.LineInternals.linePoints(data,this._x,this._y1),this._interpolator) + "L" + thx.svg.LineInternals.interpolatePoints(second,this._interpolator) + "Z";
	}
	,_interpolator: null
	,_y1: null
	,_y0: null
	,_x: null
	,__class__: thx.svg.Area
}
thx.svg.Diagonal = function() {
	this._projection = thx.svg.Diagonal.diagonalProjection;
};
$hxClasses["thx.svg.Diagonal"] = thx.svg.Diagonal;
thx.svg.Diagonal.__name__ = ["thx","svg","Diagonal"];
thx.svg.Diagonal.diagonalProjection = function(d,_) {
	return d;
}
thx.svg.Diagonal.forObject = function() {
	return new thx.svg.Diagonal().sourcef(function(d,_i) {
		return [d.x0,d.y0];
	}).targetf(function(d,_i) {
		return [d.x1,d.y1];
	});
}
thx.svg.Diagonal.forArray = function() {
	return new thx.svg.Diagonal().sourcef(function(d,_i) {
		return [d[0],d[1]];
	}).targetf(function(d,_i) {
		return [d[2],d[3]];
	});
}
thx.svg.Diagonal.prototype = {
	projection: function(x) {
		this._projection = x;
		return this;
	}
	,targetf: function(x) {
		this._target = x;
		return this;
	}
	,sourcef: function(x) {
		this._source = x;
		return this;
	}
	,diagonal: function(d,i) {
		var p0 = this._source(d,i), p3 = this._target(d,i), m = (p0[1] + p3[1]) / 2, p = [p0,[p0[0],m],[p3[0],m],p3];
		var p2 = Iterators.map(HxOverrides.iter(p),this._projection);
		return "M " + p2[0][0] + " " + p2[0][1] + " C " + p2[1][0] + " " + p2[1][1] + " " + p2[2][0] + " " + p2[2][1] + " " + p2[3][0] + " " + p2[3][1];
	}
	,_projection: null
	,_target: null
	,_source: null
	,__class__: thx.svg.Diagonal
}
thx.svg.Line = function(x,y,interpolator) {
	this._x = x;
	this._y = y;
	this._interpolator = interpolator;
};
$hxClasses["thx.svg.Line"] = thx.svg.Line;
thx.svg.Line.__name__ = ["thx","svg","Line"];
thx.svg.Line.prototype = {
	interpolator: function(type) {
		this._interpolator = type;
		return this;
	}
	,shape: function(data,i) {
		return data.length < 1?null:"M" + thx.svg.LineInternals.interpolatePoints(thx.svg.LineInternals.linePoints(data,this._x,this._y),this._interpolator);
	}
	,_interpolator: null
	,_y: null
	,_x: null
	,__class__: thx.svg.Line
}
thx.svg.LineInternals = function() { }
$hxClasses["thx.svg.LineInternals"] = thx.svg.LineInternals;
thx.svg.LineInternals.__name__ = ["thx","svg","LineInternals"];
thx.svg.LineInternals.linePoints = function(data,x,y) {
	var points = [], value;
	var _g1 = 0, _g = data.length;
	while(_g1 < _g) {
		var i = _g1++;
		value = data[i];
		points.push([x(value,i),y(value,i)]);
	}
	return points;
}
thx.svg.LineInternals.interpolatePoints = function(points,type) {
	if(null == type) type = thx.svg.LineInterpolator.Linear;
	var path = [], i = 0, n = points.length, p = points[0];
	var $e = (type);
	switch( $e[1] ) {
	case 0:
		path.push(p[0] + "," + p[1]);
		while(++i < n) {
			p = points[i];
			path.push("L" + p[0] + "," + p[1]);
		}
		break;
	case 1:
		var p1;
		path.push(p[0] + "," + p[1]);
		while(++i < n - 1) {
			p = points[i];
			p1 = points[i + 1];
			path.push("H" + (p[0] + p1[0]) / 2 + "V" + p[1]);
		}
		p = points[i];
		path.push("H" + p[0] + "V" + p[1]);
		break;
	case 2:
		path.push(p[0] + "," + p[1]);
		while(++i < n) {
			p = points[i];
			path.push("V" + p[1] + "H" + p[0]);
		}
		break;
	case 3:
		path.push(p[0] + "," + p[1]);
		while(++i < n) {
			p = points[i];
			path.push("H" + p[0] + "V" + p[1]);
		}
		break;
	case 4:
		if(points.length < 3) return thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear);
		i = 1;
		p = points[1];
		var x0 = p[0], y0 = p[1], px = [x0,x0,x0,p[0]], py = [y0,y0,y0,p[1]];
		path.push(x0 + "," + y0);
		thx.svg.LineInternals._lineBasisBezier(path,px,py);
		while(++i < n) {
			p = points[i];
			px.shift();
			px.push(p[0]);
			py.shift();
			py.push(p[1]);
			thx.svg.LineInternals._lineBasisBezier(path,px,py);
		}
		i = -1;
		while(++i < 2) {
			px.shift();
			px.push(p[0]);
			py.shift();
			py.push(p[1]);
			thx.svg.LineInternals._lineBasisBezier(path,px,py);
		}
		break;
	case 5:
		if(points.length < 4) return thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear);
		i = -1;
		var pi, px = [0.0], py = [0.0];
		while(++i < 3) {
			pi = points[i];
			px.push(pi[0]);
			py.push(pi[1]);
		}
		path.push(thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier3,px) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier3,py));
		--i;
		while(++i < n) {
			pi = points[i];
			px.shift();
			px.push(pi[0]);
			py.shift();
			py.push(pi[1]);
			thx.svg.LineInternals._lineBasisBezier(path,px,py);
		}
		break;
	case 6:
		i = -1;
		var m = n + 4, px = [], py = [];
		while(++i < 4) {
			p = points[i % n];
			px.push(p[0]);
			py.push(p[1]);
		}
		path.push(thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier3,px) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier3,py));
		--i;
		while(++i < m) {
			p = points[i % n];
			px.shift();
			px.push(p[0]);
			py.shift();
			py.push(p[1]);
			thx.svg.LineInternals._lineBasisBezier(path,px,py);
		}
		break;
	case 7:
		var tension = $e[2];
		if(null == tension) tension = .7;
		if(points.length < 3) return thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear); else return points[0][0] + "," + points[0][1] + thx.svg.LineInternals._lineHermite(points,thx.svg.LineInternals._lineCardinalTangents(points,tension));
		break;
	case 8:
		var tension = $e[2];
		return points.length < 4?thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear):points[1][0] + "," + points[1][1] + Std.string(thx.svg.LineInternals._lineCardinalTangents(points,tension));
	case 9:
		var tension = $e[2];
		if(null == tension) tension = .7;
		return points.length < 3?thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear):points[0][0] + "," + points[0][1] + thx.svg.LineInternals._lineHermite(points,thx.svg.LineInternals._lineCardinalTangents([points[points.length - 2]].concat(points).concat([points[1]]),tension));
	case 10:
		return points.length < 3?thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear):points[0][0] + "," + points[0][1] + thx.svg.LineInternals._lineHermite(points,thx.svg.LineInternals._lineMonotoneTangents(points));
	}
	return path.join("");
}
thx.svg.LineInternals._lineDot4 = function(a,b) {
	return a[0] * b[0] + a[1] * b[1] + a[2] * b[2] + a[3] * b[3];
}
thx.svg.LineInternals._lineBasisBezier = function(path,x,y) {
	path.push("C" + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier1,x) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier1,y) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier2,x) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier2,y) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier3,x) + "," + thx.svg.LineInternals._lineDot4(thx.svg.LineInternals._lineBasisBezier3,y));
}
thx.svg.LineInternals._lineSlope = function(p0,p1) {
	return (p1[1] - p0[1]) / (p1[0] - p0[0]);
}
thx.svg.LineInternals._lineFiniteDifferences = function(points) {
	var i = 0, j = points.length - 1, m = [], p0 = points[0], p1 = points[1], d = m[0] = thx.svg.LineInternals._lineSlope(p0,p1);
	while(++i < j) m[i] = d + (d = thx.svg.LineInternals._lineSlope(p0 = p1,p1 = points[i + 1]));
	m[i] = d;
	return m;
}
thx.svg.LineInternals._lineMonotoneTangents = function(points) {
	var tangents = [], d, a, b, s, m = thx.svg.LineInternals._lineFiniteDifferences(points), i = -1, j = points.length - 1;
	while(++i < j) {
		d = thx.svg.LineInternals._lineSlope(points[i],points[i + 1]);
		if(Math.abs(d) < 1e-6) m[i] = m[i + 1] = 0; else {
			a = m[i] / d;
			b = m[i + 1] / d;
			s = a * a + b * b;
			if(s > 9) {
				s = d * 3 / Math.sqrt(s);
				m[i] = s * a;
				m[i + 1] = s * b;
			}
		}
	}
	i = -1;
	while(++i <= j) {
		s = (points[Ints.min(j,i + 1)][0] - points[Ints.max(0,i - 1)][0]) / (6 * (1 + m[i] * m[i]));
		tangents.push([Math.isFinite(s)?s:0,Math.isFinite(s = m[i] * s)?s:0]);
	}
	return tangents;
}
thx.svg.LineInternals._lineHermite = function(points,tangents) {
	if(tangents.length < 1 || points.length != tangents.length && points.length != tangents.length + 2) return thx.svg.LineInternals.interpolatePoints(points,thx.svg.LineInterpolator.Linear);
	var quad = points.length != tangents.length, path = "", p0 = points[0], p = points[1], t0 = tangents[0], t = t0, pi = 1;
	if(quad) {
		path += "Q" + (p[0] - t0[0] * 2 / 3) + "," + (p[1] - t0[1] * 2 / 3) + "," + p[0] + "," + p[1];
		p0 = points[1];
		pi = 2;
	}
	if(tangents.length > 1) {
		t = tangents[1];
		p = points[pi];
		pi++;
		path += "C" + (p0[0] + t0[0]) + "," + (p0[1] + t0[1]) + "," + (p[0] - t[0]) + "," + (p[1] - t[1]) + "," + p[0] + "," + p[1];
		var _g1 = 2, _g = tangents.length;
		while(_g1 < _g) {
			var i = _g1++;
			p = points[pi];
			t = tangents[i];
			path += "S" + (p[0] - t[0]) + "," + (p[1] - t[1]) + "," + p[0] + "," + p[1];
			pi++;
		}
	}
	if(quad) {
		var lp = points[pi];
		path += "Q" + (p[0] + t[0] * 2 / 3) + "," + (p[1] + t[1] * 2 / 3) + "," + lp[0] + "," + lp[1];
	}
	return path;
}
thx.svg.LineInternals._lineCardinalTangents = function(points,tension) {
	var tangents = [], a = (1 - tension) / 2, p0 = points[0], p1 = points[1], p2 = points[2], i = 2, n = points.length;
	while(++i < n) {
		tangents.push([a * (p2[0] - p0[0]),a * (p2[1] - p0[1])]);
		p0 = p1;
		p1 = p2;
		p2 = points[i];
	}
	tangents.push([a * (p2[0] - p0[0]),a * (p2[1] - p0[1])]);
	return tangents;
}
thx.svg.LineInterpolator = { __ename__ : ["thx","svg","LineInterpolator"], __constructs__ : ["Linear","Step","StepBefore","StepAfter","Basis","BasisOpen","BasisClosed","Cardinal","CardinalOpen","CardinalClosed","Monotone"] }
thx.svg.LineInterpolator.Linear = ["Linear",0];
thx.svg.LineInterpolator.Linear.toString = $estr;
thx.svg.LineInterpolator.Linear.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.Step = ["Step",1];
thx.svg.LineInterpolator.Step.toString = $estr;
thx.svg.LineInterpolator.Step.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.StepBefore = ["StepBefore",2];
thx.svg.LineInterpolator.StepBefore.toString = $estr;
thx.svg.LineInterpolator.StepBefore.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.StepAfter = ["StepAfter",3];
thx.svg.LineInterpolator.StepAfter.toString = $estr;
thx.svg.LineInterpolator.StepAfter.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.Basis = ["Basis",4];
thx.svg.LineInterpolator.Basis.toString = $estr;
thx.svg.LineInterpolator.Basis.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.BasisOpen = ["BasisOpen",5];
thx.svg.LineInterpolator.BasisOpen.toString = $estr;
thx.svg.LineInterpolator.BasisOpen.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.BasisClosed = ["BasisClosed",6];
thx.svg.LineInterpolator.BasisClosed.toString = $estr;
thx.svg.LineInterpolator.BasisClosed.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolator.Cardinal = function(tension) { var $x = ["Cardinal",7,tension]; $x.__enum__ = thx.svg.LineInterpolator; $x.toString = $estr; return $x; }
thx.svg.LineInterpolator.CardinalOpen = function(tension) { var $x = ["CardinalOpen",8,tension]; $x.__enum__ = thx.svg.LineInterpolator; $x.toString = $estr; return $x; }
thx.svg.LineInterpolator.CardinalClosed = function(tension) { var $x = ["CardinalClosed",9,tension]; $x.__enum__ = thx.svg.LineInterpolator; $x.toString = $estr; return $x; }
thx.svg.LineInterpolator.Monotone = ["Monotone",10];
thx.svg.LineInterpolator.Monotone.toString = $estr;
thx.svg.LineInterpolator.Monotone.__enum__ = thx.svg.LineInterpolator;
thx.svg.LineInterpolators = function() { }
$hxClasses["thx.svg.LineInterpolators"] = thx.svg.LineInterpolators;
thx.svg.LineInterpolators.__name__ = ["thx","svg","LineInterpolators"];
thx.svg.LineInterpolators.parse = function(s,sep) {
	if(sep == null) sep = ":";
	var interp = s.split(sep)[0].toLowerCase();
	return (function($this) {
		var $r;
		switch(interp) {
		case "basis":
			$r = thx.svg.LineInterpolator.Basis;
			break;
		case "basisopen":
			$r = thx.svg.LineInterpolator.BasisOpen;
			break;
		case "basisclosed":
			$r = thx.svg.LineInterpolator.BasisClosed;
			break;
		case "cardinal":
			$r = thx.svg.LineInterpolator.Cardinal(thx.svg.LineInterpolators.argument(s,sep));
			break;
		case "cardinalopen":
			$r = thx.svg.LineInterpolator.CardinalOpen(thx.svg.LineInterpolators.argument(s,sep));
			break;
		case "cardinalclosed":
			$r = thx.svg.LineInterpolator.CardinalClosed(thx.svg.LineInterpolators.argument(s,sep));
			break;
		case "monotone":
			$r = thx.svg.LineInterpolator.Monotone;
			break;
		case "step":
			$r = thx.svg.LineInterpolator.Step;
			break;
		case "stepafter":
			$r = thx.svg.LineInterpolator.StepAfter;
			break;
		case "stepbefore":
			$r = thx.svg.LineInterpolator.StepBefore;
			break;
		default:
			$r = thx.svg.LineInterpolator.Linear;
		}
		return $r;
	}(this));
}
thx.svg.LineInterpolators.argument = function(s,sep) {
	var v = s.split(sep)[1];
	if(null == v) return null; else return Std.parseFloat(v);
}
thx.svg.PathGeoJson = function() {
	this.set_pointRadius(4.5);
	this.set_projection(new thx.geo.AlbersUsa());
	this.pathTypes = new thx.svg.PathTypes(this);
	this.centroidTypes = new thx.svg.CentroidTypes(this);
	this.areaTypes = new thx.svg.AreaTypes(this);
};
$hxClasses["thx.svg.PathGeoJson"] = thx.svg.PathGeoJson;
thx.svg.PathGeoJson.__name__ = ["thx","svg","PathGeoJson"];
thx.svg.PathGeoJson.circle = function(r) {
	return "m0," + r + "a" + r + "," + r + " 0 1,1 0," + -2 * r + "a" + r + "," + r + " 0 1,1 0," + 2 * r + "z";
}
thx.svg.PathGeoJson.prototype = {
	set_projection: function(projection) {
		return this.projection = projection;
	}
	,set_pointRadius: function(r) {
		this.pointRadius = r;
		this.pathCircle = thx.svg.PathGeoJson.circle(r);
		return r;
	}
	,centroid: function(d,_) {
		return this.centroidTypes.centroid(d);
	}
	,path: function(d,_) {
		return this.pathTypes.path(d);
	}
	,areaTypes: null
	,centroidTypes: null
	,pathTypes: null
	,pathCircle: null
	,projection: null
	,pointRadius: null
	,__class__: thx.svg.PathGeoJson
}
thx.svg.PathTypes = function(geo) {
	this.geo = geo;
};
$hxClasses["thx.svg.PathTypes"] = thx.svg.PathTypes;
thx.svg.PathTypes.__name__ = ["thx","svg","PathTypes"];
thx.svg.PathTypes.prototype = {
	project: function(coords) {
		return this.geo.projection.project(coords).join(",");
	}
	,geometryCollection: function(o) {
		var p = [];
		var _g = 0, _g1 = o.geometries;
		while(_g < _g1.length) {
			var geometry = _g1[_g];
			++_g;
			p.push(this.path(geometry));
		}
		return p.join("");
	}
	,multiPolygon: function(o) {
		var p = [], coords = o.coordinates;
		var _g = 0;
		while(_g < coords.length) {
			var coordinates = coords[_g];
			++_g;
			var _g1 = 0;
			while(_g1 < coordinates.length) {
				var subcoordinates = coordinates[_g1];
				++_g1;
				p.push("M");
				var _g2 = 0;
				while(_g2 < subcoordinates.length) {
					var scoords = subcoordinates[_g2];
					++_g2;
					p.push(this.project(scoords));
					p.push("L");
				}
				p[p.length - 1] = "Z";
			}
		}
		return p.join("");
	}
	,polygon: function(o) {
		var p = [], coords = o.coordinates;
		var _g = 0;
		while(_g < coords.length) {
			var coordinates = coords[_g];
			++_g;
			p.push("M");
			var _g2 = 0, _g1 = coordinates.length;
			while(_g2 < _g1) {
				var j = _g2++;
				p.push(this.project(coordinates[j]));
				p.push("L");
			}
			p[p.length - 1] = "Z";
		}
		return p.join("");
	}
	,multiLineString: function(o) {
		var p = [], coords = o.coordinates;
		var _g = 0;
		while(_g < coords.length) {
			var coordinates = coords[_g];
			++_g;
			p.push("M");
			var _g2 = 0, _g1 = coordinates.length;
			while(_g2 < _g1) {
				var i = _g2++;
				p.push(this.project(coordinates[i]));
				p.push("L");
			}
			p.pop();
		}
		return p.join("");
	}
	,lineString: function(o) {
		var p = [], coordinates = o.coordinates;
		var _g1 = 0, _g = coordinates.length;
		while(_g1 < _g) {
			var i = _g1++;
			p.push(this.project(coordinates[i]));
		}
		return "M" + p.join("L");
	}
	,multiPoint: function(o) {
		var p = [], coordinates = o.coordinates;
		var _g1 = 0, _g = coordinates.length;
		while(_g1 < _g) {
			var i = _g1++;
			p.push("M" + this.project(coordinates[i]) + this.geo.pathCircle);
		}
		return p.join("");
	}
	,point: function(o) {
		return "M" + this.project(o.coordinates) + this.geo.pathCircle;
	}
	,feature: function(f) {
		return this.path(f.geometry);
	}
	,featureCollection: function(f) {
		var p = [], features = f.features;
		var _g1 = 0, _g = features.length;
		while(_g1 < _g) {
			var i = _g1++;
			p.push(this.path(features[i].geometry));
		}
		return p.join("");
	}
	,path: function(geo) {
		var field = Reflect.field(this,Strings.lcfirst(geo.type));
		if(null == field) return "";
		return field.apply(this,[geo]);
	}
	,geo: null
	,__class__: thx.svg.PathTypes
}
thx.svg.AreaTypes = function(geo) {
	this.geo = geo;
};
$hxClasses["thx.svg.AreaTypes"] = thx.svg.AreaTypes;
thx.svg.AreaTypes.__name__ = ["thx","svg","AreaTypes"];
thx.svg.AreaTypes.prototype = {
	project: function(d,_) {
		return this.geo.projection.project(d);
	}
	,parea: function(coords) {
		return Math.abs(new thx.geom.Polygon(Iterators.map(HxOverrides.iter(coords),$bind(this,this.project))).area());
	}
	,polygonArea: function(coords) {
		var sum = this.parea(coords[0]);
		var _g1 = 1, _g = coords.length;
		while(_g1 < _g) {
			var i = _g1++;
			sum -= this.parea(coords[i]);
		}
		return sum;
	}
	,geometryCollection: function(o) {
		var sum = 0.0;
		var _g = 0, _g1 = o.geometries;
		while(_g < _g1.length) {
			var geometry = _g1[_g];
			++_g;
			sum += this.area(geometry);
		}
		return sum;
	}
	,multiPolygon: function(o) {
		var sum = 0.0, coords = o.coordinates;
		var _g = 0;
		while(_g < coords.length) {
			var coordinates = coords[_g];
			++_g;
			sum += this.polygonArea(coordinates);
		}
		return sum;
	}
	,polygon: function(o) {
		return this.polygonArea(o.coordinates);
	}
	,multiLineString: function(o) {
		return 0.0;
	}
	,lineString: function(o) {
		return 0.0;
	}
	,multiPoint: function(o) {
		return 0.0;
	}
	,point: function(o) {
		return 0.0;
	}
	,feature: function(f) {
		return this.area(f.geometry);
	}
	,featureCollection: function(f) {
		var a = 0.0;
		var _g = 0, _g1 = f.features;
		while(_g < _g1.length) {
			var feat = _g1[_g];
			++_g;
			a += this.area(feat.geometry);
		}
		return a;
	}
	,area: function(geo) {
		var field = Reflect.field(this,Strings.lcfirst(geo.type));
		if(null == field) return 0.0;
		return field.apply(this,[geo]);
	}
	,geo: null
	,__class__: thx.svg.AreaTypes
}
thx.svg.CentroidTypes = function(geo) {
	this.geo = geo;
};
$hxClasses["thx.svg.CentroidTypes"] = thx.svg.CentroidTypes;
thx.svg.CentroidTypes.__name__ = ["thx","svg","CentroidTypes"];
thx.svg.CentroidTypes.prototype = {
	project: function(d,_) {
		return this.geo.projection.project(d);
	}
	,polygonCentroid: function(coordinates) {
		var polygon = new thx.geom.Polygon(Iterators.map(HxOverrides.iter(coordinates[0]),$bind(this,this.project))), centroid = polygon.centroid(1), x = centroid[0], y = centroid[1], z = Math.abs(polygon.area());
		var _g1 = 1, _g = coordinates.length;
		while(_g1 < _g) {
			var i = _g1++;
			polygon = new thx.geom.Polygon(Iterators.map(HxOverrides.iter(coordinates[i]),$bind(this,this.project)));
			centroid = polygon.centroid(1);
			x -= centroid[0];
			y -= centroid[1];
			z -= Math.abs(polygon.area());
		}
		return [x,y,6 * z];
	}
	,multiPolygon: function(o) {
		var area = 0.0, x = 0.0, y = 0.0, z = 0.0, centroid, coords = o.coordinates;
		var _g = 0;
		while(_g < coords.length) {
			var coordinates = coords[_g];
			++_g;
			centroid = this.polygonCentroid(coordinates);
			x += centroid[0];
			y += centroid[1];
			z += centroid[2];
		}
		return [x / z,y / z];
	}
	,polygon: function(o) {
		var centroid = this.polygonCentroid(o.coordinates);
		return [centroid[0] / centroid[2],centroid[1] / centroid[2]];
	}
	,feature: function(f) {
		return this.centroid(f.geometry);
	}
	,point: function(o) {
		return this.project(o.coordinates);
	}
	,centroid: function(geo) {
		var field = Reflect.field(this,Strings.lcfirst(geo.type));
		if(null == field) return [0.0,0.0];
		return field.apply(this,[geo]);
	}
	,geo: null
	,__class__: thx.svg.CentroidTypes
}
thx.svg.Symbol = function() { }
$hxClasses["thx.svg.Symbol"] = thx.svg.Symbol;
thx.svg.Symbol.__name__ = ["thx","svg","Symbol"];
thx.svg.Symbol.triangleDown = function(size) {
	var rx = Math.sqrt(size / thx.svg.Symbol.sqrt3), ry = rx * thx.svg.Symbol.sqrt3 / 2;
	return "M0," + ry + "L" + rx + "," + -ry + " " + -rx + "," + -ry + "Z";
}
thx.svg.Symbol.triangleUp = function(size) {
	var rx = Math.sqrt(size / thx.svg.Symbol.sqrt3), ry = rx * thx.svg.Symbol.sqrt3 / 2;
	return "M0," + -ry + "L" + rx + "," + ry + " " + -rx + "," + ry + "Z";
}
thx.svg.Symbol.square = function(size) {
	var r = Math.sqrt(size) / 2;
	return "M" + -r + "," + -r + "L" + r + "," + -r + " " + r + "," + r + " " + -r + "," + r + "Z";
}
thx.svg.Symbol.diamond = function(size) {
	var ry = Math.sqrt(size / (2 * thx.svg.Symbol.tan30)), rx = ry * thx.svg.Symbol.tan30;
	return "M0," + -ry + "L" + rx + ",0" + " 0," + ry + " " + -rx + ",0" + "Z";
}
thx.svg.Symbol.cross = function(size) {
	var r = Math.sqrt(size / 5) / 2;
	return "M" + -3 * r + "," + -r + "H" + -r + "V" + -3 * r + "H" + r + "V" + -r + "H" + 3 * r + "V" + r + "H" + r + "V" + 3 * r + "H" + -r + "V" + r + "H" + -3 * r + "Z";
}
thx.svg.Symbol.circle = function(size) {
	var r = Math.sqrt(size / Math.PI);
	return "M0," + r + "A" + r + "," + r + " 0 1,1 0," + -r + "A" + r + "," + r + " 0 1,1 0," + r + "Z";
}
thx.svg.Symbol.arrowUp = function(size) {
	var r = Math.sqrt(size / 2);
	return "M" + -r + ",0" + "h" + r / 2 + "v" + r + "h" + r + "v" + -r + "h" + r / 2 + "l" + -r + "," + -r + "Z";
}
thx.svg.Symbol.arrowDown = function(size) {
	var r = Math.sqrt(size / 2);
	return "M" + -r + ",0" + "h" + r / 2 + "v" + -r + "h" + r + "v" + r + "h" + r / 2 + "l" + -r + "," + r + "Z";
}
thx.svg.Symbol.arrowDownWide = function(size) {
	var r = Math.sqrt(size / 2.5);
	return "M" + -r + ",0" + "h" + r / 4 + "v" + -r + "h" + r * 1.5 + "v" + r + "h" + r / 4 + "l" + -r + "," + r + "Z";
}
thx.svg.Symbol.arrowRight = function(size) {
	var r = Math.sqrt(size / 2);
	return "M" + "0," + -r + "v" + r / 2 + "h" + -r + "v" + r + "h" + r + "v" + r / 2 + "l" + r + "," + -r + "Z";
}
thx.svg.Symbol.arrowLeft = function(size) {
	var r = Math.sqrt(size / 2);
	return "M" + "0," + -r + "v" + r / 2 + "h" + r + "v" + r + "h" + -r + "v" + r / 2 + "l" + -r + "," + -r + "Z";
}
thx.svg.Symbol.star = function(size) {
	var r = Math.sqrt(size / 0.31027) / 2;
	return "M0," + -r + "L" + r * 0.236 + "," + r * -0.325 + " " + r * 0.951 + "," + r * -0.309 + " " + r * 0.382 + "," + r * 0.124 + " " + r * 0.588 + "," + r * 0.809 + " " + r * 0 + "," + r * 0.401 + " " + r * -0.588 + "," + r * 0.809 + " " + r * -0.382 + "," + r * 0.124 + " " + r * -0.951 + "," + r * -0.309 + " " + r * -0.236 + "," + r * -0.325 + " " + "Z";
}
thx.text = {}
thx.text.ERegs = function() { }
$hxClasses["thx.text.ERegs"] = thx.text.ERegs;
thx.text.ERegs.__name__ = ["thx","text","ERegs"];
thx.text.ERegs.escapeERegChars = function(s) {
	if(thx.text.ERegs._escapePattern.match(s)) return thx.text.ERegs._escapePattern.customReplace(s,function(e) {
		return "\\" + e.matched(0);
	}); else return s;
}
function $iterator(o) { if( o instanceof Array ) return function() { return HxOverrides.iter(o); }; return typeof(o.iterator) == 'function' ? $bind(o,o.iterator) : o.iterator; };
var $_, $fid = 0;
function $bind(o,m) { if( m == null ) return null; if( m.__id__ == null ) m.__id__ = $fid++; var f; if( o.hx__closures__ == null ) o.hx__closures__ = {}; else f = o.hx__closures__[m.__id__]; if( f == null ) { f = function(){ return f.method.apply(f.scope, arguments); }; f.scope = o; f.method = m; o.hx__closures__[m.__id__] = f; } return f; };
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
};
Math.__name__ = ["Math"];
Math.NaN = Number.NaN;
Math.NEGATIVE_INFINITY = Number.NEGATIVE_INFINITY;
Math.POSITIVE_INFINITY = Number.POSITIVE_INFINITY;
$hxClasses.Math = Math;
Math.isFinite = function(i) {
	return isFinite(i);
};
Math.isNaN = function(i) {
	return isNaN(i);
};
String.prototype.__class__ = $hxClasses.String = String;
String.__name__ = ["String"];
Array.prototype.__class__ = $hxClasses.Array = Array;
Array.__name__ = ["Array"];
Date.prototype.__class__ = $hxClasses.Date = Date;
Date.__name__ = ["Date"];
var Int = $hxClasses.Int = { __name__ : ["Int"]};
var Dynamic = $hxClasses.Dynamic = { __name__ : ["Dynamic"]};
var Float = $hxClasses.Float = Number;
Float.__name__ = ["Float"];
var Bool = Boolean;
Bool.__ename__ = ["Bool"];
var Class = $hxClasses.Class = { __name__ : ["Class"]};
var Enum = { };
var useragent = dhx.ClientHost.userAgent(), hasnavigator = dhx.ClientHost.hasNavigator(), pattern;
dhx.ClientHost.host = !hasnavigator?dhx.HostType.UnknownServer:typeof module !== 'undefined' && module.exports?dhx.HostType.NodeJs:(pattern = new EReg("MSIE(?:/| )(\\S*);","")).match(useragent)?dhx.HostType.IE(pattern.matched(1)):(pattern = new EReg("Firefox(?:/| )(\\S*)","")).match(useragent)?dhx.HostType.Firefox(pattern.matched(1)):(pattern = new EReg("Chrome(?:/| )(\\S*)","")).match(useragent)?dhx.HostType.Chrome(pattern.matched(1)):(pattern = new EReg("Version(?:/| )(\\S*) Safari(?:/| )(\\S*)","")).match(useragent)?dhx.HostType.Safari(pattern.matched(1)):(pattern = new EReg("Opera(?:/| )(\\S*)","")).match(useragent)?dhx.HostType.Opera(pattern.matched(1)):dhx.HostType.Unknown(useragent);
dhx.ClientHost.os = !hasnavigator?dhx.OSType.UnknownOs:(pattern = new EReg("Windows NT\\s+(\\d+\\.\\d+)","")).match(useragent)?(function($this) {
	var $r;
	var version = (function($this) {
		var $r;
		var _g = pattern.matched(1);
		$r = (function($this) {
			var $r;
			switch(_g) {
			case "5.1":
				$r = "XP";
				break;
			case "5.2":
				$r = "2003/XP x64";
				break;
			case "6.0":
				$r = "Vista";
				break;
			case "6.1":
				$r = "7";
				break;
			case "6.2":
				$r = "8";
				break;
			default:
				$r = "unknown";
			}
			return $r;
		}($this));
		return $r;
	}($this));
	$r = dhx.OSType.Windows(version);
	return $r;
}(this)):new EReg("Mac OS X","").match(useragent)?dhx.OSType.Mac:new EReg("(iPhone|iPad|iPod)","").match(useragent)?dhx.OSType.IOs:new EReg("Linux","").match(useragent)?dhx.OSType.Linux:new EReg("Android","").match(useragent)?dhx.OSType.Android:dhx.OSType.UnknownOs;
dhx.ClientHost.environment = (function($this) {
	var $r;
	var _g = dhx.ClientHost;
	$r = (function($this) {
		var $r;
		switch( (_g.host)[1] ) {
		case 0:
			$r = dhx.EnvironmentType.Server;
			break;
		case 1:
			$r = dhx.EnvironmentType.Server;
			break;
		case 2:
		case 6:
		case 3:
			$r = dhx.EnvironmentType.Desktop;
			break;
		case 4:
			$r = (function($this) {
				var $r;
				var _g1 = dhx.ClientHost;
				$r = (function($this) {
					var $r;
					switch( (_g1.os)[1] ) {
					case 1:
						$r = dhx.EnvironmentType.Mobile;
						break;
					default:
						$r = dhx.EnvironmentType.Desktop;
					}
					return $r;
				}($this));
				return $r;
			}($this));
			break;
		case 5:
			$r = (function($this) {
				var $r;
				var _g1 = dhx.ClientHost;
				$r = (function($this) {
					var $r;
					switch( (_g1.os)[1] ) {
					case 2:
						$r = dhx.EnvironmentType.Mobile;
						break;
					default:
						$r = dhx.EnvironmentType.Desktop;
					}
					return $r;
				}($this));
				return $r;
			}($this));
			break;
		case 7:
			$r = (function($this) {
				var $r;
				var _g1 = dhx.ClientHost;
				$r = (function($this) {
					var $r;
					switch( (_g1.os)[1] ) {
					case 5:
						$r = dhx.EnvironmentType.UnknownEnvironment;
						break;
					default:
						$r = dhx.EnvironmentType.Desktop;
					}
					return $r;
				}($this));
				return $r;
			}($this));
			break;
		}
		return $r;
	}($this));
	return $r;
}(this));
/*!
 * Sizzle CSS Selector Engine
 *  Copyright 2011, The Dojo Foundation
 *  Released under the MIT, BSD, and GPL Licenses.
 *  More information: http://sizzlejs.com/
 */
(function(){

var chunker = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
	done = 0,
	toString = Object.prototype.toString,
	hasDuplicate = false,
	baseHasDuplicate = true,
	rBackslash = /\\/g,
	rNonWord = /\W/;

// Here we check if the JavaScript engine is using some sort of
// optimization where it does not always call our comparision
// function. If that is the case, discard the hasDuplicate value.
//   Thus far that includes Google Chrome.
[0, 0].sort(function() {
	baseHasDuplicate = false;
	return 0;
});

var Sizzle = function( selector, context, results, seed ) {
	results = results || [];
	context = context || document;

	var origContext = context;

	if ( context.nodeType !== 1 && context.nodeType !== 9 ) {
		return [];
	}
	
	if ( !selector || typeof selector !== "string" ) {
		return results;
	}

	var m, set, checkSet, extra, ret, cur, pop, i,
		prune = true,
		contextXML = Sizzle.isXML( context ),
		parts = [],
		soFar = selector;
	
	// Reset the position of the chunker regexp (start from head)
	do {
		chunker.exec( "" );
		m = chunker.exec( soFar );

		if ( m ) {
			soFar = m[3];
		
			parts.push( m[1] );
		
			if ( m[2] ) {
				extra = m[3];
				break;
			}
		}
	} while ( m );

	if ( parts.length > 1 && origPOS.exec( selector ) ) {

		if ( parts.length === 2 && Expr.relative[ parts[0] ] ) {
			set = posProcess( parts[0] + parts[1], context );

		} else {
			set = Expr.relative[ parts[0] ] ?
				[ context ] :
				Sizzle( parts.shift(), context );

			while ( parts.length ) {
				selector = parts.shift();

				if ( Expr.relative[ selector ] ) {
					selector += parts.shift();
				}
				
				set = posProcess( selector, set );
			}
		}

	} else {
		// Take a shortcut and set the context if the root selector is an ID
		// (but not if it'll be faster if the inner selector is an ID)
		if ( !seed && parts.length > 1 && context.nodeType === 9 && !contextXML &&
				Expr.match.ID.test(parts[0]) && !Expr.match.ID.test(parts[parts.length - 1]) ) {

			ret = Sizzle.find( parts.shift(), context, contextXML );
			context = ret.expr ?
				Sizzle.filter( ret.expr, ret.set )[0] :
				ret.set[0];
		}

		if ( context ) {
			ret = seed ?
				{ expr: parts.pop(), set: makeArray(seed) } :
				Sizzle.find( parts.pop(), parts.length === 1 && (parts[0] === "~" || parts[0] === "+") && context.parentNode ? context.parentNode : context, contextXML );

			set = ret.expr ?
				Sizzle.filter( ret.expr, ret.set ) :
				ret.set;

			if ( parts.length > 0 ) {
				checkSet = makeArray( set );

			} else {
				prune = false;
			}

			while ( parts.length ) {
				cur = parts.pop();
				pop = cur;

				if ( !Expr.relative[ cur ] ) {
					cur = "";
				} else {
					pop = parts.pop();
				}

				if ( pop == null ) {
					pop = context;
				}

				Expr.relative[ cur ]( checkSet, pop, contextXML );
			}

		} else {
			checkSet = parts = [];
		}
	}

	if ( !checkSet ) {
		checkSet = set;
	}

	if ( !checkSet ) {
		Sizzle.error( cur || selector );
	}

	if ( toString.call(checkSet) === "[object Array]" ) {
		if ( !prune ) {
			results.push.apply( results, checkSet );

		} else if ( context && context.nodeType === 1 ) {
			for ( i = 0; checkSet[i] != null; i++ ) {
				if ( checkSet[i] && (checkSet[i] === true || checkSet[i].nodeType === 1 && Sizzle.contains(context, checkSet[i])) ) {
					results.push( set[i] );
				}
			}

		} else {
			for ( i = 0; checkSet[i] != null; i++ ) {
				if ( checkSet[i] && checkSet[i].nodeType === 1 ) {
					results.push( set[i] );
				}
			}
		}

	} else {
		makeArray( checkSet, results );
	}

	if ( extra ) {
		Sizzle( extra, origContext, results, seed );
		Sizzle.uniqueSort( results );
	}

	return results;
};

Sizzle.uniqueSort = function( results ) {
	if ( sortOrder ) {
		hasDuplicate = baseHasDuplicate;
		results.sort( sortOrder );

		if ( hasDuplicate ) {
			for ( var i = 1; i < results.length; i++ ) {
				if ( results[i] === results[ i - 1 ] ) {
					results.splice( i--, 1 );
				}
			}
		}
	}

	return results;
};

Sizzle.matches = function( expr, set ) {
	return Sizzle( expr, null, null, set );
};

Sizzle.matchesSelector = function( node, expr ) {
	return Sizzle( expr, null, null, [node] ).length > 0;
};

Sizzle.find = function( expr, context, isXML ) {
	var set;

	if ( !expr ) {
		return [];
	}

	for ( var i = 0, l = Expr.order.length; i < l; i++ ) {
		var match,
			type = Expr.order[i];
		
		if ( (match = Expr.leftMatch[ type ].exec( expr )) ) {
			var left = match[1];
			match.splice( 1, 1 );

			if ( left.substr( left.length - 1 ) !== "\\" ) {
				match[1] = (match[1] || "").replace( rBackslash, "" );
				set = Expr.find[ type ]( match, context, isXML );

				if ( set != null ) {
					expr = expr.replace( Expr.match[ type ], "" );
					break;
				}
			}
		}
	}

	if ( !set ) {
		set = typeof context.getElementsByTagName !== "undefined" ?
			context.getElementsByTagName( "*" ) :
			[];
	}

	return { set: set, expr: expr };
};

Sizzle.filter = function( expr, set, inplace, not ) {
	var match, anyFound,
		old = expr,
		result = [],
		curLoop = set,
		isXMLFilter = set && set[0] && Sizzle.isXML( set[0] );

	while ( expr && set.length ) {
		for ( var type in Expr.filter ) {
			if ( (match = Expr.leftMatch[ type ].exec( expr )) != null && match[2] ) {
				var found, item,
					filter = Expr.filter[ type ],
					left = match[1];

				anyFound = false;

				match.splice(1,1);

				if ( left.substr( left.length - 1 ) === "\\" ) {
					continue;
				}

				if ( curLoop === result ) {
					result = [];
				}

				if ( Expr.preFilter[ type ] ) {
					match = Expr.preFilter[ type ]( match, curLoop, inplace, result, not, isXMLFilter );

					if ( !match ) {
						anyFound = found = true;

					} else if ( match === true ) {
						continue;
					}
				}

				if ( match ) {
					for ( var i = 0; (item = curLoop[i]) != null; i++ ) {
						if ( item ) {
							found = filter( item, match, i, curLoop );
							var pass = not ^ !!found;

							if ( inplace && found != null ) {
								if ( pass ) {
									anyFound = true;

								} else {
									curLoop[i] = false;
								}

							} else if ( pass ) {
								result.push( item );
								anyFound = true;
							}
						}
					}
				}

				if ( found !== undefined ) {
					if ( !inplace ) {
						curLoop = result;
					}

					expr = expr.replace( Expr.match[ type ], "" );

					if ( !anyFound ) {
						return [];
					}

					break;
				}
			}
		}

		// Improper expression
		if ( expr === old ) {
			if ( anyFound == null ) {
				Sizzle.error( expr );

			} else {
				break;
			}
		}

		old = expr;
	}

	return curLoop;
};

Sizzle.error = function( msg ) {
	throw "Syntax error, unrecognized expression: " + msg;
};

var Expr = Sizzle.selectors = {
	order: [ "ID", "NAME", "TAG" ],

	match: {
		ID: /#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
		CLASS: /\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
		NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,
		ATTR: /\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(?:(['"])(.*?)\3|(#?(?:[\w\u00c0-\uFFFF\-]|\\.)*)|)|)\s*\]/,
		TAG: /^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
		CHILD: /:(only|nth|last|first)-child(?:\(\s*(even|odd|(?:[+\-]?\d+|(?:[+\-]?\d*)?n\s*(?:[+\-]\s*\d+)?))\s*\))?/,
		POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,
		PSEUDO: /:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
	},

	leftMatch: {},

	attrMap: {
		"class": "className",
		"for": "htmlFor"
	},

	attrHandle: {
		href: function( elem ) {
			return elem.getAttribute( "href" );
		},
		type: function( elem ) {
			return elem.getAttribute( "type" );
		}
	},

	relative: {
		"+": function(checkSet, part){
			var isPartStr = typeof part === "string",
				isTag = isPartStr && !rNonWord.test( part ),
				isPartStrNotTag = isPartStr && !isTag;

			if ( isTag ) {
				part = part.toLowerCase();
			}

			for ( var i = 0, l = checkSet.length, elem; i < l; i++ ) {
				if ( (elem = checkSet[i]) ) {
					while ( (elem = elem.previousSibling) && elem.nodeType !== 1 ) {}

					checkSet[i] = isPartStrNotTag || elem && elem.nodeName.toLowerCase() === part ?
						elem || false :
						elem === part;
				}
			}

			if ( isPartStrNotTag ) {
				Sizzle.filter( part, checkSet, true );
			}
		},

		">": function( checkSet, part ) {
			var elem,
				isPartStr = typeof part === "string",
				i = 0,
				l = checkSet.length;

			if ( isPartStr && !rNonWord.test( part ) ) {
				part = part.toLowerCase();

				for ( ; i < l; i++ ) {
					elem = checkSet[i];

					if ( elem ) {
						var parent = elem.parentNode;
						checkSet[i] = parent.nodeName.toLowerCase() === part ? parent : false;
					}
				}

			} else {
				for ( ; i < l; i++ ) {
					elem = checkSet[i];

					if ( elem ) {
						checkSet[i] = isPartStr ?
							elem.parentNode :
							elem.parentNode === part;
					}
				}

				if ( isPartStr ) {
					Sizzle.filter( part, checkSet, true );
				}
			}
		},

		"": function(checkSet, part, isXML){
			var nodeCheck,
				doneName = done++,
				checkFn = dirCheck;

			if ( typeof part === "string" && !rNonWord.test( part ) ) {
				part = part.toLowerCase();
				nodeCheck = part;
				checkFn = dirNodeCheck;
			}

			checkFn( "parentNode", part, doneName, checkSet, nodeCheck, isXML );
		},

		"~": function( checkSet, part, isXML ) {
			var nodeCheck,
				doneName = done++,
				checkFn = dirCheck;

			if ( typeof part === "string" && !rNonWord.test( part ) ) {
				part = part.toLowerCase();
				nodeCheck = part;
				checkFn = dirNodeCheck;
			}

			checkFn( "previousSibling", part, doneName, checkSet, nodeCheck, isXML );
		}
	},

	find: {
		ID: function( match, context, isXML ) {
			if ( typeof context.getElementById !== "undefined" && !isXML ) {
				var m = context.getElementById(match[1]);
				// Check parentNode to catch when Blackberry 4.6 returns
				// nodes that are no longer in the document #6963
				return m && m.parentNode ? [m] : [];
			}
		},

		NAME: function( match, context ) {
			if ( typeof context.getElementsByName !== "undefined" ) {
				var ret = [],
					results = context.getElementsByName( match[1] );

				for ( var i = 0, l = results.length; i < l; i++ ) {
					if ( results[i].getAttribute("name") === match[1] ) {
						ret.push( results[i] );
					}
				}

				return ret.length === 0 ? null : ret;
			}
		},

		TAG: function( match, context ) {
			if ( typeof context.getElementsByTagName !== "undefined" ) {
				return context.getElementsByTagName( match[1] );
			}
		}
	},
	preFilter: {
		CLASS: function( match, curLoop, inplace, result, not, isXML ) {
			match = " " + match[1].replace( rBackslash, "" ) + " ";

			if ( isXML ) {
				return match;
			}

			for ( var i = 0, elem; (elem = curLoop[i]) != null; i++ ) {
				if ( elem ) {
					if ( not ^ (elem.className && (" " + elem.className + " ").replace(/[\t\n\r]/g, " ").indexOf(match) >= 0) ) {
						if ( !inplace ) {
							result.push( elem );
						}

					} else if ( inplace ) {
						curLoop[i] = false;
					}
				}
			}

			return false;
		},

		ID: function( match ) {
			return match[1].replace( rBackslash, "" );
		},

		TAG: function( match, curLoop ) {
			return match[1].replace( rBackslash, "" ).toLowerCase();
		},

		CHILD: function( match ) {
			if ( match[1] === "nth" ) {
				if ( !match[2] ) {
					Sizzle.error( match[0] );
				}

				match[2] = match[2].replace(/^\+|\s*/g, '');

				// parse equations like 'even', 'odd', '5', '2n', '3n+2', '4n-1', '-n+6'
				var test = /(-?)(\d*)(?:n([+\-]?\d*))?/.exec(
					match[2] === "even" && "2n" || match[2] === "odd" && "2n+1" ||
					!/\D/.test( match[2] ) && "0n+" + match[2] || match[2]);

				// calculate the numbers (first)n+(last) including if they are negative
				match[2] = (test[1] + (test[2] || 1)) - 0;
				match[3] = test[3] - 0;
			}
			else if ( match[2] ) {
				Sizzle.error( match[0] );
			}

			// TODO: Move to normal caching system
			match[0] = done++;

			return match;
		},

		ATTR: function( match, curLoop, inplace, result, not, isXML ) {
			var name = match[1] = match[1].replace( rBackslash, "" );
			
			if ( !isXML && Expr.attrMap[name] ) {
				match[1] = Expr.attrMap[name];
			}

			// Handle if an un-quoted value was used
			match[4] = ( match[4] || match[5] || "" ).replace( rBackslash, "" );

			if ( match[2] === "~=" ) {
				match[4] = " " + match[4] + " ";
			}

			return match;
		},

		PSEUDO: function( match, curLoop, inplace, result, not ) {
			if ( match[1] === "not" ) {
				// If we're dealing with a complex expression, or a simple one
				if ( ( chunker.exec(match[3]) || "" ).length > 1 || /^\w/.test(match[3]) ) {
					match[3] = Sizzle(match[3], null, null, curLoop);

				} else {
					var ret = Sizzle.filter(match[3], curLoop, inplace, true ^ not);

					if ( !inplace ) {
						result.push.apply( result, ret );
					}

					return false;
				}

			} else if ( Expr.match.POS.test( match[0] ) || Expr.match.CHILD.test( match[0] ) ) {
				return true;
			}
			
			return match;
		},

		POS: function( match ) {
			match.unshift( true );

			return match;
		}
	},
	
	filters: {
		enabled: function( elem ) {
			return elem.disabled === false && elem.type !== "hidden";
		},

		disabled: function( elem ) {
			return elem.disabled === true;
		},

		checked: function( elem ) {
			return elem.checked === true;
		},
		
		selected: function( elem ) {
			// Accessing this property makes selected-by-default
			// options in Safari work properly
			if ( elem.parentNode ) {
				elem.parentNode.selectedIndex;
			}
			
			return elem.selected === true;
		},

		parent: function( elem ) {
			return !!elem.firstChild;
		},

		empty: function( elem ) {
			return !elem.firstChild;
		},

		has: function( elem, i, match ) {
			return !!Sizzle( match[3], elem ).length;
		},

		header: function( elem ) {
			return (/h\d/i).test( elem.nodeName );
		},

		text: function( elem ) {
			var attr = elem.getAttribute( "type" ), type = elem.type;
			// IE6 and 7 will map elem.type to 'text' for new HTML5 types (search, etc)
			// use getAttribute instead to test this case
			return "text" === type && ( attr === type || attr === null );
		},

		radio: function( elem ) {
			return "radio" === elem.type;
		},

		checkbox: function( elem ) {
			return "checkbox" === elem.type;
		},

		file: function( elem ) {
			return "file" === elem.type;
		},
		password: function( elem ) {
			return "password" === elem.type;
		},

		submit: function( elem ) {
			return "submit" === elem.type;
		},

		image: function( elem ) {
			return "image" === elem.type;
		},

		reset: function( elem ) {
			return "reset" === elem.type;
		},

		button: function( elem ) {
			return "button" === elem.type || elem.nodeName.toLowerCase() === "button";
		},

		input: function( elem ) {
			return (/input|select|textarea|button/i).test( elem.nodeName );
		}
	},
	setFilters: {
		first: function( elem, i ) {
			return i === 0;
		},

		last: function( elem, i, match, array ) {
			return i === array.length - 1;
		},

		even: function( elem, i ) {
			return i % 2 === 0;
		},

		odd: function( elem, i ) {
			return i % 2 === 1;
		},

		lt: function( elem, i, match ) {
			return i < match[3] - 0;
		},

		gt: function( elem, i, match ) {
			return i > match[3] - 0;
		},

		nth: function( elem, i, match ) {
			return match[3] - 0 === i;
		},

		eq: function( elem, i, match ) {
			return match[3] - 0 === i;
		}
	},
	filter: {
		PSEUDO: function( elem, match, i, array ) {
			var name = match[1],
				filter = Expr.filters[ name ];

			if ( filter ) {
				return filter( elem, i, match, array );

			} else if ( name === "contains" ) {
				return (elem.textContent || elem.innerText || Sizzle.getText([ elem ]) || "").indexOf(match[3]) >= 0;

			} else if ( name === "not" ) {
				var not = match[3];

				for ( var j = 0, l = not.length; j < l; j++ ) {
					if ( not[j] === elem ) {
						return false;
					}
				}

				return true;

			} else {
				Sizzle.error( name );
			}
		},

		CHILD: function( elem, match ) {
			var type = match[1],
				node = elem;

			switch ( type ) {
				case "only":
				case "first":
					while ( (node = node.previousSibling) )	 {
						if ( node.nodeType === 1 ) {
							return false;
						}
					}

					if ( type === "first" ) {
						return true;
					}

					node = elem;

				case "last":
					while ( (node = node.nextSibling) )	 {
						if ( node.nodeType === 1 ) {
							return false;
						}
					}

					return true;

				case "nth":
					var first = match[2],
						last = match[3];

					if ( first === 1 && last === 0 ) {
						return true;
					}
					
					var doneName = match[0],
						parent = elem.parentNode;
	
					if ( parent && (parent.sizcache !== doneName || !elem.nodeIndex) ) {
						var count = 0;
						
						for ( node = parent.firstChild; node; node = node.nextSibling ) {
							if ( node.nodeType === 1 ) {
								node.nodeIndex = ++count;
							}
						}

						parent.sizcache = doneName;
					}
					
					var diff = elem.nodeIndex - last;

					if ( first === 0 ) {
						return diff === 0;

					} else {
						return ( diff % first === 0 && diff / first >= 0 );
					}
			}
		},

		ID: function( elem, match ) {
			return elem.nodeType === 1 && elem.getAttribute("id") === match;
		},

		TAG: function( elem, match ) {
			return (match === "*" && elem.nodeType === 1) || elem.nodeName.toLowerCase() === match;
		},
		
		CLASS: function( elem, match ) {
			return (" " + (elem.className || elem.getAttribute("class")) + " ")
				.indexOf( match ) > -1;
		},

		ATTR: function( elem, match ) {
			var name = match[1],
				result = Expr.attrHandle[ name ] ?
					Expr.attrHandle[ name ]( elem ) :
					elem[ name ] != null ?
						elem[ name ] :
						elem.getAttribute( name ),
				value = result + "",
				type = match[2],
				check = match[4];

			return result == null ?
				type === "!=" :
				type === "=" ?
				value === check :
				type === "*=" ?
				value.indexOf(check) >= 0 :
				type === "~=" ?
				(" " + value + " ").indexOf(check) >= 0 :
				!check ?
				value && result !== false :
				type === "!=" ?
				value !== check :
				type === "^=" ?
				value.indexOf(check) === 0 :
				type === "$=" ?
				value.substr(value.length - check.length) === check :
				type === "|=" ?
				value === check || value.substr(0, check.length + 1) === check + "-" :
				false;
		},

		POS: function( elem, match, i, array ) {
			var name = match[2],
				filter = Expr.setFilters[ name ];

			if ( filter ) {
				return filter( elem, i, match, array );
			}
		}
	}
};

var origPOS = Expr.match.POS,
	fescape = function(all, num){
		return "\\" + (num - 0 + 1);
	};

for ( var type in Expr.match ) {
	Expr.match[ type ] = new RegExp( Expr.match[ type ].source + (/(?![^\[]*\])(?![^\(]*\))/.source) );
	Expr.leftMatch[ type ] = new RegExp( /(^(?:.|\r|\n)*?)/.source + Expr.match[ type ].source.replace(/\\(\d+)/g, fescape) );
}

var makeArray = function( array, results ) {
	array = Array.prototype.slice.call( array, 0 );

	if ( results ) {
		results.push.apply( results, array );
		return results;
	}
	
	return array;
};

// Perform a simple check to determine if the browser is capable of
// converting a NodeList to an array using builtin methods.
// Also verifies that the returned array holds DOM nodes
// (which is not the case in the Blackberry browser)
try {
	Array.prototype.slice.call( document.documentElement.childNodes, 0 )[0].nodeType;

// Provide a fallback method if it does not work
} catch( e ) {
	makeArray = function( array, results ) {
		var i = 0,
			ret = results || [];

		if ( toString.call(array) === "[object Array]" ) {
			Array.prototype.push.apply( ret, array );

		} else {
			if ( typeof array.length === "number" ) {
				for ( var l = array.length; i < l; i++ ) {
					ret.push( array[i] );
				}

			} else {
				for ( ; array[i]; i++ ) {
					ret.push( array[i] );
				}
			}
		}

		return ret;
	};
}

var sortOrder, siblingCheck;

if ( document.documentElement.compareDocumentPosition ) {
	sortOrder = function( a, b ) {
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		if ( !a.compareDocumentPosition || !b.compareDocumentPosition ) {
			return a.compareDocumentPosition ? -1 : 1;
		}

		return a.compareDocumentPosition(b) & 4 ? -1 : 1;
	};

} else {
	sortOrder = function( a, b ) {
		var al, bl,
			ap = [],
			bp = [],
			aup = a.parentNode,
			bup = b.parentNode,
			cur = aup;

		// The nodes are identical, we can exit early
		if ( a === b ) {
			hasDuplicate = true;
			return 0;

		// If the nodes are siblings (or identical) we can do a quick check
		} else if ( aup === bup ) {
			return siblingCheck( a, b );

		// If no parents were found then the nodes are disconnected
		} else if ( !aup ) {
			return -1;

		} else if ( !bup ) {
			return 1;
		}

		// Otherwise they're somewhere else in the tree so we need
		// to build up a full list of the parentNodes for comparison
		while ( cur ) {
			ap.unshift( cur );
			cur = cur.parentNode;
		}

		cur = bup;

		while ( cur ) {
			bp.unshift( cur );
			cur = cur.parentNode;
		}

		al = ap.length;
		bl = bp.length;

		// Start walking down the tree looking for a discrepancy
		for ( var i = 0; i < al && i < bl; i++ ) {
			if ( ap[i] !== bp[i] ) {
				return siblingCheck( ap[i], bp[i] );
			}
		}

		// We ended someplace up the tree so do a sibling check
		return i === al ?
			siblingCheck( a, bp[i], -1 ) :
			siblingCheck( ap[i], b, 1 );
	};

	siblingCheck = function( a, b, ret ) {
		if ( a === b ) {
			return ret;
		}

		var cur = a.nextSibling;

		while ( cur ) {
			if ( cur === b ) {
				return -1;
			}

			cur = cur.nextSibling;
		}

		return 1;
	};
}

// Utility function for retreiving the text value of an array of DOM nodes
Sizzle.getText = function( elems ) {
	var ret = "", elem;

	for ( var i = 0; elems[i]; i++ ) {
		elem = elems[i];

		// Get the text from text nodes and CDATA nodes
		if ( elem.nodeType === 3 || elem.nodeType === 4 ) {
			ret += elem.nodeValue;

		// Traverse everything else, except comment nodes
		} else if ( elem.nodeType !== 8 ) {
			ret += Sizzle.getText( elem.childNodes );
		}
	}

	return ret;
};

// Check to see if the browser returns elements by name when
// querying by getElementById (and provide a workaround)
(function(){
	// We're going to inject a fake input element with a specified name
	var form = document.createElement("div"),
		id = "script" + (new Date()).getTime(),
		root = document.documentElement;

	form.innerHTML = "<a name='" + id + "'/>";

	// Inject it into the root element, check its status, and remove it quickly
	root.insertBefore( form, root.firstChild );

	// The workaround has to do additional checks after a getElementById
	// Which slows things down for other browsers (hence the branching)
	if ( document.getElementById( id ) ) {
		Expr.find.ID = function( match, context, isXML ) {
			if ( typeof context.getElementById !== "undefined" && !isXML ) {
				var m = context.getElementById(match[1]);

				return m ?
					m.id === match[1] || typeof m.getAttributeNode !== "undefined" && m.getAttributeNode("id").nodeValue === match[1] ?
						[m] :
						undefined :
					[];
			}
		};

		Expr.filter.ID = function( elem, match ) {
			var node = typeof elem.getAttributeNode !== "undefined" && elem.getAttributeNode("id");

			return elem.nodeType === 1 && node && node.nodeValue === match;
		};
	}

	root.removeChild( form );

	// release memory in IE
	root = form = null;
})();

(function(){
	// Check to see if the browser returns only elements
	// when doing getElementsByTagName("*")

	// Create a fake element
	var div = document.createElement("div");
	div.appendChild( document.createComment("") );

	// Make sure no comments are found
	if ( div.getElementsByTagName("*").length > 0 ) {
		Expr.find.TAG = function( match, context ) {
			var results = context.getElementsByTagName( match[1] );

			// Filter out possible comments
			if ( match[1] === "*" ) {
				var tmp = [];

				for ( var i = 0; results[i]; i++ ) {
					if ( results[i].nodeType === 1 ) {
						tmp.push( results[i] );
					}
				}

				results = tmp;
			}

			return results;
		};
	}

	// Check to see if an attribute returns normalized href attributes
	div.innerHTML = "<a href='#'></a>";

	if ( div.firstChild && typeof div.firstChild.getAttribute !== "undefined" &&
			div.firstChild.getAttribute("href") !== "#" ) {

		Expr.attrHandle.href = function( elem ) {
			return elem.getAttribute( "href", 2 );
		};
	}

	// release memory in IE
	div = null;
})();

if ( document.querySelectorAll ) {
	(function(){
		var oldSizzle = Sizzle,
			div = document.createElement("div"),
			id = "__sizzle__";

		div.innerHTML = "<p class='TEST'></p>";

		// Safari can't handle uppercase or unicode characters when
		// in quirks mode.
		if ( div.querySelectorAll && div.querySelectorAll(".TEST").length === 0 ) {
			return;
		}
	
		Sizzle = function( query, context, extra, seed ) {
			context = context || document;

			// Only use querySelectorAll on non-XML documents
			// (ID selectors don't work in non-HTML documents)
			if ( !seed && !Sizzle.isXML(context) ) {
				// See if we find a selector to speed up
				var match = /^(\w+$)|^\.([\w\-]+$)|^#([\w\-]+$)/.exec( query );
				
				if ( match && (context.nodeType === 1 || context.nodeType === 9) ) {
					// Speed-up: Sizzle("TAG")
					if ( match[1] ) {
						return makeArray( context.getElementsByTagName( query ), extra );
					
					// Speed-up: Sizzle(".CLASS")
					} else if ( match[2] && Expr.find.CLASS && context.getElementsByClassName ) {
						return makeArray( context.getElementsByClassName( match[2] ), extra );
					}
				}
				
				if ( context.nodeType === 9 ) {
					// Speed-up: Sizzle("body")
					// The body element only exists once, optimize finding it
					if ( query === "body" && context.body ) {
						return makeArray( [ context.body ], extra );
						
					// Speed-up: Sizzle("#ID")
					} else if ( match && match[3] ) {
						var elem = context.getElementById( match[3] );

						// Check parentNode to catch when Blackberry 4.6 returns
						// nodes that are no longer in the document #6963
						if ( elem && elem.parentNode ) {
							// Handle the case where IE and Opera return items
							// by name instead of ID
							if ( elem.id === match[3] ) {
								return makeArray( [ elem ], extra );
							}
							
						} else {
							return makeArray( [], extra );
						}
					}
					
					try {
						return makeArray( context.querySelectorAll(query), extra );
					} catch(qsaError) {}

				// qSA works strangely on Element-rooted queries
				// We can work around this by specifying an extra ID on the root
				// and working up from there (Thanks to Andrew Dupont for the technique)
				// IE 8 doesn't work on object elements
				} else if ( context.nodeType === 1 && context.nodeName.toLowerCase() !== "object" ) {
					var oldContext = context,
						old = context.getAttribute( "id" ),
						nid = old || id,
						hasParent = context.parentNode,
						relativeHierarchySelector = /^\s*[+~]/.test( query );

					if ( !old ) {
						context.setAttribute( "id", nid );
					} else {
						nid = nid.replace( /'/g, "\\$&" );
					}
					if ( relativeHierarchySelector && hasParent ) {
						context = context.parentNode;
					}

					try {
						if ( !relativeHierarchySelector || hasParent ) {
							return makeArray( context.querySelectorAll( "[id='" + nid + "'] " + query ), extra );
						}

					} catch(pseudoError) {
					} finally {
						if ( !old ) {
							oldContext.removeAttribute( "id" );
						}
					}
				}
			}
		
			return oldSizzle(query, context, extra, seed);
		};

		for ( var prop in oldSizzle ) {
			Sizzle[ prop ] = oldSizzle[ prop ];
		}

		// release memory in IE
		div = null;
	})();
}

(function(){
	var html = document.documentElement,
		matches = html.matchesSelector || html.mozMatchesSelector || html.webkitMatchesSelector || html.msMatchesSelector;

	if ( matches ) {
		// Check to see if it's possible to do matchesSelector
		// on a disconnected node (IE 9 fails this)
		var disconnectedMatch = !matches.call( document.createElement( "div" ), "div" ),
			pseudoWorks = false;

		try {
			// This should fail with an exception
			// Gecko does not error, returns false instead
			matches.call( document.documentElement, "[test!='']:sizzle" );
	
		} catch( pseudoError ) {
			pseudoWorks = true;
		}

		Sizzle.matchesSelector = function( node, expr ) {
			// Make sure that attribute selectors are quoted
			expr = expr.replace(/\=\s*([^'"\]]*)\s*\]/g, "='$1']");

			if ( !Sizzle.isXML( node ) ) {
				try {
					if ( pseudoWorks || !Expr.match.PSEUDO.test( expr ) && !/!=/.test( expr ) ) {
						var ret = matches.call( node, expr );

						// IE 9's matchesSelector returns false on disconnected nodes
						if ( ret || !disconnectedMatch ||
								// As well, disconnected nodes are said to be in a document
								// fragment in IE 9, so check for that
								node.document && node.document.nodeType !== 11 ) {
							return ret;
						}
					}
				} catch(e) {}
			}

			return Sizzle(expr, null, null, [node]).length > 0;
		};
	}
})();

(function(){
	var div = document.createElement("div");

	div.innerHTML = "<div class='test e'></div><div class='test'></div>";

	// Opera can't find a second classname (in 9.6)
	// Also, make sure that getElementsByClassName actually exists
	if ( !div.getElementsByClassName || div.getElementsByClassName("e").length === 0 ) {
		return;
	}

	// Safari caches class attributes, doesn't catch changes (in 3.2)
	div.lastChild.className = "e";

	if ( div.getElementsByClassName("e").length === 1 ) {
		return;
	}
	
	Expr.order.splice(1, 0, "CLASS");
	Expr.find.CLASS = function( match, context, isXML ) {
		if ( typeof context.getElementsByClassName !== "undefined" && !isXML ) {
			return context.getElementsByClassName(match[1]);
		}
	};

	// release memory in IE
	div = null;
})();

function dirNodeCheck( dir, cur, doneName, checkSet, nodeCheck, isXML ) {
	for ( var i = 0, l = checkSet.length; i < l; i++ ) {
		var elem = checkSet[i];

		if ( elem ) {
			var match = false;

			elem = elem[dir];

			while ( elem ) {
				if ( elem.sizcache === doneName ) {
					match = checkSet[elem.sizset];
					break;
				}

				if ( elem.nodeType === 1 && !isXML ){
					elem.sizcache = doneName;
					elem.sizset = i;
				}

				if ( elem.nodeName.toLowerCase() === cur ) {
					match = elem;
					break;
				}

				elem = elem[dir];
			}

			checkSet[i] = match;
		}
	}
}

function dirCheck( dir, cur, doneName, checkSet, nodeCheck, isXML ) {
	for ( var i = 0, l = checkSet.length; i < l; i++ ) {
		var elem = checkSet[i];

		if ( elem ) {
			var match = false;
			
			elem = elem[dir];

			while ( elem ) {
				if ( elem.sizcache === doneName ) {
					match = checkSet[elem.sizset];
					break;
				}

				if ( elem.nodeType === 1 ) {
					if ( !isXML ) {
						elem.sizcache = doneName;
						elem.sizset = i;
					}

					if ( typeof cur !== "string" ) {
						if ( elem === cur ) {
							match = true;
							break;
						}

					} else if ( Sizzle.filter( cur, [elem] ).length > 0 ) {
						match = elem;
						break;
					}
				}

				elem = elem[dir];
			}

			checkSet[i] = match;
		}
	}
}

if ( document.documentElement.contains ) {
	Sizzle.contains = function( a, b ) {
		return a !== b && (a.contains ? a.contains(b) : true);
	};

} else if ( document.documentElement.compareDocumentPosition ) {
	Sizzle.contains = function( a, b ) {
		return !!(a.compareDocumentPosition(b) & 16);
	};

} else {
	Sizzle.contains = function() {
		return false;
	};
}

Sizzle.isXML = function( elem ) {
	// documentElement is verified for cases where it doesn't yet exist
	// (such as loading iframes in IE - #4833)
	var documentElement = (elem ? elem.ownerDocument || elem : 0).documentElement;

	return documentElement ? documentElement.nodeName !== "HTML" : false;
};

var posProcess = function( selector, context ) {
	var match,
		tmpSet = [],
		later = "",
		root = context.nodeType ? [context] : context;

	// Position selectors must be done after the filter
	// And so must :not(positional) so we move all PSEUDOs to the end
	while ( (match = Expr.match.PSEUDO.exec( selector )) ) {
		later += match[0];
		selector = selector.replace( Expr.match.PSEUDO, "" );
	}

	selector = Expr.relative[selector] ? selector + "*" : selector;

	for ( var i = 0, l = root.length; i < l; i++ ) {
		Sizzle( selector, root[i], tmpSet );
	}

	return Sizzle.filter( later, tmpSet );
};

// EXPOSE

window.Sizzle = Sizzle;

})();;
var s = dhx.SizzleEngine.getSizzle();
dhx.Sizzle = s;
dhx.Sizzle.select = s;
window.requestAnimationFrame = window.requestAnimationFrame
    || window.webkitRequestAnimationFrame
    || window.mozRequestAnimationFrame
    || window.oRequestAnimationFrame
    || window.msRequestAnimationFrame
    || function(callback) { setTimeout(callback, 1000 / 60); } ;
var r = window.ReportGrid?window.ReportGrid:window.ReportGrid = { };
r.$ = r.$ || { };
r.$.pk = r.$.pk || { };
r.$.pk.rg_query_BaseQuery = r.$.pk.rg_query_BaseQuery || rg.query.BaseQuery;
r.$.pk.rg_query_Query = r.$.pk.rg_query_Query || rg.query.Query;
rg.svg.util.SymbolCache.cache = new rg.svg.util.SymbolCache();
rg.visualization.Visualizations.layoutDefault = new haxe.ds.StringMap();
rg.visualization.Visualizations.layoutType = new haxe.ds.StringMap();
rg.visualization.Visualizations.layoutArgs = new haxe.ds.StringMap();
rg.visualization.Visualizations.layoutDefault.set("barchart","cartesian");
rg.visualization.Visualizations.layoutDefault.set("funnelchart","simple");
rg.visualization.Visualizations.layoutDefault.set("geo","simple");
rg.visualization.Visualizations.layoutDefault.set("heatgrid","cartesian");
rg.visualization.Visualizations.layoutDefault.set("linechart","cartesian");
rg.visualization.Visualizations.layoutDefault.set("piechart","simple");
rg.visualization.Visualizations.layoutDefault.set("sankey","simple");
rg.visualization.Visualizations.layoutDefault.set("scattergraph","cartesian");
rg.visualization.Visualizations.layoutDefault.set("streamgraph","x");
rg.visualization.Visualizations.layoutType.set("cartesian",rg.layout.LayoutCartesian);
rg.visualization.Visualizations.layoutType.set("simple",rg.layout.LayoutSimple);
rg.visualization.Visualizations.layoutType.set("x",rg.layout.LayoutX);
thx.color.NamedColors.byName = new haxe.ds.StringMap();
thx.color.NamedColors.byName.set("aliceblue",thx.color.NamedColors.aliceblue = thx.color.Rgb.fromInt(15792383));
thx.color.NamedColors.byName.set("alice blue",thx.color.NamedColors.aliceblue);
thx.color.NamedColors.byName.set("antiquewhite",thx.color.NamedColors.antiquewhite = thx.color.Rgb.fromInt(16444375));
thx.color.NamedColors.byName.set("antique white",thx.color.NamedColors.antiquewhite);
thx.color.NamedColors.byName.set("aqua",thx.color.NamedColors.aqua = thx.color.Rgb.fromInt(65535));
thx.color.NamedColors.byName.set("aquamarine",thx.color.NamedColors.aquamarine = thx.color.Rgb.fromInt(8388564));
thx.color.NamedColors.byName.set("azure",thx.color.NamedColors.azure = thx.color.Rgb.fromInt(15794175));
thx.color.NamedColors.byName.set("beige",thx.color.NamedColors.beige = thx.color.Rgb.fromInt(16119260));
thx.color.NamedColors.byName.set("bisque",thx.color.NamedColors.bisque = thx.color.Rgb.fromInt(16770244));
thx.color.NamedColors.byName.set("black",thx.color.NamedColors.black = thx.color.Rgb.fromInt(0));
thx.color.NamedColors.byName.set("blanchedalmond",thx.color.NamedColors.blanchedalmond = thx.color.Rgb.fromInt(16772045));
thx.color.NamedColors.byName.set("blanched almond",thx.color.NamedColors.blanchedalmond);
thx.color.NamedColors.byName.set("blue",thx.color.NamedColors.blue = thx.color.Rgb.fromInt(255));
thx.color.NamedColors.byName.set("blueviolet",thx.color.NamedColors.blueviolet = thx.color.Rgb.fromInt(9055202));
thx.color.NamedColors.byName.set("blue violet",thx.color.NamedColors.blueviolet);
thx.color.NamedColors.byName.set("brown",thx.color.NamedColors.brown = thx.color.Rgb.fromInt(10824234));
thx.color.NamedColors.byName.set("burlywood",thx.color.NamedColors.burlywood = thx.color.Rgb.fromInt(14596231));
thx.color.NamedColors.byName.set("burly wood",thx.color.NamedColors.burlywood);
thx.color.NamedColors.byName.set("cadetblue",thx.color.NamedColors.cadetblue = thx.color.Rgb.fromInt(6266528));
thx.color.NamedColors.byName.set("cadet blue",thx.color.NamedColors.cadetblue);
thx.color.NamedColors.byName.set("chartreuse",thx.color.NamedColors.chartreuse = thx.color.Rgb.fromInt(8388352));
thx.color.NamedColors.byName.set("chart reuse",thx.color.NamedColors.chartreuse);
thx.color.NamedColors.byName.set("chocolate",thx.color.NamedColors.chocolate = thx.color.Rgb.fromInt(13789470));
thx.color.NamedColors.byName.set("coral",thx.color.NamedColors.coral = thx.color.Rgb.fromInt(16744272));
thx.color.NamedColors.byName.set("cornflowerblue",thx.color.NamedColors.cornflowerblue = thx.color.Rgb.fromInt(6591981));
thx.color.NamedColors.byName.set("corn flower blue",thx.color.NamedColors.cornflowerblue);
thx.color.NamedColors.byName.set("cornsilk",thx.color.NamedColors.cornsilk = thx.color.Rgb.fromInt(16775388));
thx.color.NamedColors.byName.set("corn silk",thx.color.NamedColors.cornsilk);
thx.color.NamedColors.byName.set("crimson",thx.color.NamedColors.crimson = thx.color.Rgb.fromInt(14423100));
thx.color.NamedColors.byName.set("cyan",thx.color.NamedColors.cyan = thx.color.Rgb.fromInt(65535));
thx.color.NamedColors.byName.set("darkblue",thx.color.NamedColors.darkblue = thx.color.Rgb.fromInt(139));
thx.color.NamedColors.byName.set("dark blue",thx.color.NamedColors.darkblue);
thx.color.NamedColors.byName.set("darkcyan",thx.color.NamedColors.darkcyan = thx.color.Rgb.fromInt(35723));
thx.color.NamedColors.byName.set("dark cyan",thx.color.NamedColors.darkcyan);
thx.color.NamedColors.byName.set("darkgoldenrod",thx.color.NamedColors.darkgoldenrod = thx.color.Rgb.fromInt(12092939));
thx.color.NamedColors.byName.set("dark golden rod",thx.color.NamedColors.darkgoldenrod);
thx.color.NamedColors.byName.set("darkgray",thx.color.NamedColors.darkgray = thx.color.NamedColors.darkgrey = thx.color.Rgb.fromInt(11119017));
thx.color.NamedColors.byName.set("dark gray",thx.color.NamedColors.darkgray);
thx.color.NamedColors.byName.set("darkgrey",thx.color.NamedColors.darkgrey);
thx.color.NamedColors.byName.set("dark grey",thx.color.NamedColors.darkgrey);
thx.color.NamedColors.byName.set("darkgreen",thx.color.NamedColors.darkgreen = thx.color.Rgb.fromInt(25600));
thx.color.NamedColors.byName.set("dark green",thx.color.NamedColors.darkgreen);
thx.color.NamedColors.byName.set("darkkhaki",thx.color.NamedColors.darkkhaki = thx.color.Rgb.fromInt(12433259));
thx.color.NamedColors.byName.set("dark khaki",thx.color.NamedColors.darkkhaki);
thx.color.NamedColors.byName.set("darkmagenta",thx.color.NamedColors.darkmagenta = thx.color.Rgb.fromInt(9109643));
thx.color.NamedColors.byName.set("dark magenta",thx.color.NamedColors.darkmagenta);
thx.color.NamedColors.byName.set("darkolivegreen",thx.color.NamedColors.darkolivegreen = thx.color.Rgb.fromInt(5597999));
thx.color.NamedColors.byName.set("dark olive green",thx.color.NamedColors.darkolivegreen);
thx.color.NamedColors.byName.set("darkorange",thx.color.NamedColors.darkorange = thx.color.Rgb.fromInt(16747520));
thx.color.NamedColors.byName.set("dark orange",thx.color.NamedColors.darkorange);
thx.color.NamedColors.byName.set("darkorchid",thx.color.NamedColors.darkorchid = thx.color.Rgb.fromInt(10040012));
thx.color.NamedColors.byName.set("dark orchid",thx.color.NamedColors.darkorchid);
thx.color.NamedColors.byName.set("darkred",thx.color.NamedColors.darkred = thx.color.Rgb.fromInt(9109504));
thx.color.NamedColors.byName.set("dark red",thx.color.NamedColors.darkred);
thx.color.NamedColors.byName.set("darksalmon",thx.color.NamedColors.darksalmon = thx.color.Rgb.fromInt(15308410));
thx.color.NamedColors.byName.set("dark salmon",thx.color.NamedColors.darksalmon);
thx.color.NamedColors.byName.set("darkseagreen",thx.color.NamedColors.darkseagreen = thx.color.Rgb.fromInt(9419919));
thx.color.NamedColors.byName.set("dark sea green",thx.color.NamedColors.darkseagreen);
thx.color.NamedColors.byName.set("darkslateblue",thx.color.NamedColors.darkslateblue = thx.color.Rgb.fromInt(4734347));
thx.color.NamedColors.byName.set("dark slate blue",thx.color.NamedColors.darkslateblue);
thx.color.NamedColors.byName.set("darkslategray",thx.color.NamedColors.darkslategray = thx.color.NamedColors.darkslategrey = thx.color.Rgb.fromInt(3100495));
thx.color.NamedColors.byName.set("dark slate gray",thx.color.NamedColors.darkslategray);
thx.color.NamedColors.byName.set("darkslategrey",thx.color.NamedColors.darkslategrey);
thx.color.NamedColors.byName.set("dark slate grey",thx.color.NamedColors.darkslategrey);
thx.color.NamedColors.byName.set("darkturquoise",thx.color.NamedColors.darkturquoise = thx.color.Rgb.fromInt(52945));
thx.color.NamedColors.byName.set("dark turquoise",thx.color.NamedColors.darkturquoise);
thx.color.NamedColors.byName.set("darkviolet",thx.color.NamedColors.darkviolet = thx.color.Rgb.fromInt(9699539));
thx.color.NamedColors.byName.set("dark violet",thx.color.NamedColors.darkviolet);
thx.color.NamedColors.byName.set("deeppink",thx.color.NamedColors.deeppink = thx.color.Rgb.fromInt(16716947));
thx.color.NamedColors.byName.set("deep pink",thx.color.NamedColors.deeppink);
thx.color.NamedColors.byName.set("deepskyblue",thx.color.NamedColors.deepskyblue = thx.color.Rgb.fromInt(49151));
thx.color.NamedColors.byName.set("deep sky blue",thx.color.NamedColors.deepskyblue);
thx.color.NamedColors.byName.set("dimgray",thx.color.NamedColors.dimgray = thx.color.NamedColors.dimgrey = thx.color.Rgb.fromInt(6908265));
thx.color.NamedColors.byName.set("dim grey",thx.color.NamedColors.dimgrey);
thx.color.NamedColors.byName.set("dimgrey",thx.color.NamedColors.dimgrey);
thx.color.NamedColors.byName.set("dim grey",thx.color.NamedColors.dimgrey);
thx.color.NamedColors.byName.set("dodgerblue",thx.color.NamedColors.dodgerblue = thx.color.Rgb.fromInt(2003199));
thx.color.NamedColors.byName.set("dodger blue",thx.color.NamedColors.dodgerblue);
thx.color.NamedColors.byName.set("firebrick",thx.color.NamedColors.firebrick = thx.color.Rgb.fromInt(11674146));
thx.color.NamedColors.byName.set("fire brick",thx.color.NamedColors.firebrick);
thx.color.NamedColors.byName.set("floralwhite",thx.color.NamedColors.floralwhite = thx.color.Rgb.fromInt(16775920));
thx.color.NamedColors.byName.set("floral white",thx.color.NamedColors.floralwhite);
thx.color.NamedColors.byName.set("forestgreen",thx.color.NamedColors.forestgreen = thx.color.Rgb.fromInt(2263842));
thx.color.NamedColors.byName.set("forest green",thx.color.NamedColors.forestgreen);
thx.color.NamedColors.byName.set("fuchsia",thx.color.NamedColors.fuchsia = thx.color.Rgb.fromInt(16711935));
thx.color.NamedColors.byName.set("gainsboro",thx.color.NamedColors.gainsboro = thx.color.Rgb.fromInt(14474460));
thx.color.NamedColors.byName.set("ghostwhite",thx.color.NamedColors.ghostwhite = thx.color.Rgb.fromInt(16316671));
thx.color.NamedColors.byName.set("ghost white",thx.color.NamedColors.ghostwhite);
thx.color.NamedColors.byName.set("gold",thx.color.NamedColors.gold = thx.color.Rgb.fromInt(16766720));
thx.color.NamedColors.byName.set("goldenrod",thx.color.NamedColors.goldenrod = thx.color.Rgb.fromInt(14329120));
thx.color.NamedColors.byName.set("golden rod",thx.color.NamedColors.goldenrod);
thx.color.NamedColors.byName.set("gray",thx.color.NamedColors.gray = thx.color.NamedColors.grey = thx.color.Rgb.fromInt(8421504));
thx.color.NamedColors.byName.set("grey",thx.color.NamedColors.grey);
thx.color.NamedColors.byName.set("green",thx.color.NamedColors.green = thx.color.Rgb.fromInt(32768));
thx.color.NamedColors.byName.set("greenyellow",thx.color.NamedColors.greenyellow = thx.color.Rgb.fromInt(11403055));
thx.color.NamedColors.byName.set("green yellow",thx.color.NamedColors.greenyellow);
thx.color.NamedColors.byName.set("honeydew",thx.color.NamedColors.honeydew = thx.color.Rgb.fromInt(15794160));
thx.color.NamedColors.byName.set("honey dew",thx.color.NamedColors.honeydew);
thx.color.NamedColors.byName.set("hotpink",thx.color.NamedColors.hotpink = thx.color.Rgb.fromInt(16738740));
thx.color.NamedColors.byName.set("hot pink",thx.color.NamedColors.hotpink);
thx.color.NamedColors.byName.set("indianred",thx.color.NamedColors.indianred = thx.color.Rgb.fromInt(13458524));
thx.color.NamedColors.byName.set("indian red",thx.color.NamedColors.indianred);
thx.color.NamedColors.byName.set("indigo",thx.color.NamedColors.indigo = thx.color.Rgb.fromInt(4915330));
thx.color.NamedColors.byName.set("ivory",thx.color.NamedColors.ivory = thx.color.Rgb.fromInt(16777200));
thx.color.NamedColors.byName.set("khaki",thx.color.NamedColors.khaki = thx.color.Rgb.fromInt(15787660));
thx.color.NamedColors.byName.set("lavender",thx.color.NamedColors.lavender = thx.color.Rgb.fromInt(15132410));
thx.color.NamedColors.byName.set("lavenderblush",thx.color.NamedColors.lavenderblush = thx.color.Rgb.fromInt(16773365));
thx.color.NamedColors.byName.set("lavender blush",thx.color.NamedColors.lavenderblush);
thx.color.NamedColors.byName.set("lawngreen",thx.color.NamedColors.lawngreen = thx.color.Rgb.fromInt(8190976));
thx.color.NamedColors.byName.set("lawn green",thx.color.NamedColors.lawngreen);
thx.color.NamedColors.byName.set("lemonchiffon",thx.color.NamedColors.lemonchiffon = thx.color.Rgb.fromInt(16775885));
thx.color.NamedColors.byName.set("lemon chiffon",thx.color.NamedColors.lemonchiffon);
thx.color.NamedColors.byName.set("lightblue",thx.color.NamedColors.lightblue = thx.color.Rgb.fromInt(11393254));
thx.color.NamedColors.byName.set("light blue",thx.color.NamedColors.lightblue);
thx.color.NamedColors.byName.set("lightcoral",thx.color.NamedColors.lightcoral = thx.color.Rgb.fromInt(15761536));
thx.color.NamedColors.byName.set("light coral",thx.color.NamedColors.lightcoral);
thx.color.NamedColors.byName.set("lightcyan",thx.color.NamedColors.lightcyan = thx.color.Rgb.fromInt(14745599));
thx.color.NamedColors.byName.set("light cyan",thx.color.NamedColors.lightcyan);
thx.color.NamedColors.byName.set("lightgoldenrodyellow",thx.color.NamedColors.lightgoldenrodyellow = thx.color.Rgb.fromInt(16448210));
thx.color.NamedColors.byName.set("light golden rod yellow",thx.color.NamedColors.lightgoldenrodyellow);
thx.color.NamedColors.byName.set("lightgray",thx.color.NamedColors.lightgray = thx.color.NamedColors.lightgrey = thx.color.Rgb.fromInt(13882323));
thx.color.NamedColors.byName.set("light gray",thx.color.NamedColors.lightgray);
thx.color.NamedColors.byName.set("lightgrey",thx.color.NamedColors.lightgrey);
thx.color.NamedColors.byName.set("light grey",thx.color.NamedColors.lightgrey);
thx.color.NamedColors.byName.set("lightgreen",thx.color.NamedColors.lightgreen = thx.color.Rgb.fromInt(9498256));
thx.color.NamedColors.byName.set("light green",thx.color.NamedColors.lightgreen);
thx.color.NamedColors.byName.set("lightpink",thx.color.NamedColors.lightpink = thx.color.Rgb.fromInt(16758465));
thx.color.NamedColors.byName.set("light pink",thx.color.NamedColors.lightpink);
thx.color.NamedColors.byName.set("lightsalmon",thx.color.NamedColors.lightsalmon = thx.color.Rgb.fromInt(16752762));
thx.color.NamedColors.byName.set("light salmon",thx.color.NamedColors.lightsalmon);
thx.color.NamedColors.byName.set("lightseagreen",thx.color.NamedColors.lightseagreen = thx.color.Rgb.fromInt(2142890));
thx.color.NamedColors.byName.set("light sea green",thx.color.NamedColors.lightseagreen);
thx.color.NamedColors.byName.set("lightskyblue",thx.color.NamedColors.lightskyblue = thx.color.Rgb.fromInt(8900346));
thx.color.NamedColors.byName.set("light sky blue",thx.color.NamedColors.lightskyblue);
thx.color.NamedColors.byName.set("lightslategray",thx.color.NamedColors.lightslategray = thx.color.NamedColors.lightslategrey = thx.color.Rgb.fromInt(7833753));
thx.color.NamedColors.byName.set("light slate gray",thx.color.NamedColors.lightslategray);
thx.color.NamedColors.byName.set("lightslategrey",thx.color.NamedColors.lightslategrey);
thx.color.NamedColors.byName.set("light slate grey",thx.color.NamedColors.lightslategrey);
thx.color.NamedColors.byName.set("lightsteelblue",thx.color.NamedColors.lightsteelblue = thx.color.Rgb.fromInt(11584734));
thx.color.NamedColors.byName.set("light steel blue",thx.color.NamedColors.lightsteelblue);
thx.color.NamedColors.byName.set("lightyellow",thx.color.NamedColors.lightyellow = thx.color.Rgb.fromInt(16777184));
thx.color.NamedColors.byName.set("light yellow",thx.color.NamedColors.lightyellow);
thx.color.NamedColors.byName.set("lime",thx.color.NamedColors.lime = thx.color.Rgb.fromInt(65280));
thx.color.NamedColors.byName.set("limegreen",thx.color.NamedColors.limegreen = thx.color.Rgb.fromInt(3329330));
thx.color.NamedColors.byName.set("lime green",thx.color.NamedColors.limegreen);
thx.color.NamedColors.byName.set("linen",thx.color.NamedColors.linen = thx.color.Rgb.fromInt(16445670));
thx.color.NamedColors.byName.set("magenta",thx.color.NamedColors.magenta = thx.color.Rgb.fromInt(16711935));
thx.color.NamedColors.byName.set("maroon",thx.color.NamedColors.maroon = thx.color.Rgb.fromInt(8388608));
thx.color.NamedColors.byName.set("mediumaquamarine",thx.color.NamedColors.mediumaquamarine = thx.color.Rgb.fromInt(6737322));
thx.color.NamedColors.byName.set("mediuma quamarine",thx.color.NamedColors.mediumaquamarine);
thx.color.NamedColors.byName.set("mediumblue",thx.color.NamedColors.mediumblue = thx.color.Rgb.fromInt(205));
thx.color.NamedColors.byName.set("medium blue",thx.color.NamedColors.mediumblue);
thx.color.NamedColors.byName.set("mediumorchid",thx.color.NamedColors.mediumorchid = thx.color.Rgb.fromInt(12211667));
thx.color.NamedColors.byName.set("medium orchid",thx.color.NamedColors.mediumorchid);
thx.color.NamedColors.byName.set("mediumpurple",thx.color.NamedColors.mediumpurple = thx.color.Rgb.fromInt(9662683));
thx.color.NamedColors.byName.set("medium purple",thx.color.NamedColors.mediumpurple);
thx.color.NamedColors.byName.set("mediumseagreen",thx.color.NamedColors.mediumseagreen = thx.color.Rgb.fromInt(3978097));
thx.color.NamedColors.byName.set("medium sea green",thx.color.NamedColors.mediumseagreen);
thx.color.NamedColors.byName.set("mediumslateblue",thx.color.NamedColors.mediumslateblue = thx.color.Rgb.fromInt(8087790));
thx.color.NamedColors.byName.set("medium slate blue",thx.color.NamedColors.mediumslateblue);
thx.color.NamedColors.byName.set("mediumspringgreen",thx.color.NamedColors.mediumspringgreen = thx.color.Rgb.fromInt(64154));
thx.color.NamedColors.byName.set("medium spring green",thx.color.NamedColors.mediumspringgreen);
thx.color.NamedColors.byName.set("mediumturquoise",thx.color.NamedColors.mediumturquoise = thx.color.Rgb.fromInt(4772300));
thx.color.NamedColors.byName.set("medium turquoise",thx.color.NamedColors.mediumturquoise);
thx.color.NamedColors.byName.set("mediumvioletred",thx.color.NamedColors.mediumvioletred = thx.color.Rgb.fromInt(13047173));
thx.color.NamedColors.byName.set("medium violet red",thx.color.NamedColors.mediumvioletred);
thx.color.NamedColors.byName.set("midnightblue",thx.color.NamedColors.midnightblue = thx.color.Rgb.fromInt(1644912));
thx.color.NamedColors.byName.set("midnight blue",thx.color.NamedColors.midnightblue);
thx.color.NamedColors.byName.set("mintcream",thx.color.NamedColors.mintcream = thx.color.Rgb.fromInt(16121850));
thx.color.NamedColors.byName.set("mint cream",thx.color.NamedColors.mintcream);
thx.color.NamedColors.byName.set("mistyrose",thx.color.NamedColors.mistyrose = thx.color.Rgb.fromInt(16770273));
thx.color.NamedColors.byName.set("misty rose",thx.color.NamedColors.mistyrose);
thx.color.NamedColors.byName.set("moccasin",thx.color.NamedColors.moccasin = thx.color.Rgb.fromInt(16770229));
thx.color.NamedColors.byName.set("navajowhite",thx.color.NamedColors.navajowhite = thx.color.Rgb.fromInt(16768685));
thx.color.NamedColors.byName.set("navajo white",thx.color.NamedColors.navajowhite);
thx.color.NamedColors.byName.set("navy",thx.color.NamedColors.navy = thx.color.Rgb.fromInt(128));
thx.color.NamedColors.byName.set("oldlace",thx.color.NamedColors.oldlace = thx.color.Rgb.fromInt(16643558));
thx.color.NamedColors.byName.set("old lace",thx.color.NamedColors.oldlace);
thx.color.NamedColors.byName.set("olive",thx.color.NamedColors.olive = thx.color.Rgb.fromInt(8421376));
thx.color.NamedColors.byName.set("olivedrab",thx.color.NamedColors.olivedrab = thx.color.Rgb.fromInt(7048739));
thx.color.NamedColors.byName.set("olive drab",thx.color.NamedColors.olivedrab);
thx.color.NamedColors.byName.set("orange",thx.color.NamedColors.orange = thx.color.Rgb.fromInt(16753920));
thx.color.NamedColors.byName.set("orangered",thx.color.NamedColors.orangered = thx.color.Rgb.fromInt(16729344));
thx.color.NamedColors.byName.set("orangered",thx.color.NamedColors.orangered);
thx.color.NamedColors.byName.set("orchid",thx.color.NamedColors.orchid = thx.color.Rgb.fromInt(14315734));
thx.color.NamedColors.byName.set("palegoldenrod",thx.color.NamedColors.palegoldenrod = thx.color.Rgb.fromInt(15657130));
thx.color.NamedColors.byName.set("pale golden rod",thx.color.NamedColors.palegoldenrod);
thx.color.NamedColors.byName.set("palegreen",thx.color.NamedColors.palegreen = thx.color.Rgb.fromInt(10025880));
thx.color.NamedColors.byName.set("pale green",thx.color.NamedColors.palegreen);
thx.color.NamedColors.byName.set("paleturquoise",thx.color.NamedColors.paleturquoise = thx.color.Rgb.fromInt(11529966));
thx.color.NamedColors.byName.set("pale turquoise",thx.color.NamedColors.paleturquoise);
thx.color.NamedColors.byName.set("palevioletred",thx.color.NamedColors.palevioletred = thx.color.Rgb.fromInt(14381203));
thx.color.NamedColors.byName.set("pale violet red",thx.color.NamedColors.palevioletred);
thx.color.NamedColors.byName.set("papayawhip",thx.color.NamedColors.papayawhip = thx.color.Rgb.fromInt(16773077));
thx.color.NamedColors.byName.set("papaya whip",thx.color.NamedColors.papayawhip);
thx.color.NamedColors.byName.set("peachpuff",thx.color.NamedColors.peachpuff = thx.color.Rgb.fromInt(16767673));
thx.color.NamedColors.byName.set("peach puff",thx.color.NamedColors.peachpuff);
thx.color.NamedColors.byName.set("peru",thx.color.NamedColors.peru = thx.color.Rgb.fromInt(13468991));
thx.color.NamedColors.byName.set("pink",thx.color.NamedColors.pink = thx.color.Rgb.fromInt(16761035));
thx.color.NamedColors.byName.set("plum",thx.color.NamedColors.plum = thx.color.Rgb.fromInt(14524637));
thx.color.NamedColors.byName.set("powderblue",thx.color.NamedColors.powderblue = thx.color.Rgb.fromInt(11591910));
thx.color.NamedColors.byName.set("powder blue",thx.color.NamedColors.powderblue);
thx.color.NamedColors.byName.set("purple",thx.color.NamedColors.purple = thx.color.Rgb.fromInt(8388736));
thx.color.NamedColors.byName.set("red",thx.color.NamedColors.red = thx.color.Rgb.fromInt(16711680));
thx.color.NamedColors.byName.set("rosybrown",thx.color.NamedColors.rosybrown = thx.color.Rgb.fromInt(12357519));
thx.color.NamedColors.byName.set("rosy brown",thx.color.NamedColors.rosybrown);
thx.color.NamedColors.byName.set("royalblue",thx.color.NamedColors.royalblue = thx.color.Rgb.fromInt(4286945));
thx.color.NamedColors.byName.set("royal blue",thx.color.NamedColors.royalblue);
thx.color.NamedColors.byName.set("saddlebrown",thx.color.NamedColors.saddlebrown = thx.color.Rgb.fromInt(9127187));
thx.color.NamedColors.byName.set("saddle brown",thx.color.NamedColors.saddlebrown);
thx.color.NamedColors.byName.set("salmon",thx.color.NamedColors.salmon = thx.color.Rgb.fromInt(16416882));
thx.color.NamedColors.byName.set("sandybrown",thx.color.NamedColors.sandybrown = thx.color.Rgb.fromInt(16032864));
thx.color.NamedColors.byName.set("sandy brown",thx.color.NamedColors.sandybrown);
thx.color.NamedColors.byName.set("seagreen",thx.color.NamedColors.seagreen = thx.color.Rgb.fromInt(3050327));
thx.color.NamedColors.byName.set("sea green",thx.color.NamedColors.seagreen);
thx.color.NamedColors.byName.set("seashell",thx.color.NamedColors.seashell = thx.color.Rgb.fromInt(16774638));
thx.color.NamedColors.byName.set("sea shell",thx.color.NamedColors.seashell);
thx.color.NamedColors.byName.set("sienna",thx.color.NamedColors.sienna = thx.color.Rgb.fromInt(10506797));
thx.color.NamedColors.byName.set("silver",thx.color.NamedColors.silver = thx.color.Rgb.fromInt(12632256));
thx.color.NamedColors.byName.set("skyblue",thx.color.NamedColors.skyblue = thx.color.Rgb.fromInt(8900331));
thx.color.NamedColors.byName.set("sky blue",thx.color.NamedColors.skyblue);
thx.color.NamedColors.byName.set("slateblue",thx.color.NamedColors.slateblue = thx.color.Rgb.fromInt(6970061));
thx.color.NamedColors.byName.set("slate blue",thx.color.NamedColors.slateblue);
thx.color.NamedColors.byName.set("slategray",thx.color.NamedColors.slategray = thx.color.NamedColors.slategrey = thx.color.Rgb.fromInt(7372944));
thx.color.NamedColors.byName.set("slate gray",thx.color.NamedColors.slategray);
thx.color.NamedColors.byName.set("slategrey",thx.color.NamedColors.slategrey);
thx.color.NamedColors.byName.set("slate grey",thx.color.NamedColors.slategrey);
thx.color.NamedColors.byName.set("snow",thx.color.NamedColors.snow = thx.color.Rgb.fromInt(16775930));
thx.color.NamedColors.byName.set("springgreen",thx.color.NamedColors.springgreen = thx.color.Rgb.fromInt(65407));
thx.color.NamedColors.byName.set("spring green",thx.color.NamedColors.springgreen);
thx.color.NamedColors.byName.set("steelblue",thx.color.NamedColors.steelblue = thx.color.Rgb.fromInt(4620980));
thx.color.NamedColors.byName.set("steel blue",thx.color.NamedColors.steelblue);
thx.color.NamedColors.byName.set("tan",thx.color.NamedColors.tan = thx.color.Rgb.fromInt(13808780));
thx.color.NamedColors.byName.set("teal",thx.color.NamedColors.teal = thx.color.Rgb.fromInt(32896));
thx.color.NamedColors.byName.set("thistle",thx.color.NamedColors.thistle = thx.color.Rgb.fromInt(14204888));
thx.color.NamedColors.byName.set("tomato",thx.color.NamedColors.tomato = thx.color.Rgb.fromInt(16737095));
thx.color.NamedColors.byName.set("turquoise",thx.color.NamedColors.turquoise = thx.color.Rgb.fromInt(4251856));
thx.color.NamedColors.byName.set("violet",thx.color.NamedColors.violet = thx.color.Rgb.fromInt(15631086));
thx.color.NamedColors.byName.set("wheat",thx.color.NamedColors.wheat = thx.color.Rgb.fromInt(16113331));
thx.color.NamedColors.byName.set("white",thx.color.NamedColors.white = thx.color.Rgb.fromInt(16777215));
thx.color.NamedColors.byName.set("whitesmoke",thx.color.NamedColors.whitesmoke = thx.color.Rgb.fromInt(16119285));
thx.color.NamedColors.byName.set("white smoke",thx.color.NamedColors.whitesmoke);
thx.color.NamedColors.byName.set("yellow",thx.color.NamedColors.yellow = thx.color.Rgb.fromInt(16776960));
thx.color.NamedColors.byName.set("yellowgreen",thx.color.NamedColors.yellowgreen = thx.color.Rgb.fromInt(10145074));
thx.color.NamedColors.byName.set("yellow green",thx.color.NamedColors.yellowgreen);
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
Strings._reFormat = new EReg("{(\\d+)(?::([a-zA-Z]+))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?}","m");
Strings._reCollapse = new EReg("\\s+","g");
Strings.__ucwordsPattern = new EReg("[^a-zA-Z]([a-z])","g");
Strings._reInterpolateNumber = new EReg("[-+]?(?:\\d+\\.\\d+|\\d+\\.|\\.\\d+|\\d+)(?:[eE][-]?\\d+)?","");
dhx.AccessAttribute.refloat = new EReg("(\\d+(?:\\.\\d+)?)","");
dhx.AccessClassed._escapePattern = new EReg("[*+?|{[()^$.# \\\\]","");
dhx.AccessStyle.refloat = new EReg("(\\d+(?:\\.\\d+)?)","");
js.Browser.window = typeof window != "undefined" ? window : null;
js.Browser.document = typeof window != "undefined" ? window.document : null;
dhx.Dom.doc = (function() {
	var g = new dhx.Group([js.Browser.document]), gs = dhx.Selection.create([g]);
	g.parentNode = gs.parentNode = js.Browser.document.documentElement;
	return gs;
})();
dhx.Dom.selectionEngine = (function($this) {
	var $r;
	var engine;
	if(dhx.NativeSelectorEngine.supported()) engine = new dhx.NativeSelectorEngine(); else if(dhx.SizzleEngine.supported()) engine = new dhx.SizzleEngine(); else throw "no selector engine available";
	$r = engine;
	return $r;
}(this));
dhx.Namespace.prefix = (function() {
	var h = new haxe.ds.StringMap();
	h.set("svg","http://www.w3.org/2000/svg");
	h.set("xhtml","http://www.w3.org/1999/xhtml");
	h.set("xlink","http://www.w3.org/1999/xlink");
	h.set("xml","http://www.w3.org/XML/1998/namespace");
	h.set("xmlns","http://www.w3.org/2000/xmlns/");
	return h;
})();
dhx.Svg._usepage = new EReg("WebKit","").match(js.Browser.window.navigator.userAgent);
dhx.Timer.timeout = 0;
dhx.Timer.interval = 0;
dhx.Timer._step = dhx.Timer.step;
dhx.BaseTransition._id = 0;
dhx.BaseTransition._inheritid = 0;
erazor.Parser.at = "@";
erazor.Parser.bracketMismatch = "Bracket mismatch! Inside template, non-paired brackets, '{' or '}', should be replaced by @{'{'} and @{'}'}.";
rg.RGConst.BASE_URL_GEOJSON = "https://api.reportgrid.com/geo/json/";
rg.RGConst.SERVICE_RENDERING_STATIC = "https://api.reportgrid.com/services/viz/charts/up.json";
rg.RGConst.LEGACY_RENDERING_STATIC = "https://api.reportgrid.com/services/viz/charts/upandsee.{ext}";
rg.app.charts.App.lastid = 0;
rg.app.charts.App.chartsCounter = 0;
rg.app.charts.App.chartsLoaded = 0;
rg.axis.AxisTime.snapping = { minute : [{ to : 10, s : 1},{ to : 20, s : 2},{ to : 30, s : 5},{ to : 60, s : 10},{ to : 120, s : 30},{ to : 240, s : 60},{ to : 960, s : 240}], minutetop : 480, hour : [{ to : 12, s : 1},{ to : 24, s : 6},{ to : 60, s : 12},{ to : 240, s : 24},{ to : 480, s : 48},{ to : 960, s : 120}], hourtop : 240, month : [{ to : 13, s : 1},{ to : 25, s : 2},{ to : 49, s : 4},{ to : 73, s : 6}], monthtop : 12, year : [{ to : 10, s : 1},{ to : 20, s : 2},{ to : 50, s : 5}], yeartop : 10};
rg.html.chart.PivotTable.defaultColorStart = new thx.color.Hsl(210,1,1);
rg.html.chart.PivotTable.defaultColorEnd = new thx.color.Hsl(210,1,0.5);
rg.html.widget.DownloaderMenu.DEFAULT_FORMATS = ["png","jpg","pdf"];
rg.html.widget.DownloaderMenu.DEFAULT_TITLE = "Download";
rg.info.Info.warner = window.console && window.console.warn?function(m) {
	console.warn("" + Std.string(m));
}:function(m) {
};
rg.info.InfoPivotTable.defaultStartColor = new thx.color.Hsl(210,1,1);
rg.info.InfoPivotTable.defaultEndColor = new thx.color.Hsl(210,1,0.5);
rg.info.filter.TransformerArray.instance = new rg.info.filter.TransformerArray();
rg.info.filter.TransformerObject.instance = new rg.info.filter.TransformerObject();
rg.info.filter.TransformerString.instance = new rg.info.filter.TransformerString();
rg.info.filter.TransformerBool.instance = new rg.info.filter.TransformerBool();
rg.info.filter.TransformerInt.instance = new rg.info.filter.TransformerInt();
rg.info.filter.TransformerFloat.instance = new rg.info.filter.TransformerFloat();
rg.info.filter.TransformerFunction.instance = new rg.info.filter.TransformerFunction();
rg.info.filter.TransformerExpressionToFunction.interp = new hscript.Interp();
rg.info.filter.TransformerExpressionToFunction.pattern = new EReg("^\\s*=","");
rg.interactive.RGDownloader.ALLOWED_FORMATS = ["pdf","ps","png","jpg","svg"];
rg.interactive.RGLegacyRenderer.FORMAT = "jpg";
rg.interactive.RGLegacyRenderer.nextframeid = 0;
rg.layout.LayoutCartesian.ALT_RIGHT = 20;
rg.layout.LayoutCartesian.ALT_LEFT = 20;
rg.layout.LayoutCartesian.ALT_TOP = 8;
rg.layout.LayoutCartesian.ALT_BOTTOM = 8;
rg.layout.LayoutCartesian.REYAXIS = new EReg("^y(\\d+)$","");
rg.layout.LayoutCartesian.REYINDEX = new EReg("^y(\\d+)","");
rg.layout.LayoutCartesian.REYTITLE = new EReg("^y(\\d+)title$","");
rg.layout.LayoutX.ALT_RIGHT = 20;
rg.layout.LayoutX.ALT_LEFT = 20;
rg.layout.LayoutX.ALT_TOP = 8;
rg.layout.LayoutX.ALT_BOTTOM = 8;
rg.svg.chart.Coords.retransform = new EReg("translate\\(\\s*(\\d+(?:\\.\\d+)?)\\s*(?:[, ]\\s*(\\d+(?:\\.\\d+)?)\\s*)?\\)","");
rg.svg.chart.StreamGraph.vid = 0;
rg.svg.util.SVGSymbolBuilder.SIZE_PATTERN = new EReg("^(\\d+)x(\\d+)$","");
rg.svg.util.SVGSymbolBuilder.ALIGN_PATTERN = new EReg("^(center|left|right)\\s+(center|top|bottom)$","i");
rg.svg.util.SVGSymbolBuilder.HORIZONTAL_PATTERN = new EReg("^(center|left|right)$","i");
rg.svg.util.SVGSymbolBuilder.VERTICAL_PATTERN = new EReg("^(top|bottom)$","i");
rg.util.Periodicity.validGroupValues = ["hour","day","week","month","year"];
rg.util.RGStrings.range = new EReg("(\\d+(?:\\.\\d+)?|\\.\\d+)?-(\\d+(?:\\.\\d+|\\.\\d+)?)?","");
rg.visualization.Visualizations.html = ["pivottable","leaderboard"];
rg.visualization.Visualizations.svg = ["barchart","geo","funnelchart","heatgrid","linechart","piechart","scattergraph","streamgraph","sankey"];
rg.visualization.Visualizations.visualizations = rg.visualization.Visualizations.svg.concat(rg.visualization.Visualizations.html);
rg.visualization.Visualizations.layouts = ["simple","cartesian","x"];
thx.color.Colors._reParse = new EReg("^(?:(hsl|rgb|rgba|cmyk)\\(([^)]+)\\))|(?:(?:0x|#)([a-f0-9]{3,6}))$","i");
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
thx.svg.LineInternals.arcOffset = -Math.PI / 2;
thx.svg.LineInternals.arcMax = 2 * Math.PI - 1e-6;
thx.svg.LineInternals._lineBasisBezier1 = [0,2 / 3,1 / 3,0];
thx.svg.LineInternals._lineBasisBezier2 = [0,1 / 3,2 / 3,0];
thx.svg.LineInternals._lineBasisBezier3 = [0,1 / 6,2 / 3,1 / 6];
thx.svg.Symbol.sqrt3 = Math.sqrt(3);
thx.svg.Symbol.tan30 = Math.tan(30 * Math.PI / 180);
thx.text.ERegs._escapePattern = new EReg("[\\*\\+\\?\\|\\{\\[\\(\\)\\^\\$\\.# \\\\]","g");
rg.app.charts.JSBridge.main();
})();
