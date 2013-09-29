<html>
<head>
<title>ReportGrid Renderer</title>
<script src="http://api.reportgrid.com/js/reportgrid-core.js?tokenId=<?php echo $config->tokenId?>" type="text/javascript"></script>
<script src="http://api.reportgrid.com/js/reportgrid-viz.js" type="text/javascript"></script>
<?php
for($i=0;$i<count($css = $config->css());$i++)
{
    echo "<link href=\"{$css[$i]}\" rel=\"stylesheet\" type=\"text/css\" />\n";
}
?>
</head>
<body<?php echo ($config->backgroundColor() ? (' bgcolor="'.$config->backgroundColor().'" style="background-color:' . $config->backgroundColor() .'"') : ''); ?>>
<<?php echo $config->element()?><?php echo ($config->id()?' id="'.$config->id().'"':''); ?><?php echo ($config->className()?' class="'.$config->className().'"':''); ?>></<?php echo $config->element(); ?>>
<script type="text/javascript"><![CDATA[

var params = <?php echo $config->params(); ?>;
params.options = params.options || {};
params.options.ready = function() { RG_READY = true; };
params.options.track = { enabled : false };
params.options.animation = { animated : false };
params.options.visualization = params.options.visualization || "linechart";

ReportGrid.viz("<?php echo $config->id()?'#'.$config->id():'.'.str_replace(' ', '.', $config->className())?>", params);

window.setTimeout(function() {
    RG_READY = true;
}, 15000);
]]></script>
</body>
</html>