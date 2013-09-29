<?php

interface ufront_web_mvc_IResultFilter {
	function onResultExecuting($filterContext);
	function onResultExecuted($filterContext);
}
