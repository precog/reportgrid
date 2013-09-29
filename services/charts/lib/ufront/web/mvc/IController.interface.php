<?php

interface ufront_web_mvc_IController {
	function execute($requestContext, $async);
	function getViewHelpers();
}
