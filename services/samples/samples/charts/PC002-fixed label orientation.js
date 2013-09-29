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
		labelorientation : "fixed:90"
	}
});