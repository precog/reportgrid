<?php

interface ufront_web_mvc_view_ITemplateView extends ufront_web_mvc_IView{
	//;
	//;
	function data();
	function executeTemplate($template, $data);
}
