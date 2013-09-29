<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="chrome=IE8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $info['title'] ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $CSS_API; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo $SAMPLE_CSS; ?>"/>
<?php if(isset($QUERY_API)) { ?>
<script src="<?php echo $CORE_API; ?>"></script>
<script src="<?php echo $QUERY_API; ?>"></script>
<?php } ?>
<script src="<?php echo $VIZ_API; ?>"></script>
<?php
if(@$info['style'])
{
	echo "<style>\n";
	echo $info['style']."\n";
	echo "</style>\n";
}
?>
</head>
<body>
<?php
if(@$info['html'])
{
echo $info['html'];
} else {
?>
<div id="chart" class="chart<?php echo (@$info['class']?' '.$info['class']:'')?>"></div>
<?php
}
?>
<script>
<?php
	echo $info['viz'];
	echo "\n\n";
	echo @$info['data'];
	echo "\n";
?>
</script>
<!--
<!--[if lt IE 9]>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
<script>
CFInstall.check({
	mode: "overlay",
	oninstall : function() { parent.location.reload(); }
});
</script>
<![endif]-->
</body>
</html>