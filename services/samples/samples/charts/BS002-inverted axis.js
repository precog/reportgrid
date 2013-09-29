//** LOAD
usa-agestructure

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ["age","count"],
	datapoints : data(),
	options : {
		segmenton : "gender",
		label : {
			datapointover : function(dp) {
				return ReportGrid.format(dp.count)+" "+dp.gender+"s";
			}
		}
	}
});
