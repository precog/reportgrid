//** LOAD
top10-emoticons-twitter

//** VIZ
var data = data(),
	options = {
	label : {
		datapointover : function(dp) { return ReportGrid.format(dp.count) + " " + dp.emoticon; },
		datapoint : function(dp) { return dp.emoticon; }
	},
	labelorientation : "fixed:90",
	innerradius : 0.5,
	labelradius : 0.7
};
ReportGrid.pieChart("#chart1", {
	axes : ["count"],
	datapoints : data,
	options : options
});

ReportGrid.pieChart("#chart2", {
	axes : ["count"],
	datapoints : data,
	options : options
});

ReportGrid.pieChart("#chart3", {
	axes : ["count"],
	datapoints : data,
	options : options
});

ReportGrid.pieChart("#chart4", {
	axes : ["count"],
	datapoints : data,
	options : options
});

//** HTML
<div id="chart1"></div>
<div id="chart2"></div>
<div id="chart3"></div>
<div id="chart4"></div>