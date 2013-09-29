<?php

class php_FileSystem {
	public function __construct(){}
	static function exists($path) {
		return file_exists($path);
	}
	static function rename($path, $newpath) {
		rename($path, $newpath);
	}
	static function stat($path) {
		$fp = fopen($path, "r");
		$fstat = fstat($fp);
		fclose($fp);;
		return _hx_anonymous(array("gid" => $fstat['gid'], "uid" => $fstat['uid'], "atime" => Date::fromTime($fstat['atime'] * 1000), "mtime" => Date::fromTime($fstat['mtime'] * 1000), "ctime" => Date::fromTime($fstat['ctime'] * 1000), "dev" => $fstat['dev'], "ino" => $fstat['ino'], "nlink" => $fstat['nlink'], "rdev" => $fstat['rdev'], "size" => $fstat['size'], "mode" => $fstat['mode']));
	}
	static function fullPath($relpath) {
		$p = realpath($relpath);
		if(($p === false)) {
			return null;
		} else {
			return $p;
		}
	}
	static function kind($path) {
		$k = filetype($path);
		switch($k) {
		case "file":{
			return php_FileKind::$kfile;
		}break;
		case "dir":{
			return php_FileKind::$kdir;
		}break;
		default:{
			return php_FileKind::kother($k);
		}break;
		}
	}
	static function isDirectory($path) {
		return is_dir($path);
	}
	static function createDirectory($path) {
		@mkdir($path, 493);
	}
	static function deleteFile($path) {
		@unlink($path);
	}
	static function deleteDirectory($path) {
		@rmdir($path);
	}
	static function readDirectory($path) {
		$l = array();
		$dh = opendir($path);
        while (($file = readdir($dh)) !== false) if("." != $file && ".." != $file) $l[] = $file;
        closedir($dh);;
		return new _hx_array($l);
	}
	function __toString() { return 'php.FileSystem'; }
}
