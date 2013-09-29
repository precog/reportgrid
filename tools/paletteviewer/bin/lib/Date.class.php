<?php

class Date {
	public function __construct($year, $month, $day, $hour, $min, $sec) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("Date::new");
		$»spos = $GLOBALS['%s']->length;
		$this->__t = mktime($hour, $min, $sec, $month + 1, $day, $year);
		$GLOBALS['%s']->pop();
	}}
	public $__t;
	public function getTime() {
		$GLOBALS['%s']->push("Date::getTime");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->__t * 1000;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getPhpTime() {
		$GLOBALS['%s']->push("Date::getPhpTime");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $this->__t;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getFullYear() {
		$GLOBALS['%s']->push("Date::getFullYear");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = intval(date("Y", $this->__t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getMonth() {
		$GLOBALS['%s']->push("Date::getMonth");
		$»spos = $GLOBALS['%s']->length;
		$m = intval(date("n", $this->__t));
		{
			$»tmp = -1 + $m;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getDate() {
		$GLOBALS['%s']->push("Date::getDate");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = intval(date("j", $this->__t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getHours() {
		$GLOBALS['%s']->push("Date::getHours");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = intval(date("G", $this->__t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getMinutes() {
		$GLOBALS['%s']->push("Date::getMinutes");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = intval(date("i", $this->__t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getSeconds() {
		$GLOBALS['%s']->push("Date::getSeconds");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = intval(date("s", $this->__t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getDay() {
		$GLOBALS['%s']->push("Date::getDay");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = intval(date("w", $this->__t));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("Date::toString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = date("Y-m-d H:i:s", $this->__t);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static function now() {
		$GLOBALS['%s']->push("Date::now");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Date::fromPhpTime(time());
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromPhpTime($t) {
		$GLOBALS['%s']->push("Date::fromPhpTime");
		$»spos = $GLOBALS['%s']->length;
		$d = new Date(2000, 1, 1, 0, 0, 0);
		$d->__t = $t;
		{
			$GLOBALS['%s']->pop();
			return $d;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromTime($t) {
		$GLOBALS['%s']->push("Date::fromTime");
		$»spos = $GLOBALS['%s']->length;
		$d = new Date(2000, 1, 1, 0, 0, 0);
		$d->__t = $t / 1000;
		{
			$GLOBALS['%s']->pop();
			return $d;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromString($s) {
		$GLOBALS['%s']->push("Date::fromString");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = Date::fromPhpTime(strtotime($s));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return $this->toString(); }
}
