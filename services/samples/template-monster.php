<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monster VIZ</title>
<link rel="stylesheet" type="text/css" href="<?php echo $CSS_API; ?>"/>
<script src="<?php echo $VIZ_API; ?>"></script>
<style>
body, html
{
	margin: 0;
	padding: 0;
}

.chart
{
	width : 480px;
	height : 320px;
	margin: 10px;
	float: left;
}

.chart.wide
{
	width : 640px;
	height : 320px;
}

.chart.square
{
	width : 320px;
	height : 320px;
}

.chart.big
{
	width : 780px;
	height : 500px;
}

.chart.very-tall
{
	width : 410px;
	height : 750px;
}
</style>
</head>
<?php
$i = 0;
foreach($list as $info)
{

if(@$info['style'])
{
	echo "<style>\n";
	echo $info['style']."\n";
	echo "</style>\n";
}
?>
<body>
<?php
if(@$info['html'])
{
echo $info['html'];
} else {
?>
<div id="chart<?php echo $i; ?>" class="chart <?php echo @$info['class']; ?>"></div>
<?php
}
?>
<script>
<?php
	echo $info['data'];
	echo "\n\n";
	echo str_replace('#chart', '#chart'.$i, $info['viz']);
	echo "\n";
?>
</script>
<?php
$i++;
}
?>
</body>
</html>