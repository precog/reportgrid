<?php

class DateTools {
	public function __construct(){}
	static function format($d, $f) {
		return strftime($f, $d->__t);
	}
	static function delta($d, $t) {
		return Date::fromTime($d->getTime() + $t);
	}
	static $DAYS_OF_MONTH;
	static function getMonthDays($d) {
		$month = $d->getMonth();
		$year = $d->getFullYear();
		if($month !== 1) {
			return DateTools::$DAYS_OF_MONTH[$month];
		}
		$isB = $year % 4 === 0 && $year % 100 !== 0 || $year % 400 === 0;
		return (($isB) ? 29 : 28);
	}
	static function seconds($n) {
		return $n * 1000.0;
	}
	static function minutes($n) {
		return $n * 60.0 * 1000.0;
	}
	static function hours($n) {
		return $n * 60.0 * 60.0 * 1000.0;
	}
	static function days($n) {
		return $n * 24.0 * 60.0 * 60.0 * 1000.0;
	}
	static function parse($t) {
		$s = $t / 1000;
		$m = $s / 60;
		$h = $m / 60;
		return _hx_anonymous(array("ms" => $t % 1000, "seconds" => intval($s % 60), "minutes" => intval($m % 60), "hours" => intval($h % 24), "days" => intval($h / 24)));
	}
	static function make($o) {
		return $o->ms + 1000.0 * ($o->seconds + 60.0 * ($o->minutes + 60.0 * ($o->hours + 24.0 * $o->days)));
	}
	function __toString() { return 'DateTools'; }
}
DateTools::$DAYS_OF_MONTH = new _hx_array(array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31));
