<?php

interface ufront_web_module_ITraceModule extends ufront_web_IHttpModule{
	function trace($msg, $pos);
}
