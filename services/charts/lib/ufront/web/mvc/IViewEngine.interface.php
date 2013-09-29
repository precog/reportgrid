<?php

interface ufront_web_mvc_IViewEngine {
	function findView($controllerContext, $viewName);
	function releaseView($controllerContext, $view);
}
