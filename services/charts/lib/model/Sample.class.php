<?php

class model_Sample {
	public function __construct(){}
	static $config = "cache=2 days\x0A[params]\x0Aviz[0]=pieChart\x0Aviz[1]=barChart\x0A[defaults]\x0Aviz=pieChart";
	static $html;
	function __toString() { return 'model.Sample'; }
}
model_Sample::$html = "<?DOCTYPE html>\x0A<html>\x0A<head>\x0A<title>Viz</title>\x0A<script src=\"" . ("http://" . $_SERVER["HTTP_HOST"] . "/js/") . "reportgrid-charts.js\"></script>\x0A<link type=\"text/css\" href=\"" . ("http://" . $_SERVER["HTTP_HOST"] . "/css/") . "rg-charts.css\" rel=\"stylesheet\">\x0A<script type=\"text/javascript\">\x0Afunction render()\x0A{\x0A  ReportGrid.\$viz(\"#chart\", {\x0A    data : [{browser:\"chrome\",count:100},{browser:\"firefox\",count:80}],\x0A    axes : [\"browser\",\"count\"]\x0A  });\x0A}\x0A</script>\x0A</head>\x0A<body onload=\"render()\">\x0A<div id=\"chart\"></div>\x0A</body>\x0A</html>";
