<?php

define('HOST', '//'.$_SERVER['SERVER_NAME']);
define('SAMPLES_CHARTS_DIR', 'samples/charts/');
define('SAMPLES_DATA_DIR', 'samples/data/');
define('SAMPLE_EXT', '.js');
define('MANAGE_CODE', '67ww78bhFGY!543fv');
define('LOCAL', in_array($_SERVER['SERVER_NAME'], array('localhost', 'reportgrid.local', '192.169.1.21')) || intval($_SERVER['SERVER_NAME']) > 0);
//define('AUTHCODE', 'IGLBxMA3vSoTDWz+Fu3cjPZNmdpS+fYSlwyN7LvpssTRTRpE4Lt+hqO9nX6LaLf2SZZBVf7vFDTyUID1uWUdoPC73kAA9HVzsOZwxO5jY+NdazmeBwK64oD5vRkxth5vO3ejfjx0nkh7mgaoSwde0zri1V+b+SVHR92RidT5Isk=');
//define('AUTHCODE', 'kcb+LX2KAKWofM1W54YYcFEE+aZ1L00UGK9PgcnrHpLRuFjCh6bOFSoMwc0NN3jmpZYqsBZ0uR08TQd0R0CmKj1o8FSJfNhPl2ZdjxqmhcZnYgiiFTWN2TLFVu4KvhSUAHp6jMaCzAPNlq7ImGjOovsVyti541aOn5+oFQXNeX0=');
define('AUTHCODE', 'QWWwKQIBDTBblBgGtgUCgQjS4MM+R+2oSOfdekNAM2xxE0E98ZLtdwaVfrMjShf51Ou3NsUtkv9yvqWH0pbyH0IRc6kvJ7HDZCyA3ObMouvdcyNxmyDS/EUcjCIZqxkGrCLcj9w43gMjWBHndW1Pk9429QaRI4voWSvZQMd4boE=');

$viz_categories = array(
	'SK' => array("name" => 'Sankey',				"sequence" => 0),
	'GE' => array("name" => 'Geo Chart',			"sequence" => 10),
	'GB' => array("name" => 'Geo Bubble Chart',		"sequence" => 20),
	'FC' => array("name" => 'Funnel Chart',			"sequence" => 30),
	'HM' => array("name" => 'Heatmap',				"sequence" => 40),
	'BS' => array("name" => 'Stacked Bar Chart',	"sequence" => 50),
	'BC' => array("name" => 'Bar Chart',			"sequence" => 60),
	'BP' => array("name" => 'Bar Percent Chart',	"sequence" => 70),
	'HS' => array("name" => 'Horizontal Stacked Bar Chart',	"sequence" => 80),
	'HC' => array("name" => 'Horizontal Bar Chart',			"sequence" => 90),
	'HP' => array("name" => 'Horizontal Bar Percent Chart',	"sequence" => 100),
	'SG' => array("name" => 'Stream Graph',			"sequence" => 110),
	'SP' => array("name" => 'Scatter Plot',			"sequence" => 120),
	'SB' => array("name" => 'Bubble Chart',			"sequence" => 130),
	'LS' => array("name" => 'Stacked Area Chart',	"sequence" => 140),
	'LA' => array("name" => 'Area Chart',			"sequence" => 150),
	'LP' => array("name" => 'Area Percent Chart',	"sequence" => 160),
	'LC' => array("name" => 'Line Chart',			"sequence" => 170),
	'PC' => array("name" => 'Pie Chart',			"sequence" => 180),
	'PD' => array("name" => 'Donut Chart',			"sequence" => 190),
	'PT' => array("name" => 'Pivot Table',			"sequence" => 200),
	'BB' => array("name" => 'Leaderboard',			"sequence" => 210)
);

if(LOCAL)
{
	define('REPORTGRID_VIZ_API', HOST.'/rg/charts/js/reportgrid-charts.js' . (AUTHCODE ? ('?authCode=' . urlencode(AUTHCODE)) : ''));
	define('REPORTGRID_QUERY_API', HOST.'/rg/query/js/reportgrid-query.js');
	define('REPORTGRID_CSS_API', HOST.'/rg/css/rg-charts.css');
	define('REPORTGRID_CORE_API', HOST.'/rg/js/reportgrid-core.js?tokenId=A3BC1539-E8A9-4207-BB41-3036EC2C6E6D&analyticsServer=https://stageapp01.reportgrid.com/services/analytics/v1/" type="text/javascript');
	define('SAMPLE_CSS', HOST.'/rg/charts/service/samples/css/sample.css');

	$viz_categories['XX'] = array('name' => 'Test', 'sequence' => 1000);
} else {
	define('REPORTGRID_VIZ_API', HOST.'/js/reportgrid-charts.js' . (AUTHCODE ? ('?authCode=' . urlencode(AUTHCODE)) : ''));
	define('REPORTGRID_QUERY_API', '//api.reportgrid.com/js/reportgrid-query.js');
	define('REPORTGRID_CSS_API', '//api.reportgrid.com/css/rg-charts.css');
	define('REPORTGRID_CORE_API', '//api.reportgrid.com/js/reportgrid-core.js?tokenId=A3BC1539-E8A9-4207-BB41-3036EC2C6E6D&analyticsServer=https://stageapp01.reportgrid.com/services/analytics/v1/" type="text/javascript');
	define('SAMPLE_CSS', '//api.reportgrid.com/services/viz/samples/samples/css/sample.css');
}

function categories()
{
	global $viz_categories;
	$result = array();
	foreach($viz_categories as $key => $value)
	{
		$result[] = array('category' => $value['name'], 'code' => $key);
	}
	return $result;
}

function categoryOptions($cat)
{
	$d = dir(SAMPLES_CHARTS_DIR);
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
	global $viz_categories;
	$c = @$viz_categories[substr($v, 0, 2)]['sequence'];
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
	$d = dir(SAMPLES_CHARTS_DIR);
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
	$result = parseContent(file_get_contents(SAMPLES_CHARTS_DIR.basename($sample)));
	$result['title']  = extractTitle($sample);
	$result['sample'] = $sample;
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
			$info['data'] = "function data() {\n\t return ".file_get_contents(SAMPLES_DATA_DIR.$value.'.json').";\n}";
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

function displayMonster()
{
	$list = infoSamples();
	$VIZ_API = REPORTGRID_VIZ_API;
	$CSS_API = REPORTGRID_CSS_API;
	require('template-monster.php');
	exit;
}

function display($sample)
{
	$info = infoSample($sample);
	$VIZ_API = REPORTGRID_VIZ_API;
	if(false !== strpos(@$info['viz'], 'ReportGrid.query'))
	{
		$QUERY_API = REPORTGRID_QUERY_API;
		$CORE_API = REPORTGRID_CORE_API;
	}
	$CSS_API = REPORTGRID_CSS_API;
	$SAMPLE_CSS = SAMPLE_CSS;
	require('template.php');
	exit;
}

function delete($list)
{
	if(in_array($_SERVER['SERVER_NAME'], array('localhost')))
	{
		echo "CAN'T DELETE ON LOCALHOST<br>";
		var_dump($list);
		return;
	}
	foreach($list as $item)
	{
		$file = SAMPLES_CHARTS_DIR.$item;
		unlink($file);
	}
}

function deleteAll()
{
	$result = array();
	foreach(listSamples(false) as $item)
		$result[] = $item['sample'];
	delete($result);
}

function manage()
{
	if(isset($_POST))
	{
		switch($_POST['action'])
		{
			case "delete":
				delete($_POST['selected']);
				break;
			case "deleteall":
				deleteAll();
				break;
		}
	}
	$list = listSamples(false);
	require('template-manage.php');
	exit();
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
	case 'categories':
		json(categories());
	case 'options':
		json(categoryOptions($_GET['category']));
	case 'info':
		json(infoSample($_GET['sample']));
	case 'display':
		display($_GET['sample']);
	case 'monster':
		displayMonster();
		break;
//	case 'manage':
//		if($_GET['code'] == MANAGE_CODE)
//			manage();
	default:
		echo "INVALID ACTION";
}