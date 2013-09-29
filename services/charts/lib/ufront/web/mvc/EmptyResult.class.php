<?php

class ufront_web_mvc_EmptyResult extends ufront_web_mvc_ActionResult {
	public function __construct() { 
	}
	public function executeResult($controllerContext) {
	}
	function __toString() { return 'ufront.web.mvc.EmptyResult'; }
}
