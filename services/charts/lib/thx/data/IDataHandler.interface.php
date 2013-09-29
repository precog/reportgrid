<?php

interface thx_data_IDataHandler {
	function start();
	function end();
	function objectStart();
	function objectFieldStart($name);
	function objectFieldEnd();
	function objectEnd();
	function arrayStart();
	function arrayItemStart();
	function arrayItemEnd();
	function arrayEnd();
	function valueDate($d);
	function valueString($s);
	function valueInt($i);
	function valueFloat($f);
	function valueNull();
	function valueBool($b);
	function comment($s);
}
