<?php

class php_FileSystem {
	public function __construct(){}
	static function exists($path) {
		$GLOBALS['%s']->push("php.FileSystem::exists");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = file_exists($path);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function rename($path, $newpath) {
		$GLOBALS['%s']->push("php.FileSystem::rename");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = rename($path, $newpath);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function stat($path) {
		$GLOBALS['%s']->push("php.FileSystem::stat");
		$»spos = $GLOBALS['%s']->length;
		$fp = fopen($path, "r");
		$fstat = fstat($fp);
		fclose($fp);;
		{
			$»tmp = _hx_anonymous(array("gid" => $fstat['gid'], "uid" => $fstat['uid'], "atime" => Date::fromTime($fstat['atime'] * 1000), "mtime" => Date::fromTime($fstat['mtime'] * 1000), "ctime" => Date::fromTime($fstat['ctime'] * 1000), "dev" => $fstat['dev'], "ino" => $fstat['ino'], "nlink" => $fstat['nlink'], "rdev" => $fstat['rdev'], "size" => $fstat['size'], "mode" => $fstat['mode']));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fullPath($relpath) {
		$GLOBALS['%s']->push("php.FileSystem::fullPath");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = realpath($relpath);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function kind($path) {
		$GLOBALS['%s']->push("php.FileSystem::kind");
		$»spos = $GLOBALS['%s']->length;
		$k = filetype($path);
		switch($k) {
		case "file":{
			$»tmp = php_FileKind::$kfile;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		case "dir":{
			$»tmp = php_FileKind::$kdir;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		default:{
			$»tmp = php_FileKind::kother($k);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function isDirectory($path) {
		$GLOBALS['%s']->push("php.FileSystem::isDirectory");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = is_dir($path);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function createDirectory($path) {
		$GLOBALS['%s']->push("php.FileSystem::createDirectory");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = @mkdir($path, 493);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function deleteFile($path) {
		$GLOBALS['%s']->push("php.FileSystem::deleteFile");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = @unlink($path);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function deleteDirectory($path) {
		$GLOBALS['%s']->push("php.FileSystem::deleteDirectory");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = @rmdir($path);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function readDirectory($path) {
		$GLOBALS['%s']->push("php.FileSystem::readDirectory");
		$»spos = $GLOBALS['%s']->length;
		$l = array();
		$dh = opendir($path);
        while (($file = readdir($dh)) !== false) if("." != $file && ".." != $file) $l[] = $file;
        closedir($dh);;
		{
			$»tmp = new _hx_array($l);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'php.FileSystem'; }
}
