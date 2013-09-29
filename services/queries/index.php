<?php

define('SAMPLES_QUERIES_DIR', 'samples/queries/');
define('SAMPLES_DATA_DIR', 'samples/data/');
define('SAMPLE_EXT', '.js');
define('DEFAULT_PATH', '/query/test2');
define('LOCAL', in_array($_SERVER['SERVER_NAME'], array('localhost', 'reportgrid.local')) || intval($_SERVER['SERVER_NAME']) > 0);
define('DISABLE_CACHE', isset($_GET['disableCache']));
define('ANALYTICS_SERVER', isset($_GET['analyticsServer']) ? $_GET['analyticsServer'] : 'http://stageapp01.reportgrid.com/services/analytics/v1/');

$categories = array(
	'RG' => array("name" => 'RG Query', "sequence" => 0),
	'QU' => array("name" => 'Query', "sequence" => 10),
	'VZ' => array("name" => 'Visualization', "sequence" => 20),
	'PR' => array("name" => 'Precog', "sequence" => 30),
	'TR' => array("name" => 'Track', "sequence" => 50)
);

define('TOKEN_ID', 'A3BC1539-E8A9-4207-BB41-3036EC2C6E6D');

if(LOCAL)
{
	define('REPORTGRID_QUERY_API', '/rg/js/reportgrid-query.js');
	define('REPORTGRID_CHARTS_API', '/rg/js/reportgrid-charts.js');
	define('REPORTGRID_CSS_API', '/rg/css/rg-charts.css');
	define('REPORTGRID_CORE_API', '/rg/js/reportgrid-core.js?tokenId=$tokenId' . (ANALYTICS_SERVER ? ('&analyticsServer='.ANALYTICS_SERVER) : ''));
	define('PRECOG_CORE_API', '/rg/js/precog.js?tokenId=C5EF0038-A2A2-47EB-88A4-AAFCE59EC22B');
	$categories['XX'] = array('name' => 'Test', 'sequence' => 1000);
} else {
	define('REPORTGRID_QUERY_API', 'http://api.reportgrid.com/js/reportgrid-query.js');
	define('REPORTGRID_CHARTS_API', 'http://api.reportgrid.com/js/reportgrid-charts.js');
	define('REPORTGRID_CSS_API', 'http://api.reportgrid.com/css/rg-charts.css');
	define('PRECOG_CORE_API', 'http://api.reportgrid.com/js/precog.js?tokenId=C5EF0038-A2A2-47EB-88A4-AAFCE59EC22B' . (ANALYTICS_SERVER ? ('&analyticsServer='.ANALYTICS_SERVER) : ''));
}

function categories()
{
	global $categories;
	$result = array();
	foreach($categories as $key => $value)
	{
		$result[] = array('category' => $value['name'], 'code' => $key);
	}
	return $result;
}

function categoryOptions($cat)
{
	$d = dir(SAMPLES_QUERIES_DIR);
	$results = array();
	while(false !== ($entry = $d->read())) {
		if($cat != ($p = substr($entry, 0, 2)))
			continue;
		$results[] = array('sample' => $entry, 'title' => extractTitle($entry));
	}
	usort($results, 'optionComparison');
	return $results;
}

function extractTitle($sample)
{
	return array_pop(explode('-', basename($sample, SAMPLE_EXT), 2));
}

function compareCategory($v)
{
	global $categories;
	$c = @$categories[substr($v, 0, 2)]['sequence'];
	if($c === null)
		return 1000;
	else
		return $c;
}

function sampleComparison($a, $b)
{
	$v = compareCategory($a['sample']) - compareCategory($b['sample']);
	if($v !== 0)
		return $v;
	else
		return $a['sample']>$b['sample'];
}

function optionComparison($a, $b)
{
	return substr($a['sample'], 2) > substr($b['sample'], 2);
}

function listSamples($filtered = true)
{
	$d = dir(SAMPLES_QUERIES_DIR);
	$results = array();
	while(false !== ($entry = $d->read())) {
		if(('.' == ($c = substr($entry, 0, 1))) || ($filtered && ($c == '_' || $c == '-')))
			continue;
		$results[] = array('sample' => $entry, 'title' => extractTitle($entry));
	}
	usort($results, 'sampleComparison');
	return $results;
}

function infoSample($sample)
{
	$result = parseContent(file_get_contents(SAMPLES_QUERIES_DIR.basename($sample)));
	$result['title']  = extractTitle($sample);
	$result['sample'] = $sample;
	if(isset($result['query']))
		$result['query'] = str_replace('pathvalue', "'".DEFAULT_PATH."'", $result['query']);
	return $result;
}

function parseContent($content)
{
	$info = array();
	$parts = explode('//**', $content);
	foreach($parts as $part)
	{
		$pair = explode("\n", $part, 2);
		// first line is the section
		$key = trim(strtolower($pair[0]));
		if(!$key) continue;
		// the rest is the content
		$value = trim($pair[1]);
		if($key == 'load')
		{
			$info['load'] = file_get_contents(SAMPLES_DATA_DIR.$value.'.json'); //."\n\n".@$info['data']; //"(function() {\n\t ".file_get_contents(SAMPLES_DATA_DIR.$value.'.json').";\nreturn {$info['data']}\n})()";
		} else {
			$info[$key] = $value;
		}
	}

	return $info;
}

function infoSamples()
{
	$list = listSamples(true);
	$result = array();
	foreach($list as $item)
	{
		if(substr($item['sample'], 0, 2) == "XX")
			continue;
		$result[] = infoSample($item['sample']);
	}
	return $result;
}

function display($sample)
{
	$info = infoSample($sample);
	$QUERY_API = REPORTGRID_QUERY_API;
	$VIZ_API = REPORTGRID_CHARTS_API;
	$CSS_API = REPORTGRID_CSS_API;
	$CORE_API = REPORTGRID_CORE_API;
	$CORE_API = str_replace('$tokenId', isset($info['token']) ? $info['token'] : TOKEN_ID, $CORE_API);
	$DEFAULT_PATH = isset($info['path']) ? $info['path'] : DEFAULT_PATH;
	$PRECOG_API = PRECOG_CORE_API;
	$DISABLE_CACHE = DISABLE_CACHE;
	require('template.php');
	exit;
}

function json($v)
{
	$json = json_encode($v);
	if(@$_GET['callback'])
	{
		echo $_GET['callback']."($json);";
	} else {
		echo $json;
	}
	exit;
}

if(!isset($_GET['action']))
{
	echo "<ul>\n";
	foreach(listSamples() as $item)
		echo "\t<li>{$item['title']}</li>\n";
	echo "</ul>";
	exit;
}

switch($_GET['action'])
{
	case 'list':
		json(listSamples());
		break;
	case 'categories':
		json(categories());
		break;
	case 'options':
		json(categoryOptions($_GET['category']));
		break;
	case 'info':
		json(infoSample($_GET['sample']));
		break;
	case 'display':
		display($_GET['sample']);
		break;
	default:
		echo "INVALID ACTION";
}