<?php

interface ufront_web_mvc_IActionFilter {
	function onActionExecuting($filterContext);
	function onActionExecuted($filterContext);
}
