<?php

define("PHANTOMJS", "DISPLAY=:0 /usr/local/bin/phantomjs");
define('LOCAL', in_array($_SERVER['SERVER_NAME'], array('localhost', 'reportgrid.local')) || intval($_SERVER['SERVER_NAME']) > 0);
if(LOCAL)
{
	define("SERVICE_PATH", "/rg/services/viz/renderer/");
} else {
	define("SERVICE_PATH", "/services/viz/renderer/");
}


require_once('lib/config.class.php');

if(isset($_GET['file']))
{
	$file = $_GET['file'];
	$path = path($file);
	$format = array_pop(explode('.', $file));

	switch($format)
	{
		case "png":
			header("Content-Type: image/png");
			break;
		case "jpg":
			header("Content-Type: image/jpeg");
			break;
		case "pdf":
			header("Content-Type: application/pdf");
			break;
	}

	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=visualization.$format");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . filesize($path));

	readfile($path);
	exit;
}

try
{
	$config = Config::fromQueryString($_REQUEST);
	$hash = $config->hash();
	$output = path($hash,'xhtml');

	if(!file_exists($output)) {
		captureTemplate($config, $output);
	}

	$imagepath = path($hash, $config->format());

	if(!file_exists($imagepath)) {
		$out = renderVisualization($output, $imagepath, $config->width(), $config->height(), $config->format());
	}

	output(serviceUrl() . "?file=$hash.{$config->format()}");
	exit;
} catch(Exception $e) {
	output("ERROR:" . $e->getMessage());
	exit;
}

function renderVisualization($input, $output, $width, $height, $format)
{
	switch($format)
	{
		case "pdf":
			require_once('lib/WKPDF.class.php');
			$pdf = new WKPDF();
			$pdf->set_orientation($width > $height ? WKPDF::$PDF_LANDSCAPE : WKPDF::$PDF_PORTRAIT);
			$pdf->set_page_size("letter");
			$pdf->set_html_path($input);
			$out = $pdf->output($output);
			return $out;
			break;
		default:
			return phantom("renderer.js", $input, $output, $width, $height);
	}
}

function phantom($script, $input, $output, $width, $height)
{
	$dir = __DIR__;
	$bin = escapeshellcmd(PHANTOMJS);
	$options = " --config=$dir/phantom/config.json";
	$args = "$dir/$input  $dir/$output $width $height";
	$script = "$dir/phantom/$script";
	$cmd = "$bin$options $script $args";

	shell_exec('export DYLD_LIBRARY_PATH="";');
	return shell_exec($cmd);
}

function hostname()
{
	if(LOCAL)
		return $_SERVER['SERVER_NAME'];
	else
		return trim(`hostname -f`);
}

function serviceUrl()
{
	return "http://".hostname().SERVICE_PATH;
}

function url($name, $ext = null)
{
	return baseUrl() . 'cache/'.$name.(null == $ext ? '' : '.'.$ext);
}

function path($name, $ext = null)
{
	return 'cache/'.$name.(null == $ext ? '' : '.'.$ext);
}

function captureTemplate($config, $output)
{
	ob_start();
	printTemplate($config);
	$content = ob_get_contents();
	ob_end_clean();
	file_put_contents($output, $content);
}

function printTemplate($config)
{
	if($config->params())
		require_once('template/visualization.template.php');
	else
		require_once('template/xml.template.php');
}

function dump($v)
{
	echo "<pre>";
	var_dump($v);
	echo "</pre>";
}

function output($v)
{
	if(isset($_GET['callback']))
		echo $_GET['callback'].'("'.str_replace('"', '\\"', $v).'");';
	else
		echo $v;
}