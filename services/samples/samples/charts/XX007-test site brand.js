//** LOAD
top10-emoticons-twitter

//** VIZ
ReportGrid.pieChart("#chart", {
	axes : ["count"],
	datapoints : data(),
	options : {
		label : {
			datapointover : function(dp) { return ReportGrid.format(dp.count) + " " + dp.emoticon; },
			datapoint : function(dp) { return dp.emoticon; }
		},
		labelorientation : "fixed:90",
		innerradius : 0.5,
		labelradius : 0.7
	}
});

//** HTML
<div id="chart"></div>
<div>
	<img src="http://api.reportgrid.com/css/images/reportgrid-clear.png"/>
</div>