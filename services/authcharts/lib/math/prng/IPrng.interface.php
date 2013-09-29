<?php

interface math_prng_IPrng {
	//;
	function init($key);
	function next();
	function toString();
}
