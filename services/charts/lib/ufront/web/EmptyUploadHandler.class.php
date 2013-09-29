<?php

class ufront_web_EmptyUploadHandler implements ufront_web_IHttpUploadHandler{
	public function __construct() { 
	}
	public function uploadStart($name, $filename) {
	}
	public function uploadProgress($bytes, $pos, $len) {
	}
	public function uploadEnd() {
	}
	function __toString() { return 'ufront.web.EmptyUploadHandler'; }
}
