<?php

class thx_date_Milli {
	public function __construct(){}
	static $CHUNKER;
	static $intervals;
	static $map;
	static function parse($s) {
		if(thx_date_Milli::$CHUNKER->match($s)) {
			return (((thx_date_Milli::$CHUNKER->matched(1) === "-") ? -1 : 1)) * Std::parseFloat(thx_date_Milli::$CHUNKER->matched(2)) * thx_date_Milli::$map->get(thx_date_Milli::$CHUNKER->matched(3)) + thx_date_Milli::parse(thx_date_Milli::$CHUNKER->matchedRight());
		} else {
			return 0;
		}
	}
	static function toString($v, $shortFormat) {
		if($shortFormat === null) {
			$shortFormat = true;
		}
		$len = thx_date_Milli::$intervals->length; $cur = 0; $s = new _hx_array(array()); $item = null;
		while($cur < $len && $v >= 1) {
			$item = thx_date_Milli::$intervals[$cur];
			$div = Math::floor($v / $item->time);
			if($div > 0) {
				if($shortFormat) {
					$s->push($div . $item->short);
				} else {
					$s->push($div . " " . $item->name . ((($div === 1) ? "" : "s")));
				}
				$v = $v - $div * $item->time;
			}
			$cur++;
			unset($div);
		}
		if($shortFormat) {
			return $s->join("");
		} else {
			$last = $s->pop();
			return _hx_deref(((($s->length > 0) ? new _hx_array(array($s->join(", "))) : new _hx_array(array()))))->concat(new _hx_array(array($last)))->join(" and ");
		}
	}
	function __toString() { return 'thx.date.Milli'; }
}
thx_date_Milli::$CHUNKER = new EReg("([+-])?\\s*(\\d*.?\\d+)\\s*(ms|millisecond|second|minute|hour|day|[smhd])s?", "");
thx_date_Milli::$intervals = new _hx_array(array(_hx_anonymous(array("name" => "day", "short" => "d", "time" => 86400000)), _hx_anonymous(array("name" => "hour", "short" => "h", "time" => 3600000)), _hx_anonymous(array("name" => "minute", "short" => "m", "time" => 60000)), _hx_anonymous(array("name" => "second", "short" => "s", "time" => 1000)), _hx_anonymous(array("name" => "millisecond", "short" => "ms", "time" => 1))));
thx_date_Milli::$map = call_user_func((array(new _hx_lambda(array(), "thx_date_Milli_0"), 'execute')));
function thx_date_Milli_0() {
	{
		$m = new Hash();
		Arrays::each(thx_date_Milli::$intervals, array(new _hx_lambda(array(&$m), "thx_date_Milli_1"), 'execute'));
		return $m;
	}
}
function thx_date_Milli_1(&$m, $item, $_) {
	{
		$m->set($item->name, $item->time);
		$m->set($item->short, $item->time);
	}
}
