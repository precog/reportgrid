<?php

class php_Sys {
	public function __construct(){}
	static function args() {
		$GLOBALS['%s']->push("php.Sys::args");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = ((array_key_exists("argv", $_SERVER)) ? new _hx_array(array_slice($_SERVER["argv"], 1)) : new _hx_array(array()));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getEnv($s) {
		$GLOBALS['%s']->push("php.Sys::getEnv");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = getenv($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function putEnv($s, $v) {
		$GLOBALS['%s']->push("php.Sys::putEnv");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = putenv($s . "=" . $v);
			$GLOBALS['%s']->pop();
			$»tmp;
			return;
		}
		$GLOBALS['%s']->pop();
	}
	static function sleep($seconds) {
		$GLOBALS['%s']->push("php.Sys::sleep");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = usleep($seconds * 1000000);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function setTimeLocale($loc) {
		$GLOBALS['%s']->push("php.Sys::setTimeLocale");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = setlocale(LC_TIME, $loc) !== false;
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getCwd() {
		$GLOBALS['%s']->push("php.Sys::getCwd");
		$»spos = $GLOBALS['%s']->length;
		$cwd = getcwd();
		$l = _hx_substr($cwd, -1, null);
		{
			$»tmp = $cwd . ((($l === "/" || $l === "\\") ? "" : "/"));
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function setCwd($s) {
		$GLOBALS['%s']->push("php.Sys::setCwd");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = chdir($s);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function systemName() {
		$GLOBALS['%s']->push("php.Sys::systemName");
		$»spos = $GLOBALS['%s']->length;
		$s = php_uname("s");
		$p = null;
		if(($p = _hx_index_of($s, " ", null)) >= 0) {
			$»tmp = _hx_substr($s, 0, $p);
			$GLOBALS['%s']->pop();
			return $»tmp;
		} else {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	static function escapeArgument($arg) {
		$GLOBALS['%s']->push("php.Sys::escapeArgument");
		$»spos = $GLOBALS['%s']->length;
		$ok = true;
		{
			$_g1 = 0; $_g = strlen($arg);
			while($_g1 < $_g) {
				$i = $_g1++;
				switch(_hx_char_code_at($arg, $i)) {
				case 32:case 34:{
					$ok = false;
				}break;
				case 0:case 13:case 10:{
					$arg = _hx_substr($arg, 0, $i);
				}break;
				}
				unset($i);
			}
		}
		if($ok) {
			$GLOBALS['%s']->pop();
			return $arg;
		}
		{
			$»tmp = "\"" . _hx_explode("\"", $arg)->join("\\\"") . "\"";
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function command($cmd, $args) {
		$GLOBALS['%s']->push("php.Sys::command");
		$»spos = $GLOBALS['%s']->length;
		if($args !== null) {
			$cmd = php_Sys::escapeArgument($cmd);
			{
				$_g = 0;
				while($_g < $args->length) {
					$a = $args[$_g];
					++$_g;
					$cmd .= " " . php_Sys::escapeArgument($a);
					unset($a);
				}
			}
		}
		$result = 0;
		system($cmd, $result);
		{
			$GLOBALS['%s']->pop();
			return $result;
		}
		$GLOBALS['%s']->pop();
	}
	static function hexit($code) {
		$GLOBALS['%s']->push("php.Sys::exit");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = exit($code);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function time() {
		$GLOBALS['%s']->push("php.Sys::time");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = microtime(true);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function cpuTime() {
		$GLOBALS['%s']->push("php.Sys::cpuTime");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = microtime(true) - $_SERVER['REQUEST_TIME'];
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function executablePath() {
		$GLOBALS['%s']->push("php.Sys::executablePath");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = $_SERVER['SCRIPT_FILENAME'];
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function environment() {
		$GLOBALS['%s']->push("php.Sys::environment");
		$»spos = $GLOBALS['%s']->length;
		{
			$»tmp = php_Lib::hashOfAssociativeArray($_SERVER);
			$GLOBALS['%s']->pop();
			return $»tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'php.Sys'; }
}
