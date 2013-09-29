<?php

interface ufront_web_routing_IRouteConstraint {
	function match($context, $route, $params, $direction);
}
