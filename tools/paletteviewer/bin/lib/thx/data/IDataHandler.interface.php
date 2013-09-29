<?php

interface thx_data_IDataHandler {
	function start();
	function end();
	function startObject();
	function startField($name);
	function endField();
	function endObject();
	function startArray();
	function startItem();
	function endItem();
	function endArray();
	function date($d);
	function string($s);
	function int($i);
	function float($f);
	function null();
	function bool($b);
	function comment($s);
}
