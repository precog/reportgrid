<?php

interface math_reduction_ModularReduction {
	function convert($x);
	function revert($x);
	function reduce($x);
	function mulTo($x, $y, $r);
	function sqrTo($x, $r);
}
