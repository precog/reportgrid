//** LOAD
english-speakers

//** VIZ
ReportGrid.pieChart("#chart", {
	axes : ["count"],
	datapoints : data(),
	options : {
		label : {
			datapointover : function(dp) {
				return dp.country + ": " + ReportGrid.format(dp.count);
			},
			datapoint : function(dp) { return dp.country; }
		}
	}
});