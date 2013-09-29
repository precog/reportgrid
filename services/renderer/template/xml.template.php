<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ReportGrid Renderer</title>
<?php
for($i=0;$i<count($css = $config->css());$i++)
{
    echo "<link href=\"{$css[$i]}\" rel=\"stylesheet\" type=\"text/css\" />\n";
}
?>
</head>
<body<?php echo ($config->backgroundColor() ? (' bgcolor="'.$config->backgroundColor().'" style="background-color:' . $config->backgroundColor() .'"') : ''); ?>>
<<?php echo $config->element(); ?><?php echo $config->id()?' id="'.$config->id().'"':''; ?> class="rg<?php echo $config->className()?' '.$config->className():''; ?>"<?php echo ($config->backgroundColor() ? (' style="background-color:' . $config->backgroundColor() .'"') : ''); ?>><?php echo $config->xml(); ?></<?php echo $config->element(); ?>>
<script type="text/javascript"><![CDATA[
setTimeout(function() { RG_READY = true; }, 200);
]]></script>
</body>
</html>