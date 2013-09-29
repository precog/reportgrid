<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="chrome=IE8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $info['title'] ?></title>
<?php
    if(strpos(@$info['viz'].@$info['code'].@$info['query'], 'quirrel') === false)
    {
?>
<script src="<?php echo $CORE_API; ?>" type="text/javascript"></script>
<?php
    }
?>
<?php if(isset($info['viz'])) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $CSS_API; ?>"/>
<script src="<?php echo $VIZ_API; ?>" type="text/javascript"></script>
<style>
#chart {
    width: 600px;
    height: 400px;
}
</style>
<?php } ?>
<script src="<?php echo $QUERY_API; ?>" type="text/javascript"></script>
<?php
    if(strpos(@$info['viz'].@$info['code'].@$info['query'], 'quirrel') !== false)
    {
?>
<script src="<?php echo $PRECOG_API; ?>" type="text/javascript"></script>
<?php
    }
?>
<?php
if(@$info['style'])
{
    echo "<style>\n";
    echo $info['style']."\n";
    echo "</style>\n";
}
?>
</head>
<style>
#out {
    font-family: monospace;
    white-space: pre;
}
</style>
<?php
    if($DISABLE_CACHE && (isset($info['query']) || strpos(@$info['viz'].@$info['code'], 'ReportGrid.query') !== false))
    {
?>
<script>
    ReportGrid.cache.disable();
</script>
<?php
    }
?>
<body>
<?php
if(@$info['html'])
{
echo $info['html'];
} else {
?>
<?php if(isset($info['viz'])) { ?>
<div id="chart"></div>
<?php } ?>
<div id="out"></div>
<div id="haxe:trace"></div>
<?php
}
?>
<script>

<?php
if(isset($info['data']) && !isset($info['query']))
{
    $paths = split("\n",isset($info['path']) ? $info['path'] : $DEFAULT_PATH);
?>
var paths  = ['<?php echo implode("', '", $paths); ?>'];
//    events = 
<?php if(isset($info['load'])) echo $info['load']; ?>

var events = <?php echo $info['data']; ?>;
if(!(events instanceof Array))
    events = [events];
var out = document.getElementById('out');
out.innerHTML = "TRACKS:\n";
for(var i = 0; i < paths.length; i++)
{
    var path = paths[i];
    for(var j = 0; j < events.length; j++)
    {
        var event = events[j];
        ReportGrid.track(path, event,
        (function(p, e) {
            return function() {
                out.innerHTML += p + ": " + JSON.stringify(e) + "\n";
            };
        })(path, event));
    }
}
<?php
}

function detab($s)
{
    return str_replace("\t", "    ", $s);
}

function query($s, $useexecute) {
    if(!$s)
        return "";
?>
var callback = function(dps) {
    document.getElementById('out').innerHTML += 'QUERY RESULT:\n[\n  '
        + dps.map(function(o){ return JSON.stringify(o); }).join(',\n  ')+'\n]\n\n';
};

<?php
    if(!$useexecute)
        return $s.".audit(callback)";
    else
        return $s.".execute(callback)";
}

function indent($s) {
    return join("\n\t", split("\n", $s));
}

if(isset($info['viz']))
{
    echo detab(str_replace('loader', indent(query(@$info['query'], false)), $info['viz']));
} else if(isset($info['query'])) {
    echo detab(query(@$info['query'], true));
}

if(isset($info['code']))
{
    echo "\n\n".detab($info['code']);
}

if(isset($info['data']) && isset($info['query']))
{
?>


function data()
{
    return <?php echo detab(indent($info['data'])); ?>;
}
<?php
}
if(isset($info['load']) && isset($info['query']))
{
?>


function data()
{
    return <?php echo detab(indent($info['load'])); ?>;
}
<?php
}
?>

</script>
</body>
</html>