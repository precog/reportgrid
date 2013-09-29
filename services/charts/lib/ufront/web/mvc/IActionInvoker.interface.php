<?php

interface ufront_web_mvc_IActionInvoker {
	function invokeAction($controllerContext, $actionName, $async);
}
