<?php

interface ufront_web_IHttpSessionState {
	function dispose();
	function clear();
	function get($name);
	function set($name, $value);
	function exists($name);
	function remove($name);
	function id();
}
