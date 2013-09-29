<?php

class php_io_File {
	public function __construct(){}
	static function getContent($path) {
		return file_get_contents($path);
	}
	static function getBytes($path) {
		return haxe_io_Bytes::ofString(php_io_File::getContent($path));
	}
	static function putContent($path, $content) {
		return file_put_contents($path, $content);
	}
	static function read($path, $binary) {
		if($binary === null) {
			$binary = true;
		}
		return new php_io_FileInput(fopen($path, (($binary) ? "rb" : "r")));
	}
	static function write($path, $binary) {
		if($binary === null) {
			$binary = true;
		}
		return new php_io_FileOutput(fopen($path, (($binary) ? "wb" : "w")));
	}
	static function append($path, $binary) {
		if($binary === null) {
			$binary = true;
		}
		return new php_io_FileOutput(fopen($path, (($binary) ? "ab" : "a")));
	}
	static function copy($src, $dst) {
		copy($src, $dst);
	}
	static function stdin() {
		return new php_io_FileInput(fopen("php://stdin", "r"));
	}
	static function stdout() {
		return new php_io_FileOutput(fopen("php://stdout", "w"));
	}
	static function stderr() {
		return new php_io_FileOutput(fopen("php://stderr", "w"));
	}
	static function getChar($echo) {
		$v = fgetc(STDIN);
		if($echo) {
			echo($v);
		}
		return $v;
	}
	function __toString() { return 'php.io.File'; }
}
