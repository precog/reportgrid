<?php

interface ufront_web_mvc_IValueProvider {
	function containsPrefix($prefix);
	function getValue($key);
}
