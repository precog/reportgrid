<?php

class Main {
	public function __construct(){}
	static $patternColorCapture;
	static function main() {
		$GLOBALS['%s']->push("Main::main");
		$製pos = $GLOBALS['%s']->length;
		$config = thx_ini_Ini::decode(php_io_File::getContent("config.ini")); $src = $config->src; $pattern = new EReg($config->pattern, "i");
		if(!file_exists($config->template)) {
			throw new HException(new thx_error_Error("template file not found at '{0}'", null, $config->template, _hx_anonymous(array("fileName" => "Main.hx", "lineNumber" => 23, "className" => "Main", "methodName" => "main"))));
		}
		$temp = new erazor_Template(php_io_File::getContent($config->template));
		$items = Iterators::map(Arrays::filter(Arrays::filter(php_FileSystem::readDirectory($config->src), array(new _hx_lambda(array(&$config, &$pattern, &$src, &$temp), "Main_0"), 'execute')), array(new _hx_lambda(array(&$config, &$pattern, &$src, &$temp), "Main_1"), 'execute'))->iterator(), array(new _hx_lambda(array(&$config, &$pattern, &$src, &$temp), "Main_2"), 'execute'));
		$items->sort(array(new _hx_lambda(array(&$config, &$items, &$pattern, &$src, &$temp), "Main_3"), 'execute'));
		Arrays::each($items, (isset(Main::$addColors) ? Main::$addColors: array("Main", "addColors")));
		php_Lib::hprint($temp->execute(_hx_anonymous(array("items" => $items))));
		$GLOBALS['%s']->pop();
	}
	static function addColors($item, $_) {
		$GLOBALS['%s']->push("Main::addColors");
		$製pos = $GLOBALS['%s']->length;
		$content = php_io_File::getContent($item->path);
		while(Main::$patternColorCapture->match($content)) {
			$item->colors->push(Main::$patternColorCapture->matched(1));
			$content = Main::$patternColorCapture->matchedRight();
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Main'; }
}
Main::$patternColorCapture = new EReg("background-color\\s*:\\s*(#?[0-9a-f]+)", "i");
function Main_0(&$config, &$pattern, &$src, &$temp, $d) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Main::main@28");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = $pattern->match($d);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Main_1(&$config, &$pattern, &$src, &$temp, $d) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Main::main@29");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = !is_dir($config->src . "/" . $d);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Main_2(&$config, &$pattern, &$src, &$temp, $d, $i) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Main::main@30");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = _hx_anonymous(array("name" => $d, "path" => $config->src . "/" . $d, "colors" => new _hx_array(array())));
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
function Main_3(&$config, &$items, &$pattern, &$src, &$temp, $a, $b) {
	$製pos = $GLOBALS['%s']->length;
	{
		$GLOBALS['%s']->push("Main::main@35");
		$製pos2 = $GLOBALS['%s']->length;
		{
			$裨mp = Strings::compare($a->name, $b->name);
			$GLOBALS['%s']->pop();
			return $裨mp;
		}
		$GLOBALS['%s']->pop();
	}
}
