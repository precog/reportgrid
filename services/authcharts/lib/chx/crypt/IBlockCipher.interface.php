<?php

interface chx_crypt_IBlockCipher {
	//;
	function encryptBlock($plain);
	function decryptBlock($enc);
}
