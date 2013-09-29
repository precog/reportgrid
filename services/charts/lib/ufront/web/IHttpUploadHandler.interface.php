<?php

interface ufront_web_IHttpUploadHandler {
	function uploadStart($name, $filename);
	function uploadProgress($bytes, $pos, $len);
	function uploadEnd();
}
