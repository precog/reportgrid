<?php

interface ufront_web_mvc_view_ITemplateViewEngine extends ufront_web_mvc_IViewEngine{
	function getTemplate($controllerContext, $path);
}
