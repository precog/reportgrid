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
<div style='z-index:2147483647;right:150px;top:0;background-color:#faa;width:200px;height:50px;position:absolute' id='cover'></div>