<?php

interface chx_crypt_IPad {
	//;
	function pad($s);
	function unpad($s);
	function isBlockPad();
	function calcNumBlocks($len);
	function blockOverhead();
	function getBytesReadPerBlock();
}
