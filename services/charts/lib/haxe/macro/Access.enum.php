<?php

class haxe_macro_Access extends Enum {
	public static $ADynamic;
	public static $AInline;
	public static $AOverride;
	public static $APrivate;
	public static $APublic;
	public static $AStatic;
	public static $__constructors = array(4 => 'ADynamic', 5 => 'AInline', 3 => 'AOverride', 1 => 'APrivate', 0 => 'APublic', 2 => 'AStatic');
	}
haxe_macro_Access::$ADynamic = new haxe_macro_Access("ADynamic", 4);
haxe_macro_Access::$AInline = new haxe_macro_Access("AInline", 5);
haxe_macro_Access::$AOverride = new haxe_macro_Access("AOverride", 3);
haxe_macro_Access::$APrivate = new haxe_macro_Access("APrivate", 1);
haxe_macro_Access::$APublic = new haxe_macro_Access("APublic", 0);
haxe_macro_Access::$AStatic = new haxe_macro_Access("AStatic", 2);
