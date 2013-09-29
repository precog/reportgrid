<?php

interface ufront_web_IUrlFilter {
	function filterIn($url, $request);
	function filterOut($url, $request);
}
