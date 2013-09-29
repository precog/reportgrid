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
/**
 * ...
 * @author Franco Ponticelli
 */

package rg.info.filter;

import thx.validation.IValidator;
import thx.util.Message;
using rg.info.filter.FilterDescription;
using Arrays;

class FilterDescription {
	public var name(default, null) : String;
	public var transformer(default, null) : ITransformer<Dynamic, Pairs>;

	public function new(name : String, ?transformer : ITransformer<Dynamic, Pairs>)
	{
		this.name  = name;
		this.transformer = null == transformer ? new EmptyTransformer(name) : transformer;
	}

	public static function toBool(name : String, ?maps : Array<String>)
	{
		return pair(name, maps, TransformerBool.instance);
	}

	public static function toInt(name : String, ?maps : Array<String>)
	{
		return pair(name, maps, TransformerInt.instance);
	}

	public static function toFloat(name : String, ?maps : Array<String>)
	{
		return pair(name, maps, TransformerFloat.instance);
	}

	public static function toStr(name : String, ?maps : Array<String>)
	{
		return pair(name, maps, TransformerString.instance);
	}

	public static function toStrOrNull(name : String, ?maps : Array<String>)
	{
		return custom(name, maps, function(value : Dynamic) {
			if(null == value)
				return TransformResult.Success(null);
			else
				return TransformerString.instance.transform(value);
		});
	}

	public static function toArray(name : String, ?maps : Array<String>)
	{
		return custom(name, maps, function(v : Dynamic) {
			return Std.is(v, Array) ? TransformResult.Success(v) : TransformResult.Failure(new Message("expected array but was '{0}'", v));
		});
	}

	public static function toObject(name : String, ?maps : Array<String>)
	{
		return pair(name, maps, TransformerObject.instance);
	}

	public static function toFunction(name : String, ?maps : Array<String>)
	{
		return pair(name, maps, TransformerFunction.instance);
	}

	public static function toTemplateFunction(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return pair(name, maps, new TransformerTemplateToFunction(args));
	}

	public static function toExpressionFunction(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return pair(name, maps, new TransformerExpressionToFunction(args));
	}

	public static function toInfo<T>(name : String, ?maps : Array<String>, cls : Class<T>, ?fun : T -> Void)
	{
		return simplified(name, maps, function(value) {
				var inst = Type.createInstance(cls, []);
				if(null != fun)
					fun(inst);
				return rg.info.Info.feed(inst, value);
			},
			ReturnMessageIfNot.isObject
		);
	}

	public static function toInfoArray(name : String, ?maps : Array<String>, cls : Class<Dynamic>)
	{
		return custom(name, maps, function(value : Dynamic) {
			var arr;
			if(Std.is(value, Array)) {
				arr =  value;
			} else if(Types.isAnonymous(value)) {
				arr = [value];
			} else {
				return TransformResult.Failure(new Message("value must be either an array of objects or an object but is {0}", [value]));
			}

			return TransformResult.Success(Arrays.map(arr, function(v : Dynamic, _) {
				var inst = Type.createInstance(cls, []);
				return Info.feed(inst, v);
			}));
		});
	}

	public static function toTry(name : String, ?maps : Array<String>, conversion : Dynamic -> Dynamic, errorMessage : String)
	{
		return custom(name, maps, function(value : Dynamic) {
			try {
				return TransformResult.Success(conversion(value));
			} catch(e : Dynamic) {
				return TransformResult.Failure(new Message(errorMessage, [value]));
			}
		});
	}

	public static function toDataFunctionFromArray(name : String, ?maps : Array<String>)
	{
		return custom(name, maps,
			TransformerArray.instance.transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(function(handler) { return handler(value); });
				},
				function(vin : Dynamic, msg : Message) {
					return TransformResult.Failure(new Message("parameter must be an array of values"));
				}
			)
		);
	}

	public static function toLoaderFunction(name : String, ?maps : Array<String>)
	{
		return custom(name, maps,
			TransformerFunction.instance.transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					var field = Reflect.field(vin, "execute");
					if(null != field && Reflect.isFunction(field)) {
						return TransformResult.Success(function(handler) {
							Reflect.callMethod(vin, field, [handler]);
						});
					} else {
						return TransformResult.Failure(new Message("parameter must be an array of values"));
					}
				}
			)
		);
	}

	public static function toFunctionOrBool(name : String, ?maps : Array<String>)
	{
		return custom(name, maps,
			TransformerFunction.instance.transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerBool.instance.transform.onResult(
						function(b : Bool, _)
							return TransformResult.Success(function() { return b; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a boolean value or a function returning a boolean value"))
					)(vin);
				}
			)
		);
	}

	public static function toExpressionFunctionOrBool(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return custom(name, maps,
			new TransformerExpressionToFunction(args).transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerBool.instance.transform.onResult(
						function(b : Bool, _)
							return TransformResult.Success(function() { return b; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a boolean value or a function returning a boolean value"))
					)(vin);
				}
			)
		);
	}

	public static function toFunctionOrFloat(name : String, ?maps : Array<String>)
	{
		return custom(name, maps,
			TransformerFunction.instance.transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerFloat.instance.transform.onResult(
						function(b : Float, _)
							return TransformResult.Success(function() { return b; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a float value or a function returning a float value"))
					)(vin);
				}
			)
		);
	}

	public static function toExpressionFunctionOrFloat(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return custom(name, maps,
			new TransformerExpressionToFunction(args).transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerFloat.instance.transform.onResult(
						function(b : Float, _)
							return TransformResult.Success(function() { return b; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a float value or a function returning a float value"))
					)(vin);
				}
			)
		);
	}

	public static function toFunctionOrNull(name : String, ?maps : Array<String>)
	{
		return custom(name, maps,
			TransformerFunction.instance.transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					if(null == vin)
						return TransformResult.Success(null);
					else
						return TransformResult.Failure(new Message("parameter should be a function or null"));
				}
			)
		);
	}

	public static function toExpressionFunctionOrNull(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return custom(name, maps,
			new TransformerExpressionToFunction(args).transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					if(null == vin)
						return TransformResult.Success(null);
					else
						return TransformResult.Failure(new Message("parameter should be a function or null"));
				}
			)
		);
	}

	public static function toTemplateFunctionOrNull(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return custom(name, maps,
			new TransformerTemplateToFunction(args).transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					if(null == vin)
						return TransformResult.Success(null);
					else
						return TransformResult.Failure(new Message("parameter should be a function or null"));
				}
			)
		);
	}

	public static function toFunctionOrString(name : String, ?maps : Array<String>)
	{
		return custom(name, maps,
			TransformerFunction.instance.transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerString.instance.transform.onResult(
						function(s : String, _)
							return TransformResult.Success(function() { return s; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a string value or a function returning a string value"))
					)(vin);
				}
			)
		);
	}

	public static function toExpressionFunctionOrString(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return custom(name, maps,
			new TransformerExpressionToFunction(args).transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerString.instance.transform.onResult(
						function(s : String, _)
							return TransformResult.Success(function() { return s; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a string value or a function returning a string value"))
					)(vin);
				}
			)
		);
	}

	public static function toTemplateFunctionOrString(name : String, args : Array<String>, ?maps : Array<String>)
	{
		return custom(name, maps,
			new TransformerTemplateToFunction(args).transform.onResult(
				function(value : Dynamic, vin : Dynamic) {
					return TransformResult.Success(value);
				},
				function(vin : Dynamic, msg : Message) {
					return TransformerString.instance.transform.onResult(
						function(s : String, _)
							return TransformResult.Success(function() { return s; }),
						function(vin : Dynamic, msg : Message)
							return TransformResult.Failure(new Message("parameter should be a string value or a function returning a string value"))
					)(vin);
				}
			)
		);
	}

	public static function custom<T>(name : String, ?maps : Array<String>, transformer : Dynamic -> TransformResult<Dynamic>)
	{
		return pair(name, maps, new CustomTransformer(transformer));
	}

	public static function simplified<T>(name : String, ?maps : Array<String>, filter : T -> Dynamic, ?validator : Dynamic -> Null<String>)
	{
		return pair(name, maps, CustomTransformer.simplified(filter, validator));
	}

	static function pair(name : String, ?maps : Array<String>, transformer : ITransformer<Dynamic, Dynamic>)
	{
		if(null == maps)
			maps = [name];
		return new FilterDescription(name, new PairTransformer(maps, transformer));
	}
}

class CustomTransformer implements ITransformer<Dynamic, Dynamic>
{
	var transformer : Dynamic -> TransformResult<Dynamic>;
	public function new(transformer : Dynamic -> TransformResult<Dynamic>)
	{
		this.transformer = transformer;
	}

	public function transform(value : Dynamic)
	{
		return transformer(value);
	}

	public static function simplified(filter : Dynamic -> Dynamic, ?validate : Dynamic -> Null<String>)
	{
		return new CustomTransformer(function(value) {
			var err = validate(value);
			if(null == err)
				return TransformResult.Success(filter(value));
			else
				return TransformResult.Failure(new Message(err, [value]));
		});
	}
}

class TransformerChainer
{
	public static function onResult<TIn, TOut, TResult>(src : TIn -> TransformResult<TOut>, success : TOut -> TIn -> TransformResult<TResult>, failure : TIn -> Message -> TransformResult<TResult>) : TIn -> TransformResult<TResult>
	{
		return function(value : TIn) : TransformResult<TResult>
		{
			switch (src(value)) {
				case Success(out):
					return success(out, value);
				case Failure(msg):
					return failure(value, msg);
			}
		}
	}
}

class TransformerArray implements ITransformer<Dynamic, Array<Dynamic>>
{
	public static var instance(default, null) : TransformerArray = new TransformerArray();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<Array<Dynamic>>
	{
		if(Std.is(value, Array)) {
			return TransformResult.Success(value);
		} else {
			return TransformResult.Failure(new Message("value {0} is not an array", [value]));
		}
	}
}

class TransformerObject implements ITransformer<Dynamic, Dynamic>
{
	public static var instance(default, null) : TransformerObject = new TransformerObject();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<Dynamic>
	{
		if(Types.isAnonymous(value)) {
			return TransformResult.Success(value);
		} else {
			return TransformResult.Failure(new Message("value {0} is not an object", [value]));
		}
	}
}

class TransformerString implements ITransformer<Dynamic, String>
{
	public static var instance(default, null) : TransformerString = new TransformerString();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<String>
	{
		switch(Type.typeof(value)) {
			case TBool:
				return TransformResult.Success(value ? "true" : "false");
			case TInt, TFloat:
				return TransformResult.Success("" + value);
			case TClass(_):
				return TransformResult.Success(Std.string(value));
			default:
				return TransformResult.Failure(new Message("unable to tranform {0} into a string value", [value]));
		}
	}
}

class TransformerBool implements ITransformer<Dynamic, Bool>
{
	public static var instance(default, null) : TransformerBool = new TransformerBool();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<Bool>
	{
		switch(Type.typeof(value)) {
			case TBool:
				return TransformResult.Success(value);
			case TInt, TFloat:
				return TransformResult.Success(value != 0);
			case TClass(cls):
				if("String" == Type.getClassName(cls))
				{
					if(Bools.canParse(value))
						return TransformResult.Success(Bools.parse(value));
					else
						return TransformResult.Failure(new Message("unable to tranform the string '{0}'' into a boolean value", [value]));
				} else {
					return TransformResult.Failure(new Message("unable to tranform the instance of {0} into a boolean value", [value]));
				}
			default:
				return TransformResult.Failure(new Message("unable to tranform {0} into a boolean value", [value]));
		}
	}
}

class TransformerInt implements ITransformer<Dynamic, Int>
{
	public static var instance(default, null) : TransformerInt = new TransformerInt();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<Int>
	{
		switch(Type.typeof(value)) {
			case TBool:
				return TransformResult.Success(value ? 1 : 0);
			case TInt:
				return TransformResult.Success(value);
			case TFloat:
				return TransformResult.Success(Std.int(value));
			default:
				if(Std.is(value, String) && Ints.canParse(value))
					return TransformResult.Success(Ints.parse(value));
				else
					return TransformResult.Failure(new Message("unable to tranform {0} into an integer value", [value]));
		}
	}
}

class TransformerFloat implements ITransformer<Dynamic, Float>
{
	public static var instance(default, null) : TransformerFloat = new TransformerFloat();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<Float>
	{
		switch(Type.typeof(value)) {
			case TBool:
				return TransformResult.Success(value ? 1.0 : 0.0);
			case TInt, TFloat:
				return TransformResult.Success(value);
			default:
				if(Std.is(value, String) && Floats.canParse(value))
					return TransformResult.Success(Floats.parse(value));
				else
					return TransformResult.Failure(new Message("unable to tranform {0} into a float value", [value]));
		}
	}
}

class TransformerFunction implements ITransformer<Dynamic, Void -> Void>
{
	public static var instance(default, null) : TransformerFunction = new TransformerFunction();
	public function new() {}
	public function transform(value : Dynamic) : TransformResult<Void -> Void>
	{
		if(Reflect.isFunction(value))
		{
			return TransformResult.Success(value);
		} else {
			return TransformResult.Failure(new Message("not a function"));
		}
	}
}

class TransformerTemplateToFunction implements ITransformer<Dynamic, Void -> String>
{
	var argumentsMap : Array<String>;
	public function new(argumentsMap : Array<String>)
	{
		this.argumentsMap = argumentsMap;
	}

	public function transform(value : Dynamic) : TransformResult<Void -> String>
	{
		if(Std.is(value, String)) {
			var template = new erazor.Template(cast value);
			return TransformResult.Success(function() {
				return template.execute(TransformerExpressionToFunction.extractValues(argumentsMap, untyped __js__("arguments")));
			});
		} else if(Reflect.isFunction(value)) {
			return TransformResult.Success(value);
		} else {
			return TransformResult.Failure(new Message("not a function"));
		}
	}
}

class TransformerExpressionToFunction implements ITransformer<Dynamic, Void -> String>
{
	var argumentsMap : Array<String>;
	static var interp = new hscript.Interp();
	static var pattern = ~/^\s*=/;
	public function new(argumentsMap : Array<String>)
	{
		this.argumentsMap = argumentsMap;
	}

	public static function extractValues(map : Array<String>, args : Array<Dynamic>)
	{
		var i = map.length,
			values = new Map<String, Dynamic>();
		values.set("ReportGrid", untyped __js__("ReportGrid"));

		values.set("format",   untyped __js__("ReportGrid.format"));
		values.set("symbol",   untyped __js__("ReportGrid.symbol"));
		values.set("humanize", untyped __js__("ReportGrid.humanize"));
		values.set("compare",  untyped __js__("ReportGrid.compare"));

		values.set("Math", Math);
		values.set("null", null);
		values.set("true", true);
		values.set("false", false);

		while(--i >= 0) {
			var key = map[i];
			if(null == key) {
				for(key in Reflect.fields(args[i])) {
					values.set(key, Reflect.field(args[i], key));
				}
			} else {
				values.set(key, args[i]);
			}
		}
		return values;
	}

	public function transform(value : Dynamic) : TransformResult<Void -> String>
	{
		if(Std.is(value, String) && pattern.match(value)) {
			value = value.substr(value.indexOf("=")+1);
			var program = new hscript.Parser().parseString(cast value);
			return TransformResult.Success(function() {
				interp.variables = extractValues(argumentsMap, untyped __js__("arguments"));
				return interp.execute(program);
			});
		} else if(Reflect.isFunction(value)) {
			return TransformResult.Success(value);
		} else {
			return TransformResult.Failure(new Message("not a function"));
		}
	}
}

class ReturnMessageIfNot
{
	public static function isBool(v : Dynamic) return Std.is(v, Bool) ? null : "not a boolean";
	public static function isString(v : Dynamic) return Std.is(v, String) ? null : "not a string";
	public static function isObject(v : Dynamic) return Types.isAnonymous(v) ? null : "not an object";
}

class ReturnMessageChainer
{
	public static function make(f : Dynamic -> Bool, msg : String) {
		return function(v : Dynamic) {
			if(f(v))
				return null;
			else
				return msg;
		};
	}
	public static function or(f1 : Dynamic -> Null<String>, f2 : Dynamic -> Null<String>)
	{
		return function(v : Dynamic)
		{
			var o = f1(v);
			if(null == o)
				return f2(v);
			else
				return o;
		}
	}

	public static function and(f1 : Dynamic -> Null<String>, f2 : Dynamic -> Null<String>)
	{
		return function(v : Dynamic)
		{
			return null == f1(v) && null == f2(v);
		}
	}
}