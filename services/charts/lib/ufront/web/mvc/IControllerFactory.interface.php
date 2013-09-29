<?php

interface ufront_web_mvc_IControllerFactory {
	function createController($requestContext, $controllerName);
	function releaseController($controller);
}
