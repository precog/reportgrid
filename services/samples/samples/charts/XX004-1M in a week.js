//** VIZ
var path  = "/demo/yunno",
	event = "demo";

ReportGrid.lineChart("#chart", {
	axes : ["time:hour", "count"],
	load : ReportGrid.query.series({
		path        : path,
		event       : event,
		start       : "2012-02-22",
		end         : "2012-02-28 23:59:59",
		periodicity : "hour"
	}),
	options : {
		effect : "dropshadow"
	}
});


//** HTML
<div id="chart" class="chart"></div>

//** STYLE
.chart
{
	width:  600px;
	height: 240px;
	display: block;
	float:  left;
}