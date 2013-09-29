<?php

interface ufront_web_IHttpModule {
	function init($application);
	function dispose();
}
