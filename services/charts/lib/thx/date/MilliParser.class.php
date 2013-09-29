<?php

class thx_date_MilliParser {
	public function __construct(){}
	static $CHUNKER;
	static $map;
	static function parse($s) {
		if(thx_date_MilliParser::$CHUNKER->match($s)) {
			return (((thx_date_MilliParser::$CHUNKER->matched(1) === "-") ? -1 : 1)) * Std::parseFloat(thx_date_MilliParser::$CHUNKER->matched(2)) * thx_date_MilliParser::$map->get(thx_date_MilliParser::$CHUNKER->matched(3)) + thx_date_MilliParser::parse(thx_date_MilliParser::$CHUNKER->matchedRight());
		} else {
			return 0;
		}
	}
	function __toString() { return 'thx.date.MilliParser'; }
}
thx_date_MilliParser::$CHUNKER = new EReg("([+-])?\\s*(\\d*.?\\d+)\\s*(ms|milli|millisecond|sec|second|min|minute|hour|day|week|[smhdw])s?", "");
thx_date_MilliParser::$map = thx_date_MilliParser_0();
function thx_date_MilliParser_0() {
	{
		$m = new Hash();
		$m->set("ms", 1);
		$m->set("milli", 1);
		$m->set("millisecond", 1);
		$m->set("s", 1000);
		$m->set("sec", 1000);
		$m->set("second", 1000);
		$m->set("m", 60000);
		$m->set("min", 60000);
		$m->set("minute", 60000);
		$m->set("h", 3600000);
		$m->set("hour", 3600000);
		$m->set("d", 86400000);
		$m->set("day", 86400000);
		$m->set("w", 604800000);
		$m->set("week", 604800000);
		return $m;
	}
}
