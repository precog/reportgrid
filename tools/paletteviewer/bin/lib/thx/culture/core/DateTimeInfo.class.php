<?php

class thx_culture_core_DateTimeInfo {
	public function __construct($months, $abbrMonths, $days, $abbrDays, $shortDays, $am, $pm, $separatorDate, $separatorTime, $firstWeekDay, $patternYearMonth, $patternMonthDay, $patternDate, $patternDateShort, $patternDateRfc, $patternDateTime, $patternUniversal, $patternSortable, $patternTime, $patternTimeShort) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("thx.culture.core.DateTimeInfo::new");
		$»spos = $GLOBALS['%s']->length;
		$this->months = $months;
		$this->abbrMonths = $abbrMonths;
		$this->days = $days;
		$this->abbrDays = $abbrDays;
		$this->shortDays = $shortDays;
		$this->am = $am;
		$this->pm = $pm;
		$this->separatorDate = $separatorDate;
		$this->separatorTime = $separatorTime;
		$this->firstWeekDay = $firstWeekDay;
		$this->patternYearMonth = $patternYearMonth;
		$this->patternMonthDay = $patternMonthDay;
		$this->patternDate = $patternDate;
		$this->patternDateShort = $patternDateShort;
		$this->patternDateRfc = $patternDateRfc;
		$this->patternDateTime = $patternDateTime;
		$this->patternUniversal = $patternUniversal;
		$this->patternSortable = $patternSortable;
		$this->patternTime = $patternTime;
		$this->patternTimeShort = $patternTimeShort;
		$GLOBALS['%s']->pop();
	}}
	public $months;
	public $abbrMonths;
	public $days;
	public $abbrDays;
	public $shortDays;
	public $am;
	public $pm;
	public $separatorDate;
	public $separatorTime;
	public $firstWeekDay;
	public $patternYearMonth;
	public $patternMonthDay;
	public $patternDate;
	public $patternDateShort;
	public $patternDateRfc;
	public $patternDateTime;
	public $patternUniversal;
	public $patternSortable;
	public $patternTime;
	public $patternTimeShort;
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
	function __toString() { return 'thx.culture.core.DateTimeInfo'; }
}
