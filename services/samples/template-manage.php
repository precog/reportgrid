<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage</title>
</head>
<body>
<div>
	<form method="POST">
	<ul>
<?php
	foreach($list as $item)
	{
		echo "\t".'<li><input type="checkbox" name="selected[]" value="'.$item['sample'].'">'.$item['sample']."</li>\n";
	}
?>
	</ul>
	<button name="action" value="delete">delete selected</button>
	<button name="action" value="deleteall">delete all</button>
	</form>
</div>
</body>
</html>